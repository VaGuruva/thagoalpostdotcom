<?php


class sport_tables_fixtures_results_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'sport_tables_fixtures_results_widget', // Base ID
            '[Sidebar] Multiple Sports Tables, Fixtures and Results Widget', // Name
            array('description' => 'Multiple Sports Tables, Fixtures and Results Widget',) // Args
        );
    }

    function widget($args, $instance){
        require_once "../partials/cricket.html";
    }
}


add_action('widgets_init', function () {
    register_widget('sport_tables_fixtures_results_widget');
});

?>
