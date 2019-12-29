<?php
/*-----------------------------------------------------------------------------------*/
/*	Enqueue Styles in Child Theme
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'inspiry_enqueue_child_styles' ) ) {
	function inspiry_enqueue_child_styles() {
		if ( ! is_admin() ) {
			// dequeue and deregister parent default css
			wp_dequeue_style( 'parent-default' );
			wp_deregister_style( 'parent-default' );

			// dequeue parent custom css
			wp_dequeue_style( 'parent-custom' );

			// parent default css
			wp_enqueue_style( 'parent-default', get_template_directory_uri() . '/style.css' );

			// parent custom css
			wp_enqueue_style( 'parent-custom' );

			// child default css
			wp_enqueue_style( 'child-default', get_stylesheet_uri(), array( 'parent-default' ), '1.0', 'all' );

			// child custom css
			wp_enqueue_style( 'child-custom', get_stylesheet_directory_uri() . '/css/child-custom.css', array( 'child-default' ), '1.4', 'all' );

			// child custom js
			wp_enqueue_script( 'child-custom', get_stylesheet_directory_uri() . '/js/child-custom.js', array( 'jquery' ), '1.4', true );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'inspiry_enqueue_child_styles', PHP_INT_MAX );


if ( ! function_exists( 'inspiry_load_translation_from_child' ) ) {
	/**
	 * Load translation files from child theme
	 */
	function inspiry_load_translation_from_child() {
		load_child_theme_textdomain( 'framework', get_stylesheet_directory() . '/languages' );
	}

	add_action( 'after_setup_theme', 'inspiry_load_translation_from_child' );
}

/*Add Child Functions
*/
// echo get_stylesheet_directory_uri().'/inc/debug.php';
// include_once(get_stylesheet_directory_uri().'/inc/debug.php');
include_once get_stylesheet_directory() . '/inc/debug.php';

$X = set_debug(__FILE__);

function pidRealty_Files()
{
    //load js scripts
    wp_enqueue_script('main-pidrealty-js', get_stylesheet_directory_uri().('/js/scripts-bundled.js'), null, microtime(), true);
    wp_enqueue_script('secondary-pidrealty-js', get_stylesheet_directory_uri() . ('/js/appjs-bundled.js'), null, microtime(), true);
    wp_enqueue_script('vendor-js', get_stylesheet_directory_uri().("/temp/scripts/Vendor.js"));
    wp_enqueue_script('ajax-cors', get_stylesheet_directory_uri(). ("/js/modules/jquery.ajax-cross-origin.min.js"));
    wp_enqueue_script('chartjs-crosshair', "//cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js");
    // wp_enqueue_script('chartjs', 'https://www.jsdelivr.com/package/npm/chart.js');
    //load css files
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', get_stylesheet_directory_uri().("/assets/lib/fontawesome/css/font-awesome.min.css"));
    wp_enqueue_style('pidRealty_secondary_style', get_stylesheet_directory_uri().("/temp/styles.css"));
    //wp_enqueue_style('pidRealty_main_style', get_stylesheet_directory_uri());
    if(!is_home()){
      // wp_register_script('loadmore', get_stylesheet_directory_uri(). ("/js/loadmore.js" ));
      wp_localize_script('main-pidrealty-js', 'pid_Data', array( 
        'siteurl' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
      ));
      // Enqueued script with localized data.
      // wp_enqueue_script('loadmore');
      // alert("not home");
    }
}
add_action('wp_enqueue_scripts', 'pidRealty_Files');

function pidHomes_child_features()
{
    add_theme_support('title-tag');
    //41. Featured Image Post
    add_theme_support('post-thumbnails');
    //41.. Add image size
    //42.. Crop image precisely, use parameter array('left', 'top') to replace true
    //42.. example: add_image_size('professorLandscape', 400, 260, array('left','top'));
    //42.. use 'manual image crop' plugin to do the precisely cropping;
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    //43.. Add page banner pic size
    add_image_size('pageBanner', 1900, 300, true);
    add_image_size('pageBanner-about', 1900, 800, true);

}

add_action('after_setup_theme', 'pidHomes_child_features');

require_once("googleMapKey.php");
// function pidHomesMapKey($api)
// {
//     $api['key'] = '';
//     return $api;
// }
// add_filter('acf/fields/google_map/api', 'pidHomesMapKey');


// function pidhomes_child_files()
// {
//     //49. Map on Front-End | 49.. Add google map js and key
//     wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=', null, '1.0', true);
//     wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), null, '1.0', true);
//     wp_enqueue_script('CentrisMainFramework', get_theme_file_uri('/js/centris.js'), null, '1.0', true);
//     wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
//     wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
//     wp_enqueue_style('university_main_styles', get_stylesheet_uri());
//     //59.
//     wp_localize_script('main-university-js', 'universityData', array(
//         'root_url' => get_site_url(),
//         'nonce' => wp_create_nonce('wp_rest'), //80. | Prepare to authorize to delete a note post
//     ));
// }

// add_action('wp_enqueue_scripts', 'pidhomes_child_files');

function pageBanner($args = null)
{
    // 44.. add arguments
    if (!$args['title']) {
        $args['title'] = get_the_title();
    }
    if (!$args['subtitle']) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }
    if (!$args['photo']) {
        if (get_field('page_banner_background_image')) {
            //echo print_r(get_field('page_banner_background_image'));
            $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/field.jpg');
        }
    }
    ?>
   <div class="page-banner">
      <?php //43. Change the banner background image to dynamic image
    //43.. Select specific size image ?>
      <div class="page-banner__bg-image" style="background-image: url(<?php
				echo $args['photo'];
    ?>);">
      </div>
      <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
        <div class="page-banner__intro">
          <?php //43. Change the sub title to dynamic text?>
          <p><?php echo $args['subtitle'] ?></p>
        </div>
      </div>
    </div>

  <?php
}

//Add public Query Variable
add_filter('query_vars', 'add_property_neighborhood_var', 0, 1);

function add_property_neighborhood_var($vars){
  $vars[]= 'property-neighborhood'; //, 'property-city', 'school');
  return $vars;
}

/**
 * Add term meta to results of get_terms
 * See /genesis/lib/functions/options.php for more info
 *
 *
 * Genesis is forced to create its own term-meta data structure in
 * the options table. Therefore, the following function merges that
 * data into the term data structure, via a filter.
 *
 * @param array $terms
 * @param string $taxonomy Taxonomy name that $terms are part of.
 * @param array $args
 * @return array $terms
 */
// function be_get_terms_filter($terms, $taxonomy, $args)
// {
//     foreach ($terms as $term) {
//         $term = genesis_get_term_filter($term, $taxonomy);
//     }

//     return $terms;
// }
// add_filter('get_terms', 'be_get_terms_filter', 10, 3);

function custom_query_vars_filter($vars) {
  $vars[] .= 'page1';
  $vars[] .= 'page2';
  return $vars;
}
add_filter( 'query_vars', 'custom_query_vars_filter' );

/************
 * NOTICE
 * AFTER CHANGE THE REWRITE RULE, WORDPRESS NEEDS RESET PERMALINK ON ADMIN PANEL
 */
//Add Rewrite Rules
add_rewrite_rule('^schools/([^/]*)/page/([^/]*)/?','index.php?post_type=school&property-neighborhood=$matches[1]&page2=$matches[2]','top');
add_rewrite_rule('^schools/([^/]*)/?','index.php?post_type=school&property-neighborhood=$matches[1]','top');
add_rewrite_rule('^school/([^/]*)/?','index.php?post_type=school&name=$matches[1]','top');
//Community
add_rewrite_rule('^communities/([^/]*)/page/([^/]*)/?','index.php?post_type=community&property-neighborhood=$matches[1]&page1=$matches[2]','top');
add_rewrite_rule('^communities/([^/]*)/?','index.php?&post_type=community&property-neighborhood=$matches[1]','top');
add_rewrite_rule('^community/([^/]*)/?','index.php?post_type=community&name=$matches[1]','top');
//Market
add_rewrite_rule('^markets/([^/]*)/?', 'index.php?post_type=market&property-neighborhood=$matches[1]', 'top');
add_rewrite_rule('^market/([^/]*)/?', 'index.php?post_type=market&name=$matches[1]', 'top');
//Database
add_rewrite_rule('^db/([^/]*)/?', get_theme_file_uri('/db/data.php'), 'top');


// function pid_load_more_scripts() {
//  	if ( is_home() ) {
// 		global $wp_query; 
 
// 		// In most cases it is already included on the page and this line can be removed
// 		//wp_enqueue_script('jquery');
 
// 		// register our main script but do not enqueue it yet
// 		wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/js/loadmore.js', array('jquery') );
 
// 		// now the most interesting part
// 		// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
// 		// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
// 		wp_localize_script( 'my_loadmore', 'loadmore_params', array(
// 			'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
// 			'posts' => serialize( $wp_query->query_vars ), // everything about your loop is here
// 			'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
// 			'max_page' => $wp_query->max_num_pages
// 		) );
 
// 	 	wp_enqueue_script( 'my_loadmore' );
//  	}
// }
// add_action( 'wp_enqueue_scripts', 'pid_load_more_scripts' );

//ajax handler
function pid_loadmore_ajax_handler(){
  $X = set_debug(__FILE__);
	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
 
	// it is always better to use WP_Query but not here
	query_posts( $args );
  print_X($X, __LINE__, $args['paged']);
  $post_type = $args['post_type'];
  $post_type_labels = get_post_type_labels(get_post_type_object($post_type));

	if( have_posts() ) :
    $iLoop =1;
		// run the loop
		while( have_posts() ): the_post();
      print_X($X, __LINE__, '$iLoop::', $iLoop++);
			// look into your theme code how the posts are inserted, but you can use your own HTML of course
			// do you remember? - my example is adapted for Twenty Seventeen theme
      // get_template_part( 'template-parts/content', get_post_format() );
      //get_template_part('template-parts/content', 'x-postx');
      ?>
        <div style="text-align: left">
            <h3><a href="<?php echo str_replace("/" . strtolower($post_type_labels->name) . "/",
            "/" . strtolower($post_type_labels->singular_name) . "/",
            strtolower(get_the_permalink())); ?>">
                <?php the_title();?></a>
            </h3>
            <div><?php the_excerpt();?> </div>
        </div>
      <?php
      // for the test purposes comment the line above and uncomment the below one
        // the_title();

        // echo '</br>';
        // the_excerpt();
        // echo '</br>';

		endwhile;
 
	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}
add_action('wp_ajax_loadmore', 'pid_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'pid_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}

//Add include modules
require_once (get_stylesheet_directory() . '/inc/neighborhood-metabox.php');

// function add_cors_http_header()
// {
//     header("Access-Control-Allow-Origin: *");
// }
// add_action('init', 'add_cors_http_header');


//End of PHP

/*
  GENERAL FUNCTION LIBRARY
*/



// function print_var_name($var){
//   foreach ($GLOBALS as $var_name => $value) {
//       if ($value === $var) {
//           return $var_name;
//       }
//   }
//   return false;
// }

// function get_func_argNames($funcName)
// {
//     $f = new ReflectionFunction($funcName);
//     $result = array();
//     foreach ($f->getParameters() as $param) {
//         $result[] = $param->name;
//     }
//     return $result;
// }

?>