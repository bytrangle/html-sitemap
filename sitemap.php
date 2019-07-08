<?php
/*
Template Name: Sitemap
*/
?>
<h2 id="pages">Pages</h2>
<ul>
<?php
// Add pages you'd like to exclude in the exclude here
wp_list_pages(
  array(
    'exclude' => '',
    'title_li' => '',
  )
);
?>
</ul>
<h2 id="posts">Posts</h2>
<?php
$all_posts = new WP_Query(array('posts_per_page'=>-1));
?>

<ul>
<?php
// Add categories you'd like to exclude in the exclude here
$cats = get_categories();
$cats_to_skip = array();

while($all_posts->have_posts()):
  $all_posts->the_post();
   
  $post_cats = get_the_category();
  
  for ($i = 1; $i < count($post_cats); $i++) {
    if ($post_cats[$i]->count === 1):         
      array_push($cats_to_skip, $post_cats[$i]->term_id );
    endif;
      
  }
endwhile;

$cats_to_display = array();
foreach ($cats as $cat):
  if (($cat->term_id !== 1) && !in_array($cat->term_id, $cats_to_skip)):
    echo "<li><h3>".$cat->cat_name."</h3>";
  endif;
  echo "<ul>";

  while($all_posts->have_posts()):
    $all_posts->the_post();
    $category = get_the_category();
    
    // Only display a post link once, even if it's in multiple categories
    if ($category[0]->term_id == $cat->term_id):
      echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
    endif;
  endwhile;

  echo "</ul>";
  wp_reset_postdata();
  echo "</li>";
endforeach;
?>
</ul>
