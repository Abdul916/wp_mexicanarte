<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Avante_Templates_Source extends Elementor\TemplateLibrary\Source_Base {

	/**
	 * Template prefix
	 *
	 * @var string
	 */
	protected $template_prefix = 'avante_';

	/**
	 * Return templates prefix
	 *
	 * @return [type] [description]
	 */
	public function get_prefix() {
		return $this->template_prefix;
	}

	public function get_id() {
		return 'avante-templates';
	}

	public function get_title() {
		return __( 'Avante Templates', 'avante-elementor' );
	}

	public function register_data() {}

	public function get_items( $args = array() ) {
		
		$templates = array();

		$templates_data = array(
			1 	=> array(
				'template_id'      	=> $this->template_prefix .'1',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 1',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_1.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/',
			),
			2 	=> array(
				'template_id'      	=> $this->template_prefix .'2',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 2',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_2.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-2/',
			),
			3 	=> array(
				'template_id'      	=> $this->template_prefix .'3',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 3',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_3.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-3/',
			),
			4 	=> array(
				'template_id'      	=> $this->template_prefix .'4',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 4',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_4.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-4/',
			),
			5 	=> array(
				'template_id'      	=> $this->template_prefix .'5',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 5',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_5.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-5/',
			),
			6 	=> array(
				'template_id'      	=> $this->template_prefix .'6',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 6',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_6.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-6/',
			),
			7 	=> array(
				'template_id'      	=> $this->template_prefix .'7',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 7',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_7.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-7/',
			),
			8 	=> array(
				'template_id'      	=> $this->template_prefix .'8',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 8',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_8.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-8/',
			),
			9 	=> array(
				'template_id'      	=> $this->template_prefix .'9',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Home 9',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_9.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('home'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/home-9/',
			),
			10 	=> array(
				'template_id'      	=> $this->template_prefix .'10',
				'source'            => $this->get_id(),
				'title'             => 'Avante - About 1',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_10.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('about'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/about-1/',
			),
			11 	=> array(
				'template_id'      	=> $this->template_prefix .'11',
				'source'            => $this->get_id(),
				'title'             => 'Avante - About 2',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_11.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('about'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/about-2/',
			),
			12 	=> array(
				'template_id'      	=> $this->template_prefix .'12',
				'source'            => $this->get_id(),
				'title'             => 'Avante - About 3',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_12.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('about'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/about-3/',
			),
			13 	=> array(
				'template_id'      	=> $this->template_prefix .'13',
				'source'            => $this->get_id(),
				'title'             => 'Avante - About 4',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_13.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('about'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/about-4/',
			),
			14 	=> array(
				'template_id'      	=> $this->template_prefix .'14',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Our Team',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_14.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('team'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/our-team/',
			),
			15 	=> array(
				'template_id'      	=> $this->template_prefix .'15',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Contact 1',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_15.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('contact'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/contact-1/',
			),
			16 	=> array(
				'template_id'      	=> $this->template_prefix .'16',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Contact 2',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_16.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('contact'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/contact-2/',
			),
			17 	=> array(
				'template_id'      	=> $this->template_prefix .'17',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Service 1',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_17.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('service'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/service-1/',
			),
			18 	=> array(
				'template_id'      	=> $this->template_prefix .'18',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Service 2',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_18.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('service'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/service-2/',
			),
			19 	=> array(
				'template_id'      	=> $this->template_prefix .'19',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Service 3',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_19.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('service'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/service-3/',
			),
			20 	=> array(
				'template_id'      	=> $this->template_prefix .'20',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Classic',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_20.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-classic/',
			),
			21 	=> array(
				'template_id'      	=> $this->template_prefix .'21',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Grid',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_21.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-grid/',
			),
			22 	=> array(
				'template_id'      	=> $this->template_prefix .'22',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Grid Overlay',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_22.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-grid-overlay/',
			),
			23 	=> array(
				'template_id'      	=> $this->template_prefix .'23',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio 3D Overlay',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_23.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-3d-overlay/',
			),
			24 	=> array(
				'template_id'      	=> $this->template_prefix .'24',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Contain',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_24.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-contain/',
			),
			25 	=> array(
				'template_id'      	=> $this->template_prefix .'25',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Masonry',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_25.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-masonry/',
			),
			26 	=> array(
				'template_id'      	=> $this->template_prefix .'26',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Masonry',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_26.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-masonry-grid/',
			),
			27 	=> array(
				'template_id'      	=> $this->template_prefix .'27',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Coverflow',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_27.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-coverflow/',
			),
			28 	=> array(
				'template_id'      	=> $this->template_prefix .'28',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Timeline Horizon',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_28.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-timeline-horizon/',
			),
			29 	=> array(
				'template_id'      	=> $this->template_prefix .'29',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Portfolio Timeline Vertical',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_29.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/portfolio-timeline-vertical/',
			),
			30 	=> array(
				'template_id'      	=> $this->template_prefix .'30',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Single Portfolio 1',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_30.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/single-portfolio/',
			),
			31 	=> array(
				'template_id'      	=> $this->template_prefix .'31',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Single Portfolio 2',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_31.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/single-portfolio-2/',
			),
			32 	=> array(
				'template_id'      	=> $this->template_prefix .'32',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Single Portfolio 3',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_32.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/single-portfolio-3/',
			),
			33 	=> array(
				'template_id'      	=> $this->template_prefix .'33',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Single Portfolio 4',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_33.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/single-portfolio-4/',
			),
			34 	=> array(
				'template_id'      	=> $this->template_prefix .'34',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Single Portfolio 5',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_34.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('portfolio'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/single-portfolio-5/',
			),
			35 	=> array(
				'template_id'      	=> $this->template_prefix .'35',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Video Grid',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_35.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('video'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/video-grid/',
			),
			36 	=> array(
				'template_id'      	=> $this->template_prefix .'36',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Blog',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_36.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'page',
				'subtype'			=> 'page',
				'author'            => 'ThemeGoods',

				'keywords'          => array('blog'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog-grid/',
			),
						
			//Adding navigation menu block templates
			501 => array(
				'template_id'      	=> $this->template_prefix .'501',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 1',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_501.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-1/',
			),
			502 => array(
				'template_id'      	=> $this->template_prefix .'502',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 2',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_502.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-2/',
			),
			503 => array(
				'template_id'      	=> $this->template_prefix .'503',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 3',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_503.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-3/',
			),
			504 => array(
				'template_id'      	=> $this->template_prefix .'504',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 4',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_504.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-4/',
			),
			505 => array(
				'template_id'      	=> $this->template_prefix .'505',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 5',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_505.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-5/',
			),
			506 => array(
				'template_id'      	=> $this->template_prefix .'506',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 6',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_506.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-6/',
			),
			507 => array(
				'template_id'      	=> $this->template_prefix .'507',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 7',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_507.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-7/',
			),
			508 => array(
				'template_id'      	=> $this->template_prefix .'508',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 8',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_508.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-8/',
			),
			509 => array(
				'template_id'      	=> $this->template_prefix .'509',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Header 9',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_509.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme navigation menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('navigation'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/header/header-9/',
			),
			
			//Adding mega menu block templates
			601 => array(
				'template_id'      	=> $this->template_prefix .'601',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Mega Menu Home Grid',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_601.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme mega menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('megamenu'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/megamenu/home-demos/',
			),
			602 => array(
				'template_id'      	=> $this->template_prefix .'602',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Mega Menu Services',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_602.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme mega menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('megamenu'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/megamenu/services/',
			),
			603 => array(
				'template_id'      	=> $this->template_prefix .'603',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Mega Menu Shop',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_603.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme mega menu',
				'author'            => 'ThemeGoods',

				'keywords'          => array('megamenu'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/megamenu/shop/',
			),
			
			//Adding footer block templates
			701 => array(
				'template_id'      	=> $this->template_prefix .'701',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 1',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_701.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-1/',
			),
			702 => array(
				'template_id'      	=> $this->template_prefix .'702',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 2',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_702.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-2/',
			),
			703 => array(
				'template_id'      	=> $this->template_prefix .'703',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 3',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_703.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-3/',
			),
			704 => array(
				'template_id'      	=> $this->template_prefix .'704',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 4',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_704.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-4/',
			),
			705 => array(
				'template_id'      	=> $this->template_prefix .'705',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 5',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_705.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-5/',
			),
			706 => array(
				'template_id'      	=> $this->template_prefix .'706',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 6',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_706.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-6/',
			),
			707 => array(
				'template_id'      	=> $this->template_prefix .'707',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 7',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_707.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-7/',
			),
			708 => array(
				'template_id'      	=> $this->template_prefix .'708',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 8',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_708.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-8/',
			),
			709 => array(
				'template_id'      	=> $this->template_prefix .'709',
				'source'            => $this->get_id(),
				'title'             => 'Avante - Footer 9',
				'thumbnail'         => 'http://assets.themegoods.com/demo/avante/templates/screenshots/avante_709.jpg',
				'date'      		=> date( get_option( 'date_format' ), 1575280289 ),
				'type'				=> 'block',
				'subtype'			=> 'theme footer',
				'author'            => 'ThemeGoods',

				'keywords'          => array('footer'),
				'is_pro'            => false,
				'has_page_settings' => false,
				'url'               => 'https://themes.themegoods.com/avante/blog/footer/footer-9/',
			),
		);
		
		if ( ! empty( $templates_data ) ) {
			foreach ( $templates_data as $template_data ) 
			{
				$templates_data['popularityIndex'] = 260;
				$templates_data['trendIndex'] = 125;
				
				$templates[] = $this->get_item( $template_data );
			}
		}

		if ( ! empty( $args ) ) {
			$templates = wp_list_filter( $templates, $args );
		}
		
		return $templates;
	}
	
	public function get_item( $template_data ) {
		return array(
			'template_id'     => $template_data['template_id'],
			'source'          => 'remote',
			'type'            => $template_data['type'],
			'subtype'         => $template_data['subtype'],
			'title'           => $template_data['title'],
			'thumbnail'       => $template_data['thumbnail'],
			'date'            => $template_data['date'],
			'author'          => $template_data['author'],
			'tags'            => $template_data['tags'],
			'isPro'           => ( 1 == $template_data['isPro'] ),
			'popularityIndex' => (int) $template_data['popularityIndex'],
			'trendIndex'      => (int) $template_data['trendIndex'],
			'hasPageSettings' => ( 1 == $template_data['hasPageSettings'] ),
			'url'             => $template_data['url'],
			'favorite'        => ( 1 == $template_data['favorite'] ),
			'accessLevel'     => 0,
		);
	}

	public function save_item( $template_data ) {
		return false;
	}

	public function update_item( $new_data ) {
		return false;
	}

	public function delete_template( $template_id ) {
		return false;
	}

	public function export_template( $template_id ) {
		return false;
	}

	public function get_data( array $args, $context = 'display' ) {
		$url	  = 'http://assets.themegoods.com/demo/avante/templates/json/'.$args['template_id'].'.json';
		$response = wp_remote_get( $url, array( 'timeout' => 60 ) );
		$body     = wp_remote_retrieve_body( $response );
		$body     = json_decode( $body, true );
		$data     = ! empty( $body['content'] ) ? $body['content'] : false;
		
		$result = array();

		$result['content']       = $this->replace_elements_ids($data);
		$result['content']       = $this->process_export_import_content( $result['content'], 'on_import' );
		$result['page_settings'] = array();

		return $result;
	}
}
