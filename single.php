<?php
/**
 * @package WordPress
 * @subpackage Agrilife
 */
get_header();
?>
<div id="content">
	<div id="sidecontent">
    <?php if ( function_exists( "yoast_breadcrumb" ) ) yoast_breadcrumb('', ''); ?>
    
<div id="main_content"> 

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
    
    <div class="post-meta left-col">
		<div class="date-tab-t"></div>
		<div class="date-tab">
		<h3 class="thedate">
			<span class="day"><?php the_time('d');?></span>
			<span class="month"><?php the_time('M'); ?>
				<span class="year"><?php the_time('Y'); ?></span>
			</span>
		</h3>
		<h4 class="author"><?php the_author() ?></h4>
		<?php /* 
		<h4 class="comments"><?php comments_popup_link(__(''), __('1'), __('%')); ?></h4>
		*/ ?>
		</div>
		<div class="date-tab-b"></div>
	</div>
	
	<div class="post-content right-col">
		<h2 class="storytitle"><?php the_title(); ?></h2>
		<!-- <h2 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>-->
		<div class="storycontent">
			<div class="entry">
	            <?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
	    
	            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	            <?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
	            
	            <p>Categories: <?php the_category(', ') ?></p>
	        </div><!-- .entry -->
	        
	        <?php comments_template(); ?>
		</div>
	</div>
	

</div>
       
    

<?php endwhile; else: ?>

	<p>Sorry, no posts matched your criteria.</p>

<?php endif; ?>

				</div><!-- #main_content -->
			</div><!-- #sidecontent -->
			<?php get_sidebar(); ?>
			<div class="clear"></div>	
		</div><!-- #content -->
	</div><!-- #main-box -->
	<div id="main-box-bottom"></div>
</div><!-- #main -->

<?php get_footer(); ?>