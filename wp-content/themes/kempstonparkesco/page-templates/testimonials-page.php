<?php
/**
 * Template Name: Testimonials page
 *
 * @package WordPress
 * @subpackage Kempstonparkesco_Theme
 * @since Kempstonparkesco 1.0
 */
?>
<div>
    <section id="testimonials" class="section">
    	
        <div class="container">
        	<a class="anchor" href="#top">Top</a>
            <aside><h2><?php the_title(); ?></h2></aside>
            <main class="main" role="main">

                <?php 	

	global $wpdb, $post;
    $blog_per_page = 3;
    $total_blogs = $published_posts = wp_count_posts('post_testimonials')->publish;
    $bolgpost = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post_testimonials' ORDER BY post_title  ASC LIMIT 0," . $blog_per_page . "");

    $max = sizeof($bolgpost);
	
    $custom_post_query = new WP_Query(array('post__in' => $bolgpost, 'post_type' => 'post_testimonials','post_status' => 'publish','posts_per_page' => -1));
    $more_count = 0;



	 
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
			wp_reset_query();
		?>
        
       <div id="secondary_blog<?php echo  $more_count;?>"></div>
       <?php if ($total_blogs != $more_count) { ?>
     	<footer class="testimonials-footer" id="testimonials-footer">
        <div id="more_blog<?php echo  $more_count;?>" class="morebox_blog" style="display:<?php if($max>0){echo "block";} else{echo "none";}?>">
        <a href="javascript:void(0);" class="button" id="<?php echo  $more_count;?>">View more testimonials</a>
        
        </div>
      	</footer>  
       
    <?php } ?>
	</div>
<script>
jQuery(document).ready(function(){
//More Button
	jQuery('body').on('click', '.button', function() {
			var ID = jQuery(this).attr("id");
			if(ID)
				{
					//jQuery("#more_blog"+ID).html('<span class="loader"><img src="<?php bloginfo('template_url');?>/images/more-ajax-loader.gif"/></span>');

					jQuery.ajax({
					type: "POST",
					url: "<?php bloginfo('template_url');?>/ajax_more.php",
					data: "lastmsg="+ ID, 
					cache: false,
                                        
                                        
                                        beforeSend: function () {

                                            jQuery(".button").addClass('loading');
                                        },
                                        
                                        
                                        
					success: function(html){
					//alert(html);
                                        jQuery(".button").removeClass('loading');
					jQuery("div#secondary_blog"+ID).append(html);
					jQuery("#more_blog"+ID).remove();
				}
			});
		}
	return false;
	});
});
</script>

      
                
                
               
        </div>
</div>
</section>
</div>
<?php 