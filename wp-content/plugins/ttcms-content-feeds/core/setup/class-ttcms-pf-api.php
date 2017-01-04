<?php

class Ttcms_Content_Base_Core_Setup_Api_Feed {

	function planet_api_init() {
		global $planet_api_feed;

		$planet_api_feed = new Ttcms_Content_Base_Core_Setup_Api_Feed();
		add_filter( 'json_endpoints', array( $planet_api_feed, 'register_routes' ) );
	}

	public function register_routes( $routes ) {

		$routes['/ttcms/content'] = array(
			array( array( $this, 'process_content'), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_RAW ),
		);
		
		return $routes;
	}

	public function process_content($data) {
		$raw_data = wp_unslash($data);
		
		if(substr($data,0,5) == 'data='){
			$data = str_replace('data=','',$data);
		}else{
			//exit();
		}

		
		$xml 			= simplexml_load_string(urldecode($raw_data),null,LIBXML_NOCDATA);
		$feeds_class 	= new Ttcms_Content_Feeds('feeds',1);
		$json  			= json_encode( $xml );
		$array 			= json_decode( $json, true );
		$array 			= $xml;
		$upload_dir 	= wp_upload_dir();
		$directory   	= $upload_dir['basedir'].'/'.'feeds/content';
		$raw_filename   = trailingslashit( $directory ) . time().'_raw_content.xml';

		if (!file_exists($directory)) {
			mkdir($directory, 0777, true);
		}
		
		file_put_contents( $raw_filename, $raw_data, FILE_APPEND | LOCK_EX);
		
		$response = array('success'=>TRUE,'message'=>'Push Success');
		$response = json_ensure_response( $response );
		
		$feeds_class->processFeedSingle( $xml );

		return $response;

	}


}

