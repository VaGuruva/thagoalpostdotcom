<?php

/**
* The core-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the dashboard-specific stylesheet and JavaScript.
*
* @package    Plugin_Name
* @subpackage Plugin_Name/admin
* @author     Your Name <email@example.com>
*/
class Ttcms_Content_Base_Core
{

	/**
	* The ID of this plugin.
	*
	* @since    1.0.0
	* @access   private
	* @var      string $name The ID of this plugin.
	*/
	private $name;

	/**
	* The version of this plugin.
	*
	* @since    1.0.0
	* @access   private
	* @var      string $version The current version of this plugin.
	*/
	private $version;

	/**
	* Initialize the class and set its properties.
	*
	* @since    1.0.0
	* @var      string $name    The name of this plugin.
	* @var      string $version The version of this plugin.
	*/
	public function __construct($name, $version, $loader)
	{
		$this->name = $name;
		$this->version = $version;
		$this->loader = $loader;
		$this->plugin_class_prefix = 'pf';

		$this->load_dependencies();
		$this->define_hooks();
	}

	/**
	* Load the required dependencies for this plugin.
	*
	* Create an instance of the loader which will be used to register the hooks
	* with WordPress.
	*
	* @since    1.0.0
	* @access   private
	*/
	private function load_dependencies()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'core/setup/class-ttcms-' . $this->plugin_class_prefix . '-posts.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'core/setup/class-ttcms-' . $this->plugin_class_prefix . '-api.php';
	}

	/**
	* Register all of the hooks related to core functionality
	* of the plugin.
	*
	* @access   private
	*/
	private function define_hooks()
	{
		$setup = new Ttcms_Content_Base_Core_Setup_Posts($this->name, $this->version, $this->loader);

		$this->loader->add_action('init', $setup, 'register_default_post_type');
		$this->loader->add_action('init', $setup, 'taxonomy_event_type');
		$this->loader->add_action('init', $setup, 'taxonomy_content_type');
		$this->loader->add_filter('rwmb_meta_boxes', $setup, 'planet_register_meta_boxes');
		$this->loader->add_action('manage_posts_custom_column', $setup, 'planet_custom_columns');
		//$this->loader->add_action('manage_posts_columns', $setup, 'planet_add_admin_columns');
		$this->loader->add_action('add_meta_boxes', $setup, 'plugin_add_meta_box');
		$this->loader->add_action('save_post', $setup, 'planet_save_meta_box_data');

		$api = new Ttcms_Content_Base_Core_Setup_Api_Feed($this->name, $this->version);
		$array = $this->loader->add_action('wp_json_server_before_serve', $api, 'planet_api_init');

	}


	/**
	* Register all of the schedules related to core functionality
	* of the plugin.
	*
	* @access   private
	*/
	public function define_schedules()
	{
		$schedules = array(
		'twicedaily'  => array('clear_api_cache'),
		'fifteenmins' => array('sync_update_posts'),
		'daily'       => array('send_statistics_email', mktime(5, 0, 0, date('m'), date('d', strtotime('+1 Day')), date('y'))),
		);
		foreach ($schedules as $frequency => $event)
		{
			if (!wp_next_scheduled($event[0]))
			{
				$time = isset($event[1]) ? $event[1] : time();
				wp_schedule_event($time, $frequency, $event[0]);
			}
		}
	}


}
