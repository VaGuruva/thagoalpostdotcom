<?php
$url = $_SERVER['REQUEST_URI'];
//var_dump($url);

$myHeader = "";
?>

<?php if (strpos($url, "football") || ($url == '/') ) :?>

    <?php

    if ((strpos($url, "premier-league"))  || (strpos($url, "manchester-city")) || (strpos($url, "manchester-united")) ||  (strpos($url, "arsenal"))
    || (strpos($url, "chelsea")) || (strpos($url, "liverpool")) || (strpos($url, "tottenham-hotspur")) || (strpos($url, "leicester-city"))){
        $myHeader  = 'EPL';
        $selected = "selected";
    } elseif ($url == '/'){
        $myHeader  = 'EPL';
        $selectedPL = "selected";
    } elseif ((strpos($url, "spanish-la-liga")) || (strpos($url, "fc-barcelona")) || (strpos($url, "real-madrid"))){
        $myHeader  = 'La Liga';
        $selectedLaliga = "selected";
    } elseif (strpos($url, "kenya-premier-league")){
        $myHeader  = 'Kenyan League';
        $selectedKenya = "selected";
    } elseif (strpos($url, "italian-serie-a") ){
        $myHeader  = 'Serie A';
        $selectedSeriea = "selected";
    }elseif (strpos($url, "portuguese-league") ){
        $myHeader  = 'Primeira Liga';
        $selectedPrimeira = "selected";
    }elseif (strpos($url, "french-ligue-1") ){
        $myHeader  = 'Ligue 1';
        $selectedLigue1 = "selected";
    }elseif (strpos($url, "german-bundesliga") ){
        $myHeader  = 'Bundesliga';
        $selectedBundesliga = "selected";
    }
    ?>

<?php if ($myHeader): ?>
    <div class="widget widget-tables-fix-results">
        <header class="widget__header">
            <h3 id="myHeader"><?php echo $myHeader; ?></h3>
            <div class="select-wrapper-sport">
                <select id="widget_sport_selector" class="widget-sport-select">
                    <option value="football">Football</option>
                   <!--  <option value="rugby">Rugby</option> -->
                </select>
            </div>
            <div class="select-wrapper-football">
                <select id="leaguesfootball" class="widget-league-select sportsleagues">
                    <option value="premier"<?php echo $selectedPL; ?>>Premier League</option>
                    <!--<option value="liga" <?php //echo $selectedLaliga; ?>>La Liga</option>
                    <option value="serie" <?php //echo $selectedSeriea; ?>>Serie A</option>
                    <option value="primeira" <?php //echo $selectedPrimeira; ?>>Primeira Liga</option>-->
                    <option value="kenya" <?php echo $selectedKenya; ?>>Kenyan League</option>
                    <!--<option value="ligue" <?php //echo $selectedLigue1; ?>>Ligue 1</option>
                    <option value="bundesliga" <?php //echo $selectedBundesliga; ?>>Bundesliga</option>-->
                </select>
            </div>
    <!--         <div class="select-wrapper-rugby">
                <select id="leaguesrugby" class="widget-league-select sportsleagues">
                    <option value="super-rugby">Super Rugby</option>
                </select>
            </div> -->
        </header>

        <div id="insert-file"></div>
<?php endif; ?>
<?php else:   ?>

<?php echo "" ?>

<?php endif; ?>