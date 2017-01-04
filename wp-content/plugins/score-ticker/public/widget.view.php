<!-- CSS -->
<link rel="stylesheet" href="/wp-content/plugins/score-ticker/public/css/component-animations-bootstrap3.css">
<link rel="stylesheet" href="/wp-content/plugins/score-ticker/public/css/dropdowns-bootstrap3.css">
<link rel="stylesheet" href="/wp-content/plugins/score-ticker/public/css/navbar-bootstrap3.css">
<link rel="stylesheet" href="/wp-content/plugins/score-ticker/public/css/navs-bootstrap3.css">
<link rel="stylesheet" href="/wp-content/plugins/score-ticker/public/css/panels-bootstrap3.css">
<link rel="stylesheet" href="/wp-content/plugins/score-ticker/public/style.css">

<div class="score-ticker">

    <div id="score_container">
        <div class="wrapper">

            <!-- Display Results -->
            <div class="score_display_wrapper">
                <div class="left" style="background: #a4cd39 !important;">

<?php
//select the sport type:
$path           = $_SERVER['REQUEST_URI'];
$premier        = '';
$kenya          = '';
$spain          = '';
$italian        = '';
$bundesliga     = '';
$portuguese     = '';
$french         = '';
$section        = 'Football';
$active         = 'football-active';
$rugby_copy     = 'Super Rugby';
$champ          = '';
$super          = '';

    if ((strpos($path, "/premier-league/") !== false)) {
        $premier = 'selected';
        $copy = 'Premier League';
    } else if ((strpos($path, "/spanish-la-liga/") !== false)) { 
        $spain = 'selected';
        $copy = 'La Liga';
    } else if ((strpos($path, "/kenya-premier-league/") !== false)) { 
        $kenya = 'selected';
        $copy = 'Kenyan Premier League';
    } else if ((strpos($path, "/italian-serie-a/") !== false)) { 
        $italian = 'selected';
        $copy = 'Serie A';
    } else if ((strpos($path, "/german-bundesliga/") !== false)) {             
        $bundesliga = 'selected';
        $copy = 'Bundesliga';
    } else if ((strpos($path, "/portuguese-league/") !== false)) {             
        $portuguese = 'selected';
        $copy = 'Primeira Liga';       
    } else if ((strpos($path, "/french-ligue-1/") !== false)) {             
        $french = 'selected';
        $copy = 'French Ligue 1';           
    } else if ((strpos($path, "/super-rugby/") !== false)) {
        $super = 'selected';
        $rugby_copy = 'Super Rugby';
        $section    = 'Rugby';
    } else if ((strpos($path, "/aviva-premiership/") !== false)) {
        $aviva = 'selected';
        $rugby_copy = 'Aviva Premiership';
        $section    = 'Rugby';
    } else if ((strpos($path, "/rugby-championship/") !== false)) {             
        $champ = 'selected';  
        $rugby_copy = 'Rugby Championship';   
        $section    = 'Rugby';        
    } else if ((strpos($path, "/rugby/") !== false)) {             
        $champ = 'selected';  
        $rugby_copy = 'Rugby Championship';   
        $section    = 'Rugby';        
    }    else {
        $premier = 'selected';
        $copy = 'Premier League';
        $section    = 'Football';  
    }    


if ((strpos($path, "/rugby/") !== false)) { 
?>

                    <style>
                    .standings-controls-dropdown-toggle .uppercase-dropdown {
                        background: transparent url("") no-repeat scroll right center !important;
                    }
                    </style>
                        <div class="m-global-standings-controls">
                        <form class="form-inline">

                                <!-- Menu -->
                                <div class="col-xs-6 col-md-12 dropdown btn-group standings-controls-dropdown-wrapper">
                                        <a href="#" id="rugby-active" class="standings-controls-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="uppercase-dropdown" style="">Rugby</span>
                                            </a>
                                    </div>


                                <!-- Submenu Rugby -->
                                <div class="col-xs-6 col-md-12 dropdown btn-group tournament-controls-wrapper tournament-controls-golf" id="score_container" style="display:block;">
                                        <a href="#" id="golf-active" class="standings-controls-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="lowercase-dropdown" style=""><?php echo $rugby_copy; ?></span>
                                            </a>
                                    <ul class="dropdown-menu tournament-controls score_tabs" role="menu" aria-labelledby="drop7">
                                    <li class="<?php echo $super; ?>" data-link="/score/?comp=205&amp;section=rugby" data-type="rugby" data-url="/rugby/tournaments/super-rugby/">
                                        <a style="cursor: pointer;" id="dropdown-super">Super Rugby</a>
                                    </li>
                                    <li class="<?php echo $champ; ?>" data-link="/score/?comp=214&section=rugby" data-type="rugby" data-url="/rugby/tournaments/rugby-championship/">
                                        <a style="cursor: pointer;" id="dropdown-champ">Rugby Championship</a>
                                    </li>
                                    <li class="<?php echo $aviva; ?>" data-link="/score/?comp=201&amp;section=rugby" data-type="rugby" data-url="/rugby/tournaments/aviva-premiership/">
                                        <a style="cursor: pointer;" id="dropdown-aviva">Aviva Premiership</a>
                                    </li>
                                       </ul>
                                    </div>

                         </form>
                         </div>



<?php
} else {
?>


                    <div class="m-global-standings-controls">
                        <form class="row form-inline">

                            <!-- Menu -->
                            <div class="col-xs-6 col-md-12 dropdown btn-group standings-controls-dropdown-wrapper">
                                <a href="#" id="football-active" class="standings-controls-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="uppercase-dropdown" style="border-bottom: none !important;"><?php echo $section; ?></span>
                                </a>

                                <ul class="dropdown-menu standings-controls-dropdown-list" role="menu" aria-labelledby="drop4">
                                    <li><a style="cursor: pointer;" id="dropdown-football">Football</a></li>
                                    <!--li><a style="cursor: pointer;" id="dropdown-rugby">Rugby</a></li-->
                                    <!-- <li><a style="cursor: pointer;" id="dropdown-cricket">Cricket</a></li> -->
                                </ul>
                            </div>

                            <!-- Submenu Football -->
                            <div class="col-xs-6 col-md-12 dropdown btn-group tournament-controls-wrapper tournament-controls-football" id="score_container">
                                <a href="#" id="football-active" class="standings-controls-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="lowercase-dropdown" style=""><?php echo $copy; ?></span>
                                </a>
                                <ul class="dropdown-menu tournament-controls score_tabs" role="menu" aria-labelledby="drop4">                                
                                <li class="<?php echo $premier; ?>" data-link="/score/?comp=9&section=football" data-type="football" data-url="/football/europe/england/premier-league/">
                                        <a style="cursor: pointer;" id="dropdown-premier">Premier League</a>
                                    </li>                                    
                                    <li class="<?php echo $kenya; ?>" data-link="/score/?comp=53&section=football" data-type="football"  data-url="/football/africa/kenya/kenya-premier-league/">
                                        <a style="cursor: pointer;" id="dropdown-liga">Kenyan League</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Submenu Rugby -->
                            <div class="col-xs-6 col-md-12 dropdown btn-group tournament-controls-wrapper tournament-controls-rugby" id="score_container">
                                <a href="#" id="rugby-active" class="standings-controls-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="lowercase-dropdown" style=""><?php echo $rugby_copy; ?></span>
                                </a>
                                <ul class="dropdown-menu tournament-controls score_tabs" role="menu" aria-labelledby="drop4">
                                    <li class="<?php echo $super; ?>" data-link="/score/?comp=205&section=rugby" data-type="rugby" data-url="/rugby/tournaments/super-rugby/">
                                        <a style="cursor: pointer;" id="dropdown-super">Super Rugby</a>
                                    </li>
                                    <li class="<?php echo $champ; ?>" data-link="/score/?comp=214&section=rugby" data-type="rugby" data-url="/rugby/tournaments/rugby-championship/">
                                        <a style="cursor: pointer;" id="dropdown-champ">Rugby Championship</a>
                                    </li>
                                    <li class="<?php echo $aviva; ?>" data-link="/score/?comp=201&section=rugby" data-type="rugby" data-url="/rugby/tournaments/aviva-premiership/">
                                        <a style="cursor: pointer;" id="dropdown-aviva">Aviva Premiership</a>
                                    </li>
<!--                                     <li data-link="/wp-content/plugins/score-ticker/public/data/data.xml" data-type="rugby">
                                        <a style="cursor: pointer;" id="dropdown-national">Currie Cup</a>
                                    </li>
                                    <li data-link="/wp-content/plugins/score-ticker/public/data/data.xml" data-type="rugby">
                                        <a style="cursor: pointer;" id="dropdown-national">Internationals</a>
                                    </li> -->
                                </ul>
                            </div>

                            <!-- Submenu Cricket -->
                            <div class="col-xs-6 col-md-12 dropdown btn-group tournament-controls-wrapper tournament-controls-cricket" id="score_container">
                                <a href="#" id="cricket-active" class="standings-controls-dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="lowercase-dropdown" style="">Test Series</span>
                                </a>
                                <ul class="dropdown-menu tournament-controls score_tabs" role="menu" aria-labelledby="drop4">
                                    <li data-link="/score/?comp=3&section=cricket" data-type="cricket">
                                        <a style="cursor: pointer;" id="dropdown-premier">Test Series</a>
                                    </li>
                                    <li data-link="/score/?comp=1&section=cricket" data-type="cricket">
                                        <a style="cursor: pointer;" id="dropdown-national">ODI</a>
                                    </li>
                                    <li data-link="/score/?comp=4&section=cricket" data-type="cricket">
                                        <a style="cursor: pointer;" id="dropdown-national">Twenty20</a>
                                    </li>                                    
                                </ul>
                            </div>

                        </form>
                    </div>


<?php
}
?>

                </div>

                <div class="right">
                    <div id="score_display" class="score_display">
                        <ul style="display: block;">

                        </ul>
                        <img id="loading_icon" src="/wp-content/plugins/score-ticker/public/images/loading.gif" style="display: none;">
                    </div>

                    <!-- Left / Right Arrows -->
                    <a class="move_left"><img src="/wp-content/plugins/score-ticker/public/images/left_arrow.png"></a>
                    <a class="move_right"><img src="/wp-content/plugins/score-ticker/public/images/right_arrow.png"></a>
                </div>

            </div>

        </div>
    </div>

</div>