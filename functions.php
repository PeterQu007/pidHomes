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

//Add Rewrite Rules
add_rewrite_rule('^schools/([^/]*)/?','index.php?post_type=school&property-neighborhood=$matches[1]','top');
add_rewrite_rule('^school/([^/]*)/?','index.php?post_type=school&name=$matches[1]','top');

add_rewrite_rule('^communities/([^/]*)/?','index.php?post_type=community&property-neighborhood=$matches[1]','top');
add_rewrite_rule('^community/([^/]*)/?','index.php?post_type=community&name=$matches[1]','top');

require_once (get_stylesheet_directory() . '/inc/neighborhood-metabox.php');
//End of PHP

/*
  GENERAL FUNCTION LIBRARY
*/

/*
  @color
  @various messages
  print the messages by color
*/
function print_x($color = 'red', ...$msgs)
{
  if(!$color){
    $color = 'red';
  }
  echo '<div >';
    echo '<hr height="1" style="padding-top: 3px; border-bottom: 1px solid; color: lightblue">';
    $msgString = '<p style ="text-align: left; color:' . $color . '">';
    foreach($msgs as $msg){
      
      if (!(is_object($msg) or is_array($msg))) {
          if(file_exists($msg)){
            $msg=basename($msg);
          }
          $msgString .=  print_var_name($msg) . "=" . $msg . " :: " ;
      } elseif (is_array($msg)) {
          $msgString .= "^ARRAY " . print_var_name($msg) . "[ " . count($msg) . " ]";
          echo '<p style ="text-align: left; color:' . $color . '">';
          //print_r($msg);
          var_dump($msg);
          echo ' </p>';
      }elseif (is_object($msg)){
        $msgString .= "^OBJECT " . $msg->name. "{ " . count(array($msg)) . " }";
          echo '<p style ="text-align: left; color:' . $color . '">';
          var_dump($msg);
          //print_r($msg);
          echo ' </p>';
      }
    }
    $msgString .= '</p>';
    echo $msgString; //prints the debug message
    echo '<hr height="1" style="border: 1px solid; color: darkblue">';

  echo '</div>';
}

function print_var_name($var){
  foreach ($GLOBALS as $var_name => $value) {
      if ($value === $var) {
          return $var_name;
      }
  }
  return false;
}


?>
