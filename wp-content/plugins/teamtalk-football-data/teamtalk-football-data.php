<?php
/*
Plugin Name: TeamTalk Football Data
Plugin URI: http://teamtalk.com/
Description: Data plugin for the Football API
Author: TeamTalk
Author URI: http://teamtalk.com/
Text Domain: teamtalk-football-data
Domain Path: /lang
Version: 1.0.1
License: GPL-2.0+
*/

/*
 * Football API class
 */
require_once 'classes/class-football-data.php';

/*
 * Widgets
 */
require_once 'widgets/football_tables_widget.php';
require_once 'widgets/football_tables_with_team_name_click_through_widget.php';
require_once 'widgets/football_fixtures_widget.php';
require_once 'widgets/football_results_widget.php';
require_once 'widgets/football_results_without_match_detail_widget.php';

require_once 'widgets/football_fixtures_results_no_match_detail_widget.php';
require_once 'widgets/football_tables_with_groups_widget.php';

require_once 'widgets/football_live_home_test_widget.php';
require_once 'widgets/football_live_home_widget.php';
require_once 'widgets/football_live_match_widget.php';

require_once 'widgets/football_team_fixtures_widget.php';
require_once 'widgets/football_team_results_widget.php';
require_once 'widgets/football_team_tables_widget.php';

require_once 'widgets/football_live_scores_home_widget.php';
require_once 'widgets/football_live_listing_widget.php';
require_once 'widgets/football_live_scoring_widget.php';


/*
 * Global variables
 */
$plugin_url = WP_PLUGIN_URL.'/teamtalk-football-data';
$options = array();

function teamtalk_football_data (){
    echo "SETTING";
}

function teamtalk_football_data_settings_menu() {
    add_options_page( 'Football Data API Settings', 'Football Data API', 'manage_options', 'teamtalk_football_data_api_settings', 'teamtalk_football_data_options_page' );
}

function teamtalk_football_data_settings($links) {
    $settings_link = '<a href="options-general.php?page=teamtalk_football_data_api_settings">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

function teamtalk_football_data_options_page(){

    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }

    global $plugin_url;
    global $options;


    if( isset( $_POST['teamtalk_football_data_settings_form_submitted'] ) ) {
        $hidden_field = esc_html( $_POST['teamtalk_football_data_settings_form_submitted'] );

        if( $hidden_field == 'Y' ) {
            //push options to options array
            $options['football_data_api_url'] = esc_html($_POST['football_data_api_url']);
            $options['football_data_api_username'] = esc_html($_POST['football_data_api_username']);
            $options['football_data_api_password'] = esc_html($_POST['football_data_api_password']);
            $options['football_data_api_password_confirm'] = esc_html($_POST['football_data_api_password_confirm']);
            $options['last_updated'] = time();

            update_option('teamtalk_football_data_api_settings', $options);
        }
    }


    //******************************************************************************************************************
    $options = get_option( 'teamtalk_football_data_api_settings' );

    if ( $options != ''){
        $football_data_api_url = $options['football_data_api_url'];
        $football_data_api_username = $options['football_data_api_username'];
        $football_data_api_password = $options['football_data_api_password'];
        $football_data_api_password_confirm = $options['football_data_api_password_confirm'];
    }

    require('inc/options-page-wrapper.php');
}

/**
 * Enqueue scripts
 */
function enqueue_football_data_scripts() {
    wp_enqueue_script( 'footballdata.js', plugins_url('/public/js/footballdata.js',  __FILE__ ), array(), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_football_data_scripts', 20 );

/*
 * Plugin hooks
 */
$plugin = plugin_basename(__FILE__);
add_filter( "plugin_action_links_$plugin", 'teamtalk_football_data_settings');

add_action( 'admin_menu', 'teamtalk_football_data_settings_menu' );