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

class BTN_Article_Categories_Widget extends \Elementor\Widget_Base{

	public static $slug = 'elementor-btn-article-categories';

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
		return __('Article Categories', 'btn-articles');
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

		$slug = self::$slug;

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Article Categories', 'btn-articles' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_description',
			[
				'label' => __( 'Show Description', 'btn-articles' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'btn-articles' ),
				'label_off' => __( 'Hide', 'btn-articles' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
		$html = '';
		$settings = $this->get_settings_for_display();
		$tax_args = [
			 'orderby'    => 'ID',
			 'order'     => 'DESC',
			 'hide_empty' => true,
		];
		$css_class = "btn-category-default";
		if ( 'yes' === $settings['show_description'] ) {
				$css_class = "btn-category-description";
		}
		$html .= '<ul class="'.$css_class.'">';
		$catlist = get_terms(btn_articles()->articles()->get_taxonomy_slug(),$tax_args);
		if ( ! empty( $catlist ) ) {
			foreach ( $catlist as $key => $item ) {
				$link = get_category_link($item->term_taxonomy_id);
					$html .= '<li> <a href="'.$link.'" class="category-'.$item->slug.'">'. $item->name . '</a><br />';
				if ( 'yes' === $settings['show_description'] ) {
						$html .= '<em>'. $item->description . '</em> </li>';
				}
			}
		}
		$html .= '</ul>';
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
