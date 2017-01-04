<?php


class Ttcms_Content_Base_Core_Setup_Posts {

	function register_default_post_type(){

		$labels = array(
			'name_admin_bar' => _x( 'News', 'add new on admin bar' ),
		);

		$args = array(
			'labels' => $labels,
			'public'  => true,
			'show_ui'  => true,
			'_builtin' => false,
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => false,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'news' ),
			'query_var' => false,
			'supports' => array( 'title', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'post-formats' ),
		);
		//register_post_type( 'post', $args );


	}

	function taxonomy_event_type() {

		$labels = array(
			'name'                       => _x( 'Event Types', 'Taxonomy General Name', 'ttcms' ),
			'singular_name'              => _x( 'Event Type', 'Taxonomy Singular Name', 'ttcms' ),
			'menu_name'                  => __( 'Event Type', 'ttcms' ),
			'all_items'                  => __( 'Event Type', 'ttcms' ),
			'parent_item'                => __( 'Parent Event Type', 'ttcms' ),
			'parent_item_colon'          => __( 'Parent Event Type:', 'ttcms' ),
			'new_item_name'              => __( 'New Event Type', 'ttcms' ),
			'add_new_item'               => __( 'Add New Event Type', 'ttcms' ),
			'edit_item'                  => __( 'Edit Event Type', 'ttcms' ),
			'update_item'                => __( 'Update Event Type', 'ttcms' ),
			'separate_items_with_commas' => __( 'Separate Event Type with commas', 'ttcms' ),
			'search_items'               => __( 'Search Event Type', 'ttcms' ),
			'add_or_remove_items'        => __( 'Add or remove Event Type', 'ttcms' ),
			'choose_from_most_used'      => __( 'Choose from the most used Event Type', 'ttcms' ),
			'not_found'                  => __( 'Not Found', 'ttcms' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'event_type', array( 'event' ), $args );

	}

	function taxonomy_content_type() {

		$labels = array(
			'name'                       => _x( 'Content Types', 'Taxonomy General Name', 'ttcms' ),
			'singular_name'              => _x( 'Content Type', 'Taxonomy Singular Name', 'ttcms' ),
			'menu_name'                  => __( 'Content Type', 'ttcms' ),
			'all_items'                  => __( 'Content Type', 'ttcms' ),
			'parent_item'                => __( 'Parent Content Type', 'ttcms' ),
			'parent_item_colon'          => __( 'Parent Content Type:', 'ttcms' ),
			'new_item_name'              => __( 'New Content Type', 'ttcms' ),
			'add_new_item'               => __( 'Add New Content Type', 'ttcms' ),
			'edit_item'                  => __( 'Edit Content Type', 'ttcms' ),
			'update_item'                => __( 'Update Content Type', 'ttcms' ),
			'separate_items_with_commas' => __( 'Separate Content Type with commas', 'ttcms' ),
			'search_items'               => __( 'Search Content Type', 'ttcms' ),
			'add_or_remove_items'        => __( 'Add or remove Content Type', 'ttcms' ),
			'choose_from_most_used'      => __( 'Choose from the most used Content Type', 'ttcms' ),
			'not_found'                  => __( 'Not Found', 'ttcms' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'content_type', array( 'post' ), $args );

	}



	function planet_custom_columns( $column ) {
		global $post;

		switch ( $column ) {

			case 'planet_feed_id':

				echo	get_post_meta($post->ID,'_planetf1_feed_id',true);

			break;


			case 'planet_baskets' :
				$baskets = get_post_meta($post->ID,'_planetf1_basket_id');

				if($baskets)
					foreach($baskets as $b){
						echo '<p>'.$b.'</p>';
					}

			break;

			case 'driver' :
				$driver_id = get_post_meta($post->ID,'driver_id');

				if($driver_id)
					foreach($driver_id as $d){
						echo '<p>'.get_the_title($d).'</p>';
					}

				break;

			case 'team' :
				$team_id = get_post_meta($post->ID,'team_id','true');
				if($team_id)
					echo get_the_title($team_id);
			break;

			case 'circuit' :
				$circuit_id = get_post_meta($post->ID,'circuit_id','true');
				if($circuit_id)
					echo get_the_title($circuit_id);

			break;
			case 'season' :
				$season = get_post_meta($post->ID,'circuit_season');

				if($season)
					foreach($season as $d){
						echo '<p>'.$d.'</p>';
					}

			break;
		}
	}

	function planet_register_meta_boxes( $meta_boxes )
	{

		$prefix = '';

		//POSTS
		$meta_boxes[] = array(
			'id' => 'general',
			'title' =>'General',
			'pages' => array('post'),
			'context' => 'normal',
			'priority' => 'high',
			'autosave' => true,
			'fields' => array(
				array(
					'name' => "Link",
					'id'   => "{$prefix}planet_link",
					'type' => 'text',
					'std'  => '',
				)

			)


		);


		return $meta_boxes;
	}

	function plugin_add_meta_box() {

		$screens = array( 'team' );

		foreach ( $screens as $screen ) {

			add_meta_box(
				'planet_team_select',
				__( 'Drivers', 'planet' ),
				array($this,'planet_meta_box_callback'),
				$screen
			);
		}
	}

	function planet_meta_box_callback( $post ) {

		wp_nonce_field( 'planet_meta_box', 'planet_meta_box_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$driver_ids = get_post_meta( $post->ID, 'driver_id' );

		$teams_args = array(
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
			'posts_per_page' => -1,
			'post_type' => 'driver',

		);
		$teams = new WP_Query($teams_args);

		$i=1;
		foreach($driver_ids as $d){

			$team_options = null;
			while ($teams->have_posts()) : $teams->the_post();
				$selected = (get_the_ID() == $d) ? 'selected="selected"' : null;
				$team_options .= '<option '.$selected.' value="'.get_the_ID().'">'.get_the_title().'</option>';
			endwhile;

			echo '<p><label for="planet_driver_id_'.$d.'">';
			_e( 'Driver '. $i, 'planet' );
			echo '</label> ';
			echo '<select name="planet_driver_ids['.$i.']">'.$team_options.'</select></p>';
			$i ++;
		}


	}

	function planet_save_meta_box_data( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['planet_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['planet_meta_box_nonce'], 'planet_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */

		delete_post_meta($post_id,'driver_id');

		foreach($_REQUEST['planet_driver_ids'] as $d){
			add_post_meta($post_id,'driver_id',$d);
			update_post_meta($d,'team_id',$post_id);
		}

	}

}
