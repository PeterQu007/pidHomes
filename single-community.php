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
    get_template_part('assets/modern/partials/properties/search/advance');
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
  // wp_reset_query(); //x//
  // echo get_the_ID(); //d//
  // echo the_title(); //d//

  $terms = get_the_terms(get_the_ID(),'property-neighborhood'); 
  // print_r($terms); //d//
  foreach ($terms as $term){
    //echo $term->name; //d//
    //echo $term->term_id; //d//
    if(!$term->parent /* get the top city name*/){
      $termID = $term->term_id;
      $termName = $term->name;
      //echo $term->name; //d//
      //echo $termID; //d//
    };
  }
  // echo get_term_link(54); //d//
?>

<div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block">
    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('community'); ?>">
    <i class="fas fa-map-marked" aria-hidden="true">
    </i> All Communities
    </a>
    
    <!-- Secondary Meta Box for City -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_post_type_archive_link('community') . '/' . $termName; ?>">
      <i class="fas fa-city" aria-hidden="true"></i>
      <?php echo $termName; ?> </a>
    <span class="metabox__main"><?php the_title();?></span></div>

    <!-- 
      toDo: Add District Meta Box 
    -->
</div>

<?php
while (have_posts()) {
    the_post();?>
      <div style="text-align: left">
      <h2><?php the_title();?></h2>
      <?php get_field('banner_image') ?>
      <div><?php the_content();?> </div>
      <div class="acf-map">
              <?php
                  $mapLocation = get_field('map_location');?>
                  <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                  <h3><a href="<?php the_permalink();?>"><?php the_title();?></a> </h3>
                  <?php echo $mapLocation['address']; ?>
                  </div>
              </div>
            </div>
      <div><span>Community Area: &nbsp<?php echo get_field('community_area'); ?></span></div>
      <div><span>Private Dwellings: &nbsp<?php echo get_field('occupied_private_dwellings'); ?></span></div>
      <div><span>Population: &nbsp<?php echo get_field('population'); ?> </span></div>
      <div><span>Average Household Income: &nbsp<?php echo get_field('average_household_income'); ?></span></div>
      

  <?php }?>
  <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
    <div style="font-size: 20px; text-align: left; display: block">
      <a class="metabox__blog-home-link" href="#">
      <i class="fas fa-chart-line" aria-hidden="true">
      </i> Market Statistics
      </a>
  </div>
  </div>
  <iframe style="border: 0;" width="400" height="300" src="https://statscentre.rebgv.org/infoserv/s-v1/8pCb-9cV?w=400&h=300"></iframe>

  

  <?php
  $terms = get_the_terms(get_the_ID(), 'property-neighborhood');
  //print_r($terms);
  foreach ($terms as $term) {
      
          //$termID = $term->term_id;
          //$termName = $term->name;
          //echo $termID;
          //echo $termName;
          $termChildren= get_term_children($term->term_id, 'property-neighborhood');
          if(!$termChildren){
            $termID = $term->term_id;
            $termName = $term->name;
            $termSlug = $term->slug;
            echo $termID;
            echo $termName;
          }
  }
  
  echo $termName;

  $Schools = new WP_Query(array(
    'post_type' => 'school',
    'tax_query' => array(
        array(
            'taxonomy' => 'property-neighborhood',
            'field' => 'slug',
            'terms' => $termName,
        ),
    ),
    'post_per_page' => -1,
));
if ($Schools->have_posts()) {
    ?>
  <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block">
    <a class="metabox__blog-home-link" href="<?php echo get_page_link(get_page_by_title('schools')->ID); ?>">
    <i class="fa fa-school" aria-hidden="true">
    </i> All Schools
    </a>
    <!-- <a class="metabox__blog-home-link" href="<?php echo get_term_link($termID); ?>"> <?php echo $termName; ?> </a> -->
    <a class="metabox__blog-home-link" href="<?php echo get_site_url($termID) . '/schools/' . $termSlug; ?>"> <?php echo $termName; ?> </a>

  </div>
  </div>

  <?php
}

while ($Schools->have_posts()) {
    $Schools->the_post();?>
        <div style="text-align: left">
        <?php //rewrite schools permalink to singular school ?>
        <h2><a href="<?php echo str_replace('/schools/', '/school/', get_the_permalink());?>"><?php the_title();?></a></h2>
        <div><?php the_excerpt();?> </div>
        </div>

    <?php }
wp_reset_query(); ?>


  <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
      <div style="font-size: 20px; text-align: left; display: block">
        <a class="metabox__blog-home-link" href="#">
        <i class="fas fa-sign" aria-hidden="true">
        </i> Active Listings
        </a>
    </div>
  </div>

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
