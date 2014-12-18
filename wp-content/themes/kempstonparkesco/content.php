<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php kempstonparkesco_post_thumbnail(); ?>

	<header class="entry-header">
		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && kempstonparkesco_categorized_blog() ) : ?>
		<div class="entry-meta">
			<span class="cat-links"><?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'kempstonparkesco' ) ); ?></span>
		</div>
		<?php
			endif;

			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h2>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
		?>
<?php
			if ( 'post' == get_post_type() )
					kempstonparkesco_posted_on();
				?>
	</header><!-- .entry-header -->

	<?php if(!is_single()): ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>
<?php else: ?>
	<div class="entry-article">
<?php the_content(); ?>
	</div>
<?php endif ?>
<footer>
<div class="entry-meta">
	<span class="back-link"><a href="<?php echo get_permalink(95)?>">Back to posts</a></span>
			<?php
			

				if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
			?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'kempstonparkesco' ), __( '1 Comment', 'kempstonparkesco' ), __( '% Comments', 'kempstonparkesco' ) ); ?></span>
			<?php
				endif;

				edit_post_link( __( 'Edit', 'kempstonparkesco' ), '<span class="edit-link"> | ', '</span>' );
			?>
		</div><!-- .entry-meta -->
</footer>
	<?php the_tags( '<footer class="entry-meta"><span class="tag-links">', '', '</span></footer>' ); ?>
</article><!-- #post-## -->
