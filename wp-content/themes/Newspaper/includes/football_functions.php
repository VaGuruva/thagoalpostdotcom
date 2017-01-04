<?php
/**
 * Create main site navigation
 */
function main_nav()
{
	wp_nav_menu(
		array(
			'theme_location'  => 'header-menu',
			'menu'            => '',
			'container'       => 'nav',
			'container_class' => 'navigation--primary',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '<ul>%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		)
	);
}

/**
 * Accessibility Menu in Footer
 */
function accessibility_menu()
{
    wp_nav_menu(
        array(
            'theme_location'  => 'footer-menu',
            'menu'            => '',
            'container'       => 'nav',
            'container_class' => 'navigation--accessibility',
            'container_id'    => '',
            'menu_class'      => 'menu',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul>%3$s</ul>',
            'depth'           => 0,
            'walker'          => ''
        )
    );
}

/*
    Remove the long string and put ... at the end of the abstract
*/
function wp_new_excerpt($text)
{
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = strip_tags($text);
    $text = nl2br($text);
    $excerpt_length = apply_filters('excerpt_length', 15);
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words) > $excerpt_length) {
        array_pop($words);
        array_push($words, '...');
        $text = implode(' ', $words);
    }

    return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
// add_filter('get_the_excerpt', 'wp_new_excerpt');

//Custom Excerpts
//Custom Excerpts
function custom_multi_excerpt($length) {

	$text = get_the_content();	

	$length = (int) $length;
	$text = trim( strip_tags( $text ) );

	if ( strlen( $text ) > $length ) {
	    $text = substr( $text, 0, $length + 1 );
	    $words = preg_split( "/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY );
	    preg_match( "/[\s]|&nbsp;/", $text, $lastchar, 0, $length );
	    if ( empty( $lastchar ) )
	        array_pop( $words );

	    $text = implode( ' ', $words ); 
	    $text .= '...';
	}

	return $text;



    /*
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    }

    $content = apply_filters('the_content', $content);
    $content = strip_tags($content);

    return $content;
    */
}

remove_filter('custom_multi_excerpt', 'wpautop');

// Limiting excerpt length to 140 characters
function more_news_excerpt($length=190){
    $excerpt = get_the_excerpt();
	$excerpt = str_replace("%u2018", "'", $excerpt);
    $excerpt = preg_replace(" (/[.*?/])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);

	if ( strlen( $excerpt ) > $length ) {
	    $text = substr( $excerpt, 0, $length + 1 );
	    $words = preg_split( "/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY );
	    preg_match( "/[\s]|&nbsp;/", $text, $lastchar, 0, $length );
	    if ( empty( $lastchar ) )
	        array_pop( $words );

	    $excerpt = implode( ' ', $words ); 
	    $excerpt .= '...';
	}

	return $excerpt;
}

// Limiting excerpt length to 140 characters
function more_news_content_excerpt($length=190){
    $excerpt = get_the_content();
    $excerpt = str_replace("%u2018", "'", $excerpt);
    $excerpt = preg_replace(" (/[.*?/])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
	if ( strlen( $excerpt ) > $length ) {
	    $text = substr( $excerpt, 0, $length + 1 );
	    $words = preg_split( "/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY );
	    preg_match( "/[\s]|&nbsp;/", $text, $lastchar, 0, $length );
	    if ( empty( $lastchar ) )
	        array_pop( $words );

	    $excerpt = implode( ' ', $words ); 
	    $excerpt .= '...';
	}

	return $excerpt;
}

// Limiting title length
function mustwatch_title($length) {
    $title = get_the_title($post->ID);
    $title = strip_shortcodes($title);
    $title = strip_tags($title);

	if ( strlen( $title ) > $length ) {
	    $text = substr( $title, 0, $length + 1 );
	    $words = preg_split( "/[\s]|&nbsp;/", $text, -1, PREG_SPLIT_NO_EMPTY );
	    preg_match( "/[\s]|&nbsp;/", $text, $lastchar, 0, $length );
	    if ( empty( $lastchar ) )
	        array_pop( $words );

	    $title = implode( ' ', $words ); 
	    $title .= '...';
	}

	echo $title;
}

// Add limit in backend for excerpt
function excerpt_count_js(){

    if ('page' != get_post_type()) {

        echo "<script>jQuery(document).ready(function(){
     jQuery('#postexcerpt .handlediv').after('<div class=\"lengthlimit\" style=\"position:absolute;top:12px;right:34px;color:#000;\">Length: <span id=\"excerpt_counter\"></span><span style=\"font-weight:bold; padding-left:7px;\">of 140</span><span style=\"padding-left:7px;\">characters.</span></div>');
     jQuery('#excerpt').keyup( function() {
         if(jQuery(this).val().length >= 140){
            jQuery(this).val(jQuery(this).val().substr(0, 140));
            jQuery('.lengthlimit').css({'color':'#FF0000'});
        }
        else
        {
        jQuery('.lengthlimit').css({'color':'#000'});
        }
     jQuery('span#excerpt_counter').text(jQuery('#excerpt').val().length);

   });
});</script>";
    }
}
add_action( 'admin_head-post.php', 'excerpt_count_js');
add_action( 'admin_head-post-new.php', 'excerpt_count_js');

/**
 * Custom Backend Styling
 */

//Attach custom admin login CSS file
function custom_login_css() {
    echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/custom-login.css" />';
}
add_action('login_head', 'custom_login_css');

function custom_wpadmin() {
    echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/custom-login.css" />';
}
add_action('wp_head', 'custom_wpadmin');
add_action('admin_head', 'custom_wpadmin');

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Kwesesports.com';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

/* Hide Thank you message in admin footer */
if (! function_exists('dashboard_footer') ){
    function dashboard_footer () {}
}
add_filter('admin_footer_text', 'dashboard_footer');

/* Remove Wordpress Admin Bar */
function admin_bar_remove() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}

add_action('wp_before_admin_bar_render', 'admin_bar_remove', 0);

// Remove wp generator tag
remove_action('wp_head', 'wp_generator');

//
// Add options page
//
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Trending Now Widget',
        'menu_title'	=> 'Trending Now',
        'menu_slug' 	=> 'trending-now',
        'capability'	=> 'edit_posts',
        'redirect'		=> true
    ));

    acf_add_options_page(array(
        'page_title' 	=> 'Footer Settings',
        'menu_title'	=> 'Footer Settings',
        'menu_slug' 	=> 'footer-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> true
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Channels',
        'menu_title'	=> 'Channels',
        'parent_slug'	=> 'footer-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Social Media',
        'menu_title'	=> 'Social Links',
        'parent_slug'	=> 'footer-settings',
    ));
}

// Change Default Email From Name and Email Address
add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');

function new_mail_from($old) {
    return 'noreply@foxsportsasia.com';
}
function new_mail_from_name($old) {
    return 'FOX SPORTS ASIA';
}

/**
 * Get social shares for facebook
 *  * @param $url
 *  * @return string
 */
function get_remote_facebook_shares ($url)
{

	$fb_count = wp_remote_get ("http://graph.facebook.com/?id=" . rawurlencode($url), array( 'timeout' => 15 ));
	if (is_wp_error ($fb_count)) {
		return;
	}
	$fb_count = $fb_count["body"];
	$fb_count = json_decode ($fb_count);
	$shares = property_exists ($fb_count, 'shares');
	$error = property_exists ($fb_count, 'error');
	$fb_count = ( $shares && !$error ) ? $fb_count->shares : "0";

	return $fb_count;
}

/**
 * Get social shares for twitter
 * @param $url
 *
 * @return string
 */
function get_remote_twitter_shares ($url)
{

	$twit_count = wp_remote_get ("http://urls.api.twitter.com/1/urls/count.json?url=" . rawurlencode($url), array( 'timeout' => 15 ));
	if (is_wp_error ($twit_count)) {
		return;
	}
	$twit_count = $twit_count["body"];
	$twit_count = json_decode ($twit_count);
	$twit_count = ( $twit_count->count ) ? $twit_count->count : "0";

	return $twit_count;
}


/**
 * Get the wordpress post_id using a teamtalk xml data id
 * Relates to driver, circuit, event etc
 * @param $data_id DATA ID
 * @param $post_type
 *
 * @return bool|int post_id of relevant item in wordpress
 */
function get_post_id_from_planet_data_id($data_id,$post_type){
	global $wpdb;
	$result = $wpdb->get_results("SELECT ID, post_title FROM wp_posts p
				INNER JOIN wp_postmeta m
				ON m.post_id = p.ID
				AND meta_value = $data_id
				AND meta_key = '_planetf1_data_id'
				AND post_type = '{$post_type}'");

	if(isset($result[0]))
		return $result[0]->ID;
	else
		return false;

}

/**
 * Get the teamtalk xml data id using the wordpress post_id
 * Relates to driver, circuit, event etc
 * @param $data_id DATA ID from teamtalk xml feed - Relates to driver, circuit, event etc
 * @param $post_type
 *
 * @return bool|int post_id of relevant item in wordpress
 */
function get_planet_id_from_post_id($post_id,$post_type){
	global $wpdb;
	$result = $wpdb->get_results("SELECT ID, post_title, meta_value FROM wp_posts p
				INNER JOIN wp_postmeta m
				ON m.post_id = p.ID
				AND meta_key = '_planetf1_data_id'
				AND post_type = '{$post_type}'
				AND ID = {$post_id} ");

	if(isset($result[0]))
		return $result[0]->meta_value;
	else
		return false;

}

/**
 * Get winner of specific event
 *
 * @param $event_id
 *
 * @return mixed
 */
function planet_get_event_winner($event_id){
	global $wpdb;
	$results = $wpdb->get_results("
	SELECT  r.event_date, r.team,  d.post_title as driver_name FROM wp_event_results r

	INNER JOIN wp_postmeta dm
	ON dm.meta_value = r.driver_id
	AND dm.meta_key = '_planetf1_data_id'

	INNER JOIN wp_posts d
	ON dm.post_id = d.ID

	WHERE end_position = 1
	AND event_id = $event_id
	ORDER BY event_date DESC
	LIMIT 1 ");



	return $results;
}


/**
 * Generate latest results for homepage dashboard
 * @return array
 */
function planet_results_dashboard_list(){
	global $wpdb;

	$results = $wpdb->get_results("	SELECT  p.ID as event_id, p.post_title, m.meta_value as start_date, mc.meta_value as circuit_id, e.post_title FROM wp_posts p

	INNER JOIN wp_postmeta m
	ON m.post_id = p.ID
	AND m.meta_key = 'start_date'

	INNER JOIN wp_postmeta mc
	ON mc.post_id = p.ID
	AND mc.meta_key = 'circuit_id'

	INNER JOIN wp_posts e
	ON e.ID = mc.meta_value

	INNER JOIN wp_term_relationships txr1 ON p.ID = txr1.object_id
	INNER JOIN wp_term_taxonomy tx1 ON txr1.term_taxonomy_id = tx1.term_taxonomy_id AND tx1.taxonomy ='event_type'
	INNER JOIN wp_terms trm ON tx1.term_id = trm.term_id and trm.name = 'race'

	WHERE p.post_type = 'event'
	ORDER BY m.meta_value");


	return $results;

}

/**
 * Generate results for all circuits
 * @param bool $limit
 *
 * @return mixed
 */
function planet_results_for_circuits($limit = false){
	global $wpdb;
	$limit_text=null;

	if($limit)
		$limit_text = "LIMIT $limit";

	$results = $wpdb->get_results("SELECT  r.result_time, r.event_date, r.team,  c.post_title as circuit_name, d.post_title as driver_name FROM wp_event_results r

	INNER JOIN wp_postmeta cm
	ON cm.meta_value = r.circuit_id
	AND cm.meta_key = '_planetf1_data_id'

	INNER JOIN wp_posts c
	ON cm.post_id = c.ID

	INNER JOIN wp_postmeta dm
	ON dm.meta_value = r.driver_id
	AND dm.meta_key = '_planetf1_data_id'

	INNER JOIN wp_posts d
	ON dm.post_id = d.ID

	WHERE end_position = 1
	ORDER BY event_date DESC
	$limit_text");


	return $results;

}

/**
 * Generate results for last circuit raced. Shows top 3 positions
 * @return mixed
 */
function planet_results_for_last_circuit(){
	global $wpdb;



	$results = $wpdb->get_results("SELECT  c.ID as circuit_id , r.result_time, r.event_date, r.team,  c.post_title as circuit_name, d.post_title as driver_name FROM wp_event_results r

	INNER JOIN wp_postmeta cm
	ON cm.meta_value = r.circuit_id
	AND cm.meta_key = '_planetf1_data_id'

	INNER JOIN wp_posts c
	ON cm.post_id = c.ID

	INNER JOIN wp_postmeta dm
	ON dm.meta_value = r.driver_id
	AND dm.meta_key = '_planetf1_data_id'

	INNER JOIN wp_posts d
	ON dm.post_id = d.ID

	WHERE end_position IN(1,2,3)

	AND event_id = (SELECT event_id FROM wp_event_results ORDER by event_date DESC LIMIT 1   )

	ORDER BY end_position ASC
	");


	return $results;

}


/**
 *
 * Get specific drivers standings
 *
 * @param bool $driver_name
 * @param bool $limit
 *
 * @return array
 */
function planet_driver_standings_list($driver_name = false,$limit=false){
	global $wpdb;
	$where = null;
	$limit_text = null;
	if(false != $driver_name)
		$where = 'WHERE name = "'.$driver_name.'"';

	if($limit)
		$limit_text = "LIMIT $limit";

	//$results = $wpdb->get_results("SELECT * FROM wp_driver_standings $where  ORDER by position ASC $limit_text");
	$results = $wpdb->get_results("SELECT d.position, d.name, d.points, d.post_id
		FROM wp_driver_standings AS d
		JOIN wp_posts AS p ON p.ID = d.post_id
		ORDER BY d.position ASC $limit_text");

	return $results;

}

/**
 *
 * Get specific teams standings
 *
 * @param bool $team_id
 * @param bool $limit
 *
 * @return array
 */
function planet_team_standings_list($team_id = false,$limit = false){
	global $wpdb;
	$limit_text=null;

	if($team_id)
		$where = 'WHERE';

	if($limit)
		$limit_text = "LIMIT $limit";

	$results = $wpdb->get_results("SELECT * FROM wp_team_standings ORDER by position ASC $limit_text");
	return $results;

}

/**
 *
 * Get standings for specific driver using driver id
 *
 * @param $driver_id
 *
 * @return array
 */
function planet_driver_results_list($driver_id){

	global $wpdb;
	$results = $wpdb->get_results("
	SELECT r.*, d.post_title as driver_name, c.post_title as circuit_name FROM wp_event_results r

	INNER JOIN wp_postmeta dm
	ON dm.meta_key = '_planetf1_data_id'
	AND dm.meta_value = r.driver_id
	INNER JOIN wp_posts d
	ON d.ID = dm.post_id

	INNER JOIN wp_postmeta cm
	ON cm.meta_key = '_planetf1_data_id'
	AND cm.meta_value = r.circuit_id
	INNER JOIN wp_posts c
	ON c.ID = cm.post_id

	WHERE driver_id = {$driver_id}
	ORDER BY event_date DESC
	");
	return $results;

}


/** AJAX FUNCTIONS */


add_action( 'wp_ajax_newsletter_subscribe', 'planet_newsletter_subscribe' );
add_action( 'wp_ajax_nopriv_newsletter_subscribe', 'planet_newsletter_subscribe' );


/**
 *Subscribe to mailchimp newsletter with user email
 */
function planet_newsletter_subscribe()
{
	if ( isset( $_POST['email'] ) )
	{
		if ( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) )
		{
			require_once( 'classes/Mailchimp.php' );
			$clean_email = trim( $_POST['email'] );
			$mailchimp   = new Mailchimp( '89b858c3577e8b003002397935dbce0d-us7' );
			try {
				//$mailchimp->lists->subscribe( 'fe0086060a', array( 'email' => $clean_email ) );
				echo json_encode(array(
					'success' => true,
					'message' => 'Thank you for subscribing!'
				));
				die();
			}catch(Mailchimp_Error $e){
				echo json_encode(array(
					'success' => false,
					'message' => 'Subscription request failed.'
				));
				die();
			}
		} else
		{
			echo json_encode(array(
				'success' => false,
				'message' => 'Please enter a valid email address.'
			));
			die();
		}
	} else
	{
		echo json_encode(array(
			'success' => false,
			'message' => 'Please enter an email address.'
		));
		die();
	}
}


function permalink_untrailingslashit($link) {
	return untrailingslashit($link);
}
add_filter('page_link', 'permalink_untrailingslashit');
add_filter('post_type_link', 'permalink_untrailingslashit');