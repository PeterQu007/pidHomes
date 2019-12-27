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
      $X = set_debug(__FILE__);
      //Get query var in order to filter the neighborhoods
      //entrance variable value for archive module
      //if it is null, means show all categories/taxonomies
      //if it is not null, means show specific categories/taxonomy
      $qvar = get_query_var('property-neighborhood'); //query var is passed from url rewriting 
      // print_X($X, __LINE__, $qvar, get_the_ID(), get_the_title()); //d//
      ?>
      <div >
        <h2> <?php echo $qvar ?> </h2>
        <?php
          //get the guid for demographics
          $mysqli = new mysqli("localhost", "root", "root", "local");
          $strSql = "SELECT GEO_UID FROM pid_census_subdivision_bc
                    WHERE GEO_Name_nom = '" . $qvar . "'" ;
          $mysqli->real_query($strSql);
          $res = $mysqli->use_result();
          // print_X($X, __LINE__, $res);
          while ($row = $res->fetch_assoc()){
            // print_X($X, __LINE__, $row);
            $GEO_UID = $row['GEO_UID'];
          }
        ?>
        <div id = "demographic" class = "wrapper" uid="<?php echo $GEO_UID; ?>">
        </div>
      </div>
      <?php
      get_template_part('template-parts/content', 'x-postx');

      get_template_part('template-parts/content', 'market-stats');
      set_query_var('post_type', 'school');
      get_template_part('template-parts/content', 'x-postx');

    ?>
    
  </div>

  <div class="rh_page rh_page_sidebar" style="width: 30%">
    <?php get_sidebar( 'default' ); ?> 
  </div>

</section>

<?php

get_footer();
