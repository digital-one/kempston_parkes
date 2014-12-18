<?php
/**
 * Template Name: Our services page
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */

?>
<div>
<section id="our-services" class="section">

    <div class="container">
        <a class="anchor" href="#top">Top</a>
<aside>
   <h2><?php the_title();?></h2>
</aside>
<main class="main" role="main">
    <div class="alpha"><?php echo get_field('section_one',8);?></div>
<div class="beta"><?php echo get_field('section_two',8);?></div>
<div class="gamma">
<dl class="accordion">
  <?php  
  $counter=1;
    if (have_rows('accordion_content')):
    while (have_rows('accordion_content')) : the_row();
    if($counter==1){
    $class="active";
    
     }
 
 ?>
        <dt<?php if($counter==1){?> class="<?php echo $class; ?>" <?php } ?>>
    <span class="label"><em><?php echo $counter; ?></em><?php echo get_sub_field('title');?></span>
    <span class="link"><em>VIEW</em></span></dt>
    <dd <?php if($counter!=1){ ?>style="display:none;" <?php } ?>>
       <?php echo get_sub_field('content');?>
    </dd>
       
    <?php
       $counter++; endwhile;
    endif;
    
    ?>
    
   
</dl>
<h3>OUR COSTS</h3>
<?php echo get_field('currently_our_costs',8);?>
    </div>
</main>
</dov>
</section>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<!-- Load jQuery from a local copy if loading from Google fails -->
<script>window.jQuery || document.write('<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.10.1.min.js"><\/script>')</script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<!-- Load jQuery UI from a local copy if loading from Google fails -->
<script>window.jQuery || document.write('<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui.min.js"><\/script>')</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.easing.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/fancybox/jquery.fancybox.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.selectbox.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>
<!--/scripts-->

