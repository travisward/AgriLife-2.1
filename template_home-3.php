<?php
/**
 * @package WordPress
 * @subpackage Agrilife
 */
/*
Template Name: Home
*/
get_header();
?>
<div id="content">
	<div id="sidecontent">
	
	<?php if ( function_exists("yoast_breadcrumb") && !is_front_page() ) yoast_breadcrumb('', ''); ?>
	<div id="main_content"> 

<?php
	$youTube = get_post_meta($post->ID, "youtube", true);
	//Check for well-formed playlist url
	
	if(stristr($youTube,'http://www.youtube.com/view_play_list?p=')){
		$youTube = 'http://gdata.youtube.com/feeds/api/playlists/'.substr($youTube,40);
	} elseif(stristr($youTube,'http://www.youtube.com/playlist?p=PL')){
		$youTube = 'http://gdata.youtube.com/feeds/api/playlists/'.substr($youTube,36);
	} elseif(stristr($youTube,'http://gdata.youtube.com/feeds/api/playlists/')) {
		$youTube = $youTube;
	} else {
		$youTube = '';
	}
 ?>

<!--
<?php
$args = array(
	'post_type' => 'attachment',
	'numberposts' => -1,
	'post_status' => null,
	'post_parent' => $post->ID
	); 
$attachments = get_posts($args);
?>
-->
<div>
    <div class="clear"></div>										
    <div>
    	<?php if (count($attachments) > 0): ?>
        <div>
            <div id="features">
              <?php if($youTube!=''): ?>
              <ul class="tabs" id="featuresnav">
              	<li><a class="active" href="#points-of-pride" id="points-of-prive-nav"><img alt="pix" src="<?php echo THEME_TEMPLATEURL;?>/images/tab-slideshow.gif?v=100" /></a></li>
              	<li><a href="#video-vault" id="video-vault-nav"><img alt="YouTube Videos" src="<?php echo THEME_TEMPLATEURL;?>/images/tab-youtube.gif?v=100" /></a></li>         
              </ul>
              <?php endif; ?>
              <div class="tab active" id="points-of-pride">
				<?php echo do_shortcode('[gallery_home]'); ?>
                <?php if (count($attachments) > 1): ?>
                  <div class="pics-nav">
                    <div id="prev">Previous</div>
                    <div id="next">Next</div>
                  </div>
                <?php endif; ?>
              </div>
              
              <?php if($youTube!=''): ?>
              	<div class="tab" id="video-vault">
                  <script type="text/javascript" src="<?php echo THEME_TEMPLATEURL;?>/scripts/swfobject.js"></script>
                  <div id="player">This text will be replaced</div>
                  <script type="text/javascript">
				  var so = new SWFObject('<?php echo THEME_TEMPLATEURL;?>/media/player.swf','mpl','585','305','9');
				  so.addParam('allowscriptaccess','always');
				  so.addParam('allowfullscreen','true');
				  so.addVariable('file','<?php echo $youTube; ?>');
				  so.addVariable('skin','<?php echo THEME_TEMPLATEURL;?>/media/modieus.swf');
				  so.addVariable('playlist','over');
				  so.addVariable('frontcolor','#cfceb9');
				  so.write('player');
				  </script>
              	</div> <!-- .tab -->
              <?php endif; ?>
            </div><!-- #features-->		
        </div>
        <?php endif; ?>
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<!-- <h4 class="front-headline"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h4>-->
        	<p class="front-summary"><?php the_content(__('(more...)')); ?></p>
        </div>
        <?php  endwhile; else: ?>
            <!-- <p><?php _e('Sorry, no posts matched your criteria.'); ?></p> -->
        <?php endif; ?>
        
        <div id="frontcolumns">
        	<div class="leftcolumn">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('homepage_col_1') ) : ?>
                <div>
                    <h3 class="front-header">Column 1</h3>	
                    <ul class="front-list">
                        <li><a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php">Add a Widget</a></li>
                        <li><a href="http://www.youtube.com/watch?v=geWLGoAw53o">Video About Widgets</a></li>
                        <li><a href="http://automattic.com/code/widgets/">Read More on Widgets</a></li>
                    </ul>			
                </div>
            <?php endif; // col1 ?>
            </div>
            
            <div class="middlecolumn">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('homepage_col_2') ) : ?>
                <div>
                    <h3 class="front-header">Column 2</h3>
                    <ul class="front-list">
                        <li><a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php">Add a Widget</a></li>
                        <li><a href="http://www.youtube.com/watch?v=geWLGoAw53o">Video About Widgets</a></li>
                        <li><a href="http://automattic.com/code/widgets/">Read More on Widgets</a></li>
                    </ul>		
                </div>
            <?php endif; // col2 ?>
            </div>
            
            <div class="rightcolumn">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('homepage_col_3') ) : ?>
                <div>
                    <h3 class="front-header">Column 3</h3>
                    <ul class="front-list">
                        <li><a href="<?php bloginfo('url'); ?>/wp-admin/widgets.php">Add a Widget</a></li>
                        <li><a href="http://www.youtube.com/watch?v=geWLGoAw53o">Video About Widgets</a></li>
                        <li><a href="http://automattic.com/code/widgets/">Read More on Widgets</a></li>
                    </ul>				
                </div>
            <?php endif; // col3 ?>
            </div>
            <div class="clear"></div>
        </div><!-- #frontcolumns -->
        
        
        		
        </div>  
    </div>
	
	
	








				</div><!-- #main_content -->
			</div><!-- #sidecontent -->
			<?php get_sidebar(); ?>
			<div class="clear"></div>	
		</div><!-- #content -->
	</div><!-- #main-box -->
	<div id="main-box-bottom"></div>
</div><!-- #main -->

<?php get_footer(); ?>
