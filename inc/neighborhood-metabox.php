<?php

/*
  @neighborhoodID
  return metabox for section banner menu
*/
function nbh_3level_metabox($neighborhoodID){

  // print_X('red', __FILE__, 'neighborhoodID', $neighborhoodID);

	$metabox = [];

	$terms = get_the_terms($neighborhoodID, 'property-neighborhood');
    // print_X('', __LINE__, __FILE__, __FUNCTION__ , $terms); //d//

    foreach ($terms as $term) {
      //Get Top Level Term
      if (!$term->parent) {
          $topTermID = $term->term_id;
          $topTermName = $term->name;
          $topTermSlug = $term->slug;
      }

      //Get Level 3 Term
      if(!get_term_children($term->term_id, 'property-neighborhood')){
        $level3TermID = $term->term_id;
        $level3TermName = $term->name;
        $level3TermSlug = $term->slug;
      }
    }
    foreach($terms as $term){
      //Get Level 2 Term
      if($topTermID & $term->parent == $topTermID){
          $level2TermID = $term->term_id;
          $level2TermName = $term->name;
          $level2TermSlug = $term->slug;
      }
    }

    array_push($metabox, array(
              'level1TermID' => $topTermID,
              'level1TermName' => $topTermName,
              'level1TermSlug' => $topTermSlug
            ));

    array_push($metabox, array(
              'level2TermID' => $level2TermID,
              'level2TermName' => $level2TermName,
              'level2TermSlug' => $level2TermSlug
          ));
     array_push($metabox, array(
              'level3TermID' => $level3TermID,
              'level3TermName' => $level3TermName,
              'level3TermSlug' => $level3TermSlug
             ));   
    
    // print_X('red', __FILE__, $metabox);

    return $metabox;
}

/*
  @community post ID: $nbhID
  return: first two level terms of community taxonomy tree
*/
function nbh_2level_metabox($nbhID){

  $metabox = [];

  $terms = get_the_terms($nbhID, 'property-neighborhood');

  // print_x('blue', 'nbh_2level_metabox ' . $nbhID, $terms); //d//

  foreach ($terms as $term) {
    //Get Top Level Term
    if (!$term->parent) {
        $topLevelTerm = $term;
        $topTermID = $term->term_id;
        $topTermName = $term->name;
        // print_x( '', __LINE__, __FUNCTION__ , $topTermID, $topLevelTerm); //d//
    }
  }

  $level2Terms = get_terms(array(
    'taxonomy' => 'property-neighborhood',
    'parent' => $topTermID, //get direct children
    'orderby' => 'slug',
    'order' => 'ASC', //'DESC',
    //'child_of' => $topTermID, //get all children
    'hide_empty' => false,
  ));
  // print_X('green', $level2Terms); //d//

  $level2Term1 = $level2Terms[0];
  $level2Term2 = $level2Terms[1];
  $level2Term3 = $level2Terms[2];

  // Output the results with Normalized Var names
  array_push($metabox, array(
      'level0_Term1_ID' => $topLevelTerm->term_id,
      'level0_Term1_Name' => $topLevelTerm->name,
      'level0_Term1_Slug' => $topLevelTerm->slug
    ));
  array_push($metabox, array(
      'level1_Term1_ID' => $level2Term1->term_id,
      'level1_Term1_Name' => $level2Term1->name,
      'level1_Term1_Slug' => $level2Term1->slug
    ));
  array_push($metabox, array(
      'level1_Term2_ID' => $level2Term2->term_id,
      'level1_Term2_Name' => $level2Term2->name,
      'level1_Term2_Slug' => $level2Term2->slug
    ));
  array_push($metabox, array(
      'level1_Term3_ID' => $level2Term3->term_id,
      'level1_Term3_Name' => $level2Term3->name,
      'level1_Term3_Slug' => $level2Term3->slug
    ));
  return $metabox;
}

/* @communityTermSlug
   return city & city district terms (first 2 level terms in the community taxonomy tree)
*/
function nbh_top2level_terms($communityTermSlug){

  $metabox = [];

  $term = get_term_by('slug', $communityTermSlug, 'property-neighborhood');

  // print_x('', __FUNCTION__, $term); //d//

  // Loop for top community term
  while($term->parent){
    $term = get_term_by('id', $term->parent, 'property-neighborhood');
  }
  $topLevelTerm = $term;

  // Fetch second level (City District) terms
  $level2Terms = get_terms(array(
      'taxonomy' => 'property-neighborhood',
      'parent' => $term->term_id, //get direct children
      'orderby' => 'slug', //district slug is named by [city]-#
      'order' => 'ASC', //'DESC',
      //'child_of' => $topTermID, //get all children
      'hide_empty' => false,
  ));

  // print_x('', 'level2Terms', $level2Terms); //d//

  $level2Term1 = $level2Terms[0];
  $level2Term2 = $level2Terms[1];
  $level2Term3 = $level2Terms[2];

  // Output the results with Normalized Var names
  array_push($metabox, array(
      'level0_Term1_ID' => $topLevelTerm->term_id,
      'level0_Term1_Name' => $topLevelTerm->name,
      'level0_Term1_Slug' => $topLevelTerm->slug,
  ));
  array_push($metabox, array(
      'level1_Term1_ID' => $level2Term1->term_id,
      'level1_Term1_Name' => $level2Term1->name,
      'level1_Term1_Slug' => $level2Term1->slug,
  ));
  array_push($metabox, array(
      'level1_Term2_ID' => $level2Term2->term_id,
      'level1_Term2_Name' => $level2Term2->name,
      'level1_Term2_Slug' => $level2Term2->slug,
  ));
  array_push($metabox, array(
      'level1_Term3_ID' => $level2Term3->term_id,
      'level1_Term3_Name' => $level2Term3->name,
      'level1_Term3_Slug' => $level2Term3->slug,
  ));

  return $metabox;
}
    
?>

