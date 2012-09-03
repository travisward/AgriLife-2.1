<?php
/**
 * @package WordPress
 * @subpackage Agrilife
 */

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- CDN Domain Variable
- Thumbnail Support
- Menu Navigation Variables
- Widget Areas
- Set Plugin Defaults
	- $content_width
	- Yoast Breadcrumb Defaults
	- Gravity Form Defaults
	- Vipers Video Tags Defaults [not working]
	- Tiny MCE
- Set Excerpt More...
- Include .js libraries
- Allow additional tags in posts (For MU)
- Custom [shortcodes]
	- [children]
	- [home-gallery]
	- [sm-directory]
	- [loop]

- Admin Menus

- Admin Dashboard Feedburner Stat Widget

- Custom Password Protected Message

-----------------------------------------------------------------------------------*/


/* This brute-force CDN variable did help with Domain Mapped sites.  */
/* Phase out if  DM plugin improves. */
//$CDN = 'http://agrilifecdn.tamu.edu/wp-content/themes/agrilife-2.0';
$CDN = '';
$theme_directory = ($CDN<>'' ? $CDN : get_bloginfo('template_directory'));  
// 'template_directory' = parent theme if using a child
define('THEME_TEMPLATEURL', $theme_directory);

// nonces failing unexpectedly
remove_action('init', '_show_post_preview' , 10);

// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'agrilife' ),
) );

/* Add Thumbnail Support */
if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
	add_theme_support( 'post-thumbnails');	
	set_post_thumbnail_size( 150, 150, true );
}

/*	Widget Areas */
function register_agrilife_sidebars() {
	register_sidebar(array(
		'name' => 'Homepage Col 1',
		'id' => 'homepage_col_1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="front-header">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Homepage Col 2',
		'id' => 'homepage_col_2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="front-header">',
		'after_title' => '</h3>'
	));	
	register_sidebar(array(
		'name' => 'Homepage Col 3',
		'id' => 'homepage_col_3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="front-header">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Replace Sidebar Navigation',
        'id' => 'main-right-sidebar',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
	register_sidebar(array(
		'name' => 'Below Right Sidebar',
        'id' => 'below-right-sidebar',
		'before_widget' => '<div class="widget sidebar-box %2$s" id=" %1$s">',
		'after_widget' => '<div class="banner"></div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));	
	
	
	// hook allows child themes to de-register widget areas
	// In child theme functions.php
	// # function unregister_sidebar() {
	// # 	unregister_sidebar('sidebar-two');
	// # }
	// # add_action( 'childtheme_sidebars', 'unregister_sidebar' );
	do_action('childtheme_sidebars'); 
}
add_action( 'widgets_init', 'register_agrilife_sidebars' );
/*	END - Widget Areas */

/* This will Auto-config some plugins */
/* Example: Slideshare */
global $content_width;
$content_width = 650;

/* BEGIN Config Yoast Breadcrumb Defaults */
$yoast_bc_opt 						= array();
$yoast_bc_opt['home'] 				= "Home";
$yoast_bc_opt['blog'] 				= "Blog";
$yoast_bc_opt['sep'] 				= " &gt; ";
$yoast_bc_opt['prefix']				= "";
$yoast_bc_opt['boldlast'] 			= false;
$yoast_bc_opt['nofollowhome'] 		= false;
$yoast_bc_opt['singleparent'] 		= 0;
$yoast_bc_opt['singlecatprefix']		= true;
$yoast_bc_opt['archiveprefix'] 		= "Archives for";
$yoast_bc_opt['searchprefix'] 		= "Search for";
add_option("yoast_breadcrumbs",$yoast_bc_opt);
/* END Config Yoast Breadcrumb Defaults */

/* BEGIN Set Gravity Form Defaults */
// This will be added in WordPress 3.1
if(!function_exists('wp_dequeue_style')) {
	function wp_dequeue_style( $handle ) {
	    global $wp_styles;
	    if ( !is_a($wp_styles, 'WP_Styles') )
	        $wp_styles = new WP_Styles(); 

	    $wp_styles->dequeue( $handle );
	}
}

// Remove The Gravity Form Stylesheet
function remove_gravityforms_style() {
	wp_dequeue_style('gforms_css');
}
add_action('wp_print_styles', 'remove_gravityforms_style');
/* END Set Gravity Form Defaults */

/* BEGIN Config Vipers Video Tags Defaults */
/* This does not work. Want to turn off all options except YouTube by default.  */
/* Setting it in PU works, but PU upgrades break it. */
/*
$vvq_defaultsettings							= array();
$vvq_defaultsettings['vimeo']['button'] 		= 0;
$vvq_defaultsettings['veoh']['button'] 			= 0;
$vvq_defaultsettings['dailymotion']['button'] 	= 0;
$vvq_defaultsettings['bliptv']['button']		= 0;
update_option("vvq_options",$vvq_defaultsettings);
*/
/* END Config Vipers Video Tags Defaults */

/* BEGIN Tiny MCE */
/* Allow iframe content to 'stick' when toggling visual editor */
add_filter('tiny_mce_before_init', create_function( '$a',
'$a["extended_valid_elements"] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]"; return $a;') );
/* END Tiny MCE */

// Changing excerpt more
function new_excerpt_more($excerpt) {
	//return str_replace('[...]', '<a href="'. get_permalink($post->ID) . '">' . 'Read More...' . '</a>', $excerpt);
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'new_excerpt_more');
// END - Changing excerpt more

/* Add .js Libraries */
add_action('template_redirect', 'theme_js_head_load');


/* -- Add typekit js and css to document head -- */
add_action('wp_head','typekit_js');
	function typekit_js() { 
		if( !is_admin() ) : ?>
<script type="text/javascript" src="http://use.typekit.com/fsk3bpv.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>	
<style type="text/css">
  .wf-loading h1.header-title,
  .wf-loading .entry-title {
    /* Hide the blog title and post titles while web fonts are loading */
    visibility: hidden;
  }
</style>				
<?php
endif; 
}

function theme_js_head_load(){
	GLOBAL $theme_directory;
	// we don't need these on admin pages
	if(is_admin()) {
	
	} else {
	
		//register the plugin
		//wp_deregister_script('jquery');
		//wp_enqueue_script('jquery', THEME_TEMPLATEURL.'/scripts/jquery-1.3.2.min.js');
		
		
		
		//wp_deregister_script('jqueryui');
		//wp_register_script('jqueryui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js', false, '1.8.1');
		//wp_enqueue_script('jqueryui');
		
		wp_enqueue_script('jquery-plugins', THEME_TEMPLATEURL.'/scripts/jquery.plugins.js', array('jquery'), '1.1');
		wp_enqueue_script('theme-nav', THEME_TEMPLATEURL.'/scripts/inner.js', array('jquery'), '1.0');
		if(is_front_page()) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', false, '1.3.2');
			wp_enqueue_script('jquery');
		
			wp_enqueue_script('jquery-cycle', THEME_TEMPLATEURL.'/scripts/jquery.cycle.js', array('jquery'), '2.63');
			
			
		} else {
			wp_deregister_script('jquery');
			wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1');
			wp_enqueue_script('jquery');
		}

	}
}
/* END -Add .js Libraries */


//Allow additional tags in posts
function agrilife_add_tags(&$content) {
    $content += array(
        'object' => array(
            'width' => array(),
            'height' => array(),
            'data' => array(),
            'type' => array(),
            'classid' => array(),
            ),
        'param' => array(
            'name' => array(),
            'value' => array(),
            ),
        'embed' => array(
            'src' => array(),
            'type' => array(),
            'bgcolor' => array(),
            'allowfullscreen' => array(),
            'flashvars' => array(),
            'wmode' => array(),
            'width' => array(),
            'height' => array(),
            'style' => array(),
	            'id' => array(),
            'flashvars' => array(),
            ),
        'script' => array(
            'src' => array(),
            'type' => array(),
            'language' => array(),
        ),
        'input' => array(
            'name' => array(),
            'type' => array(),
            'value' => array(),
            'src' => array(),
            'alt' => array(),
        )
    );
return $content;
}
add_filter('edit_allowedposttags', 'agrilife_add_tags');




// Shortcodes
// -----------------------------------------------------------------------------
// Custom shortcodes


/**
 * The Child Page shortcode. [children]
 *
 * This lists children of the current page.
 **
 */
function child_pages_shortcode() {
	global $post;
	return '<ul class="childpages">'.wp_list_pages('echo=0&depth=0&title_li=&child_of='.$post->ID).'</ul>';
}
add_shortcode('children', 'child_pages_shortcode');




/**
 * The Home Gallery shortcode.
 *
 * This implements the functionality of the jQuery Gallery Shortcode for the Home template
 *
 * @param array $attr Attributes attributed to the shortcode.
 * @return string HTML content to display gallery.
 */
 add_shortcode('gallery_home', 'gallery_home_shortcode');
 
function gallery_home_shortcode($attr) {
	global $post;

	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'size'       => array(585,305)
	), $attr));

	// dropped:
	// itemtag
	// icontag
	// captiontag
	// columns

	$id = intval($id);
	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	//$itemtag = tag_escape($itemtag);
	//$captiontag = tag_escape($captiontag);
	//$columns = intval($columns);
	//$itemwidth = $columns > 0 ? floor(100/$columns) : 100;

	$selector = "gallery-{$instance}";

	$output = apply_filters('gallery_home_style', "<div id='$selector' class='pics galleryid-{$id}'>");

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] 
				? wp_get_attachment_image($id, $size, false) 
				: wp_get_attachment_image($id, $size, false);
				
		$image = wp_get_attachment_image_src($id,$size);
		//$output .= "\n<!-- ".$image[0]." -->";

		$output .= "\n	<div class='home-slide'>\n		";
		//$output .= '<img src="'.$image[0].'" alt="'.wptexturize($attachment->post_title).'" title="'.wptexturize($attachment->post_excerpt).'" />';
		// accomodate links : anchor tags
		$output .= '<img src="'.$image[0].'" alt="slide show image" title="" />';

		  if ( trim($attachment->post_excerpt) ) {
			  $output .= "<p class='home-caption'><span>" . wptexturize($attachment->post_title) . "</span>". wptexturize($attachment->post_excerpt) ."</p>";
		  }
		$output .= "\n	</div><!-- .gallery-icon -->";
	}
	$output .= "\n</div><!-- .pics -->\n";
	return $output;
}


/**
 * The Social Media Directory shortcode. [sm-directory]
 *
 * This lists children of the current page.
 **
 */
function sm_dir_shortcode() {
	global $post;
	
    // $array = get_cforms_entries();   /* all data, no filters */
	//$array = get_cforms_entries('Social Media Efforts',false,date ("Y-m-d H:i:s", time()-(3600*24*20)),'What AgriLife office do you represent?',false,'asc'); //20 day buffer
	//$array = get_cforms_entries('Social Media Efforts');
	$array = get_cforms_entries('Social Media Efforts',false,date ("Y-m-d H:i:s", time()),'What AgriLife office do you represent?',false,'asc');

	$return = '<div class="table2">
	<div class="t2-row"><div class="t2-dept"><h4>Department</h4></div><div class="t2-effort"><h4>SM Efforts</h4></div></div>';

	foreach( $array as $e ){
		if (($e['data']['Facebook Page or Group Address']<>'')
			|| ($e['data']['Facebook Page or Group Address'] <>'http://')
			|| ($e['data']['Twitter Account']<>'')
			|| ($e['data']['Twitter Account']<>'@username')
			|| ($e['data']['Flickr Photostream Address'] <> '') 
			|| ($e['data']['Flickr Photostream Address'] <> 'http://') 
			|| ($e['data']['Flickr Username'] <> '')
			|| ($e['data']['YouTube Username']<>'')
			|| ($e['data']['YouTube Username']<>'@username')
			|| ($e['data']['YouTube Channel Address']<>'')
			|| ($e['data']['YouTube Channel Address'] <> 'http://')) {
	
			$name = $e['data']['What AgriLife office do you represent?'];
			if($e['data']['Website']<>'' && $e['data']['Website']<>'http://')
				$name = '<a href="'.$e['data']['Website'].'" target="_blank">'.$name.'</a>';
			$return .=  '<div class="t2-row"><div class="t2-dept">' . $name . '</div>';
			$return .=  '<div class="t2-effort">';
			
			//Facebook
			if($e['data']['Facebook Page or Group Address']<>'' && $e['data']['Facebook Page or Group Address'] <>'http://') {
				$return .=  '<a href="'.$e['data']['Facebook Page or Group Address'].'" target="_blank"><img src="http://agrilifeweb.tamu.edu/us/files/2010/01/facebook.gif?v=100" alt="'.$e['data']['Facebook Page or Group Address'].'" /></a>';
			}
			
			//Flickr
			if ($e['data']['Flickr Photostream Address'] <> '' && $e['data']['Flickr Photostream Address'] <> 'http://') {
			  $return .=  '<a href="'.$e['data']['Flickr Photostream Address'].'">'.
			  '<img src="http://agrilifeweb.tamu.edu/us/files/2010/01/flickr.gif?v=100" alt="'.$e['data']['Flickr Photostream Address'] . ' Flickr Photos" /></a>';
			}
			
			//YouTube
			//if($e['data']['YouTube Username']<>'' && $e['data']['YouTube Username']<>'@username')
			//  $return .=  $e['data']['YouTube Username'] . '<br />';
			if($e['data']['YouTube Channel Address']<>'' && $e['data']['YouTube Channel Address'] <> 'http://') {
			  $return .=  '<a href="'.$e['data']['YouTube Channel Address'].'">'.
		  		'<img src="http://agrilifeweb.tamu.edu/us/files/2010/01/youtube.gif?v=100" alt="'.$e['data']['YouTube Channel Address'] . 
		  		' Flickr Photos" /></a>';
		  	}
		  	
		  	//Twitter
			if ($e['data']['Twitter Account']<>'' && $e['data']['Twitter Account']<>'@username') {	
				  $return .=  '<a href="'.$e['data']['Twitter Account'].'" target="_blank">'.
				  '<img src="http://agrilifeweb.tamu.edu/us/files/2010/01/twitter.gif?v=100" alt="'.$e['data']['Twitter Account'] . 
		  		  ' Twitter Page" /></a>';
			}
			
			//Blog
			if ($e['data']['Blog Address']<>'' && $e['data']['Blog Address'] <> 'http://') {
			  $return .=  '<a href="'.$e['data']['Blog Address'].'" target="_blank">'.
			  '<img src="http://agrilifeweb.tamu.edu/us/files/2010/01/rss.png?v=100" alt="'.$e['data']['What AgriLife office do you represent?'] . 
	  		  ' Blog" /></a>';
			}

			$return .=  '</div></div>';
		}
	}	
	$return .=  '</div><!-- .table2 -->';
	
	/* 
	$return .=  '<table>';
	$return .=  '<tr><th>Department</th><th>SM Efforts</th></tr>';
	foreach( $array as $e ){
		$return .=  '<tr valign="top"><td>' . $e['data']['What AgriLife office do you represent?'] . '</td>'.
		'<td>';
		
		if($e['data']['Website']<>'' && $e['data']['Website']<>'http://')
		  $return .=  $e['data']['Website'].'<br />';
		if ($e['data']['Blog Address']<>'' && $e['data']['Blog Address'] <> 'http://')
		  $return .=  $e['data']['Blog Address'] . '<br />';
		$return .=  '</td><tr>';
	}
	$return .=  '</table>';
	*/

	return $return;
}
add_shortcode('sm-directory', 'sm_dir_shortcode');


/**
 * The custom post query shortcode. [loop]
 */
function myLoop($atts, $content = null) {
	extract(shortcode_atts(array(
		"pagination" => 'true',
		"query" => '',
		"category" => '',
	), $atts));
	global $wp_query,$paged,$post;
	$temp = $wp_query;
	$wp_query= null;
	$wp_query = new WP_Query();
	if($pagination == 'true'){
		$query .= '&paged='.$paged;
	}
	if(!empty($category)){
		$query .= '&category_name='.$category;
	}
	if(!empty($query)){
		$query .= $query;
	}
	$wp_query->query($query);
	ob_start();
	?>

	<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
	 <div class="featured-wrap" id="featured-wrapper-<?php echo $count;?>">
			<h3 class="entry-title"><a href="<?php the_permalink();?>"><?php echo get_the_title(); ?></a></h3>
			<p><a class="feature-img-date" href="<?php the_permalink();?>">
			<?php if ( get_post_type() == 'post' ){ ?>
 				<span class="date"><?php echo get_the_date('m/d'); ?></span>
			<?php }
			if ( has_post_thumbnail() ) {
  the_post_thumbnail('thumbnail', array('class' => 'alignright'));
} else  { 
	echo '<img src="'.get_bloginfo("template_url").'/images/AgriLife-default-post-image.png?v=100" alt="AgriLife Logo" title="AgriLife" />'; 
	}
	?></a></p>
		<?php the_excerpt();?>
			</div><!-- end .featured-wrap -->
			<?php endwhile;  wp_reset_query; ?>	
	<?php if(pagination == 'true'){ ?>
	<div class="navigation">
	  <div class="alignleft"><?php previous_posts_link('Ç Previous') ?></div>
	  <div class="alignright"><?php next_posts_link('More È') ?></div>
	</div>
	<?php } ?>
	<?php $wp_query = null; $wp_query = $temp;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode("loop", "myLoop");
add_shortcode("show-posts", "myLoop");











// Admin Menus
// -----------------------------------------------------------------------------
// make the options user-selectable

/* put stuff on pages and init-frontend */
if (!class_exists("AgrilifeCustomizer")) {
  
  class AgrilifeCustomizer {
	var $adminOptionsName = "AgrilifeOptions";
	function AgrilifeCustomizer() { //constructor
	  
	} // End Constructor
	function init() {
		$this->getAdminOptions();
	}
	//Returns an array of admin options
	function getAdminOptions() {
		$agrilifeAdminOptions = array(
			'isResearch' => true,
			'isExtension' => true, 
			'isCollege' => true,
			'isTvmdl' => true,
			'titleImg' => '',
			'feedBurner' => '',
			'googleAnalytics' => '',
			'footerHtml' => 'footer');
		$agrilifeOptions = get_option($this->adminOptionsName);
		if (!empty($agrilifeOptions)) {
			foreach ($agrilifeOptions as $key => $option)
				$agrilifeAdminOptions[$key] = $option;
		}				
		update_option($this->adminOptionsName, $agrilifeAdminOptions);
		return $agrilifeAdminOptions;
	}
		
	
	function addHeaderCode() {
		echo '\n<!-- plugged in -->\n<h2>YO!</h2>';
	}
	
	
	function addContent($content = '') {
		$content .= "<p>Agrilife</p>";
		return $content;
	}
	/*
	function addContent($content = '') {
			$agrilifeOptions = $this->getAdminOptions();
			if ($agrilifeOptions['add_content'] == "true") {
				$content .= $agrilifeOptions['content'];
			}
			return $content;
		}
		function authorUpperCase($author = '') {
			$agrilifeOptions = $this->getAdminOptions();
			if ($agrilifeOptions['comment_author'] == "true") {
				$author = strtoupper($author);
			}
			return $author;
		}
		*/

	function set_defaults() {
	  $options = get_option('AgrilifeOptions');
	  
	  // Set Header Tabs
	  $options['isResearch'] = true;
	  $options['isExtension'] = true;
	  $options['isCollege'] = true;
	  $options['isTvmdl'] = true;
	  
	  //Set Site Title Image
	  $options['titleImg'] = '';
	  
	  //Set Google Defaults
	  $options['feedBurner'] = '';
	  $options['googleAnalytics'] = '';
	  
	  //Set Footer HTML
	  $options['footerHtml'] = '<div class="vcard">
	<h3 class="org">Texas A&amp;M AgriLife</h3>
	<p>
	<span class="adr">Jack K. Williams Administration Building | 
	  <span class="street-address">2142 TAMU</span> | 
	  <span class="locality">College Station</span>, 
	  <span class="region">TX</span> 
	  <span class="postal-code">77843</span>

	</span> | 
	<a class="map" href="http://maps.google.com/maps?q=30.619096,-96.335553&amp;sll=57.339721,-48.168397&amp;sspn=65.320558,115.604153&amp;ie=UTF8&amp;ll=30.61906,-96.335657&amp;spn=0.012982,0.017531&amp;z=16" rel="map">Map</a><br />
	Phone: <span class="tel">(979) 845-4747</span> | 
	<span class="tel"><span class="type">Fax</span>: <span class="value">(979) 845-4242</span></span> | 
	Email: <a class="email" href="mailto:agrilife@tamu.edu">agrilife@tamu.edu</a>

	</p>
</div><!-- .vcard -->
<p class="maintenance">Web Site Maintenance:<a href="http://agcomm.tamu.edu/">AgriLife Communications</a></p>';
			  
	  update_option('AgrilifeOptions',$options);
	}
	
	function showHtml($html) {
		//return htmlspecialchars(stripslashes($html));
		return $html;
	}
	
	//Prints out the admin page
	function printAdminPage() {
		  $agrilifeOptions = $this->getAdminOptions();
	     
		  // On Submit
		  if (isset($_POST['update_agrilifeSettings'])) { 
			  //Sanitize This Data
			  
			  if (isset($_POST['isCollege'])) {
				  $agrilifeOptions['isCollege'] = $_POST['isCollege'];
			  }
			  if (isset($_POST['isExtension'])) {
				  $agrilifeOptions['isExtension'] = $_POST['isExtension'];
			  }	
			  if (isset($_POST['isResearch'])) {
				  $agrilifeOptions['isResearch'] = $_POST['isResearch'];
			  }	
			  if (isset($_POST['isTvmdl'])) {
				  $agrilifeOptions['isTvmdl'] = $_POST['isTvmdl'];
			  }	
			  if (isset($_POST['titleImg'])) {
				  $agrilifeOptions['titleImg'] = stripslashes(apply_filters('content_save_pre', $_POST['titleImg']));
			  }
			  if (isset($_POST['feedBurner'])) {
				  $agrilifeOptions['feedBurner'] = stripslashes(apply_filters('content_save_pre', $_POST['feedBurner']));
			  }
			  if (isset($_POST['googleAnalytics'])) {
				  $agrilifeOptions['googleAnalytics'] = stripslashes(apply_filters('content_save_pre', $_POST['googleAnalytics']));
			  }
			  
			  if (isset($_POST['footerHtml'])) {
				  $agrilifeOptions['footerHtml'] = stripslashes(apply_filters('content_save_pre', $_POST['footerHtml']));
				  //$agrilifeOptions['footerHtml'] = apply_filters($agrilifeOptions['footerHtml'], 'wptexturize');
				  //$agrilifeOptions['footerHtml'] = apply_filters($agrilifeOptions['footerHtml'], 'convert_smilies');
				  //$agrilifeOptions['footerHtml'] = apply_filters($agrilifeOptions['footerHtml'], 'convert_chars');
			  }
			  update_option($this->adminOptionsName, $agrilifeOptions);
			  
			  ?>
<div class="updated"><p><strong><?php _e("Settings Updated.", "AgrilifeCustomizer");?></strong></p></div>
		  <?php
		  } ?>
          
          
<div class=wrap>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
<h2>Agrilife Plugin</h2>

<table width="100%" border="0" cellspacing="0" cellpadding="8">
  <tr>
    <td>
    <h3>Research?</h3>
    <p>Selecting "No" will disable the Research tab in the header.</p>
    <p><label for="isResearch_yes"><input type="radio" id="isResearch_yes" name="isResearch" value="1" <?php if ($agrilifeOptions['isResearch'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="isResearch_no"><input type="radio" id="isResearch_no" name="isResearch" value="0" <?php if (!$agrilifeOptions['isResearch'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?>/> No</label></p>
    </td>
    <td>
    <h3>Extension?</h3>
    <p>Selecting "No" will disable the Extension tab in the header.</p>
    <p><label for="isExtension_yes"><input type="radio" id="isExtension_yes" name="isExtension" value="1" <?php if ($agrilifeOptions['isExtension'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="isExtension_no"><input type="radio" id="isExtension_no" name="isExtension" value="0" <?php if (!$agrilifeOptions['isExtension'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?>/> No</label></p>
    </td>
    <td>
    <h3>College?</h3>
    <p>Selecting "No" will disable the College tab in the header.</p>
<p><label for="isCollege_yes"><input type="radio" id="isCollege_yes" name="isCollege" value="1" <?php if ($agrilifeOptions['isCollege'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="isCollege_no"><input type="radio" id="isCollege_no" name="isCollege" value="0" <?php if (!$agrilifeOptions['isCollege'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?>/> No</label></p>
    </td>
    <td>
    <h3>TVMDL?</h3>
    <p>Selecting "No" will disable the TVMDL tab in the header.</p>
    <p><label for="isTvmdl_yes"><input type="radio" id="isTvmdl_yes" name="isTvmdl" value="1" <?php if ($agrilifeOptions['isTvmdl'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?> /> Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="isTvmdl_no"><input type="radio" id="isTvmdl_no" name="isTvmdl" value="0" <?php if (!$agrilifeOptions['isTvmdl'] ) { _e('checked="checked"', "AgrilifeCustomizer"); }?>/> No</label></p>
    </td>
  </tr>
</table>


<h3>Header Image</h3>
<p>A custom 900px by 60px image you have designed.  Make sure it's exported for Web at 72 dpi.  You will need to add the image to the Media Library and then paste the path to the image below. The Media Library can be found under the 'Media' link in the left column.</p>
<p>The link you paste in should look something like: <em><?php bloginfo('url'); ?>/wp-content/uploads/2009/11/borlaug_title.gif</em></p>
<textarea name="titleImg" style="width:575px" rows="3"><?php _e($this->showHtml($agrilifeOptions['titleImg']), 'AgrilifeCustomizer') ?></textarea>


<h3>Custom Footer</h3>
<p>Your unit's name, address, contact information and link to web maintenance.</p>
<textarea name="footerHtml" style="width: 98%;" rows="18"><?php _e(apply_filters('format_to_edit',$this->showHtml($agrilifeOptions['footerHtml'])), 'AgrilifeCustomizer') ?></textarea>



<h3 style="padding-top: 20px;"><?php _e('Google Analytics Settings') ?></h3> 
<table class="form-table">
	<tr valign="top"> 
		<th scope="row"><?php _e('Tracking Code') ?></th> 
		<td>
            <input type="text" name="googleAnalytics" id="googleAnalytics" class="regular-text" tabindex='40' maxlength="200" value="<?php echo $this->showHtml($agrilifeOptions['googleAnalytics']); ?>" />
			<br />
			<?php _e('Ex: UA-XXXXX-2') ?>
		</td>
	</tr>
</table>


<a href="javascript:void(0);" onclick="jQuery(this).next('div').toggle();"><?php _e("What's Google Analytics? How do I set this up?") ?></a> 
    <div style="display:none; padding:10px 20px 20px; border:1px solid #CCC; "> 
	<p><?php _e("<a href=\"https://www.google.com/analytics/\">Google Analytics</a> is the free stats tracking system supplied by Google and produces very attractive (and comprehensive) stats.") ?></p>
	<p><?php _e("To get going, just <a href=\"http://www.google.com/analytics/sign_up.html\">sign up for Analytics</a>, set up a new account and copy the tracking code you receive (it'll start with 'UA-') into the box above and press 'Save' - it can take several hours before you see any stats, but once it is you've got access to one heck of a lot of data!") ?></p>
	<p><?php _e("For more information on finding the tracking code, please visit <a href=\"http://www.google.com/support/analytics/bin/answer.py?hl=en&amp;answer=55603\">this Google help site</a>.") ?></p>
	</div>

<h3><?php _e('Feedburner Settings') ?></h3> 
<table class="form-table">
	<tr valign="top"> 
		<th scope="row"><?php _e('FeedBurner Feed Address') ?></th> 
		<td>
            <input type="text" name="feedBurner" id="feedBurner" class="regular-text" tabindex='40' maxlength="200" value="<?php echo $this->showHtml($agrilifeOptions['feedBurner']); ?>" />
			<br />
			<?php _e('Ex: http://feeds.feedburner.com/AgriLife') ?>
		</td>
	</tr>
</table>


<div class="submit">
<input type="submit" name="update_agrilifeSettings" value="<?php _e('Update Settings', 'AgrilifeCustomizer') ?>" /></div>
</form>
</div>

		  <?php
	  }//End function printAdminPage()



  }
} //End Class AgrilifeCustomizer



if (class_exists("AgrilifeCustomizer")) {
  $agrilife_customizer = new AgrilifeCustomizer();
  $options	= get_option('AgrilifeOptions');

  //if db not already populated, the add defaults
  if (!is_array($options))
	  $agrilife_customizer->set_defaults();

}

//Initialize the admin panel
if (!function_exists("AgrilifeCustomize_ap")) {
	function AgrilifeCustomize_ap() {
		global $agrilife_customizer;
		if (!isset($agrilife_customizer)) {
			return;
		}
		if (function_exists('add_options_page')) {
			add_options_page('Agrilife Options', 'Agrilife Options', 9, basename(__FILE__), array(&$agrilife_customizer, 'printAdminPage'));
		}
	}	
}


if (isset($agrilife_customizer)) {
	// Do Stuff
	
	// put agrilife in admin menu
	add_action('admin_menu', 'AgrilifeCustomize_ap');
	
	function feedburner_add($output, $feed) { 
		$feed_url = 'http://feeds.feedburner.com/agrilife';
		$feed_array = array('rss' => $feed_url, 'rss2' => $feed_url, 'atom' => $feed_url, 'rdf' => $feed_url, 'comments_rss2' => '');
		$feed_array[$feed] = $feed_url;
		$output = $feed_array[$feed];
		return $output;
	}
	function feedburner_add_comments(){
		return 'http://comments.com';
	}
		

	
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	
	function i_want_no_generators()	{return '';}
	add_filter('the_generator','i_want_no_generators');
	
}





// Dashboard Feedburner Stat Widget
// -----------------------------------------------------------------------------
// show the feedburner dashboard widget (if configured)

/**
 * Content of Dashboard-Widget
 */
function my_wp_dashboard_test() {
	$agrilife_opt = get_option('AgrilifeOptions');
	//echo '<h4>Test Add Dashboard-Widget</h4>';
	if($agrilife_opt['feedBurner']<>''){
	  $feed 		= $agrilife_opt['feedBurner'];
	  $feed_stat	= str_replace('feeds.feedburner.com/','feeds.feedburner.com/~fc/',$feed);
	  // http://feeds.feedburner.com/tamu/UIYt
	  // http://feeds.feedburner.com/~fc/tamu/UIYt
	  echo '<p><a href="'.$feed.'"><img src="'.$feed_stat.'?bg=F9F9F9&amp;fg=21759B&amp;anim=0" height="26" width="88" style="border:0" alt="" /></a></p>'; 
	  
	} else {
	  echo "Feedburner is not configured";
	  // Publicize -> Feedcount --> Activate
	}
}
 
// add Dashboard Widget via function wp_add_dashboard_widget()
function my_wp_dashboard_setup() {
	wp_add_dashboard_widget( 'my_wp_dashboard_test', __( 'Feedburner Stats' ), 'my_wp_dashboard_test' );
}
 
// use hook, to integrate new widget
add_action('wp_dashboard_setup', 'my_wp_dashboard_setup');




// Password Protected Page Message
// This fixes a problem with password protected pages redirecting to a blank screen when referred from https
function custom_password_form($form) {
  $subs = array(
    '#<p>This post is password protected. To view it please enter your password below:</p>#' => '<p>This page is password protected. To view it please enter your password below:</p>',
    '#http#' => 'https',
    '#<form(.*?)>#' => '<form$1 class="passwordform">',
    '#<input(.*?)type="password"(.*?) />#' => '<input$1type="password"$2 class="text" />',
    '#<input(.*?)type="submit"(.*?) />#' => '<input$1type="submit"$2 class="button" />'
  );

  echo preg_replace(array_keys($subs), array_values($subs), $form);
}
//add_filter('the_password_form', 'custom_password_form');

		// Set path to function files
     	$includes_path = TEMPLATEPATH . '/includes/';

		// Add Logout Button to password-protected posts 
      	require_once ($includes_path . 'logout-password-protected-posts/logout.php');
?>
