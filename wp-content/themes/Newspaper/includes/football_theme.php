<?php
function remove_extra_posts_menu() {
        global $menu;

        foreach ( $menu as $i => $item ) {
                if ( $item[2] == 'edit.php' ) {
                        unset($menu[$i]);
                        break;
                }
        }
}
add_action( 'admin_menu', 'remove_extra_posts_menu' );

if (function_exists('add_theme_support'))
{
	// Add Thumbnail Theme Support
	add_theme_support('post-thumbnails');
}

/**
 * Load conditional scripts required on specific pages
 */
function teamtalk_conditional_scripts()
{
	if (is_page('pagenamehere')) {
		// Conditional script(s)
		wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0');
		wp_enqueue_script('scriptname');
	}
}

/**
 * Load required styles and scripts
 */
function teamtalk_styles_and_scripts()
{
	wp_enqueue_script( 'jquery.js', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'frontend.js', get_template_directory_uri() . '/js/frontend.js', array(), '1.0.0', true );
    wp_enqueue_script( 'bootstrap.min.js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '3.3.4', true );
	wp_enqueue_script( 'underscore-min.js', get_template_directory_uri() . '/js/underscore-min.js', array(), '1.0.0', true );

    // Content Slider - Mobile
    wp_enqueue_script( 'jquery.bxslider.min.js', get_template_directory_uri() . '/js/jquery.bxslider.min.js', array(), '1.0.0', true );

    // Tennis Weather Widget
    wp_enqueue_script( 'jquery.simpleWeather.min.js', get_template_directory_uri() . '/js/jquery.simpleWeather.min.js', array(), '1.0.0', true );

    // Mobile Subnav / Slicknav
    wp_enqueue_script( 'jquery.slicknav.js', get_template_directory_uri() . '/js/jquery.slicknav.js', array(), '1.0.0', true );

    // Gallery - Lightslider
    wp_enqueue_script( 'lightslider.js', get_template_directory_uri() . '/js/lightslider.js', array(), '1.0.0', true );

    wp_enqueue_script( 'scripts.js', get_template_directory_uri() . '/js/scripts.js', array(), '1.0.0', true );

    //wp_enqueue_script( 'jquery.min.js', '/wp-content/plugins/score-ticker/public/scripts/jquery.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'moment.min.js', '/wp-content/plugins/score-ticker/public/scripts/moment.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'transition-bootstrap3.js', '/wp-content/plugins/score-ticker/public/scripts/transition-bootstrap3.js', array(), '1.0.0', true );
    wp_enqueue_script( 'dropdown-bootstrap3.js', '/wp-content/plugins/score-ticker/public/scripts/dropdown-bootstrap3.js', array(), '1.0.0', true );
    wp_enqueue_script( 'tab-bootstrap3.js', '/wp-content/plugins/score-ticker/public/scripts/tab-bootstrap3.js', array(), '1.0.0', true );
    wp_enqueue_script( 'collapse-bootstrap3.js', '/wp-content/plugins/score-ticker/public/scripts/collapse-bootstrap3.js', array(), '1.0.0', true );
    wp_enqueue_script( 'jquery.cookie.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js', array(), '1.4.1', true );
    wp_enqueue_script( 'script.js', '/wp-content/plugins/score-ticker/public/scripts/script.js', array(), '1.5.0', true );
}
add_action('wp_enqueue_scripts', 'teamtalk_styles_and_scripts');



/**
 * Register Menus
 */
function register_menu()
{
	register_nav_menus(array( // Using array to specify more menus if needed
	                          'header-menu' => __('Main Menu', 'teamtalk'),
                              'asia' => __('Asia Menu', 'teamtalk'),
                              'footer_copyright' => __('Footer - Copyright Menu', 'teamtalk'),
                              'sport' => __('Footer - Sport Menu', 'teamtalk'),
                              'sport2' => __('Footer - Sport Menu 2', 'teamtalk'),
                              'sport3' => __('Footer - Sport Menu 3', 'teamtalk'),
                              'watch' => __('Footer - Watch Menu', 'teamtalk'),
                              'other-links' => __('Footer - Other Links Menu', 'teamtalk')
	));
}

add_action('admin_init', 'image_sizes_init');

/**
 * Define image dimensions for site
 */
function image_sizes_init() {

    set_post_thumbnail_size(100, 100, true);

    add_image_size('top_news_widget', 426, 250, true);
    add_image_size('promo', 300, 167, true);
    add_image_size('latest_news', 265, 149, true);
    add_image_size('latest_news_small', 137, 137, true);
    add_image_size('article_image', 610, 356, true);
    add_image_size('popular_now', 105, 79, true);
    add_image_size('video_main', 323, 180, array('center','top'));
    add_image_size('video_small', 158, 75, array('center','top'));

    add_image_size('hero_secondary',469,245,array('center','top'));

}



/**
 * remove class from the_post_thumbnail
 * @param $output
 *
 * @return mixed
 */
function the_post_thumbnail_remove_class($output) {
	$output = preg_replace('/class=".*?"/', '', $output);
	$output = preg_replace('/width=".*?"/', '', $output);
	$output = preg_replace('/height=".*?"/', '', $output);
	return $output;
}
add_filter('post_thumbnail_html', 'the_post_thumbnail_remove_class');


/**
 * Remove Injected classes, ID's and Page ID's from Navigation <li> items
 * @param $var
 *
 * @return array|string
 */
function my_css_attributes_filter($var)
{
	return is_array($var) ? array() : '';
}


/**
 * Remove invalid rel attribute values in the categorylist
 * @param $thelist
 *
 * @return mixed
 */
function remove_category_rel_from_category_list($thelist)
{
	return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

//
/**
 * Add page slug to body class
 * @param $classes
 *
 * @return array
 */
function add_slug_to_body_class($classes)
{
	global $post;
	if (is_home()) {
		$key = array_search('blog', $classes);
		if ($key > -1) {
			unset($classes[$key]);
		}
	} elseif (is_page()) {
		$classes[] = sanitize_html_class($post->post_name);
	} elseif (is_singular()) {
		$classes[] = sanitize_html_class($post->post_name);
	}

	return $classes;
}


/**
 * Remove the width and height attributes from inserted images
 * @param $html
 *
 * @return mixed
 */
function remove_width_attribute( $html ) {
	$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
	return $html;
}


add_filter( 'wp_get_attachment_image_attributes', 'add_title_to_attachment_image', 10, 2 );
function add_title_to_attachment_image( $attr, $attachment ) {
    $attr['title'] = esc_attr( $attachment->post_title );
    return $attr;
}

/**
 *  Remove Admin bar
 * @return bool
 */
function remove_admin_bar()
{
	return false;
}

/**
 * Register sidebars for site
 *
 */


if (function_exists('register_sidebar'))
{
	register_sidebar(array(
		'name' => __('Main Sidebar', 'teamtalk'),
		'id' => 'main-sidebar',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

	register_sidebar(array(
		'name' => __('Home Page', 'teamtalk'),
		'id' => 'home-content',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

	register_sidebar(array(
		'name' => __('News Single Article', 'teamtalk'),
		'id' => 'news-sidebar',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

    register_sidebar(array(
        'name' => __('Stats', 'teamtalk'),
        'id' => 'stats-sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'name' => __('Videos', 'teamtalk'),
        'id' => 'videos-sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'name' => __('Forum Sidebar', 'teamtalk'),
        'id' => 'forum-sidebar',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));    
}

// Add Actions

add_action('wp_print_scripts', 'teamtalk_conditional_scripts'); // Add Conditional Page Scripts
add_action('init', 'register_menu'); // Add HTML5 Blank Menu
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
foreach (glob(dirname(__FILE__)."/widgets/*.php") as $filename)
{
	include_once $filename;
}


/**
 * Load a template part into a template
 *
 * Makes it easy for a theme to reuse sections of code in a easy to overload way
 * for child themes.
 *
 * Includes the named template part for a theme or if a name is specified then a
 * specialised part will be included. If the theme contains no {slug}.php file
 * then no template will be included.
 *
 * The template is included using require, not require_once, so you may include the
 * same template part multiple times.
 *
 * For the $name parameter, if the file is called "{slug}-special.php" then specify
 * "special".
 *
 * @since 3.0.0
 *
 * @uses locate_template()
 *
 * @param string $slug The slug name for the generic template.
 * @param string $name The name of the specialised template.
 */
if(!function_exists('include_template_part')):
	/**
	 * @param      $slug
	 * @param null $name
	 * @param null $_data
	 */
	function include_template_part( $slug, $name = null, $_data = null ) {
		/**
		 * Fires before the specified template part file is loaded.
		 *
		 * The dynamic portion of the hook name, $slug, refers to the slug name
		 * for the generic template part.
		 *
		 * @since 3.0.0
		 *
		 * @param string $slug The slug name for the generic template.
		 * @param string $name The name of the specialized template.
		 */
		do_action( "include_template_part_{$slug}", $slug, $name );

		$templates = array();
		$name = (string) $name;
		if ( '' !== $name )
			$templates[] = "{$slug}-{$name}.php";

		$templates[] = "{$slug}.php";

		$template = locate_template($templates, false, false);

		if ( !empty( $_data ) && is_array( $_data ) )
			extract( $_data, EXTR_SKIP );
		include $template;
	}
endif;

function planet_pagination($query,$pages = '', $range = 4)
{
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{

		$pages = $query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}
	//echo $pages;
	if(1 != $pages)
	{
		echo "<div class=\"pagination\">";
		echo "<ul class=\"pagination__list\">";
		//FIRST ITEM
		if($paged > 2 && $paged > $range+1 && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link(1);
		}else{
			$active = 'inactive';
			$url = '#';
		}
		echo "<li class=\"pagination__item {$active}\">";
		echo "<a href='".$url."'><span class=\"sprite-pagination--firstPage_Active\"></span></a>";
		echo "</li>";


		if($paged > 1 && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link($paged - 1);
		}else{
			$active = 'inactive';
			$url = '#';
		}

		echo "<li class=\"pagination__item {$active}\">";
		echo "<a href='".$url."'><span class=\"sprite-pagination--previousPage_Active\"></span></a></li>";
		echo "</li>";

		echo "<li class=\"pagination__item\">
					<span>Page {$paged} of {$pages}</span>
		</li>";

		if ($paged < $pages && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link($paged + 1);
		}else{
			$active = 'inactive';
			$url = '#';
		}

		echo "<li class=\"pagination__item {$active} \">";
		echo "<a href=\"".$url."\"><span class=\"sprite-pagination--nextPage_Active\"></span></a></li>";
		echo "</li>";


		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link($pages);
		}else{
			$active = 'inactive';
			$url = '#';
		}


		echo "<li class=\"pagination__item {$active} \">";
		echo "<a href='".$url."'><span class=\"sprite-pagination--lastPage_Active\"></span></a></li>";
		echo "</li>";

		echo "</ul>";
		echo "</div>";
	}
}

function planet_search_pagination($query,$pages = '', $range = 4)
{
	$showitems = ($range * 2)+1;
	//echo 'Showitems'.$showitems;
	global $paged;
	if(empty($paged)) $paged = 1;
	//echo('page'.$paged);
	if($pages == '')
	{

		$pages = $query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}
	//echo 'Pages:'.$pages;
	if(1 != $pages)
	{
		echo "<div class=\"pagination\">";
		echo "<ul class=\"pagination__list\">";
		//FIRST ITEM
		if($paged > 2 && $paged > $range+1 && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link(1);
		}else{
			$active = 'inactive';
			$url = '#';
		}
		echo "<li class=\"pagination__item {$active}\">";
		echo "<a href='".$url."'><span class=\"sprite-pagination--firstPage_Active\"></span></a>";
		echo "</li>";


		if($paged > 1 && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link($paged - 1);
		}else{
			$active = 'inactive';
			$url = '#';
		}

		echo "<li class=\"pagination__item {$active}\">";
		echo "<a href='".$url."'><span class=\"sprite-pagination--previousPage_Active\"></span></a></li>";
		echo "</li>";

		echo "<li class=\"pagination__item\">
					<span>Page {$paged} of {$pages}</span>
		</li>";

		if ($paged < $pages && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link($paged + 1);

		}else{
			$active = 'inactive';
			$url = '#';
		}

		echo "<li class=\"pagination__item {$active} \">";
		echo "<a href=\"".$url."\"><span class=\"sprite-pagination--nextPage_Active\"></span></a></li>";
		echo "</li>";


		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages){
			$active = '';
			$url = get_pagenum_link($pages);
		}else{
			$active = 'inactive';
			$url = '#';
		}


		echo "<li class=\"pagination__item {$active} \">";
		echo "<a href='".$url."'><span class=\"sprite-pagination--lastPage_Active\"></span></a></li>";
		echo "</li>";

		echo "</ul>";
		echo "</div>";
	}
}

add_filter( 'request', 'planet_filter_request' );
/**
 * @param $vars
 *
 * @return mixed
 */
function planet_filter_request( $vars )
{
	return $vars;
}


add_filter( 'template_include', 'planet_page_template', 99 );

/**
 * Load specific template for certain endpoints
 *
 * @param $template
 *
 * @return string
 */
function planet_page_template( $template ) {

		global $wp_query;



		if ( (isset( $wp_query->query_vars['galleries'] ) or isset($wp_query->query_vars['news']) ) && is_singular()  ) {

			if ( isset( $wp_query->query_vars['galleries'] ) ):
				$new_template = locate_template( array( 'template-photo-gallery.php' ) );
				if ( '' != $new_template ) {
					return $new_template;
				}
			endif;

			if ( isset( $wp_query->query_vars['news'] ) ):
				$new_template = locate_template( array( 'template-news.php' ) );
				if ( '' != $new_template ) {
					return $new_template;
				}
			endif;

		}else{
			return $template;
		}

	return $template;
}

add_action('pre_get_posts','planet_alter_search_query');

/**
 * For search, show only posts in results
 * @param $query
 */
function planet_alter_search_query($query) {
	//gets the global query var object
	global $wp_query;



	if (!is_search())
		return;

	if ( !$query->is_main_query() )
		return;


	$query-> set('post_type' ,'post');

}

add_action( 'admin_init', 'posts_order_wpse_91866' );

function posts_order_wpse_91866() 
{
    add_post_type_support( 'post', 'page-attributes' );
}


function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');


 //if(!is_admin()){
	require_once( 'classes/Mobile_Detect.php' );
	global $detect;
	$detect = new Mobile_Detect();
//}


