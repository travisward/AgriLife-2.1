<?php
/**
 * @package WordPress
 * @subpackage Agrilife
 */
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
<div id="content">
	<div id="sidecontent">
    <?php if ( function_exists( "yoast_breadcrumb" ) ) yoast_breadcrumb('', ''); ?>
    
<div id="main_content"> 

<?php if (have_posts()) : $count = 0; ?>
            <?php while (have_posts()) : the_post(); $count++; ?>
                                                                        
                <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
                    
   
                   
                    <div class="storycontent">
	                	<?php the_content(); ?>
	               	</div><!-- /.storycontent -->
	             </div>
	         <?php endwhile; endif;?>

<h2>Archives by Month:</h2>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

<h2>Archives by Subject:</h2>
	<ul>
		 <?php wp_list_categories(); ?>
	</ul>


</div><!-- #main_content -->
			</div><!-- #sidecontent -->
			<?php get_sidebar(); ?>
			<div class="clear"></div>	
		</div><!-- #content -->
	</div><!-- #main-box -->
	<div id="main-box-bottom"></div>
</div><!-- #main -->

<?php get_footer(); ?>

