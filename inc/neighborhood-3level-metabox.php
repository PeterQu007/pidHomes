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
    
?>

