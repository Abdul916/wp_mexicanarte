<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Command_Status extends AutoUpdater_Command_Base
{
    /**
     * Gets AutoUpdater status
     *
     * ## OPTIONS
     *
     * [--date=<YYYY-MM-DD>]
     * : Get updates performed on a given date. All times are UTC. Defaults to the date of the last batch of updates.
     *
     * [--output=<format>]
     * : Output format.
     * ---
     * default: yaml
     * options:
     *   - json
     *   - yaml
     *
     * @when before_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        $date = $this->getDate($assoc_args);

        $updates = $this->getResourceList('update', $date);
        $syncs = $this->getResourceList('sync', $date);

        if (empty($updates) && empty($syncs)) {
            WP_CLI::warning('No items to display.');
        }

        // When no date provided, then display only the latest items
        if (!$date) {
            $items = array();
            if (!empty($updates)) {
                $items[] = $updates[0];
            }
            if (!empty($syncs)) {
                $items[] = $syncs[0];
            }
        } else {
            $items = array_merge($updates, $syncs);
        }

        usort($items, array($this, 'sortItems'));
        $items = $this->getResourceItemsFromList($items);

        if ($assoc_args['output'] === 'json') {
            WP_CLI::line(json_encode(
                $items,
                JSON_PRETTY_PRINT // phpcs:ignore PHPCompatibility.Constants.NewConstants
            ));
        } elseif ($assoc_args['output'] === 'yaml') {
            WP_CLI\Utils\format_items('yaml', $items, array(
                'id',
                'type',
                'state',
                'started_at',
                'finished_at',
                'finish_reason',
                'finish_message',
                'actions',
                'errors',
            ));
        }
    }

    /**
     * @param array $assoc_args
     *
     * @return DateTime|null
     */
    protected function getDate($assoc_args)
    {
        if (empty($assoc_args['date'])) {
            return null;
        }

        if (!$this->isDate($assoc_args['date'])) {
            WP_CLI::error('Invalid date format. Use YYYY-MM-DD format.');
        }

        $date = new DateTime($assoc_args['date']);
        $now = new DateTime();
        if ($date > $now) {
            WP_CLI::error('Invalid future date.');
        }

        return $date;
    }

    /**
     * @param array $list
     *
     * @return array
     */
    protected function getResourceItemsFromList($list)
    {
        $items = array();

        foreach ($list as $list_item) {
            if (!isset($list_item->id)) {
                continue;
            }
            $item = $this->getResourceItem($list_item->type, $list_item->id);
            if ($item) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * @param string $resource
     * @param int $resource_id
     *
     * @return array
     */
    protected function getResourceItem($resource, $resource_id)
    {
        $resources = $resource . 's';

        $response = AutoUpdater_Request::api('GET', "sites/{ID}/{$resources}/{$resource_id}")->send();

        if ($response->code !== 200) {
            WP_CLI::error(sprintf('Failed to get %s resource with ID %d. API responded with HTTP %d %s.', $resource, $resource_id, $response->code, $response->message), false);
            return null;
        }

        if (!isset($response->body->$resource)) {
            WP_CLI::error(sprintf('Invalid API response. Missing "%s" property for resource with ID %d.', $resource, $resource_id), false);
            return null;
        }

        $item = $response->body->$resource;
        $item->type = $resource;

        return $item;
    }

    /**
     * @param string $resource
     * @param DateTime|null $date
     *
     * @return array
     */
    protected function getResourceList($resource, $date)
    {
        $resources = $resource . 's';
        $date_format = 'Y-m-d';
        $expected_date = $date instanceof DateTime ? $date->format($date_format) : '';
        $request_data = array('page_size' => $this->getPageSize($date));
        $next_page_token = '';

        $items = array();

        do {
            if ($next_page_token) {
                // Request next page
                $request_data['page_token'] = $next_page_token;
                $next_page_token = '';
            }

            $response = AutoUpdater_Request::api('GET', "sites/{ID}/{$resources}", $request_data)->send();

            if ($response->code !== 200) {
                WP_CLI::error(sprintf('Failed to get %s resources. API responded with HTTP %d %s.', $resources, $response->code, $response->message));
                break;
            }

            if (!isset($response->body->$resources) || !is_array($response->body->$resources)) {
                WP_CLI::error(sprintf('Invalid API response. Missing "%s" property.', $resources));
                break;
            }

            if (!count($response->body->$resources)) {
                break;
            }

            // Expects items to be sorted by date descending
            foreach ($response->body->$resources as $item) {
                if (!isset($item->started_at)) {
                    WP_CLI::error(sprintf('Invalid API response. Missing "%s" property for %s resource.', 'started_at', $resource));
                    break 2;
                }

                $item->type = $resource;

                $started_at = new DateTime($item->started_at);
                if (!$expected_date || $started_at->format($date_format) === $expected_date) {
                    $items[] = $item;
                } elseif (count($items)) {
                    // Stop searching for next items if already found some items and the next one is older than expected
                    break 2;
                }
            }

            if (isset($response->body->next_page_token)) {
                $next_page_token = $response->body->next_page_token;
            }
        } while ($expected_date && $next_page_token);

        return $items;
    }

    /**
     * @param object $a
     * @param object $b
     *
     * @return int
     */
    protected function sortItems($a, $b)
    {
        if ($a->started_at == $b->started_at) {
            return 0;
        }
        return ($a->started_at < $b->started_at) ? -1 : 1;
    }

    /**
     * @param DateTime|null $date
     *
     * @return int
     */
    protected function getPageSize($date)
    {
        if (!($date instanceof DateTime)) {
            return 1;
        }

        $now = new DateTime();
        $interval = $now->diff($date);
        return intval($interval->format('%a')) + 5;
    }

    public static function beforeInvoke()
    {
        if (!AutoUpdater_Config::get('site_id')) {
            WP_CLI::error('The site ID is missing.');
        }
        if (!AutoUpdater_Config::get('worker_token')) {
            WP_CLI::error('The worker token is missing.');
        }
    }
}
