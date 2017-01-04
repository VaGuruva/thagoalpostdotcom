<?php

class Ttcms_Content_Push_List extends WP_List_Table
{
	/**
	 * Message Transient Prefix
	 * @var string
	 */
	var $message_transient_prefix = '_pf_feeds_messages_';

	var $items = array();
	var $_column_headers = array();
	var $_status_to_show = 'all';
	var $_statuses = array(
		'01' => 'Successful',
		'02' => 'Pending',
		'03' => 'Failed'
	);

	/**
	 * Create and instance of this list table.
	 */
	public function __construct()
	{
		parent::__construct(array(
			'singular' => 'content_push',
			'plural'   => 'content_pushes',
			'ajax'     => false
		));

//		$this->process_actions();
	}

	/**
	 * Output any messages set on the class
	 */
	protected function messages()
	{
		if (isset($_GET['message']))
		{
			$all_messages = get_transient($this->message_transient_prefix . $_GET['message']);

			if (!empty($all_messages))
			{
				delete_transient($this->message_transient_prefix . $_GET['message']);

				if (!empty($all_messages['messages']))
				{
					echo '<div id="moderated" class="updated"><p>' . implode("<br/>\n", $all_messages['messages']) . '</p></div>';
				}

				if (!empty($all_messages['error_messages']))
				{
					echo '<div id="moderated" class="error"><p>' . implode("<br/>\n", $all_messages['error_messages']) . '</p></div>';
				}
			}
		}
	}

	public function get_columns()
	{
		$columns = array(
			'id'            => __('Id'),
			'name'      => __('Name'),			
			'active'            => __('Is Active'),
			'ttcms_basket_id'      => __('Section'),
			'post_taxonomy_type'       => __('Taxonomy Type'),
			'post_taxonomies'       => __('Taxonomies'),
			'actions'       => __('Actions')

		);

		return $columns;
	}

	public function no_items()
	{
		_e('No bacthes found.');
	}

	/**
	 * Get an associative array ( id => link ) with the list
	 * of views available on this table.
	 *
	 * @return array
	 */
	public function get_views()
	{
		// Let's get our counts
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM content_push");
		
		$screen = get_current_screen();
		$base_url = add_query_arg('page', $screen->parent_base, admin_url('admin.php'));

		$total_count = 0;
		$statuses = array();

	}

	public function __set( $name, $value ) {
		return $this->$name = $value;
	}

	/**
	 * Get, sort and filter subscriptions for display.
	 *
	 * @uses $this->_column_headers
	 * @uses $this->items
	 * @uses $this->get_columns()
	 * @uses $this->get_sortable_columns() FUTURE
	 */
	public function prepare_items()
	{
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->_status_to_show = (isset($_GET['status'])) ? $_GET['status'] : 'all';
		$this->items = $this->get_data();
	}

	/**
	 * Get the list data
	 *
	 * @return mixed
	 * 
	 * Content Feeds page display list
	 */
	protected function get_data()
	{
		global $wpdb;


		// Conditions
		$where_conditions = array();
		if ($this->_status_to_show != 'all')
		{
			if (isset($this->_statuses[$this->_status_to_show]))
			{
				$where_conditions[] = " {$wpdb->payudo_batches}.batch_status = '{$this->_status_to_show}' ";
			}
		}
		$where_conditions = implode(' AND ', $where_conditions);
		$where_conditions = !empty($where_conditions) ? 'AND ' . $where_conditions : '';

		// Query
		$results = $wpdb->get_results("SELECT *
		FROM content_push
		WHERE 1
		{$where_conditions}
		 ORDER BY name ASC");

		return $results;
	}

	/**
	 * Checkbox Column
	 *
	 * @param $item
	 *
	 * @return mixed
	 */
	protected function column_cb($item)
	{
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/
			$this->_args['singular'],
			/*$2%s*/
			$item->id
		);
	}

	/**
	 * Checkbox Column
	 *
	 * @param $item
	 *
	 * @return mixed
	 */
	protected function column_active($item)
	{
		 $is_active = ($item->active) ? 'checked' : '';
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" %3$s />',
			/*$1%s*/
			$this->_args['singular'],
			/*$2%s*/
			1,
			$is_active
		);
	}

	protected function column_post_taxonomies($item){
		$terms =  @unserialize($item->post_taxonomies);
		$term_text = NULL;
		if(is_array($terms)):
			foreach($terms as $term):
				$t = get_term( $term, $item->post_taxonomy_type);
				$term_text .= $t->name.'<br/>';
			endforeach;
		endif;
		return $term_text;

	}

	/**
	 * Format the currency
	 *
	 * @param $item
	 *
	 * @return string
	 */
	protected function column_batch_total($item)
	{
		return 'R ' . number_format($item->batch_total / 100, 2, ".", " ");
	}

	/**
	 * Format the transaction date
	 *
	 * @param $item
	 *
	 * @return string|void
	 */
	protected function column_process_date($item)
	{
		return __(date(get_option('date_format'), strtotime($item->process_date)));
	}


	/**
	 * Show row actions
	 *
	 * @param $item
	 *
	 * @return string/void
	 */
	protected function column_actions($item)
	{

		$actions = array();
		$screen = get_current_screen();
		$base_url = add_query_arg('page', $screen->parent_base, admin_url('admin.php'));
		$link = '<a href="%1$s" class="%3$s" title="%4$s">%2$s</a>';


		// View Transactions
		$actions[] = sprintf($link,
			add_query_arg('id', $item->id, add_query_arg('page', 'ttcms-pf-push-edit', admin_url('admin.php'))),
			'<span class="dashicons dashicons-edit"></span>',
			'button icon-button',
			__('Edit the Push Feed'));

		return implode('', $actions);
	}

	/**
	 * Show row status
	 *
	 * @param $item
	 *
	 * @return string/void
	 */
	protected function column_status($item)
	{
		$icon = '<span class="omb-icon-%1$s icon-%2$s icon-status" title="%3$s"></span>';
		switch ($item->batch_status)
		{
			case '01':
				return sprintf($icon, 'checked', 'green', $this->_statuses[$item->batch_status]);
				break;
			case '02':
				return sprintf($icon, 'minus2', 'orange', $this->_statuses[$item->batch_status]);
				break;
			case '03':
				return sprintf($icon, 'error', 'red', $this->_statuses[$item->batch_status]);
				break;
			default:
				return '?';
				break;

		}
	}

	/**
	 * Show row results
	 *
	 * @param $item
	 *
	 * @return string/void
	 */
	protected function column_results($item)
	{
		return '<span class="description">'.__('No results yet').'</span>';
	}

	/**
	 * Display default column data
	 *
	 * @param $item
	 * @param $column_name
	 *
	 * @return mixed
	 */
	protected function column_default($item, $column_name)
	{
		return $item->$column_name;
	}

}
