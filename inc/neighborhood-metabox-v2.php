<?php

/*
  MODULE OF FUNCTION.PHP
  ======================
  @neighborhoodID
  Version 2
  use pid_neighborhoods and pdo
  return metabox for section banner menu
*/
function nbh_3level_metabox($neighborhoodID){

  $X = set_debug(__FILE__);
  // print_X1($X, __LINE__, "---------------");
  print_X($X, __LINE__, 'neighborhoodID::', $neighborhoodID);

	$metabox = [];

	$terms = get_the_terms($neighborhoodID, 'property-city');
  // print_X($X, __LINE__, __FUNCTION__ , $terms); //d//

  //use pdo
    include(get_stylesheet_directory() . '/db/pdoConn.php');
    $stmt_check_nbh_level = $pdo->prepare("CALL procedure_nbh_single_path_by_term_id(?)");
    $stmt_check_nbh_level->bindParam(1, $terms[0]->term_id , PDO::PARAM_INT);
    $stmt_check_nbh_level->execute();
    $term_single_path = [];
    while($level = $stmt_check_nbh_level->fetch()){
        $term_single_path[] = $level;
    };
    // print_X($X, __LINE__, $term_single_path);
    $stmt_check_nbh_level = null;
    $pdo = null;

    foreach ($term_single_path as $term) {
      // print_X($X, __LINE__, $term, $term['nbh_level']);
      switch($term['nbh_level']){
        case 0:
          $topTermID = $term['nbh_term_id'];
          $topTermName = $term['nbh_name'];
          $topTermSlug = $term['slug'];
          $topTermCode = $term['nbh_code'];
        break;
        case 1:
          $level2TermID = $term['nbh_term_id'];
          $level2TermName = $term['nbh_name'];
          $level2TermSlug = $term['slug'];
          $level2TermCode = $term['nbh_code'];
        break;
        case 2:
          $level3TermID = $term['nbh_term_id'];
          $level3TermName = $term['nbh_name'];
          $level3TermSlug = $term['slug'];
          $level3TermCode = $term['nbh_code'];
        break;
      }

    }

    array_push($metabox, array(
              '0'=> $topTermID,
              '1'=> $topTermName,
              '2' => $topTermSlug,
              '3' => $topTermCode,
              'Term_ID' => $topTermID,
              'Term_Name' => $topTermName,
              'Term_Slug' => $topTermSlug,
              'Term_Code' => $topTermCode,
              'show_metabox' => true,
              'get_chartdata' => true
            ));

    array_push($metabox, array(
              '0' => $level2TermID,
              '1' => $level2TermName,
              '2' => $level2TermSlug,
              '3' => $level2TermCode,
              'Term_ID' => $level2TermID,
              'Term_Name' => $level2TermName,
              'Term_Slug' => $level2TermSlug,
              'Term_Code' => $level2TermCode,
              'show_metabox' => true,
              'get_chartdata' => true
          ));
     array_push($metabox, array(
              '0' => $level3TermID,
              '1' => $level3TermName,
              '2' => $level3TermSlug,
              '3' => $level3TermCode,
              'Term_ID' => $level3TermID,
              'Term_Name' => $level3TermName,
              'Term_Slug' => $level3TermSlug,
              'Term_Code' => $level3TermCode,
              'show_metabox' => true,
              'get_chartdata' => true
             ));   
    
    // print_X($X, __LINE__, $metabox);

    return $metabox;
}

/*
  @community post ID: $nbhID
  return: first two level terms of community taxonomy tree
*/
function nbh_2Level_metabox_by_ID($nbhID){

  $X = set_debug(__FILE__);

  $metabox = [];

  $terms = get_the_terms($nbhID, 'property-city');

  // print_x('blue', 'nbh_2Level_metabox_by_ID ' . $nbhID, $terms); //d//

  foreach ($terms as $term) {
    //Get Top Level Term
    if (!$term->parent) {
        $topLevelTerm = $term;
        $topTermID = $term->term_id;
        $topTermName = $term->name;
        $topTermCode = get_term_meta($term->term_id, 'neighborhood_code', true);
        // print_X( $X, __LINE__, __FUNCTION__ , $topTermID, $topLevelTerm); //d//
    }
  }

  $level2Terms = get_terms(array(
    'taxonomy' => 'property-city',
    'parent' => $topTermID, //get direct children
    'orderby' => 'slug',
    'order' => 'ASC', //'DESC',
    //'child_of' => $topTermID, //get all children
    'hide_empty' => false,
  ));
  // print_X('green', $level2Terms); //d//

  // $level2Term1 = $level2Terms[0];
  // $level2Term2 = $level2Terms[1];
  // $level2Term3 = $level2Terms[2];

  // Output the results with Normalized Var names
  array_push($metabox, array(
      '0' => $topLevelTerm->term_id,
      '1' => $topLevelTerm->name,
      '2' => $topLevelTerm->slug,
      '3' => $topTermCode,
      'Term_ID' => $topLevelTerm->term_id,
      'Term_Name' => $topLevelTerm->name,
      'Term_Slug' => $topLevelTerm->slug,
      'Term_Code' => $topTermCode,
      'show_metabox' => true
    ));

    for($i=0; $i < count($level2Terms); $i++){
      array_push($metabox, array(
          '0' => $level2Terms[$i]->term_id,
          '1' => $level2Terms[$i]->name,
          '2' => $level2Terms[$i]->slug,
          '3' => get_term_meta($level2Terms[$i]->term_id, 'neighborhood_code', true),
          'Term_ID' => $level2Terms[$i]->term_id,
          'Term_Name' => $level2Terms[$i]->name,
          'Term_Slug' => $level2Terms[$i]->slug,
          'Term_Code' => get_term_meta($level2Terms[$i]->term_id, 'neighborhood_code', true),
          'show_metabox' => true
        ));
    }

  return $metabox;
}

/* @communityTermSlug
   return city & city district terms (first 2 level terms in the community taxonomy tree)
*/
function nbh_2Level_metabox_by_Slug($communityTermSlug){

  $X = set_debug(__FILE__);

  $metabox = [];

  $term = get_term_by('slug', $communityTermSlug, 'property-city');
  // print_x($X, __LINE__, __FUNCTION__, $term); //d//

  // Loop for top community term
  if($term->parent){
    $term = get_term_by('id', $term->parent, 'property-city');
  }
  $topLevelTerm = $term;
  // print_x($X, __LINE__, __FUNCTION__, $term); //d//

  // Fetch second level (City District) terms
  $level2Terms = get_terms(array(
      'taxonomy' => 'property-city',
      'parent' => $term->term_id, //get direct children
      'orderby' => 'slug', //district slug is named by [city]-#
      'order' => 'ASC', //'DESC',
      //'child_of' => $topTermID, //get all children
      'hide_empty' => false,
  ));

  // print_x($X, __LINE__, 'level2Terms::', $level2Terms); //d//

  // Output the results with Normalized Var names
  array_push($metabox, array(
      '0' => $topLevelTerm->term_id,
      '1' => $topLevelTerm->name,
      '2' => $topLevelTerm->slug,
      '3' => get_term_meta($topLevelTerm->term_id, 'neighborhood_code', true),
      'Term_ID' => $topLevelTerm->term_id,
      'Term_Name' => $topLevelTerm->name,
      'Term_Slug' => $topLevelTerm->slug,
      'Term_Code' => get_term_meta($topLevelTerm->term_id, 'neighborhood_code', true),
      'show_metabox' => true
  ));

  for($i=0; $i < count($level2Terms); $i++){
    array_push($metabox, array(
        '0' => $level2Terms[$i]->term_id,
        '1' => $level2Terms[$i]->name,
        '2' => $level2Terms[$i]->slug,
        '3' => get_term_meta($level2Terms[$i]->term_id, 'neighborhood_code', true),
        'Term_ID' => $level2Terms[$i]->term_id,
        'Term_Name' => $level2Terms[$i]->name,
        'Term_Slug' => $level2Terms[$i]->slug,
        'Term_Code' => get_term_meta($level2Terms[$i]->term_id, 'neighborhood_code', true),
        'show_metabox' => true
    ));
  }

  // print_X($X, __LINE__, __FUNCTION__, $metabox);
  return $metabox;
}

function nbh_Direct_2Level_metabox_by_Slug($communityTermSlug)
{

    $X = set_debug(__FILE__);

    $metabox = [];

    // if($communityTermSlug){
      $level1Term = get_term_by('slug', $communityTermSlug, 'property-city');
      $level1Terms =[];
      $level2Terms = [];
      // print_x($X, __LINE__, __FUNCTION__, '$communityTermSlug::', $communityTermSlug, '$level1Term::', $level1Term);

      // Loop for top community term
      if ($level1Term->parent) {
          $topLevelTerm = get_term_by('id', $level1Term->parent, 'property-city');
          $level1Terms = get_terms(array(
            'taxonomy' => 'property-city',
            'parent' => $topLevelTerm->term_id, //get direct children
            'orderby' => 'slug', //district slug is named by [city]-#
            'order' => 'ASC', //'DESC',
            //'child_of' => $topTermID, //get all children
            'hide_empty' => false,
          ));
      }else{
        $level1Terms[] = $level1Term;
        $topLevelTerm = $level1Term;
      }
      // print_X($X, __LINE__, "TopLevelTerms::", $topLevelTerms);

//use pdo
    include(get_stylesheet_directory() . '/db/pdoConn.php');
    $stmt_check_nbh_level = $pdo->prepare("CALL procedure_nbh_fetch_top_2_level_by_term_id(?)");
    $stmt_check_nbh_level->bindParam(1, $topLevelTerm->term_id , PDO::PARAM_INT);
    $stmt_check_nbh_level->execute();
    $term_single_path = [];
    while($level = $stmt_check_nbh_level->fetch()){
        $top2LevelTerms[] = $level;
    };
    // print_X($X, __LINE__, $top2LevelTerms);
    $stmt_check_nbh_level = null;
    $pdo = null;

    // Output the results with Normalized Var names

    for($i = 0; $i<count($top2LevelTerms); $i++){
      array_push($metabox, array(
          '0' => $top2LevelTerms[$i]['nbh_term_id'],
          '1' => $top2LevelTerms[$i]['nbh_name'],
          '2' => $top2LevelTerms[$i]['slug'],
          '3' => $top2LevelTerms[$i]['nbh_code'],
          'Term_ID' => $top2LevelTerms[$i]['nbh_term_id'],
          'Term_Name' => $top2LevelTerms[$i]['nbh_name'],
          'Term_Slug' => $top2LevelTerms[$i]['slug'],
          'Term_Code' => $top2LevelTerms[$i]['nbh_code'],
          'show_metabox' => true,
          'get_chartdata' => true
      ));
    }

    // print_X($X, __LINE__, __FUNCTION__, $metabox);
    return $metabox;
}

    
?>

