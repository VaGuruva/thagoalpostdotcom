<?php

$competition_id =  $_GET['comp'];
$section        =  $_GET['section'];

if ($section == 'football') {

    $html = $data->get_cache ($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], $competition_id, 120, 'football');
?>
<?php 
//header("Cache-Control: max-age=2592000");
+header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
+header('Cache-Control: no-store, no-cache, must-revalidate');
+header('Cache-Control: post-check=0, pre-check=0', FALSE);
+header('Pragma: no-cache');
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo "<?xml version='1.0' encoding='".get_option('blog_charset')."'?>\n";
?>
<results>
<info>Generated by RSS Feed Manager</info>
<competition id="<?php echo $competition_id; ?>"><?php echo $competition_name; ?></competition>
<details>
<?php

$count_games = 0;

$fixturesCount = 0;
$resultsCount = 0;

foreach ($html as $set) {

/*if ($set->result != null) {
    $result_home = $set->result->home_final_score;
    $result_away = $set->result->away_final_score;*/

if ($set->score != null) {
    $result_home = $set->score->home_score;
    $result_away = $set->score->away_score;    
} else {
    $result_home = '';
    $result_away = '';
}

//Bundesliga Fix on the teams
$home_team = '';
$away_team = '';
//1. FSV Mainz 05
if ($set->home->team_name == '1. FSV Mainz 05') {
    $home_team = 'M05';
}

if ($set->away->team_name == '1. FSV Mainz 05') {
    $away_team = 'M05';
} 

if ($set->home->team_name == '1. FC Köln') {
    $home_team = 'FCK';
}

if ($set->away->team_name == '1. FC Köln') {
    $away_team = 'FCK';
} 

if ($home_team == '') {
    $home_team = $set->home->team_name;
}
if ($away_team == '') {
    $away_team = $set->away->team_name;
}



$status = 'fixtures';



    /*
     *
     * Hacking in the LIVE matches ...
     *
     */

    $football_data = new Football_Data();
    $match_teams = $football_data->match_by_data(array(
        "match_id" => $set->fixture_id,
        "section" => "teams"
    ));

    $home_squad_count = count($match_teams->home->squad);

    if  ($set->score->status == '') {
        if ($home_squad_count){
            $status = 'live';
        }
    }

    if ($set->score->status == 'fulltime') {
        $status = 'results';
    }

?>
<?php
if ($competition_id == 9) {

$time = strtotime(date('Y-m-d 00:00:00'));

$first_day_of_week = date('2016-05-21 00:00:00', strtotime('Last Saturday', $time));
//$last_day_of_week = date('Y-m-d 00:00:00', strtotime('Next Friday', $time));

$game_time = date('Y-m-d H:i:s', strtotime($set->fixture_date_time));

$game_date = date('Y-m-d', strtotime($set->fixture_date_time));
$last_friday = date("Y-m-d", strtotime("last week friday"));

    if (($count_games < 50)) {


        if (($status == 'fixtures') || ($status == 'live')){
            if ($fixturesCount <= 9 ) {
                ?>

                <?php if ($status == 'live'): ?>
                    <?php
                    $football_data = new Football_Data();
                    $match_scores = $football_data->match_by_scores(array(
                        "match_id" => $set->fixture_id
                    ));

                    $result_home = $match_scores[0]->home_score;
                    $result_away = $match_scores[0]->away_score;

                    ?>

                    <item>
                        <id><?php echo $set->fixture_id; ?></id>
                        <comp-name><?php echo $set->competition_name; ?></comp-name>
                        <comp-id><?php echo $competition_id; ?></comp-id>
                        <home-team><?php echo substr($home_team, 0, 3); ?></home-team>
                        <home-team-id><?php echo $set->home_team_id; ?></home-team-id>
                        <home-scorers></home-scorers>
                        <away-team><?php echo substr($away_team, 0, 3); ?></away-team>
                        <away-team-id><?php echo $set->away_team_id; ?></away-team-id>
                        <away-scorers><?php echo $count_games; ?></away-scorers>
                        <result-home><?php echo $result_home; ?></result-home>
                        <result-away><?php echo $result_away; ?></result-away>
                        <status><?php echo $status; ?></status>
                        <datetime><?php echo date("D, d M Y H:i:s O", strtotime($set->fixture_date_time)); ?></datetime>
                    </item>
                <?php endif ?>
                <?php if ($status == 'fixtures'): ?>

                    <item>
                        <id><?php echo $set->fixture_id; ?></id>
                        <comp-name><?php echo $set->competition_name; ?></comp-name>
                        <comp-id><?php echo $competition_id; ?></comp-id>
                        <home-team><?php echo substr($home_team, 0, 3); ?></home-team>
                        <home-team-id><?php echo $set->home_team_id; ?></home-team-id>
                        <home-scorers></home-scorers>
                        <away-team><?php echo substr($away_team, 0, 3); ?></away-team>
                        <away-team-id><?php echo $set->away_team_id; ?></away-team-id>
                        <away-scorers><?php echo $count_games; ?></away-scorers>
                        <result-home><?php echo $result_home; ?></result-home>
                        <result-away><?php echo $result_away; ?></result-away>
                        <status><?php echo $status; ?></status>
                        <datetime><?php echo date("D, d M Y H:i:s O", strtotime($set->fixture_date_time)); ?></datetime>
                    </item>
                <?php endif ?>

                <?php
                $fixturesCount++;
            }
        }

        if (($status == 'results') && ($game_date >= $last_friday)){
            if ($resultsCount <= 9 ) {

                ?>
                <item>
                    <id><?php echo $set->fixture_id; ?></id>
                    <comp-name><?php echo $set->competition_name; ?></comp-name>
                    <comp-id><?php echo $competition_id; ?></comp-id>
                    <home-team><?php echo substr($home_team, 0, 3); ?></home-team>
                    <home-team-id><?php echo $set->home_team_id; ?></home-team-id>
                    <home-scorers></home-scorers>
                    <away-team><?php echo substr($away_team, 0, 3); ?></away-team>
                    <away-team-id><?php echo $set->away_team_id; ?></away-team-id>
                    <away-scorers><?php echo $count_games; ?></away-scorers>
                    <result-home><?php echo $result_home; ?></result-home>
                    <result-away><?php echo $result_away; ?></result-away>
                    <status><?php echo $status; ?></status>
                    <datetime><?php echo date("D, d M Y H:i:s O", strtotime($set->fixture_date_time)); ?></datetime>
                </item>
                <?php
                $resultsCount++;
            }
        }


     $count_games++;

    }

/*    if ($count_games == 0) {
       ?>
            <item>
            <id><?php echo $set->fixture_id; ?></id>
            <comp-id><?php echo $competition_id; ?></comp-id>
            <home-team><?php echo substr($home_team, 0, 3); ?></home-team>
            <home-team-id><?php echo $set->home_team_id; ?></home-team-id>
            <home-scorers></home-scorers>
            <away-team><?php echo substr($away_team, 0, 3); ?></away-team>
            <away-team-id><?php echo $set->away_team_id; ?></away-team-id>
            <away-scorers></away-scorers>
            <result-home><?php echo $result_home; ?></result-home>
            <result-away><?php echo $result_away; ?></result-away>
            <datetime><?php echo date("D, d M Y H:i:s O", strtotime($set->fixture_date_time)); ?></datetime>
            </item>
        <?php

    }*/


} else {
?>
            <item>
            <id><?php echo $set->fixture_id; ?></id>
            <comp-name><?php echo $set->competition_name; ?></comp-name>
            <comp-id><?php echo $competition_id; ?></comp-id>
            <home-team><?php echo substr($home_team, 0, 3); ?></home-team>
            <home-team-id><?php echo $set->home_team_id; ?></home-team-id>
            <home-scorers></home-scorers>
            <away-team><?php echo substr($away_team, 0, 3); ?></away-team>
            <away-team-id><?php echo $set->away_team_id; ?></away-team-id>
            <away-scorers></away-scorers>
            <result-home><?php echo $result_home; ?></result-home>
            <result-away><?php echo $result_away; ?></result-away>
             <status><?php echo $status; ?></status>
            <datetime><?php echo date("D, d M Y H:i:s O", strtotime($set->fixture_date_time)); ?></datetime>
            </item>
<?php } ?>
<?php } ?>
</details>
</results>
<?php } ?>
<?php if ($section == 'rugby') { 

$html = $data->get_cache ($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], $competition_id, 120, 'rugby');

//header("Cache-Control: max-age=2592000");
+header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
+header('Cache-Control: no-store, no-cache, must-revalidate');
+header('Cache-Control: post-check=0, pre-check=0', FALSE);
+header('Pragma: no-cache');
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo "<?xml version='1.0' encoding='".get_option('blog_charset')."'?>\n";
?>
<results>
    <info>Generated by RSS Feed Manager</info>
    <language id="en">English</language>
    <details>
    <?php

    $fixtures_count = 0;
    $fixtures = $html['fixtures'][0];

    $todays_fixture_ids = $html['today_fixture_ids'];

    foreach ($fixtures as $set) { ?>

        <?php
            $date_time = $set->game_date . ' '. $set->game_time;
            $result_home = $set->team_score_1;
            $result_away = $set->team_score_2;
            $status = 'fixtures';

            if (in_array($set->id , $todays_fixture_ids)){

                $rugby_data = new Rugby_Data();
                $GET_SCORES = "getsummarymatchstatsbymatchid/$set->id";
                $scores = $rugby_data->request_data($GET_SCORES);

//                var_dump($scores);
                $result_home = ($scores->home_team_score >= 0) ? $scores->home_team_score : '';
                $result_away = ($scores->away_team_score >= 0)  ? $scores->away_team_score : '';

                $status = 'live';
            }
        ?>

        <?php if ($fixtures_count < 8) { ?>
            <item>
                <id><?php echo $set->id; ?></id>
                <comp-name><?php echo $set->competition_name; ?></comp-name>
                <comp-id><?php echo $competition_id; ?></comp-id>
                <home-team><?php echo substr($set->team_name_1, 0, 3); ?></home-team>
                <home-team-id><?php echo $set->team_id_1; ?></home-team-id>
                <home-scorers></home-scorers>
                <away-team><?php echo substr($set->team_name_2, 0, 3); ?></away-team>
                <away-team-id><?php echo $set->team_id_2; ?></away-team-id>
<!--                <away-scorers>--><?php //echo $count_games; ?><!--</away-scorers>-->
                <result-home><?php echo $result_home; ?></result-home>
                <result-away><?php echo $result_away; ?></result-away>
                <status><?php echo $status; ?></status>
                <datetime><?php echo date("D, d M Y H:i:s O", strtotime($date_time)); ?></datetime>
            </item>
        <?php  $fixtures_count++;  }?>

    <?php } ?>
    <?php
    $results_count = 0;
    $results = $html['results'][0];

    $status = 'results';
    foreach ($results as $set) { ?>
        <?php $date_time = $set->game_date . ' '. $set->game_time ?>

        <?php if ($results_count < 8) { ?>
            <item>
                <id><?php echo $set->id; ?></id>
                <comp-name><?php echo $set->competition_name; ?></comp-name>
                <comp-id><?php echo $competition_id; ?></comp-id>
                <home-team><?php echo substr($set->team_name_1, 0, 3); ?></home-team>
                <home-team-id><?php echo $set->team_id_1; ?></home-team-id>
                <home-scorers></home-scorers>
                <away-team><?php echo substr($set->team_name_2, 0, 3); ?></away-team>
                <away-team-id><?php echo $set->team_id_2; ?></away-team-id>
                <away-scorers><?php echo $count_games; ?></away-scorers>
                <result-home><?php echo $set->team_score_1; ?></result-home>
                <result-away><?php echo $set->team_score_2; ?></result-away>
                <status><?php echo $status; ?></status>
                <datetime><?php echo date("D, d M Y H:i:s O", strtotime($date_time)); ?></datetime>
            </item>
            <?php  $results_count++;  }?>

    <?php } ?>



    </details>
</results>
<?php } ?>
<?php if ($section == 'cricket') { 

$html = $data->get_cache ($_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'], $competition_id, 120, 'cricket');

header("Cache-Control: max-age=2592000");
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
echo "<?xml version='1.0' encoding='".get_option('blog_charset')."'?>\n";
?>
<results>
    <info>Generated by RSS Feed Manager</info>
    <language id="en">English</language>
    <details><?php echo $html; ?>
    </details>
</results>
<?php } ?>