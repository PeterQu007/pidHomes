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
//entrance variable value for archive module
//if it is null, means show all categories/taxonomies
//if it is not null, means show specific categories/taxonomy
$qvar = get_query_var('property-neighborhood');
echo '<p>qvar: ' . $qvar . '</p>'; //d//
//require_once get_stylesheet_directory() . '/inc/generate-neighborhood-2-Level-metabox.php';

?>

<?php
If($qvar){
  // Debug:: surrey id is 87
  $terms = get_terms(array(
    'taxonomy' => 'property-neighborhood',
    //'object_ids' => 87, //metrotown //d//
    //'exclude_tree' => 93, 
    //'parent' => 0,
    //'hierarchical' => true,
    //'child_of' => 92,
    'fields' => 'all', //'names',
    //name__like' => 'burnaby', 
    'hide_empty' => false,
    'slug' => $qvar
  ));
  echo "<p style='color: green'> get_terms function experiment: </p> "; //d//
  //$post=$post[0];
  echo is_category(); //d//
  print_r($terms); //d//
}else{
  $terms = get_terms(array(
      'taxonomy' => 'property-neighborhood',
      'parent' => 0,
      //'child_of' => 0,
      'hide_empty' => false,
      'slug' => $qvar
  ));
  echo "<p>Archive-community Show term id & name: </p>"; //d//
  // print_r($terms); //d//
}

foreach($terms as $term){
  echo $term->term_id; //d//
  echo $term->name; //d//
  echo $term->slug; //d//
  $termID = $term->term_id; 
  //Define the query to get community posts
  $Communities = new WP_Query(array(
      'post_type' => 'community',
      'tax_query' => array(
          array(
              'taxonomy' => 'property-neighborhood',
              'field' => 'slug',
              'terms' => $term->slug //'fraser-heights' //d//
          ),
      ),
      'posts_per_page' => -1,
  ));

  echo '<p> Archive-community Found posts: ' . $Communities->found_posts . '</p>'; //d//

  if($Communities->have_posts()){ 

    // $Communities->the_post();

    // $metabox = nbh_2level_metabox($termID); //d//
    $metabox = nbh_top2level_terms($term->slug); //d//
    echo '<p style = "color:blue"> Archive-community get the ID: '. $term->slug . '</p>'; //d//
    print_r($metabox); //d//
    ?>
    <!-- 
      SET UP Sub Area title meta box 
      Swtich between All Communities and City Catogary names
      All Communities Meta Box
      City Catogory Meta Box
    -->
    <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
      <div style="font-size: 20px; text-align: left; display: block">
        <!-- First MetaBox Could invisible if in All Communities Mode-->
        <?php if($qvar){ ?>
          <a class="metabox__blog-home-link" href="
            <?php 
              echo  get_post_type_archive_link('community');
            ?>">
            <i class="
              <?php 
                echo "fas fa-map-marked"; 
              ?>
            " aria-hidden="true"></i> 
            <?php 
              echo 'All';
            ?>
          </a>  
          
        <?php

        } ?>
          

      <!-- Secondary Meta Box: show city name -->
        
      <a class="metabox__blog-home-link" href="<?php 
        echo get_post_type_archive_link('community') . $metabox[0]['level0_Term1_Slug']; ?>"> 
        <i class="fas fa-city" aria-hidden="true"></i>
        <?php echo $metabox[0]['level0_Term1_Name']; ?>
      </a>

      <a class="metabox__blog-home-link" href="<?php 
        echo get_post_type_archive_link('community') . $metabox[1]['level1_Term1_Slug']; ?>"> 
        <i class="fas fa-city" aria-hidden="true"></i>
        <?php echo $metabox[1]['level1_Term1_Name']; ?>
      </a>
        
      <a class="metabox__blog-home-link" href="<?php 
        echo get_post_type_archive_link('community') . $metabox[2]['level1_Term2_Slug']; ?>"> 
        <i class="fas fa-city" aria-hidden="true"></i>
        <?php echo $metabox[2]['level1_Term2_Name']; ?>
      </a>

      <a class="metabox__blog-home-link" href="<?php 
        echo get_post_type_archive_link('community') . $metabox[3]['level1_Term3_Slug']; ?>"> 
        <i class="fas fa-city" aria-hidden="true"></i>
        <?php echo $metabox[3]['level1_Term3_Name']; ?>
      </a>

      </div>
    </div>

    <?php
    echo '<p style="color: blue"> archive-community found posts: ' . $Communities->found_posts . '</p>'; //d//
    $i=0; //d//
    //echo print_r($Communities);
    while ($Communities->have_posts()) {
        echo '<p style="color: blue"> archive-community inside the LOOP: ' . $i++ . '</p>'; //d//
        $Communities->the_post();?>

          <div style="text-align: left">
            <h2><a href="<?php echo str_replace("/communities/", "/community/", get_the_permalink());?>">
              <?php the_title();?></a>
            </h2>
            <div><?php the_excerpt();?> </div>
          </div>

    <?php }

  }
 
  wp_reset_postdata();

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
