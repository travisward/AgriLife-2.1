<?php
/**
 * @package WordPress
 * @subpackage Agrilife
 */
/*
Template Name: Slideshow
*/
get_header();
?>
<div id="content">
	<div id="sidecontent">
    <?php if ( function_exists( "yoast_breadcrumb" ) ) yoast_breadcrumb('', ''); ?>
    
<div id="main_content"> 

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
			<?php if ( !is_front_page() ) : ?>
		  	  <h2><?php the_title(); ?></h2>
		    <?php endif; ?>
<?php
	$youTube = get_post_meta($post->ID, "youtube", true);
	//Check for well-formed playlist url
	
	if(stristr($youTube,'http://www.youtube.com/view_play_list?p=')){
		$youTube = 'http://gdata.youtube.com/feeds/api/playlists/'.substr($youTube,40);
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
    										
    
    	<?php if (count($attachments) > 0): ?>
        	<div class="clear"></div>
            <div id="features">
              <?php if($youTube!=''): ?>
              <ul class="tabs" id="featuresnav">
              	<li><a class="active" href="#points-of-pride" id="points-of-prive-nav"><img alt="pix" src="<?php bloginfo('template_directory'); ?>/images/tab-slideshow.gif?v=100" /></a></li>
              	<li><a href="#video-vault" id="video-vault-nav"><img alt="YouTube Videos" src="<?php bloginfo('template_directory'); ?>/images/tab-youtube.gif?v=100" /></a></li>         
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
                  <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/swfobject.js"></script>
                  <div id="player">You will need <a href="http://www.google.com/url?sa=t&source=web&cd=1&ved=0CBsQFjAA&url=http%3A%2F%2Fget.adobe.com%2Fflashplayer%2F&ei=XwhOTPqRHcmenwfTm6zZCw&usg=AFQjCNFV-EC-o0osKJm2dFwEBoUMPY6T2g&sig2=p-YajqU82tbiFG3tiaNnZQ">Adobe's Flash player</a> to view this content.</div>
                  <script type="text/javascript">
				  var so = new SWFObject('<?php bloginfo('template_directory'); ?>/media/player.swf','mpl','585','305','9');
				  so.addParam('allowscriptaccess','always');
				  so.addParam('allowfullscreen','true');
				  so.addVariable('file','<?php echo $youTube; ?>');
				  so.addVariable('skin','<?php bloginfo('template_directory'); ?>/media/modieus.swf');
				  so.addVariable('playlist','over');
				  so.addVariable('frontcolor','#cfceb9');
				  so.write('player');
				  </script>
              	</div> <!-- .tab -->
              <?php endif; ?>
            </div><!-- #features-->		
        	<div class="clear"></div>
        <?php endif; ?>
        
        
        	<?php the_content(__('(more...)')); ?>
        </div>
        <?php  endwhile; else: ?>
            <!-- <p><?php _e('Sorry, no posts matched your criteria.'); ?></p> -->
        <?php endif; ?>
        		
         
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
