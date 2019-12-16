<!--

  @parameter $communityID

-->

<?php
  $communityID = get_query_var('communityID');
  // print_X('Blue', __FILE__ , $communityID);
  $metabox = nbh_2level_metabox(get_the_ID());
?>

<div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block">
    <?php
    if(!$communityID){?>
      <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('community'); ?>">
      <i class="fas fa-map-marked" aria-hidden="true">
      </i> All
      </a>
    <?php }?>
    
    <?php //echo '<P> metabox in single: ' . $metabox[1]['level1TermSlug'] . '</p>'; ?> 

    <!-- Top Level City -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/communities/' . $metabox[0]['level0_Term1_Slug']; ?>">
      <i class="fas fa-city" aria-hidden="true"></i>
      <?php echo $metabox[0]['level0_Term1_Name']; ?> </a>  

    <!-- Top Level City -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/communities/' . $metabox[1]['level1_Term1_Slug']; ?>">
      <i class="fas fa-city" aria-hidden="true"></i>
      <?php echo $metabox[1]['level1_Term1_Name']; ?> </a>
    <!-- Level 2 City District -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/communities/' . $metabox[2]['level1_Term2_Slug']; ?>">
      <i class="fas fa-building" aria-hidden="true"></i>
      <?php echo $metabox[2]['level1_Term2_Name']; ?> </a>
    <!-- Level 3 City Neighborhoods -->
    <a class="metabox__blog-home-link" href="<?php 
      echo get_site_url() . '/community/' . $metabox[3]['level1_Term3_Slug']; ?>">
      <i class="fas fa-university" aria-hidden="true"></i>
      <?php echo $metabox[3]['level1_Term3_Name']; ?> </a>

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
          <?php if (!$communityID) {?>
            <div class="acf-map">
              <?php
$mapLocation = get_field('map_location');?>
                <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a> </h3>
                <?php echo $mapLocation['address']; ?>
                </div>
            </div>
          <?php }?>
          <div><?php $communityID ? the_excerpt() : the_content();?> </div>
          
        </div>
        <!--
          toDo: Format Community Profile data
        -->
        <div><span>Community Area: &nbsp<?php echo get_field('community_area'); ?></span></div>
        <div><span>Private Dwellings: &nbsp<?php echo get_field('occupied_private_dwellings'); ?></span></div>
        <div><span>Population: &nbsp<?php echo get_field('population'); ?> </span></div>
        <div><span>Average Household Income: &nbsp<?php echo get_field('average_household_income'); ?></span></div>

  <?php } //[]?>