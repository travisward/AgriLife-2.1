<?php
/**
 * @package WordPress
 * @subpackage Agrilife_Theme
 */
 /*
Template Name: Full Width
*/
get_header();
?>
<div id="content">
	<div id="sidecontent" class="fullwidth">
    <?php if ( function_exists( "yoast_breadcrumb" ) ) yoast_breadcrumb('', ''); ?>
    
<div id="main_content"> 

<?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                    
                    <?php if ( !is_front_page() ) : ?>
				  	  <h2><?php the_title(); ?></h2>
				    <?php endif; ?>
                   
                    <div class="storycontent">
	                	<?php the_content(); ?>
	               	</div><!-- /.storycontent -->
	               	
                </div><!-- /.post -->
                
                <?php if ('open' == $post->comment_status) : ?>
	                <?php comments_template(); ?>
				<?php endif; ?>
                                                    
			<?php endwhile; else: ?>
				<div class="post">
                	<p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
                </div><!-- /.post -->
            <?php endif; ?>  

				</div><!-- #main_content -->
			</div><!-- #sidecontent -->
			
			<div class="clear"></div>	
		</div><!-- #content -->
	</div><!-- #main-box -->
	<div id="main-box-bottom"></div>
</div><!-- #main -->

<?php get_footer(); ?>
