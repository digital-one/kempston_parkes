<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */


get_header();
?>

    <?php
            if (have_posts()):
                while (have_posts()) : the_post();
                    ?>
<section id="about-us">

<div class="container">
<aside>
<h2><?php the_title();?></h2>
</aside>
<main class="main" role="main">

      <?php  the_content(); ?>
    </main>
</div>

</section>
              <?php
             

                endwhile;
            endif;
            ?>
  
<?php get_footer();




