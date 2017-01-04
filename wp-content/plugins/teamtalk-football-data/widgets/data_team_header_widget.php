<?php

class data_team_header_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'data_team_header_widget', // Base ID
                'Team Header Widget', // Name
                array('description' => 'Team Header Widget') // Args
        );
    }

    public function widget($args, $instance) {

        $previous_fixture = array();
        $next_fixture = array();
        $slug = get_category_slug(4);
        $team_id = get_team_id($slug);

        if (!empty($team_id)) {
            $football_data = new Football_Data();

            $team = $football_data->teams_by_data(array(
                "team_id" => $team_id
            ));

            if (!empty($team->team_id)) {
                $football_data = new Football_Data();

                $previous_fixture = $football_data->fixtures_by_data(array(
                    "position" => "prev",
                    "team_id" => $team->team_id
                ));

                $next_fixture = $football_data->fixtures_by_data(array(
                    "position" => "next",
                    "team_id" => $team->team_id
                ));
                ?>
                <div class="team-header-container">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 team-header-logo">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $team_id; ?>.png" alt="<?php echo $team->team_name ?>">
                        </div>
                        <div class="col-md-5 col-sm-5 team-header-games">
                            <?php $home_team = $previous_fixture->home->team_name ?>
                            <?php $away_team = $previous_fixture->away->team_name ?>
                            <div class="game-title">Last Game:</div>
                            <div class="game-desc">
                                <?php if (!empty($previous_fixture->fixture_date_time)): ?>
                                    <?php echo $home_team ?>  <?php echo $previous_fixture->result->home_final_score ?> -  <?php echo $previous_fixture->result->away_final_score ?> <?php echo $away_team ?><br>
                                    <?php echo date("D jS F Y", strtotime($previous_fixture->fixture_date_time)) ?>
                                    <?php echo $previous_fixture->venue ?>
                                <?php else: ?>
                                    <?php echo "There is no previous game data." ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 team-header-games">
                            <?php $home_team = $next_fixture->home->team_name ?>
                            <?php $away_team = $next_fixture->away->team_name ?>
                            <div class="game-title">Next Game:</div>
                            <div class="game-desc">
                                <?php if (!empty($next_fixture->fixture_date_time)): ?>
                                    <?php echo $home_team ?> - <?php echo $away_team ?><br>
                                    <?php echo date("D jS F Y", strtotime($next_fixture->fixture_date_time)) ?>
                                    <?php echo $next_fixture->venue ?>
                                <?php else: ?>
                                    <?php echo "There is no next game data." ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <span></span>
                </div>
                <?php
            }
        }
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
    register_widget('data_team_header_widget');
});
?>
