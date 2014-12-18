<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */
?>
<!--Footer-->
<footer id="footer">
    <div class="container">
        <a class="anchor" href="#top">Top</a>
        &copy; Kempston-Parkes <?php echo date('Y') ?>
       <!-- <nav id="footer-nav"><a href="">Terms &amp; Conditions</a> / <a href="">Privacy</a></nav>-->
        <nav id="footer-nav">
            <?php
            //$foot_nav = wp_nav_menu(array('container' => '', 'link_after' => ' ', 'before' => ' / ', 'echo' => '0', 'menu' => 'footer menu'));
            //$foot_nav2 = preg_replace(array('#^<ul[^>]*>#', '#</ul>$#'), '', $foot_nav);
           // $foot_nav2 = preg_replace(array('#<li[^>]*>#', '#</li>$#'), '', $foot_nav2);
             // $foot_nav2 = ltrim($foot_nav2, " /");
         
           // echo $foot_nav2;
           // ?>  

        </nav>
    </div>
</footer>
<!--/Footer-->
<!-- Contact Form -->   
<div style="display:none;">
    <!-- Add Gravity Form Shortcode Here and strip out markup below -->
 <div id="inline-form" class="gform_wrapper">
    
<?php echo do_shortcode(' [gravityform id=1  description=false title=false ajax=true tabindex=49]'); ?>
    </div>   
</div>
<!-- /Contact Form -->
<!--scripts-->
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

<?php wp_footer(); ?>
<?php 
$permalinks = array();
    $args = array(
          'post_type' => 'page',
          'orderby' => 'menu_order',
          'order' => 'ASC',
          'posts_per_page' => -1,
          'post_status' => 'publish',
          'exclude' => array(2,38,74,76,49)
          );
    if($pages = get_posts($args)):
        foreach($pages as $page):
$permalinks[] = get_permalink($page->ID);
            endforeach;
            endif;
    ?>
<script>
$(function(){
    var pages = <?php echo json_encode($permalinks) ?>;
    if($('#front-page').length) loadPages(pages);
});
</script>
</body>
</html>