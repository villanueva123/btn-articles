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

class BTN_Article_Quote_Widget extends \Elementor\Widget_Base{

	public static $slug = 'elementor-btn-article-quote';

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
		return __('Article Quote', 'btn-articles');
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

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Quote Content', 'btn-articles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'item_description',
			[
				'label' => __( 'Description', 'btn-articles' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Default description', 'btn-articles' ),
				'placeholder' => __( 'Type your description here', 'btn-articles' ),
			]
		);


    $this->end_controls_section();


    /**
      * Style Section
    */
    $this->start_controls_section( 'style_section', [
      'label' => __( 'Typography & Border', 'btn-articles' ),
      'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		] );
    $text_array = [
      [
        'slug'        => 'content',
        'label'       => __( 'Post Excerpt', 'btn-articles' ),
        'include' => [
          'color'       => [ 'value' => \Elementor\Scheme_Color::COLOR_3 ],
          'typography'  => [ 'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3 ],
        ]
      ],
    ];
		$this->add_control( 'row_gap', [
			'label' => __( 'Rows Gap', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 35,
			],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 100,
				],
			],
			'frontend_available' => true,
			'selectors' => [
				'.btn-articles_quote__content' => 'padding-bottom: {{SIZE}}{{UNIT}};padding-top: {{SIZE}}{{UNIT}}',
			],
		]);

    $widget_name = $this->get_name();

    foreach ($text_array as $t => $text_config) {
      $slug = $text_config['slug'];
      //COLOUR = $text_config['color'];
      $selector = 'btn-articles_quote__' . $slug;
      $include = $text_config['include'];
      #Heading Style
      $this->add_control( 'heading_'.$slug.'_style', [
        'label'       => $text_config['label'],
      	'type'        => \Elementor\Controls_Manager::HEADING,

        'separator'   => 'after',
      ] );
      if( isset($include['color']) ){
        #Colour
        $this->add_control( $slug.'_color', [
          'label'   => __( 'Color', 'btn-articles' ),
          'type'    => \Elementor\Controls_Manager::COLOR,
          'scheme'  => [
            'type'  => \Elementor\Scheme_Color::get_type(),
            'value' => $include['color']['value'],
          ],
          'selectors'   => [ '{{WRAPPER}} .'.$selector => 'color: {{VALUE}};'],

        ] );
      }
      if( isset($include['typography']) && isset($include['typography']['scheme']) ){
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
          'name'        => $slug .'_typography',
          'scheme'      => $include['typography']['scheme'],
          'selector'    => '{{WRAPPER}} .'.$selector,

        ] );
      }

    }


		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Border', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .btn-articles_quote__border',
			]
		);
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
		$settings = $this->get_settings_for_display();
		echo '<div class="btn-articles_quote__content btn-articles_quote__border ">' . $settings['item_description'] . '</div>';
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
