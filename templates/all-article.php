<?php
$count = 0;
$html .= "<div class=\"{$css_class} btn-article-wrapper\">";
if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) : $loop->the_post();
    $count++;
    $id = get_the_ID();
    $title = get_the_title();
    $excerpt = get_the_excerpt();
    $link = get_the_permalink();
    $date = get_the_date();
    $categories = get_the_terms($id, $post_taxonomy );
    $category = ( ! empty( $categories ) )?  $categories[0]->name : '';
  	if($category_id > '' || is_tax($post_taxonomy)){
  		foreach($categories as $term){
  			if($term->term_id  == $term_id || $term->term_id == $category_id){
  				$category = $term->name;
  			}
  		}
  	}
    $meta_check =  $args['show_meta'];
    $pagination_check = $args['show_pagination'] ;

    $img_url = get_the_post_thumbnail_url($id,'full');
    $author = get_the_author_meta('display_name');
    $author_link = get_author_posts_url(get_the_author_meta('ID'));
    $class = ($img_url > '')? "article-column": "article-full";
    $html .="<div class=\"article-list-container {$class}\">";
        $html .="<div class=\"article-left\">";
          if($meta_check){
            $html .="<div class=\"article-meta\">";
                $html .="<span>{$date}</span><span class=\"article-category\">{$category}</span>";
            $html .="</div>";
          }
          if($title_check){
              $title_html = ($title_link_check)? "<a href=\"{$link}\"><h3 class=\"btn-articles__title\">{$title}</h3></a>":"<h3 class=\"btn-articles__title\">{$title}</h3>";
              $html .= $title_html;
          }
          $html .="<div class=\"article-meta-author\">";
            $html .= "<a href=\"{$author_link}\">BY {$author}</a>";
          $html .="</div>";
          $html .="<p>{$excerpt}</p>";
          $html .= ($read_more)? "<a href=\"{$link}\" class=\"article-readmore  btn-articles__read_more\">{$read_more_text}</a>" :'';
        $html .="</div>";
        if($image_check && $img_url > ''){
          $html .="<div class=\"article-right\">";
            $image_html = ($image_link_check)? "<a href=\"{$link}\"><img src=\"{$img_url}\"></a>":"<img src=\"{$img_url}\">";
            $html .= $image_html;
          $html .="</div>";
        }
    $html .="</div>";
    if($count == $sponsored_row && $sponsored_id > ''){
      $html .=do_shortcode("[btn_articles_sponsored_article id={$sponsored_id} title=\"{$sponsored_title}\"]");
    }
    endwhile;

	$total_rows = max( 0, $loop->found_posts - $offset_start );
	$total_pages = ceil( $total_rows / $posts_per_page );
    if ($total_pages > 1 && $pagination_check){

        $current_page = max(1, get_query_var('paged'));

        $html .= paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => __('«'),
            'next_text'    => __('»'),
        ));
    }
}else{
	if(isset($_GET['s'])){
		$html .="No article Found";
	}
}
$html .="</div>";
wp_reset_postdata();
?>
