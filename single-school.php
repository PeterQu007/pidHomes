<?php
/**
 * All Communities Page
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
<div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block">
    <a class="metabox__blog-home-link" href="<?php echo get_page_link(get_page_by_title('schools')->ID); ?>">
    <i class="fas fa-school" aria-hidden="true">
    </i> All Schools
    </a>

    <?php
$terms = get_the_terms(get_the_ID(), 'property-neighborhood');
//print_r($terms);
foreach ($terms as $term) {
    if (!$term->parent) {
        $termID = $term->term_id;
        $termName = $term->name;
        //echo $termID;
    }
    ;
}

//echo get_term_link(54);
?>
    <!-- <a class="metabox__blog-home-link" href="<?php echo get_term_link($termID); ?>"> <?php echo $termName; ?> </a> -->
    <a class="metabox__blog-home-link" href="<?php echo get_site_url() . '/schools/?fraser-heights'; ?>"> <?php echo $termName; ?> </a>
    <span class="metabox__main"><?php the_title();?></span></div>
</div>

<?php
while (have_posts()) {
    the_post();?>
      <div style="text-align: left">
      <h2><?php the_title();?></h2>
      <?php get_field('banner_image')?>
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
      <?php 
        global $wpdb;
        //$school = $wpdb->get_var("SELECT COUNT(*) FROM pid_schools WHERE school_name='Fraser Heights'");
        //echo "<p>User Count is {$user_count}</p>";
        $results = $wpdb->get_results("SELECT school_year, school_type, `rank`, rank5, rating FROM pid_schools WHERE school_name='" . get_field('school_name') . "'");
        // foreach($results as $school){
        //    echo "<p>{$school->rank}</p>";
        // }
      ?>
      <div><span>School Year: &nbsp<?php echo $results[0]->school_year; ?></span></div>
      <div><span>School Type: &nbsp<?php echo $results[0]->school_type; ?></span></div>
      <div><span>FI Rank: &nbsp<?php echo $results[0]->rank; ?> </span></div>
      <div><span>FI Rating: &nbsp<?php echo $results[0]->rating . '/10'; ?></span></div>


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

  <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
      <div style="font-size: 20px; text-align: left; display: block">
        <a class="metabox__blog-home-link" href="#">
        <i class="fas fa-home" aria-hidden="true">
        </i> Communities
        </a>
    </div>
  </div>

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
