<?php get_header();?>
<section id="home">

    <div class="container">
<aside>
<?php echo get_field('text',38);?>
</aside>
<div class="alpha">
<img src="<?php echo get_template_directory_uri(); ?>/images/andrew-kempston-parkes.png" alt="Andrew Kempston Parkes" />
</div>
</div>
</section>
<div id="page">
	<?php
	$page = get_page(2);
?>
	<!-- about us -->
<section id="about-us">

<div class="container">
<aside>
<h2><?php echo $page->post_title ?></h2>
</aside>
<main class="main" role="main">
<div class="alpha"><?php echo get_field('section_one',2);?></div>
<div class="beta"><?php echo get_field('section_two',2);?></div>
<div class="gamma"><?php echo get_field('section_three',2);?></div> 
    </main>
</div>

</section>
<!-- /about us -->



</div>

<?php get_footer();

