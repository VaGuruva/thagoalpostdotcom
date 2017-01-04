<?php

/*
 * Admin Theme Options
 */
require get_template_directory() . '/admin/admin-framework.php';

add_filter('onnet_admin_options', 'theme_options', 10, 1);
function theme_options($current_options) {


	$options = array();

	//Social
	$options[] = array(
		'name' => __('Social', 'admin-framework'),
		'type' => 'heading'
	);


	$options[] = array(
		'name' => __('Social facebook link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'facebook_link',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Social twitter link', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'twitter_link',
		'std' => '',
		'type' => 'text'
	);


	$options[] = array(
		'name' => __('Mailchimp API details', 'admin-framework'),
		'type' => 'heading'
	);

	$options[] = array(
		'name' => __('Mailchimp API Key', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'planet_mailchimp_api_key',
		'std' => '',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Mailchimp List ID', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'planet_mailchimp_list_id',
		'std' => '',
		'type' => 'text'
	);

	//Planet
	$options[] = array(
		'name' => __('Planet F1', 'admin-framework'),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __('Current Season', 'options_framework_theme'),
		'desc' => __('', 'options_framework_theme'),
		'id' => 'planetf1_season',
		'std' => '2015',
		'type' => 'text'
	);

	return array_merge($options, $current_options);
}