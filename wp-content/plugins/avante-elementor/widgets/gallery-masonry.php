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
class Avante_Gallery_Masonry extends Widget_Base {

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
		return 'avante-gallery-masonry';
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
		return __( 'Masonry Gallery', 'avante-elementor' );
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
		return 'eicon-gallery-masonry';
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
		return [ 'tilt', 'masonry', 'avante-elementor' ];
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
			'gallery',
			  [
			    'label' => __( 'Add Images', 'avante-elementor' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
		    'columns',
		    [
		        'label' => __( 'Columns', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 3,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 2,
		                'max' => 5,
		                'step' => 1,
		            ]
		        ],
		    ]
		);
		
		$this->add_control(
			'spacing',
			[
				'label' => __( 'Column Spacing', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
		    'border',
		    [
		        'label' => __( 'Border Width', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 0,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 0,
		                'max' => 40,
		                'step' => 1,
		            ],
		        ],
		        'size_units' => [ 'px' ],
		        'selectors' => [
		            '{{WRAPPER}} .avante-gallery-grid-content-wrapper .gallery-grid-item' => 'border-width: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);
		
		$this->add_control(
		    'border_color',
		    [
		        'label' => __( 'Border Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .avante-gallery-grid-content-wrapper div.gallery-grid-item' => 'border-color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'avante-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .avante-gallery-grid-content-wrapper div.gallery-grid-item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title on Hover', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'lightbox',
			[
				'label' => __( 'Image Lightbox', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'lightbox_content',
			[
				'label' => __( 'Lightbox Content', 'avante-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'title',
			    'options' => [
			     	'title' => __( 'Title', 'avante-elementor' ),
			     	'title_caption' => __( 'Title and Caption', 'avante-elementor' ),
			     	'title_description' => __( 'Title and Description', 'starto-elementor' ),
			     	'none' 	=> __( 'None', 'avante-elementor' ),
			    ],
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
			'section_content_style',
			array(
				'label'      => esc_html__( 'Content', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'background_overlay',
		    [
		        'label' => __( 'Background Overlay', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => 'rgba(0,0,0,0.2)',
		        'selectors' => [
		            '{{WRAPPER}} .avante-gallery-grid-content-wrapper .gallery-grid-item:hover .bg-overlay' => 'background: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'title_color',
		    [
		        'label' => __( 'Title Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .avante-gallery-grid-content-wrapper .gallery-grid-item:hover .gallery-grid-title' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .avante-gallery-grid-content-wrapper .gallery-grid-item .gallery-grid-title',
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
		include(AVANTE_ELEMENTOR_PATH.'templates/gallery-masonry/index.php');
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
