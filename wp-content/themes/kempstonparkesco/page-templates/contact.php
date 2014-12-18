<?php
/**
 * Template Name: Contact Us page
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */

?>
<div>
<section id="contact" class="section">

<div class="container">
		<a class="anchor" href="#top">Top</a>
<aside><h2><?php the_title();?></h2></aside>
<main class="main" role="main">
<div class="alpha"><?php echo get_field('address_and_telephone',12);?></div>
<?php $src = get_field('upload_map_field',$post->ID) ?>
<div class="beta"><img src="<?php echo $src ?>" /></div>
</main>
</div>
    </section>
    </div>
