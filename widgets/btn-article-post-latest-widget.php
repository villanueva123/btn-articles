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

class BTN_Article_Post_Latest_Widget extends \Elementor\Widget_Base{

	public static $slug = 'elementor-btn-article-post-latest';

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
		return __('Article Latest Post', 'btn-articles');
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

    /**
     * Image
      */
    $this->add_control( 'show_image', [
      'label' => __( 'Image', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SWITCHER,
      'label_on' => __( 'Show', 'btn-articles' ),
      'label_off' => __( 'Hide', 'btn-articles' ),
      'default' => 'yes',
      'separator' => 'before',
  	] );
    $show_image_conditions = [ 'terms' => [ [
      'name'  => 'show_image',
      'value' => 'yes'
    ] ] ];
    $this->add_control( 'link_image', [
      'label' => __( 'Link Image', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SWITCHER,
      'label_on' => __( 'Link', 'btn-articles' ),
      'label_off' => __( 'Image', 'btn-articles' ),
      'default' => 'yes',
      'conditions' => $show_image_conditions
  	] );


		/**
		 * Image
			*/
		$this->add_control( 'show_category', [
			'label' => __( 'Category', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'Show', 'btn-articles' ),
			'label_off' => __( 'Hide', 'btn-articles' ),
			'default' => 'yes',
			'separator' => 'before',
		] );
		$show_category_conditions = [ 'terms' => [ [
			'name'  => 'show_category',
			'value' => 'yes'
		] ] ];
		$this->add_control( 'link_category', [
			'label' => __( 'Link Category', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'Link', 'btn-articles' ),
			'label_off' => __( 'Image', 'btn-articles' ),
			'default' => 'yes',
			'conditions' => $show_category_conditions
		] );

    /**
     * Title
      */
    $this->add_control( 'show_title', [
      'label' => __( 'Title', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SWITCHER,
      'label_on' => __( 'Show', 'btn-articles' ),
      'label_off' => __( 'Hide', 'btn-articles' ),
      'default' => 'yes',
      'separator' => 'before',
		] );
    $show_title_conditions = [ 'terms' => [ [
      'name'  => 'show_title',
      'value' => 'yes'
    ] ] ];
    $this->add_control( 'link_title', [
      'label' => __( 'Link Title', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SWITCHER,
      'label_on' => __( 'Link', 'btn-articles' ),
      'label_off' => __( 'Text', 'btn-articles' ),
      'default' => 'yes',
      'conditions' => $show_title_conditions
		] );

		/**
		 * Excerpt
			*/
		$this->add_control( 'show_excerpt', [
			'label' => __( 'Excerpt', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'Show', 'btn-articles' ),
			'label_off' => __( 'Hide', 'btn-articles' ),
			'default' => 'yes',
			'separator' => 'before',
		] );
    $this->end_controls_section();



    /**
      * Style Section
    */
    $this->start_controls_section( 'style_section', [
      'label' => __( 'Typography', 'btn-articles' ),
      'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		] );
    $text_array = [
      [
        'slug'        => 'title',
        'label'       => __( 'Post Title', 'btn-articles' ),
        'conditions'  => $show_title_conditions,
        'include' => [
          'color'       => [ 'value' => \Elementor\Scheme_Color::COLOR_2 ],
          'typography'  => [ 'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1 ],
          'margins'     => [
            [ 'prop' => 'margin-top', 'label' => __( 'Margin Top', 'btn-articles' ) ],
            [ 'prop' => 'margin-bottom', 'label' => __( 'Margin Bottom', 'btn-articles' ) ],
          ]
        ]
      ],
			[
				'slug'        => 'excerpt',
				'label'       => __( 'Excerpt', 'btn-articles' ),
				'conditions'  => $show_title_conditions,
				'include' => [
					'color'       => [ 'value' => \Elementor\Scheme_Color::COLOR_2 ],
					'typography'  => [ 'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1 ],
					'margins'     => [
						[ 'prop' => 'margin-top', 'label' => __( 'Margin Top', 'btn-articles' ) ],
						[ 'prop' => 'margin-bottom', 'label' => __( 'Margin Bottom', 'btn-articles' ) ],
					]
				]
			],
    ];
    $widget_name = $this->get_name();

    foreach ($text_array as $t => $text_config) {
      $slug = $text_config['slug'];
      $conditions = $text_config['conditions'];
      //COLOUR = $text_config['color'];
      $selector = 'btn-articles_latest__' . $slug;
      $include = $text_config['include'];
      #Heading Style
      $this->add_control( 'heading_'.$slug.'_style', [
        'label'       => $text_config['label'],
      	'type'        => \Elementor\Controls_Manager::HEADING,
        'conditions'  => $conditions,
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
          'conditions'  => $conditions
        ] );
      }
      if( isset($include['typography']) && isset($include['typography']['scheme']) ){
        $this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
          'name'        => $slug .'_typography',
          'scheme'      => $include['typography']['scheme'],
          'selector'    => '{{WRAPPER}} .'.$selector,
          'conditions'  => $conditions
        ] );
      }
      if( isset($include['margins']) ){
        foreach ( $include['margins'] as $p => $margin ) {
          $prop = $margin['prop'];
          $this->add_control( $slug . '_' . $prop, [
            'label'       => $margin['label'],
            'type'        => \Elementor\Controls_Manager::SLIDER,
            'range'       => [ 'em' => [ 'max' => 2 ] ],
            'selectors'   => [ '{{WRAPPER}} .'.$selector => $prop . ': {{SIZE}}{{UNIT}};display:inline-block' ],
            'conditions'  => $conditions
          ] );
        }
      }
    }
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
		$image_check = ( $settings['show_image'] == 'yes' ) ? true : false;
		$image_link_check = ( $image_check && $settings['link_image'] == 'yes' ) ? true : false;
		$title_check = ( $settings['show_title'] == 'yes' ) ? true : false;
		$title_link_check = ( $title_check && $settings['link_title'] == 'yes' ) ? true : false;
		$title_check = ( $settings['show_title'] == 'yes' ) ? true : false;
		$excerpt_check = ( $settings['show_excerpt'] == 'yes' ) ? true : false;
		$title_link_check = ( $title_check && $settings['link_title'] == 'yes' ) ? true : false;
		$category_check = ( $settings['show_category'] == 'yes' ) ? true : false;
		$category_link_check = ( $category_check && $settings['link_category'] == 'yes' ) ? true : false;
		$template = btn_articles()->template_part_path('latest-article.php');
		$post_type = btn_articles()->articles()->get_post_slug();
		$post_taxonomy = btn_articles()->articles()->get_taxonomy_slug();

		$args = [
			'post_type'				=> $post_type,
			'posts_per_page'	=> 1,
		];
		$queried_object = get_queried_object();
		$taxonomy = $queried_object->taxonomy;
		if(is_tax()){
			$term_id = $queried_object->term_id;
			$args['tax_query'] = [
			 [
				 'taxonomy'	=> $taxonomy,
				 'terms' 	=> $term_id,
				 'field'		=> 'term_id',
			 ]
		 ];
		}
		$loop = new WP_Query( $args );
		if($template > ''){
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
