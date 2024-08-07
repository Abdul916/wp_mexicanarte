<?php
/**
* Custom Sanitize Functions
**/
function avante_sanitize_checkbox( $input ) {
	if(is_bool($input))
	{
		return $input;
	}
	else
	{
		return false;
	}

}

function avante_sanitize_slider( $input ) {	if(is_numeric($input))
	{
		return $input;
	}
	else
	{
		return 0;

	}
}

function avante_sanitize_html( $input ) {
    return wp_kses_post( $input );
}

/*** Configuration to disable default WordPress customizer tabs
**/

add_action( 'customize_register', 'avante_customize_register' );
function avante_customize_register( $wp_customize ) {
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'background_image' );
}

/**
 * Configuration sample for the Kirki Customizer
 */
function avante_demo_configuration_sample() {

    /**
     * If you need to include Kirki in your theme,
     * then you may want to consider adding the translations here
     * using your textdomain.
     * 
     * If you're using Kirki as a plugin then you can remove these.
     */

    $strings = array(
        'background-color' => esc_html__('Background Color', 'avante' ),
        'background-image' => esc_html__('Background Image', 'avante' ),
        'no-repeat' => esc_html__('No Repeat', 'avante' ),
        'repeat-all' => esc_html__('Repeat All', 'avante' ),
        'repeat-x' => esc_html__('Repeat Horizontally', 'avante' ),
        'repeat-y' => esc_html__('Repeat Vertically', 'avante' ),
        'inherit' => esc_html__('Inherit', 'avante' ),
        'background-repeat' => esc_html__('Background Repeat', 'avante' ),
        'cover' => esc_html__('Cover', 'avante' ),
        'contain' => esc_html__('Contain', 'avante' ),
        'background-size' => esc_html__('Background Size', 'avante' ),
        'fixed' => esc_html__('Fixed', 'avante' ),
        'scroll' => esc_html__('Scroll', 'avante' ),
        'background-attachment' => esc_html__('Background Attachment', 'avante' ),
        'left-top' => esc_html__('Left Top', 'avante' ),
        'left-center' => esc_html__('Left Center', 'avante' ),
        'left-bottom' => esc_html__('Left Bottom', 'avante' ),
        'right-top' => esc_html__('Right Top', 'avante' ),
        'right-center' => esc_html__('Right Center', 'avante' ),
        'right-bottom' => esc_html__('Right Bottom', 'avante' ),
        'center-top' => esc_html__('Center Top', 'avante' ),
        'center-center' => esc_html__('Center Center', 'avante' ),
        'center-bottom' => esc_html__('Center Bottom', 'avante' ),
        'background-position' => esc_html__('Background Position', 'avante' ),
        'background-opacity' => esc_html__('Background Opacity', 'avante' ),
        'ON' => esc_html__('ON', 'avante' ),
        'OFF' => esc_html__('OFF', 'avante' ),
        'all' => esc_html__('All', 'avante' ),
        'cyrillic' => esc_html__('Cyrillic', 'avante' ),
        'cyrillic-ext' => esc_html__('Cyrillic Extended', 'avante' ),
        'devanagari' => esc_html__('Devanagari', 'avante' ),
        'greek' => esc_html__('Greek', 'avante' ),
        'greek-ext' => esc_html__('Greek Extended', 'avante' ),
        'khmer' => esc_html__('Khmer', 'avante' ),
        'latin' => esc_html__('Latin', 'avante' ),
        'latin-ext' => esc_html__('Latin Extended', 'avante' ),
        'vietnamese' => esc_html__('Vietnamese', 'avante' ),
    );

    $args = array(
        'textdomain'   => 'avante',
    );

    return $args;

}
add_filter( 'kirki/config', 'avante_demo_configuration_sample' );

/**
 * Create the customizer panels and sections
 */
function avante_add_panels_and_sections( $wp_customize ) {

	/**
     * Add panels
     */
    $wp_customize->add_panel( 'general', array(
        'priority'    => 35,
        'title'       => esc_html__('General', 'avante' ),
    ) ); 
    
    $wp_customize->add_panel( 'menu', array(
        'priority'    => 35,
        'title'       => esc_html__('Navigation', 'avante' ),
    ) );
    
    $wp_customize->add_panel( 'header', array(
        'priority'    => 39,
        'title'       => esc_html__('Header', 'avante' ),
    ) );
    
    $wp_customize->add_panel( 'sidebar', array(
        'priority'    => 43,
        'title'       => esc_html__('Sidebar', 'avante' ),
    ) );
    
    $wp_customize->add_panel( 'footer', array(
        'priority'    => 44,
        'title'       => esc_html__('Footer', 'avante' ),
    ) );
    
    $wp_customize->add_panel( 'gallery', array(
        'priority'    => 45,
        'title'       => esc_html__('Gallery', 'avante' ),
    ) );
    
    $wp_customize->add_panel( 'blog', array(
        'priority'    => 47,
        'title'       => esc_html__('Blog', 'avante' ),
    ) );
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		$wp_customize->add_panel( 'shop', array(
	        'priority'    => 48,
	        'title'       => esc_html__('Shop', 'avante' ),
	    ) );
	}
	
	//Check if Booking Calendar is installed	
	if(class_exists('LearnPress'))
	{
		$wp_customize->add_panel( 'learnpress', array(
	        'priority'    => 48,
	        'title'       => esc_html__('Learn Press', 'avante' ),
	    ) );
	}

    /**
     * Add sections
     */
	$wp_customize->add_section( 'logo_favicon', array(
        'title'       => esc_html__('Site Logo', 'avante' ),
        'priority'    => 34,

    ) );
    
    $wp_customize->add_section( 'general_image', array(
        'title'       => esc_html__('Image', 'avante' ),
        'panel'		  => 'general',
        'priority'    => 46,
    ) );
    
    $wp_customize->add_section( 'general_lightbox', array(
        'title'       => esc_html__('Lightbox', 'avante' ),
        'panel'		  => 'general',
        'priority'    => 46,

    ) );
    
    $wp_customize->add_section( 'general_fonts', array(
        'title'       => esc_html__('Fonts', 'avante' ),
        'panel'		  => 'general',
        'priority'    => 46,

    ) );
    
    $wp_customize->add_section( 'general_typography', array(
        'title'       => esc_html__('Typography', 'avante' ),
        'panel'		  => 'general',
        'priority'    => 47,

    ) );
    
    $wp_customize->add_section( 'general_color', array(
        'title'       => esc_html__('Background & Colors', 'avante' ),
        'panel'		  => 'general',
        'priority'    => 48,

    ) );
    
    $wp_customize->add_section( 'general_input', array(
        'title'       => esc_html__('Input and Button Elements', 'avante' ),
        'panel'		  => 'general',
        'priority'    => 49,

    ) );
    
    $wp_customize->add_section( 'general_frame', array(
        'title'       => esc_html__('Frame', 'avante' ),
        'panel'		  => 'general',
        'priority'    => 51,
    ) );

    $wp_customize->add_section( 'menu_general', array(
        'title'       => esc_html__('General', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 36,

    ) );
    
    $wp_customize->add_section( 'menu_typography', array(
        'title'       => esc_html__('Typography', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 36,

    ) );
    
    $wp_customize->add_section( 'menu_color', array(
        'title'       => esc_html__('Colors', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 37,

    ) );
    
    $wp_customize->add_section( 'menu_submenu', array(
        'title'       => esc_html__('Sub Menu', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 38,

    ) );
    
    $wp_customize->add_section( 'menu_megamenu', array(
        'title'       => esc_html__('Mega Menu', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 38,

    ) );
    
    $wp_customize->add_section( 'menu_topbar', array(
        'title'       => esc_html__('Top Bar', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 38,

    ) );
    
    $wp_customize->add_section( 'menu_contact', array(
        'title'       => esc_html__('Contact Info', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 39,

    ) );
    
    $wp_customize->add_section( 'menu_sidemenu', array(
        'title'       => esc_html__('Side Menu', 'avante' ),
        'panel'		  => 'menu',
        'priority'    => 39,

    ) );
    
    $wp_customize->add_section( 'header_background', array(
        'title'       => esc_html__('Background', 'avante' ),
        'panel'		  => 'header',
        'priority'    => 40,

    ) );
    
    $wp_customize->add_section( 'header_title', array(
        'title'       => esc_html__('Page Title', 'avante' ),
        'panel'		  => 'header',
        'priority'    => 41,

    ) );
    
    $wp_customize->add_section( 'header_builder_title', array(
        'title'       => esc_html__('Content Builder Header', 'avante' ),
        'panel'		  => 'header',
        'priority'    => 41,

    ) );
    
    $wp_customize->add_section( 'header_tagline', array(
        'title'       => esc_html__('Page Tagline & Sub Title', 'avante' ),
        'panel'		  => 'header',
        'priority'    => 42,

    ) );
    
    $wp_customize->add_section( 'sidebar_general', array(
        'title'       => esc_html__('General', 'avante' ),
        'panel'		  => 'sidebar',
        'priority'    => 42,

    ) );
    
    $wp_customize->add_section( 'sidebar_typography', array(
        'title'       => esc_html__('Typography', 'avante' ),
        'panel'		  => 'sidebar',
        'priority'    => 43,

    ) );
    
    $wp_customize->add_section( 'sidebar_color', array(
        'title'       => esc_html__('Colors', 'avante' ),
        'panel'		  => 'sidebar',
        'priority'    => 44,

    ) );
    
    $wp_customize->add_section( 'footer_general', array(
        'title'       => esc_html__('General', 'avante' ),
        'panel'		  => 'footer',
        'priority'    => 45,

    ) );
    
    $wp_customize->add_section( 'footer_color', array(
        'title'       => esc_html__('Colors', 'avante' ),
        'panel'		  => 'footer',
        'priority'    => 46,

    ) );
    
    $wp_customize->add_section( 'footer_copyright', array(
        'title'       => esc_html__('Copyright', 'avante' ),
        'panel'		  => 'footer',
        'priority'    => 47,

    ) );
    
    $wp_customize->add_section( 'blog_general', array(
        'title'       => esc_html__('General', 'avante' ),
        'panel'		  => 'blog',
        'priority'    => 53,

    ) );
    
    $wp_customize->add_section( 'blog_typography', array(
        'title'       => esc_html__('Typography', 'avante' ),
        'panel'		  => 'blog',
        'priority'    => 54,

    ) );
    
    $wp_customize->add_section( 'blog_slider', array(
        'title'       => esc_html__('Slider', 'avante' ),
        'panel'		  => 'blog',
        'priority'    => 54,

    ) );
    
    $wp_customize->add_section( 'blog_single', array(
        'title'       => esc_html__('Single Post', 'avante' ),
        'panel'		  => 'blog',
        'priority'    => 55,

    ) );
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		$wp_customize->add_section( 'shop_layout', array(
	        'title'       => esc_html__('Layout', 'avante' ),
	        'panel'		  => 'shop',
	        'priority'    => 55,
	
	    ) );
	    
	    $wp_customize->add_section( 'shop_single', array(
	        'title'       => esc_html__('Single Product', 'avante' ),
	        'panel'		  => 'shop',
	        'priority'    => 56,
	
	    ) );
	}
	
	//Check if Booking Calendar is installed	
	if(class_exists('LearnPress'))
	{
		$wp_customize->add_section( 'course_general', array(
	        'title'       => esc_html__('General', 'avante' ),
	        'panel'		  => 'learnpress',
	        'priority'    => 55,
	
	    ) );
	    
	    $wp_customize->add_section( 'course_grid', array(
	        'title'       => esc_html__('Course Grid', 'avante' ),
	        'panel'		  => 'learnpress',
	        'priority'    => 55,
	
	    ) );
		
		$wp_customize->add_section( 'course_single', array(
	        'title'       => esc_html__('Single Course', 'avante' ),
	        'panel'		  => 'learnpress',
	        'priority'    => 55,
	
	    ) );
	    
	    $wp_customize->add_section( 'course_single_profile', array(
	        'title'       => esc_html__('Teacher Profile', 'avante' ),
	        'panel'		  => 'learnpress',
	        'priority'    => 55,
	
	    ) );
	}

}
add_action( 'customize_register', 'avante_add_panels_and_sections' );

/**
 * Register and setting to header section
 */
function avante_header_setting( $wp_customize ) {

	//Register Logo Tab Settings
	$wp_customize->add_setting( 'tg_favicon', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );
	
    $wp_customize->add_setting( 'tg_retina_logo', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_setting( 'tg_retina_transparent_logo', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    //End Logo Tab Settings
    
    //Register General Tab Settings
    $wp_customize->add_setting( 'tg_enable_right_click', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_enable_dragging', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_body_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_body_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
	$wp_customize->add_setting( 'tg_header_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_header_font_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h1_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h2_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h3_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h4_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h5_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_h6_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_content_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_hover_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_h1_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_hr_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_input_focus_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_button_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_button_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_button_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_button_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    //End General Tab Settings
    

    //Register Menu Tab Settings
    $wp_customize->add_setting( 'tg_menu_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_fixed_menu', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_padding', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_hover_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_active_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_hover_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_hover_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_submenu_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_megamenu_header_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_megamenu_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_topbar_social_link', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_contact_hours', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_contact_number', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_search', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_search_input_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_menu_search_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_sidemenu_font_hover_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    //End Menu Tab Settings
    
    //Register Header Tab Settings
	$wp_customize->add_setting( 'tg_page_header_bg_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_page_header_padding_top', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_header_padding_bottom', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_weight', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_font_spacing', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_page_title_bg_height', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_header_builder_font_size', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_header_builder_font_transform', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    //End Header Tab Settings
    
    //Register Copyright Tab Settings
    
    $wp_customize->add_setting( 'tg_footer_sidebar', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
	
	$wp_customize->add_setting( 'tg_footer_social_link', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
	$wp_customize->add_setting( 'tg_footer_font_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_hover_link_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_border_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_social_color', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_copyright_text', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_html',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_copyright_right_area', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_footer_copyright_totop', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    //End Copyright Tab Settings
    
    
    //Begin Portfolio Tab Settings
    $wp_customize->add_setting( 'tg_portfolio_filterable', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_filterable_link', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_filterable_sort', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_items', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_slider',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_next_prev', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_portfolio_recent', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    //End Portfolio Tab Settings
    
    
    //Begin Blog Tab Settings
    $wp_customize->add_setting( 'tg_blog_display_full', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_archive_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_category_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_tag_layout', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_html',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_header_bg', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_feat_content', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_display_tags', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_display_author', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    
    $wp_customize->add_setting( 'tg_blog_display_related', array(
        'type'           => 'theme_mod',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'avante_sanitize_checkbox',
    ) );
    //End Blog Tab Settings
    
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		//Begin Shop Tab Settings
		$wp_customize->add_setting( 'tg_shop_layout', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_html',
	    ) );
	    
	    $wp_customize->add_setting( 'tg_shop_items', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'avante_sanitize_slider',
	    ) );
	    
	    $wp_customize->add_setting( 'tg_shop_price_font_color', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color',
	    ) );
	    
	    $wp_customize->add_setting( 'tg_shop_related_products', array(
	        'type'           => 'theme_mod',
	        'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'avante_sanitize_checkbox',
	    ) );
		//End Shop Tab Settings
	}
    
    
    //Add Live preview
    if ( $wp_customize->is_preview() && ! is_admin() ) {
	    add_action( 'wp_footer', 'avante_customize_preview', 21);
	}
}
add_action( 'customize_register', 'avante_header_setting' );

/**
 * Create the setting
 */
function avante_custom_setting( $controls ) {

	//Default control choices
	$tg_text_transform = array(
	    'none' => 'None',
	    'capitalize' => 'Capitalize',
	    'uppercase' => 'Uppercase',
	    'lowercase' => 'Lowercase',
	);
	
	$tg_text_alignment = array(
	    'left' => 'Left',
	    'center' => 'Center',
	    'right' => 'Right',
	);
	
	$tg_copyright_content = array(
	    'social' => 'Social Icons',
	    'menu' => 'Footer Menu',
	);
	
	$tg_footer_content = array(
	    'content' => 'Footer Content',
	    'sidebar' => 'Sidebar',
	    'hide' => 'Hide Footer Content',
	);
	
	$tg_header_content = array(
	    'content' => 'Header Content',
	    'menu' => 'General Menu Layout',
	);
	
	$tg_copyright_column = array(
	    1 => '1 Column',
	    2 => '2 Column',
	    3 => '3 Column',
	    4 => '4 Column',
	);
	
	$tg_portfolio_filterable_sort = array(
		'name' => 'By Name',
		'slug' => 'By Slug',
		'id' => 'By ID',
		'count' => 'By Number of Portfolio',
	);
	
	$tg_blog_layout = array(
		'blog-r' => 'Right Sidebar',
		'blog-l' => 'Left Sidebar',
		'blog-f' => 'Fullwidth',
	);
	
	$tg_shop_layout = array(
		'fullwidth' => 'Fullwidth',
		'sidebar' => 'With Sidebar',
	);
	
	$tg_slideshow_trans = array(
	    1 => 'Fade',
	    2 => 'Slide Top',
	    3 => 'Slide Right',
	    4 => 'Slide Bottom',
	    5 => 'Slide Left',
	    6 => 'Carousel Right',
	    7 => 'Carousel Left',
	);
	
	$tg_menu_layout = array(
	    'leftalign' => 'Left Align',
	    'centeralign' => 'Center Align',
	    'hammenuside' => 'Hamburger Menu + Side Menu',
	    'full-burger-menu' => 'Hamburger Menu + Fullscreen Menu',
	    'leftmenu' => 'Left Vetical',
	);
	
	$tg_lightbox_skin = array(
		'white' => 'White',
		'black' => 'Black',
	);
	
	$tg_lightbox_thumbnails = array(
		'no_thumbnail' => 'No Thumbnail',
		'thumbnail' => 'Show Thumbnail',
	);
	
	//Get all categories
	$categories_arr = get_categories();
	$tg_categories_select = array();
	$tg_categories_select[''] = '';
	
	foreach ($categories_arr as $cat) {
		$tg_categories_select[$cat->cat_ID] = $cat->cat_name;
	}
	
	//Get all gallery categories
	$gallery_categories_arr = get_terms('gallerycat', 'hide_empty=0&hierarchical=0&parent=0&orderby=name');
	$tg_gallery_categories_select = array();
	$tg_gallery_categories_select[''] = '';
	
	if(!empty($gallery_categories_arr) && is_array($gallery_categories_arr))
	{
		foreach ($gallery_categories_arr as $gallery_cat) {
			$tg_gallery_categories_select[$gallery_cat->slug] = $gallery_cat->name;
		}
	}
	
	//Get all footer posts
	$args = array(
		 'post_type'     => 'footer',
		 'post_status'   => array( 'publish' ),
		 'numberposts'   => -1,
		 'orderby'       => 'title',
		 'order'         => 'ASC',
		 'suppress_filters'   => false
	);
	$footers = get_posts($args);
	$tg_footers_select = array();
	$tg_footers_select[''] = '';
	
	if(!empty($footers))
	{
		foreach ($footers as $footer)
		{
			$tg_footers_select[$footer->ID] = $footer->post_title;
		}
	}
	
	//Get all header posts
	$args = array(
		 'post_type'     => 'header',
		 'post_status'   => array( 'publish' ),
		 'numberposts'   => -1,
		 'orderby'       => 'title',
		 'order'         => 'ASC',
		 'suppress_filters'   => false
	);
	$headers = get_posts($args);
	$tg_headers_select = array();
	$tg_headers_select[''] = '';
	
	if(!empty($headers))
	{
		foreach ($headers as $header)
		{
			$tg_headers_select[$header->ID] = $header->post_title;
		}
	}
	
	//Register Logo Tab Settings
	$controls[] = array(
        'type'     => 'image',
        'settings'  => 'tg_retina_logo',
        'label'    => esc_html__('Retina Logo', 'avante' ),
        'description' => esc_html__('Retina Ready Image logo. It should be 2x size of normal logo. For example 200x60px logo will displays at 100x30px', 'avante' ),
        'section'  => 'logo_favicon',
	    'default'  => get_template_directory_uri().'/images/logo@2x.png',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'image',
        'settings'  => 'tg_retina_transparent_logo',
        'label'    => esc_html__('Retina Transparent Logo', 'avante' ),
        'description' => esc_html__('Retina Ready Image logo for menu transparent page. It should be 2x size of normal logo. For example 200x60px logo will displays at 100x30px. Recommend logo color is white or bright color', 'avante' ),
        'section'  => 'logo_favicon',
	    'default'  => get_template_directory_uri().'/images/logo@2x_white.png',
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_retina_logo_for_admin',
        'label'    => esc_html__('Display Retina Logo in Theme Setting', 'avante' ),
        'description' => esc_html__('Check this to replace theme setting to your logo. It helps branding your site', 'avante' ),
        'section'  => 'logo_favicon',
        'default'  => '',
	    'priority' => 4,
    );
    //End Logo Tab Settings
    
    //Register General Tab Settings
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_enable_right_click_title',
        'label'    => esc_html__('Right Click Protection Settings', 'avante' ),
        'section'  => 'general_image',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_enable_right_click',
        'label'    => esc_html__('Enable Right Click Protection', 'avante' ),
        'description' => esc_html__('Check this to disable right click.', 'avante' ),
        'section'  => 'general_image',
        'default'  => '',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_enable_right_click_content',
        'label'    => esc_html__('Enable Right Click Protection Content', 'avante' ),
        'description' => esc_html__('Check this to enable fullscreen content when visitor tried to right click', 'avante' ),
        'section'  => 'general_image',
        'default'  => '',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'textarea',
        'settings'  => 'tg_enable_right_click_content_text',
        'label'    => esc_html__('Right Click Protection Content', 'avante' ),
        'description' => '',
        'section'  => 'general_image',
        'default'  => '',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_enable_right_click_content_bg_color',
        'label'    => esc_html__('Right Click Protection Content Background Color', 'avante' ),
        'section'  => 'general_image',
        'default'  => 'rgba(0, 0, 0, 0.5)',
        'output' => array(
	        array(
	            'element'  => '#right-click-content',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
	    'js_vars'   => array(
			array(
				'element'  => '#right-click-content',
				'function' => 'css',
				'property' => 'background',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_enable_right_click_content_font_color',
        'label'    => esc_html__('Right Click Protection Content Font Color', 'avante' ),
        'section'  => 'general_image',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#right-click-content',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
	    'js_vars'   => array(
			array(
				'element'  => '#right-click-content',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_image_other_title',
        'label'    => esc_html__('Other Settings', 'avante' ),
        'section'  => 'general_image',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_enable_dragging',
        'label'    => esc_html__('Enable Image Dragging Protection', 'avante' ),
        'description' => esc_html__('Check this to disable dragging on all images.', 'avante' ),
        'section'  => 'general_image',
        'default'  => '',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_enable_lazy_loading',
        'label'    => esc_html__('Enable Lazy Loading Image', 'avante' ),
        'description' => esc_html__('Check this to enable lazy loading image option to improve site loading speed.', 'avante' ),
        'section'  => 'general_image',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio-buttonset',
        'settings'  => 'tg_lightbox_color_scheme',
        'label'    => esc_html__('Select lightbox color scheme', 'avante' ),
        'description' => esc_html__('Select which alignment you want to use for lightbox thumbnails', 'avante' ),
        'section'  => 'general_lightbox',
        'default'  => 'black',
        'choices'  => $tg_lightbox_skin,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio-buttonset',
        'settings'  => 'tg_lightbox_thumbnails',
        'label'    => esc_html__('Select lightbox thumbnails alignment', 'avante' ),
        'description' => esc_html__('Select which alignment you want to use for lightbox thumbnails', 'avante' ),
        'section'  => 'general_lightbox',
        'default'  => 'thumbnail',
        'choices'  => $tg_lightbox_thumbnails,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_lightbox_timer',
        'label'    => esc_html__('Lightbox slideshow timer', 'avante' ),
        'description' => esc_html__('Select number of seconds for lightbox slideshow timer', 'avante' ),
        'section'  => 'general_lightbox',
        'default'  => 7,
        'choices' => array( 'min' => 1, 'max' => 20, 'step' => 1 ),
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_body_typography_title',
        'label'    => esc_html__('Body and Content Settings', 'avante' ),
        'section'  => 'general_typography',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_body_typography',
        'label'    => esc_html__('Main Content Typography', 'avante' ),
        'section'  => 'general_typography',
        'default'  => array(
			'font-family'    => 'Roboto',
			'variant'        => '400',
			'font-size'      => '16px',
			'line-height'    => '1.8',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => 'body, input[type=text], input[type=password], input[type=email], input[type=url], input[type=date], input[type=tel], input.wpcf7-text, .woocommerce table.cart td.actions .coupon .input-text, .woocommerce-page table.cart td.actions .coupon .input-text, .woocommerce #content table.cart td.actions .coupon .input-text, .woocommerce-page #content table.cart td.actions .coupon .input-text, select, textarea, .ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button, .ui-widget label, .ui-widget-header, .zm_alr_ul_container',
	        ),
	    ),
	    'priority' => 1,
    );
        
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_header_typography_title',
        'label'    => esc_html__('Header Settings', 'avante' ),
        'section'  => 'general_typography',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_header_typography',
        'label'    => esc_html__('Header Typography', 'avante' ),
        'section'  => 'general_typography',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'line-height'    => '1.7',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => 'h1, h2, h3, h4, h5, h6, h7, .post_quote_title, strong[itemprop="author"], #page-content-wrapper .posts.blog li a, .page-content-wrapper .posts.blog li a, #filter_selected, blockquote, .sidebar-widget li.widget_products, #footer ul.sidebar-widget li ul.posts.blog li a, .woocommerce-page table.cart th, table.shop_table thead tr th, .testimonial_slider_content, .pagination, .pagination-detail',
	        ),
	    ),
	    'priority' => 2
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h1_size',
        'label'    => esc_html__('H1 Font Size', 'avante' ),
        'section'  => 'general_typography',
        'default'  => 32,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h1',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 3,
	    'js_vars'   => array(
			array(
				'element'  => 'h1',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h2_size',
        'label'    => esc_html__('H2 Font Size', 'avante' ),
        'section'  => 'general_typography',
        'default'  => 28,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h2',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 4,
	    'js_vars'   => array(
			array(
				'element'  => 'h2',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h3_size',
        'label'    => esc_html__('H3 Font Size', 'avante' ),
        'section'  => 'general_typography',
        'default'  => 24,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h3',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 5,
	    'js_vars'   => array(
			array(
				'element'  => 'h3',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h4_size',
        'label'    => esc_html__('H4 Font Size', 'avante' ),
        'section'  => 'general_typography',
        'default'  => 22,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h4',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 6,
	    'js_vars'   => array(
			array(
				'element'  => 'h4',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h5_size',
        'label'    => esc_html__('H5 Font Size', 'avante' ),
        'section'  => 'general_typography',
        'default'  => 20,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h5',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 7,
	    'js_vars'   => array(
			array(
				'element'  => 'h5',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_h6_size',
        'label'    => esc_html__('H6 Font Size', 'avante' ),
        'section'  => 'general_typography',
        'default'  => 18,
        'choices' => array( 'min' => 13, 'max' => 60, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'h6',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'priority' => 8,
	    'js_vars'   => array(
			array(
				'element'  => 'h6',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_content_color_title',
        'label'    => esc_html__('Main Content Color Settings', 'avante' ),
        'section'  => 'general_color',
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_content_bg_color',
        'label'    => esc_html__('Main Content Background Color', 'avante' ),
        'section'  => 'general_color',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'body, #wrapper, #page-content-wrapper.fixed, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, #body_loading_screen, h3#reply-title span, .overlay_gallery_wrapper, .pagination a, .pagination span, #captcha-wrap .text-box input, .flex-direction-nav a, .blog_promo_title h6, #supersized li, #horizontal_gallery_wrapper .image_caption, body.password-protected #page-content-wrapper .inner .inner-wrapper .sidebar-content, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"], #single-course-meta',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
	    'js_vars'   => array(
			array(
				'element'  => 'body, #wrapper, #page-content-wrapper.fixed, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, #body_loading_screen, h3#reply-title span, .overlay_gallery_wrapper, .pagination a, .pagination span, #captcha-wrap .text-box input, .flex-direction-nav a, .blog_promo_title h6, #supersized li, #horizontal_gallery_wrapper .image_caption, body.password-protected #page-content-wrapper .inner .inner-wrapper .sidebar-content, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"], #single-course-meta',
				'function' => 'css',
				'property' => 'background-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_font_color',
        'label'    => esc_html__('Page Content Font Color', 'avante' ),
        'section'  => 'general_color',
        'default'  => '#7E8090',
        'output' => array(
	        array(
	            'element'  => 'body, .pagination a, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, .post_info a, #page-content-wrapper.split #copyright, .page-content-wrapper.split #copyright, .ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, .woocommerce-MyAccount-navigation ul a, .woocommerce #page-content-wrapper div.product p.price, .woocommerce-page #page-content-wrapper div.product p.price',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '::selection, .verline',
	            'property' => 'background-color',
	        ),
	        array(
	            'element'  => '::-webkit-input-placeholder',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '::-moz-placeholder',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => ':-ms-input-placeholder',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 11,
	    'js_vars'   => array(
			array(
				'element'  => 'body, .pagination a, #gallery_lightbox h2, .slider_wrapper .gallery_image_caption h2, .post_info a, #page-content-wrapper.split #copyright, .page-content-wrapper.split #copyright, .ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, .woocommerce-MyAccount-navigation ul a',
				'function' => 'css',
				'property' => 'color',
			),
			array(
				'element'  => '::-webkit-input-placeholder',
				'function' => 'css',
				'property' => 'background-color',
			),
			array(
				'element'  => '::-moz-placeholder',
				'function' => 'css',
				'property' => 'background-color',
			),
			array(
				'element'  => ':-ms-input-placeholder',
				'function' => 'css',
				'property' => 'background-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_link_color',
        'label'    => esc_html__('Page Content Link Color', 'avante' ),
        'section'  => 'general_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => 'a, .gallery_proof_filter ul li a, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_rss ul li  cite, #footer-wrapper ul.sidebar-widget li.widget_rss ul li  cite',
	            'property' => 'color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active, .post-attribute a:before, #menu-wrapper .nav ul li a:before, #menu-wrapper div .nav li > a:before, .post-attribute a:before',
	            'property' => 'background-color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active, .image_boxed_wrapper:hover, .gallery_proof_filter ul li a.active, .gallery_proof_filter ul li a:hover',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 12,
	    'js_vars'   => array(
			array(
	            'element'  => 'a, .gallery_proof_filter ul li a, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_rss ul li  cite, #footer-wrapper ul.sidebar-widget li.widget_rss ul li  cite',
	            'property' => 'color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active, .post-attribute a:before, #menu-wrapper .nav ul li a:before, #menu-wrapper div .nav li > a:before, .post-attribute a:before',
	            'property' => 'background-color',
	        ),
	         array(
	            'element'  => '.flex-control-paging li a.flex-active, .image_boxed_wrapper:hover, .gallery_proof_filter ul li a.active, .gallery_proof_filter ul li a:hover',
	            'property' => 'border-color',
	        ),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_hover_link_color',
        'label'    => esc_html__('Page Content Hover Link Color', 'avante' ),
        'section'  => 'general_color',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => 'a:hover, a:active, .post_info_comment a i, #commentform .required, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_rss ul li .rss-date, #footer-wrapper ul.sidebar-widget li.widget_rss ul li .rss-date',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, #menu-wrapper .nav ul li a:hover:before, #menu-wrapper div .nav li > a:hover:before, .post-attribute a:hover:before',
	            'property' => 'background-color',
	        ),
	        array(
	            'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .sidebar-widget li.widget_recent_comments ul li.recentcomments a:hover',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
	            'element'  => 'a:hover, a:active, .post_info_comment a i, #commentform .required, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_rss ul li .rss-date, #footer-wrapper ul.sidebar-widget li.widget_rss ul li .rss-date',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active',
	            'property' => 'background',
	        ),
	        array(
	            'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .sidebar-widget li.widget_recent_comments ul li.recentcomments a:hover',
	            'property' => 'border-color',
	        ),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_h1_font_color',
        'label'    => esc_html__('H1, H2, H3, H4, H5, H6 Font Color', 'avante' ),
        'section'  => 'general_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => 'h1, h2, h3, h4, h5, h6, h7, pre, code, tt, blockquote, .post-header h5 a, .post-header h3 a, .post-header.grid h6 a, .post-header.fullwidth h4 a, .post-header h5 a, blockquote, .site_loading_logo_item i, .ppb_subtitle, .woocommerce .woocommerce-ordering select, .woocommerce #page-content-wrapper a.button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button:hover, .ui-accordion .ui-accordion-header a, .tabs .ui-state-active a, .post-header h5 a, .post-header h6 a, .flex-direction-nav a:before, .social_share_button_wrapper .social_post_view .view_number, .social_share_button_wrapper .social_post_share_count .share_number, .portfolio_post_previous a, .portfolio_post_next a, #filter_selected, #autocomplete li strong, .themelink, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .ui-dialog-titlebar .ui-dialog-title, body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .ui-dialog-titlebar .ui-dialog-title',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => 'body.page.page-template-gallery-archive-split-screen-php #fp-nav li .active span, body.tax-gallerycat #fp-nav li .active span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav li .active span, body.page.tax-portfolioset #fp-nav li .active span, body.page.page-template-gallery-archive-split-screen-php #fp-nav ul li a span, body.tax-gallerycat #fp-nav ul li a span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav ul li a span, body.page.tax-portfolioset #fp-nav ul li a span',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 14,
	    'js_vars'   => array(
			array(
				'element'  => 'h1, h2, h3, h4, h5, h6, h7, pre, code, tt, blockquote, .post-header h5 a, .post-header h3 a, .post-header.grid h6 a, .post-header.fullwidth h4 a, .post-header h5 a, blockquote, .site_loading_logo_item i, .ppb_subtitle, .woocommerce .woocommerce-ordering select, .woocommerce #page-content-wrapper a.button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button, .woocommerce.columns-4 ul.products li.product a.add_to_cart_button:hover, .ui-accordion .ui-accordion-header a, .tabs .ui-state-active a, .post-header h5 a, .post-header h6 a, .flex-direction-nav a:before, .social_share_button_wrapper .social_post_view .view_number, .social_share_button_wrapper .social_post_share_count .share_number, .portfolio_post_previous a, .portfolio_post_next a, #filter_selected, #autocomplete li strong, .themelink, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .ui-dialog-titlebar .ui-dialog-title, body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .ui-dialog-titlebar .ui-dialog-title',
				'function' => 'css',
				'property' => 'color',
			),
			array(
				'element'  => 'body.page.page-template-gallery-archive-split-screen-php #fp-nav li .active span, body.tax-gallerycat #fp-nav li .active span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav li .active span, body.page.tax-portfolioset #fp-nav li .active span, body.page.page-template-gallery-archive-split-screen-php #fp-nav ul li a span, body.tax-gallerycat #fp-nav ul li a span, body.page.page-template-portfolio-fullscreen-split-screen-php #fp-nav ul li a span, body.page.tax-portfolioset #fp-nav ul li a span',
				'function' => 'css',
				'property' => 'background-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_hr_color',
        'label'    => esc_html__('Horizontal Line Color', 'avante' ),
        'section'  => 'general_color',
        'default'  => '#D8D8D8',
        'output' => array(
	        array(
	            'element'  => 'hr, .post.type-post, .comment .right, .widget_tag_cloud div a, .meta-tags a, .tag_cloud a, #footer, #post_more_wrapper, #page-content-wrapper .inner .sidebar-content, #page-content-wrapper .inner .sidebar-content.left-sidebar, .ajax_close, .ajax_next, .ajax_prev, .portfolio_next, .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_next, .separated, .blog_next_prev_wrapper, #post_more_wrapper h5, #ajax_portfolio_wrapper.hidding, #ajax_portfolio_wrapper.visible, .tabs.vertical .ui-tabs-panel, .ui-tabs.vertical.right .ui-tabs-nav li, .woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li, .woocommerce div.product .woocommerce-tabs .panel, .woocommerce-page div.product .woocommerce-tabs .panel, .woocommerce #content div.product .woocommerce-tabs .panel, .woocommerce-page #content div.product .woocommerce-tabs .panel, .woocommerce table.shop_table, .woocommerce-page table.shop_table, .woocommerce .cart-collaterals .cart_totals, .woocommerce-page .cart-collaterals .cart_totals, .woocommerce .cart-collaterals .shipping_calculator, .woocommerce-page .cart-collaterals .shipping_calculator, .woocommerce .cart-collaterals .cart_totals tr td, .woocommerce .cart-collaterals .cart_totals tr th, .woocommerce-page .cart-collaterals .cart_totals tr td, .woocommerce-page .cart-collaterals .cart_totals tr th, table tr th, table tr td, .woocommerce #payment, .woocommerce-page #payment, .woocommerce #payment ul.payment_methods li, .woocommerce-page #payment ul.payment_methods li, .woocommerce #payment div.form-row, .woocommerce-page #payment div.form-row, .ui-tabs li:first-child, .ui-tabs .ui-tabs-nav li, .ui-tabs.vertical .ui-tabs-nav li, .ui-tabs.vertical.right .ui-tabs-nav li.ui-state-active, .ui-tabs.vertical .ui-tabs-nav li:last-child, #page-content-wrapper .inner .sidebar-wrapper ul.sidebar-widget li.widget_nav_menu ul.menu li.current-menu-item a, .page-content-wrapper .inner .sidebar-wrapper ul.sidebar-widget li.widget_nav_menu ul.menu li.current-menu-item a, .ui-accordion .ui-accordion-header, .ui-accordion .ui-accordion-content, #page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle:before, h2.widgettitle:before, #autocomplete, .ppb_blog_minimal .one-third_bg, .tabs .ui-tabs-panel, .ui-tabs .ui-tabs-nav li, .ui-tabs li:first-child, .ui-tabs.vertical .ui-tabs-nav li:last-child, .woocommerce .woocommerce-ordering select, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page table.cart th, table.shop_table thead tr th, hr.title_break, .overlay_gallery_border, #page-content-wrapper.split #copyright, .page-content-wrapper.split #copyright, .post.type-post, .events.type-events, h5.event_title, .post-header h5.event_title, .client_archive_wrapper, #page-content-wrapper .sidebar .content .sidebar-widget li.widget, .page-content-wrapper .sidebar .content .sidebar-widget li.widget, hr.title_break.bold, blockquote, .social_share_button_wrapper, .social_share_button_wrapper, body:not(.single) .post-wrapper, .theme-border, #about-the-author, .related.products, .woocommerce div.product div.summary .product_meta, #single-course-meta ul.single-course-meta-data li.single-course-meta-data-separator, body .course-curriculum ul.curriculum-sections .section-header, .course-reviews-list li, .course-reviews-list-shortcode li, .wp-block-table, .wp-block-table td, .wp-block-table th, .wp-block-table.is-style-stripes td, .wp-block-table.is-style-stripes th, table, .widget_categories ul > li, .widget_pages ul > li, .widget_archive ul > li, #page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle:before, h2.widgettitle:before, #page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle:after, h2.widgettitle:after',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 15,
	    'js_vars'   => array(
			array(
				'element'  => 'hr, .post.type-post, .comment .right, .widget_tag_cloud div a, .meta-tags a, .tag_cloud a, #footer, #post_more_wrapper, #page-content-wrapper .inner .sidebar-content, #page-content-wrapper .inner .sidebar-content.left-sidebar, .ajax_close, .ajax_next, .ajax_prev, .portfolio_next, .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_prev, .portfolio_next_prev_wrapper.video .portfolio_next, .separated, .blog_next_prev_wrapper, #post_more_wrapper h5, #ajax_portfolio_wrapper.hidding, #ajax_portfolio_wrapper.visible, .tabs.vertical .ui-tabs-panel, .ui-tabs.vertical.right .ui-tabs-nav li, .woocommerce div.product .woocommerce-tabs ul.tabs li, .woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li, .woocommerce div.product .woocommerce-tabs .panel, .woocommerce-page div.product .woocommerce-tabs .panel, .woocommerce #content div.product .woocommerce-tabs .panel, .woocommerce-page #content div.product .woocommerce-tabs .panel, .woocommerce table.shop_table, .woocommerce-page table.shop_table, .woocommerce .cart-collaterals .cart_totals, .woocommerce-page .cart-collaterals .cart_totals, .woocommerce .cart-collaterals .shipping_calculator, .woocommerce-page .cart-collaterals .shipping_calculator, .woocommerce .cart-collaterals .cart_totals tr td, .woocommerce .cart-collaterals .cart_totals tr th, .woocommerce-page .cart-collaterals .cart_totals tr td, .woocommerce-page .cart-collaterals .cart_totals tr th, table tr th, table tr td, .woocommerce #payment, .woocommerce-page #payment, .woocommerce #payment ul.payment_methods li, .woocommerce-page #payment ul.payment_methods li, .woocommerce #payment div.form-row, .woocommerce-page #payment div.form-row, .ui-tabs li:first-child, .ui-tabs .ui-tabs-nav li, .ui-tabs.vertical .ui-tabs-nav li, .ui-tabs.vertical.right .ui-tabs-nav li.ui-state-active, .ui-tabs.vertical .ui-tabs-nav li:last-child, #page-content-wrapper .inner .sidebar-wrapper ul.sidebar-widget li.widget_nav_menu ul.menu li.current-menu-item a, .page-content-wrapper .inner .sidebar-wrapper ul.sidebar-widget li.widget_nav_menu ul.menu li.current-menu-item a, .ui-accordion .ui-accordion-header, .ui-accordion .ui-accordion-content, #page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle:before, h2.widgettitle:before, #autocomplete, .ppb_blog_minimal .one-third_bg, .tabs .ui-tabs-panel, .ui-tabs .ui-tabs-nav li, .ui-tabs li:first-child, .ui-tabs.vertical .ui-tabs-nav li:last-child, .woocommerce .woocommerce-ordering select, .woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active, .woocommerce #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page table.cart th, table.shop_table thead tr th, hr.title_break, .overlay_gallery_border, #page-content-wrapper.split #copyright, .page-content-wrapper.split #copyright, .post.type-post, .events.type-events, h5.event_title, .post-header h5.event_title, .client_archive_wrapper, #page-content-wrapper .sidebar .content .sidebar-widget li.widget, .page-content-wrapper .sidebar .content .sidebar-widget li.widget, hr.title_break.bold, blockquote, .social_share_button_wrapper, .social_share_button_wrapper, body:not(.single) .post-wrapper, .theme-border, #about-the-author, .related.products, .woocommerce div.product div.summary .product_meta, #single-course-meta ul.single-course-meta-data li.single-course-meta-data-separator, body .course-curriculum ul.curriculum-sections .section-header, .course-reviews-list li, .course-reviews-list-shortcode li, .wp-block-table, .wp-block-table td, .wp-block-table th, .wp-block-table.is-style-stripes td, .wp-block-table.is-style-stripes th, table, .widget_categories ul > li, .widget_pages ul > li, .widget_archive ul > li, #page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle:before, h2.widgettitle:before, #page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle:after, h2.widgettitle:after',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_input_title',
        'label'    => esc_html__('Input and Textarea Settings', 'avante' ),
        'section'  => 'general_input',
	    'priority' => 16,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_input_border_radius',
        'label'    => esc_html__('Input and Textarea Border Radius (px)', 'avante' ),
        'section'  => 'general_input',
        'default'  => 5,
        'choices' => array( 'min' => 0, 'max' => 25, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea',
	            'property' => 'border-radius',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 20,
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea',
				'function' => 'css',
				'property' => 'border-radius',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_input_typography',
        'label'    => esc_html__('Input and Textarea Typography', 'avante' ),
        'section'  => 'general_input',
        'default'  => 'Roboto',
        'default'  => array(
			'font-family'    => 'Roboto',
			'variant'        => '400',
			'font-size'      => '16px',
			'line-height'    => '1.7',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .woocommerce .page_slider a.button, a.button.fullwidth, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], .select2-container--default .select2-selection--single',
	        ),
	    ),
	    'priority' => 19,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_bg_color',
        'label'    => esc_html__('Input and Textarea Background Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea, .widget_search form',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 16,
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea, .widget_search form',
				'function' => 'css',
				'property' => 'background-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_font_color',
        'label'    => esc_html__('Input and Textarea Font Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea.widget_search input.search-field',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 17,
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea.widget_search input.search-field',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_border_color',
        'label'    => esc_html__('Input and Textarea Border Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#D8D8D8',
        'output' => array(
	        array(
	            'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea, .select2-container--default .select2-selection--single, .select2-dropdown, .widget_search form',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 18,
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=date], textarea, .select2-container--default .select2-selection--single, .select2-dropdown, .widget_search form',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_input_focus_color',
        'label'    => esc_html__('Input and Textarea Focus State Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => 'input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=url]:focus, input[type=date]:focus, textarea:focus, .widget_search form.focus',
	            'property' => 'border-color',
	        ),
	        array(
	            'element'  => '.input-effect ~ .focus-border',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 19,
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=text]:focus, input[type=password]:focus, input[type=email]:focus, input[type=url]:focus, input[type=date]:focus, textarea:focus, .widget_search form.focus',
				'function' => 'css',
				'property' => 'border-color',
			),
			array(
	            'element'  => '.input-effect ~ .focus-border',
	            'function' => 'css',
	            'property' => 'background-color',
	        ),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_button_title',
        'label'    => esc_html__('Button Settings', 'avante' ),
        'section'  => 'general_input',
	    'priority' => 19,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_button_typography',
        'label'    => esc_html__('Button Typography', 'avante' ),
        'section'  => 'general_input',
        'default'  => 'Cabin',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '14px',
			'line-height'    => '1.8',
			'letter-spacing' => '0px',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .woocommerce .page_slider a.button, a.button.fullwidth, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], body.learnpress-page #page-content-wrapper .order-recover .lp-button, .learnpress-page #learn-press-profile-basic-information button, body #page-content-wrapper p#lp-avatar-actions button, .learnpress-page #profile-content-settings form button[type=submit], button, .woocommerce #respond input#submit',
	        ),
	    ),
	    'priority' => 19,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_button_border_radius',
        'label'    => esc_html__('Button Border Radius (px)', 'avante' ),
        'section'  => 'general_input',
        'default'  => 5,
        'choices' => array( 'min' => 0, 'max' => 25, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .woocommerce .page_slider a.button, a.button.fullwidth, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], a#go-to-top, .pagination span, .widget_tag_cloud div a, .pagination a, .pagination span, body.learnpress-page #page-content-wrapper .order-recover .lp-button, .learnpress-page #learn-press-profile-basic-information button, body #page-content-wrapper p#lp-avatar-actions button, .learnpress-page #profile-content-settings form button[type=submit], .learnpress-page #page-content-wrapper .lp-button, button, .woocommerce #respond input#submit',
	            'property' => 'border-radius',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 20,
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=submit], input[type=button], a.button, .button, .woocommerce .page_slider a.button, a.button.fullwidth, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], a#go-to-top, .pagination span, .widget_tag_cloud div a, .pagination a, .pagination span, body.learnpress-page #page-content-wrapper .order-recover .lp-button, .learnpress-page #learn-press-profile-basic-information button, body #page-content-wrapper p#lp-avatar-actions button, .learnpress-page #profile-content-settings form button[type=submit], .learnpress-page #page-content-wrapper .lp-button, button, .woocommerce #respond input#submit',
				'function' => 'css',
				'property' => 'border-radius',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_bg_color',
        'label'    => esc_html__('Button Background Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer-main-container .button, .woocommerce .footer-main-container .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post-type-icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one-half.gallery2 .portfolio_type_wrapper, .one-third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrapper, .widget_tag_cloud div a:hover, .ui-accordion .ui-accordion-header .ui-icon, .mobile-menu-wrapper #mobile-menu-close.button, .mobile-menu-wrapper #btn-close-mobile-menu, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], .learnpress-page #page-content-wrapper .lp-button, .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], button, .widget_search input#searchsubmit:hover, #wp-calendar caption, #wp-calendar thead th, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_categories .cat-count, .widget_categories .cat-count, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_archive .archive-count, .widget_archive .archive-count, .woocommerce #respond input#submit',
	            'property' => 'background-color',
	        ),
	        array(
	            'element'  => '.pagination span, .pagination a:hover, .button.ghost, .button.ghost:hover, .button.ghost:active, blockquote:after, .woocommerce-MyAccount-navigation ul li.is-active, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], .learnpress-page #page-content-wrapper .lp-button, .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], .widget_search input#searchsubmit:hover',
	            'property' => 'border-color',
	        ),
	        array(
	            'element'  => '.comment_box:before, .comment_box:after',
	            'property' => 'border-top-color',
	        ),
	        array(
	            'element'  => '.button.ghost, .button.ghost:hover, .button.ghost:active, .infinite_load_more, blockquote:before, .woocommerce-MyAccount-navigation ul li.is-active a, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], #page-content-wrapper .inner .sidebar-wrapper .sidebar-widget li.widget_recent_comments ul li.recentcomments a:not(.url)',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer-main-container .button, .woocommerce .footer-main-container .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post-type-icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one-half.gallery2 .portfolio_type_wrapper, .one-third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrapper, .widget_tag_cloud div a:hover, .ui-accordion .ui-accordion-header .ui-icon, .mobile-menu-wrapper #mobile-menu-close.button, .mobile-menu-wrapper #btn-close-mobile-menu, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], .learnpress-page #page-content-wrapper .lp-button, .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], button, .widget_search input#searchsubmit:hover, #wp-calendar caption, #wp-calendar thead th, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_categories .cat-count, .widget_categories .cat-count, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_archive .archive-count, .widget_archive .archive-count, .woocommerce #respond input#submit',
				'function' => 'css',
				'property' => 'background-color',
			),
			array(
				'element'  => '.pagination span, .pagination a:hover, .button.ghost, .button.ghost:hover, .button.ghost:active, blockquote:after, .woocommerce-MyAccount-navigation ul li.is-active, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], .learnpress-page #page-content-wrapper .lp-button, .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], .widget_search input#searchsubmit:hover',
				'function' => 'css',
				'property' => 'border-color',
			),
			array(
				'element'  => '.comment_box:before, .comment_box:after',
				'function' => 'css',
				'property' => 'border-top-color',
			),
			array(
				'element'  => '.button.ghost, .button.ghost:hover, .button.ghost:active, .infinite_load_more, blockquote:before, .woocommerce-MyAccount-navigation ul li.is-active a, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], #page-content-wrapper .inner .sidebar-wrapper .sidebar-widget li.widget_recent_comments ul li.recentcomments a:not(.url)',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 20,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_font_color',
        'label'    => esc_html__('Button Font Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination a:hover, .woocommerce .footer-main-container .button , .woocommerce .footer-main-container .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post-type-icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one-half.gallery2 .portfolio_type_wrapper, .one-third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrapper, .widget_tag_cloud div a:hover, .ui-accordion .ui-accordion-header .ui-icon, .mobile-menu-wrapper #mobile-menu-close.button, #go-to-top, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"],.pagination span.current, .mobile-menu-wrapper #btn-close-mobile-menu, body.learnpress-page #page-content-wrapper .lp-button, .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], button, .widget_search input#searchsubmit:hover, #wp-calendar caption, #wp-calendar thead th, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_categories .cat-count, .widget_categories .cat-count, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_archive .archive-count, .widget_archive .archive-count, .woocommerce #respond input#submit',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer-main-container .button, .woocommerce .footer-main-container .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post-type-icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one-half.gallery2 .portfolio_type_wrapper, .one-third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrapper, .widget_tag_cloud div a:hover, .ui-accordion .ui-accordion-header .ui-icon, .mobile-menu-wrapper #mobile-menu-close.button, #go-to-top, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"],.pagination span.current, .mobile-menu-wrapper #btn-close-mobile-menu, body.learnpress-page #page-content-wrapper .lp-button, .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], button, .widget_search input#searchsubmit:hover, #wp-calendar caption, #wp-calendar thead th, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_categories .cat-count, .widget_categories .cat-count, #page-content-wrapper .sidebar .content .sidebar-widget li.widget_archive .archive-count, .widget_archive .archive-count, .woocommerce #respond input#submit',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 21,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_border_color',
        'label'    => esc_html__('Button Border Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination a:hover, .woocommerce .footer-main-container .button , .woocommerce .footer-main-container .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .infinite_load_more, .widget_tag_cloud div a:hover, .mobile-menu-wrapper #btn-close-mobile-menu, .mobile-menu-wrapper #mobile-menu-close.button, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], button, .woocommerce #respond input#submit',
	            'property' => 'border-color',
	        ),
	        array(
	            'element'  => '#wp-calendar tbody td#today',
	            'property' => 'border-bottom-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=submit], input[type=button], a.button, .button, .pagination span, .pagination a:hover, .woocommerce .footer-main-container .button, .woocommerce .footer-main-container .button:hover, .woocommerce-page div.product form.cart .button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .post-type-icon, .filter li a:hover, .filter li a.active, #portfolio_wall_filters li a.active,  #portfolio_wall_filters li a:hover, .comment_box, .one-half.gallery2 .portfolio_type_wrapper, .one-third.gallery3 .portfolio_type_wrapper, .one_fourth.gallery4 .portfolio_type_wrapper, .one_fifth.gallery5 .portfolio_type_wrapper, .portfolio_type_wrappe, .widget_tag_cloud div a:hover, .mobile-menu-wrapper #btn-close-mobile-menu, .menu-cart-wrapper > a, .ui-accordion .ui-accordion-header .ui-icon, .mobile-menu-wrapper #mobile-menu-close.button, body .ui-dialog[aria-describedby="ajax-login-register-login-dialog"] .form-wrapper input[type="submit"], body .ui-dialog[aria-describedby="ajax-login-register-dialog"] .form-wrapper input[type="submit"], .learnpress-page #learn-press-profile-basic-information button, .learnpress-page #profile-content-settings form button[type=submit], button, .woocommerce #respond input#submit',
				'function' => 'css',
				'property' => 'border-color',
			),
			array(
	            'element'  => '#wp-calendar tbody td#today',
	            'property' => 'border-bottom-color',
	        ),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 22,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_hover_bg_color',
        'label'    => esc_html__('Button Hover Background Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .black_bg input[type=submit], .learnpress-page #page-content-wrapper .lp-button:hover, .learnpress-page #learn-press-profile-basic-information button:hover, .learnpress-page #profile-content-settings form button[type=submit]:hover, .woocommerce #respond input#submit:hover',
	            'property' => 'background-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .black_bg input[type=submit], .learnpress-page #page-content-wrapper .lp-button:hover, .learnpress-page #learn-press-profile-basic-information button:hover, .learnpress-page #profile-content-settings form button[type=submit]:hover, .woocommerce #respond input#submit:hover',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 23,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_hover_font_color',
        'label'    => esc_html__('Button Hover Font Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .black_bg input[type=submit], body.learnpress-page #page-content-wrapper .lp-button:hover, .learnpress-page #learn-press-profile-basic-information button:hover, .learnpress-page #profile-content-settings form button[type=submit]:hover, button:hover, .woocommerce #respond input#submit:hover',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .black_bg input[type=submit], body.learnpress-page #page-content-wrapper .lp-button:hover, .learnpress-page #learn-press-profile-basic-information button:hover, .learnpress-page #profile-content-settings form button[type=submit]:hover, button:hover, .woocommerce #respond input#submit:hover',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 24,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_button_hover_border_color',
        'label'    => esc_html__('Button Hover Border Color', 'avante' ),
        'section'  => 'general_input',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .black_bg input[type=submit], .learnpress-page #learn-press-profile-basic-information button:hover, .learnpress-page #profile-content-settings form button[type=submit]:hover, button:hover, .woocommerce #respond input#submit:hover',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'input[type=button]:hover, input[type=submit]:hover, a.button:hover, .button:hover, .button.submit, a.button.white:hover, .button.white:hover, a.button.white:active, .button.white:active, .black_bg input[type=submit], .learnpress-page #learn-press-profile-basic-information button:hover, .learnpress-page #profile-content-settings form button[type=submit]:hover, button:hover, .woocommerce #respond input#submit:hover',
				'function' => 'css',
				'property' => 'border-color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 25,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_frame',
        'label'    => esc_html__('Enable Frame', 'avante' ),
        'description' => esc_html__('Check this to enable frame for site layout', 'avante' ),
        'section'  => 'general_frame',
        'default'  => 0,
	    'priority' => 26,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_frame_color',
        'label'    => esc_html__('Frame Color', 'avante' ),
        'section'  => 'general_frame',
        'default'  => '#000000',
        'output' => array(
	        array(
	            'element'  => '.frame_top, .frame_bottom, .frame_left, .frame_right',
	            'property' => 'background',
	        ),
	    ),
	    'transport'  => 'postMessage',
	    'priority' => 27,
	    'js_vars'   => array(
			array(
				'element'  => '.frame_top, .frame_bottom, .frame_left, .frame_right',
				'function' => 'css',
				'property' => 'background',
			),
		)
    );
    
    //End General Tab Settings

	//Register Menu Tab Settings
	$controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_header_content_title',
        'label'    => esc_html__('Header Content Settings', 'avante' ),
        'section'  => 'menu_general',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_fixed_menu',
        'label'    => esc_html__('Enable Sticky Header', 'avante' ),
        'description' => esc_html__('Enable this option to display main menu fixed when scrolling', 'avante' ),
        'section'  => 'menu_general',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_header_content',
        'label'    => esc_html__('Display Header Content From', 'avante' ),
        'description' => esc_html__('Select how theme get main header & navigation content', 'avante' ),
        'section'  => 'menu_general',
        'default'  => 'menu',
        'choices'  => $tg_header_content,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_default_header_content_title',
        'label'    => esc_html__('Default Header Content Settings', 'avante' ),
        'section'  => 'menu_general',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_header_content_default',
        'label'    => esc_html__('Default Header Content', 'avante' ),
        'description' => esc_html__('Select default header content for general pages & posts', 'avante' ),
        'section'  => 'menu_general',
        'default'  => '',
        'choices'  => $tg_headers_select,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_sticky_header_content_default',
        'label'    => esc_html__('Default Sticky Header Content', 'avante' ),
        'description' => esc_html__('Select default sticky header content for general pages & posts', 'avante' ),
        'section'  => 'menu_general',
        'default'  => '',
        'choices'  => $tg_headers_select,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_transparent_header_content_default',
        'label'    => esc_html__('Default Transparent Header Content', 'avante' ),
        'description' => esc_html__('Select default transparent header content for general pages & posts', 'avante' ),
        'section'  => 'menu_general',
        'default'  => '',
        'choices'  => $tg_headers_select,
	    'priority' => 1,
    );
	
	$controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_menu_title',
        'label'    => esc_html__('General Menu Settings', 'avante' ),
        'section'  => 'menu_general',
	    'priority' => 1,
    );
	
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_menu_layout',
        'label'    => esc_html__('Menu Layout', 'avante' ),
        'description' => esc_html__('Select main menu layout', 'avante' ),
        'section'  => 'menu_general',
        'default'  => 'leftalign',
        'choices'  => $tg_menu_layout,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_menu_show_cart',
        'label'    => esc_html__('Show Cart Icon (Required Woocommerce plugin)', 'avante' ),
        'description' => esc_html__('Enable this option to show cart icon which link to Woocommerce cart page along with main menu', 'avante' ),
        'section'  => 'menu_general',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_menu_show_client',
        'label'    => esc_html__('Show Client Icon (Required ZM Ajax Login & Register  plugin)', 'avante' ),
        'description' => esc_html__('Enable this option to show client icon which link to client login page along with main menu', 'avante' ),
        'section'  => 'menu_general',
        'default'  => 1,
	    'priority' => 1,
    );
	
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_menu_typography',
        'label'    => esc_html__('Menu Font Typography', 'avante' ),
        'section'  => 'menu_typography',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '16px',
			'line-height'    => '1.7',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li a, #menu-wrapper div .nav li > a, .menu-client-wrapper',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_menu_padding',
        'label'    => esc_html__('Menu Padding', 'avante' ),
        'section'  => 'menu_typography',
        'default'  => 28,
        'choices' => array( 'min' => 0, 'max' => 150, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li, #menu-wrapper div .nav li, html[data-menu=center-menu-logo] #logo-right-wrapper',
	            'property' => 'padding-top',
	            'units'    => 'px',
	        ),
	        array(
	            'element'  => '#menu-wrapper .nav ul li, #menu-wrapper div .nav li, html[data-menu=center-menu-logo] #logo-right-wrapper',
	            'property' => 'padding-bottom',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper .nav ul li, #menu-wrapper div .nav li, html[data-menu=center-menu-logo] #logo-right-wrapper',
				'function' => 'css',
				'property' => 'padding-top',
				'units'    => 'px',
			),
			array(
				'element'  => '#menu-wrapper .nav ul li, #menu-wrapper div .nav li, html[data-menu=center-menu-logo] #logo-right-wrapper',
				'function' => 'css',
				'property' => 'padding-bottom',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_menu_main_colors_title',
        'label'    => esc_html__('Main Menu Colors Settings', 'avante' ),
        'section'  => 'menu_color',
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_bg',
        'label'    => esc_html__('Menu Background', 'avante' ),
        'section'  => 'menu_color',
	    'default'     => '#ffffff',
	    'output' => array(
	        array(
	            'element'  => '.top-menu-bar, html',
	            'property' => 'background-color',
	        ),
	    ),
	    'priority' => 4,
	    'transport' 	 => 'postMessage',
	    'js_vars'   => array(
			array(
				'element'  => '.top-menu-bar, html',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_font_color',
        'label'    => esc_html__('Menu Font Color', 'avante' ),
        'section'  => 'menu_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li a, #menu-wrapper div .nav li > a, #mobile-nav-icon, #logo-wrapper .social-profile-wrapper ul li a, .menu-cart-wrapper a',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#mobile-nav-icon',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 5,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper .nav ul li a, #menu-wrapper div .nav li > a, #mobile-nav-icon, #logo-wrapper .social-profile-wrapper ul li a, .menu-cart-wrapper a',
				'function' => 'css',
				'property' => 'color',
			),
			array(
				'element'  => '#mobile-nav-icon',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_hover_font_color',
        'label'    => esc_html__('Menu Hover State Font Color', 'avante' ),
        'section'  => 'menu_color',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li a.hover, #menu-wrapper .nav ul li a:hover, #menu-wrapper div .nav li a.hover, #menu-wrapper div .nav li a:hover, .menu-cart-wrapper a:hover, #page_share:hover, #logo-wrapper .social-profile-wrapper ul li a:hover',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#menu-wrapper .nav ul li a:before, #menu-wrapper div .nav li > a:before',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 6,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper .nav ul li a.hover, #menu-wrapper .nav ul li a:hover, #menu-wrapper div .nav li a.hover, #menu-wrapper div .nav li a:hover, .menu-cart-wrapper a:hover, #page_share:hover, #logo-wrapper .social-profile-wrapper ul li a:hover',
				'function' => 'css',
				'property' => 'color',
			),
			array(
	            'element'  => '#menu-wrapper .nav ul li a:before, #menu-wrapper div .nav li > a:before',
	            'property' => 'background-color',
	        ),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_active_font_color',
        'label'    => esc_html__('Menu Active State Font Color', 'avante' ),
        'section'  => 'menu_color',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper div .nav > li.current-menu-item > a, #menu-wrapper div .nav > li.current-menu-parent > a, #menu-wrapper div .nav > li.current-menu-ancestor > a, #menu-wrapper div .nav li ul:not(.sub-menu) li.current-menu-item a, #menu-wrapper div .nav li.current-menu-parent  ul li.current-menu-item a, #logo-wrapper .social-profile-wrapper ul li a:active',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper div .nav > li.current-menu-item > a, #menu-wrapper div .nav > li.current-menu-parent > a, #menu-wrapper div .nav > li.current-menu-ancestor > a, #menu-wrapper div .nav li ul:not(.sub-menu) li.current-menu-item a, #menu-wrapper div .nav li.current-menu-parent  ul li.current-menu-item a, #logo-wrapper .social-profile-wrapper ul li a:active',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_border_color',
        'label'    => esc_html__('Menu Bar Border Color', 'avante' ),
        'section'  => 'menu_color',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '.top-menu-bar, #nav-wrapper',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
	    'js_vars'   => array(
			array(
				'element'  => '.top-menu-bar, #nav-wrapper',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_menu_icon_colors_title',
        'label'    => esc_html__('Icon Colors Settings', 'avante' ),
        'section'  => 'menu_color',
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_cart_bg',
        'label'    => esc_html__('Cart Counter Background', 'avante' ),
        'section'  => 'menu_color',
	    'default'     => '#57B957',
	    'output' => array(
	        array(
	            'element'  => '.menu-cart-wrapper .cart-counter',
	            'property' => 'background-color',
	        ),
	    ),
	    'priority' => 8,
	    'transport' 	 => 'postMessage',
	    'js_vars'   => array(
			array(
				'element'  => '.menu-cart-wrapper .cart-counter',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_menu_cart_font_color',
        'label'    => esc_html__('Cart Counter Font Color', 'avante' ),
        'section'  => 'menu_color',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '.menu-cart-wrapper .cart-counter',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 8,
	    'js_vars'   => array(
			array(
				'element'  => '.menu-cart-wrapper .cart-counter',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_submenu_font_title',
        'label'    => esc_html__('Typography Settings', 'avante' ),
        'section'  => 'menu_submenu',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_submenu_typography',
        'label'    => esc_html__('Sub Menu Typography', 'avante' ),
        'section'  => 'menu_submenu',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '15px',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li ul li a, #menu-wrapper div .nav li ul li a, #menu-wrapper div .nav li.current-menu-parent ul li a',
	        ),
	    ),
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_submenu_color_title',
        'label'    => esc_html__('Color Settings', 'avante' ),
        'section'  => 'menu_submenu',
	    'priority' => 12,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_font_color',
        'label'    => esc_html__('Sub Menu Font Color', 'avante' ),
        'section'  => 'menu_submenu',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li ul li a, #menu-wrapper div .nav li ul li a, #menu-wrapper div .nav li.current-menu-parent ul li a, #menu-wrapper div .nav li.current-menu-parent ul li.current-menu-item a, #menu-wrapper .nav ul li.megamenu ul li ul li a, #menu-wrapper div .nav li.megamenu ul li ul li a',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper .nav ul li ul li a, #menu-wrapper div .nav li ul li a, #menu-wrapper div .nav li.current-menu-parent ul li a, #menu-wrapper div .nav li.current-menu-parent ul li.current-menu-item a, #menu-wrapper .nav ul li.megamenu ul li ul li a, #menu-wrapper div .nav li.megamenu ul li ul li a',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_hover_font_color',
        'label'    => esc_html__('Sub Menu Hover State Font Color', 'avante' ),
        'section'  => 'menu_submenu',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li ul li a:hover, #menu-wrapper div .nav li ul li a:hover, #menu-wrapper div .nav li.current-menu-parent ul li a:hover, #menu-wrapper .nav ul li.megamenu ul li ul li a:hover, #menu-wrapper div .nav li.megamenu ul li ul li a:hover, #menu-wrapper .nav ul li.megamenu ul li ul li a:active, #menu-wrapper div .nav li.megamenu ul li ul li a:active, #menu-wrapper div .nav li.current-menu-parent ul li.current-menu-item  a:hover',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#menu-wrapper .nav ul li ul li a:before, #menu-wrapper div .nav li ul li > a:before, #wrapper.transparent .top-menu-bar:not(.scroll) #menu-wrapper div .nav ul li ul li a:before',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 14,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper .nav ul li ul li a:hover, #menu-wrapper div .nav li ul li a:hover, #menu-wrapper div .nav li.current-menu-parent ul li a:hover, #menu-wrapper .nav ul li.megamenu ul li ul li a:hover, #menu-wrapper div .nav li.megamenu ul li ul li a:hover, #menu-wrapper .nav ul li.megamenu ul li ul li a:active, #menu-wrapper div .nav li.megamenu ul li ul li a:active, #menu-wrapper div .nav li.current-menu-parent ul li.current-menu-item  a:hover',
				'function' => 'css',
				'property' => 'color',
			),
			array(
	            'element'  => '#menu-wrapper .nav ul li ul li a:before, #menu-wrapper div .nav li ul li > a:before, #wrapper.transparent .top-menu-bar:not(.scroll) #menu-wrapper div .nav ul li ul li a:before',
	            'property' => 'background-color',
	        ),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_bg_color',
        'label'    => esc_html__('Sub Menu Background Color', 'avante' ),
        'section'  => 'menu_submenu',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li ul, #menu-wrapper div .nav li ul',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 16,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper .nav ul li ul, #menu-wrapper div .nav li ul',
				'function' => 'css',
				'property' => 'background',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_submenu_border_color',
        'label'    => esc_html__('Sub Menu Border Color', 'avante' ),
        'section'  => 'menu_submenu',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper .nav ul li ul, #menu-wrapper div .nav li ul',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 17,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper .nav ul li ul, #menu-wrapper div .nav li ul',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_megamenu_header_color',
        'label'    => esc_html__('Mega Menu Header Font Color', 'avante' ),
        'section'  => 'menu_megamenu',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper div .nav li.megamenu ul li > a, #menu-wrapper div .nav li.megamenu ul li > a:hover, #menu-wrapper div .nav li.megamenu ul li > a:active, #menu-wrapper div .nav li.megamenu ul li.current-menu-item > a',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 18,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper div .nav li.megamenu ul li > a, #menu-wrapper div .nav li.megamenu ul li > a:hover, #menu-wrapper div .nav li.megamenu ul li > a:active, #menu-wrapper div .nav li.megamenu ul li.current-menu-item > a',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_megamenu_border_color',
        'label'    => esc_html__('Mega Menu Border Color', 'avante' ),
        'section'  => 'menu_megamenu',
        'default'  => '#D8D8D8',
        'output' => array(
	        array(
	            'element'  => '#menu-wrapper div .nav li.megamenu ul li',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 20,
	    'js_vars'   => array(
			array(
				'element'  => '#menu-wrapper div .nav li.megamenu ul li',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_topbar',
        'label'    => esc_html__('Display Top Bar', 'avante' ),
        'description' => esc_html__('Enable this option to display top bar above main menu', 'avante' ),
        'section'  => 'menu_topbar',
        'default'  => 0,
	    'priority' => 21,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_topbar_bg_color',
        'label'    => esc_html__('Top Bar Background Color', 'avante' ),
        'section'  => 'menu_topbar',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '.above-top-menu-bar',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 22,
	    'js_vars'   => array(
			array(
				'element'  => '.above-top-menu-bar',
				'function' => 'css',
				'property' => 'background',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_topbar_font_color',
        'label'    => esc_html__('Top Bar Menu Font Color', 'avante' ),
        'section'  => 'menu_topbar',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#top-menu li a, .top-contact-info, .top-contact-info i, .top-contact-info a, .top-contact-info a:hover, .top-contact-info a:active',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 23,
	    'js_vars'   => array(
			array(
				'element'  => '#top-menu li a, .top-contact-info, .top-contact-info i, .top-contact-info a, .top-contact-info a:hover, .top-contact-info a:active',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_menu_contact_hours',
        'label'    => esc_html__('Contact Hours (Optional)', 'avante' ),
        'description' => esc_html__('Enter your company contact hours.', 'avante' ),
        'section'  => 'menu_contact',
        'default'  => 'Mon-Fri 09.00 - 17.00',
        'transport' 	 => 'postMessage',
	    'priority' => 26,
    );
    
    $controls[] = array(
        'type'     => 'text',
        'settings'  => 'tg_menu_contact_number',
        'label'    => esc_html__('Contact Phone Number (Optional)', 'avante' ),
        'description' => esc_html__('Enter your company contact phone number.', 'avante' ),
        'section'  => 'menu_contact',
        'default'  => '1.800.456.6743',
        'transport' => 'postMessage',
	    'priority' => 27,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_topbar_social_link',
        'label'    => esc_html__('Open Top Bar Social Icons link in new window', 'avante' ),
        'description' => esc_html__('Check this to open top bar social icons link in new window', 'avante' ),
        'section'  => 'menu_contact',
        'default'  => 1,
	    'priority' => 28,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_sidemenu',
        'label'    => esc_html__('Enable Side Menu on Desktop', 'avante' ),
        'description' => 'Check this option to enable side menu on desktop',
        'section'  => 'menu_sidemenu',
        'default'  => 0,
	    'priority' => 31,
    );
    
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_sidemenu_close',
        'label'    => esc_html__('Display Close Menu Button', 'avante' ),
        'description' => 'Check this option to display close menu button when side menu is opened',
        'section'  => 'menu_sidemenu',
        'default'  => 0,
	    'priority' => 31,
    );
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_sidemenu_font_title',
        'label'    => esc_html__('Typography Settings', 'avante' ),
        'section'  => 'menu_sidemenu',
	    'priority' => 31,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_sidemenu_typography',
        'label'    => esc_html__('Side Menu Typography', 'avante' ),
        'section'  => 'menu_sidemenu',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '18px',
			'line-height'    => '2',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => '.mobile-main-nav li a, #side-sub-menu li a',
	        ),
	    ),
	    'priority' => 32
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_side_submenu_typography',
        'label'    => esc_html__('Side Sub Menu Typography', 'avante' ),
        'section'  => 'menu_sidemenu',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '18px',
			'line-height'    => '2',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => '#side-sub-menu li a',
	        ),
	    ),
	    'priority' => 32
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_sidemenu_bg_title',
        'label'    => esc_html__('Color Settings', 'avante' ),
        'section'  => 'menu_sidemenu',
	    'priority' => 36,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidemenu_bg',
        'label'    => esc_html__('Side Menu Background', 'avante' ),
        'section'  => 'menu_sidemenu',
	    'default'  => '#ffffff',
	    'output' => array(
	        array(
	            'element'  => '.mobile-menu-wrapper',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'js_vars'   => array(
			array(
	            'element'  => '.mobile-menu-wrapper',
	            'property' => 'background-color',
	        ),
		),
	    'priority' => 36,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidemenu_font_color',
        'label'    => esc_html__('Side Menu Font Color', 'avante' ),
        'section'  => 'menu_sidemenu',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '.mobile-main-nav li a, #side-sub-menu li a, .mobile-menu-wrapper .sidebar-wrapper a, .mobile-menu-wrapper .sidebar-wrapper, #btn-close-mobile-menu i, .mobile-menu-wrapper .social-profile-wrapper ul li a, .fullmenu_content #copyright, .mobile-menu-wrapper .sidebar-wrapper h2.widgettitle',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 37,
	    'js_vars'   => array(
			array(
				'element'  => '.mobile-main-nav li a, #side-sub-menu li a, .mobile-menu-wrapper .sidebar-wrapper a, .mobile-menu-wrapper .sidebar-wrapper, #btn-close-mobile-menu i, .mobile-menu-wrapper .social-profile-wrapper ul li a, .fullmenu_content #copyright, .mobile-menu-wrapper .sidebar-wrapper h2.widgettitle',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidemenu_font_hover_color',
        'label'    => esc_html__('Side Menu Hover State Font Color', 'avante' ),
        'section'  => 'menu_sidemenu',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '.mobile-main-nav li a:hover, .mobile-main-nav li a:active, #side-sub-menu li a:hover, #side-sub-menu li a:active, .mobile-menu-wrapper .social-profile-wrapper ul li a:hover',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 38,
	    'js_vars'   => array(
			array(
				'element'  => '.mobile-main-nav li a:hover, .mobile-main-nav li a:active, #side-sub-menu li a:hover, #side-sub-menu li a:active, .mobile-menu-wrapper .social-profile-wrapper ul li a:hover',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    //End Menu Tab Settings
    
    //Register Header Tab Settings
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_page_header_bg_title',
        'label'    => esc_html__('Background Image Settings', 'avante' ),
        'section'  => 'header_background',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_bg_height',
        'label'    => esc_html__('Page Title Background Image Height (in px)', 'avante' ),
        'section'  => 'header_background',
        'default'  => 600,
        'choices' => array( 'min' => 100, 'max' => 1000, 'step' => 5 ),
        'output' => array(
	        array(
	            'element'  => '#page-header.hasbg',
	            'property' => 'height',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
	    'js_vars'   => array(
			array(
				'element'  => '#page-header.hasbg',
				'function' => 'css',
				'property' => 'height',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_title_bg_overlay',
        'label'    => esc_html__('Page Title Background Image Overlay Opacity (in %)', 'avante' ),
        'section'  => 'header_background',
        'default'  => 30,
        'choices' => array( 'min' => 10, 'max' => 100, 'step' => 5 ),
	    'priority' => 1
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_page_header_bgcolor_title',
        'label'    => esc_html__('Background Color Settings', 'avante' ),
        'section'  => 'header_background',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_page_header_bg_color',
        'label'    => esc_html__('Page Header Background Color', 'avante' ),
        'section'  => 'header_background',
        'default'  => '#f9f9f9',
        'output' => array(
	        array(
	            'element'  => '#page-header',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
	    'js_vars'   => array(
			array(
				'element'  => '#page-header',
				'function' => 'css',
				'property' => 'background-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_page_title_font_alignment',
        'label'    => esc_html__('Page Title Alignment', 'avante' ),
        'description' => esc_html__('Select alignment for page title', 'avante' ),
        'section'  => 'header_title',
        'default'  => 'center',
        'choices'  => $tg_text_alignment,
        'output' => array(
	        array(
	            'element'  => '#page-header .page-title-wrapper .page-title-inner',
	            'property' => 'text-align',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '#page-header .page-title-wrapper .page-title-inner',
				'function' => 'css',
				'property' => 'text-align',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_header_padding_top',
        'label'    => esc_html__('Page Header Padding Top', 'avante' ),
        'section'  => 'header_title',
        'default'  => 60,
        'choices' => array( 'min' => 0, 'max' => 200, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page-header',
	            'property' => 'padding-top',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 3,
	    'js_vars'   => array(
			array(
				'element'  => '#page-header',
				'function' => 'css',
				'property' => 'padding-top',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_header_padding_bottom',
        'label'    => esc_html__('Page Header Padding Bottom', 'avante' ),
        'section'  => 'header_title',
        'default'  => 60,
        'choices' => array( 'min' => 0, 'max' => 200, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page-header',
	            'property' => 'padding-bottom',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
	    'js_vars'   => array(
			array(
				'element'  => '#page-header',
				'function' => 'css',
				'property' => 'padding-bottom',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_page_header_marging_bottom',
        'label'    => esc_html__('Page Header Margin Bottom', 'avante' ),
        'section'  => 'header_title',
        'default'  => 45,
        'choices' => array( 'min' => 0, 'max' => 200, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#page-header',
	            'property' => 'margin-bottom',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
	    'js_vars'   => array(
			array(
				'element'  => '#page-header',
				'function' => 'css',
				'property' => 'margin-bottom',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_page_title_typography',
        'label'    => esc_html__('Page Title Typography', 'avante' ),
        'section'  => 'header_title',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '45px',
			'line-height'    => '1.2',
			'letter-spacing' => '0',
			'text-transform' => 'none',
			'color'			 => '#181B31',
		),
        'output' => array(
	        array(
	            'element'  => '#page-header h1',
	        ),
	    ),
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_page_tagline_typography',
        'label'    => esc_html__('Page Tagline Typography', 'avante' ),
        'section'  => 'header_tagline',
        'default'  => array(
			'font-family'    => 'Roboto',
			'variant'        => '500',
			'font-size'      => '14px',
			'letter-spacing' => '0',
			'text-transform' => 'none',
			'color'			 => '#7E8090',
		),
        'output' => array(
	        array(
	            'element'  => '.page-tagline, .post-detail.single-post',
	        ),
	    ),
	    'priority' => 6,
    );
    //End Header Tab Settings
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_sidebar_sticky',
        'label'    => esc_html__('Enable Sticky Sidebar', 'avante' ),
        'description' => esc_html__('Check this to displays sidebar fixed when scrolling.', 'avante' ),
        'section'  => 'sidebar_general',
        'default'  => 1,
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_sidebar_title_typography',
        'label'    => esc_html__('Widget Title Typography', 'avante' ),
        'section'  => 'sidebar_typography',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '13px',
			'letter-spacing' => '2px',
			'text-transform' => 'uppercase',
		),
        'output' => array(
	        array(
	            'element'  => '#page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 1,
    );
        
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_font_color',
        'label'    => esc_html__('Sidebar Font Color', 'avante' ),
        'section'  => 'sidebar_color',
        'default'  => '#7E8090',
        'output' => array(
	        array(
	            'element'  => '#page-content-wrapper .inner .sidebar-wrapper .sidebar .content, .page-content-wrapper .inner .sidebar-wrapper .sidebar .content',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 6,
	    'js_vars'   => array(
			array(
				'element'  => '#page-content-wrapper .inner .sidebar-wrapper .sidebar .content, .page-content-wrapper .inner .sidebar-wrapper .sidebar .content',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_link_color',
        'label'    => esc_html__('Sidebar Link Color', 'avante' ),
        'section'  => 'sidebar_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#page-content-wrapper .inner .sidebar-wrapper a:not(.button), .page-content-wrapper .inner .sidebar-wrapper a:not(.button)',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.widget_nav_menu ul > li.menu-item-has-children > a:after',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 7,
	    'js_vars'   => array(
			array(
				'element'  => '#page-content-wrapper .inner .sidebar-wrapper a:not(.button), .page-content-wrapper .inner .sidebar-wrapper a:not(.button)',
				'function' => 'css',
				'property' => 'color',
			),
			array(
				'element'  => '.widget_nav_menu ul > li.menu-item-has-children > a:after',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_hover_link_color',
        'label'    => esc_html__('Sidebar Hover Link Color', 'avante' ),
        'section'  => 'sidebar_color',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '#page-content-wrapper .inner .sidebar-wrapper a:hover:not(.button), #page-content-wrapper .inner .sidebar-wrapper a:active:not(.button), .page-content-wrapper .inner .sidebar-wrapper a:hover:not(.button), .page-content-wrapper .inner .sidebar-wrapper a:active:not(.button)',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 8,
	    'js_vars'   => array(
			array(
				'element'  => '#page-content-wrapper .inner .sidebar-wrapper a:hover:not(.button), #page-content-wrapper .inner .sidebar-wrapper a:active:not(.button), .page-content-wrapper .inner .sidebar-wrapper a:hover:not(.button), .page-content-wrapper .inner .sidebar-wrapper a:active:not(.button)',
				'function' => 'css',
				'property' => 'color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_sidebar_title_color',
        'label'    => esc_html__('Sidebar Widget Title Font Color', 'avante' ),
        'section'  => 'sidebar_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
	            'property' => 'border-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
	    'js_vars'   => array(
			array(
				'element'  => '#page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
				'function' => 'css',
				'property' => 'color',
			),
			array(
				'element'  => '#page-content-wrapper .sidebar .content .sidebar-widget li h2.widgettitle, h2.widgettitle, h5.widgettitle',
				'function' => 'css',
				'property' => 'border-color',
			),
		)
    );
    //End Sidebar Tab Settings
    
    //Register Footer Tab Settings
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_footer_content_title',
        'label'    => esc_html__('Footer Content Settings', 'avante' ),
        'section'  => 'footer_general',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_footer_content',
        'label'    => esc_html__('Display Footer Content From', 'avante' ),
        'description' => esc_html__('Select how theme get main footer content', 'avante' ),
        'section'  => 'footer_general',
        'default'  => 'sidebar',
        'choices'  => $tg_footer_content,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_footer_content_default',
        'label'    => esc_html__('Default Footer Content', 'avante' ),
        'description' => esc_html__('Select default footer content for general pages & posts', 'avante' ),
        'section'  => 'footer_general',
        'default'  => '',
        'choices'  => $tg_footers_select,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_footer_sidebar_title',
        'label'    => esc_html__('Footer Sidebar Settings', 'avante' ),
        'section'  => 'footer_general',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_footer_sidebar',
        'label'    => esc_html__('Footer Sidebar Columns', 'avante' ),
        'section'  => 'footer_general',
        'default'  => '3',
        'choices'  => $tg_copyright_column,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_footer_font_size',
        'label'    => esc_html__('Footer Font Size', 'avante' ),
        'section'  => 'footer_general',
        'default'  => 15,
        'choices' => array( 'min' => 10, 'max' => 30, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '#footer',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 10,
	    'js_vars'   => array(
			array(
				'element'  => '#footer',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'slider',
        'settings'  => 'tg_copyright_font_size',
        'label'    => esc_html__('Copyright Font Size', 'avante' ),
        'section'  => 'footer_general',
        'default'  => 13,
        'choices' => array( 'min' => 10, 'max' => 30, 'step' => 1 ),
        'output' => array(
	        array(
	            'element'  => '.footer-main-container-wrapper',
	            'property' => 'font-size',
	            'units'    => 'px',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 10,
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container-wrapper',
				'function' => 'css',
				'property' => 'font-size',
				'units'    => 'px',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_footer_social_link',
        'label'    => esc_html__('Open Footer Social Icons link in new window', 'avante' ),
        'description' => esc_html__('Check this to open footer social icons link in new window', 'avante' ),
        'section'  => 'footer_general',
        'default'  => 1,
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_footer_effect_title',
        'label'    => esc_html__('Footer Effect Settings', 'avante' ),
        'section'  => 'footer_general',
	    'priority' => 12,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_footer_reveal',
        'label'    => esc_html__('Enable reveal effect for footer', 'avante' ),
        'description' => esc_html__('Check this to enable reveal effect for footer content', 'avante' ),
        'section'  => 'footer_general',
        'default'  => 0,
	    'priority' => 12,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_footer_colors_title',
        'label'    => esc_html__('Footer Colors Settings', 'avante' ),
        'section'  => 'footer_color',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_bg',
        'label'    => esc_html__('Footer Background', 'avante' ),
        'section'  => 'footer_color',
	    'priority' => 1,
	    'default'  => '#ffffff',
	    'output' => array(
	        array(
	            'element'  => '.footer-main-container, #footer',
	            'property' => 'background-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container, #footer, #footer input[type=text], #footer input[type=password], #footer input[type=email], #footer input[type=url], #footer input[type=tel], #footer input[type=date], #footer textarea, #footer select, #footer_photostream',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_font_color',
        'label'    => esc_html__('Footer Font Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#7E8090',
        'output' => array(
	        array(
	            'element'  => '#footer, #copyright, #footer-menu li a, #footer-menu li a:hover, #footer-menu li a:active, #footer input[type=text], #footer input[type=password], #footer input[type=email], #footer input[type=url], #footer input[type=tel], #footer input[type=date], #footer textarea, #footer blockquote',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 10,
	    'js_vars'   => array(
			array(
				'element'  => '#footer, #copyright, #footer-menu li a, #footer-menu li a:hover, #footer-menu li a:active, #footer input[type=text], #footer input[type=password], #footer input[type=email], #footer input[type=url], #footer input[type=tel], #footer input[type=date], #footer textarea, #footer blockquote',
				'function' => 'css',
				'property' => 'color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_link_color',
        'label'    => esc_html__('Footer Link Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#copyright a, #copyright a:active, #footer a, #footer a:active#footer_photostream a',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '#footer .sidebar-widget li h2.widgettitle',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '#copyright a, #copyright a:active, #footer a, #footer a:active, #footer_photostream a',
				'function' => 'css',
				'property' => 'color',
			),
			array(
	            'element'  => '#footer .sidebar-widget li h2.widgettitle',
	            'function' => 'css',
	            'property' => 'border-color',
	        ),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_hover_link_color',
        'label'    => esc_html__('Footer Hover Link Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '#copyright a:hover, #footer a:hover, .social-profile-wrapper ul li a:hover, #footer a:hover, #footer_photostream a:hover',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 12,
	    'js_vars'   => array(
			array(
				'element'  => '#copyright a:hover, #footer a:hover, .social-profile-wrapper ul li a:hover, #footer-wrapper a:hover, #footer_photostream a:hover',
				'function' => 'css',
				'property' => 'color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_border_color',
        'label'    => esc_html__('Footer Border Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#D8D8D8',
        'output' => array(
	        array(
	            'element'  => '#footer table tr td, #footer .widget_tag_cloud div a',
	            'property' => 'border-color',
	        ),
	        array(
	            'element'  => '#footer table tbody tr:nth-child(even) ',
	            'property' => 'background',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 10,
	    'js_vars'   => array(
			array(
				'element'  => '#footer table tr td, #footer .widget_tag_cloud div a',
				'function' => 'css',
				'property' => 'border-color',
			),
			array(
				'element'  => '#footer table tbody tr:nth-child(even) ',
				'function' => 'css',
				'property' => 'background',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_widget_title_color',
        'label'    => esc_html__('Footer Widget Title Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '#footer .sidebar-widget li h2.widgettitle',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '#footer .sidebar-widget li h2.widgettitle',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 11,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_copyright_colors_title',
        'label'    => esc_html__('Copyright Colors Settings', 'avante' ),
        'section'  => 'footer_color',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_copyright_bg',
        'label'    => esc_html__('Copyright Background', 'avante' ),
        'section'  => 'footer_color',
	    'priority' => 13,
	    'default'  => '#ffffff',
	    'output' => array(
	        array(
	            'element'  => '.footer-main-container',
	            'property' => 'background-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container',
				'function' => 'css',
				'property' => 'background-color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_copyright_font_color',
        'label'    => esc_html__('Copyright Font Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '.footer-main-container, #copyright ',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container, #copyright ',
				'function' => 'css',
				'property' => 'color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_copyright_link_color',
        'label'    => esc_html__('Copyright Link Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '.footer-main-container a, #copyright a, #footer-menu li a',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container a, #copyright a, #footer-menu li a',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_copyright_hover_link_color',
        'label'    => esc_html__('Copyright Hover Link Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '.footer-main-container a:hover, #copyright a:hover, #footer-menu li a:hover',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container a:hover, #copyright a:hover, #footer-menu li a:hover',
				'function' => 'css',
				'property' => 'color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_copyright_border_color',
        'label'    => esc_html__('Copyright Border Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#D8D8D8',
        'output' => array(
	        array(
	            'element'  => '.footer-main-container-wrapper, .footer-main-container',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container-wrapper, .footer-main-container',
				'function' => 'css',
				'property' => 'border-color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_social_color',
        'label'    => esc_html__('Copyright Social Icon Color', 'avante' ),
        'section'  => 'footer_color',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '.footer-main-container-wrapper .social-profile-wrapper ul li a',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
	    'js_vars'   => array(
			array(
				'element'  => '.footer-main-container-wrapper .social-profile-wrapper ul li a',
				'function' => 'css',
				'property' => 'color',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_footer_copyright_title',
        'label'    => esc_html__('Copyright Content Settings', 'avante' ),
        'section'  => 'footer_copyright',
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'textarea',
        'settings'  => 'tg_footer_copyright_text',
        'label'    => esc_html__('Copyright Text', 'avante' ),
        'description' => esc_html__('Enter your copyright text.', 'avante' ),
        'section'  => 'footer_copyright',
        'default'  => '© Copyright Avante Theme Demo - Theme by ThemeGoods',
        'transport' 	 => 'postMessage',
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'select',
        'settings'  => 'tg_footer_copyright_right_area',
        'label'    => esc_html__('Copyright Right Area Content', 'avante' ),
        'section'  => 'footer_copyright',
        'default'  => 'menu',
        'choices'  => $tg_copyright_content,
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_footer_copyright_totop_title',
        'label'    => esc_html__('Go To Top Settings', 'avante' ),
        'section'  => 'footer_copyright',
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_footer_copyright_totop',
        'label'    => esc_html__('Go To Top Button', 'avante' ),
        'description' => 'Check this option to enable go to top button at the bottom of page when scrolling',
        'section'  => 'footer_copyright',
        'default'  => 1,
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_copyright_totop_bg',
        'label'    => esc_html__('Go To Top Button Background', 'avante' ),
        'section'  => 'footer_copyright',
	    'priority' => 13,
	    'default'  => 'rgba(0,0,0,0.1)',
	    'output' => array(
	        array(
	            'element'  => 'a#go-to-top',
	            'property' => 'background',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'a#go-to-top',
				'function' => 'css',
				'property' => 'background',
			),
		),
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_footer_copyright_totop_font_color',
        'label'    => esc_html__('Go To Top Button Font Color', 'avante' ),
        'section'  => 'footer_copyright',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'a#go-to-top',
	            'property' => 'color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 13,
	    'js_vars'   => array(
			array(
				'element'  => 'a#go-to-top',
				'function' => 'css',
				'property' => 'color',
			),
		),
    );
    //End Footer Tab Settings

    
    //Begin Blog Tab Settings
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_full',
        'label'    => esc_html__('Display Full Blog Post Content', 'avante' ),
        'description' => esc_html__('Check this option to display post full content in blog page (excerpt blog grid layout)', 'avante' ),
        'section'  => 'blog_general',
        'default'  => 1,
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_blog_archive_layout',
        'label'    => esc_html__('Archive Page Layout', 'avante' ),
        'description' => esc_html__('Select page layout for displaying archive page', 'avante' ),
        'section'  => 'blog_general',
        'default'  => 'blog-r',
        'choices'  => $tg_blog_layout,
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_blog_category_layout',
        'label'    => esc_html__('Category Page Layout', 'avante' ),
        'description' => esc_html__('Select page layout for displaying category page', 'avante' ),
        'section'  => 'blog_general',
        'default'  => 'blog-r',
        'choices'  => $tg_blog_layout,
	    'priority' => 2,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_blog_tag_layout',
        'label'    => esc_html__('Tag Page Layout', 'avante' ),
        'description' => esc_html__('Select page layout for displaying tag page', 'avante' ),
        'section'  => 'blog_general',
        'default'  => 'blog-r',
        'choices'  => $tg_blog_layout,
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'radio',
        'settings'  => 'tg_blog_tag_layout',
        'label'    => esc_html__('Tag Page Layout', 'avante' ),
        'description' => esc_html__('Select page layout for displaying tag page', 'avante' ),
        'section'  => 'blog_general',
        'default'  => 'blog_r',
        'choices'  => $tg_blog_layout,
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_blog_content_bg_color',
        'label'    => esc_html__('Single Post Content Background Color', 'avante' ),
        'section'  => 'blog_general',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '#page-content-wrapper.blog-wrapper, .post-excerpt.post-tag a:after, .post-excerpt.post-tag a:before, .post-navigation .navigation-post-content',
	            'property' => 'background-color',
	        ),
	    ),
	    'transport' 	 => 'postMessage',
	    'priority' => 3,
	    'js_vars'   => array(
			array(
				'element'  => '#page-content-wrapper.blog-wrapper, .post-excerpt.post-tag a:after, .post-excerpt.post-tag a:before, .post-navigation .navigation-post-content',
				'function' => 'css',
				'property' => 'background-color',
			),
		)
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_blog_cat_font_color',
        'label'    => esc_html__('Post Category Link Font Color', 'avante' ),
        'section'  => 'blog_general',
        'default'  => '#57B957',
        'output' => array(
	        array(
	            'element'  => '.post-info-cat, .post-info-cat a',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.post-info-cat, .post-info-cat a',
	            'property' => 'border-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.post-info-cat, .post-info-cat a',
				'function' => 'css',
				'property' => 'color',
			),
			array(
				'element'  => '.post-info-cat, .post-info-cat a',
				'function' => 'css',
				'property' => 'border-color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 3,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_blog_post_format_bg_color',
        'label'    => esc_html__('Post Format Background Color', 'avante' ),
        'section'  => 'blog_general',
        'default'  => '#181B31',
        'output' => array(
	        array(
	            'element'  => '.post-featured-image-hover .post-type-icon',
	            'property' => 'background',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.post-featured-image-hover .post-type-icon',
				'function' => 'css',
				'property' => 'background',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_blog_grid_content_bg_color',
        'label'    => esc_html__('Post Grid Content Background Color', 'avante' ),
        'section'  => 'blog_general',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => '.blog_post-content-wrapper.layout_grid .post-content-wrapper, .blog_post-content-wrapper.layout_masonry .post-content-wrapper, .blog_post-content-wrapper.layout_metro .post-content-wrapper, .blog_post-content-wrapper.layout_classic .post-content-wrapper',
	            'property' => 'background',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.blog_post-content-wrapper.layout_grid .post-content-wrapper, .blog_post-content-wrapper.layout_masonry .post-content-wrapper, .blog_post-content-wrapper.layout_metro .post-content-wrapper, .blog_post-content-wrapper.layout_classic .post-content-wrapper',
				'function' => 'css',
				'property' => 'background',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 4,
    );
    
    $controls[] = array(
        'type'     => 'title',
        'settings'  => 'tg_blog_general_title',
        'label'    => esc_html__('General Post Title Settings', 'avante' ),
        'section'  => 'blog_typography',
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_blog_title_typography',
        'label'    => esc_html__('Post Title Typography', 'avante' ),
        'section'  => 'blog_typography',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'letter-spacing' => '0px',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => '.post-header h5, h6.subtitle, .post-caption h1, #page-content-wrapper .posts.blog li a, .page-content-wrapper .posts.blog li a, #post_featured_slider li .slider_image .slide_post h2, .post-header.grid h6, .sidebar-widget li.widget_recent_comments ul li.recentcomments a:not(.url), #page-content-wrapper .sidebar .content .sidebar-widget li.widget_rss ul li a.rsswidget, #footer-wrapper ul.sidebar-widget li.widget_rss ul li a.rsswidget',
	        ),
	    ),
	    'priority' => 1,
    );
    
    $controls[] = array(
        'type'     => 'typography',
        'settings'  => 'tg_single_blog_title_typography',
        'label'    => esc_html__('Singe Post Title Typography', 'avante' ),
        'section'  => 'header_title',
        'default'  => array(
			'font-family'    => 'Cabin',
			'variant'        => '700',
			'font-size'      => '40px',
			'line-height'    => '1.3',
			'letter-spacing' => '0',
			'text-transform' => 'none',
		),
        'output' => array(
	        array(
	            'element'  => 'body.single-post #page-header h1',
	        ),
	    ),
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_feat_content',
        'label'    => esc_html__('Display Post Featured Content', 'avante' ),
        'description' => esc_html__('Check this to display featured header image in single post page', 'avante' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_cat',
        'label'    => esc_html__('Display Post Categories', 'avante' ),
        'description' => esc_html__('Check this to display categories in single post page', 'avante' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_date',
        'label'    => esc_html__('Display Post Date', 'avante' ),
        'description' => esc_html__('Check this to display date in single post page', 'avante' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 5,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_tags',
        'label'    => esc_html__('Display Post Tags', 'avante' ),
        'description' => esc_html__('Check this option to display post tags on single post page', 'avante' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 6,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_author',
        'label'    => esc_html__('Display About Author', 'avante' ),
        'description' => esc_html__('Check this option to display about author on single post page', 'avante' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 7,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_related',
        'label'    => esc_html__('Display Related Posts', 'avante' ),
        'description' => esc_html__('Check this option to display related posts on single post page', 'avante' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'toggle',
        'settings'  => 'tg_blog_display_navigation',
        'label'    => esc_html__('Display Previous/Next Navigation', 'avante' ),
        'description' => esc_html__('Check this option to display previous/next navigation on single post page', 'avante' ),
        'section'  => 'blog_single',
        'default'  => 1,
	    'priority' => 8,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_blog_post_single_content_bg_color',
        'label'    => esc_html__('Single Post Content Background Color', 'avante' ),
        'section'  => 'blog_single',
        'default'  => '#ffffff',
        'output' => array(
	        array(
	            'element'  => 'body.single-post #page-content-wrapper.blog-wrapper, .post-related .post-header-wrapper',
	            'property' => 'background',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => 'body.single-post #page-content-wrapper.blog-wrapper, .post-related .post-header-wrapper',
				'function' => 'css',
				'property' => 'background',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_blog_post-tag_bg_color',
        'label'    => esc_html__('Post Tag Background Color', 'avante' ),
        'section'  => 'blog_single',
        'default'  => '#f0f0f0',
        'output' => array(
	        array(
	            'element'  => '.post-excerpt.post-tag a',
	            'property' => 'background',
	        ),
	        array(
	            'element'  => '.post-excerpt.post-tag a:after',
	            'property' => 'border-left-color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.post-excerpt.post-tag a',
				'function' => 'css',
				'property' => 'background',
			),
			array(
	            'element'  => '.post-excerpt.post-tag a:after',
	            'property' => 'border-left-color',
	        ),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
    );
    
    $controls[] = array(
        'type'     => 'color',
        'settings'  => 'tg_blog_post-tag_font_color',
        'label'    => esc_html__('Post Tag Font Color', 'avante' ),
        'section'  => 'blog_single',
        'default'  => '#444',
        'output' => array(
	        array(
	            'element'  => '.post-excerpt.post-tag a',
	            'property' => 'color',
	        ),
	        array(
	            'element'  => '.post-excerpt.post-tag a',
	            'property' => 'color',
	        ),
	    ),
	    'js_vars'   => array(
			array(
				'element'  => '.post-excerpt.post-tag a',
				'function' => 'css',
				'property' => 'color',
			),
		),
	    'transport' 	 => 'postMessage',
	    'priority' => 9,
    );
    //End Blog Tab Settings
    
    //Check if Woocommerce is installed	
	if(class_exists('Woocommerce'))
	{
		//Begin Shop Tab Settings
		$controls[] = array(
	        'type'     => 'radio-buttonset',
	        'settings'  => 'tg_shop_layout',
	        'label'    => esc_html__('Shop Main Page Layout', 'avante' ),
	        'description' => esc_html__('Select page layout for displaying shop\'s products page', 'avante' ),
	        'section'  => 'shop_layout',
	        'default'  => 'fullwidth',
	        'choices'  => $tg_shop_layout,
		    'priority' => 1,
	    );
	    
	    $controls[] = array(
	        'type'     => 'slider',
	        'settings'  => 'tg_shop_items',
	        'label'    => esc_html__('Products Page Show At Most', 'avante' ),
	        'description' => esc_html__('Select number of product items you want to display per page', 'avante' ),
	        'section'  => 'shop_layout',
	        'default'  => 16,
	        'choices' => array( 'min' => 1, 'max' => 100, 'step' => 1 ),
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_shop_filter_sorting',
	        'label'    => esc_html__('Display Shop Sorting Filter Option', 'avante' ),
	        'description' => esc_html__('Check this option to display sorting filter option on shop page', 'avante' ),
	        'section'  => 'shop_layout',
	        'default'  => 1,
		    'priority' => 3,
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_shop_price_font_color',
	        'label'    => esc_html__('Product Price Font Color', 'avante' ),
	        'section'  => 'shop_single',
	        'default'  => '#181B31',
	        'output' => array(
		        array(
		            'element'  => '.woocommerce ul.products li.product .price ins, .woocommerce-page ul.products li.product .price ins, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, p.price ins span.amount, .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.woocommerce ul.products li.product .price ins, .woocommerce-page ul.products li.product .price ins, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, p.price ins span.amount, .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_shop_onsale_bg_color',
	        'label'    => esc_html__('Product On Sale Background Color', 'avante' ),
	        'section'  => 'shop_single',
	        'default'  => '#57B957',
	        'output' => array(
		        array(
		            'element'  => '.woocommerce .products .onsale, .woocommerce ul.products li.product .onsale, .woocommerce span.onsale',
		            'property' => 'background-color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.woocommerce .products .onsale, .woocommerce ul.products li.product .onsale, .woocommerce span.onsale',
					'function' => 'css',
					'property' => 'background-color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_shop_tab_font_color',
	        'label'    => esc_html__('Active Tab Font Color', 'avante' ),
	        'section'  => 'shop_single',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active a',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_shop_tab_bg_color',
	        'label'    => esc_html__('Active Tab Background Color', 'avante' ),
	        'section'  => 'shop_single',
	        'default'  => '#181B31',
	        'output' => array(
		        array(
		            'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.woocommerce div.product .woocommerce-tabs ul.tabs li.active, .woocommerce-page div.product .woocommerce-tabs ul.tabs li.active',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_shop_single_content_bg_color',
	        'label'    => esc_html__('Single Product Content Background Color', 'avante' ),
	        'section'  => 'blog_single',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => 'body.single-product div.product.type-product',
		            'property' => 'background',
		        ),
		    ),
		    'js_vars'   => array(
				array(
					'element'  => 'body.single-product div.product.type-product',
					'function' => 'css',
					'property' => 'background',
				),
			),
		    'transport' 	 => 'postMessage',
		    'priority' => 9,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_shop_related_products',
	        'label'    => esc_html__('Display Related Products', 'avante' ),
	        'description' => esc_html__('Check this option to display related products on single product page', 'avante' ),
	        'section'  => 'shop_single',
	        'default'  => 1,
		    'priority' => 3,
	    );
		//End Shop Tab Settings
	}
	
	//Check if Booking Calendar is installed	
	if(class_exists('LearnPress'))
	{  
		$controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_general_title',
	        'label'    => esc_html__('Global Settings', 'avante' ),
	        'section'  => 'course_general',
		    'priority' => 1,
	    );
	    
		$controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_curriculum_active_color',
	        'label'    => esc_html__('Featured Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#57B957',
	        'output' => array(
		        array(
		            'element'  => 'body .course-curriculum ul.curriculum-sections .section-content .course-item.item-preview .course-item-status, body.learnpress-page.profile #learn-press-profile-nav .tabs > li.active > a, body.learnpress-page.profile #learn-press-profile-nav .tabs > li a:hover, body.learnpress-page.profile #learn-press-profile-nav .tabs > li:hover:not(.active) > a, body ul.learn-press-courses .course .course-info .course-price .price',
		            'property' => 'background',
		        ),
		        array(
		            'element'  => 'body .course-item-nav .prev span, body .course-item-nav .next span, body .course-curriculum ul.curriculum-sections .section-content .course-item.current a',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => 'body .course-curriculum ul.curriculum-sections .section-content .course-item.item-preview .course-item-status, body.learnpress-page.profile #learn-press-profile-nav .tabs > li.active > a, body.learnpress-page.profile #learn-press-profile-nav .tabs > li a:hover, body ul.learn-press-courses .course .course-info .course-price .price',
					'function' => 'css',
					'property' => 'background',
				),
				array(
		            'element'  => 'body .course-item-nav .prev span, body .course-item-nav .next span, body .course-curriculum ul.curriculum-sections .section-content .course-item.current a, body.learnpress-page.profile #learn-press-profile-nav .tabs > li:hover:not(.active) > a',
		            'function' => 'css',
		            'property' => 'color',
		        ),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_tab_bg_color',
	        'label'    => esc_html__('Tab Background Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#f9f9f9',
	        'output' => array(
		        array(
		            'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav a',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav a',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_tab_font_color',
	        'label'    => esc_html__('Tab Active Font Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#181B31',
	        'output' => array(
		        array(
		            'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav a',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav a',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_tab_active_bg_color',
	        'label'    => esc_html__('Tab Active Background Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#57B957',
	        'output' => array(
		        array(
		            'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav.active a, body.learnpress-page.profile .lp-tab-sections .section-tab.active span',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav.active a, body.learnpress-page.profile .lp-tab-sections .section-tab.active span',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_tab_active_font_color',
	        'label'    => esc_html__('Tab Active Font Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav.active a, body.learnpress-page.profile .lp-tab-sections .section-tab.active span',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => '#page-content-wrapper ul.learn-press-nav-tabs .course-nav.active a, body.learnpress-page.profile .lp-tab-sections .section-tab.active span',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_table_title',
	        'label'    => esc_html__('Course Table Settings', 'avante' ),
	        'section'  => 'course_general',
		    'priority' => 16,
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_table_header_bg_color',
	        'label'    => esc_html__('Table Header Background Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#181B31',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.checkout .lp-list-table thead tr th, body.learnpress-page.profile .lp-list-table thead tr th',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.checkout .lp-list-table thead tr th, body.learnpress-page.profile .lp-list-table thead tr th',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_table_header_text_color',
	        'label'    => esc_html__('Table Header Text Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#181B31',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.checkout .lp-list-table',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.checkout .lp-list-table',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_table_content_bg_color',
	        'label'    => esc_html__('Table Content Background Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => 'body .lp-list-table th, body .lp-list-table td, body .lp-list-table tbody tr td, body .lp-list-table tbody tr th',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => 'body .lp-list-table th, body .lp-list-table td, body .lp-list-table tbody tr td, body .lp-list-table tbody tr th',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_table_content_border_color',
	        'label'    => esc_html__('Table Content Border Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#d8d8d8',
	        'output' => array(
		        array(
		            'element'  => 'body .lp-list-table tbody tr td, body .lp-list-table tbody tr th, body .lp-list-table td',
		            'property' => 'border-color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => 'body .lp-list-table tbody tr td, body .lp-list-table tbody tr th, body .lp-list-table td',
					'function' => 'css',
					'property' => 'border-color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_table_content_text_color',
	        'label'    => esc_html__('Table Content Text Color', 'avante' ),
	        'section'  => 'course_general',
	        'default'  => '#7E8090',
	        'output' => array(
		        array(
		            'element'  => 'body .lp-list-table th, body .lp-list-table td',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 16,
		    'js_vars'   => array(
				array(
					'element'  => 'body .lp-list-table th, body .lp-list-table td',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_grid_title',
	        'label'    => esc_html__('Grid Settings', 'avante' ),
	        'section'  => 'course_grid',
		    'priority' => 1,
	    );
	    
	    $controls[] = array(
	        'type'     => 'select',
	        'settings'  => 'tg_course_grid_template',
	        'label'    => esc_html__('Grid Template', 'avante' ),
	        'description' => esc_html__('Select teacher profile course grid template', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => 1,
	        'choices'  => array(
		        1	=> __( 'Style 1', 'avante' ),
		        2	=> __( 'Style 2', 'avante' ),
		        3	=> __( 'Style 3', 'avante' ),
	        ),
		    'priority' => 1,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_course_hover_effect',
	        'label'    => esc_html__('Hover Effect', 'avante' ),
	        'description' => esc_html__('Check this option to activate course grid hover effect', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => 1,
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_course_rating',
	        'label'    => esc_html__('Show Rating', 'avante' ),
	        'description' => esc_html__('Check this option to show course rating', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => 1,
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_course_lesson',
	        'label'    => esc_html__('Show Lesson', 'avante' ),
	        'description' => esc_html__('Check this option to show course\'s lessons', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => 1,
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_course_student',
	        'label'    => esc_html__('Show Student Number', 'avante' ),
	        'description' => esc_html__('Check this option to show course enrolled students', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => 1,
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_course_pricing',
	        'label'    => esc_html__('Show Pricing', 'avante' ),
	        'description' => esc_html__('Check this option to show course pricing', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => 1,
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_course_tooltip',
	        'label'    => esc_html__('Show Tooltip', 'avante' ),
	        'description' => esc_html__('Check this option to show course tooltip', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => 1,
		    'priority' => 2,
	    );
	    
	     $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_content_title',
	        'label'    => esc_html__('Content Settings', 'avante' ),
	        'section'  => 'course_grid',
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_content_title_color',
	        'label'    => esc_html__('Course Title Color', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => '#181B31',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.profile .course-grid-container .portfolio-classic-grid-wrapper .card-title',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.profile .course-grid-container .portfolio-classic-grid-wrapper .card-title',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_content_title_bg_color',
	        'label'    => esc_html__('Course Title Background Color', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-info, .course-grid-container .grid-template3 .card-info .card-title-wrapper',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-info, .course-grid-container .grid-template3 .card-info .card-title-wrapper',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_content_title_border_color',
	        'label'    => esc_html__('Course Title Border Color', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => '.course-grid-container .portfolio-classic-grid-wrapper, .course-grid-container .portfolio-classic-grid-wrapper .card-meta-wrapper',
		            'property' => 'border-color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.course-grid-container .portfolio-classic-grid-wrapper, .course-grid-container .portfolio-classic-grid-wrapper .card-meta-wrapper',
					'function' => 'css',
					'property' => 'border-color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_content_meta_color',
	        'label'    => esc_html__('Course Meta Color', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => '#181B31',
	        'output' => array(
		        array(
		            'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-info .card-meta',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-info .card-meta',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_content_pricing_bg_color',
	        'label'    => esc_html__('Course Pricing Background Color', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => '#57B957',
	        'output' => array(
		        array(
		            'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-price',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-price',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_content_pricing_color',
	        'label'    => esc_html__('Course Pricing Color', 'avante' ),
	        'section'  => 'course_grid',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-price',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => '.course-grid-container .portfolio-classic-grid-wrapper .card-price',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_template_title',
	        'label'    => esc_html__('Template Settings', 'avante' ),
	        'section'  => 'course_single',
		    'priority' => 1,
	    );
	    
	    $controls[] = array(
	        'type'     => 'select',
	        'settings'  => 'tg_course_template',
	        'label'    => esc_html__('Template Style', 'avante' ),
	        'description' => esc_html__('Select single course template', 'avante' ),
	        'section'  => 'course_single',
	        'default'  => '',
	        'choices'  => array(
		        1	=> __( 'Style 1', 'avante' ),
		        2	=> __( 'Style 2', 'avante' ),
		        3	=> __( 'Style 3', 'avante' ),
		        4	=> __( 'Style 4', 'avante' ),
	        ),
		    'priority' => 1,
	    );
	    
	    $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_include_title',
	        'label'    => esc_html__('Course Include Settings', 'avante' ),
	        'section'  => 'course_single',
		    'priority' => 16,
	    );
	    
	    $controls[] = array(
	        'type'     => 'repeater',
	        'settings'  => 'tg_course_include',
	        'label'    => esc_html__('Course Include List', 'avante' ),
	        'section'  => 'course_single',
		    'priority' => 16,
		    'transport' => 'auto',
		    'row_label' => array(
		        'type' => 'text',
		        'value' => esc_html__( 'List', 'avante' ) ,
		    ),
		    'fields' => array(
		        'course_include_title' => array(
		            'type' => 'text',
		            'label' => esc_html__( 'Title', 'avante' ) ,
		        ) ,
		        'course_include_icon' => array(
		            'type' => 'upload',
		            'label' => esc_html__( 'Icon', 'avante' ) ,
		        ) ,
		    ),
	    );
	    
	    $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_related_title',
	        'label'    => esc_html__('Related Courses Settings', 'avante' ),
	        'section'  => 'course_single',
		    'priority' => 16,
	    );
	    
	    $controls[] = array(
	        'type'     => 'toggle',
	        'settings'  => 'tg_course_related',
	        'label'    => esc_html__('Show Related Courses', 'avante' ),
	        'description' => esc_html__('Check this option to display related courses base on tags', 'avante' ),
	        'section'  => 'course_single',
	        'default'  => 1,
		    'priority' => 16,
	    );
	    
	    $controls[] = array(
	        'type'     => 'select',
	        'settings'  => 'tg_course_related_sort',
	        'label'    => esc_html__('Related Courses Sorting by', 'avante' ),
	        'description' => esc_html__('Select sorting option for related courses', 'avante' ),
	        'section'  => 'course_single',
	        'default'  => '',
	        'choices'  => array(
		         'default' => __( 'Default', 'avante' ),
		         'random' => __( 'Random', 'avante' ),
				 'published' => __( 'Published Date', 'avante' ),
			     'title' => __( 'Title', 'avante' ),
			     'price_low' => __( 'Price (Low to High)', 'avante' ),
			     'price_high' => __( 'Price (High to Low)', 'avante' ),
	        ),
		    'priority' => 16,
	    );
	    
	    $controls[] = array(
	        'type'     => 'slider',
	        'settings'  => 'tg_course_related_item',
	        'label'    => esc_html__('Number of Related Courses', 'avante' ),
	        'description' => esc_html__('Select number of related courses you want to display', 'avante' ),
	        'section'  => 'course_single',
	        'default'  => 4,
	        'choices' => array( 'min' => 2, 'max' => 4, 'step' => 1 ),
		    'priority' => 16,
	    );
	    
	    $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_single_profile_content',
	        'label'    => esc_html__('Content Settings', 'avante' ),
	        'section'  => 'course_single_profile',
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_profile_course_bg',
	        'label'    => esc_html__('Course Grid Background Color', 'avante' ),
	        'section'  => 'course_single_profile',
	        'default'  => '#f9f9f9',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.profile #wrapper',
		            'property' => 'background',
		            'suffix'   => ' !important',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.profile #wrapper',
					'function' => 'css',
					'property' => 'background',
					'suffix'   => ' !important',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'title',
	        'settings'  => 'tg_course_single_profile_counter',
	        'label'    => esc_html__('Course Counter Settings', 'avante' ),
	        'section'  => 'course_single_profile',
		    'priority' => 2,
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_single_profile_counter_icon_color',
	        'label'    => esc_html__('Course Counter Icon Color', 'avante' ),
	        'section'  => 'course_single_profile',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.profile .profile-course-count span.ti-agenda',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.profile .profile-course-count span.ti-agenda',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_single_profile_counter_icon_bg_color',
	        'label'    => esc_html__('Course Counter Icon Background Color', 'avante' ),
	        'section'  => 'course_single_profile',
	        'default'  => '#57B957',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.profile .profile-course-count',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.profile .profile-course-count',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_single_profile_counter_font_color',
	        'label'    => esc_html__('Course Counter Font Color', 'avante' ),
	        'section'  => 'course_single_profile',
	        'default'  => '#ffffff',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.profile .profile-course-count span.profile-course-count-number',
		            'property' => 'color',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.profile .profile-course-count span.profile-course-count-number',
					'function' => 'css',
					'property' => 'color',
				),
			)
	    );
	    
	    $controls[] = array(
	        'type'     => 'color',
	        'settings'  => 'tg_course_single_profile_counter_bg_color',
	        'label'    => esc_html__('Course Counter Background Color', 'avante' ),
	        'section'  => 'course_single_profile',
	        'default'  => '#FF6D3F',
	        'output' => array(
		        array(
		            'element'  => 'body.learnpress-page.profile .profile-course-count span.profile-course-count-number',
		            'property' => 'background',
		        ),
		    ),
		    'transport' 	 => 'postMessage',
		    'priority' => 2,
		    'js_vars'   => array(
				array(
					'element'  => 'body.learnpress-page.profile .profile-course-count span.profile-course-count-number',
					'function' => 'css',
					'property' => 'background',
				),
			)
	    );
	}

    return $controls;
}
add_filter( 'kirki/controls', 'avante_custom_setting' );


function avante_customize_preview()
{
?>
    <script type="text/javascript">
        ( function( $ ) {
        	//Register Logo Tab Settings
        	wp.customize('tg_retina_logo',function( value ) {
                value.bind(function(to) {
                    jQuery('#custom_logo img').attr('src', to );
                });
            });
        	//End Logo Tab Settings
            
            wp.customize('tg_menu_contact_hours',function( value ) {
                value.bind(function(to) {
                    jQuery('#top_contact_hours').html('<i class="fa fa-clock-o"></i>'+to);
                });
            });
            
            wp.customize('tg_menu_contact_number',function( value ) {
                value.bind(function(to) {
                    jQuery('#top_contact_number').html('<i class="fa fa-phone"></i>'+to);
                });
            });
            
            //Register Footer Tab Settings
            wp.customize('tg_footer_copyright_text',function( value ) {
                value.bind(function(to) {
                    jQuery('#copyright').html( to );
                });
            });
            //End Footer Tab Settings
        } )( jQuery )
    </script>
<?php	
}