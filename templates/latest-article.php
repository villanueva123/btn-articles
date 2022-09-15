<?php
if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) : $loop->the_post();
    $id = get_the_ID();
    $title = get_the_title();
    $excerpt = get_the_excerpt();
    $link = get_the_permalink();
    $categories = get_the_terms($id, $post_taxonomy );
    $img_url = get_the_post_thumbnail_url($id,'full');
    $class = ($img_url > '')? "article-column-latest": "article-full-latest";
	$author = get_the_author_meta('display_name');
    $author_link = get_author_posts_url(get_the_author_meta('ID'));
    $html .="<div class=\"article-latest-container  {$class}\">";

      if($image_check){
          $img_link_html = ($image_link_check && $img_url > '' )? "<a href=\"{$img_url}\"><img src=\"{$img_url}\"></a>":"<img src=\"{$img_url}\">";
          $html .= $img_link_html;
      }
        if($category_check){
          $html .="<div class=\"article-latest-meta\">";
                  $link_html = "<a href=\"{$author_link}\">By {$author}</a>";
                  $html .="<span class=\"article-last-category\">{$link_html}</span>";
          $html .="</div>";
        }
        if($title_check){
            $title_html = ($title_link_check)? "<a class=\"btn-articles_latest__title\" href=\"{$link}\">{$title}</a>":$title;
            $html .="<h3>$title_html</h3>";
        }
        if($excerpt_check){
            $html .="<p class=\"btn-articles_latest__excerpt\">{$excerpt}</p>";
        }
		$html .= "<a href=\"{$link}\" class=\"article-readmore  btn-articles__read_more\">READ MORE</a>";

      $html .="</a>";
    $html .="</div>";
    endwhile;
}
wp_reset_postdata();
?>
