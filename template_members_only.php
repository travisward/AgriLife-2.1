<?php
/**
 * @package WordPress
 * @subpackage Agrilife_Theme
 */
 /*
Template Name: Private: Must Be Logged In
*/
get_header();
?>
<div id="content">
	<div id="sidecontent">
    <?php if ( function_exists( "yoast_breadcrumb" ) ) yoast_breadcrumb('', ''); ?>
    
<div id="main_content"> 

<?php if (is_user_logged_in()) { ?>
		       
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
		  <h2><?php the_title(); ?></h2>
		  <div class="storycontent">
		    <?php the_content(__('(more...)')); ?>
		  </div>
		</div>
		<?php mail('travisward@gmail.com', 'members only template use!', 'used on '.get_permalink($post->ID));?>
	<?php endwhile; endif; ?>     
	                   
<?php } else { ?>
		<div class="post"><div class="entry">You must <a href="<?php echo wp_login_url(); ?>" title="login">login</a> to view this page.</div></div>
<?php } ?>

				</div><!-- #main_content -->
			</div><!-- #sidecontent -->
			<?php get_sidebar(); ?>
			<div class="clear"></div>	
		</div><!-- #content -->
	</div><!-- #main-box -->
	<div id="main-box-bottom"></div>
</div><!-- #main -->

<?php get_footer(); ?>
