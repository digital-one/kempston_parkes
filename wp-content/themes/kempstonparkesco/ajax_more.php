<?php include '../../../wp-load.php'; ?>
<?php
if (isSet($_POST['lastmsg'])) {
    global $wpdb;
    $lastmsg = $_POST['lastmsg'];
    $total_blogs = $published_posts = wp_count_posts('post_testimonials')->publish;
	$more_count = $lastmsg;
    $blog_per_page = 3;
    $blogpost = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post_testimonials' ORDER BY post_title ASC LIMIT " . $lastmsg . "," . $blog_per_page . "");

	$max = sizeof($blogpost);
    if ($max > 0) {
        $custom_post_query = new WP_Query(array('post__in' => $blogpost, 'post_type' => 'post_testimonials','orderby'=> 'title','order'=>'ASC','post_status' => 'publish','posts_per_page' => -1));
      if ($custom_post_query->have_posts()) : while ($custom_post_query->have_posts()) : $custom_post_query->the_post();
						 ?>
						
					
			 <blockquote>
                            <?php the_content(); ?>
                            <footer>
                                <span><?php the_title(); ?></span>,<?php echo get_field('author_designation', $post->ID) ?>
                            </footer>
                        </blockquote>   	
              
     	<?php 
        $more_count++;
        endwhile;
			else :
				echo wpautop('Sorry, no result were found');
			endif;
			
			wp_reset_postdata();
			wp_reset_query(); } ?>

    <div class="clear"></div>
    <div id="secondary_blog<?php echo $more_count; ?>"></div>
    <footer class="testimonials-footer" id="testimonials-footer">
    <?php if ($total_blogs != $more_count) { ?>
            <div id="more_blog<?php echo $more_count; ?>" class="morebox_blog">
                <a href="javascript:void(0);" class="button" id="<?php echo $more_count; ?>">View more testimonials<span class="loader"></span></a>
                <a href="" class="loading" style="display:none;"></a>
            </div>
        <?php }  ?>
    </footer> 

 <?php

}
?>
