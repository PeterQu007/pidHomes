  <?php get_header(); 

  // Page Head.
$header_variation = get_option('inspiry_listing_header_variation');
//echo $header_variation;

if (empty($header_variation) || ('none' === $header_variation)) {
    echo 'header';
    get_template_part('assets/modern/partials/banner/header');
} elseif (!empty($header_variation) && ('banner' === $header_variation)) {
    //echo 'property-archive';
    get_template_part('assets/modern/partials/banner/community');
}

if (inspiry_show_header_search_form()) {
    get_template_part('assets/modern/partials/properties/search/advance'); //d//
}

if (isset($_GET['view'])) {
    $view_type = $_GET['view'];
} else {
    /* Theme Options Listing Layout */
    $view_type = get_option('theme_listing_layout');
}

  ?>

  <div class="large-hero" style="top: -130px!important; z-index: -10!important">
    <!-- responsive image element, not work with ie-->
  	<picture>
      <source srcset="<?php echo get_theme_file_uri("assets/images/banner1-cityNightScene-large.jpg") ?> 1920w, 
                        <?php echo get_theme_file_uri("assets/images/banner1-cityNightScene-large-hi-dpi.jpg") ?> 3840w" media="(min-width:1380px)">
      <source srcset="<?php echo get_theme_file_uri("assets/images/banner1-cityNightScene-medium.jpg") ?> 1380w, 
                        <?php echo get_theme_file_uri("assets/images/hero--medium-hi-dpi.jpg") ?> 2760w" media="(min-width:990px)">
      <source srcset="<?php echo get_theme_file_uri("assets/images/banner1-cityNightScene-small.jpg") ?> 990w, 
                        <?php echo get_theme_file_uri("assets/images/hero--small-hi-dpi.jpg") ?> 1980w" media="(min-width:640px)">	
      <img srcset="<?php echo get_theme_file_uri("assets/images/banner1-cityNightScene-smaller.jpg") ?> 640w, 
                        <?php echo get_theme_file_uri("assets/images/hero--smaller-hi-dpi.jpg") ?> 1280w" 
                        alt="Coastal view of ocean and mountains" class="large-hero__image">	
  	</picture>
    
    <div class="large-hero__text-content">
  		<div class="wrapper"> 
  			<h1 class="large-hero__title">Peter Qu <i class="fa fa-star site-header__fa-padding"></i> GREAT VANCOUVER REALTOR</h1>
  			<h2 class="large-hero__subtitle">GREAT VANCOUVER REALTOR</h2>
        <div class="large-hero__title" style="margin: 10px!important; text-align: center; width:100%!important; border-bottom: none ">
                <span style="font-size: 3rem"><i class="fa fa-star site-header__fa-padding"></i>Professionalism </span>
                
                <span style="font-size: 3rem"><i class="fa fa-star site-header__fa-padding"></i> Integrity </span>
                
                <span style="font-size: 3rem"><i class="fa fa-star site-header__fa-padding"></i> Diligence</span></div>
        <!--
        <p><a href="#" class="btn btn--blue btn--large"><i class="fa fa-search site-header__fa-padding"></i>Home Search Now!</a></p>
        -->
  		</div>
  	</div>
  </div>

  <div id="BuyAndSell" class="page-section"  >
    <div class="wrapper">
      <div id="BuyerAndSeller" class="row row__gutters">

        <div class="row__medium-4 row__medium-4--larger row__b-margin-until-medium">
          <picture>
            <source sizes="404px" srcset="<?php echo get_theme_file_uri("assets/images/PeterQuFlyer-404X647.jpg") ?> 404w, 
                                          <?php echo get_theme_file_uri("assets/images/PeterQuFlyer-808X1293.jpg") ?> 808w" 
                                          media="(min-width:1020px)">
            <source sizes="320px" srcset="<?php echo get_theme_file_uri("assets/images/Peter-Qu-portrait-382X1073.jpg") ?> 382w, 
                                          <?php echo get_theme_file_uri("assets/images/Peter-Qu-portrait-hi-764X2146.jpg") ?> 764w" 
                                          media="(min-width:800px)">
            <img sizes="800px" srcset="<?php echo get_theme_file_uri("assets/images/PeterQuflyer-Landscape-800X651.jpg") ?> 800w, 
                                          <?php echo get_theme_file_uri("assets/images/Peter-Qu-Landscape-1600X1118.jpg") ?> 1600w" 
                                          alt="Surrey REALTOR, Peter Qu">
          </picture>
        </div>


      <div id="ForProfessionism" class="row__medium-8 row__medium-8--smaller ">
      <div>

        <div class="hero-slider">
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center" style="font-size: 5rem">Professionalism</h2>
                <p class="t-center">All students have free unlimited bus fare.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center" style="font-size: 5rem">Integrity</h2>
                <p class="t-center">Our dentistry program recommends eating apples.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
          <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg') ?>);">
            <div class="hero-slider__interior container">
              <div class="hero-slider__overlay">
                <h2 class="headline headline--medium t-center" style="font-size: 5rem">Diligence</h2>
                <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>

    </div>
  </div>

   
  <div id="features" class="generic-content-container page-section page-section__blue">
  	<div class="wrapper">
  		
      <h2 class="section-title"><span class="icon icon--star section-title__icon" >
      </span ><span style="font-size: 6rem !important; color: white !important">Our <strong>Features</strong></span></h2>
  	  <div class="row row__gutters-large generic-content-container">
         <div class="row__medium-6">
            <div class="feature-item">
              <span class="icon icon--HomeEvalue feature-item__icon"></span>
              <h3 class="feature-item__title" style="font-size: 3.5rem; color: white">Free Home Evaluation</h3>
              <p style="font-size: 1.8rem !important; color: white !important">Are you curious about what your home is worth in today&rsquo;s market? Maybe you are thinking about moving or selling and would like a precise evaluation to help with your decision? Perhaps you are ready to meet a Realtor&reg; and start the process? No matter where you are on the home selling journey, I have a free and no-obligation home evaluation to suit your needs. Home values are on the rise again! The correct pricing of your property is the very first key step to your final success.</p>
            </div>
            
            <div class="feature-item">
              
              <span class="icon icon--sold feature-item__icon"></span>
              <h3 class="feature-item__title" style="font-size: 3.5rem; color: white">Competitive Marketing Plan</h3>
              <p style="font-size: 1.8rem !important; color: white !important">With our established competitive marketing plan, we have helped our clients to sell their homes fast and with top dollars. We work hard for our clients and we use our professional knowledge to help our clients for the best results.</p>
            </div>
            

         </div>

         <div class="row__medium-6">
            <div class="feature-item">
              <span class="icon icon--HomeSearch feature-item__icon"></span>
              <h3 class="feature-item__title" style="font-size: 3.5rem; color: white">Powerful Home Search</h3>
              <p style="font-size: 1.8rem !important; color: white !important">Search Surrey listings using our quick, easy to use listing search engine. Search active listings, register for listing access before public has access. Or Register for access to all the
                      features this site offers. Save your favorite Searches for auto email updates!</p>
            </div>
            
            <div class="feature-item">
              
              <span class="icon icon--Prize feature-item__icon"></span>
              <h3 class="feature-item__title" style="font-size: 3.5rem; color: white">Strategic Offer Negotiation</h3>
              <p style="font-size: 1.8rem !important; color: white !important">With rare exception, negotiating the transaction is the most complex part of selling a home. At the same time, it&rsquo;s the one that can involve the most creativity. That&rsquo;s why it&rsquo;s important to have an experienced and savvy REALTOR&reg; who has successfully worked through many different transaction scenarios.</p>

            </div>
            
         </div>

      </div>
   	</div>
  </div>

  

  <div id="testimonials" class="page-section page-section__no-b-padding-until-large page-section__testimonials lazyload">
    <div class="wrapper wrapper__no-padding-until-large">
      <h2 class="section-title section-title__blue"><span class="icon icon--comment section-title__icon"></span>
      <span style="font-size: 5rem !important;"> Real<strong>Testimonials</strong></span></h2>

      <div class="row row__gutters row__equal-height-at-large row__gutters-small row__t-padding generic-content-container">
        <div class="row__large-4">
          <div class="testimonial">
            <div class="testimonial__photo">
              <img class="lazyload" data-src="<?php echo get_theme_file_uri("assets/images/testimonial-jane.jpg") ?>">
            </div>
            <h3 class="testimonial__title" style="font-size: 2rem !important;">Lisa Yin</h3>
            <h4 class="testimonial__subtitle" style="font-size: 1.5rem !important; padding-bottom: 10px !important">City Hall Official</h4>
            <p style="font-size: 1.8rem !important; color: #2f5572 !important; padding-bottom: 10px !important">&ldquo;Peter listened closely to my needs, developed a plan specific to my home, and then implemented the plan.  It required that we invest in certain improvements and that we follow the recommendations but it was all worth it. After seven days on the market Peter presented three offers at and above the asking price. &rdquo;</p>
          </div>
        </div>
        <div class="row__large-4">
          <div class="testimonial">
            <div class="testimonial__photo">
              <img class="lazyload" data-src="<?php echo get_theme_file_uri("assets/images/testimonial-john.jpg") ?>">
            </div>
            <h3 class="testimonial__title" style="font-size: 2rem !important;">Cooper Williams</h3>
            <h4 class="testimonial__subtitle" style="font-size: 1.5rem !important; padding-bottom: 10px !important">Engineer</h4>
            <p style="font-size: 1.8rem !important; color: #2f5572 !important; padding-bottom: 10px !important">&ldquo;If you are looking for a real estate agent Peter Qu is the man for you. He sold my house in four days getting more than we asked. He is extremely professional, personable, and detailed oriented. He staged my home to sell using a dynamic team consisting of not just him but a professional stager and photographer as well. His sales results speak for himself. You won't be disappointed.&rdquo;</p>
          </div>
        </div>
        <div class="row__large-4">
          <div class="testimonial testimonial__last">
            <div class="testimonial__photo">
              <img class="lazyload" data-src="<?php echo get_theme_file_uri("assets/images/testimonial-cat.jpg") ?>">
            </div>
            <h3 class="testimonial__title" style="font-size: 2rem !important;">Brandon Chen</h3>
            <h4 class="testimonial__subtitle" style="font-size: 1.5rem !important; padding-bottom: 10px !important">Lawyer</h4>
            <p style="font-size: 1.8rem !important; color: #2f5572 !important; padding-bottom: 10px !important">&ldquo;I had a wonderful experience purchasing my new home in Fleetwood. Peter was so attentive to my needs, very patient and always available when I had a question.  I would definitely recommend Peter to anyone in the future, looking to buy a home.&rdquo;</p>
          </div>
        </div>
        
      </div>
   
    </div>
  </div>

  <footer class="site-footer">
    <div class="wrapper">
       <p>
         <span class="site-footer__text">Copyright &copy; 2017 pidrealty.ca - Peter Qu Surrey Realtor. All rights reserved.</span>
         <a href="#" class="btn btn--orange open-modal">Get in Touch</a>
         <a href="#" class="btn btn--image"><img src="<?php echo get_theme_file_uri("assets/images/magsen-logo-130X45.jpg") ?>" 
                            alt="Magsen Realty"></a>
         <a href="#" class="btn btn--image"><img src="<?php echo get_theme_file_uri("assets/images/ghmba.jpg") ?>" 
                            alt="Guanghua School of Management"></a>
         
       </p>
    </div>
   
  </footer>

  <div class="modal">
      <div class="modal__inner">
          <h2 class="section-title section-title__blue section-title--less-margin"><span class="icon icon--mail section-title__icon"></span>Get in <strong>Touch</strong></h2>
          <div class="wrapper wrapper--narrow">
            <p class="modal__description">We will have an online order system in place soon ndndn fndnd fndndn fndndn. </p>
            <div class="social-icons">
              <a href="#" class="social-icons__icon"><span class="icon--facebook icon"></span></a>
              <a href="#" class="social-icons__icon"><span class="icon--twitter icon"></span></a>
              <a href="#" class="social-icons__icon"><span class="icon--instagram icon"></span></a>
              <a href="#" class="social-icons__icon"><span class="icon--youtube icon"></span></a>
            </div>
          </div>
      <div class="modal__close">X</div>
    </div>
  </div>

 
  
  <!-- build:js assets/scripts/App.js -->
  <script src="<?php echo get_theme_file_uri("/temp/scripts/app.js") ?>"></script>
  <!-- endbuild -->
  <?php get_footer(); ?>
</body>
</html>