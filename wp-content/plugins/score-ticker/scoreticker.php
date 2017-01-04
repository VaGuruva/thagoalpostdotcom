<?php
/**
 * Plugin Name: Score Ticker Widget
 */
class scoreticker_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'scoreticker_widget', // Base ID
            'Score ticker for the header', // Name
            array( 'description' => 'Score ticker for the header', ) // Args
        );
    }

    function scoreticker_widget(){
        $widget_ops = array('classname' => 'scoreticker_widget', 'description' => 'Score Ticker Widget' );
        $this->WP_Widget('scoreticker_widget', 'Score Ticker Widget', $widget_ops);
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Latest Scores', 'text_domain' );

?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

    function widget($args, $instance){
        require_once "public/widget.view.php";
    }
}


require_once 'public/lib/class-live-data.php';
/**
 * Enqueue scripts
 */
function enqueue_scoreticker_scripts() {
    wp_enqueue_script( 'moment.min.js',plugins_url( '/public/scripts/moment.min.js' , __FILE__ ), array(), '1.0.0', true );
    wp_enqueue_script( 'dropdown-bootstrap3',plugins_url( '/public/scripts/dropdown-bootstrap3.js' , __FILE__ ), array(), '1.0.0', true );
    wp_enqueue_script( 'scoreticker-script',plugins_url( '/public/scripts/script.js' , __FILE__ ), array(), '1.0.5', true );
}

add_action( 'wp_enqueue_scripts', 'enqueue_scoreticker_scripts', 20 );


//handle the custom URL to fetch the XML
function my_custom_url_handler() {
    if ((strpos($_SERVER["REQUEST_URI"], "/score/") !== false)) {
      $data = new LiveData();
      require_once('public/theme/score.php');
      exit();
   }
}
add_action('parse_request', 'my_custom_url_handler');


add_action('widgets_init', function () {
    register_widget('scoreticker_widget');
});