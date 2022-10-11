<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="apple-touch-fullscreen" content="yes" />

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width,height=device-height">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  
  <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>



  <?php 
    $v = '?v=1.0.0'.time();   

    if(!is_single()) {


          $meta_desc = get_option( 'blogdescription', '' );
          $meta_keywords = get_option( 'meta_keywords', '' );

          if($meta_desc!=''){
            ?>
              <meta property="og:description" content="<?php echo $meta_desc; ?>" />
              <meta name="description" content="<?php echo $meta_desc; ?>">
            <?php
          }

          if($meta_keywords!=''){
            ?>
              <meta name="keywords" content="<?php echo $meta_keywords; ?>">
            <?php
          }
          ?> 
  
  
            <meta property="fb:app_id" content="1932782073646462" />
            <meta property="og:type" content="website" /> 
            <meta property="og:title" content="<?php bloginfo('name'); ?><?php wp_title(); ?>" /> 
  
      <?php 
          set_meta_image(); 
    }//END IF IS SINGLE
  ?>




  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

  <?php wp_head(); ?>
  


  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/favicon/57x57.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/favicon/60x60.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/favicon/72x72.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/favicon/76x76.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/favicon/114x114.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/favicon/120x120.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/favicon/144x144.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/favicon/152x152.png<?php echo $v; ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/favicon/180x180.png<?php echo $v; ?>">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/favicon/196x196.png<?php echo $v; ?>">
  
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/favicon/16x16.png?v=1.2">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/favicon/32x32.png<?php echo $v; ?>">
  
  
  
  <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/favicon/manifest.json<?php echo $v; ?>">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/favicon/32x32.png<?php echo $v; ?>">
  <meta name="theme-color" content="#ffffff">




</head>
<?php 
  global $post;
  $qobj = get_queried_object();
  $lang=get_bloginfo("language");
  //print_r($qobj);
  //echo $qobj->taxonomy;
  ?>
<body id="<?php echo 'body-'.$post->post_name; ?>" class="body page-index clearfix <?php if (is_front_page() || is_page('tentang-kami') || is_post_type_archive( 'produk' ) 
              || (!empty($qobj)  && $qobj->taxonomy=='produk_cat') ) echo 'state-menu-transparent' ;?>"   oncopy="return false" oncut="return false" onpaste="return false">

<div id="mobilenav" class="mobilenav hide">
  <div class="middle-mv">
    <div class="center">
      <?php 
        wp_nav_menu( 
              array(
                  'menu' => 'Menu '.$lang,
                  'menu_class'=>'menu fright clearfix',
                  'link_before'     => '<span>',
                  'link_after'      => '</span>',
                  'container' => false
              ) 
          );
      ?>
    </div>  
  </div>  
</div>


<!-- Header Start -->    
<div id="header" class="header no-language">
  <div class="middle clearfix">
    <a href="<?php echo get_site_url(); ?>">
      <img class="logo-header fleft" src="<?php echo get_template_directory_uri().'/images/logo.png' ?>">  
    </a>
    
    <div class="header-right fright clearfix">
      <div class="menu-mobile fright hide">
        <a href="javascript:void(0)" class="icon">
          <div class="hamburger">
            <div class="menui top-menu"></div>
            <div class="menui mid-menu"></div>
            <div class="menui bottom-menu"></div>
          </div>
        </a>
      </div>
      <div class="lang-select fright">
        <?php pll_the_languages(array('dropdown'=>1,'display_names_as'=>'slug')); ?>
      </div>
      <?php 
        
        wp_nav_menu( 
            array(
                'menu' => 'Menu '.$lang,
                'menu_class'=>'menu fright clearfix',
                'link_before'     => '<span>',
                'link_after'      => '</span>',
                'container' => false
            ) 
        );
      ?>
    </div>
  </div>
</div>
<!-- Header End -->