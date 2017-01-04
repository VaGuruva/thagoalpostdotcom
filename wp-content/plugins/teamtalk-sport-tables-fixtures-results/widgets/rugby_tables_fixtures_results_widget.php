<?php

class rugby_tables_fixtures_results_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'rugby_tables_fixtures_results_widget', // Base ID
            '[Sidebar]Tables, Fixtures and Results Widget', // Name
            array('description' => 'Tables, Fixtures and Results Widget',) // Args
        );
    }

    public function widget($args, $instance) {

        $football_data = new Football_Data();

        $competition_id = (get_competition_id() == false ? 63 : get_competition_id()); // default to premier-league
        $competition_short_name =  (get_competition_id() == false ? "Premier League" : get_competition_short_name());

        $competition_logs = array();
        $competition_fixtures = array();
        $competition_results = array();

        if (!empty($competition_id)) {
            $competition = $football_data->competitions_by_data(array(
                "id" => $competition_id
            ));

            if (!empty($competition)) {
                $competition_logs = $football_data->logs_by_data(array(
                    "competition_id" => $competition->competition_id,
                    "season_id" => $competition->season_id
                ));
            }

            $competition_fixtures = $football_data->fixtures_by_data(array(
                "competition_id" => $competition_id,
                "limit" => 20
            ));

            $competition_results = $football_data->results_by_data(array(
                "competition_id" => $competition_id,
                "limit" => 20
            ));
        }

        ?>

        <?php
        $url = $_SERVER['REQUEST_URI'];
        if (strpos($url, "cricket") || strpos($url, "rugby") || strpos($url, "other-sports") || $competition_id == 38 || $competition_id == 39 || $competition_id == 6 ) { echo ""; }
        else {  ?>

            <!-- Widget Tables, Fixtures and Results -->
            <div class="widget widget-tables-fix-results">
                <header class="widget__header">
                    <h3>Super Rugby</h3>
                    <select id="widget_sport_selector" class="widget-sport-select">
                        <option>Rugby</option>
                        <option>Football</option>
                        <option>Cricket</option>
                    </select>
                    <select id="widget_league_selector" class="widget-league-select">
                        <option>Premier League</option>
                        <option>League Cup</option>
                        <option>FA Cup</option>
                        <option>Championship</option>
                    </select>
                </header>
                <section id="fix_results_logs" class="widget__body--noExpand featured-news-widget">

                    <div class="tab-container">
                        <!-- Nav tabs -->
                        <ul class="row nav nav-tabs responsive" role="tablist">
                            <li class="col-md-4 col-xs-4 active"><a href="#tables" aria-controls="tables" role="tab" data-toggle="tab">Tables</a></li>
                            <li class="col-md-4 col-xs-4 "><a href="#fixtures" aria-controls="fixtures" role="tab" data-toggle="tab">Fixtures</a></li>
                            <li class="col-md-4 col-xs-4"><a href="#results" aria-controls="results" role="tab" data-toggle="tab">Results</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content responsive">

                            <!-- Tables -->
                            <div role="tabpanel" class="tab-pane fade in active" id="tables">
                                <!-- PL TABLES -->

                                <div>
                                    <?php
                                    $args = array(
                                        'show_count' => '0',
                                        'orderby' => 'name',
                                        'echo' => '0',
                                        'child_of' => '1365',
                                        'hide_empty' => '0',
                                        'depth' => '1',
                                        'title_li' => '',
                                        'exclude' => array(232, 231, 233, 43083)
                                    );

                                    $english_clubs = get_categories($args);
                                    ?>
                                    <?php $clubs_holder = array(); ?>
                                    <?php foreach ($english_clubs as $club): ?>
                                        <?php if (!empty($club->term_id)): ?>
                                            <?php $data_id = get_field_value($club->term_id); ?>
                                            <?php if (!empty($data_id)): ?>
                                                <?php $clubs_holder[$data_id] = get_category_link($club->term_id); ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <!-- Tables / Log -->
                                    <table class="pl-tables">
                                        <tr>
                                            <th>Team</th>
                                            <th> </th>
                                            <th>Pld</th>
                                            <th>Pts</th>
                                        </tr>
                                        <?php
                                        $count = 0;
                                        foreach ($competition_logs as $log): ?>
                                            <?php if ($count < 8) { ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?php echo get_template_directory_uri();?>/images/teamlogos/<?php echo $log->team->id ?>.png">
                                                    </td>
                                                    <td>
                                                        <?php if ($competition_id == 63): ?>
                                                            <a href="/football/europe/england/premier-league/teams/<?php echo slugify($log->team->team_name) ?>">
                                                                <?php echo $log->team->team_name ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <?php echo $log->team->team_name ?>
                                                        <?php endif ?>
                                                    </td>
                                                    <td><?php echo $log->played ?></td>
                                                    <td><?php echo $log->points ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php
                                            $count++;
                                        endforeach;
                                        ?>
                                    </table>
                                </div>
                                <!-- End PL TABLES -->
                            </div>
                            <!-- End Tables -->

                            <!-- Fixtures -->
                            <div role="tabpanel" class="tab-pane fade" id="fixtures">
                                <!-- PL FIXTURES -->
                                <div>
                                    <!-- Fixtures -->
                                    <?php $fixtures_handle = array(); ?>
                                    <?php foreach ($competition_fixtures as $fixture): ?>
                                        <?php $fixtures_handle[date("l j F Y", strtotime($fixture->fixture_date_time))][] = $fixture; ?>
                                    <?php endforeach; ?>

                                    <?php foreach ($fixtures_handle as $key => $fixtures): ?>
                                        <span class="fixtures-date"><?php echo $key ?> (All Times CAT)</span>
                                        <table class="pl-fixtures">
                                            <tbody>
                                            <?php foreach ($fixtures as $fixture): ?>
                                                <?php //$fixture_date_time = strtotime($fixture->fixture_date_time) ?>
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
                                                <tr>
                                                    <td><?php echo date("H:i", $fixture_date_time) ?></td>
                                                    <td><?php echo $home_team ?></td>
                                                    <td>vs</td>
                                                    <td><?php echo $away_team ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php endforeach; ?>
                                    <?php if (count($fixtures_handle) == 0): ?>
                                        <div class="no-data" style="text-align: center; padding:10px">There are currently no fixtures today</div>
                                    <?php endif; ?>
                                </div>
                                <!-- End PL FIXTURES -->
                            </div>
                            <!-- End Fixtures -->

                            <!-- Results -->
                            <div role="tabpanel" class="tab-pane fade" id="results">
                                <!-- PL RESULTS -->
                                <div>
                                    <!-- Results -->
                                    <?php $results_handle = array(); ?>
                                    <?php foreach ($competition_results as $result): ?>
                                        <?php $results_handle[date("l j F Y", strtotime($result->fixture_date_time))][] = $result; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($results_handle as $key => $results): ?>
                                        <span class="fixtures-date"><?php echo $key ?></span>
                                        <table class="pl-results">
                                            <?php foreach ($results as $result): ?>
                                                <?php $home_team = $result->home->team_name ?>
                                                <?php $away_team = $result->away->team_name ?>
                                                <tr>
                                                    <td><?php echo $home_team ?></td>
                                                    <td>
                                                        <?php $match = sanitize_title_for_query($home_team) . "-vs-" . sanitize_title_for_query($away_team); ?>
                                                        <a href="<?php echo site_url() ?>/match/<?php echo $match ?>/<?php echo $result->fixture_id ?>">
                                                            <?php echo $result->result->home_final_score ?> - <?php echo $result->result->away_final_score ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $away_team ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    <?php endforeach; ?>
                                    <?php if (count($competition_results) == 0): ?>
                                        <table class="pl-fixtures">
                                            <tr>
                                                <td colspan="3">There are currently no results data available</td>
                                            </tr>
                                        </table>
                                    <?php endif; ?>
                                </div>
                                <!-- End PL RESULTS -->
                            </div>
                            <!-- End Results -->

                        </div>
                    </div>

                    <div class="more-news-link">
                        <a href="">More <i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </section>
            </div>

        <?php } ?>
        <?php
    }
}

add_action('widgets_init', function () {
    register_widget('rugby_tables_fixtures_results_widget');
});
?>