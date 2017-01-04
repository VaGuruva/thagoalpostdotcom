<?php


//add_action('content_feeds_cron','content_feeds_cron_fun');

function content_feeds_cron_fun(){
	set_time_limit(0);
	$feeds = new Ttcms_Content_Feeds('name',1);
	$feeds->bulk_process_content_feed();
}


function planet_add_cron_schedule( $schedules ) {
	$schedules['two_minutes'] = array(
		'interval' => 120,
		'display' => __('Every two minutes')
	);

	$schedules['ten_seconds'] = array(
		'interval' => 10,
		'display' => __('Every ten seconds')
	);

	$schedules['ten_minutes'] = array(
		'interval' => 600,
		'display' => __('Every ten minutes')
	);

	return $schedules;
}
//add_filter( 'cron_schedules', 'planet_add_cron_schedule' );


