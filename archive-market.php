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
$debug_color = 'brown';
// print_X($debug_color, __FILE__, __LINE__, $qvar); //d//
?>

<?php
if ($qvar) {
    // Debug:: surrey id is 87
    $terms = get_terms(array(
        'taxonomy' => 'property-neighborhood',
        'fields' => 'all', //'names',
        'hide_empty' => false,
        'slug' => $qvar,
    ));
} else {
    $terms = get_terms(array(
        'taxonomy' => 'property-neighborhood',
        'parent' => 0,
        'hide_empty' => false,
    ));
}
// print_X('green', __FILE__, __LINE__, $terms); //d//

foreach ($terms as $term) {
    // print_X($debug_color, __FILE__, "Archive-community Show term id & name", $term->term_id, $term->name, $term->slug); //d//
    $termID = $term->term_id;
    //Define the query to get community posts
    $Communities = new WP_Query(array(
        'post_type' => 'market',
        'tax_query' => array(
            array(
                'taxonomy' => 'property-neighborhood',
                'field' => 'slug',
                'terms' => $term->slug, //'fraser-heights' //d//
            ),
        ),
        'posts_per_page' => -1,
    ));
    // print_X($debug_color, __FILE__, 'Archive-community Found posts: ', $Communities->found_posts); //d//
    set_query_var('qvar', $qvar);
    set_query_var('term', $term);
    set_query_var('metabox_tax', 'market');
    get_template_part('/template-parts/content-metabox');

    if ($Communities->have_posts()) {?>

    <?php
        // print_X($debug_color, 'Archive-community found posts: ', $Communities->found_posts); //d//
        $i = 0; //d//
        while ($Communities->have_posts()) {
            // print_X('Olive', 'Archive-community inside the LOOP: ', $i++); //d//
            $Communities->the_post();?>
          <div style="text-align: left">
            <h2><a href="<?php echo str_replace("/markets/", "/market/", get_the_permalink()); ?>">
              <?php the_title();?></a>
            </h2>
            <div><?php the_excerpt();?> </div>
          </div>
    <?php }

    } else {
        //No POSTS
        echo "<p> NO SCHOOLS ADDED, COMING SOON... </p>";
    }

    wp_reset_postdata();

}
;?>

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