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

//Add Child Functions

function pidHomes_child_features()
{
    add_theme_support('title-tag');
    //41. Featured Image Post
    add_theme_support('post-thumbnails');
    //41.. Add image size
    //42.. Crop image precisely, use parameter array('left', 'top') to replace true
    //42.. example: add_image_size('professorLandscape', 400, 260, array('left','top'));
    //42.. use 'manual image crop' plugin to do the precisely cropping;
    //add_image_size('professorLandscape', 400, 260, true);
    //add_image_size('professorPortrait', 480, 650, true);
    //43.. Add page banner pic size
    add_image_size('pageBanner', 1500, 350, true);
}

add_action('after_setup_theme', 'pidHomes_child_features');


function pidHomesMapKey($api)
{
    $api['key'] = 'AIzaSyAczOjPVWMravPAIpPPegKgPtTFiipbgMM';
    return $api;
}
add_filter('acf/fields/google_map/api', 'pidHomesMapKey');


function pidhomes_child_files()
{
    //49. Map on Front-End | 49.. Add google map js and key
    wp_enqueue_script('googleMap', '//maps.googleapis.com/maps/api/js?key=AIzaSyAczOjPVWMravPAIpPPegKgPtTFiipbgMM', null, '1.0', true);
    wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), null, '1.0', true);
    wp_enqueue_script('CentrisMainFramework', get_theme_file_uri('/js/centris.js'), null, '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_stylesheet_uri());
    //59.
    wp_localize_script('main-university-js', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest'), //80. | Prepare to authorize to delete a note post
    ));
}

add_action('wp_enqueue_scripts', 'pidhomes_child_files');

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


//End of PHP
?>
