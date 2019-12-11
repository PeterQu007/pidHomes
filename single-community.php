<?php
/**
 * Single Community Post Page
 *
 * @package realhomes-child
 * @subpackage modern
 */

get_header();


// Page Head.
$header_variation = get_option('inspiry_listing_header_variation');
//echo $header_variation;

if (empty($header_variation) || ('none' === $header_variation)) {
    echo 'header';
    get_template_part('assets/modern/partials/banner/header');
} elseif (!empty($header_variation) && ('banner' === $header_variation)) {
    //echo 'property-archive';
    get_template_part('assets/modern/partials/banner/community');
}

if (inspiry_show_header_search_form()) {
    // get_template_part('assets/modern/partials/properties/search/advance'); //d//
}

if (isset($_GET['view'])) {
    $view_type = $_GET['view'];
} else {
    /* Theme Options Listing Layout */
    $view_type = get_option('theme_listing_layout');
}

?>


<section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding">
<div class="rh_page rh_page__listing_page rh_page__main" style="width: 70%">

<?php 
  get_template_part('template-parts/content-single-community');
  get_template_part('template-parts/content-market-stats');
?>

  <?php //star school block //School[]
    // echo get_the_ID(); //d//
    $terms = get_the_terms(get_the_ID(), 'property-neighborhood');
    // print_r($terms); //d//
    foreach ($terms as $term) {
        
      //$termID = $term->term_id; //d//
      //$termName = $term->name;
      //echo $termID;
      //echo $termName;
      $termChildren= get_term_children($term->term_id, 'property-neighborhood');
      if(!$termChildren){
        $termID = $term->term_id;
        $termName = $term->name;
        $termSlug = $term->slug;
        // echo $termID; //d//
        // echo $termName; //d//
      }
    }
  
  // echo $termName; //d//

  $Results = new WP_Query(array(
    'post_type' => 'school',
    'tax_query' => array(
        array(
            'taxonomy' => 'property-neighborhood',
            'field' => 'slug',
            'terms' => $termName,
        ),
    ),
    'posts_per_page' => -1,
  ));

  if ($Results->have_posts()) {
    ?>
    <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
    <div style="font-size: 20px; text-align: left; display: block">
      <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('school'); ?>">
      <i class="fa fa-school" aria-hidden="true">
      </i> All Schools
      </a>
      <!-- <a class="metabox__blog-home-link" href="<?php echo get_term_link($termID); ?>"> <?php echo $termName; ?> </a> -->
      <a class="metabox__blog-home-link" href="<?php 
        echo get_site_url($termID) . '/schools/' . $termSlug; ?>"> <?php echo $termName; ?> </a>
    </div>
    </div>
    <?php 
    while ($Results->have_posts()) {
      $Results->the_post();?>
        <div style="text-align: left">
        <?php //rewrite schools permalink to singular school ?>
        <h2><a href="<?php echo str_replace('/schools/', '/school/', get_the_permalink());?>"><?php the_title();?></a></h2>
        <div><?php the_excerpt();?></div>
        </div>

      <?php 
    }
  }

  wp_reset_query(); //School[]?> 

  <?php 
    get_template_part('template-parts/content-active-listings');
  ?>

  </div>

  <div class="rh_page rh_page_sidebar" style="width: 30%">

  <?php

// if ('grid' === $view_type) {
//     get_template_part('assets/modern/partials/taxonomy/grid-layout');
// } else {
//     get_template_part('assets/modern/partials/taxonomy/list-layout');
// }
get_sidebar('default');

?>

</div>
</section>

<?php

get_footer();
