<?php

class football_team_results_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'football_team_results_widget', // Base ID
                'Team Reults Widget', // Name
                array('description' => 'Team Results Widget') // Args
        );
    }

    public function widget($args, $instance) {
        global $wp_query;

        $competition_fixtures = array();
        $football_data = new Football_Data();
        $slug = get_category_slug(5);
       // $team_id = get_field_id($slug);
        $team_id = get_team_id($slug);
        $competition_id = get_tournament_competition_id();

        if (!empty($team_id)) {
            $team = $football_data->teams_by_data(array(
                "team_id" => $team_id
            ));

            if ($team->team_id) {
                $competition_fixtures = $football_data->results_by_data(array(
                    "team_id" => $team->team_id,
                    "competition_id" => $competition_id,
                    "days" => 30,
                    "has_results" => true
                ));
            }
        }

        ?>

        <!-- Results // To separate page -->
        <div class="article football-fixtures-results">
            <header class="articleList__header">
                <h3>Results</h3>
            </header>

            <?php $fixtures_handle = array(); ?>
            <?php $unique_fixtures = array(); ?>
            <?php foreach ($competition_fixtures as $fixture): ?>
                <?php $fixtures_handle[date("l j F Y", strtotime($fixture->fixture_date_time))][] = $fixture; ?>
            <?php endforeach; ?>

            <?php foreach ($fixtures_handle as $key => $fixtures): ?>
                <div class="fixtures-results-item">
                    <div class="fixtures-results-heading">
                        <span class="fixtures-results-date"><?php echo $key ?></span>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php foreach ($fixtures as $fixture): ?>
                            <?php if (!in_array($fixture->id , $unique_fixtures)): ?>
                                <?php
                                $unique_fixtures[] = $fixture->id;
                                ?>

                                <?php
                                date_default_timezone_set('Europe/London');
                                $datetime = new DateTime($fixture->fixture_date_time);
                                $datetime->format('Y-m-d H:i:s') . "\n";
                                $la_time = new DateTimeZone('Africa/Johannesburg');
                                $datetime->setTimezone($la_time);
                                $fixture_date_time = strtotime($datetime->format('Y-m-d H:i:s'));
                                ?>
                                <?php $home_team = $fixture->home->team_name ?>
                                <?php $away_team = $fixture->away->team_name ?>
                                <?php $result = $fixture->result ?>
                                <?php $home_team_id = $fixture->home->id ?>
                                <?php $away_team_id = $fixture->away->id ?>
                                <tr>
                                    <td class="time">FT</td>
                                    <td class="team-left-name"><?php echo $home_team ?></td>
                                    <td class="team-left-logo"><img src="<?php echo get_template_directory_uri();?><?php echo"/images/teamlogos/$home_team_id.png" ?>"</td>
                                    <td class="score"><span><?php echo $result->home_final_score ?></span><span>-</span><span><?php echo $result->away_final_score ?></span>
                                        <span class="match-page"><a href="">Match Page ></a></span></td>
                                    <td class="team-right-logo"><img src="<?php echo get_template_directory_uri();?><?php echo"/images/teamlogos/$away_team_id.png" ?>"</td>
                                    <td class="team-right-name"><?php echo $away_team ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endforeach; ?>

            <?php if (count($competition_fixtures) == 0): ?>
                <tr>
                    <td colspan="12">There are currently no results available for this competition for this season.</td>
                </tr>
            <?php endif; ?>

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
    register_widget('football_team_results_widget');
});
?>