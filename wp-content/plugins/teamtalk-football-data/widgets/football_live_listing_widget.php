<?php

class football_live_listing_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'football_live_listing_widget', // Base ID
                'Data Live Home Widget', // Name
                array('description' => 'Data Live Home Widget',) // Args
        );
    }

    public function widget($args, $instance) {
        ?>

        <!-- Football - Live Scores Home -->
        <div class="article football-fixtures-results football-live-scoring">
            <header class="articleList__header">
                <h3>Live Scores</h3>
            </header>
            <div class="row live-scoring-header">
                <div class="col-md-6 live-date">
                    <i class="fa fa-calendar" aria-hidden="true"></i> <span>Friday 10 June 2016</span>
                </div>
                <div class="col-md-6 filter-tournament">
                    <div class="datePicker__wrapper">
                        <div class="datePicker">
                              <select id="league_select" class="datePicker__select tournament_picker" name="tournament_select">
                                  <option value="9999">Filter by tournament</option>
                                  <option>Tournament 1</option>
                                  <option>Tournament 2</option>
                                  <option>Tournament 3</option>
                                  <option>Tournament 4</option>
                              </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Static Data -->
            <div class="fixtures-results-item">
                <div class="fixtures-results-heading">
                    <span class="fixtures-results-date">Tournament Name</span>
                </div>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="group-icon-container"><div class="group-icon"><span>A</span><span>Group</span></div></td>
                        <td class="stadium">State de France, Saint-Denis</td>
                        <td class="team-left-name">Manchester United</td>
                        <td class="team-left-logo"><img src="<?php echo get_template_directory_uri();?>/images/teamlogos/11.png"></td>
                        <td class="time">17:00</td>
                        <td class="team-right-logo"><img src="<?php echo get_template_directory_uri();?>/images/teamlogos/18.png"></td>
                        <td class="team-right-name">Tottenham Hotspur</td>
                        <td class="match"><span class="match-page"><a href="">Match Page ></a></td>
                    </tr>
                    <tr>
                        <td class="group-icon-container"><div class="group-icon"><span>B</span><span>Group</span></div></td>
                        <td class="stadium">State de France, Saint-Denis</td>
                        <td class="team-left-name">Manchester United</td>
                        <td class="team-left-logo"><img src="<?php echo get_template_directory_uri();?>/images/teamlogos/41.png"></td>
                        <td class="time">17:00</td>
                        <td class="team-right-logo"><img src="<?php echo get_template_directory_uri();?>/images/teamlogos/2.png"></td>
                        <td class="team-right-name">Tottenham Hotspur</td>
                        <td class="match"><span class="match-page"><a href="">Match Page ></a></td>
                    </tr>
                    <tr>
                        <td class="group-icon-container"><div class="group-icon"><span>C</span><span>Group</span></div></td>
                        <td class="stadium">State de France, Saint-Denis</td>
                        <td class="team-left-name">Manchester United</td>
                        <td class="team-left-logo"><img src="<?php echo get_template_directory_uri();?>/images/teamlogos/11.png"></td>
                        <td class="time">17:00</td>
                        <td class="team-right-logo"><img src="<?php echo get_template_directory_uri();?>/images/teamlogos/18.png"></td>
                        <td class="team-right-name">Tottenham Hotspur</td>
                        <td class="match"><span class="match-page"><a href="">Match Page ></a></td>
                    </tr>
                </table>
            </div>

            <!-- End Static Data -->

        </div>

        <!-- Current Live Data Styling -->
<!--        --><?php
//        $football_data = new Football_Data();
//        $competition_fixtures = $football_data->fixtures_by_data(array(
//            "is_live" => true
//        ));
//        ?>
<!---->
<!--        --><?php //$fixtures_handle = array(); ?>
<!--        --><?php //foreach ($competition_fixtures as $key => $fixture): ?>
<!--               --><?php ////$tournament_names_with_no_live_updates = array("Kenyan Premier League", "Ghana Premier League", "South African Premier Soccer League", "Internationals"); ?>
<!--               --><?php //$tournament_names_with_no_live_updates = array("Dutch Eredivisie"); ?>
<!--                --><?php //$tournament_ids_with_no_live_updates = array(163, 162, 107); ?>
<!--                --><?php //if (!in_array($key , $tournament_names_with_no_live_updates)): ?>
<!--                    --><?php //$fixtures_handle[$key] = $fixture; ?>
<!--                --><?php //endif ?>
<!--        --><?php //endforeach; ?>
<!---->
<!--        <div class="live-home">-->
<!--            --><?php //foreach ($fixtures_handle as $key => $fixtures): ?>
<!--                <!-- Day --><?php //echo $key + 1 ?><!-- -->
<!--                <header class="articleList__header">-->
<!--                    <h3><span>--><?php //echo $key ?><!--</span></h3>-->
<!--                </header>-->
<!--                --><?php //$unique_fixtures = array(); ?>
<!--                --><?php //foreach ($fixtures as $key => $fixture): ?>
<!--                    --><?php //$home_team = $fixture->home->team_name ?>
<!--                    --><?php //if (in_array($fixture->fixture_id, $unique_fixtures)) continue; ?>
<!--                    --><?php //$unique_fixtures[] = $fixture->fixture_id ?>
<!--                    --><?php //$away_team = $fixture->away->team_name ?>
<!--                    --><?php //$away_score = $fixture->away->score? $fixture->score : 0  ?>
<!--                    --><?php //$home_score = $fixture->home->score? $fixture->score : 0  ?>
<!--                    --><?php ////$fixture_date_time = strtotime($fixture->fixture_date_time); ?>
<!--                        --><?php
//                        date_default_timezone_set('Europe/London');
//                        $datetime = new DateTime($fixture->fixture_date_time);
//                        $datetime->format('Y-m-d H:i:s') . "\n";
//                        $la_time = new DateTimeZone('Africa/Johannesburg');
//                        $datetime->setTimezone($la_time);
//                        $fixture_date_time = strtotime($datetime->format('Y-m-d H:i:s'));
//                        ?>
<!--                    <div class="article">-->
<!--                        <table border="0" cellpadding="0" cellspacing="0">-->
<!--                            <tr class="match-live" id="--><?php //echo $fixture->fixture_id ?><!--">-->
<!--                                <td>--><?php //echo $home_team ?><!--</td>-->
<!--                                <td class="score-home">--><?php //echo $home_score ?><!--</td>-->
<!--                                <td class="match--><?php //echo $fixture->is_live ? "-" : "-not-" ?><!--live">-->
<!--                                    --><?php
//                                    $match = sanitize_title_for_query($home_team) . "-vs-" . sanitize_title_for_query($away_team); ?>
<!--                                    --><?php //if (in_array($fixture->competition_id , $tournament_ids_with_no_live_updates)): ?>
<!--                                        --><?php //echo $fixture->is_live ? "Live" : date("H:i ", $fixture_date_time) ?>
<!--                                    --><?php //endif ?>
<!--                                    --><?php //if (!in_array($fixture->competition_id , $tournament_ids_with_no_live_updates)): ?>
<!--                                        <a href="--><?php //echo site_url() ?><!--/match/--><?php //echo $match ?><!--/--><?php //echo $fixture->fixture_id ?><!--">-->
<!--                                            --><?php //echo $fixture->is_live ? "Live" : date("H:i ", $fixture_date_time) ?>
<!--                                        </a>-->
<!--                                    --><?php //endif ?>
<!--                                </td>-->
<!--                                <td class="score-away">--><?php //echo $away_score ?><!--</td>-->
<!--                                <td>--><?php //echo $away_team ?><!--</td>-->
<!--                            </tr>-->
<!--                        </table>-->
<!--                    </div>-->
<!--                --><?php //endforeach; ?>
<!--            --><?php //endforeach; ?>
<!--            --><?php //if (count($fixtures_handle) == 0): ?>
<!--                <div class="no-data" style="text-align: center; padding:10px">There are currently no live matches today</div>-->
<!--            --><?php //endif; ?>
<!--        </div>-->
        <!-- End Current Live Data Styling -->

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
    register_widget('football_live_listing_widget');
});
?>
