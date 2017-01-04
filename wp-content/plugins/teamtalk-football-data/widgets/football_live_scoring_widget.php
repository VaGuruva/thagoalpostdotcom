<?php

class football_live_scoring_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'football_live_scoring_widget', // Base ID
            '[Comp] Football Live Scoring Widget', // Name
            array('description' => 'This is the Football Live Scoring Widget',) // Args
        );
    }

    public function widget($args, $instance) {
        $football_data = new Football_Data();
        $actual_link = $_SERVER['REQUEST_URI'];
        $match_id = end((explode('/', trim($actual_link, '/'))));
        $match_id = !empty($match_id) ? $match_id : 0;

        $match_timeline = $football_data->match_by_data(array(
            "match_id" => $match_id,
            "section" => "timeline"
        ));

        $match_teams = $football_data->match_by_data(array(
            "match_id" => $match_id,
            "section" => "teams"
        ));

        $match_commentary = $football_data->match_by_data(array(
            "match_id" => $match_id,
            "section" => "commentary"
        ));

        $match_stats = $football_data->match_by_data(array(
            "match_id" => $match_id,
            "section" => "stats"
        ));

        $match_positions = $football_data->match_by_data(array(
            "match_id" => $match_id,
            "section" => "positions"
        ));

        $match_scorers = $football_data->match_by_data(array(
            "match_id" => $match_id,
            "section" => "scorers"
        ));

        //match_by_scores
        $match_scores = $football_data->match_by_scores(array(
            "match_id" => $match_id
        ));

        $events = array(
            "shot_on_target" => "Shots On Target",
            "shot_off_target" => "Shots Off Target",
            "penalty" => "Penalties",
            'block' => "Blocks",
            'freekick' => "Free Kicks",
            'corner' => "Corners",
            'save' => "Saves",
            'throwin' => "Throw Ins"
        );

        $icons = array(
            "yellow" => "yellowcard",
            "red" => "redcard",
            'goal' => "goal"
        );

        $home_squad = $match_teams->home->squad;
        $away_squad = $match_teams->away->squad;

        $home_team = $match_teams->home->team_name;
        $away_team = $match_teams->away->team_name;


        $home_score = $match_scores[0]->home_score;
        $away_score = $match_scores[0]->away_score;

        $status = $match_timeline->score->status;

        if ($status == 'fulltime'){
            $status = "ft";
        }

        $venue = $match_timeline->venue;
        $city = $match_timeline->city;

        $home_timeline = $match_timeline->timeline->home;
        $away_timeline = $match_timeline->timeline->away;

        $home_positions = $match_positions->home;
        $away_positions = $match_positions->away;

        $home_scorers = $match_scorers->home->scorers;
        $away_scorers = $match_scorers->away->scorers;

        $home_id = $match_teams->home->id;
        $away_id = $match_teams->away->id;

        $home_team_id = @$match_stats->home_team_id;
        $away_team_id = @$match_stats->away_team_id;
        $result = @$match_teams->result;
        $competition_name = $match_stats->competition_name;

        $competition_name= strtoupper($competition_name);

        if($competition_name  == 'ENGLISH BARCLAYS PREMIER LEAGUE'){
            $competition_name = 'PREMIER LEAGUE';
        }

        if (!empty($home_team)) {
            $home_manager = '';//get_field_id(sanitize_title_for_query($home_team), false, "team-manager");
        }

        if (!empty($away_team)) {
            $away_manager = '';//get_field_id(sanitize_title_for_query($away_team), false, "team-manager");
        }
        ?>

        <!-- Component: Live Scoring -->
        <div class="article football-fixtures-results football-live-scoring match-cricket-main-container">
            <header class="articleList__header">
                <h3>Live Scores: Match</h3>
            </header>

            <div class="fixtures-results-item">
                <div class="fixtures-results-heading">
                    <?php $fixture_date_time = strtotime($match_teams->fixture_date_time); ?>
                    <span class="fixtures-results-date"><?php echo date("l d F Y", $fixture_date_time) ?></span>
                </div>
            </div>

            <!-- Start Live Home Container -->
            <div class="live-cricket-home">
                <header class="articleList__header cricket-live">
                    <h3><span><?php echo $competition_name ?></span></h3>
                </header>
                <div class="match-results">
                    <div class="match-name">
                        <span><?php echo $venue ?></span>
                        <!--                        <span>Group Stage - Group A</span>-->
                    </div>
                    <div class="row scores-container">
                        <div class="col-md-3 col-sm-3 col-xs-3 team-home-name">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $home_id ?>.png" alt="<?php echo $home_team ?>">
                            <span><?php echo $home_team ?></span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 team-home-score"><span><?php echo $home_score ?></span><br>
                            <span class="run-rate">
                                <?php foreach ($home_scorers as $key => $scorer): ?>
                                    <?php echo $scorer->name ?>
                                    (<?php echo implode(",", $scorer->events) ?>)<br/>
                                <?php endforeach; ?>
                            </span>
                        </div>
                        <div class="elapsed-time" style="text-align:center;"><?php echo strtoupper($status); ?></div>
                        <div class="col-md-3 col-sm-3 col-xs-3 team-away-score"><span><?php echo $away_score ?></span><br>
                            <span class="run-rate">
                                <?php foreach ($away_scorers as $key => $scorer): ?>
                                    <?php echo $scorer->name ?>
                                    (<?php echo implode(",", $scorer->events) ?>)<br/>
                                <?php endforeach; ?>
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 team-away-name">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $away_id ?>.png" alt="<?php echo $away_team ?>">
                            <span><?php echo $away_team ?></span>
                        </div>
                    </div>
                </div>

                <!-- SUMMARY / LINE-UPS / MATCH INFO Tabs -->
                <div class="live-scoring-tab-container">
                    <!-- Nav tabs -->
                    <ul class="row nav nav-tabs responsive" role="tablist">
                        <li class="col-md-6 col-xs-6 summary active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">SUMMARY</a></li>
                        <li class="col-md-6 col-xs-6 lineups" style="padding-right:15px !important; border-right: none;"><a href="#lineups" aria-controls="lineups" role="tab" data-toggle="tab">LINE-UPS</a></li>
                        <!--                        <li class="col-md-4 col-xs-4 matchinfo"><a href="#matchinfo" aria-controls="matchinfo" role="tab" data-toggle="tab">MATCH INFO</a></li>-->
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content responsive">
                        <!-- Summary Data -->
                        <div role="tabpanel" class="tab-pane fade in active" id="summary">
                            <div class="match-commentary">
                                <div class="match-commentary-title">
                                    <span><i class="fa fa-microphone icon-commentary"></i> Match Commentary</span>
                                </div>
                                <?php $commentary = $match_commentary->commentary  ?>
                                <?php foreach ($commentary as $key => $comment):    ?>
                                    <div class="row commentary-block">
                                        <div class="col-md-1 col-sm-2 col-xs-2 quote"><?php echo $comment->match_time ?></div>
                                        <div class="col-md-11 col-sm-10 col-xs-10 commentary-content">
                                            <?php echo $comment->content ?>
                                        </div>
                                    </div>
                                    <?php if ($key == 0): ?>
                                        <input id="message_id" type="hidden" value="<?php echo $comment->message_id; ?>" />
                                    <?php endif;   ?>
                                <?php endforeach;  ?>

                                <?php if (count($commentary) == 0):                                     ?>
                                    <input id="message_id" type="hidden" value="0" />
                                    <div class="row commentary-liner">
                                        <div class="col-md-11">There is currently no live match commentary available for this fixture</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- End Summary Data -->

                        <!-- Line-ups Data -->
                        <div role="tabpanel" class="tab-pane fade" id="lineups">
                            <div class="match-commentary">
                                <div class="row line-ups">
                                    <div class="team-divider"></div>
                                    <div class="col-md-5 col-xs-5 home-team">
                                        <div class="team-name">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $home_id ?>.png" alt="<?php echo $home_team ?>">
                                            <span><?php echo $home_team ?></span>
                                        </div>
                                        <div class="team-positions-home">
                                            <ul>
                                                <?php foreach ($home_squad as $key => $squad): ?>
                                                    <?php if ($key > 10) break; ?>
                                                    <li>
                                                        <?php if (!empty($squad->shirt_number)): ?>
                                                            <div><?php echo $squad->shirt_number ?></div>
                                                        <?php endif; ?>
                                                        <?php echo $squad->player->last_name ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php if (count($home_squad) > 11): ?>
                                                <span><strong>Substitutes</strong></span>
                                                <ul>
                                                    <?php foreach ($home_squad as $key => $squad): ?>
                                                        <?php if ($key > 20) break; ?>
                                                        <?php if ($key > 10): ?>
                                                            <li>
                                                                <?php if (!empty($squad->shirt_number)): ?>
                                                                    <div><?php echo $squad->shirt_number ?></div>
                                                                    <?php echo $squad->player->last_name ?>
                                                                <?php endif; ?>
                                                            </li>

                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-2 field">

                                    </div>
                                    <div class="col-md-5 col-xs-5 away-team">
                                        <div class="team-name">
                                            <span><?php echo $away_team ?></span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $away_id ?>.png" alt="<?php echo $away_team ?>">

                                        </div>
                                        <div class="team-positions-away">
                                            <ul>
                                                <?php foreach ($away_squad as $key => $squad): ?>
                                                    <?php if ($key > 10) break; ?>
                                                    <li>
                                                        <?php echo $squad->player->last_name ?>
                                                        <?php if (!empty($squad->shirt_number)): ?>
                                                            <div><?php echo $squad->shirt_number ?></div>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php if (count($away_squad) > 11): ?>
                                                <span><strong>Substitutes</strong></span>
                                                <ul>
                                                    <?php foreach ($away_squad as $key => $squad): ?>
                                                        <?php if ($key > 20) break; ?>
                                                        <?php if ($key > 10): ?>
                                                            <li>
                                                                <?php if (!empty($squad->shirt_number)): ?>
                                                                    <div><?php echo $squad->shirt_number ?></div>
                                                                <?php endif; ?>
                                                                <?php echo $squad->player->last_name ?>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Line-ups Data -->

                        <!-- Match Info Data -->
                        <!--                        <div role="tabpanel" class="tab-pane fade" id="matchinfo">-->
                        <!--                            <div class="match-commentary">-->
                        <!--                                <div class="matchinfo">-->
                        <!--                                    <div class="row stadium-container">-->
                        <!--                                        <div class="col-md-1 col-sm-2 col-xs-2 stadium-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>-->
                        <!--                                        <div class="col-md-5 col-sm-10 col-xs-10 stadium-info">-->
                        <!--                                            <span class="heading">--><?php //echo $venue ?><!--</span>-->
                        <!--                                            <span><strong>Capacity: </strong>80100</span>-->
                        <!--                                            <span><strong>Opened: </strong>January 1997</span>-->
                        <!---->
                        <!---->
                        <!--                                            <input id="matchCity" type ="hidden" value ="--><?php //echo $city ?><!--">-->
                        <!--                                            <div class="weather">-->
                        <!--                                                --><?php //the_widget('weatherWidget') ?>
                        <!--                                            </div>-->
                        <!--                                        </div>-->
                        <!--                                        <div class="col-md-6 stadium-photo"><img src="--><?php //echo get_template_directory_uri();?><!--/images/stadium.png"></div>-->
                        <!--                                    </div>-->
                        <!--                                    <div class="stadium-divider"></div>-->
                        <!--                                    <div class="row referee-container">-->
                        <!--                                        <div class="col-md-1 col-xs-2 stadium-icon"><i class="icomoon-rugby-final-whistle" aria-hidden="true"></i></div>-->
                        <!--                                        <div class="col-md-5 col-xs-10 stadium-info">-->
                        <!--                                            <span><strong>Referee</strong></span>-->
                        <!--                                            <span>Viktor Kassai (HUN)</span>-->
                        <!---->
                        <!--                                            <div class="assistant-ref">-->
                        <!--                                                <span><strong>Assistant referee</strong></span>-->
                        <!--                                                <span>Gyorgy Ring (HUN)</span>-->
                        <!--                                                <span>Vencel Toth (HUN)</span>-->
                        <!--                                            </div>-->
                        <!--                                        </div>-->
                        <!--                                        <div class="col-md-6 col-xs-10 pull-right stadium-info">-->
                        <!--                                            <span><strong>Additional assistant referee</strong></span>-->
                        <!--                                            <span>Tamas Bognar (HUN)</span>-->
                        <!--                                            <span>Adam Farkas (HUN)</span>-->
                        <!---->
                        <!--                                            <div class="assistant-ref">-->
                        <!--                                                <span><strong>Fourth official</strong></span>-->
                        <!--                                                <span>Bjorn Kuipers (NED)</span>-->
                        <!--                                            </div>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                        <!--                                </div>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!-- End Match Info Data -->

                    </div>
                </div>
                <!-- End SUMMARY & SCORECARD Tabs -->
            </div>

            <!-- End Live Home Container -->
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
    register_widget('football_live_scoring_widget');
});
?>