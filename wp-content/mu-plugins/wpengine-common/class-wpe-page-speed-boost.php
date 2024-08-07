<?php
/**
 * WP Engine Page Speed Boost.
 *
 * @package wpengine/common-mu-plugin
 * @owner wpengine/golden
 */

namespace wpe\plugin;

use WP_CLI;

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Page Speed Boost class adds WP Engine specific content and navigation to NitroPack plugin.
 */
class Wpe_Page_Speed_Boost {

	/**
	 * Pair of public and private keys
	 *
	 * @var null|object
	 */
	protected $keys;

	/**
	 * Initialize.
	 */
	public function init() {
		// Is the dependent plugin installed? Doesn't have to be active.
		if ( ! file_exists( WP_PLUGIN_DIR . '/nitropack' ) ) {
			return;
		}

		add_action( 'init', array( $this, 'register_hooks' ) );
	}

	/**
	 * Registers hooks.
	 */
	public function register_hooks() {
		global $pagenow;

		// Is it the right scope?
		$is_wp_cli = defined( 'WP_CLI' ) && WP_CLI && class_exists( 'WP_CLI' );
		if ( ! is_admin() && ! $is_wp_cli && ! is_user_logged_in() ) {
			return;
		}

		// These filters are triggered only when the dependent plugin is in OneClick mode.
		add_filter( 'nitropack_oneclick_connect_url', array( $this, 'get_connect_url' ), 10, 1 );
		add_filter( 'nitropack_oneclick_vendor_widget', array( $this, 'get_vendor_widget' ), 10, 1 );
		add_filter( 'nitropack_oneclick_action_links', array( $this, 'get_action_links' ), 10, 1 );
		add_filter( 'nitropack_oneclick_safemode_message', array( $this, 'get_safe_mode_warning' ), 10, 1 );

		// Make sure to run these filters  when the dependent plugin is in OneClick mode.
		if ( $this->is_one_click() ) {
			add_action( 'admin_init', array( $this, 'admin_menu' ) );
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), PHP_INT_MAX - 9 );
			add_filter( 'all_plugins', array( $this, 'set_plugin_details' ), 10, 1 );
			add_filter( 'plugin_row_meta', array( $this, 'add_plugin_metadata' ), 10, 4 );
			add_filter( 'plugin_action_links', array( $this, 'plugin_action_links' ), 10, 4 );
			add_filter( 'network_admin_plugin_action_links', array( $this, 'plugin_action_links' ), 10, 4 );
			// Only necessary on the updates page.
			if ( 'update-core.php' === $pagenow || 'options-general.php' === $pagenow ) {
				add_filter( 'gettext', array( $this, 'set_plugin_name' ), 10, 3 );
			}

			if ( $is_wp_cli ) {
				WP_CLI::add_command( 'psb mode', array( $this, 'command_psb_mode' ) );
				WP_CLI::add_command( 'psb preview', array( $this, 'command_psb_preview' ) );
				WP_CLI::add_command( 'psb warmup', array( $this, 'command_psb_warmup' ) );
				WP_CLI::add_command( 'psb urls', array( $this, 'command_psb_urls' ) );
				WP_CLI::add_command( 'psb excludedurls', array( $this, 'command_psb_excluded_urls' ) );
				WP_CLI::add_command( 'psb excludes', array( $this, 'command_psb_excludes' ) );
			}
		}

		if ( $is_wp_cli ) {
			WP_CLI::add_command( 'psb connect', array( $this, 'command_psb_connect' ) );
		}
	}

	/**
	 * Gets the product landing page URL.
	 *
	 * @return string Returns the product landing page URL.
	 */
	protected function get_product_landing_page_url() {
		return 'https://wpengine.com/page-speed-boost';
	}

	/**
	 * Gets the product page URL.
	 *
	 * @return string Returns the product page URL.
	 */
	protected function get_product_page_url() {
		return 'https://my.wpengine.com/products/page_speed_boost';
	}

	/**
	 * Gets the URL to complete product enablement.
	 *
	 * @param string $url The URL to filter.
	 *
	 * @return string Returns the URL.
	 */
	public function get_connect_url( $url = '' ) {
		return $this->get_product_page_url() . ( defined( 'PWP_NAME' ) ? '/enable?selected=' . PWP_NAME : '/add' );
	}

	/**
	 * Gets WP Engine specific content for NitroPack settings page.
	 *
	 * @param string $html HTML to filter.
	 *
	 * @return string Returns HTML.
	 */
	public function get_vendor_widget( $html = '' ) {
		return '<h5 class="card-title">'
			. __( 'What is NitroPack OneClick?', 'wpengine' )
			. '</h5>'
			. '<div class="row mt-4 mx-0" style="line-height:24px">'
			. __( 'NitroPack OneClick is provided as part of your Page Speed Boost add-on and is preconfigured with essential features for immediate use. Activate it effortlessly and enjoy an instant boost in page speed.', 'wpengine' )
			. '</div>'
			. '<div class="row mt-4 mx-0">'
			. '<a href="' . $this->get_product_landing_page_url() . '" target="_blank">' . __( 'Learn more' ) . '</a>'
			. '</div>'
			. '<div class="row mt-4 mx-0">'
			. '<a href="' . $this->get_product_page_url() . '" target="_blank" class="btn btn-light btn-outline-primary">' . __( 'Manage' ) . '</a>'
			. '</div>';
	}

	/**
	 * Gets the message to complete product enablement.
	 *
	 * @param string $html HTML message to filter.
	 *
	 * @return string Returns HTML message.
	 */
	public function get_safe_mode_warning( $html = '' ) {
		return '<strong>Important:</strong> Product enablement is not finished. Currently, your website does not serve optimizations to regular users. Complete product enablement in the '
			. '<a href="' . $this->get_connect_url() . '" target="_blank">User Portal</a>.';
	}

	/**
	 * Gets action links displayed on the plugins list.
	 *
	 * @param array $links An array of HTML links.
	 *
	 * @return array Returns the array of HTML links.
	 */
	public function get_action_links( $links = array() ) {
		return array(
			'<a href="https://wpengine.com/support/page-speed-boost" target="_blank" rel="noopener noreferrer">' . __( 'Support Center', 'wpengine' ) . '</a>',
		);
	}

	/**
	 * Filters the action links displayed for each plugin in the Plugins list table.
	 *
	 * @param array  $actions     An array of plugin action links.
	 * @param string $plugin_file Path to the plugin file relative to the plugins directory.
	 * @param array  $plugin_data An array of plugin data.
	 * @param string $context     The plugin context. By default this can include 'all', 'active', 'inactive', 'recently_activated', 'upgrade', 'mustuse', 'dropins', and 'search'.
	 *
	 * @return array Returns an array of plugin action links.
	 */
	public function plugin_action_links( $actions, $plugin_file, $plugin_data, $context = 'all' ) {
		if ( strpos( $plugin_file, 'nitropack/' ) !== 0 ) {
			return $actions;
		};

		if ( isset( $actions['edit'] ) ) {
			unset( $actions['edit'] );
		}

		if ( isset( $actions['delete'] ) ) {
			unset( $actions['delete'] );
		}

		return $actions;
	}

	/**
	 * Sets the product name and description on the plugins list.
	 * Filters the full array of plugins to list in the Plugins list table.
	 *
	 * @param array $all_plugins An array of plugins to display in the list table.
	 *
	 * @return array Returns an array of plugins to display in the list table.
	 */
	public function set_plugin_details( $all_plugins ) {
		$slug    = '';
		$plugins = array_keys( $all_plugins );
		foreach ( $plugins as $plugin_file ) {
			if ( strpos( $plugin_file, 'nitropack/' ) === 0 ) {
				$slug = $plugin_file;
				break;
			}
		}

		if ( $slug && is_array( $all_plugins[ $slug ] ) ) {
			$all_plugins[ $slug ]['Name']        = 'Page Speed Boost';
			$all_plugins[ $slug ]['Title']       = $all_plugins[ $slug ]['Name'];
			$all_plugins[ $slug ]['Description'] = __( '35+ enhancements for site speed and Core Web Vitals powered by NitroPack OneClick. Includes caching, image optimization, critical CSS, and code minification.', 'wpengine' );
		}

		return $all_plugins;
	}

	/**
	 * Gets the product name.
	 * Filters text with its translation.
	 *
	 * @param string $translation Translated text.
	 * @param string $text        Text to translate.
	 * @param string $domain      Text domain. Unique identifier for retrieving translated strings.
	 *
	 * @return string Returns Translated text.
	 */
	public function set_plugin_name( $translation, $text, $domain = '' ) {
		if ( 'nitropack' === $domain ) {
			if ( 'NitroPack' === $text ) {
				return 'Page Speed Boost';
			}
			if ( 'NitroPack OneClick™' === $text ) {
				return 'Page Speed Boost';
			}
			if ( 'Welcome to NitroPack OneClick for WordPress!' === $text ) {
				return 'Welcome to Page Speed Boost by WP Engine!';
			}
			if ( 'Your license is managed by your hosting provider.' === $text ) {
				return 'Powered by NitroPack OneClick.';
			}
			if ( 'In order to connect NitroPack OneClick with WordPress you need to visit your hosting provider page' === $text ) {
				return 'In order to connect Page Speed Boost with WordPress, you need to visit the Page Speed Boost add-on page in the WP Engine Portal.';
			}
		}

		return $translation;
	}

	/**
	 * Adds the link to the product landing page.
	 * Filters the array of row meta for each plugin in the Plugins list table.
	 *
	 * @param array  $plugin_meta An array of the plugin's metadata, including the version, author, author URI, and plugin URI.
	 * @param string $plugin_file Path to the plugin file relative to the plugins directory.
	 * @param array  $plugin_data An array of plugin data.
	 * @param string $status      Status filter currently applied to the plugin list. Possible values are: 'all', 'active', 'inactive', 'recently_activated', 'upgrade', 'mustuse', 'dropins', 'search', 'paused', 'auto-update-enabled', 'auto-update-disabled'.
	 *
	 * @return array Returns an array of the plugin's metadata.
	 */
	public function add_plugin_metadata( $plugin_meta, $plugin_file, $plugin_data, $status = 'all' ) {
		if ( strpos( $plugin_file, 'nitropack/' ) === 0 ) {
			array_splice( $plugin_meta, 2, 0, '<a href="' . $this->get_product_landing_page_url() . '" target="_blank">WP Engine</a>' );
		}

		return $plugin_meta;
	}

	/**
	 * Sets the product name in the Settings menu.
	 */
	public function admin_menu() {
		global $submenu;
		if ( ! isset( $submenu['options-general.php'] ) ) {
			return;
		}
		foreach ( $submenu['options-general.php'] as $key => $menu ) {
			if ( 'nitropack' === $menu[2] ) {
				$submenu['options-general.php'][ $key ][0] = 'Page Speed Boost'; // phpcs:ignore
				return;
			}
		}
	}

	/**
	 * Sets the product name in the top bar.
	 *
	 * @param \WP_Admin_Bar $wp_admin_bar Admin bar object.
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
		$node = $wp_admin_bar->get_node( 'nitropack-top-menu' );
		if ( $node ) {
			$node->title = str_replace( 'NitroPack', 'Page Speed Boost', $node->title );
			$wp_admin_bar->remove_node( $node->id );
			$wp_admin_bar->add_node( (array) $node );
		}
	}

	/**
	 * Checks if the plugin distribution is OneClick.
	 *
	 * @return bool
	 */
	protected function is_one_click() {
		if ( function_exists( 'get_nitropack' ) ) {
			if ( method_exists( get_nitropack(), 'getDistribution' ) ) {
				return 'oneclick' === get_nitropack()->getDistribution();
			}
		}

		return 'oneclick' === get_option( 'nitropack-distribution' );
	}

	/**
	 * Get vendor API.
	 *
	 * @return \NitroPack\SDK\Api API.
	 */
	protected function get_vendor_api() {
		return get_nitropack()->getSdk()->getApi();
	}

	/**
	 * Get site configuration.
	 *
	 * @return null|array Returns site configuration on success or exits with an error.
	 */
	protected function get_site_config() {
		if ( ! function_exists( 'get_nitropack' ) ) {
			WP_CLI::error( 'The dependent plugin is missing or is inactive!' );
			return;
		}

		$site_config = get_nitropack()->getSiteConfig();
		if ( empty( $site_config['siteId'] ) || empty( $site_config['siteSecret'] ) ) {
			WP_CLI::error( 'The Site ID or Site Secret is missing!' );
			return;
		}

		return $site_config;
	}

	/**
	 * Generate and get public and private keys.
	 *
	 * @return object
	 */
	protected function keys_instance() {
		// This must be executed only once per request.
		if ( empty( $this->keys ) ) {
			$this->keys = \NitroPack\SDK\Crypto::generateKeyPair();
		}

		return $this->keys;
	}

	/**
	 * Get vendor plugin file relative to plugins directory.
	 *
	 * @return string
	 */
	protected function get_vendor_plugin_file() {
		$plugins = get_plugins();
		foreach ( $plugins as $plugin_file => $plugin ) {
			if ( strpos( $plugin_file, 'nitropack/' ) === 0 ) {
				return $plugin_file;
			}
		}

		return '';
	}

	/**
	 * PSB connect. Do not run it manually.
	 *
	 * ## OPTIONS
	 *
	 * <site_ID>
	 * : The site ID.
	 *
	 * <site_secret>
	 * : The site secret.
	 *
	 * @when before_wp_load
	 * @param array $psb_command_args       Command arguments.
	 * @param array $psb_command_assoc_args Command parameters.
	 */
	public function command_psb_connect( $psb_command_args, $psb_command_assoc_args ) {
		if ( ! function_exists( 'nitropack_verify_connect' ) ) {
			$psb_vendor_plugin_file = $this->get_vendor_plugin_file();
			include_once WP_PLUGIN_DIR . '/' . $psb_vendor_plugin_file;
			if ( ! function_exists( 'nitropack_verify_connect' ) ) {
				WP_CLI::error( 'The dependent plugin in incompatible!' );
				return;
			}
		}

		nitropack_verify_connect(
			empty( $psb_command_args[0] ) ? '' : $psb_command_args[0],
			empty( $psb_command_args[1] ) ? '' : $psb_command_args[1],
			true
		);
	}

	/**
	 * PSB mode.
	 *
	 * ## OPTIONS
	 *
	 * [<mode>]
	 * : Read or change mode.
	 * ---
	 * default: 0
	 * options:
	 *   - 0
	 *   - 1
	 *   - 2
	 *   - 3
	 *   - 4
	 * ---
	 *
	 * @when before_wp_load
	 *
	 * @param array $args       Command arguments.
	 * @param array $assoc_args Command parameters.
	 */
	public function command_psb_mode( $args, $assoc_args ) {
		$mode = isset( $args[0] ) ? intval( $args[0] ) : 0;
		if ( 0 > $mode || 4 < $mode ) {
			WP_CLI::error( 'The input mode is invalid!' );
			return;
		}
		$change      = 0 !== $mode;
		$site_config = $this->get_site_config();
		$keys        = $this->keys_instance();
		$url         = new \NitroPack\SDK\IntegrationUrl( $change ? 'quicksetup' : 'quicksetup_json', $site_config['siteId'], $site_config['siteSecret'] );
		$headers     = array(
			'X-Nitro-Public-Key' => call_user_func( 'base' . 64 . '_encode', $keys->publicKey ), // phpcs:ignore
		);

		if ( $change ) {
			$response = wp_remote_post(
				$url->getUrl(),
				array(
					'headers' => $headers,
					'body'    => array(
						'setting' => $mode,
					),
				)
			);
		} else {
			$response = wp_remote_get( $url->getUrl(), array( 'headers' => $headers ) );
		}

		if ( is_wp_error( $response ) ) {
			/**
			 * Response error.
			 *
			 * @var WP_Error $error
			 */
			$error = $response;
			WP_CLI::error( $error->get_error_message() );
			return;
		}

		if ( 200 !== $response['response']['code'] ) {
			WP_CLI::debug( sprintf( 'Response body: %s.', $response['body'] ) );
			WP_CLI::error( sprintf( 'Request has failed with %d %s.', $response['response']['code'], $response['response']['message'] ) );
			return;
		}

		if ( $change ) {
			WP_CLI::success( 'Mode has been changed.' );
			return;
		}

		$body = @json_decode( $response['body'], true ); // phpcs:ignore
		if ( empty( $body['optimization_level'] ) ) {
			WP_CLI::error( 'Mode is missing in the response body!' );
			return;
		}
		WP_CLI::success( sprintf( 'Mode: %d.', $body['optimization_level'] ) );
	}

	/**
	 * PSB preview mode.
	 *
	 * ## OPTIONS
	 *
	 * [<command>]
	 * : Get preview status or change it.
	 * ---
	 * default: status
	 * options:
	 *   - status
	 *   - disable
	 *   - enable
	 * ---
	 *
	 * @when before_wp_load
	 *
	 * @param array $args       Command arguments.
	 * @param array $assoc_args Command parameters.
	 */
	public function command_psb_preview( $args, $assoc_args ) {
		$this->get_site_config();

		/**
		 * SDK.
		 *
		 * @var \NitroPack\SDK\NitroPack $sdk
		 */
		$sdk = get_nitropack()->getSdk();
		try {
			$command = empty( $args[0] ) ? 'status' : $args[0];
			if ( 'enable' === $command ) {
				$sdk->enableSafeMode();
			} elseif ( 'disable' === $command ) {
				$sdk->disableSafeMode();
			} else {
				$api    = $this->get_vendor_api();
				$status = $api->isSafeModeEnabled();
				WP_CLI::success( sprintf( 'Preview mode is %s.', $status ? 'enabled' : 'disabled' ) );
				return;
			}
		} catch ( \Exception $e ) {
			WP_CLI::error( $e->getMessage(), false );
			WP_CLI::error( sprintf( 'Failed to %s preview mode.', $command ) );
			return;
		}

		WP_CLI::success( sprintf( 'Preview mode has been %sd.', $command ) );
	}

	/**
	 * PSB cache warmup.
	 *
	 * ## OPTIONS
	 *
	 * [<command>]
	 * : Get cache warmup status or change it.
	 * ---
	 * default: status
	 * options:
	 *   - status
	 *   - disable
	 *   - enable
	 * ---
	 *
	 * @when before_wp_load
	 *
	 * @param array $args       Command arguments.
	 * @param array $assoc_args Command parameters.
	 */
	public function command_psb_warmup( $args, $assoc_args ) {
		$this->get_site_config();

		$command = empty( $args[0] ) ? 'status' : $args[0];
		if ( 'enable' === $command ) {
			nitropack_enable_warmup();
			return;
		} elseif ( 'disable' === $command ) {
			nitropack_disable_warmup();
			return;
		}

		try {
			$api   = $this->get_vendor_api();
			$stats = $api->getWarmupStats();
			if ( isset( $stats['status'] ) ) {
				$stats['status'] = $stats['status'] ? 'enabled' : 'disabled';
			}
			WP_CLI\Utils\format_items(
				'yaml',
				array(
					array(
						'warmup' => $stats,
					),
				),
				array(
					'warmup',
				)
			);
		} catch ( \Exception $e ) {
			WP_CLI::error( $e->getMessage(), false );
			WP_CLI::error( 'Failed to fetch warmup stats.' );
			return;
		}
	}

	/**
	 * PSB optimized URLs.
	 *
	 * ## OPTIONS
	 *
	 * [<command>]
	 * : Get optimized URLs or pending optimization.
	 * ---
	 * default: optimized
	 * options:
	 *   - optimized
	 *   - pending
	 * ---
	 *
	 * @when before_wp_load
	 *
	 * @param array $args       Command arguments.
	 * @param array $assoc_args Command parameters.
	 */
	public function command_psb_urls( $args, $assoc_args ) {
		$this->get_site_config();

		$command = empty( $args[0] ) ? 'optimized' : $args[0];

		try {
			$api    = $this->get_vendor_api();
			$result = array();
			if ( 'optimized' === $command ) {
				$result = $api->getUrls();
			} elseif ( 'pending' === $command ) {
				$result = $api->getPendingUrls();
			}
			WP_CLI\Utils\format_items(
				'yaml',
				array(
					array(
						'urls' => $result,
					),
				),
				array(
					'urls',
				)
			);
		} catch ( \Exception $e ) {
			WP_CLI::error( $e->getMessage(), false );
			WP_CLI::error( 'Failed to fetch URLs.' );
			return;
		}
	}

	/**
	 * PSB excluded URLs.
	 *
	 * ## OPTIONS
	 *
	 * [<command>]
	 * : Control excluded URLs.
	 * ---
	 * default: get
	 * options:
	 *   - enable
	 *   - disable
	 *   - get
	 *   - add
	 *   - remove
	 * ---
	 *
	 * [<url_pattern>]
	 * : URL pattern.
	 *
	 * ## EXAMPLES
	 *
	 *     # Enable feature to exclude any URL
	 *     $ wp psb excludedurls enable
	 *
	 *     # Exclude a contact page
	 *     $ wp psb excludedurls add *\/contact
	 *
	 * @when before_wp_load
	 *
	 * @param array $args       Command arguments.
	 * @param array $assoc_args Command parameters.
	 */
	public function command_psb_excluded_urls( $args, $assoc_args ) {
		$site_config = $this->get_site_config();

		$command     = empty( $args[0] ) ? '' : $args[0];
		$url_pattern = empty( $args[1] ) ? '' : $args[1];

		if ( ( 'add' === $command || 'remove' === $command ) && ! $url_pattern ) {
			WP_CLI::error( 'Enter valid URL.' );
			return;
		}

		try {
			$api = $this->get_vendor_api();
			switch ( $command ) {
				case 'enable':
					$api->enableExcludedUrls();
					break;
				case 'disable':
					$api->disableExcludedUrls();
					break;
				case 'get':
					$fetcher  = new \NitroPack\SDK\Api\RemoteConfigFetcher( $site_config['siteId'], $site_config['siteSecret'] );
					$response = $fetcher->get();
					$config   = @json_decode( $response, true ); // phpcs:ignore
					if ( ! array_key_exists( 'DisabledURLs', $config ) ) {
						WP_CLI::error( 'Disabled URLs are not present in the respone. Vendor API might changed.' );
						return;
					}
					WP_CLI\Utils\format_items(
						'yaml',
						array(
							array(
								'excludes' => $config['DisabledURLs'],
							),
						),
						array(
							'excludes',
						)
					);
					return;
				case 'add':
					$api->addExcludedUrl( $url_pattern );
					break;
				case 'remove':
					$api->removeExcludedUrl( $url_pattern );
					break;
				default:
					WP_CLI::error( 'Enter valid sub-command.' );
					return;
			}
		} catch ( \Exception $e ) {
			WP_CLI::error( $e->getMessage(), false );
			WP_CLI::error( sprintf( 'Failed to %s excluded URL(s).', $command ) );
			return;
		}

		WP_CLI::success( sprintf( 'Succeeded to %s excluded URL(s).', $command ) );
	}

	/**
	 * PSB JS, CSS, image, font excludes.
	 *
	 * ## OPTIONS
	 *
	 * [<command>]
	 * : Control excluded asset.
	 * ---
	 * default: get
	 * options:
	 *   - enable
	 *   - disable
	 *   - get
	 *   - add
	 *   - remove
	 * ---
	 *
	 * [<url_pattern>]
	 * : URL pattern.
	 *
	 * [--resource=<type>]
	 * : Limit exclusion to a specific resource type.
	 * ---
	 * default: any
	 * options:
	 *   - any
	 *   - css
	 *   - js
	 *   - font
	 *   - image
	 * ---
	 *
	 * [--device=<type>]
	 * : Limit exclusion to a specific device.
	 * ---
	 * default: any
	 * options:
	 *   - any
	 *   - desktop
	 *   - tablet
	 *   - mobile
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     # Enable feature to exclude any resource
	 *     $ wp psb excludes enable
	 *
	 *     # Exclude a contact page
	 *     $ wp psb excludes add *\/script.js --resource=js
	 *
	 * @when before_wp_load
	 *
	 * @param array $args       Command arguments.
	 * @param array $assoc_args Command parameters.
	 */
	public function command_psb_excludes( $args, $assoc_args ) {
		$this->get_site_config();

		if ( ! class_exists( '\NitroPack\SDK\ExcludeEntry' ) ) {
			WP_CLI::error( 'The dependent plugin is incompatible.' );
			return;
		}

		$command     = empty( $args[0] ) ? '' : $args[0];
		$url_pattern = empty( $args[1] ) ? '' : $args[1];

		if ( ( 'add' === $command || 'remove' === $command ) && ! $url_pattern ) {
			WP_CLI::error( 'Enter valid URL.' );
			return;
		}

		try {
			$api = $this->get_vendor_api();
			switch ( $command ) {
				case 'enable':
					$api->enableExcludes();
					break;
				case 'disable':
					$api->disableExcludes();
					break;
				case 'get':
					$all_excludes = $api->getExcludes();
					WP_CLI\Utils\format_items(
						'yaml',
						array(
							array(
								'excludes' => $all_excludes,
							),
						),
						array(
							'excludes',
						)
					);
					return;
				case 'add':
					$all_excludes = $api->getExcludes();

					$new_exclude                 = new \NitroPack\SDK\ExcludeEntry();
					$new_exclude->string         = $url_pattern;
					$new_exclude->device         = empty( $assoc_args['device'] ) || 'any' === $assoc_args['device'] ? null : $assoc_args['device'];
					$new_exclude->resourceType   = empty( $assoc_args['resource'] ) || 'any' === $assoc_args['resource'] ? null : $assoc_args['resource']; // phpcs:ignore
					$new_exclude->operation->all = true;

					$all_excludes[] = $new_exclude;
					$api->setExcludes( $all_excludes );
					break;
				case 'remove':
					$all_excludes = $api->getExcludes();
					$all_excludes = array_filter(
						$all_excludes,
						function ( $exclusion ) use ( $url_pattern ) {
							return $exclusion->string !== $url_pattern;
						}
					);
					$api->setExcludes( $all_excludes );
					break;
				default:
					WP_CLI::error( 'Enter valid sub-command.' );
					return;
			}
		} catch ( \Exception $e ) {
			WP_CLI::error( $e->getMessage(), false );
			WP_CLI::error( sprintf( 'Failed to %s exclude(s).', $command ) );
			return;
		}

		WP_CLI::success( sprintf( 'Succeeded to %s exclude(s).', $command ) );
	}
}
