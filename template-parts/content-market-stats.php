<!--
  Single Market Template File
  Dec 15 2019
-->

<?php

  $X = set_debug(__FILE__);

  //get the neighborhood_code
  //All markets | City code | district code | Neighborhood Code
  $qvar = get_query_var('qvar'); //get neighborhood_code

  print_X($X, __LINE__, 'get_the_ID()', get_the_ID(), get_the_title(), $qvar); //d//
  // print_X($X, __LINE__, get_post_meta(get_the_ID(), 'neighborhood_code', false));
  // if (is_single(get_the_ID())){
  //   echo '<div>true</div>';
  // }else{
  //   echo '<div>false</div>';
  // }

  if($qvar){
    $the_neighborhood = $qvar;
  }else{
    $the_neighborhood = get_the_title();
  }

  $the_neighborhood=trim($the_neighborhood);

  $metabox = nbh_3level_metabox(get_the_ID());
  // print_X($X, __LINE__, $metabox); //d//
  $neighborhood_codes = '';
  $neighborhood_names = [];
  foreach($metabox as $meta){
    $neighborhood_codes .= $meta['3'] . ",";
    $neighborhood_names[$meta['3']] = $meta['1'] ;
  }
  $neighborhood_codes = rtrim($neighborhood_codes, ',');
  print_X($X, __LINE__, $neighborhood_names);
  print_X($X, __LINE__, $neighborhood_codes, json_encode($neighborhood_names));

  global $wpdb;
  $results = $wpdb->get_results("SELECT Neighborhood_Code, nbh.RE_Area_Code, nbh.City_Code, city.City_Name, area.RE_Area_Name 
                                  FROM pid_neighborhoods nbh
                                  RIGHT JOIN pid_cities city ON city.City_ID = nbh.City_ID
                                  RIGHT JOIN pid_re_areas area ON area.RE_Area_Code = nbh.RE_Area_Code
                                  WHERE neighborhood_name='" . $the_neighborhood . "'");

  foreach($results as $nbh){
    $nbh_codes = trim($nbh->Neighborhood_Code) . ',' . trim($nbh->RE_Area_Code) . ',' . trim($nbh->City_Code);
    print_X($X, __LINE__, $nbh_codes);
    $nbh->City_Code = trim($nbh->City_Code);
    $nbh->RE_Area_Code = trim($nbh->RE_Area_Code);
    $nbh->Neighborhood_Code = trim($nbh->Neighborhood_Code);
    $nbh_names=array(
      @$nbh->City_Code => trim($nbh->City_Name),
      @$nbh->RE_Area_Code => trim($nbh->RE_Area_Name),
      @$nbh->Neighborhood_Code => trim(get_the_title())
    );
    print_X($X, __LINE__, $nbh_names);
    print_X($X, __LINE__, json_encode($nbh_names));
  }
      
?>

<div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
  <div style="font-size: 20px; text-align: left; display: block" 
        id="marketSection" nbhCodes="<?php echo $neighborhood_codes; ?>" nbhNames='<?php echo json_encode($neighborhood_names); ?>'>
   
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
<div style="text-align: left">
  <form style="display:block">
    <span style="display:inline-block!important;">Select Property Type: &nbsp&nbsp&nbsp&nbsp </span>
    <select id="Property_Type" name="Property_Type" style="width: 150px!important; border: 1px">
      <option value="All">All Property</option>
      <option value="Detached">Detached Property</option>
      <option value="Townhouse">Townhouse</option>
      <option value="Apartment">Apartment</option>
    </select> 
  </form>
  <div style="clear:both"></div>
</div>
<div style="text-align: left">
  <canvas id="lineChart" height="400px !important", width="400"></canvas>
</div>

<?php
if(have_posts()){
    while (have_posts()) {
      the_post();?>
        <div style="text-align: left">
          <h2><?php //the_title();?></h2>
          <?php //get_field('banner_image')?>
          <div><?php //the_content();?> </div> 
          <!-- <div><iframe style="border: 2px; color: blue;" width="400" height="300" 
            src="https://statscentre.rebgv.org/infoserv/s-v1/8ezk-7wW?w=400&h=300"></iframe>
          </div> -->
          
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
    <?php /*while[]*/}
} /*if */ ?>

