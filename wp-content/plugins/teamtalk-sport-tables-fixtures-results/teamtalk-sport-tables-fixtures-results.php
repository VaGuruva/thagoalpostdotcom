<?php
/*
Plugin Name: TeamTalk Multiple Sports Side Bar Widget
Plugin URI: http://teamtalk.com/
Description: Side bar widget showing fixtures, results & tables for multiple sports
Author: TeamTalk
Author URI: http://teamtalk.com/
Text Domain: teamtalk-sport-tables-fixtures-results
Domain Path: /lang
Version: 1.0.0
License: GPL-2.0+
*/


class teamtalk_sport_tables_fixtures_results_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'teamntalk_sport_tables_fixtures_results_widget', // Base ID
            '[Sidebar] Multiple Sports Tables, Fixtures and Results Widget', // Name
            array('description' => 'Multiple Sports Tables, Fixtures and Results Widget',) // Args
        );
    }

    function widget($args, $instance){
        require_once "partials/_header.php";
        ///require_once "partials/_rugby.php";
        //require_once "partials/_test.php";
    }
}


//handle the custom URL to fetch the relevant sport section
function my_custom_widget_handler() {
    if ((strpos($_SERVER["REQUEST_URI"], "/widget/") !== false)) {
      require_once('partials/_football.php');
      exit();
   }
}
add_action('parse_request', 'my_custom_widget_handler');

add_action('widgets_init', function () {
    register_widget('teamtalk_sport_tables_fixtures_results_widget');
});

?>