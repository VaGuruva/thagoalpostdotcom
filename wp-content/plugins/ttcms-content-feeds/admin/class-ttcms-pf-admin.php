<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Content Feeds
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Ttcms_Content_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $ttcms_content;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $ttcms_content, $version ) {

		$this->plugin_name = $ttcms_content;
		$this->name = $ttcms_content;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ttcms-pf-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-chosen', plugin_dir_url( __FILE__ ) . 'css/chosen.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ttcms-pf-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-chosen', plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the admin menu
	 */
	public function admin_menu()
	{
		$capability = 'manage_options';

		add_menu_page(__('Content Feeds'), __('Content Feeds'), $capability, $this->plugin_name . '-feeds', array($this, 'render_feeds'));
		add_submenu_page($this->plugin_name . '-feeds', __('TTCMS Content Feeds - Push'), __('Content Push'), $capability, $this->plugin_name.'-push', array($this, 'render_push'));
		add_submenu_page($this->plugin_name . '-feeds', __('TTCMS Content Feeds - Push'), __('Add Push Feed'), $capability, $this->plugin_name.'-add-push', array($this, 'add_push'));
		add_submenu_page(null, __('Content Feed - Pull'), __('Pull'), $capability, $this->plugin_name.'-feed-edit', array($this, 'render_feed_edit'));
		add_submenu_page(null, __('Content Feed - Push'), __('Push'), $capability, $this->plugin_name.'-push-edit', array($this, 'render_push_edit'));
	}

	/**
	 * Catch the action requests
	 */
	public function catch_actions()
	{
		// Check for actions
		if (isset($_GET['action']) && !empty($_GET['action']))
		{

			$feeds = new Ttcms_Content_Feeds($this->name, $this->version);
			$method = str_replace('-', '_', 'action_' . $_GET['action']);


			if (method_exists($feeds, $method))
			{
				call_user_func(array($feeds, $method));
				die(1);
			}
		}
	}

	/**
	 * Render a template with header and footer
	 *
	 * @param string $template_name
	 * @param string $page_title
	 * @param array  $args
	 */
	private function render($template_name = '', $page_title = '', $args = array())
	{

		extract($args);
		include plugin_dir_path(__FILE__) . 'partials/ttcms-pf-admin-header.php';
		include plugin_dir_path(__FILE__) . 'partials/ttcms-pf-admin-' . $template_name . '.php';
		include plugin_dir_path(__FILE__) . 'partials/ttcms-pf-admin-footer.php';
	}

	/**
	 * Render Page Feeds
	 */
	public function render_feeds()
	{
		// Load libs
		if (!class_exists('WP_List_Table'))
		{
			require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
		}

		// let's load our table list
		require_once plugin_dir_path(__FILE__).'lib/class-ttcms-pf-table-list-feeds.php';
		$table_list = new Ttcms_Content_Table_List(array(
			'plural' => 'Feeds',
			'singular' => 'Feed',
		));
		$table_list->prepare_items();

		// Render our display
		$this->render('feeds', 'XML Feeds', array(
			'feed_table_list' => $table_list
		));
	}

	public function render_feed_edit(){

		require_once plugin_dir_path(__FILE__).'partials/ttcms-pf-admin-basket-edit.php';
		die();

	}


	/**
	 * Add for the PUSH feeds
	 */
	public function add_push()
	{

		// let's load our table list
		require_once plugin_dir_path(__FILE__).'partials/ttcms-pf-admin-push-add.php';
		die();

	}	

	/**
	 * Render Page for the PUSH feeds
	 */
	public function render_push()
	{
		// Load libs
		if (!class_exists('WP_List_Table'))
		{
			require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
		}

		// let's load our table list
		require_once plugin_dir_path(__FILE__).'lib/class-ttcms-pf-table-push-feeds.php';
		$table_list = new Ttcms_Content_Push_List(array(
			'plural' => 'content_pushes',
			'singular' => 'content_push',
		));
		$table_list->prepare_items();

		// Render our display
		$this->render('feeds', 'Push Service', array(
			'feed_table_list' => $table_list
		));
	}

	public function render_push_edit(){

		require_once plugin_dir_path(__FILE__).'partials/ttcms-pf-admin-push-edit.php';
		die();

	}	

	/**
	 * Get Post Type Categories
	 *
	 * This will get the children for the post type, either categories
	 * for one tax or the tax list until we're on the last element.
	 *
	 * @return object $options
	 */
	function ajax_get_post_type_categories()
	{
		$return_title = '';
		$return_select = '';
		$return_single = true;

		$post_type_object = get_post_type_object($_GET['post_type']);
		$taxonomies = get_object_taxonomies($_GET['post_type']);

		if ( isset($_GET['post_taxonomy']) )
		{
			if ( in_array($_GET['post_taxonomy'], $taxonomies) )
			{
				unset($taxonomies);
				$taxonomies = array($_GET['post_taxonomy']);
			}
		}

		if ( count($taxonomies) === 1 )
		{
			$taxonomy_object = get_taxonomy($taxonomies[0]);
			$return_title .= __($post_type_object->labels->singular_name);
			$return_title .= "&nbsp;";
			$return_title .= __($taxonomy_object->labels->singular_name);

			$return_select .= '<input type="hidden" name="planet_taxonomy_parent" value="' . $taxonomy_object->name . '" />';
			$return_select .= wp_dropdown_categories(array(
				'hide_empty'   => 0,
				'name'         => 'planet_category_parent[]',
				'id'           => 'planet_category_parent_select',
				'orderby'      => 'name',
				'hierarchical' => true,
				'taxonomy'     => $taxonomies[0],
				'echo'         => false,
				'multiple'     => ''
			));
		}
		else
		{
			$return_single = false;

			$return_title .= __($post_type_object->labels->singular_name);
			$return_title .= "&nbsp;";
			$return_title .= __('Taxonomy');

			$return_select .= '<select name="planet_taxonomy_parent" style="width: 200px;" id="taxonomy_parent" data-post-type="' . $_GET['post_type'] . '">';
			$return_select .= '<option value="">' . __('None') . '</option>';

			foreach ($taxonomies as $taxonomy)
			{
				if ( !in_array($taxonomy, array('post_format')) )
				{
					$taxonomy_object = get_taxonomy($taxonomy);
					$return_select .= '<option value="' . $taxonomy . '">' . $taxonomy_object->labels->singular_name . '</option>';
				}
			}
			$return_select .= '</select>';
		}

		echo json_encode(array(
			'single' => $return_single,
			'title'  => $return_title,
			'select' => $return_select,
		));
		die(); // this is required to return a proper result
	}

}
