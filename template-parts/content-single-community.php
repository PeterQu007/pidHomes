<!--

  @parameter $communityID

-->

<?php
  $communityID = get_query_var('communityID');
  // echo 'get_the_ID()' . get_the_ID(); //d//
  // echo 'communityID: ' . $communityID; //d//
?>

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
    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('community'); ?>">
    <i class="fas fa-map-marked" aria-hidden="true">
    </i> All Communities
    </a>
    
    <!-- Top Level City -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . 'communities/' . $topTermName; ?>">
      <i class="fas fa-city" aria-hidden="true"></i>
      <?php echo $topTermName; ?> </a>
    <!-- Level 2 City District -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/communities/' . $level2TermSlug; ?>">
      <i class="fas fa-building" aria-hidden="true"></i>
      <?php echo $level2TermName; ?> </a>
    <!-- Level 3 City Neighborhoods -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/communities/' . $level3TermSlug; ?>">
      <i class="fas fa-university" aria-hidden="true"></i>
      <?php echo $level3TermName; ?> </a>

    <span class="metabox__main"><?php //the_title();//x//?></span>
  </div>
</div>

<?php 
  if($communityID){
    //define custom query by communityID
    //Define the query to get community posts
    $Communities = new WP_Query(array(
        'post_type' => 'community',
        'tax_query' => array(
            array(
                'taxonomy' => 'property-neighborhood',
                'field' => 'term_taxonomy_id', //'slug',
                'terms' =>  $communityID //'Fraser Heights' //$term->name,
            ),
          ),
          'posts_per_page' => -1,
        ));
  }else{
    $Communities = new WP_Query(array(
      'post_type' => 'community',
      'p' =>get_the_ID()
    ));
  }
  // print_r($Communities); //d//
?>

<?php 
  while ($Communities->have_posts()) { //while[]
      $Communities->the_post();  ?>
        <div style="text-align: left">
          <h2><?php the_title();?></h2>
          <?php get_field('banner_image') ?>
          <div><?php $communityID ? the_excerpt() : the_content();?> </div>
          <?php if($communityID){?>
            <div class="acf-map">
              <?php
                $mapLocation = get_field('map_location');?>
                <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a> </h3>
                <?php echo $mapLocation['address']; ?>
                </div>
            </div>
          <?php }?>
        </div>
        <!--
          toDo: Format Community Profile data
        -->
        <div><span>Community Area: &nbsp<?php echo get_field('community_area'); ?></span></div>
        <div><span>Private Dwellings: &nbsp<?php echo get_field('occupied_private_dwellings'); ?></span></div>
        <div><span>Population: &nbsp<?php echo get_field('population'); ?> </span></div>
        <div><span>Average Household Income: &nbsp<?php echo get_field('average_household_income'); ?></span></div>

  <?php } //[]?>