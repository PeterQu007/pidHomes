    <?php

      $X = set_debug(__FILE__);
      //vars are from set_query_var() in the upper level module
      if(!$metabox){
        $metabox = nbh_2Level_metabox_by_Slug($term->slug); //d//
      }
      // print_X($X, __LINE__, 'Community slug:', $term->slug , $metabox); //d//
    ?>
    <!-- 
      SET UP Sub Area title meta box 
      Swtich between All Communities and City Catogary names
      All Communities Meta Box
      City Catogory Meta Box
    -->
    <div class="metabox metabox--with-home-link" style="font-size: 20px; text-align: left; display: block">
      <div style="font-size: 20px; text-align: left; display: block">
        <!-- First MetaBox Could invisible if in All Communities Mode-->
        <?php if($qvar){ ?>
          <a class="metabox__blog-home-link" href="<?php echo  get_post_type_archive_link($metabox_tax); ?>">
            <i class="<?php echo "fas fa-map-marked"; ?>" aria-hidden="true"></i> 
            All
          </a>  
        <?php } ?>

        <!-- Secondary Meta Box: show city name -->
        <?php
          for($i=0; $i < count($metabox); $i++){ ?>
            <a class="metabox__blog-home-link" href="<?php 
              echo get_post_type_archive_link($metabox_tax) . $metabox[$i][2]; ?>"> 
              <i class="fas fa-city" aria-hidden="true"></i>
              <?php echo $metabox[$i][1]; ?>
            </a>
          <?php }
        ?>

      </div>
    </div>
