<?php

class football_live_match_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                'football_live_match_widget', // Base ID
                '[Main Menu] Results & Fixtures Widget', // Name
                array('description' => 'Results & Fixtures Widget',) // Args
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

        $venue = $match_timeline->venue;

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

        if (!empty($home_team)) {
            $home_manager = '';//get_field_id(sanitize_title_for_query($home_team), false, "team-manager");
        }
        
//        echo "<pre>";
//        print_r($away_timeline);
//        die;

        if (!empty($away_team)) {
            $away_manager = '';//get_field_id(sanitize_title_for_query($away_team), false, "team-manager");
        }
        ?>
        <input id="match_id" type="hidden" value="<?php echo $match_id ?>" />
        <div class="live-scoring-wrapper">
            <div class="live-scoring-points">
                <div class="row">
                    <div class="col-md-2 hidden-xs hidden-sm left-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $home_id ?>.png" alt="<?php echo $home_team ?>">
                    </div>
                    <div class="col-xs-4 col-md-3 col-sm-4 name"><?php echo $home_team ?></div>
                    <div class="col-xs-4 col-md-2 col-sm-4 score">
                        <?php $fixture_date_time = strtotime($match_teams->fixture_date_time); ?>
                        <div class="date"><?php echo date("D d M", $fixture_date_time) ?></div>
                        <div>
                            <span id="score-home"><?php echo $home_score; ?></span>
                            <span> - </span>
                            <span id="score-away"><?php echo $away_score; ?></span>
                        </div>
                    </div>
                    <div class="col-xs-4 col-md-3 col-sm-4 name"><?php echo $away_team ?></div>
                    <div class="col-md-2 hidden-xs hidden-sm right-logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $away_id ?>.png" alt="<?php echo $away_team ?>">
                    </div>
                </div>
            </div>
            <div class="live-scoring">
                <div class="live-scoring-container">
                    <div class="score-timeline hidden-sm hidden-xs">
                        <div class="timeline-header">
                            <div class="col-md-2 col-sm-2 timeline-stadium"><?php echo $venue ?></div>
                            <div class="col-md-3 col-sm-3 timeline-goals-left">
                                <?php foreach ($home_scorers as $key => $scorer): ?>
                                    <?php echo $scorer->name ?>
                                    (<?php echo implode(",", $scorer->events) ?>)<br/>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-md-2 col-sm-2"></div>
                            <div class="col-md-3 col-sm-3 timeline-goals-right">
                                <?php foreach ($away_scorers as $key => $scorer): ?>
                                    <?php echo $scorer->name ?>
                                    (<?php echo implode(",", $scorer->events) ?>)<br/>
                                <?php endforeach; ?>
                            </div>
                        </div>                        
                        <div class="timeline-logo-left">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $home_id ?>.png" alt="<?php echo $home_team ?>">
                        </div>
                        <ul class="timeline">
                            <li class="versus">V</li>
                            <?php foreach (range(5, 90, 5) as $step): ?>
                                <?php $home_events = array(); ?>
                                <?php $away_events = array(); ?>
                                <?php $is_home = false; ?>
                                <?php $is_away = false; ?>
                                <?php foreach ($home_timeline as $home_event): ?>
                                    <?php $is_home = $home_event->range == $step && array_key_exists($home_event->event, $icons) ?>
                                    <?php if ($is_home): ?>
                                        <?php $home_events[] = $home_event; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php foreach ($away_timeline as $away_event): ?>
                                    <?php $is_away = $away_event->range == $step && array_key_exists($away_event->event, $icons) ?>
                                    <?php if ($is_away): ?>
                                        <?php $away_events[] = $away_event; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php
                               // print_r($home_events);
                                ?>
                                <li class="<?php echo count($home_events) ? "arrow_box_up" : "" ?><?php echo count($away_events) ? " arrow_box_down" : "" ?>" id="step-<?php echo $step ?>">
                                    <span><?php echo $step ?></span>
                                    <?php foreach ($home_events as $home_event): ?>
                                        <div class="timeline-icons-top" id="event-<?php echo $home_event->event ?>-<?php echo $home_event->event_id ?>" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $home_event->player_name ?> <?php echo $home_event->player_surname ?> (<?php echo $home_event->event ?> <?php if ($home_event->period == 1 ) { echo $home_event->event_match_time; } else  {echo (45 + $home_event->event_match_time); } ?>)"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-<?php echo $icons[$home_event->event] ?>.png"></div>
                                    <?php endforeach; ?>
                                    <?php foreach ($away_events as $away_event): ?>
                                        <div class="timeline-icons-bottom" id="event-<?php echo $away_event->event_id ?>"  data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo $away_event->player_name ?> <?php echo $away_event->player_surname ?> (<?php echo $away_event->event ?> <?php echo $away_event->event_match_time ?>)"><img src="<?php echo get_template_directory_uri(); ?>/images/icon-<?php echo $icons[$away_event->event] ?>.png"></div>
                                    <?php endforeach; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="timeline-logo-left">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $away_id ?>.png" alt="<?php echo $away_team_id ?>">    
                        </div>
                    </div>
                    <div class="live-scoring-tab-container">
                        <!-- Nav tabs -->
                        <ul class="row nav nav-tabs responsive" role="tablist">
                            <li class="col-md-4 active"><a href="#teams" aria-controls="teams" role="tab" data-toggle="tab">TEAMS</a></li>
                            <li class="col-md-4"><a href="#statsmain" aria-controls="statsmain" role="tab" data-toggle="tab">STATS</a></li>
                            <li class="col-md-4"><a href="#commentary" aria-controls="commentary" role="tab" data-toggle="tab">COMMENTARY</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content responsive">
                            <!-- Teams Data -->
                            <div role="tabpanel" class="tab-pane fade in active" id="teams">
                                <div class="row">
                                    <!-- Team Left -->
                                    <div class="col-md-3">
                                        <div class="teams-logo-left">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $home_id ?>.png" alt="<?php echo $home_team ?>">
                                        </div>
                                        <?php if (!empty($home_manager)): ?>
                                            <div class="teams-data teams-header">
                                                <span class="left"><strong>Manager</strong></span>
                                                <span class="left"><?php echo $home_manager ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="teams-data">
                                            <table cellpadding="0" cellspacing="0" border="0" class="teams-info">
                                                <?php foreach ($home_squad as $key => $squad): ?>
                                                    <?php if ($key > 10) break; ?>
                                                    <tr>
                                                        <?php if (!empty($squad->shirt_number)): ?>
                                                            <td class="teams-position"><?php echo $squad->shirt_number ?></td>
                                                        <?php endif; ?>
                                                        <td><?php echo $squad->player->last_name ?></td>
                                                        <td class="teams-sub-off">&nbsp;</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                            <?php if (count($home_squad) > 11): ?>
                                                <span class="teams-info">Substitutes</span>                                            
                                                <table cellpadding="0" cellspacing="0" border="0" class="teams-info">
                                                    <?php foreach ($home_squad as $key => $squad): ?>
                                                        <?php if ($key > 20) break; ?>
                                                        <?php if ($key > 10): ?>
                                                            <tr>
                                                                <?php if (!empty($squad->shirt_number)): ?>
                                                                    <td class="teams-position"><?php echo $squad->shirt_number ?></td>
                                                                <?php endif; ?>
                                                                <td><?php echo $squad->player->last_name ?></td>
                                                                <td class="teams-sub-off">&nbsp;</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- End Team Left -->
                                    <div class="col-md-6">
                                        <div class="pitch">
                                            <div class="statistical-home">
                                                <div class="homePitchBadge" style="background: url(<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $home_id ?>.png) no-repeat;background-size: contain;"></div>
                                            </div>
<!--                                            <div class="tactical-home">-->
<!--                                                --><?php //foreach ($home_positions as $positition): ?>
<!--                                                    --><?php //$coordinates = explode(",", $positition->field_position) ?>
<!--                                                    --><?php //$x = $coordinates[0]; ?>
<!--                                                    --><?php //$y = 2 + $coordinates[1] / 2; ?>
<!--                                                    --><?php //if (is_numeric($x) && is_numeric($y)): ?>
<!--                                                        <div class="home-player-position" style="left:  --><?php //echo $x ?><!--%; top:  --><?php //echo $y ?><!--%;">-->
<!--                                                            --><?php //echo $positition->shirt_number ?>
<!--                                                        </div>                   -->
<!--                                                    --><?php //endif; ?><!--                                    -->
<!--                                                --><?php //endforeach; ?>
<!--                                            </div>-->
<!--                                            <div class="tactical-away">-->
<!--                                                --><?php //foreach ($away_positions as $positition): ?>
<!--                                                    --><?php //$coordinates = explode(",", $positition->field_position) ?>
<!--                                                    --><?php //$x = $coordinates[0]; ?>
<!--                                                    --><?php //$y = 2 + $coordinates[1] / 2; ?>
<!--                                                    --><?php //if (is_numeric($x) && is_numeric($y)): ?>
<!--                                                        <div class="away-player-position"style="left:  --><?php //echo $x ?><!--%; bottom:  --><?php //echo $y ?><!--%;">-->
<!--                                                            --><?php //echo $positition->shirt_number ?>
<!--                                                        </div>                    -->
<!--                                                    --><?php //endif; ?>
<!--                                                --><?php //endforeach; ?>
<!--                                            </div>-->
<!--                                            <div class="statistical-away">-->
<!--                                                <div class="awayPitchBadge" style="background: url(--><?php //echo get_template_directory_uri(); ?><!--/images/teamlogos/--><?php //echo $away_id ?><!--.png) no-repeat;background-size: contain;"></div>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                    <!-- Team Right -->
                                    <div class="col-md-3">
                                        <div class="teams-logo-right">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/teamlogos/<?php echo $away_id ?>.png" alt="<?php echo $away_team ?>">
                                        </div>
                                        <?php if (!empty($away_manager)): ?>
                                            <div class="teams-data">
                                                <span class="right"><strong>Manager</strong></span>
                                                <span class="right"><?php echo $away_manager ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="teams-data">
                                            <table cellpadding="0" cellspacing="0" border="0" class="teams-info-right">
                                                <?php foreach ($away_squad as $key => $squad): ?>
                                                    <?php if ($key > 10) break; ?>
                                                    <tr>
                                                        <td><?php echo $squad->player->last_name ?></td>
                                                        <td class="teams-sub-off-right">&nbsp;</td>
                                                        <?php if (!empty($squad->shirt_number)): ?>
                                                            <td class="teams-position-right"><?php echo $squad->shirt_number ?></td>
                                                        <?php endif; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </table>
                                            <?php if (count($away_squad) > 11): ?>
                                                <span class="teams-info">Substitutes</span>
                                                <table cellpadding="0" cellspacing="0" border="0" class="teams-info-right">
                                                    <?php foreach ($away_squad as $key => $squad): ?>
                                                        <?php if ($key > 20) break; ?>
                                                        <?php if ($key > 10): ?>
                                                            <tr>
                                                                <td><?php echo $squad->player->last_name ?></td>
                                                                <td class="teams-sub-off-right">&nbsp;</td>
                                                                <?php if (!empty($squad->shirt_number)): ?>
                                                                    <td class="teams-position-right"><?php echo $squad->shirt_number ?></td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <!-- End Team Right -->
                                </div>
                            </div>
                            <!-- End Teams Data -->

                            <!-- Commentary Data -->
                                                        <div role="tabpanel" class="tab-pane fade" id="commentary">
                            
                                                            <?php $commentary = $match_commentary->commentary                                     ?>
                                                            <?php foreach ($commentary as $key => $comment):                                     ?>
                                                             
                                                                <div class="row commentary-liner">
                                                                    <div class="col-md-1"><?php echo $comment->match_time                                     ?>'</div>
                                                                    <div class="col-md-11"><?php echo $comment->content                                     ?></div>
                                                                </div>-->
                            
                                                                <?php if ($key == 0):                                     ?>
                                                                    <input id="message_id" type="hidden" value="<?php echo $comment->message_id; ?>" />
                                                                <?php endif;                                     ?>
                                                            <?php endforeach;                                     ?>
                                                            <?php if (count($commentary) == 0):                                     ?>
                                                                <input id="message_id" type="hidden" value="0" />
                                                                <div class="row commentary-liner">
                                                                    <div class="col-md-11">There are currently no match data available for this fixture</div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                            <!-- End Commentary Data -->

                            <!-- Stats Data -->
                            <div role="tabpanel" class="tab-pane fade" id="statsmain">

                                <?php $stats = $match_stats->stats ?>
                                <?php foreach ($events as $key => $event): ?>
                                    <?php if (!empty($stats->$key)): ?>
                                        <?php $stat = $stats->$key; ?>
                                        <div id="stats-<?php echo $key ?>">
                                            <?php $home_value = !empty($stat->$home_team_id) ? $stat->$home_team_id : 0; ?>
                                            <?php $away_value = !empty($stat->$away_team_id) ? $stat->$away_team_id : 0; ?>
                                            <div class = "stats-header"><?php echo $event ?></div>
                                            <div class = "row">
                                                <div class = "col-md-1 progress-data"><?php echo $home_value ?></div>
                                                <div class="col-md-10 progress">
                                                    <div class="progress-bar" style="width: <?php echo!empty($away_value) ? ($home_value * 100 / ($away_value + $home_value)) : 100 ?>%;"></div>
                                                </div>
                                                <div class="col-md-1 progress-data"><?php echo$away_value ?></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php $disciplinary = $match_stats->disciplinary ?>
                                <?php $home_red = !empty($disciplinary->$home_team_id->red) ? $disciplinary->$home_team_id->red : 0; ?>
                                <?php $home_yellow = !empty($disciplinary->$home_team_id->yellow) ? $disciplinary->$home_team_id->yellow : 0; ?>
                                <?php $away_red = !empty($disciplinary->$away_team_id->red) ? $disciplinary->$away_team_id->red : 0; ?>
                                <?php $away_yellow = !empty($disciplinary->$away_team_id->yellow) ? $disciplinary->$away_team_id->yellow : 0; ?>

                                <!-- Disciplinary -->
                                <div class="stats-header">Disciplinary</div>
                                <div id="disciplinary" class="row <?php echo empty($disciplinary) ? "hide" : "" ?>">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2" id="disciplinary-home">
                                        <span class="yellow"><?php echo $home_yellow ?></span>
                                        <span class="red"><?php echo $home_red ?></span>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-2"  id="disciplinary-away">
                                        <span class="yellow"><?php echo $away_yellow ?></span>
                                        <span class="red"><?php echo $away_red ?></span>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                            <!-- End Stats Data -->
                        </div>
                    </div>
                    <!-- End Stats Data -->
                </div>
            </div>
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
    register_widget('football_live_match_widget');
});
?>
