<?php
namespace AvanteElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Portfolio Classic
 *
 * Elementor widget for portfolio posts
 *
 * @since 1.0.0
 */
class Avante_Pricing_Table extends Widget_Base {

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
		return 'avante-pricing-table';
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
		return __( 'Pricing Table', 'avante-elementor' );
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
		return 'eicon-price-table';
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
		return [ 'switchery', 'avante-elementor' ];
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
		
		/**
		*
		*	Begin slides repeat list
		*
		**/
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_title', [
				'label' => __( 'Title', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'slide_price_month', [
				'label' => __( 'Price/Month', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( '$10' , 'avante-elementor' ),
			]
		);
		
		$repeater->add_control(
			'slide_price_year', [
				'label' => __( 'Price/Year', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( '$99' , 'avante-elementor' ),
			]
		);
		
		$repeater->add_control(
			'slide_features', [
				'label' => __( 'Features', 'avante-elementor' ),
				'description' => __( 'Enter each feature seperate by enter (new line)', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'slide_button_title', [
				'label' => __( 'Button Title', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'slide_button_link', [
				'label' => __( 'Button Link URL', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'show_external' => true,
			]
		);
		
		$repeater->add_control(
			'slide_featured', [
				'label' => __( 'Mark as Featured Plan', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'slides',
			[
				'label' => __( 'Plans', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ slide_title }}}',
			]
		);
		
		/**
		*
		*	End slides repeat list
		*
		**/

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
		                'max' => 4,
		                'step' => 1,
		            ]
		        ],
		    ]
		);
		
		$this->add_control(
			'price_switching',
			[
				'label' => __( 'Price Switching', 'avante-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => __( 'Yes', 'avante-elementor' ),
				'label_off' => __( 'No', 'avante-elementor' ),
				'return_value' => 'yes',
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
					'{{WRAPPER}} .service-grid-wrapper' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'entrance_animation',
			[
				'label'       => esc_html__( 'Entrance Animation', 'avante-elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide-up',
			    'options' => [
			     	'slide-up' => __( 'Slide Up', 'avante-elementor' ),
			     	'popout' => __( 'Popout', 'avante-elementor' ),
			     	'fade-in' => __( 'Fade In', 'avante-elementor' ),
			    ]
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
			'section_plan_style',
			array(
				'label'      => esc_html__( 'Plan', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_responsive_control(
		    'plan_padding',
		    [
		        'label' => __( 'Plan Content Padding', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 60,
		            'unit' => 'px',
		        ],
		        'range' => [
		            'px' => [
		                'min' => 0,
		                'max' => 200,
		                'step' => 5,
		            ]
		        ],
		        'size_units' => [ 'px' ],
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper .inner-wrap' => 'padding: {{SIZE}}{{UNIT}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'plan_bg_color',
		    [
		        'label' => __( 'Plan Background Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper .inner-wrap' => 'background: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'plan_border_color',
		    [
		        'label' => __( 'Plan Border Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper .inner-wrap' => 'border-color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'plan_hover_bg_color',
		    [
		        'label' => __( 'Plan Hover Background Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper .inner-wrap:hover' => 'background: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'plan_hover_border_color',
		    [
		        'label' => __( 'Plan Hover Border Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper .inner-wrap:hover' => 'border-color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'plan_featured_bg_color',
		    [
		        'label' => __( 'Featured Plan Background Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper.featured-pricing-plan .inner-wrap' => 'background: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'plan_featured_border_color',
		    [
		        'label' => __( 'Featured Plan Border Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper.featured-pricing-plan .inner-wrap' => 'border-color: {{VALUE}}',
		        ],
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
		            '{{WRAPPER}} .pricing-table-wrapper h2.pricing-plan-title' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'title_hover_color',
		    [
		        'label' => __( 'Title Hover Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper:hover h2.pricing-plan-title' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'title_featured_color',
		    [
		        'label' => __( 'Featured Plan Title Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper.featured-pricing-plan h2.pricing-plan-title' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .pricing-table-wrapper h2.pricing-plan-title',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_price_style',
			array(
				'label'      => esc_html__( 'Price', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'price_color',
		    [
		        'label' => __( 'Price Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-price-wrap h3.pricing-plan-price' => 'color: {{VALUE}}',
		            '{{WRAPPER}} .pricing-plan-price-wrap' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'price_hover_color',
		    [
		        'label' => __( 'Price Hover Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper:hover h3.pricing-plan-price' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'price_featured_color',
		    [
		        'label' => __( 'Featured Plan Price Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper.featured-pricing-plan h3.pricing-plan-price' => 'color: {{VALUE}}',
		            '{{WRAPPER}} .pricing-table-wrapper.featured-pricing-plan .pricing-plan-unit-month' => 'color: {{VALUE}}',
		            '{{WRAPPER}} .pricing-table-wrapper.featured-pricing-plan .pricing-plan-unit-year' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => __( 'Price Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .pricing-plan-price-wrap h3.pricing-plan-price',
			]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'price_unit_typography',
				'label' => __( 'Price per Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .pricing-plan-price-wrap .pricing-plan-unit-month, {{WRAPPER}} .pricing-plan-price-wrap .pricing-plan-unit-year',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_features_style',
			array(
				'label'      => esc_html__( 'Features', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'features_color',
		    [
		        'label' => __( 'Features Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper .pricing-plan-content-list' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'features_icon_color',
		    [
		        'label' => __( 'Check Icon Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-content ul.pricing-plan-content-list li:before' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'features_hover_color',
		    [
		        'label' => __( 'Features Hover Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper:hover .pricing-plan-content-list' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'features_featured_color',
		    [
		        'label' => __( 'Featured Plan Features Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-table-wrapper.featured-pricing-plan .pricing-plan-content-list' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'features_typography',
				'label' => __( 'Features Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .pricing-table-wrapper .pricing-plan-content-list',
			]
		);
				
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_button_style',
			array(
				'label'      => esc_html__( 'Button', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'button_color',
		    [
		        'label' => __( 'Button Font Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-content .pricing-plan-button' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'button_bg_color',
		    [
		        'label' => __( 'Button Background Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-content .pricing-plan-button' => 'background: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'button_border_color',
		    [
		        'label' => __( 'Button Border Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-content .pricing-plan-button' => 'border-color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'button_hover_color',
		    [
		        'label' => __( 'Button Hover Font Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-content .pricing-plan-button:hover' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'button_hover_bg_color',
		    [
		        'label' => __( 'Button Hover Background Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-content .pricing-plan-button:hover' => 'background: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'button_hover_border_color',
		    [
		        'label' => __( 'Button Hover Border Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-content .pricing-plan-button:hover' => 'border-color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Button Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .pricing-plan-content .pricing-plan-button',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_switching_style',
			array(
				'label'      => esc_html__( 'Switching', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'switching_button_color',
		    [
		        'label' => __( 'Switching Button Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#0055FF',
		    ]
		);
		
		$this->add_control(
		    'switching_bg_color',
		    [
		        'label' => __( 'Switching Background Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#E7E7E7',
		    ]
		);
		
		$this->add_control(
		    'switching_font_color',
		    [
		        'label' => __( 'Switching Font Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#000000',
		        'selectors' => [
		            '{{WRAPPER}} .pricing-plan-switch-wrap' => 'color: {{VALUE}}',
		        ],
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
		include(AVANTE_ELEMENTOR_PATH.'templates/pricing-table/index.php');
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
