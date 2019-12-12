<!--

  Generate Neighborhood 2 Level Metabox Data
-->

<?php

function nbh_3level_metabox($neighborhoodID){

	$metabox = [];

	$terms = get_the_terms($neighborhoodID, 'property-neighborhood');
    // print_r($terms); //d//
    foreach ($terms as $term) {
      //Get Top Level Term
      if (!$term->parent) {
          $topTermID = $term->term_id;
          $topTermName = $term->name;
          $topTermSlug = $term->slug;
          // echo $topTermID; //d//
          // echo $topTermName; //d//
      }

      //Get Level 3 Term
      if(!get_term_children($term->term_id, 'property-neighborhood')){

        $level3TermID = $term->term_id;
        $level3TermName = $term->name;
        $level3TermSlug = $term->slug;
        // echo $level3TermID; //d//
        // echo $level3TermName; //d//
      }
    }
    foreach($terms as $term){
      //Get Level 2 Term
      if($topTermID & $term->parent == $topTermID){
          $level2TermID = $term->term_id;
          $level2TermName = $term->name;
          $level2TermSlug = $term->slug;
          // echo $level2TermID; //d//
          // echo $level2TermName; //d//
          
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

    return $metabox;
}

function nbh_2level_metabox($nbhID){

  echo '<p style="color: red"> nbh 2level metabox args: ' . $nbhID. '</p>'; //d//

  $metabox = [];

  $terms = get_the_terms($nbhID, 'property-neighborhood');

  // $terms = get_terms(array(
  //   'taxonomy' => 'property-neighborhood',
  //   //'object_ids' => 87, //metrotown //d//
  //   //'exclude_tree' => 92,
  //   'parent' => 0,
  //   //'child_of' => 92,
  //   //'fields' => 'names',
  //   //name__like' => 'burnaby',
  //   'hide_empty' => false,
  //   'slug' => $terms,
  //   'order' => 'DESC'
  // ));


  print_r($terms); //d//
  foreach ($terms as $term) {
      //Get Top Level Term
      if (!$term->parent) {
          $topLevelTerm = $term;
          $topTermID = $term->term_id;
          $topTermName = $term->name;
          echo '<p style="color: red"> nbh 2level metabox top Term ID: ' . $topTermID . '</p>'; //d//
          echo $topTermName; //d//
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
  echo "<p> level2Terms: </p>"; //d//
  print_r($level2Terms); //d//

  foreach ($level2Terms as $term) {
      //Get Level 2 Term
      echo '<p>' . $term->name . '</p>'; //d//

  }
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

function nbh_top2level_terms($termSlug){

  $metabox = [];

  $term = get_term_by('slug', $termSlug, 'property-neighborhood');

  echo "<p> inside function </p>";
  print_r($term);

  while($term->parent){
    $term = get_term_by('id', $term->parent, 'property-neighborhood');
  }
  $topLevelTerm = $term;

$level2Terms = get_terms(array(
    'taxonomy' => 'property-neighborhood',
    'parent' => $term->term_id, //get direct children
    'orderby' => 'slug',
    'order' => 'ASC', //'DESC',
    //'child_of' => $topTermID, //get all children
    'hide_empty' => false,
));
echo "<p> level2Terms: </p>"; //d//
print_r($level2Terms); //d//

foreach ($level2Terms as $term) {
    //Get Level 2 Term
    echo '<p>' . $term->name . '</p>'; //d//

}

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

