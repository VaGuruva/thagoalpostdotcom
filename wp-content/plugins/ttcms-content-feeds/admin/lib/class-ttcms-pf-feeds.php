<?php

/**
 * Class file for Batches
 */
class Ttcms_Content_Feeds {
	/**
	 * The ID of this plugin.
	 *
	 * @access   private
	 * @var      string $name The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The prefix for the batch files.
	 *
	 * @access   private
	 * @var      string $batch_prefix The prefix for the batch files.
	 */
	private $batch_prefix;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @var      string $name    The name of this plugin.
	 * @var      string $version The version of this plugin.
	 */
	public function __construct( $name, $version ) {
		$this->name    = $name;
		$this->version = $version;

		$site_url           = get_site_url();
		$urlParts           = parse_url( $site_url );
		$this->batch_prefix = str_replace( '.', '', $urlParts['host'] );

	}

	public function get_basket( $section_id ) {
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM feeds where section_id = $section_id " );

		return $results;
	}

	public function get_category( $ttcms_basket_id ) {
		global $wpdb;
		$results = $wpdb->get_results( "SELECT * FROM content_push where ttcms_basket_id = $ttcms_basket_id " );

		return $results;
	}


	/**
	 * Catch the actions generated from the view
	 * Batch ID 448 is gallery type
	 * Batch ID 449 is news type
	 */
	public function action_get_xml_data() {
//		$this->bulk_process_data(4);
//		die('done');

		$batch_id = $_REQUEST['id'];
		$feed     = $this->getFeedXml( $batch_id );
		$this->processFeed( $feed );

		//wp_redirect(admin_url("admin.php?page={$_GET['page']}}&message={$message}"));
	}

	public function action_update_basket() {


		global $wpdb;
		$post_type              = $_REQUEST['planet_post_type'];
		$planet_taxonomy_parent = ( !isset($_REQUEST['planet_taxonomy_parent']) ) ? null
			: $_REQUEST['planet_taxonomy_parent'];
		$post_taxonomies        = ( !isset($_REQUEST['planet_category_parent']) ) ? null
			: serialize( $_REQUEST['planet_category_parent'] );
		$is_active = isset($_REQUEST['planet_is_active']) ? 1 : 0;

		$wpdb->update(
			'feeds',
			array(
				'post_type'          => $post_type,    // string
				'post_taxonomy_type' => $planet_taxonomy_parent,
				'post_taxonomies'    => $post_taxonomies,
				'is_active' => $is_active
			),
			array( 'id' => $_REQUEST['id'] )
		);
		wp_redirect( "admin.php?page=ttcms-pf-feed-edit&id=".$_REQUEST['id'] );


	}

	public function action_add_push() {


		global $wpdb;
		$ttcms_basket_id = ( !isset($_REQUEST['ttcms_id']) ) ? null
			: $_REQUEST['ttcms_id'];
		$name = ( !isset($_REQUEST['name']) ) ? null
			: $_REQUEST['name'];			

		$wpdb->insert(
			'content_push',
			array(
				'name'          => $name,    // string
				'ttcms_basket_id' => $ttcms_basket_id
			)
		);
		wp_redirect( "admin.php?page=ttcms-pf-push-edit&id=".$wpdb->insert_id );


	}	

	public function action_update_push() {


		global $wpdb;
		$post_type              = $_REQUEST['planet_post_type'];

		$planet_taxonomy_parent = ( !isset($_REQUEST['planet_taxonomy_parent']) ) ? null
			: $_REQUEST['planet_taxonomy_parent'];
		$post_taxonomies        = ( !isset($_REQUEST['planet_category_parent']) ) ? null
			: serialize( $_REQUEST['planet_category_parent'] );
		$is_active = isset($_REQUEST['planet_is_active']) ? 1 : 0;

		$wpdb->update(
			'content_push',
			array(
				'post_type'          => $post_type,    // string
				'post_taxonomy_type' => $planet_taxonomy_parent,
				'post_taxonomies'    => $post_taxonomies,
				'active' => $is_active
			),
			array( 'id' => $_REQUEST['id'] )
		);
		wp_redirect( "admin.php?page=ttcms-pf-push" );


	}	

	public function content_feeds( $ttcms_basket_id, $ttcms_article_id, $post_date, $post_updated  ) {
		global $wpdb;
		$result = '';

		$articles = $wpdb->get_row("SELECT 
											*
										FROM 
											content_feeds 
										WHERE 
											ttcms_basket_id = $ttcms_basket_id
										AND
											ttcms_article_id = $ttcms_article_id
										"
								);

		if ( count( $articles ) == 0 ) {
			//+echo 'article is NOT in the database';

			$wpdb->insert(
				'content_feeds',
				array(
					'ttcms_basket_id'   => $ttcms_basket_id, 
					'ttcms_article_id' 	=> $ttcms_article_id,
					'date_created' 		=> $post_date,
					'date_modified' 	=> $post_updated
				)
			);
			
			$result = 'insert';

		} else {
			$row_id = $articles->id;
			//check the for the modified date in the database
			$result = 'select';	


			
			$link = $wpdb->get_row("SELECT 
										date_modified,
										id 
									FROM 
										content_feeds 
									WHERE 
										date_modified != '".$post_updated."'
									AND
										ttcms_article_id = $ttcms_article_id
									AND 
										ttcms_basket_id = $ttcms_basket_id
									");

			if (count($link) > 0) {
				if (@$link->date_modified != $post_updated ) {
					//echo 'Content has to be updated';
					$wpdb->update(
						'content_feeds',
						array(
							'date_modified' => $post_updated
						),
						array( 'id' => $link->id )
					);

					$result = 'update';	
				}
			}
		
		}	

		return $result;
	}	

	public function processFeedSingle( $feed ) {

		global $wpdb;
		$ttcms_basket_id = '';
		$ttcms_article_id = '';
		$attributes 	= '';
		$articles 		= '';

		//$incoming_article = $feed->article->attributes()->basketId;

		$attributes     		= $feed->article->attributes();
		$ttcms_basket_id     	= $attributes->basketId;
		$ttcms_article_id 		= $attributes->id;

		$basket_details 		= $this->get_category( $ttcms_basket_id );
		$post_taxonomies 		= $basket_details[0]->post_taxonomies;
		$mydata 				= unserialize($post_taxonomies);
		$taxonomies 			= $mydata;

		$post_type = $basket_details[0]->post_type;

		//we are going to process the feed 1st to the content_feeds table and make sure that the date and time has not changed for the article
		//if all is fine, continue, otherwise return to the query
		

		if ( isset( $feed->article ) ):
			$article = $feed->article;

				//echo 'BASKET ID:'.$ttcms_basket_id;
				//echo '<pre style="background-color:grey;color:white">'    ;print_r($article);   echo '</pre>';

				$article_attributes = $article->attributes();
				$post               = array(
					'post_title'   => utf8_encode ( $article->title ),
					'post_content' => ( is_array( $article->body ) ) ? '' : $article->body,
					'post_excerpt' => ( is_array( $article->abstract ) ) ? '' : $article->abstract,
					'post_type'    => $post_type,
				);

				$articleType = (string)$article->articleType;

				$post_date         = date( 'Y-m-d H:i:s', strtotime( $article->publish_datetime ) );
				$post_updated      = date( 'Y-m-d H:i:s', strtotime( $article->lastUpdated ) );

				//###############################################################################	

				//process the article to the content_feeds table and return result
				$decide = $this->content_feeds( $ttcms_basket_id, $ttcms_article_id, $post_date, $post_updated );
				$wp_article = $wpdb->get_row("	SELECT 
														id,
														wp_post_id
													FROM 
														content_feeds 
													WHERE 
														ttcms_article_id = $ttcms_article_id
												");


				if ($decide == 'insert')  {

					//check if the article id is already in the database, if it is, just insert the wp_term_relationships
					//print_r($wp_article);
					//echo 'insert';


				} elseif ($decide == 'update') {

					//echo 'update';
					//update the article


				} else {
					//echo 'select';
					return true;

				}

				//###############################################################################

				$media_meta_name   = false;
				$media_attachments = array();
				$is_thumbnail      = false;
				switch ( $articleType ):

					case 'Gallery Story':
						$media_meta_name = 'gallery_image';
						$media_i = 0;
						foreach ( $article->media as $media ):
							foreach ( $media as $m ):
								$size                = $this->get_largest_image( $m['size'] );
								$media_attachments[$media_i]['url'] = $m['url'] . $size . DIRECTORY_SEPARATOR . $m['mediaName'];
								$media_attachments[$media_i]['caption'] = $m['caption'];
								$media_i ++;
							endforeach;
						endforeach;

						break;

					case 'News Story':
					case 'Default':
					case '0':
						$media_i = 0;

						foreach ( $article->media->mediaItem as $media ):

							$size = $this->get_largest_image( (string)$media->size );
							$media_attachments[$media_i]['url'] = $media->url . $size . DIRECTORY_SEPARATOR . $media->mediaName;
							$media_attachments[$media_i]['caption'] = $media->caption;
							$media_i ++;

						endforeach;
						$is_thumbnail = true;
						break;

				endswitch;

				$meta = array( '_ttcms_feed_id' => (int)$article_attributes->id );
				
				//if new
				$post_id = $this->programmatically_create_post( $post, $meta, $media_attachments, $articleType, $post_date,
					$media_meta_name, $is_thumbnail, $taxonomies,'_ttcms_feed_id' );


				//if an update is needed:
				//programmatically_update_post($post, $meta, $media_attachments, $articleType, $post_date, $media_meta_name, $is_thumbnail, $taxonomies_main, $meta_check_field);			

				//echo "POST ID: $post_id";
				if($post_id){
					add_post_meta( $post_id, '_ttcms_basket_id', (int)$ttcms_basket_id, false );
					//$this->link_posts($ttcms_basket_id,$post_id);

				}
				

			return true;
		endif;

		return false;
	}


	public function processFeed( $feed ) {



		$attributes     = $feed['@attributes'];
		$section_id     = $attributes['basketId'];
		$basket_details = $this->get_basket( $section_id );

		$post_type = $basket_details[0]->post_type;
		if( $post_type == '' ){
			$post_type = 'post';
		}

		$post_taxonomies = $basket_details[0]->post_taxonomies;
		$mydata = unserialize($post_taxonomies);
		$taxonomies = $mydata;

		if ( isset( $feed['article'] ) ):
			if(!$this->is_numeric_array($feed['article'])){
				$move = $feed['article'];
				unset($feed['article']);
				$feed['article'][0] = $move;
			}
			foreach ( $feed['article'] as $article ):

				$article_attributes = $article['@attributes'];
				$post               = array(
					'post_title'   => $article['title'],
					'post_content' => ( is_array( $article['body'] ) ) ? '' : $article['body'],
					'post_excerpt' => ( is_array( $article['abstract'] ) ) ? '' : $article['abstract'],
					'post_type'    => $post_type,
				);


				$articleType = ($article['articleType'] =='Default') ? 'News Story' : $article['articleType'];

				$post_date         = date( 'Y-m-d H:i:s', strtotime( $article['lastUpdated'] ) );
				$media_meta_name   = false;
				$media_attachments = array();
				$is_thumbnail      = false;
				$meta = array();
				switch ( $articleType ):

					case 'Gallery Story':
						$media_meta_name = 'gallery_image';
						$media_i = 0;
						foreach ( $article['media'] as $media ):
							foreach ( $media as $m ):
								$size                = $this->get_largest_image( $m['size'] );
								$media_attachments[$media_i]['url'] = $m['url'] . $size . DIRECTORY_SEPARATOR . $m['mediaName'];
								$media_attachments[$media_i]['caption'] = $m['caption'];
								$media_i ++;
							endforeach;
						endforeach;

						break;

					case 'News Story':
						$media_i = 0;

						foreach ( $article['media'] as $media ):
							$size                = $this->get_largest_image( $media['size'] );
							$media_attachments[$media_i]['url'] = $media['url'] . $size . DIRECTORY_SEPARATOR . $media['mediaName'];
							$media_attachments[$media_i]['caption'] = $media['caption'];
							$media_i ++;

						endforeach;
						$is_thumbnail = true;
						break;

					case 'Video':
						$media_i = 0;

							$feature_media = $article['media']['mediaItem']['0'];

							//featured image first
							$size                = $this->get_largest_image( $feature_media['size'] );
							$media_attachments[$media_i]['url'] = $feature_media['url'] . $size . DIRECTORY_SEPARATOR . $feature_media['mediaName'];
							$media_attachments[$media_i]['caption'] = $feature_media['caption'];
							$is_thumbnail = true;



							if(isset($article['media']['mediaItem'][1])){
								$video_code = $article['media']['mediaItem'][1]['mediaName'];
								$meta['video_code'] = $video_code;
							}

						if( $post['post_content'] == '' ){
							$post['post_content'] = $post['post_excerpt'];
						}

							break;

				endswitch;

				$meta['_planetf1_feed_id'] = $article_attributes['id'];


				$post_id = $this->programmatically_create_post( $post, $meta, $media_attachments, $articleType, $post_date,$media_meta_name, $is_thumbnail, $taxonomies,'_planetf1_feed_id' );


				if($post_id){



					$basket_meta = get_post_meta($post_id,'_planetf1_basket_id',false);
					if(!in_array($section_id,$basket_meta)){
						add_post_meta( $post_id, '_planetf1_basket_id', $section_id, false );
					}


					if($articleType == 'Video'){
						wp_set_post_terms( $post_id, 'video', 'content_type' );
					}
					if($articleType == 'Gallery Story'){
						wp_set_post_terms( $post_id, 'gallery', 'content_type' );
					}


					$this->link_posts($section_id,$post_id);

					$term_list = wp_get_post_terms($post_id, 'content_type', array("fields" => "names"));

					if(count($term_list) == 0){
						wp_set_post_terms( $post_id, 'news', 'content_type' );
					}

				}


			endforeach;
		return true;
		endif;

		return false;
	}

	public function link_posts($basket_id,$post_id){
		global $wpdb;
		$link_types = array('circuit');

		//this only works for circuits
		foreach($link_types as $post_type):

			$link = $wpdb->get_row("SELECT * FROM planetf1_feeds_link_".$post_type." WHERE basket_id = {$basket_id}");
			if(!isset($link->basket_type))
				continue;

			$post = get_posts(array(
				'post_type' => array('circuit','event','driver'),
				'orderby' => 'modified',
				'posts_per_page' => 1 ,
				'post_status' => 'publish',
				'meta_query' => array(
					array(
						'key'     => '_planetf1_data_id',
						'value'   => $link->data_id,
					),
				),
			));

			if( $post[0]  ){
				//echo 'LINKING CIRCUIT '.$link->basket_type;

//				update_post_meta($post_id,$post_type.'_id',$post[0]->ID,true);
				$meta = get_post_meta($post_id,$post_type.'_id',false);
				if(!in_array($post[0]->ID,$meta)){
					add_post_meta($post_id,$post_type.'_id',$post[0]->ID);
				}
				wp_set_post_terms( $post_id, $link->basket_type, 'content_type' );

			}

		endforeach;

	}

	public function programmatically_create_post(
		$post, $meta, $media_attachments, $articleType, $post_date, $media_meta_name, $is_thumbnail, $taxonomies_main, $meta_check_field
	) {

		// Initialize the page ID to -1. This indicates no action has been taken.
		$post_id = - 1;

		// Setup the author, slug, and title for the post
		$author_id = 1;

		$title = sanitize_title( $post['post_title'] );
		// If the page doesn't already exist, then create it
		global $wpdb;
		$results
			= $wpdb->get_results( "select post_id from $wpdb->postmeta where meta_key = '{$meta_check_field}' AND meta_value = '".$meta[$meta_check_field]."'",
			ARRAY_A );

		if ( count( $results ) == 0 ) {
		//if ( count( $results ) > 1 ) { 

			// Set the post ID so that we know the post was created successfully
			$post['comment_status'] = 'closed';
			$post['ping_status']    = 'closed';
			$post['post_author']    = $author_id;
			$post['post_status']    = 'publish';
			$post['post_name']      = $title;
			//$post['tags_input']     = $articleType; //removed due to us using content_type instead
			$post['post_date']      = $post_date;

			$post_id = wp_insert_post( $post );
			if ( $post_id ):


				foreach ( $meta as $m_key => $m_val ):
					add_post_meta( $post_id, $m_key, $m_val, true );
				endforeach;

				if ( $media_meta_name == 'gallery_image' ):
					set_post_format( $post_id, 'gallery' );
				endif;

				$count = 1;
				foreach ($taxonomies_main as $mydata) {
					echo $count; 
					$taxonomies = array(
                    					"category"=>(int)$mydata
										);

	           	 	foreach ($taxonomies as $t_key => $t_val):

	           	 		//echo $t_key;
	           	 		//echo $t_val;
		               wp_set_object_terms($post_id, $t_val, $t_key, true);
	           	 	endforeach;
	           	 	$count++;
	           	 }	

				$this->migrate_attachments($media_attachments, $post_id, $post_date, $media_meta_name, $is_thumbnail);

			endif;
			// Otherwise, we'll stop
		} else { //exists

			$post_id = $results[0]['post_id'];
				$count = 1;
				foreach ($taxonomies_main as $mydata) {
					echo $count; 
					$taxonomies = array(
                    					"category"=>(int)$mydata
										);

	           	 	foreach ($taxonomies as $t_key => $t_val):

	           	 		//echo $t_key;
	           	 		//echo $t_val;
		               wp_set_object_terms($post_id, $t_val, $t_key, true);
	           	 	endforeach;
	           	 	$count++;
	           	 }				


		} // end if

		return $post_id;

	}

	public function migrate_attachments( $attachments, $post_id, $post_date, $meta_type, $is_thumbnail ) {


		$wp_upload_dir = wp_upload_dir();

		foreach ( $attachments as $attachment ) {
			//echo $attachment . '<br/>';

			$year  = date( 'Y', strtotime( $post_date ) );
			$month = date( 'm', strtotime( $post_date ) );

			if ( ! is_dir( $wp_upload_dir['basedir'] . '/' . $year ) ) {
				mkdir( $wp_upload_dir['basedir'] . '/' . $year );
			}

			if ( ! is_dir( $wp_upload_dir['basedir'] . '/' . $year . '/' . $month ) ) {
				mkdir( $wp_upload_dir['basedir'] . '/' . $year . '/' . $month );
			}


			$file_path  = $attachment['url'];
			$file_name  = basename( $file_path );
			$new_path   = $wp_upload_dir['basedir'] . '/' . $year . '/' . $month;
			$new_url    = $wp_upload_dir['baseurl'] . '/' . $year . '/' . $month;

			if ( $_SERVER['SERVER_NAME'] == 'eatout.new' ) {
				$local_server = 'eatout.new';
			} else {
				$local_server = 'eatout.co.za.onnet.it';
			}


			$local_file = str_replace( 'http://eatout.co.za', '..', $attachment['url'] );
			//echo $local_file.'<br/>';
//			if ( @file_exists( $local_file ) ) {
			if ( 1 == 2 ) {

				//echo 'EXISTS LOCALLY '.$file_path .'<br />';
//				$file_type			= wp_check_filetype( $file_name );
//				$new_attachment = array(
//					'guid'				=> $new_url . '/'. _wp_relative_upload_path( $file_name ),
//					'post_mime_type'	=> $file_type['type'],
//					'post_title'		=> preg_replace('/\.[^.]+$/', '', $file_name ),
//					'post_content'		=> '',
//					'post_excerpt'		=> '',
//					'post_status'		=> 'inherit'
//				);
//				$attach_id		= wp_insert_attachment( $new_attachment, $new_path . '/'. $file_name, $post_id );
//				$attach_data	= wp_generate_attachment_metadata( $attach_id, $file_name );
//				wp_update_attachment_metadata( $attach_id, $attach_data );
//


			} else {


				$attachment_file = file_get_contents( $file_path );
				$file_type       = wp_check_filetype( $file_name );
				$caption = (string)$attachment->caption;
				$new_full_path = $new_path . '/' . $file_name;
				if ( file_put_contents( $new_path . '/' . $file_name, $attachment_file ) ) {

					$new_attachment = array(
						'guid'           => $new_url . '/' . _wp_relative_upload_path( $file_name ),
						'post_mime_type' => $file_type['type'],
						'post_title'     => preg_replace( '/\.[^.]+$/', '', $file_name ),
						'post_content'   => '',
						'post_excerpt'   => '',
						'post_status'    => 'inherit'
					);
					$attach_id      = wp_insert_attachment( $new_attachment, $new_path . '/' . $file_name, $post_id );
					$attach_data    = wp_generate_attachment_metadata( $attach_id, $new_full_path );
					wp_update_attachment_metadata( $attach_id, $attach_data );

					if($attach_id && !is_array((string)$attachment->caption) ){
						add_post_meta($attach_id,'caption',(string)$attachment->caption);
					}

				}

			}

			if ( $attach_id && $meta_type ) {
				add_metadata( 'post', $post_id, $meta_type, $attach_id );
			}

			if ( $is_thumbnail ) {
				set_post_thumbnail( $post_id, $attach_id );
			}
		}
	}

	public function get_largest_image( $sizes ) {

		if(!is_array($sizes))
			return '1024x768';
			//return '700x367';
		//700x367

		$new_sizes = array();
		foreach ( $sizes as $size ):

			$x                            = explode( 'x', $size );
			$new_sizes[ array_sum( $x ) ] = $x;

		endforeach;
		$max_size_key = max( array_keys( $new_sizes ) );

		return join( 'x', $new_sizes[ $max_size_key ] );


	}


	public function get_post_id_from_planet_data_id($data_id,$post_type){
				global $wpdb;
				$result = $wpdb->get_results("SELECT ID, post_title FROM wp_posts p
				INNER JOIN wp_postmeta m
				ON m.post_id = p.ID
				AND meta_value = $data_id
				AND meta_key = '_planetf1_data_id'
				AND post_type = '{$post_type}'");

				if(isset($result[0]))
					return $result[0]->ID;
				else
					return false;

	}

	public function action_dedupe_meta(){
		global $wpdb;
		$dupes = $wpdb->get_results('select *, count(*) as NUM_DUPES from wp_postmeta group by post_id, meta_key,meta_value having count(*) > 1');

		if (count($dupes) == 0)
			return true;
		foreach ($dupes as $dupe) {
			 $wpdb->query('delete from wp_postmeta where post_id = ' . $dupe->post_id . ' and meta_key = "' . $dupe->meta_key . '"  and meta_value = ' . $dupe->meta_value . ' limit ' . ($dupe->NUM_DUPES - 1));
		}
		die('Done deleting duplicate meta.');
	}

	public function is_numeric_array($array){
		foreach (array_keys($array) as $a){
			if (!is_int($a)) {
				return false;
			}
		}
		return true;
	}

}

