<?php

if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

class BTN_Article_Post_Sponsored_Widget extends \Elementor\Widget_Base{

	public static $slug = 'elementor-btn-article-sponsored';

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() { return self::$slug; }

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __('Article Sponsored Content', 'btn-articles');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fas fa-newspaper';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
			return ['btn-articles'];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		/**
      * Layout
    */
    $this->start_controls_section( 'layout_section', [
      'label' => __( 'Layout', 'btn-articles' ),
      'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
 		] );

		$options = btn_articles()->elementor()->get_article_option();
		$this->add_control( 'sponsored-title', [
			'label' => __( 'Sponsored Title', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'SPONSORED ARTICLE', 'btn-articles' ),
		]);
		$this->add_control( 'show_sponsored', [
			'label' => __( 'Sponsored Content', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'options' => [
				'no'	=> __('Select Sponsored Content'),
				'yes' => __('Used Default Meta Value', 'btn-articles' ),
			],
		] );
		$show_sponsored_conditions = [ 'terms' => [ [
			'name'  => 'show_sponsored',
			'value' => 'no'
		] ] ];
		$this->add_control( 'sponsored_id', [
			'label' => __( 'Sponsored Article', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'options' => $options,
			'conditions' => $show_sponsored_conditions
		]);

		/**
		 * Readmore
			*/
		$this->add_control( 'show_readmore', [
			'label' => __( 'Readmore Link', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'Show', 'btn-articles' ),
			'label_off' => __( 'Hide', 'btn-articles' ),
			'default' => 'yes',
			'separator' => 'before',
		] );
		$show_readmore_conditions = [ 'terms' => [ [
			'name'  => 'show_readmore',
			'value' => 'yes'
		] ] ];
		$this->add_control( 'link-text', [
			'label' => __( 'Link Text', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'conditions' => $show_readmore_conditions
		]);

    $this->end_controls_section();



    /**
      * Post Style
    */
    $this->start_controls_section( 'section_design_card', [
      'label' => __( 'Post Style', 'btn-articles' ),
      'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		] );
    $post_selector = '.btn-articles article';
		$this->add_control( 'card_bg_color', [
      'label' => __( 'Background Color', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} ' . $post_selector => 'background-color: {{VALUE}}'],
		] );

		$this->add_control( 'card_border_color', [
      'label' => __( 'Border Color', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::COLOR,
      'selectors' => [ '{{WRAPPER}} ' . $post_selector => 'border-color: {{VALUE}}']
		] );

		$this->add_control( 'card_border_width', [
      'label' => __( 'Border Width', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SLIDER,
      'size_units' => [ 'px' ],
      'range' => [
        'px' => [
          'min' => 0,
          'max' => 15,
        ],
      ],
      'selectors' => [ '{{WRAPPER}} ' . $post_selector => 'border-width: {{SIZE}}{{UNIT}}']
		] );

    $this->add_control( 'card_border_style', [
      'label' => __( 'Border Style', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SELECT,
      'default' => [ 'solid' ],
      'options' => [
        'none'    => __( 'None', 'btn-articles' ),
        'solid'   => __( 'Solid', 'btn-articles' ),
        'dotted'  => __( 'Dotted', 'btn-articles' ),
        'double'  => __( 'Double', 'btn-articles' ),
        'groove'  => __( 'Groove', 'btn-articles' ),
        'ridge'   => __( 'Ridge', 'btn-articles' ),
        'inset'   => __( 'Inset', 'btn-articles' ),
        'outset'  => __( 'Outset', 'btn-articles' ),
        'inherit' => __( 'Inherit', 'btn-articles' ),
      ],
      'selectors' => [ '{{WRAPPER}} ' . $post_selector => 'border-style: {{VALUE}}']
    ] );

		$this->add_control( 'card_border_radius', [
      'label' => __( 'Border Radius', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 200,
				],
			],
      'selectors' => [ '{{WRAPPER}} ' . $post_selector => 'border-radius: {{SIZE}}{{UNIT}}']
		] );
		$this->add_control( 'box_shadow_box_shadow_type', [
      'label' => __( 'Box Shadow', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SWITCHER,
			'prefix_class' => 'elementor-card-shadow-',
			'default' => 'no',
      'selectors' => [ '{{WRAPPER}} ' . $post_selector => '-webkit-box-shadow: 0 0 10px 0 rgba(0,0,0,.15); box-shadow: 0 0 10px 0 rgba(0,0,0,.15);' ]
		] );


    $this->add_control( 'padding', [
      'label' => __( 'Margin', 'plugin-domain' ),
      'type' => \Elementor\Controls_Manager::DIMENSIONS,
      'size_units' => [ 'px', '%', 'em' ],
      'selectors' => [ '{{WRAPPER}} .btn-articles__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'],
		] );


		$this->end_controls_section();


	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$html = '';
		$settings = $this->get_settings_for_display();
		$post_id = get_the_ID();
		$default_id = (int)$settings['sponsored_id'];
		$css_class = '';
		$readmore =  ( $settings['link-text'] > '' ) ?  $settings['link-text'] : 'Read More';
		$section_title = $settings['sponsored-title'];
		$template = btn_articles()->template_part_path('sponsored-content.php');
		$recent_post_id = btn_articles()->articles()->get_latest_post_id($post_id);
		$sponsored_id = get_post_meta($post_id, btn_articles()->article_screen()::SPONSORED_CONTENT, true );
		$sponsored_content = ($sponsored_id > '')? $sponsored_id : '';
		$id = $sponsored_content;
		$post = get_post($id);
		$permalink = get_permalink($id);
		$excerpt = $post->post_excerpt;
		$sponsored_title = $post->post_title;
		$img_url = get_the_post_thumbnail_url($id,'full');
		$img = ($img_url > '')? true : false;
		$full_width_class = (!$img)? 'btn-articles-sponsored-full-content':'';
		if($template > '' && $id > 0 ){
				include $template;
		}
		echo $html;
	}

	/**
	 * Check if is in edit mode
	 *
	 * Return true/false
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function is_edit(){
		return \Elementor\Plugin::$instance->editor->is_edit_mode();
	}

}
