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

<?php 

//Get query var in order to filter the neighborhoods
$qvar = get_query_var('property-neighborhood');
//echo '<p>qvar' . $qvar . '</p>';

$terms = get_terms(array(
    'taxonomy' => 'property-neighborhood',
    'parent' => 0,
    'hide_empty' => true,
    'name' => $qvar
));

foreach($terms as $term){
  // echo $term->term_id; //d//
  // echo $term->name; //d//
  
  //Define the query to get community posts
  $Communities = new WP_Query(array(
      'post_type' => 'community',
      'tax_query' => array(
          array(
              'taxonomy' => 'property-neighborhood',
              'field' => 'slug',
              'terms' => $term->name,
          ),
      ),
      'posts_per_page' => -1,
  ));

  //echo $Communities->found_posts;

  if($Communities->have_posts()){ ?>

    <!-- 
      SET UP Sub Area title meta box 
      Swtich between All Communities and City Catogary names
      All Communities Meta Box
      City Catogory Meta Box
    -->
    <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
      <div style="font-size: 20px; text-align: left; display: block">
        <a class="metabox__blog-home-link" href="
          <?php 
            echo $qvar ? get_post_type_archive_link('community') 
                  : get_post_type_archive_link('community') . '/' . $term->name
          ?>">
          <i class="
            <?php 
              echo $qvar ? "fas fa-map-marked" : "fas fa-city" 
            ?>
          " aria-hidden="true"></i> 
          <?php 
            echo $qvar ? 'All Communities' : $term->name;
          ?>
        </a>
        <!-- Secondary Meta Box: show city name -->
        <?php 
          if($qvar) {
        ?>
        <a class="metabox__blog-home-link" href="<?php 
          echo get_post_type_archive_link('community') . '/' . $term->name; ?>"> 
          <i class="fas fa-city" aria-hidden="true"></i>
          <?php echo $term->name; ?> </a>
        <?php } ?>
        <!-- 
          toDo: Tertiary Meta Box:
          Best show the Districts for further filtering in the All Communities Archive Page
          <a class="metabox__blog-home-link" href="<?php echo get_term_link($term->term_id); ?>"> <?php echo $term->name; ?> </a>
        -->
      </div>
    </div><?php
    //echo $Communities->found_posts;
    //$i=0;
    //echo print_r($Communities);
    while ($Communities->have_posts()) {
        //echo $i++;
        $Communities->the_post();?>

          <div style="text-align: left">
            <h2><a href="<?php echo str_replace("/communities/", "/community/", get_the_permalink());?>">
              <?php the_title();?></a>
            </h2>
            <div><?php the_excerpt();?> </div>
          </div>

    <?php }

  }
 
  wp_reset_query();

};?>

  </div>

  <div class="rh_page rh_page_sidebar" style="width: 30%">

  <?php

// if ('grid' === $view_type) {
//     get_template_part('assets/modern/partials/taxonomy/grid-layout');
// } else {
//     get_template_part('assets/modern/partials/taxonomy/list-layout');
// }
get_sidebar( 'default' );

?> 

</div>
</section>

<?php

get_footer();
