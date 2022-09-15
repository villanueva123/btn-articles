<?php
$html .="<div class=\"btn-articles-sponsored-content {$full_width_class}\">";
  if($img){
    $html .="<div class=\"btn-articles-sponsored-content-left\">";
      $html .="<img src=\"{$img_url}\">";
    $html .="</div>";
  }
  $html .="<div class=\"btn-articles-sponsored-content-right\">";
    $html .="<h3>{$section_title}</h3>";
	$html .="<img class=\"btn-articles-mobile\" src=\"{$img_url}\">";
    $html .="<h2>{$sponsored_title}</h2>";
    $html .="<p>{$excerpt}</p>";
    $html .= "<a href=\"{$permalink}\">$readmore</a>";
  $html .="</div>";
$html .="</div>";
?>
