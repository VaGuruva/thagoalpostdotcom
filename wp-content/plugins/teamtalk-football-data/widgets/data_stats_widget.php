<?php

class data_stats_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'data_stats_widget', // Base ID
                'Stats Widget', // Name
                array('description' => 'Stats Widget',) // Args
        );
    }

    public function widget($args, $instance) {
        $football_data = new Football_Data();
        $competition_id = get_field_id();

        $top_scorers = $football_data->actions_by_data(array(
            "competition_id" => $competition_id,
            "season_id" => 2015,
            "event" => "goal"
        ));

        $top_yellow_cards = $football_data->actions_by_data(array(
            "competition_id" => $competition_id,
            "season_id" => 2015,
            "event" => "yellow"
        ));

        $top_red_cards = $football_data->actions_by_data(array(
            "competition_id" => $competition_id,
            "season_id" => 2015,
            "event" => "red"
        ));

        $stats_handle = array();
        $stats_handle["TOP SCORERS"] = $top_scorers;
        $stats_handle["YELLOW CARDS"] = $top_yellow_cards;
        $stats_handle["RED CARDS"] = $top_red_cards;
        ?>

        <!-- Nav tabs -->
        <ul class="row nav nav-tabs responsive" role="tablist">
            <li class="col-md-4 col-sm-4 active">
                <a href="#top_scorers" aria-controls="teams" role="tab"  data-toggle="tab">TOP SCORERS</a>
            </li>
            <li class="col-md-4 col-sm-4">
                <a href="#yellow_cards" aria-controls="commentary" role="tab"  data-toggle="tab">YELLOW CARDS</a>
            </li>
            <li class="col-md-4 col-sm-4">
                <a href="#red_cards" aria-controls="stats" role="tab" data-toggle="tab">RED CARDS</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content responsive">

            <?php foreach ($stats_handle as $key => $stats): ?>
                <!-- Stats - <?php echo $key ?> -->

                <div role="tabpanel" class="tab-pane fade in <?php echo $key == "TOP SCORERS" ? "active" : "" ?>" id="<?php echo strtolower(str_replace(" ", "_", $key)) ?>">
                    <div class="stats-date"><?php echo $key ?></div>
                    <table class="tables-table" cellpadding="10" cellspacing="10">
                        <?php foreach ($stats as $k => $player): ?>
                            <?php if ($k == 0): ?>
                                <tr class="tables-table-header">
                                    <th>POS</th>
                                    <th class="table-club">PLAYER</th>
                                    <th class="table-club">TEAM</th>
                                    <th>TOTAL</th>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <td><?php echo $k + 1 ?></td>
                                <td class="table-club"><?php echo $player->player_name ?></td>
                                <td class="table-club"><?php echo $player->team_name ?></td>
                                <td><?php echo $player->count ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($stats) == 0): ?>
                            <tr>
                                <td colspan="4">There are currently no <?php echo strtolower($key) ?> data</td>
                            </tr>
                        <?php endif; ?> 
                    </table>
                </div>
            <?php endforeach; ?>
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

add_action('widgets_init', function () {
    register_widget('data_stats_widget');
});
?>