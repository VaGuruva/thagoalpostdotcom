<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class Ttcms_Content_Activator {

	/**
	 * Install tables required on activation. (use period)
	 *
	 *
	 * @since    1.0.0
	 */
	public function activate() {
		//self::install_tables();

		//Crons
		//self::schedule_crons();
	}

	private static function schedule_crons(){
//		wp_schedule_event( time(), 'hourly', 'planet_feeds_cron' );
		//wp_schedule_event( time(), 'two_minutes', 'planet_feeds_cron' );
		wp_schedule_event( time(), 'ten_minutes', 'planet_feeds_cron' );
		//wp_schedule_event( time(), 'ten_seconds', 'planet_feeds_cron' );
	}

	private static function install_tables(){

		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


		/**
		 * Event Results
		 */
		$table_name = $wpdb->prefix . "event_results";

		$sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        event_id mediumint(9)  NOT NULL,
        driver_id mediumint(9)  NOT NULL,
        team_id mediumint(9)  NOT NULL,
        circuit_id mediumint(9)  NOT NULL,
        start_position INT(3) NOT NULL,
        end_position INT(3) NOT NULL,
        result_time VARCHAR(30) NOT NULL,
        UNIQUE KEY id (id)
        );";

		dbDelta($sql);

	}

}
