<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Modules
 *
 * @since      1.0.0
 * @package    btn-articles
 * @subpackage btn-articles/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
class btn_articles_article_screen {

  private $post_type;

	// Init Class
	function add_wp_hooks(){
    $this->post_type = btn_articles()->articles()->get_post_slug();
    add_action("save_post_{$this->post_type}", [$this, 'save_post'] );
    add_action( 'admin_enqueue_scripts', [$this, 'enqueue'] , 10, 1 );
		add_action( 'edit_form_after_title', [$this,'edit_form_after_title']);
	}



	// Hook into Post Type after Title
	function edit_form_after_title($post){
		if( $post->post_type === $this->post_type ){
			$this->show_article_metabox($post);
		}

	}

  // Show Meta Box
  function show_article_metabox($post){
    $post_id = $post->ID;
    $meta_field = self::META_BOX;
    //Keys
		$sub_heading_key = self::SUB_HEADING;
    $sponsored_content_key = self::SPONSORED_CONTENT;

    //Get Meta
    $sub_heading = get_post_meta( $post_id,$sub_heading_key, true );
    $sponsored_content = get_post_meta($post_id, $sponsored_content_key, true );
    $sponsored_selector_data = btn_articles()->articles()->get_article_post_data();
    wp_nonce_field( self::META_BOX."_nonce", $meta_field."_nonce" );
    $args = [
      'class_name'	=> '',
      'template'		=> 'admin/metabox.php',
    ];
		$template = btn_articles()->template_part_path($args['template']);
    include $template;
  }

  //Render TextField
  function render_field_setting($args){
    $html = "";
    if($args['wp_data'] == 'option'){
			$wp_data_value = get_option($args['name']);
		} elseif($args['wp_data'] == 'post_meta'){
			$wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
		}
		switch ($args['type']) {
			case 'input':
				$value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
				if($args['subtype'] != 'checkbox'){
					$prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
					$prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
					$step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
					$min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
					$max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
					if(isset($args['disabled'])){
						$html .='<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
					} else {
						$html .='<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
					}
				} else {
					$checked = ($value) ? 'checked' : '';
					$html .= '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
				}
				break;
			  default:
				break;
		}
    return $html;
  }


  function enqueue( $hook ) {
   global $post;
   if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
     if ( $this->post_type === $post->post_type ) {
       wp_enqueue_style( 'selectWoo', BTN_ARTICLES_ASSESTS_URL . 'css/select2.min.css',[],BTN_ARTICLES_VERSION,'all');
       wp_enqueue_script('selectWoo', BTN_ARTICLES_ASSESTS_URL.'js/select2.min.js',[], BTN_ARTICLES_VERSION, false  );
       wp_enqueue_script('btn-articles-js', BTN_ARTICLES_ASSESTS_URL.'js/btn-articles-admin.js',['jquery'], BTN_ARTICLES_VERSION, false  );
     }
   }
  }


  function save_post( $post_id ) {


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}
		// Check permissions
		if (! empty($_POST['post_type']) && 'page' == $_POST['post_type']) {
			if (! current_user_can('edit_pages', $post_id)) {
				return;
			}
		}
		else {
			if (! current_user_can('edit_posts', $post_id)) {
				return;
			}
		}

	  $new_sub_heading = (isset($_POST[self::SUB_HEADING])) ? sanitize_text_field($_POST[self::SUB_HEADING]) : false;
	 	$existing_sub_heading = get_post_meta($post_id, self::SUB_HEADING, true);
	  if($new_sub_heading || $new_sub_heading === ""){
			 // Updated
            if($existing_sub_heading != $new_sub_heading){
               update_post_meta($post_id, self::SUB_HEADING,$new_sub_heading);
            }
		}

  	$new_sponsored_content = (isset($_POST[self::SPONSORED_CONTENT])) ? $_POST[self::SPONSORED_CONTENT] : false;
 		$existing_sponsored_content = get_post_meta($post_id, self::SPONSORED_CONTENT, true);
  	if($new_sponsored_content || $new_sponsored_content === ""){
		 // Updated
          if($existing_sponsored_content != $new_sponsored_content){
             update_post_meta($post_id, self::SPONSORED_CONTENT,$new_sponsored_content);
          }
		}


	}

	function __construct(){}

  const META_BOX = "btn/articles/metabox/field";
  const SUB_HEADING = 'btn/articles/sub-heading';
  const SPONSORED_CONTENT = 'btn/articles/sponsored-content';
}
