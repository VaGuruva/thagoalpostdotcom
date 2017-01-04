<?php
class opinion_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'opinion_widget', // Base ID
			'[Home] Opinion Widget', // Name
			array( 'description' => 'Opinion Widget', ) // Args
		);
	}

	public function widget( $args, $instance ) {
		global $wpdb;
		$title = apply_filters( 'widget_title', $instance['title'] );
		$opinion_args = array(
			'post_status' => 'publish',			
            'posts_per_page'=> 5,
			'offset'=>0,
			'orderby' => 'date',
			'order' => 'DESC',
            'meta_key' => '_thumbnail_id',
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => 'opinion',
				),
			),
		);

        $opinion = new WP_Query($opinion_args);
        ?>
        <!-- Opinion -->
        <div class="widget">
            <header class="widget__header">
                <h3><?php echo $title; ?></h3>
            </header>
            <section class="widget__body--noExpand featured-news-widget opinion-widget">
                <ul class="articleList__list">
                    <?php while ($opinion->have_posts()) : $opinion->the_post(); ?>
                        <li class="articleList__item">
                            <figure class="articleList__figure" style="position: relative;">
                                <a href="<?php the_permalink() ?>">
                                <span class="articleList__imgWrapper">
                                    <?php //echo get_the_post_thumbnail(null,'editorspick'); ?>
                                    <?php
                                    echo fly_get_attachment_image( get_post_thumbnail_id(), array( 50, 50  ),array('center','top'));
                                    ?>                                       
                                </span>
                                </a>
                                <figcaption class="articleList__figcaption">
                                    <span><a><?php the_field('author_opinion'); ?></a></span>
                                    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                </figcaption>
                            </figure>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <div class="more-news-link">
                    <a href="">More <i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            </section>
        </div>
        <!-- End Opinion -->

    <?php
    }


	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
		?>
		<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */

	public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

			return $instance;
	}

}

	add_action( 'widgets_init', function(){register_widget( 'opinion_widget' );});
?>
