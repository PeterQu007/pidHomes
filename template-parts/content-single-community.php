<!--

  @parameter $communityID

-->

<?php
  $communityID = get_query_var('communityID');
  // echo 'get_the_ID()' . get_the_ID(); //d//
  // echo 'communityID: ' . $communityID; //d//
  //require get_stylesheet_directory() . '/inc/generate-neighborhood-metabox.php';
  $metabox = nbh_3level_metabox(get_the_ID());
  print_r($metabox); //d//
?>

<div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block">
    <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('community'); ?>">
    <i class="fas fa-map-marked" aria-hidden="true">
    </i> All Communities
    </a>
    
    <!-- Top Level City -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/communities/' . $metabox[0]['level1TermSlug']; ?>">
      <i class="fas fa-city" aria-hidden="true"></i>
      <?php echo $metabox[0]['level1TermName']; ?> </a>
    <!-- Level 2 City District -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/communities/' . $metabox[1]['level2TermSlug']; ?>">
      <i class="fas fa-building" aria-hidden="true"></i>
      <?php echo $metabox[1]['level2TermName']; ?> </a>
    <!-- Level 3 City Neighborhoods -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/community/' . $metabox[2]['level3TermSlug']; ?>">
      <i class="fas fa-university" aria-hidden="true"></i>
      <?php echo $metabox[2]['level3TermName']; ?> </a>

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
          <?php if(!$communityID){?>
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