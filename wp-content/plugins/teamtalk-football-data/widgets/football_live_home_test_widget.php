<?php

class football_live_home_test_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'football_live_home_test_widget', // Base ID
                'Football Live Home Widget', // Name
                array('description' => 'Football Live Home Widget',) // Args
        );
    }

    public function widget($args, $instance) {
        ?>
        <?php
        $API_OPTIONS =  get_option('teamtalk_football_data_api_settings');
        $API_URL = trim($API_OPTIONS['football_data_api_url']);
        $API_USR = trim($API_OPTIONS['football_data_api_username']);
        $API_PWD = trim($API_OPTIONS['football_data_api_password']);
        ?>

        <input id="api_url" type="hidden" value="<?php echo $API_URL ?>" />
        <input id="api_usr" type="hidden" value="<?php echo $API_USR ?>" />
        <input id="api_pwd" type="hidden" value="<?php echo $API_PWD ?>" />
        <input id="comp_id" type="hidden" value="<?php echo get_competition_id() ?>" />
        <input id="templateDirectory" type="hidden" value="<?php echo get_template_directory_uri(); ?>" />

        <div class="live-home">
            <div class="no-data" style="text-align: center; padding:10px">There are currently no live matches today</div>
        </div>
        <?php
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('New title', 'text_domain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
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
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

        return $instance;
    }

}

add_action('widgets_init', function() {
    register_widget('football_live_home_test_widget');
});
?>
