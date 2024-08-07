<?php
namespace AvanteElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Discography Coverflow
 *
 * Elementor widget for portfolio posts
 *
 * @since 1.0.0
 */
class Avante_Portfolio_Coverflow extends Widget_Base {

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
		return 'avante-portfolio-coverflow';
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
		return __( 'Portfolio Coverflow', 'avante-elementor' );
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
		return 'eicon-slider-album';
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
		return [ 'swiper', 'avante-elementor' ];
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
			'slide_image', [
				'label' => __( 'Image', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_title', [
				'label' => __( 'Title', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'slide_subtitle', [
				'label' => __( 'Sub Title', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'slide_link', [
				'label' => __( 'Link URL', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::URL,
				'show_external' => true,
			]
		);
		
		$repeater->add_control(
			'slide_link_label', [
				'label' => __( 'Link Label', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'slides',
			[
				'label' => __( 'Slides', 'avante-elementor' ),
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
		    'width',
		    [
		        'label' => __( 'Width (in px)', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 400,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 100,
		                'max' => 2000,
		                'step' => 5,
		            ]
		        ],
		        'size_units' => [ 'px' ],
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide' => 'width: {{SIZE}}{{UNIT}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'height',
		    [
		        'label' => __( 'Height (in px)', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 400,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 50,
		                'max' => 2000,
		                'step' => 5,
		            ]
		        ],
		        'size_units' => [ 'px' ],
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide' => 'height: {{SIZE}}{{UNIT}}',
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article' => 'height: {{SIZE}}{{UNIT}}',
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview' => 'height: {{SIZE}}{{UNIT}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'initial_slide',
		    [
		        'label' => __( 'Initial Slide', 'avante-elementor' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 1,
		        ],
		        'range' => [
		            'px' => [
		                'min' => 1,
		                'max' => 3,
		                'step' => 1,
		            ]
		        ],
		        'size_units' => [ 'px' ]
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
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-thumbnail h2' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} div.portfolio-coverflow .swiper-slide .swiper-content .article .article-thumbnail h2',
			]
		);
		
		$this->add_control(
			'title_text_align',
			[
				'label' => __( 'Alignment', 'avante-elementor' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
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
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
		            '{{WRAPPER}} div.portfolio-coverflow .swiper-slide .swiper-content .article' => 'text-align: {{VALUE}}',
		        ],
			]
		);
				
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_subtitle_style',
			array(
				'label'      => esc_html__( 'Sub Title', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_control(
		    'subtitle_color',
		    [
		        'label' => __( 'Sub Title Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#ffffff',
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-thumbnail h2 span' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Sub Title Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} div.portfolio-coverflow .swiper-slide .swiper-content .article .article-thumbnail h2 span',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_icon_style',
			array(
				'label'      => esc_html__( 'Link', 'avante-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);
		
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'link-label_typography',
				'label' => __( 'Link Label Typography', 'avante-elementor' ),
				'selector' => '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview .controls label span',
			]
		);
		
		$this->add_control(
		    'link_color',
		    [
		        'label' => __( 'Link Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#222222',
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview .controls label span' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'link_bg_color',
		    [
		        'label' => __( 'Link Background Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#f5f5f5',
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview .controls label' => 'background-color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'link_hover_color',
		    [
		        'label' => __( 'Link Hover Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#3d64ff',
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview .controls label:hover span' => 'color: {{VALUE}}',
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview .controls label:hover span a' => 'color: {{VALUE}}',
		        ],
		    ]
		);
		
		$this->add_control(
		    'link_active_color',
		    [
		        'label' => __( 'Link Active Color', 'avante-elementor' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '#3d64ff',
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview .controls label.active span' => 'color: {{VALUE}}',
		            '{{WRAPPER}} .portfolio-coverflow .swiper-slide .swiper-content .article .article-preview .controls label.active span a' => 'color: {{VALUE}}',
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
		include(AVANTE_ELEMENTOR_PATH.'templates/portfolio-coverflow/index.php');
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
