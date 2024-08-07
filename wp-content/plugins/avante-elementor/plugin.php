<?php
namespace AvanteElementor;

use AvanteElementor\Widgets\Avante_Navigation_Menu;
use AvanteElementor\Widgets\Avante_Blog_Posts;
use AvanteElementor\Widgets\Avante_Gallery_Grid;
use AvanteElementor\Widgets\Avante_Gallery_Masonry;
use AvanteElementor\Widgets\Avante_Gallery_Justified;
use AvanteElementor\Widgets\Avante_Gallery_Horizontal;
use AvanteElementor\Widgets\Avante_Gallery_Fullscreen;
use AvanteElementor\Widgets\Avante_Gallery_Preview;
use AvanteElementor\Widgets\Avante_Album_Grid;
use AvanteElementor\Widgets\Avante_Distortion_Grid;
use AvanteElementor\Widgets\Avante_Slider_Vertical_Parallax;
use AvanteElementor\Widgets\Avante_Slider_Horizontal;
use AvanteElementor\Widgets\Avante_Slider_Animated_Frame;
use AvanteElementor\Widgets\Avante_Slider_Room;
use AvanteElementor\Widgets\Avante_Slider_Multi_Layouts;
use AvanteElementor\Widgets\Avante_Slider_Velo;
use AvanteElementor\Widgets\Avante_Slider_Split_Carousel;
use AvanteElementor\Widgets\Avante_Slider_Popout;
use AvanteElementor\Widgets\Avante_Slider_Clip_Path;
use AvanteElementor\Widgets\Avante_Slider_Split_Slick;
use AvanteElementor\Widgets\Avante_Slider_Transitions;
use AvanteElementor\Widgets\Avante_Slider_Property_Clip;
use AvanteElementor\Widgets\Avante_Slider_Slice;
use AvanteElementor\Widgets\Avante_Slider_Flip;
use AvanteElementor\Widgets\Avante_Slider_Parallax;
use AvanteElementor\Widgets\Avante_Slider_Animated;
use AvanteElementor\Widgets\Avante_Slider_Fade_UP;
use AvanteElementor\Widgets\Avante_Slider_Motion_Reveal;
use AvanteElementor\Widgets\Avante_Slider_Image_Carousel;
use AvanteElementor\Widgets\Avante_Slider_Synchronized_Carousel;
use AvanteElementor\Widgets\Avante_Slider_Zoom;
use AvanteElementor\Widgets\Avante_Mouse_Drive_Vertical_Carousel;
use AvanteElementor\Widgets\Avante_Slider_Glitch_Slideshow;
use AvanteElementor\Widgets\Avante_Horizontal_Timeline;
use AvanteElementor\Widgets\Avante_Portfolio_Classic;
use AvanteElementor\Widgets\Avante_Portfolio_Contain;
use AvanteElementor\Widgets\Avante_Portfolio_Grid;
use AvanteElementor\Widgets\Avante_Portfolio_Grid_Overlay;
use AvanteElementor\Widgets\Avante_Portfolio_3D_Overlay;
use AvanteElementor\Widgets\Avante_Portfolio_Masonry;
use AvanteElementor\Widgets\Avante_Portfolio_Masonry_Grid;
use AvanteElementor\Widgets\Avante_Portfolio_Timeline;
use AvanteElementor\Widgets\Avante_Portfolio_Timeline_Vertical;
use AvanteElementor\Widgets\Avante_Portfolio_Coverflow;
use AvanteElementor\Widgets\Avante_Background_List;
use AvanteElementor\Widgets\Avante_Testimonial_Card;
use AvanteElementor\Widgets\Avante_Video_Grid;
//use AvanteElementor\Widgets\Avante_Course_Grid;
use AvanteElementor\Widgets\Avante_Music_Player;
use AvanteElementor\Widgets\Avante_Flip_Box;
use AvanteElementor\Widgets\Avante_Search;
use AvanteElementor\Widgets\Avante_Team_Grid;
use AvanteElementor\Widgets\Avante_Pricing_Table;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

/**
 * Main Plugin Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class Avante_Elementor {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
		
		add_action( 'init', array( $this, 'init' ), -999 );
	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/init', [ $this, 'on_elementor_init' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );

		//Enqueue javascript files
		add_action( 'elementor/frontend/after_register_scripts', function() {
			
			//Check if enable lazy load image
			wp_enqueue_script('masonry');
			wp_enqueue_script('lazy', plugins_url( '/avante-elementor/assets/js/jquery.lazy.js' ), array(), false, true );
			wp_enqueue_script('modulobox', plugins_url( '/avante-elementor/assets/js/modulobox.js' ), array(), false, true );
			wp_enqueue_script('parallax-scroll', plugins_url( '/avante-elementor/assets/js/jquery.parallax-scroll.js' ), array(), false, true );
			wp_enqueue_script('smoove', plugins_url( '/avante-elementor/assets/js/jquery.smoove.js' ), array(), false, true );
			wp_enqueue_script('parallax', plugins_url( '/avante-elementor/assets/js/parallax.js' ), array(), false, true );
			
			//Registered scripts
			wp_register_script('lodash', plugins_url( '/avante-elementor/assets/js/lodash.core.min.js' ), array(), false, true );
			wp_register_script('anime', plugins_url( '/avante-elementor/assets/js/anime.min.js' ), array(), false, true );
			wp_register_script('hover', plugins_url( '/avante-elementor/assets/js/hover.js' ), array(), false, true );
			wp_register_script('three', plugins_url( '/avante-elementor/assets/js/three.min.js' ), array(), false, true );
			wp_register_script('mls', plugins_url( '/avante-elementor/assets/js/mls.js' ), array(), false, true );
			wp_register_script('velocity', plugins_url( '/avante-elementor/assets/js/velocity.js' ), array(), false, true );
			wp_register_script('velocity-ui', plugins_url( '/avante-elementor/assets/js/velocity.ui.js' ), array(), false, true );
			wp_register_script('slick', plugins_url( '/avante-elementor/assets/js/slick.min.js' ), array(), false, true );
			wp_register_script('mousewheel', plugins_url( '/avante-elementor/assets/js/jquery.mousewheel.min.js' ), array(), false, true );
			wp_register_script('tweenmax', plugins_url( '/avante-elementor/assets/js/tweenmax.min.js' ), array(), false, true );
			wp_register_script('flickity', plugins_url( '/avante-elementor/assets/js/flickity.pkgd.js' ), array(), false, true );
			wp_register_script('tilt', plugins_url( '/avante-elementor/assets/js/tilt.jquery.js' ), array(), false, true );
			wp_register_script('avante-album-tilt', plugins_url( '/avante-elementor/assets/js/album-tilt.js' ), array(), false, true );
			wp_register_script('justifiedGallery', plugins_url( '/avante-elementor/assets/js/justifiedGallery.js' ), array(), false, true );
			wp_register_script('sticky-kit', plugins_url( '/avante-elementor/assets/js/jquery.sticky-kit.min.js' ), array(), false, true );
			wp_register_script('touchSwipe', plugins_url( '/avante-elementor/assets/js/jquery.touchSwipe.js' ), array(), false, true );
			wp_register_script('momentum-slider', plugins_url( '/avante-elementor/assets/js/momentum-slider.js' ), array(), false, true );
			wp_register_script('switchery', plugins_url( '/avante-elementor/assets/js/switchery.js' ), array(), false, true );
			wp_register_script('avante-elementor', plugins_url( '/avante-elementor/assets/js/avante-elementor.js' ), array('sticky-kit'), false, true );
			
			$params = array(
			  'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
			  'ajax_nonce' => wp_create_nonce('avante-post-contact-nonce'),
			);
			
			wp_localize_script("avante-elementor", 'tgAjax', $params );
			
			wp_enqueue_script('avante-elementor', plugins_url( '/avante-elementor/assets/js/avante-elementor.js' ), array('sticky-kit'), false, true );
		} );
		
		//Enqueue CSS style files
		add_action( 'elementor/frontend/after_enqueue_styles', function() {
			wp_enqueue_style('modulobox', plugins_url( '/avante-elementor/assets/css/modulobox.css' ), false, false, 'all' );
			wp_enqueue_style('swiper', plugins_url( '/avante-elementor/assets/css/swiper.css' ), false, false, 'all' );
			wp_enqueue_style('justifiedGallery', plugins_url( '/avante-elementor/assets/css/justifiedGallery.css' ), false, false, 'all' );
			wp_enqueue_style('flickity', plugins_url( '/avante-elementor/assets/css/flickity.css' ), false, false, 'all' );
			wp_enqueue_style('avante-elementor', plugins_url( '/avante-elementor/assets/css/avante-elementor.css' ), false, false, 'all' );
			wp_enqueue_style('avante-elementor-responsive', plugins_url( '/avante-elementor/assets/css/avante-elementor-responsive.css' ), false, false, 'all' );
		});
	}
	
	/**
	 * Manually init required modules.
	 *
	 * @return void
	 */
	public function init() {
		
		avante_templates_manager()->init();
		$this->register_extension();

	}
	
	/**
	 * On Elementor Init
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_elementor_init() {
		$this->register_category();
	}

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require __DIR__ . '/widgets/navigation-menu.php';
		require __DIR__ . '/widgets/blog-posts.php';
		require __DIR__ . '/widgets/gallery-grid.php';
		require __DIR__ . '/widgets/gallery-masonry.php';
		require __DIR__ . '/widgets/gallery-justified.php';
		require __DIR__ . '/widgets/gallery-fullscreen.php';
		require __DIR__ . '/widgets/gallery-horizontal.php';
		require __DIR__ . '/widgets/gallery-preview.php';
		require __DIR__ . '/widgets/album-grid.php';
		require __DIR__ . '/widgets/distortion-grid.php';
		require __DIR__ . '/widgets/slider-vertical-parallax.php';
		require __DIR__ . '/widgets/slider-horizontal.php';
		require __DIR__ . '/widgets/slider-animated-frame.php';
		require __DIR__ . '/widgets/slider-room.php';
		require __DIR__ . '/widgets/slider-multi-layouts.php';
		require __DIR__ . '/widgets/slider-velo.php';
		require __DIR__ . '/widgets/slider-split-carousel.php';
		require __DIR__ . '/widgets/mouse-driven-vertical-carousel.php';
		require __DIR__ . '/widgets/slider-popout.php';
		require __DIR__ . '/widgets/slider-clip-path.php';
		require __DIR__ . '/widgets/slider-split-slick.php';
		require __DIR__ . '/widgets/slider-transitions.php';
		require __DIR__ . '/widgets/slider-property-clip.php';
		require __DIR__ . '/widgets/slider-slice.php';
		require __DIR__ . '/widgets/slider-flip.php';
		require __DIR__ . '/widgets/slider-parallax.php';
		require __DIR__ . '/widgets/slider-animated.php';
		require __DIR__ . '/widgets/slider-fade-up.php';
		require __DIR__ . '/widgets/slider-motion-reveal.php';
		require __DIR__ . '/widgets/slider-image-carousel.php';
		require __DIR__ . '/widgets/slider-synchronized-carousel.php';
		require __DIR__ . '/widgets/slider-glitch-slideshow.php';
		require __DIR__ . '/widgets/slider-zoom.php';
		require __DIR__ . '/widgets/horizontal-timeline.php';
		require __DIR__ . '/widgets/portfolio-classic.php';
		require __DIR__ . '/widgets/portfolio-contain.php';
		require __DIR__ . '/widgets/portfolio-grid.php';
		require __DIR__ . '/widgets/portfolio-grid-overlay.php';
		require __DIR__ . '/widgets/portfolio-3d-overlay.php';
		require __DIR__ . '/widgets/portfolio-masonry.php';
		require __DIR__ . '/widgets/portfolio-masonry-grid.php';
		require __DIR__ . '/widgets/portfolio-timeline.php';
		require __DIR__ . '/widgets/portfolio-timeline-vertical.php';
		require __DIR__ . '/widgets/portfolio-coverflow.php';
		require __DIR__ . '/widgets/background-list.php';
		require __DIR__ . '/widgets/testimonial-card.php';
		require __DIR__ . '/widgets/video-grid.php';
		//require __DIR__ . '/widgets/course-grid.php';
		require __DIR__ . '/widgets/music-player.php';
		require __DIR__ . '/widgets/flip-box.php';
		require __DIR__ . '/widgets/search.php';
		require __DIR__ . '/widgets/team-grid.php';
		require __DIR__ . '/widgets/pricing-table.php';
	}
	
	/**
	 * Register Category
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_category() {
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'avante-theme-widgets-category-fullscreen',
			array(
				'title' => 'Theme Fullscreen Elements',
				'icon'  => 'fonts',
			),
			1
		);
		
		\Elementor\Plugin::instance()->elements_manager->add_category(
			'avante-theme-widgets-category',
			array(
				'title' => 'Theme General Elements',
				'icon'  => 'fonts',
			),
			2
		);
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Navigation_Menu() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Blog_Posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Gallery_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Gallery_Masonry() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Gallery_Justified() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Gallery_Fullscreen() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Gallery_Preview() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Gallery_Horizontal() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Album_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Distortion_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Vertical_Parallax() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Horizontal() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Animated_Frame() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Room() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Multi_Layouts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Velo() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Split_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Mouse_Drive_Vertical_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Popout() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Clip_Path() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Split_Slick() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Transitions() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Property_Clip() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Slice() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Flip() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Parallax() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Animated() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Motion_Reveal() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Fade_UP() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Image_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Synchronized_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Glitch_Slideshow() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Slider_Zoom() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Horizontal_Timeline() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Classic() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Contain() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Grid_Overlay() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_3D_Overlay() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Masonry() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Masonry_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Timeline() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Timeline_Vertical() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Portfolio_Coverflow() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Background_list() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Testimonial_Card() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Video_Grid() );
		//\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Course_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Music_Player() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Flip_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Search() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Team_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Avante_Pricing_Table() );
	}
	
	/**
	 * Register Extension
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_extension() {
		//Custom Elementor extensions
		require __DIR__ . '/extensions.php';
		
		avante_ext()->init();
	}
}

new Avante_Elementor();
