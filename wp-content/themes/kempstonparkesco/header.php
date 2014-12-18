<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Kempston Parkes</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/layout.css" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/fancybox/jquery.fancybox.css" />

        <script src="<?php echo get_template_directory_uri(); ?>/js/modernizr.js"></script>
<!--[if (gte IE 6)&(lte IE 8)]>
<script src="<?php echo get_template_directory_uri(); ?>/js/selectivizr-min.js"></script>
<![endif]-->
        <!--[if lte IE 9]>
          <script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
        <![endif]-->
        
	

	<?php wp_head(); ?>
</head>

<body<?php if(is_front_page()):?> id="front-page"<?php endif ?>>
    <a id="top" style="">Top</a>
 <!-- Nav -->
      <nav id="nav"><div class="container"><a id="mobile-menu">Menu</a>
     
           <?php 
            $menu_detsils = wp_get_nav_menus('Main Menu');  // Menu 1 is defined in menu manager

            $menuTermId = $menu_detsils[0]->term_id;

            $menu_items = wp_get_nav_menu_items($menuTermId);

            ?>    
            
              
        <ul>
            <?php foreach ($menu_items as $menu_item) { 
                    $menuTitle = $menu_item->title;
                    $menuUrl = $menu_item->url;
                    $menuId = $menu_item->ID;
                    $menuClasses = $menu_item->classes;
                   
                    $menuFirstClass = $menuClasses[0];
                    $menuSecoundClass = $menuClasses[1];
                    $pageId = $menu_item->object_id; 
                ?>
            <li class="<?php echo $menuFirstClass; ?>"><a class="<?php echo $menuSecoundClass; ?>" href="<?php echo $menuUrl;?>"><?php echo $menuTitle;?></a></li>
           
                <?php } ?>
  
      
        </ul>
              
               
           
              
           
              
              
          </div></nav>
 

      <!-- /Nav -->
      
   
      
      
        <!-- Header -->
<header id="header">
<div class="container">
    <?php if(is_front_page()): ?>
<h1 id="home-link">Kempston Parkes Chartered Surveyors</h1>
<?php else: ?>
<a id="home-link" href="<?php echo home_url(); ?>">Kempston Parkes Chartered Surveyors</a>
    <?php endif ?>
<h2><?php echo get_field('strap_line',49)?></h2>
</div>
</header>
<!-- /Header -->