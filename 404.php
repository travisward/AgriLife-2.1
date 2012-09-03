<?php
/**
 * @package WordPress
 * @subpackage Agrilife
 */
get_header();
?>

	<?php	/*
	if (!current_user_can('level_10')) {
		$referral		= $_SERVER['HTTP_REFERER'];
		$not_found		= get_bloginfo('url').$_SERVER['REQUEST_URI'];
		$to				= 'agt@tamu.edu'; //get_option('admin_email');
		$subject		= 'Content Not Found @ ' . get_option('blogname');
		$content		= 'A visitor ';
		if ($_SERVER['HTTP_REFERER'])
			$content	= "that came from: $referral\n";
		$content		.= "landed on this page: $not_found\n\nYou may want to look into this.";
		$headers		= 'From: ' . get_option('admin_email');

		mail($to, $subject, $content, $headers);
	} */ ?>
		<div id="content">
			<div id="sidecontent">
		    <?php if ( function_exists( "yoast_breadcrumb" ) ) yoast_breadcrumb('', ''); ?>
				<div id="main_content">            
					<div id="404-page">
					  <h2>Page Not Found</h2>
					  <div class="storycontent">
					    <p><?php _e( 'Apologies, but the page you requested could not be found.  The page may have been moved by the site owner, which may cause the URL to change.', 'agrilife' ); ?></p>
					    <p>You may be able to find what you are looking by:</p>
					    <ul>
					    	<li>Double-checking spelling and formatting for errors</li>
					    	<li>Visiting the <a href="<?php bloginfo('home'); ?>">Home page</a></li>
					    	<li>Browsing the navigation to the right</li>
					    	<li>Searching the site <?php get_search_form( true ); ?></li>
					    </ul>
					    
					    <script type="text/javascript">
						  var GOOG_FIXURL_LANG = 'en';
						  var GOOG_FIXURL_SITE = '<?php echo bloginfo('url'); ?>'
						</script>
						<script type="text/javascript"
						  src="http://linkhelp.clients.google.com/tbproxy/lh/wm/fixurl.js">
						</script>
						    
					    
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
