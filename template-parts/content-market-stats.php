<!--
  Single Market Template File
  Dec 15 2019
-->

<?php
  // print_X('green', __FILE__, 'get_the_ID()', get_the_ID()); //d//

  $metabox = nbh_3level_metabox(get_the_ID());
  // print_X('green', __FILE__, $metabox); //d//
?>

<div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block">
   
    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('market'); ?>">
      <i class="fas fa-school" aria-hidden="true"></i>
      All Markets
     </a>
    <!-- Top Level City -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/markets/' . $metabox[0]["level1TermSlug"]; ?>">
      <i class="fas fa-city" aria-hidden="true"></i>
      <?php echo $metabox[0]["level1TermName"]; ?> </a>
    <!-- Level 2 City District -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/markets/' . $metabox[1]["level2TermSlug"]; ?>">
      <i class="fas fa-building" aria-hidden="true"></i>
      <?php echo $metabox[1]["level2TermName"]; ?> </a>
    <!-- Level 3 City Neighborhoods -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/markets/' . $metabox[2]["level3TermSlug"]; ?>">
      <i class="fas fa-university" aria-hidden="true"></i>
      <?php echo $metabox[2]["level3TermName"]; ?> </a>

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
      
    </div>
<?php /*while[]*/}?>
