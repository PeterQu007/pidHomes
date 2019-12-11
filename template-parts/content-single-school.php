<!--
  Single School Template File
  Dec 10 2019
-->

<?php
    $terms = get_the_terms(get_the_ID(), 'property-neighborhood');
    // print_r($terms); //d//
    foreach ($terms as $term) {
      //Get Top Level Term
      if (!$term->parent) {
          $topTermID = $term->term_id;
          $topTermName = $term->name;
          // echo $topTermID; //d//
          // echo $topTermName; //d//
      }

      //Get Level 3 Term
      if(!get_term_children($term->term_id, 'property-neighborhood')){

        $level3TermID = $term->term_id;
        $level3TermName = $term->name;
        $level3TermSlug = $term->slug;
        // echo $Level3TermID; //d//
        // echo $Level3TermName; //d//
      }
    }
    foreach($terms as $term){
      //Get Level 2 Term
      if($topTermID & $term->parent == $topTermID){
          $level2TermID = $term->term_id;
          $level2TermName = $term->name;
          $level2TermSlug = $term->slug;
          // echo $Level2TermID; //d//
          // echo $Level2TermName; //d//
      }
    }
    //echo get_term_link(54);
  ?>


<div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block">
   
    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('school'); ?>">
      <i class="fas fa-school" aria-hidden="true"></i>
      All Schools
     </a>
    <!-- Top Level City -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/schools/' . $topTermName; ?>">
      <i class="fas fa-city" aria-hidden="true"></i>
      <?php echo $topTermName; ?> </a>
    <!-- Level 2 City District -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/schools/' . $level2TermSlug; ?>">
      <i class="fas fa-building" aria-hidden="true"></i>
      <?php echo $level2TermName; ?> </a>
    <!-- Level 3 City Neighborhoods -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/schools/' . $level3TermSlug; ?>">
      <i class="fas fa-university" aria-hidden="true"></i>
      <?php echo $level3TermName; ?> </a>

    <span class="metabox__main"><?php //the_title();//x//?></span>

  </div>
</div>

<?php

while (have_posts()) {
  the_post();?>
    <div style="text-align: left">
    <h2><?php the_title();?></h2>
    <?php get_field('banner_image')?>
    <div><?php the_content();?> </div>
    <div class="acf-map">
            <?php
              $mapLocation = get_field('map_location');?>
                <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a> </h3>
                <?php echo $mapLocation['address']; ?>
                </div>
            </div>
          </div>
    <?php 
    global $wpdb;
    //$school = $wpdb->get_var("SELECT COUNT(*) FROM pid_schools WHERE school_name='Fraser Heights'");
    //echo "<p>User Count is {$user_count}</p>";
    $results = $wpdb->get_results("SELECT school_year, school_type, `rank`, rank5, rating FROM pid_schools WHERE school_name='" . get_field('school_name') . "'");
    // foreach($results as $school){
    //    echo "<p>{$school->rank}</p>";
    // }
    ?>
    <!--
      toDo: Format School Rank & Rating Style
    -->
    <div><span>School Year: &nbsp<?php echo $results[0]->school_year; ?></span></div>
    <div><span>School Type: &nbsp<?php echo $results[0]->school_type; ?></span></div>
    <div><span>FI Rank: &nbsp<?php echo $results[0]->rank; ?> </span></div>
    <div><span>FI Rating: &nbsp<?php echo $results[0]->rating . '/10'; ?></span></div>

<?php /*while[]*/}?>
