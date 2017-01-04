<?php

class data_small_tables_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'data_small_tables_widget', // Base ID
                '[Main Menu] Small Tables: Widget', // Name
                array('description' => 'Small Tables',) // Args
        );
    }

    public function widget($args, $instance) {
        $football_data = new Football_Data();
        $year = date("Y") - 1;
        $slug = get_category_slug(!empty($args["is_team"]) ? 4 : 3);

        $competition_logs = array();
       //$competition_id = 9;//get_field_id($slug, !empty($args["is_team"]));
        $competition_id = get_competition_id();  

        $competition = $football_data->competitions_by_data(array(
            "id" => $competition_id,
        ));
        ?>

        <?php foreach (range($year - 4, $year) as $seasonId): ?>
            <?php
            $competition_logs = $football_data->logs_by_data(array(
                "competition_id" => $competition->competition_id,
                "season_id" => $seasonId
            ));

            $c = $football_data->competitions_by_data(array(
                "id" => $competition_id,
            ));
            ?>
            <?php if (!empty($c->season_name) && count($competition_logs)): ?>
                <!-- Smaller Tables Container -->
                <div class="col-md-6 small-table">
                    <header class="articleList__header tables-header">
                        <h3><?php echo $c->competition_name ?> <?php echo str_replace("Season ", "", $c->season_name) ?></h3>
                    </header>

                    <div class="article article-table">
                        <!-- Smaller Tables / Logs -->
                        <table class="tables-table" cellpadding="10" cellspacing="10">
                            <tr class="tables-table-header">
                                <th>POS</th>
                                <th class="table-club">CLUB</th>
                                <th>P</th>
                                <th>W</th>
                                <th>D</th>
                                <th>L</th>
                                <th>GD</th>
                                <th>PTS</th>
                            </tr>
                            <?php foreach ($competition_logs as $key => $log): ?>
                                <?php if ($key > 4) break; ?>
                                <tr>
                                    <td><?php echo $log->position ?></td>
                                    <td class="table-club"><?php echo $log->team->team_name ?></td>
                                    <td><?php echo $log->played ?></td>
                                    <td><?php echo $log->won ?></td>
                                    <td><?php echo $log->drawn ?></td>
                                    <td><?php echo $log->lost ?></td>
                                    <td><?php echo $log->fors - $log->against ?></td>
                                    <td><?php echo $log->points ?></td>
                                </tr>                        
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- End Smaller Tables Container -->
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
    register_widget('data_small_tables_widget');
});
?>
