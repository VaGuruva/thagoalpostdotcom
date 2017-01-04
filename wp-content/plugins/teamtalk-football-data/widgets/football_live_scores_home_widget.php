<?php

class football_live_scores_home_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'football_live_scores_home_widget', // Base ID
            '[Comp] Football - Live scores listing widget', // Name
            array('description' => 'This is the live scores listing Widget',) // Args
        );
    }

    public function widget($args, $instance) {
        $football_data = new Football_Data();
        $competition_fixtures = $football_data->fixtures_by_data(array(
            "is_live" => true
        ));

        ?>


        <?php $fixtures_handle = array(); ?>
        <?php foreach ($competition_fixtures as $key => $fixture): ?>
            <?php $tournament_names_with_no_live_updates = array("Scottish Championship","English Football League - League 2", "English Football League - League 1", "Scottish League One", "Scottish League Two", "Kenyan Premier League", "Ghana Premier League", "Dutch Eredivisie", "Scottish Premiership", "South African Premier Soccer League", "Internationals"); ?>
            <?php //$tournament_names_with_no_live_updates = array("Dutch Eredivisie"); ?>
            <?php $tournament_ids_with_no_live_updates = array(163, 162, 107); ?>
            <?php if (!in_array($key , $tournament_names_with_no_live_updates)): ?>
                <?php
                if ($key == "English Barclays Premier League"){
                    $key = "Premier League";
                }
                ?>
                <?php $fixtures_handle[$key] = $fixture; ?>
            <?php endif ?>
        <?php endforeach; ?>

        <!-- Results // To separate page -->
        <div class="article football-fixtures-results" style="padding: 0px;">
            <header class="articleList__header">
                <h3>Live Scores</h3>
            </header>
            <div class="football-live-scoring">
                <div class="row live-scoring-header">
                    <div class="col-md-6 live-date">
                        <i class="fa fa-calendar" aria-hidden="true"></i> <span><?php echo date("l j F Y"); ?></span>
                    </div>
                    <div class="col-md-6 filter-tournament">
<!--                        <div class="datePicker__wrapper">-->
<!--                            <div class="datePicker">-->
<!--                                <select id="league_select" class="datePicker__select tournament_picker" name="tournament_select">-->
<!--                                    Filter by tournament-->
<!--                                    <option value="9999">All Tournaments</option>-->
<!--                                    --><?php //foreach ($fixtures_handle as $key => $fixture): ?>
<!--                                        <option>--><?php //echo $key; ?><!--</option>-->
<!--                                    --><?php //endforeach; ?>
<!--                                </select>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>

            <?php foreach ($fixtures_handle as $key => $fixtures): ?>
                <div class="fixtures-results-item">
                    <div class="fixtures-results-heading">
                        <span class="fixtures-results-date"><?php echo $key ?></span>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php foreach ($fixtures as $fixture): ?>
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
                            <?php $away_score = ($fixture->away->score >= 0)? $fixture->away->score : ''  ?>
                            <?php $home_score = ($fixture->home->score >= 0)? $fixture->home->score : ''  ?>
                            <?php $result = $fixture->result ?>
                            <?php $home_team_id = $fixture->home->id ?>
                            <?php $away_team_id = $fixture->away->id ?>
                            <?php

                                if ($fixture->is_live){

                                    $match_scores = $football_data->match_by_scores(array(
                                    "match_id" => $fixture->fixture_id
                                    ));

                                    $home_score = $match_scores[0]->home_score;
                                    $away_score = $match_scores[0]->away_score;
                                }

                            ?>

                            <?php

                            if ($fixture->score->status == 'fulltime'){
                                 $game_status = '<span style="color:#149E5A;">FT</span>';
                            }

                            if ($fixture->score->status == 'live'){
                                 $game_status = '<span style="color:#FF0000;">Live</span>';
                            }

                            if ($fixture->score->status == '') {
                                $game_status = date("H:i ", $fixture_date_time);
                            }

                            ?>

                            <tr>
                                <td class="time" style="font-family: 'oswaldlight',sans-serif !important;"><?php echo $game_status; ?></td>
                                <td class="team-left-name" style="font-family: 'oswaldlight',sans-serif !important;"><?php echo $home_team ?></td>
                                <td class="team-left-logo"><img src="<?php echo get_template_directory_uri();?><?php echo"/images/teamlogos/$home_team_id.png" ?>"</td>
                                <td class="score"><span><?php echo $home_score ?></span><span>-</span><span><?php echo $away_score ?></span>
                                    <?php if ($fixture->score->status == 'live'): ?>
                                        <?php $match = sanitize_title_for_query($home_team) . "-vs-" . sanitize_title_for_query($away_team); ?>
                                        <span class="match-page"><a href="<?php echo site_url() ?>/match/<?php echo $match ?>/<?php echo $fixture->fixture_id?>">Match Page ></a></span>
                                    <?php endif; ?>
                                </td>


                                <td class="team-right-logo"><img src="<?php echo get_template_directory_uri();?><?php echo"/images/teamlogos/$away_team_id.png" ?>"</td>
                                <td class="team-right-name" style="font-family: 'oswaldlight',sans-serif !important;"><?php echo $away_team ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endforeach; ?>
            <?php if (count($competition_fixtures) == 0): ?>
                <tr>
                    <td colspan="12">There are currently no live games today.</td>
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
    register_widget('football_live_scores_home_widget');
});
?>