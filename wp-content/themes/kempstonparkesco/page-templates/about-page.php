<?php
/**
 * Template Name: About Us page
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */
get_header();
?>
<div>
<section id="about-us" class="section">

<div class="container">
	<a class="anchor" href="#top">Top</a>
<aside>
<h2><?php the_title();?></h2>
</aside>
<main class="main" role="main">
<div class="alpha"><?php echo get_field('section_one');?></div>
<div class="beta"><?php echo get_field('section_one');?></div>
<div class="gamma"><?php echo get_field('section_three');?></div>
    </main>
</div>

</section>
    </div>
<?php get_footer();