<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Task_WoocommerceUrls extends AutoUpdater_Task_Base
{
    protected $high_priority = false;
    protected $home_url = '';

    public function doTask()
    {
        if (!is_plugin_active('woocommerce/woocommerce.php')) {
            return array(
                'success' => true,
                'message' => 'WooCommerce plugin is not active, skipping acquiring urls'
            );
        }

        if (
            file_exists(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php')
            && file_exists(WP_PLUGIN_DIR . '/woocommerce/includes/wc-core-functions.php')
            && file_exists(WP_PLUGIN_DIR . '/woocommerce/includes/wc-page-functions.php')
        ) {
            include_once WP_PLUGIN_DIR . '/woocommerce/woocommerce.php';
            include_once WP_PLUGIN_DIR . '/woocommerce/includes/wc-core-functions.php';
            include_once WP_PLUGIN_DIR . '/woocommerce/includes/wc-page-functions.php';
        }

        if (!defined('WC_PLUGIN_FILE')) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' => 'WooCommerce plugin not loaded'
            );
        }

        if (
            !function_exists('wc_get_cart_url')
            || !function_exists('wc_get_checkout_url')
            || !function_exists('wc_get_page_id')
            || !function_exists('wc_get_products')
        ) {
            return array(
                'success' => true,
                'needs_refactor' => true,
                'message' => 'WooCommerce URL functions not found, check for source code updates',
            );
        }

        return array(
            'success' => true,
            'urls' => $this->getUrls()
        );
    }

    /**
     * @return array
     */
    protected function getUrls()
    {
        $this->home_url = get_home_url();

        $urls = $this->getBaseUrls();

        $limit = (int) $this->input('limit', 20);
        if ($limit <= count($urls)) {
            return array_slice($urls, 0, $limit);
        }

        $categories_limit = (int) round(($limit - count($urls)) * 0.2);
        if ($categories_limit > 0) {
            $urls = array_merge($urls, $this->getCategoriesUrls($categories_limit));
        }

        $products_limit = $limit - count($urls);
        $urls = array_merge($urls, $this->getProductsUrls($products_limit));

        return $urls;
    }

    /**
     * @return array
     */
    protected function getBaseUrls()
    {
        $urls = array($this->home_url);

        if (($cart_url = wc_get_cart_url()) && $cart_url !== $this->home_url) {
            $urls[] = $this->escapeUrl($cart_url);
        }

        if (($checkout_url = wc_get_checkout_url()) && $checkout_url !== $this->home_url) {
            $urls[] = $this->escapeUrl($checkout_url);
        }

        $my_account_page_id = wc_get_page_id('myaccount');
        if ($my_account_page_id !== -1) {
            $my_account_url = get_page_link($my_account_page_id);
            // It is not a link to a page without a numeric ID or it is not the home page
            if (!preg_match('/(\?|&)page_id=(&.+)?$/', $my_account_url) && $my_account_url !== $this->home_url) {
                $urls[] = $this->escapeUrl($my_account_url);
            }
        }

        return $urls;
    }

    /**
     * @param int $limit
     * @return array
     */
    protected function getProductsUrls($limit)
    {
        $urls = array();

        $products = wc_get_products(array(
            'status' => 'publish',
            'visibility' => 'visible',
            'limit' => $limit * 10,
            'paginate' => false
        ));

        $products_count = count($products);
        if ($products_count === 0) {
            return $urls;
        }

        // Trying to pick more elements than there are in the array by array_rand, will result in an E_WARNING level error, and NULL will be returned
        if ($products_count < $limit) {
            $keys = array_keys($products);
        } elseif ($limit === 1) {
            // Returns one key
            $keys = array(array_rand($products, 1));
        } else {
            // Returns array of keys
            $keys = array_rand($products, $limit);
        }

        // Add products URLs
        foreach ($keys as $key) {
            /** @var WC_Product $product */
            $product = $products[$key];
            $product_url = $this->validateUrl($product->get_permalink());
            if (is_wp_error($product_url)) {
                AutoUpdater_Log::error(sprintf('Failed to get permalink for product ID %d with the error: %s', $product->get_id(), $product_url->get_error_message()));
                continue;
            }
            $urls[] = $this->escapeUrl($product_url);
        }

        return $urls;
    }

    /**
     * @param int $limit
     * @return array
     */
    protected function getCategoriesUrls($limit)
    {
        $urls = array();

        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'fields' => 'ids',
            'number' => $limit * 10,
            'nopaging' => true
        ));

        $categories_count = count($categories);
        if ($categories_count === 0) {
            return $urls;
        }

        // Trying to pick more elements than there are in the array by array_rand, will result in an E_WARNING level error, and NULL will be returned
        if ($categories_count < $limit) {
            $keys = array_keys($categories);
        } elseif ($limit === 1) {
            // Returns one key
            $keys = array(array_rand($categories, 1));
        } else {
            // Returns array of keys
            $keys = array_rand($categories, $limit);
        }

        // Add categories URLs
        foreach ($keys as $key) {
            $category_id = $categories[$key];
            $category_url = $this->validateUrl(get_term_link($category_id, 'product_cat'));
            if (is_wp_error($category_url)) {
                AutoUpdater_Log::error(sprintf('Failed to get permalink for category ID %d with the error: %s', $category_id, $category_url->get_error_message()));
                continue;
            }
            $urls[] = $this->escapeUrl($category_url);
        }

        return $urls;
    }

    /**
     * @param string $url
     * @return string|WP_Error
     */
    protected function validateUrl($url)
    {
        if (is_wp_error($url)) {
            return $url;
        }

        // Relative URL
        if (substr($url, 0, 1) === '/') {
            return $this->home_url . $url;
        }

        // Not absolute URL
        if (substr($url, 0, 4) !== 'http') {
            return new WP_Error('invalid_url', sprintf('Invalid URL: %s', $url));
        }

        esc_url_raw($url);
        return $url;
    }

    /**
     * @param string $url
     * @return string
     */
    protected function escapeUrl($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $encoded_path = array_map('urlencode', array_map('urldecode', explode('/', $path)));
        $url = str_replace($path, implode('/', $encoded_path), $url);
        return $url;
    }
}
