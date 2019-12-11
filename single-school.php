<?php
/**
 * Single School Post Page
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

<?php
    $terms = get_the_terms(get_the_ID(), 'property-neighborhood');
    // print_r($terms); //d//
    foreach ($terms as $term) {
      //Get Top Level Term
      if (!$term->parent) {
          $topTermID = $term->term_id;
          $topTermName = $term->name;
          // echo $topTermID; //d//
          // echo $topTermName; //d//
      }

      //Get Level 3 Term
      if(!get_term_children($term->term_id, 'property-neighborhood')){

        $level3TermID = $term->term_id;
        $level3TermName = $term->name;
        $level3TermSlug = $term->slug;
        // echo $Level3TermID; //d//
        // echo $Level3TermName; //d//
      }
    }
    foreach($terms as $term){
      //Get Level 2 Term
      if($topTermID & $term->parent == $topTermID){
          $level2TermID = $term->term_id;
          $level2TermName = $term->name;
          $level2TermSlug = $term->slug;
          // echo $Level2TermID; //d//
          // echo $Level2TermName; //d//
      }
    }
    //echo get_term_link(54);
  ?>

<section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding">
  <div class="rh_page rh_page__listing_page rh_page__main" style="width: 70%">

   <?php
    get_template_part('template-parts/content-single-school');

    get_template_part('template-parts/content-market-stats');
   ?>

    
    <!--
      toDo: List Community Post by Excerpt
    -->

    <?php 
      
      set_query_var('communityID', $level3TermID);
      get_template_part('template-parts/content-single-community'); 
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

</section>

<?php

get_footer();
