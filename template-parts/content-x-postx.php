<?php
/***********************
 * All Posts: Show by City Taxonomy
 * Single Post: Show Sub area of the City
 */
$X = set_debug(__FILE__);
if (is_single(get_the_ID())) {
  // $the_neighborhood = wp_get_post_terms(get_the_ID(), 'property-neighborhood');
  // print_X($X, __LINE__, 'The Neighborhood', $the_neighborhood);
  $qvar = get_query_var('name');
} else {
  $qvar = get_query_var('property-neighborhood');
}
$page_nbh = get_query_var('page1',1);
$page_school = get_query_var('page2' ,1);
print_X($X, __LINE__, 'page community::', $page_nbh, 'page school::', $page_school, 'qvar::', $qvar);

$post_type = get_query_var('post_type');
// print_X($X, __LINE__, 'query var::', $qvar, 'post type::', $post_type, 'post ID::', get_the_ID());
if(!$post_type){
  $post_type = get_post_type();
}
switch($post_type){
case 'community':
    $page = $page_nbh;
break;
case 'school':
    $page = $page_school;
break;
}
$post_type_labels = get_post_type_labels(get_post_type_object($post_type));
// print_X($X, __LINE__, 'query var::', $qvar, 'post type::', $post_type, 'post type obj::', $post_type_labels);

if ($qvar/* query var */) {
  // Sub Markets
  $terms = get_terms(array(
      'taxonomy' => 'property-neighborhood',
      'fields' => 'all', //'names',
      'hide_empty' => false,
      'slug' => $qvar,
  ));
} else {
  // All market
  $terms = get_terms(array(
      'taxonomy' => 'property-neighborhood',
      'parent' => 0,
      'hide_empty' => false,
  ));
}
// print_X($X, __LINE__, $terms); //d//

foreach ($terms as $term) {

    $termID = $term->term_id;

    $x_Posts = new WP_Query(array(
        'post_type' => $post_type,
        'tax_query' => array(
            array(
                'taxonomy' => 'property-neighborhood',
                'field' => 'slug',
                'terms' => $term->slug,
            ),
        ),
        'paged' => $page, //find the last page for URL
        'posts_per_page' => 3,
    ));

    set_query_var('qvar', $qvar);
    set_query_var('term', $term);
    set_query_var('metabox_tax', strtolower($post_type_labels->singular_name));
    get_template_part('/template-parts/content', '2Level-metabox');

    if ($x_Posts->have_posts()) {
        // print_X($X, __LINE__, 'Archive-market found posts: ', $Markets->found_posts); //d//
        // print_X($X, __LINE__, get_term_meta($term->term_id, null, false));
        $i = 0; //d//
        while ($x_Posts->have_posts()) {
            // print_X($X, __LINE__, 'Archive-market inside the LOOP::', $i++); //d//
            $x_Posts->the_post();
            // print_X($X, __LINE__, 'post type name::', $post_type_labels->name, 'post type singular name::', $post_type_labels->singular_name);?>
            <div style="text-align: left">
                <h3><a href="<?php echo str_replace("/" . strtolower($post_type_labels->name) . "/",
                "/" . strtolower($post_type_labels->singular_name) . "/",
                strtolower(get_the_permalink())); ?>">
                    <?php the_title();?></a>
                </h3>
                <div><?php the_excerpt();?> </div>
            </div>
        <?php }
        echo paginate_links(array(
            'format' => 'page/%#%',
            'current' => $page,
            'total' => $x_Posts->max_num_pages 
        ));
        if (  $wp_query->max_num_pages > 1 ) {
            echo '<div class="misha_loadmore">More Neighborhoods</div>'; // you can use <a> as well
        }

    } else {
        //No POSTS
        echo "<p> NO " . strtoupper($post_type_labels->singular_name) . " ADDED, COMING SOON... </p>";
    }

    wp_reset_postdata();

}
