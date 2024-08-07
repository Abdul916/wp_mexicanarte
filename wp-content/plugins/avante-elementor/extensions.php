<?php

/**
 * Class description
 *
 * @package   package_name
 * @author    ThemeG
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Avante_Ext' ) ) {

	/**
	 * Define Avante_Ext class
	 */
	class Avante_Ext {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * Init Handler
		 */
		public function init() {
			add_action( 'elementor/element/column/section_advanced/after_section_end', [ $this, 'widget_tab_advanced_add_section' ], 10, 2 );

			add_action( 'elementor/element/common/_section_style/after_section_end', array( $this, 'widget_tab_advanced_add_section' ), 10, 2 );
		}

		/**
		 * [widget_tab_advanced_add_section description]
		 * @param  [type] $element [description]
		 * @param  [type] $args    [description]
		 * @return [type]          [description]
		 */
		public function widget_tab_advanced_add_section( $element, $args ) {

			$element->start_controls_section(
				'avante_ext_animation_section',
				[
					'label' => esc_html__( 'Custom Animation', 'avante-elementor' ),
					'tab'   => Elementor\Controls_Manager::TAB_ADVANCED,
				]
			);

			$element->add_control(
				'avante_ext_is_scrollme',
				[
					'label'        => esc_html__( 'Scroll Animation', 'avante-elementor' ),
					'description'  => esc_html__( 'Add animation to element when scrolling through page contents', 'avante-elementor' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'avante-elementor' ),
					'label_off'    => esc_html__( 'No', 'avante-elementor' ),
					'return_value' => 'true',
					'default'      => 'false',
					'frontend_available' => true,
				]
			);

			$element->add_control(
				'avante_ext_scrollme_disable',
				[
					'label'       => esc_html__( 'Disable for', 'avante-elementor' ),
					'type' => Elementor\Controls_Manager::SELECT,
					'default' => 'mobile',
				    'options' => [
				     	'none' => __( 'None', 'avante-elementor' ),
				     	'tablet' => __( 'Mobile and Tablet', 'avante-elementor' ),
				     	'mobile' => __( 'Mobile', 'avante-elementor' ),
				    ],
					'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
				]
			);
			
			/*$element->add_control(
				'avante_ext_scrollme_easing',
				[
					'label'       => esc_html__( 'Easing', 'avante-elementor' ),
					'type' => Elementor\Controls_Manager::SELECT,
					'default' => 'swing',
				    'options' => [
					    'swing' => __( 'swing', 'avante-elementor' ),
				     	'easeInQuad' => __( 'easeInQuad', 'avante-elementor' ),
				     	'easeInCubic' => __( 'easeInCubic', 'avante-elementor' ),
				     	'easeInQuart' => __( 'easeInQuart', 'avante-elementor' ),
				     	'easeInQuint' => __( 'easeInQuint', 'avante-elementor' ),
				     	'easeInSine' => __( 'easeInSine', 'avante-elementor' ),
				     	'easeInExpo' => __( 'easeInExpo', 'avante-elementor' ),
				     	'easeInCirc' => __( 'easeInCirc', 'avante-elementor' ),
				     	'easeInBack' => __( 'easeInBack', 'avante-elementor' ),
				     	'easeInElastic' => __( 'easeInElastic', 'avante-elementor' ),
				     	'easeInBounce' => __( 'easeInBounce', 'avante-elementor' ),
				     	'easeOutQuad' => __( 'easeOutQuad', 'avante-elementor' ),
				     	'easeOutCubic' => __( 'easeOutCubic', 'avante-elementor' ),
				     	'easeOutQuart' => __( 'easeOutQuart', 'avante-elementor' ),
				     	'easeOutQuint' => __( 'easeOutQuint', 'avante-elementor' ),
				     	'easeOutSine' => __( 'easeOutSine', 'avante-elementor' ),
				     	'easeOutExpo' => __( 'easeOutExpo', 'avante-elementor' ),
				     	'easeOutCirc' => __( 'easeOutCirc', 'avante-elementor' ),
				     	'easeOutBack' => __( 'easeOutBack', 'avante-elementor' ),
				     	'easeOutElastic' => __( 'easeOutElastic', 'avante-elementor' ),
				     	'easeOutBounce' => __( 'easeOutBounce', 'avante-elementor' ),
				     	'easeInOutQuad' => __( 'easeInOutQuad', 'avante-elementor' ),
				     	'easeInOutCubic' => __( 'easeInOutCubic', 'avante-elementor' ),
				     	'easeInOutQuart' => __( 'easeInOutQuart', 'avante-elementor' ),
				     	'easeInOutQuint' => __( 'easeInOutQuint', 'avante-elementor' ),
				     	'easeInOutSine' => __( 'easeInOutSine', 'avante-elementor' ),
				     	'easeInOutExpo' => __( 'easeInOutExpo', 'avante-elementor' ),
				     	'easeInOutCirc' => __( 'easeInOutCirc', 'avante-elementor' ),
				     	'easeInOutBack' => __( 'easeInOutBack', 'avante-elementor' ),
				     	'easeInOutElastic' => __( 'easeInOutElastic', 'avante-elementor' ),
				     	'easeInOutBounce' => __( 'easeInOutBounce', 'avante-elementor' ),
				    ],
					'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
				]
			);*/
			
			$element->add_control(
			    'avante_ext_scrollme_smoothness',
			    [
			        'label' => __( 'Smoothness', 'avante-elementor' ),
			        'description' => __( 'factor that slowdown the animation, the more the smoothier', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 30,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0,
			                'max' => 100,
			                'step' => 5,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			/*$element->add_control(
				'avante_ext_scrollme_duration',
				[
					'label' => __( 'Animation Duration (ms)', 'avante-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 5,
					'max' => 5000,
					'step' => 5,
					'default' => 400,
					'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => false,
					'selectors' => [
			            '.elementor-widget.elementor-element-{{ID}}' => 'transition-duration: {{VALUE}}ms !important',
			        ],
				]
			);*/
			
			$element->add_control(
			    'avante_ext_scrollme_scalex',
			    [
			        'label' => __( 'Scale X', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 1,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0.1,
			                'max' => 2,
			                'step' => 0.1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_scrollme_scaley',
			    [
			        'label' => __( 'Scale Y', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 1,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0.1,
			                'max' => 2,
			                'step' => 0.1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_scrollme_scalez',
			    [
			        'label' => __( 'Scale Z', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 1,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0.1,
			                'max' => 2,
			                'step' => 0.1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
		
			$element->add_control(
			    'avante_ext_scrollme_rotatex',
			    [
			        'label' => __( 'Rotate X', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -360,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_scrollme_rotatey',
			    [
			        'label' => __( 'Rotate Y', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -360,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_scrollme_rotatez',
			    [
			        'label' => __( 'Rotate Z', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -360,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_scrollme_translatex',
			    [
			        'label' => __( 'Translate X', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -1000,
			                'max' => 1000,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_scrollme_translatey',
			    [
			        'label' => __( 'Translate Y', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -1000,
			                'max' => 1000,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_scrollme_translatez',
			    [
			        'label' => __( 'Translate Z', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -1000,
			                'max' => 1000,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_scrollme' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
				'avante_ext_is_smoove',
				[
					'label'        => esc_html__( 'Entrance Animation', 'avante-elementor' ),
					'description'  => esc_html__( 'Add custom entrance animation to element', 'avante-elementor' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'avante-elementor' ),
					'label_off'    => esc_html__( 'No', 'avante-elementor' ),
					'return_value' => 'true',
					'default'      => 'false',
					'frontend_available' => true,
				]
			);

			$element->add_control(
				'avante_ext_smoove_disable',
				[
					'label'       => esc_html__( 'Disable for', 'avante-elementor' ),
					'type' => Elementor\Controls_Manager::SELECT,
					'default' => 1,
				    'options' => [
				     	1 => __( 'None', 'avante-elementor' ),
				     	769 => __( 'Mobile and Tablet', 'avante-elementor' ),
				     	415 => __( 'Mobile', 'avante-elementor' ),
				    ],
					'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
				]
			);
			
			$element->add_control(
				'avante_ext_smoove_easing',
				[
					'label'       => esc_html__( 'Easing', 'avante-elementor' ),
					'type' => Elementor\Controls_Manager::SELECT,
					'default' => '0.250, 0.250, 0.750, 0.750',
				    'options' => [
					    '0.250, 0.250, 0.750, 0.750' => __( 'linear', 'avante-elementor' ),
				     	'0.250, 0.100, 0.250, 1.000' => __( 'ease', 'avante-elementor' ),
				     	'0.420, 0.000, 1.000, 1.000' => __( 'ease-in', 'avante-elementor' ),
				     	'0.000, 0.000, 0.580, 1.000' => __( 'ease-out', 'avante-elementor' ),
				     	'0.420, 0.000, 0.580, 1.000' => __( 'ease-in-out', 'avante-elementor' ),
				     	'0.550, 0.085, 0.680, 0.530' => __( 'easeInQuad', 'avante-elementor' ),
				     	'0.550, 0.055, 0.675, 0.190' => __( 'easeInCubic', 'avante-elementor' ),
				     	'0.895, 0.030, 0.685, 0.220' => __( 'easeInQuart', 'avante-elementor' ),
				     	'0.755, 0.050, 0.855, 0.060' => __( 'easeInQuint', 'avante-elementor' ),
				     	'0.470, 0.000, 0.745, 0.715' => __( 'easeInSine', 'avante-elementor' ),
				     	'0.950, 0.050, 0.795, 0.035' => __( 'easeInExpo', 'avante-elementor' ),
				     	'0.600, 0.040, 0.980, 0.335' => __( 'easeInCirc', 'avante-elementor' ),
				     	'0.600, -0.280, 0.735, 0.045' => __( 'easeInBack', 'avante-elementor' ),
				     	'0.250, 0.460, 0.450, 0.940' => __( 'easeOutQuad', 'avante-elementor' ),
				     	'0.215, 0.610, 0.355, 1.000' => __( 'easeOutCubic', 'avante-elementor' ),
				     	'0.165, 0.840, 0.440, 1.000' => __( 'easeOutQuart', 'avante-elementor' ),
				     	'0.230, 1.000, 0.320, 1.000' => __( 'easeOutQuint', 'avante-elementor' ),
				     	'0.390, 0.575, 0.565, 1.000' => __( 'easeOutSine', 'avante-elementor' ),
				     	'0.190, 1.000, 0.220, 1.000' => __( 'easeOutExpo', 'avante-elementor' ),
				     	'0.075, 0.820, 0.165, 1.000' => __( 'easeOutCirc', 'avante-elementor' ),
				     	'0.175, 0.885, 0.320, 1.275' => __( 'easeOutBack', 'avante-elementor' ),
				     	'0.455, 0.030, 0.515, 0.955' => __( 'easeInOutQuad', 'avante-elementor' ),
				     	'0.645, 0.045, 0.355, 1.000' => __( 'easeInOutCubic', 'avante-elementor' ),
				     	'0.770, 0.000, 0.175, 1.000' => __( 'easeInOutQuart', 'avante-elementor' ),
				     	'0.860, 0.000, 0.070, 1.000' => __( 'easeInOutQuint', 'avante-elementor' ),
				     	'0.445, 0.050, 0.550, 0.950' => __( 'easeInOutSine', 'avante-elementor' ),
				     	'1.000, 0.000, 0.000, 1.000' => __( 'easeInOutExpo', 'avante-elementor' ),
				     	'0.785, 0.135, 0.150, 0.860' => __( 'easeInOutCirc', 'avante-elementor' ),
				     	'0.680, -0.550, 0.265, 1.550' => __( 'easeInOutBack', 'avante-elementor' ),
				    ],
					'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => false,
					'selectors' => [
			            '.elementor-element.elementor-element-{{ID}}' => 'transition-timing-function: cubic-bezier({{VALUE}})',
			        ],
				]
			);
			
			$element->add_control(
				'avante_ext_smoove_delay',
				[
					'label' => __( 'Animation Delay (ms)', 'avante-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 0,
					'max' => 5000,
					'step' => 5,
					'default' => 0,
					'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => false,
					'selectors' => [
			            '.elementor-element.elementor-element-{{ID}}' => 'transition-delay: {{VALUE}}ms',
			        ],
				]
			);
			
			$element->add_control(
				'avante_ext_smoove_duration',
				[
					'label' => __( 'Animation Duration (ms)', 'avante-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 5,
					'max' => 5000,
					'step' => 5,
					'default' => 400,
					'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
					/*'selectors' => [
			            '.elementor-widget.elementor-element-{{ID}}' => 'transition-duration: {{VALUE}}ms !important',
			        ],*/
				]
			);
			
			$element->add_control(
			    'avante_ext_smoove_opacity',
			    [
			        'label' => __( 'Opacity', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0,
			                'max' => 1,
			                'step' => 0.1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => false,
					'selectors' => [
			            '.elementor-widget.elementor-element-{{ID}}' => 'opacity: {{SIZE}}',
			        ],
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_scalex',
			    [
			        'label' => __( 'Scale X', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 1,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0.1,
			                'max' => 2,
			                'step' => 0.1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_scaley',
			    [
			        'label' => __( 'Scale Y', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 1,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0.1,
			                'max' => 2,
			                'step' => 0.1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_rotatex',
			    [
			        'label' => __( 'Rotate X', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -360,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_rotatey',
			    [
			        'label' => __( 'Rotate Y', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -360,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_rotatez',
			    [
			        'label' => __( 'Rotate Z', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -360,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_translatex',
			    [
			        'label' => __( 'Translate X', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -1000,
			                'max' => 1000,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_translatey',
			    [
			        'label' => __( 'Translate Y', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -1000,
			                'max' => 1000,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_translatez',
			    [
			        'label' => __( 'Translate Z', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => -1000,
			                'max' => 1000,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_skewx',
			    [
			        'label' => __( 'Skew X', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_skewy',
			    [
			        'label' => __( 'Skew Y', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0,
			                'max' => 360,
			                'step' => 1,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
			    'avante_ext_smoove_perspective',
			    [
			        'label' => __( 'Perspective', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 1000,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 5,
			                'max' => 4000,
			                'step' => 5,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_smoove' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
				'avante_ext_is_parallax_mouse',
				[
					'label'        => esc_html__( 'Mouse Parallax', 'avante-elementor' ),
					'description'  => esc_html__( 'Add parallax to element when moving mouse position', 'avante-elementor' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'avante-elementor' ),
					'label_off'    => esc_html__( 'No', 'avante-elementor' ),
					'return_value' => 'true',
					'default'      => 'false',
					'frontend_available' => true,
				]
			);
			
			$element->add_control(
			    'avante_ext_is_parallax_mouse_depth',
			    [
			        'label' => __( 'Depth', 'avante-elementor' ),
			        'type' => Elementor\Controls_Manager::SLIDER,
			        'default' => [
			            'size' => 0.2,
			        ],
			        'range' => [
			            'px' => [
			                'min' => 0.1,
			                'max' => 2,
			                'step' => 0.05,
			            ]
			        ],
			        'size_units' => [ 'px' ],
			        'condition' => [
						'avante_ext_is_parallax_mouse' => 'true',
					],
					'frontend_available' => true,
			    ]
			);
			
			$element->add_control(
				'avante_ext_is_infinite',
				[
					'label'        => esc_html__( 'Infinite Animation', 'avante-elementor' ),
					'description'  => esc_html__( 'Add custom infinite animation to element', 'avante-elementor' ),
					'type'         => Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'avante-elementor' ),
					'label_off'    => esc_html__( 'No', 'avante-elementor' ),
					'return_value' => 'true',
					'default'      => 'false',
					'frontend_available' => true,
				]
			);
			
			$element->add_control(
				'avante_ext_infinite_animation',
				[
					'label'       => esc_html__( 'Easing', 'avante-elementor' ),
					'type' => Elementor\Controls_Manager::SELECT,
					'default' => 'if_bounce',
				    'options' => [
					    'if_swing1' => __( 'Swing 1', 'avante-elementor' ),
					    'if_swing2' => __( 'Swing 2', 'avante-elementor' ),
				     	'if_wave' 	=> __( 'Wave', 'avante-elementor' ),
				     	'if_tilt' 	=> __( 'Tilt', 'avante-elementor' ),
				     	'if_bounce' => __( 'Bounce', 'avante-elementor' ),
				     	'if_scale' 	=> __( 'Scale', 'avante-elementor' ),
				     	'if_spin' 	=> __( 'Spin', 'avante-elementor' ),
				    ],
					'condition' => [
						'avante_ext_is_infinite' => 'true',
					],
					'frontend_available' => true,
				]
			);
			
			$element->add_control(
				'avante_ext_infinite_easing',
				[
					'label'       => esc_html__( 'Easing', 'avante-elementor' ),
					'type' => Elementor\Controls_Manager::SELECT,
					'default' => '0.250, 0.250, 0.750, 0.750',
				    'options' => [
					    '0.250, 0.250, 0.750, 0.750' => __( 'linear', 'avante-elementor' ),
				     	'0.250, 0.100, 0.250, 1.000' => __( 'ease', 'avante-elementor' ),
				     	'0.420, 0.000, 1.000, 1.000' => __( 'ease-in', 'avante-elementor' ),
				     	'0.000, 0.000, 0.580, 1.000' => __( 'ease-out', 'avante-elementor' ),
				     	'0.420, 0.000, 0.580, 1.000' => __( 'ease-in-out', 'avante-elementor' ),
				     	'0.550, 0.085, 0.680, 0.530' => __( 'easeInQuad', 'avante-elementor' ),
				     	'0.550, 0.055, 0.675, 0.190' => __( 'easeInCubic', 'avante-elementor' ),
				     	'0.895, 0.030, 0.685, 0.220' => __( 'easeInQuart', 'avante-elementor' ),
				     	'0.755, 0.050, 0.855, 0.060' => __( 'easeInQuint', 'avante-elementor' ),
				     	'0.470, 0.000, 0.745, 0.715' => __( 'easeInSine', 'avante-elementor' ),
				     	'0.950, 0.050, 0.795, 0.035' => __( 'easeInExpo', 'avante-elementor' ),
				     	'0.600, 0.040, 0.980, 0.335' => __( 'easeInCirc', 'avante-elementor' ),
				     	'0.600, -0.280, 0.735, 0.045' => __( 'easeInBack', 'avante-elementor' ),
				     	'0.250, 0.460, 0.450, 0.940' => __( 'easeOutQuad', 'avante-elementor' ),
				     	'0.215, 0.610, 0.355, 1.000' => __( 'easeOutCubic', 'avante-elementor' ),
				     	'0.165, 0.840, 0.440, 1.000' => __( 'easeOutQuart', 'avante-elementor' ),
				     	'0.230, 1.000, 0.320, 1.000' => __( 'easeOutQuint', 'avante-elementor' ),
				     	'0.390, 0.575, 0.565, 1.000' => __( 'easeOutSine', 'avante-elementor' ),
				     	'0.190, 1.000, 0.220, 1.000' => __( 'easeOutExpo', 'avante-elementor' ),
				     	'0.075, 0.820, 0.165, 1.000' => __( 'easeOutCirc', 'avante-elementor' ),
				     	'0.175, 0.885, 0.320, 1.275' => __( 'easeOutBack', 'avante-elementor' ),
				     	'0.455, 0.030, 0.515, 0.955' => __( 'easeInOutQuad', 'avante-elementor' ),
				     	'0.645, 0.045, 0.355, 1.000' => __( 'easeInOutCubic', 'avante-elementor' ),
				     	'0.770, 0.000, 0.175, 1.000' => __( 'easeInOutQuart', 'avante-elementor' ),
				     	'0.860, 0.000, 0.070, 1.000' => __( 'easeInOutQuint', 'avante-elementor' ),
				     	'0.445, 0.050, 0.550, 0.950' => __( 'easeInOutSine', 'avante-elementor' ),
				     	'1.000, 0.000, 0.000, 1.000' => __( 'easeInOutExpo', 'avante-elementor' ),
				     	'0.785, 0.135, 0.150, 0.860' => __( 'easeInOutCirc', 'avante-elementor' ),
				     	'0.680, -0.550, 0.265, 1.550' => __( 'easeInOutBack', 'avante-elementor' ),
				    ],
					'condition' => [
						'avante_ext_is_infinite' => 'true',
					],
					'frontend_available' => true
				]
			);
			
			$element->add_control(
				'avante_ext_infinite_duration',
				[
					'label' => __( 'Animation Duration (s)', 'avante-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 15,
					'step' => 1,
					'default' => 4,
					'condition' => [
						'avante_ext_is_infinite' => 'true',
					],
					'frontend_available' => true
				]
			);

			$element->end_controls_section();
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}
}

/**
 * Returns instance of Avante_Ext
 *
 * @return object
 */
function avante_ext() {
	return Avante_Ext::get_instance();
}
