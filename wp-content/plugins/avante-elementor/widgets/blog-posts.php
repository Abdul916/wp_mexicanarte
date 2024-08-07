<?php
namespace AvanteElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Blog Posts
 *
 * Elementor widget for blog posts
 *
 * @since 1.0.0
 */
class Avante_Blog_Posts extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'avante-blog-posts';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Blog Posts', 'avante-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'avante-theme-widgets-category' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'sticky-kit', 'masonry', 'avante-elementor' ];
	}
	
	/**
	 * Retrieve blog post categories
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Blog categories
	 */
	public function get_blog_categories() {
		//Get all categories
		$categories_arr = get_categories( array(
		    'orderby' => 'name',
		    'order'   => 'ASC'
		) );
		$tg_categories_select = array();
		
		foreach ($categories_arr as $cat) {
			$tg_categories_select[$cat->term_id] = $cat->name;
		}

		return $tg_categories_select;
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'avante-elementor' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'avante-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'classic',
			    'options' => [
			     	'classic'  			=> __( 'Classic', 'avante-elementor' ),
			     	'grid' 				=> __( 'Grid', 'avante-elementor' ),
			     	'grid_no_space' 	=> __( 'Grid No Space', 'avante-elementor' ),
			     	'masonry' 			=> __( 'Masonry', 'avante-elementor' ),
			     	'list'   			=> __( 'List', 'avante-elementor' ),
			     	'list-circle'   	=> __( 'List Circle', 'avante-elementor' ),
			     	'metro'   			=> __( 'Metro', 'avante-elementor' ),
			     	'metro_no_space'   	=> __( 'Metro No Space', 'avante-elementor' ),
			    ],
			]
		);
		
		$this->add_control(
		    'posts_per_page',
		    [
		        'label' => __( 'Posts Per Page', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 6,
		        ],
		        'range' => [
		            'px' => [
		                'min' => -1,
		                'max' => 100,
		                'step' => 1,
		            ]
		        ],
		    ]
		);
		
		$this->add_control(
			'categories',
			[
				'label' => __( 'Categories', 'avante-elementor' ),
				'type' => Controls_Manager::SELECT2,
			    'options' => $this->get_blog_categories(),
			    'multiple' => true,
			]
		);
		
		$this->add_control(
			'show_categories',
			[
				'label' => __( 'Show Post Categories', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'show_date',
			[
				'label' => __( 'Show Post Date', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'show_pagination',
			[
				'label' => __( 'Show Pagination', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'text_display',
			[
				'label' => __( 'Text Display', 'avante-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'excerpt',
			    'options' => [
			     	'excerpt' => __( 'Excerpt', 'avante-elementor' ),
			     	'full_content' => __( 'Full Content', 'avante-elementor' ),
			     	'no_text' => __( 'No text', 'avante-elementor' ),
			    ],
			]
		);
		
		
		$this->add_control(
		    'text_align',
		    [
		        'label' => __( 'Text Alignment', 'avante-elementor' ),
		        'type' => Controls_Manager::CHOOSE,
		        'options' => [
		            'left'    => [
		                'title' => __( 'Left', 'avante-elementor' ),
		                'icon' => 'fa fa-align-left',
		            ],
		            'center' => [
		                'title' => __( 'Center', 'avante-elementor' ),
		                'icon' => 'fa fa-align-center',
		            ],
		            'right' => [
		                'title' => __( 'Right', 'avante-elementor' ),
		                'icon' => 'fa fa-align-right',
		            ],
		        ],
		    ]
		);
		
		$this->add_control(
		    'excerpt_length',
		    [
		        'label' => __( 'Excerpt Length', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 100,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 0,
		                'max' => 300,
		                'step' => 1,
		            ]
		        ],
		    ]
		);
		
		$this->add_control(
			'strip_html',
			[
				'label' => __( 'Strip HTML from Post Content', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'disable_animation',
			[
				'label'       => esc_html__( 'Disable entrance animation for', 'avante-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tablet',
			    'options' => [
			     	'none' => __( 'None', 'avante-elementor' ),
			     	'tablet' => __( 'Mobile and Tablet', 'avante-elementor' ),
			     	'mobile' => __( 'Mobile', 'avante-elementor' ),
			     	'all' => __( 'Disable All', 'avante-elementor' ),
			    ]
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_title_style',
			array(
				'label'      => esc_html__( 'Title', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'title_color',
		    [
		        'label' => __( 'Title Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .post-header h5 a' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .post-header h5',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_cat_style',
			array(
				'label'      => esc_html__( 'Categories', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'cat_color',
		    [
		        'label' => __( 'Categories Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#57b957',
		        'selectors' => [
		            '{{WRAPPER}} .post-info-cat a' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'cat_typography',
				'label' => __( 'Title Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .post-detail.single-post',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_excerpt_style',
			array(
				'label'      => esc_html__( 'Excerpt', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'excerpt_color',
		    [
		        'label' => __( 'Excerpt Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .post-header-wrapper > p' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'label' => __( 'Excerpt Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .post-header-wrapper > p',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_link_style',
			array(
				'label'      => esc_html__( 'Link', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'link_color',
		    [
		        'label' => __( 'Link Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} a.continue-reading' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => __( 'Link Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} a.continue-reading',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_date_style',
			array(
				'label'      => esc_html__( 'Date', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'date_color',
		    [
		        'label' => __( 'Date Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .post-attribute a' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'label' => __( 'Date Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .post-attribute a',
			]
		);
		
		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		include(AVANTE_ELEMENTOR_PATH.'templates/blog-posts/index.php');
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		return '';
	}
}
