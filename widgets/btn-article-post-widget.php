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

class BTN_Article_Post_Widget extends \Elementor\Widget_Base{

	public static $slug = 'elementor-btn-article-post';

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
		return __('Article Post', 'btn-articles');
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

		/**
		 * Sponsored Content
			*/
		$options = btn_articles()->elementor()->get_article_option();
		$this->add_control( 'show_sponsored_content', [
			'label' => __( 'Sponsored Content', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'Show', 'btn-articles' ),
			'label_off' => __( 'Hide', 'btn-articles' ),
			'default' => 'yes',
			'separator' => 'before',
		] );
		$show_sponsored_conditions = [ 'terms' => [ [
			'name'  => 'show_sponsored_content',
			'value' => 'yes'
		] ] ];
		$this->add_control( 'sponsored_id', [
			'label' => __( 'Sponsored Article', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::SELECT2,
			'options' => $options,
			'conditions' => $show_sponsored_conditions
		]);
		$this->add_control( 'sponsored_row', [
			'label' => __( 'Sponsored Row', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'default' => 1,
			'conditions' => $show_sponsored_conditions
		]);
		$this->add_control( 'sponsored-title', [
			'label' => __( 'Sponsored Title', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'default' => __( 'SPONSORED ARTICLE', 'btn-articles' ),
			'conditions' => $show_sponsored_conditions
		]);




    $this->end_controls_section();

    /**
      * Query
    */
    $this->start_controls_section( 'query_section', [
      'label' => __( 'Post Query', 'btn-articles' ),
   		'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ] );
    $this->add_control( 'number-posts', [
      'label' => __( 'Number of Posts', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'default' => 8,
    ]);
		$this->add_control( 'offset', [
			'label' => __( 'Offset', 'btn-articles' ),
			'type' => \Elementor\Controls_Manager::NUMBER,
			'min' => 0,
			'max' => 100,
			'step' => 1,
			'default' => 1,
		]);
    $this->add_control( 'orderby', [
      'label' => __( 'Order By', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SELECT,
      'default' => 'post_date',
      'options' => [
        'post_date' => __( 'Date', 'btn-articles' ),
        'post_title' => __( 'Title', 'btn-articles' ),
        'menu_order' => __( 'Menu Order', 'btn-articles' ),
        'rand' => __( 'Random', 'btn-articles' ),
      ]
		] );
    $this->add_control( 'order', [
      'label' => __( 'Order', 'btn-articles' ),
      'type' => \Elementor\Controls_Manager::SELECT,
      'default' => 'asc',
      'options' => [
        'asc' => __( 'Ascending', 'btn-articles' ),
        'desc' => __( 'Descending', 'btn-articles' ),
      ]
		]);

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
        'label'       => __( 'Post Excerpt', 'btn-articles' ),
				'conditions'  => $show_title_conditions,
        'include' => [
          'color'       => [ 'value' => \Elementor\Scheme_Color::COLOR_3 ],
          'typography'  => [ 'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_3 ],
          'margins'     => [
            [ 'prop' => 'margin-top', 'label' => __( 'Margin Top', 'btn-articles' ) ],
            [ 'prop' => 'margin-bottom', 'label' => __( 'Margin Bottom', 'btn-articles' ) ],
          ]
        ]
      ],
      [
        'slug'        => 'read_more',
        'label'       => __( 'Read More Link', 'btn-articles' ),
        'conditions'  => $show_title_conditions,
        'include' => [
          'color'       => [ 'value' => \Elementor\Scheme_Color::COLOR_4 ],
          'typography'  => [ 'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_4 ],
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
      $selector = 'btn-articles__' . $slug;
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
		$image_check = ( $settings['show_image'] == 'yes' ) ? true : false;
		$image_link_check = ( $image_check && $settings['link_image'] == 'yes' ) ? true : false;
		$title_check = ( $settings['show_title'] == 'yes' ) ? true : false;
		$title_link_check = ( $title_check && $settings['link_title'] == 'yes' ) ? true : false;
		$read_more = ( $settings['show_readmore'] == 'yes' ) ? true : false;
		$read_more_text =  ( $settings['link-text'] > '' ) ?  $settings['link-text'] : 'Read More';
		$template = btn_articles()->template_part_path('all-article.php');
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$posts_per_page =  (int)$settings['number-posts'];
		$offset_start = ( $settings['offset'] > 0 ) ? $settings['offset'] : 0;
		$offset = ( $paged - 1 ) * $posts_per_page + $offset_start;
		$post_type = btn_articles()->articles()->get_post_slug();
		$post_taxonomy = btn_articles()->articles()->get_taxonomy_slug();
		$sponsored_row = $settings['sponsored_row'];
		$sponsored_id = (int)$settings['sponsored_id'];
		$sponsored_title = $settings['sponsored-title'];
		$category_id = false;
		$css_class = "btn-article-default";
		$args = [
			'post_type'				=> $post_type,
			'posts_per_page'	=> $posts_per_page,
			'paged' 					=> $paged,
			'offset'					=> $offset,
			'orderby'         => $settings['orderby'],
			'order'           => $settings['order']
		];

		$year     = get_query_var('year');
		$monthnum = get_query_var('monthnum');
		$day      = get_query_var('day');
		if(isset($_GET['s'])){
			$args['offset'] = 0;
			$args['s'] = $_GET['s'];
		}
		if($year > 0){
			$args['offset'] = 0;
			$args['date_query'] = [
			 [
				 'year'  => $year,
				 'month' => $monthnum,
				 'day'	 => $day
			 ]
		 ];
		}
		
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
		if($category_id > ''){
			$args['tax_query'] = [
			 [
				 'taxonomy'	=> $taxonomy,
				 'terms' 	=> $category_id,
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
