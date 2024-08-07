<?php
defined('AUTOUPDATER_LIB') or die;

class AutoUpdater_Helper_License
{
    /**
     * @param string $slug
     * @return bool
     */
    public static function hasValidLicense($slug)
    {
        $slug = strtolower($slug);
        if (strpos($slug, '/') !== false) {
            $slug = dirname($slug);
        }

        switch ($slug) {
            case 'advanced-custom-fields-pro':
                return self::hasValidAdvancedCustomFieldsProLicense();
            case 'elementor-pro':
                return self::hasValidElementorProLicense();
            case 'js_composer':
                return self::hasValidWpBakeryPageBuilderLicense();
            case 'layerslider':
                return self::hasValidLayerSliderLicense();
            case 'masterslider':
                return self::hasValidMasterSliderProLicense();
            case 'revslider':
                return self::hasValidRevSliderLicense();
            case 'ultimate_vc_addons':
                return self::hasValidBrainstormForceLicense($slug);
            case 'wp-smush-pro':
                return self::hasValidWpmudevLicense('wp_smush');
        }

        return true;
    }

    /**
     * @return bool
     */
    protected static function hasValidAdvancedCustomFieldsProLicense()
    {
        // Advanced Custom Fields PRO 5.7.7
        // see class acf_pro_updates::acf_pro_get_license
        $license = get_site_option('acf_pro_license');
        if (!$license) {
            return false;
        }

        $license = maybe_unserialize(call_user_func('base' . 64 . '_decode', $license));
        if (!is_array($license)) {
            return false;
        }

        // see class acf_pro_updates::acf_pro_get_license_key
        if (empty($license['key']) || empty($license['url'])) {
            return false;
        }

        if (str_replace(array('http://', 'https://'), '', $license['url']) !== str_replace(array('http://', 'https://'), '', home_url())) {
            return false;
        }

        return true;
    }

    /**
     * @param string $slug
     * @return bool
     */
    protected static function hasValidBrainstormForceLicense($slug)
    {
        // Ultimate Addons for WPBakery Page Builder 3.19.6
        // see BSF_License_Manager::bsf_is_active_license
        $brainstrom_products = get_option('brainstrom_products', array());
        $brainstorm_plugins = isset($brainstrom_products['plugins']) ? $brainstrom_products['plugins'] : array();
        $brainstorm_themes = isset($brainstrom_products['themes']) ? $brainstrom_products['themes'] : array();
        $all_products = $brainstorm_plugins + $brainstorm_themes;

        // Find the product ID based on the slug
        $product_id = '';
        foreach ($all_products as $key => $product) {
            if (strtolower($product['slug']) == $slug) {
                $product_id = $product['id'];
                break;
            }
        }
        // Can not validate the license. Assume that it is valid.
        if (!$product_id) {
            return true;
        }

        // Is product free
        if (isset($all_products[$product_id]['is_product_free']) && ($all_products[$product_id]['is_product_free'] === true || $all_products[$product_id]['is_product_free'] === 'true')) {
            return true;
        }

        // Is product registered
        if (isset($all_products[$product_id]['status']) && 'registered' === $all_products[$product_id]['status']) {
            // If the purchase key is empty, Return false.
            if (!isset($all_products[$product_id]['purchase_key'])) {
                return false;
            }
            // Skipping - Check if license is active on API.
            return true;
        }

        // see BSF_Update_Manager::bsf_is_product_bundled
        $brainstrom_bundled_products = get_option('brainstrom_bundled_products', array());
        foreach ($brainstrom_bundled_products as $parent => $parent_products) {
            foreach ($parent_products as $key => $parent_product) {
                $parent_product = (object) $parent_product;
                if ($parent_product->id != $product_id) {
                    continue;
                }
                $parent_product_id = $parent_product->id;
                if (isset($all_products[$parent_product_id]['status']) && 'registered' === $all_products[$parent_product_id]['status']) {
                    // If the purchase key is empty, Return false.
                    if (!isset($all_products[$parent_product_id]['purchase_key'])) {
                        return false;
                    }
                    // Skipping - Check if license is active on API.
                    return true;
                }
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    protected static function hasValidElementorProLicense()
    {
        // Elementor Pro 3.0.5
        // see class ElementorPro\License\Admin
        $license = get_site_option('elementor_pro_license_key', '');
        return !empty($license);
    }

    /**
     * @return bool
     */
    protected static function hasValidLayerSliderLicense()
    {
        // LayerSlider WP 6.5.5
        // see KM_UpdatesV3::pre_download_filter
        $license = get_site_option('layerslider-authorized-site', '');
        return !empty($license);
    }

    /**
     * @return bool
     */
    protected static function hasValidMasterSliderProLicense()
    {
        // Master Slider Pro 3.2.2
        // see Axiom_Plugin_License::license_action
        $is_license_activated = (int) get_option((defined('MSWP_SLUG') ? MSWP_SLUG : 'masterslider') . '_is_license_actived', 0); // phpcs:ignore "actived" is not a spelling mistake
        if (!$is_license_activated) {
            return false;
        }

        $license = get_option('msp_envato_' . 'license', array());
        return (!empty($license['purchase_code']) && !empty($license['token']));
    }

    /**
     * @return bool
     */
    protected static function hasValidRevSliderLicense()
    {
        // Slider Revolution 5.4.8.3
        // see RevSliderOperations::checkPurchaseVerification
        $license = get_site_option('revslider-code', '');
        if (empty($license)) {
            return false;
        }

        $valid = get_option('revslider-valid', 'false');
        return ($valid === 'true' || $valid === true);
    }

    /**
     * @return bool
     */
    protected static function hasValidWpBakeryPageBuilderLicense()
    {
        // WPBakery Page Builder 6.1
        // see class Vc_License
        // double "_js" in the name is correct
        $license = get_site_option('wpb_js_' . 'js_composer' . '_purchase_code', '');
        return !empty($license);
    }

    /**
     * @param string $slug
     * @return bool
     */
    protected static function hasValidWpmudevLicense($slug)
    {
        // Smush Pro 3.6.3
        if (defined('WPMUDEV_APIKEY') && WPMUDEV_APIKEY) {
            $api_key = WPMUDEV_APIKEY;
        } else {
            $api_key = get_site_option('wpmudev_apikey', '');
        }

        if (!$api_key) {
            return false;
        }

        $api_auth = get_site_option($slug . '_api_auth', array());

        return (isset($api_auth[$api_key]) && isset($api_auth[$api_key]['validity']) && $api_auth[$api_key]['validity'] === 'valid');
    }
}
