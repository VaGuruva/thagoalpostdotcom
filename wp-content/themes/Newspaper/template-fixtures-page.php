<?php /* Template Name: Football Data */ ?>

<?php get_header(); ?>

<div role="main">
<?php
$path = $_SERVER['REQUEST_URI'];

$opta_styling = '	<link rel="stylesheet" href="http://widget.cloud.opta.net/2.0/css/widgets.opta.css" type="text/css" />
					<!--[if IE 9]>
						<link rel="stylesheet" type="text/css" href="http://widget.cloud.opta.net/2.0/css/ie9.widgets.opta.css" media="screen" />
					<![endif]-->
					<!--[if IE 8]>
						<link rel="stylesheet" type="text/css" href="http://widget.cloud.opta.net/2.0/css/ie8.widgets.opta.css" media="screen" />
					<![endif]-->
					<!--[if IE 7]>
						<link rel="stylesheet" type="text/css" href="http://widget.cloud.opta.net/2.0/css/ie7.widgets.opta.css" media="screen" />
					<![endif]-->
					<style>
					/*-------------------------------------------------------------------*/
					/* Widget */
					/*-------------------------------------------------------------------*/
					
					.opta-widget-container {
					    margin: -15px 0px 0px 4px;
					 }

					.opta-standings h2 {
					    display: none;
					}


					.opta-widget-container thead th {
					    padding: 6px 8px;
					    /* border-top: 1px solid #ccc; */
					    /* border-bottom: 1px solid #ccc; */
					    font-size: 14px;
					    font-weight: 700;
					    color: #fff;
					    text-align: left;
					    background: #012C56;
					    text-transform: uppercase;
					}

					.opta-widget-container thead th.name, .opta-widget-container thead th.team {
					    text-align: left;
					    padding-left: 15px;
					}

					.opta-widget-container .teamlist-onerow tbody th, .opta-widget-container tbody td {
					    padding: 15px 0;
					    border-bottom: 1px solid #ddd;
					    font-size: 11px;
					    color: #000;
					    text-align: center;
					    vertical-align: middle;
					}					

					.opta-widget-container {
					    margin: -15px 0px 0px 4px;
					 }
					
					
					.opta-widget-container .fixtures-plus-list tbody.grouping td, .opta-widget-container .opta-v3-h3 {
					    color: #fff;
					    background: #012C56;
					    font-size: 14px;
					    font-weight: 700;
					    height: 25px;
					    padding: 4px 8px;
					    text-transform: uppercase;
					}
					
					.opta-widget-container .fixtures-plus tr td.match-time abbr {
					    display: inline-block;
					    margin-top: 3px;
					    font-size: 14px;
					    font-weight: 700;
					}
					
					.opta-widget-container .fixtures-plus td.home-team-name .team-name {
					    padding-right: 60px;
					    font-size: 12px;
					}
					
					.opta-widget-container .fixtures-plus td.away-team-name .team-name {
					    padding-right: 60px;
					    font-size: 12px;
					}
					
					td.left.standout.score.score-away,td.right.standout.score.score-home {
					    font-size: 14px;
					}
					
					.opta-widget-container .fixtures-plus tr.aggregate td a {
					    font-style: normal;
					    color: #0059b5;
					    text-transform: uppercase;
					    font-size: 8px;
					    font-weight: 700;
					}
					
					.opta-widget-container .fixtures-plus-list td.standout, .opta-widget-container .fixtures-plus-list td.standout a.external-link {
					    font-weight: 500;
					    font-size: 10px;
					    color: #000;
					}
					
					.opta-widget-container h2.opta-v3 {
					    display: none;
					}
					
					.opta-widget-container .matchstats-lineup {
					    float:inherit;
					}

					.opta-widget-container tbody td.jersey, .opta-widget-container tbody td.position {
					    width: 1em;
					    text-align: center;
					    color: #000;
					    font-size: 14px;
					    font-weight: 700;
					}					
					</style>
';

?>

<?php

// PREMIER LEAGUE DATA

preg_match("/premier-league\/(.*)/", $path, $return_array);
if (isset($return_array[1])) {
	if(rtrim($return_array[1],'/') == 'fixtures'){
		$heading = rtrim($return_array[1],'/');
		// $opta = '<opta widget="fixtures_plus" sport="football" competition="8" season="2016" status="prematch" live="false" start_current_matchday="false" order_by="date_asc" grouping="date" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM" show_sub_grouping="true" pre_match="false" show_crest="true" date_time="false" competition_name="full" team_name="full" opta_logo="false" narrow_limit="400" template="list" show_venue="false"></opta>';
		$opta = '<iframe src="http://video.foxplayasia.com/iframe#/fixtures?competition=premier-league" style="width: 70%; height: 1460px;" frameBorder="0"></iframe>';
	}elseif(rtrim($return_array[1],'/') == 'results'){
		$heading = rtrim($return_array[1],'/');
		$opta = '<opta widget="fixtures_plus" sport="football" competition="8" season="2016" status="fulltime" live="false" start_current_matchday="false" order_by="date_desc" grouping="date" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM" show_sub_grouping="true" pre_match="false" show_crest="true" date_time="false" competition_name="full" team_name="full" opta_logo="false" narrow_limit="400" template="list" show_venue="false"></opta>';
	} elseif(rtrim($return_array[1],'/') == 'standings'){
		$heading = 'Standings';
		// $opta = '<opta widget="standings" sport="football" competition="8" season="2016" tabbed_groups="false" show_layout="full" sorting="false" show_image="true" opta_logo="false" team_name="normal" live="false" narrow_limit="400" show_relegation_avg="false"></opta>';
		$opta = '<iframe src="http://video.foxplayasia.com/iframe#/standings?competition=premier-league" style="width: 100%; height: 1460px;" frameBorder="0"></iframe>';
	}	
?>
        <!-- Component Wrapper 3-->
        <div class="content" style="width: 700px !important; float: left;">
			<header class="articleList__header livescores__header">
				<h3>Premier League <?php echo $heading . ' & Results'; ?></h3>
			</header>			
            <div class="content__body">
			<article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				
				<section class="article__body">
					<?php
					print $opta_styling;
					?>
					<script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
					<script>
						var _optaParams = {
							custID: 'bec00f1d8469360a24a2f5e2d689f24e',
							lang: 'en_GB',
							timezone: 0
						};
					</script>
		    		<?php print $opta; ?>
				</section>
			</article>
<?php
}
?>


<?php

// BUNDESLIGA DATA

preg_match("/bundesliga\/(.*)/", $path, $return_array);
if (isset($return_array[1])) {
	if(rtrim($return_array[1],'/') == 'fixtures'){
		$heading = rtrim($return_array[1],'/');
		// $opta = '<opta widget="fixtures_plus" sport="football" competition="22" season="2016" status="prematch" live="false" start_current_matchday="false" order_by="date_asc" grouping="date" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM" show_sub_grouping="true" pre_match="false" show_crest="true" date_time="false" competition_name="full" team_name="full" opta_logo="false" narrow_limit="400" template="list" show_venue="false"></opta>';
		$opta = '<iframe src="http://video.foxplayasia.com/iframe#/fixtures?competition=Bundesliga" style="width: 100%; height: 1460px;" frameBorder="0"></iframe>';
	}elseif(rtrim($return_array[1],'/') == 'results'){
		$heading = rtrim($return_array[1],'/');
		$opta = '<opta widget="fixtures_plus" sport="football" competition="22" season="2016" status="fulltime" live="false" start_current_matchday="false" order_by="date_desc" grouping="date" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM" show_sub_grouping="true" pre_match="false" show_crest="true" date_time="false" competition_name="full" team_name="full" opta_logo="false" narrow_limit="400" template="list" show_venue="false"></opta>';
	} elseif(rtrim($return_array[1],'/') == 'standings'){
		$heading = 'Standings';
		// $opta = '<opta widget="standings" sport="football" competition="22" season="2016" tabbed_groups="false" show_layout="full" sorting="false" show_image="true" opta_logo="false" team_name="normal" live="false" narrow_limit="400" show_relegation_avg="false"></opta>';
		$opta = '<iframe src="http://video.foxplayasia.com/iframe#/standings?competition=Bundesliga" style="width: 100%; height: 1460px;" frameBorder="0"></iframe>';
	}
?>
        <!-- Component Wrapper 3-->
        <div class="content" style="width:700px !important; float: left;">
			<header class="articleList__header livescores__header">
				<h3>Bundesliga <?php echo $heading . ' & Results'; ?></h3>
			</header>			
            <div class="content__body">
			<article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				
				<section class="article__body">
					<?php
					print $opta_styling;
					?>
					<script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
					<script>
						var _optaParams = {
							custID: 'bec00f1d8469360a24a2f5e2d689f24e',
							lang: 'en_GB',
							timezone: 0
						};
					</script>
		    		<?php print $opta; ?>
				</section>
			</article>
<?php
}
?>

<?php

// EREDIVISIE DATA

preg_match("/eredivisie\/(.*)/", $path, $return_array);
if (isset($return_array[1])) {
	if(rtrim($return_array[1],'/') == 'fixtures'){
		$heading = rtrim($return_array[1],'/');
		// $opta = '<opta widget="fixtures_plus" sport="football" competition="9" season="2016" status="prematch" live="false" start_current_matchday="false" order_by="date_asc" grouping="date" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM" show_sub_grouping="true" pre_match="false" show_crest="true" date_time="false" competition_name="full" team_name="full" opta_logo="false" narrow_limit="400" template="list" show_venue="false"></opta>';
		$opta = '<iframe src="http://video.foxplayasia.com/iframe#/fixtures?competition=Dutch%20Eredivisie" style="width: 100%; height: 1460px;" frameBorder="0"></iframe>';
	}elseif(rtrim($return_array[1],'/') == 'results'){
		$heading = rtrim($return_array[1],'/');
		$opta = '<opta widget="fixtures_plus" sport="football" competition="9" season="2016" status="fulltime" live="false" start_current_matchday="false" order_by="date_desc" grouping="date" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM" show_sub_grouping="true" pre_match="false" show_crest="true" date_time="false" competition_name="full" team_name="full" opta_logo="false" narrow_limit="400" template="list" show_venue="false"></opta>';
	}
	elseif(rtrim($return_array[1],'/') == 'standings'){
		$heading = 'Standings';
		// $opta = '<opta widget="standings" sport="football" competition="9" season="2016" tabbed_groups="false" show_layout="full" sorting="false" show_image="true" opta_logo="false" team_name="normal" live="false" narrow_limit="400" show_relegation_avg="false"></opta>';
		$opta = '<iframe src="http://video.foxplayasia.com/iframe#/standings?competition=Dutch%20Eredivisie" style="width: 100%; height: 1460px;" frameBorder="0"></iframe>';
	}
?>
        <!-- Component Wrapper 3-->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>Eredivisie <?php echo $heading; ?></h3>
			</header>			
            <div class="content__body">
			<article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				
				<section class="article__body">
					<?php
					print $opta_styling;
					?>
					<script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
					<script>
						var _optaParams = {
							custID: 'bec00f1d8469360a24a2f5e2d689f24e',
							lang: 'en_GB',
							timezone: 0
						};
					</script>
		    		<?php print $opta; ?>
				</section>
			</article>
<?php
}
?>

<?php
if ($path == '/football/scores/') {
?>
        <!-- Component Wrapper -->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>Live Scores</h3>
			</header>			
            <div class="content__body">
            <article class="article" style="border-radius: 0px !important; margin-top: 6px;">

				<section class="article__body">
				
				<!-- START - football general livescores -->
				<link rel="stylesheet" href="http://widget.cloud.opta.net/2.0/css/widgets.opta.css" type="text/css" />
				<!--[if IE 9]>
					<link rel="stylesheet" type="text/css" href="http://widget.cloud.opta.net/2.0/css/ie9.widgets.opta.css" media="screen" />
				<![endif]-->
				<!--[if IE 8]>
					<link rel="stylesheet" type="text/css" href="http://widget.cloud.opta.net/2.0/css/ie8.widgets.opta.css" media="screen" />
				<![endif]-->
				<!--[if IE 7]>
					<link rel="stylesheet" type="text/css" href="http://widget.cloud.opta.net/2.0/css/ie7.widgets.opta.css" media="screen" />
				<![endif]-->
				<style>
					/*-------------------------------------------------------------------*/
					/* Widget */
					/*-------------------------------------------------------------------*/
					
					.opta-widget-container {
					    margin: -15px 0px 0px 4px;
					 }
					
					 .opta-widget-container h2.opta-v3 {
					    display: none;
					}
					
					.opta-widget-container .fixtures-plus-list tbody.grouping td, .opta-widget-container .opta-v3-h3 {
					    color: #fff;
					    background: #012C56;
					    font-size: 14px;
					    font-weight: 700;
					    height: 25px;
					    padding: 4px 8px;
					    text-transform: uppercase;
					}
					
					td.match-time.left {
					
					    font-size: 12px;
					    font-weight: 700;
					}
					
					.opta-widget-container .fixtures-plus td.home-team-name .team-name {
					    padding-right: 60px;
					    font-size: 12px;
					}
					
					.opta-widget-container .fixtures-plus td.away-team-name .team-name {
					    padding-left: 60px;
					    font-size: 12px;
					
					}
					
					.opta-widget-container .fixtures-plus tr.aggregate td a {
					    font-style: normal;
					    color: #0059b5;
					    text-transform: uppercase;
					    font-size: 8px;
					    font-weight: 700;
					}
					
					
					.opta-widget-container .fixtures-plus-list td.standout, .opta-widget-container .fixtures-plus-list td.standout a.external-link {
					    font-weight: 500;
					    font-size: 10px;
					    color: #000;
					}
					
					.opta-fixtures_plus div.fixtures-plus-list .subgrouping td { background-color: #183354; }
				</style>	
				<script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
				<script>
					var _optaParams = {
						custID: 'bec00f1d8469360a24a2f5e2d689f24e',
						lang: 'en_GB',
						timezone: 0
					};
				</script>
				<!--<opta widget="fixtures_plus" sport="football" competition="8,9,22,541,605" season="2015" status="prematch" live="true" date_from="2015-12-10" date_to="2015-12-15" days_ahead="7" start_current_matchday="true" order_by="date_asc" grouping="competition" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM yyyy" show_sub_grouping="true" pre_match="true" show_crest="true" date_time="true" team_name="full" opta_logo="false" narrow_limit="400" template="list" show_venue="true"></opta> -->
				<!-- END - football general livescores -->			
							
				<opta widget="fixtures_plus" sport="football" competition="8,9,22,541,605" season="2016" live="true" date_from="<?php echo date('Y-m-d'); ?>" date_to="<?php echo date('Y-m-d'); ?>" start_current_matchday="true" order_by="date_asc" grouping="competition" show_grouping="true" tabbed_groupings="false" month_date_format="MMMM" show_sub_grouping="true" match_link="/football/scores/match/" pre_match="true" show_crest="true" date_time="true" opta_logo="false" narrow_limit="400" template="list" show_venue="true"></opta>

				</section>

			</article>

<?php
}
?>

<?php

// LA LIGA DATA

preg_match("/la-liga\/(.*)/", $path, $return_array);
if (isset($return_array[1])) {
	if(rtrim($return_array[1],'/') == 'fixtures'){
		$heading = rtrim($return_array[1],'/');
		$opta = 'Data coming soon...';
	}elseif(rtrim($return_array[1],'/') == 'results'){
		$heading = rtrim($return_array[1],'/');
		$opta = 'Data coming soon...';
	}
?>
        <!-- Component Wrapper 3-->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>Premier League <?php echo $heading; ?></h3>
			</header>			
            <div class="content__body">
			<article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				
				<section class="article__body">
					<?php
					print $opta_styling;
					?>
					<script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
					<script>
						var _optaParams = {
							custID: 'bec00f1d8469360a24a2f5e2d689f24e',
							lang: 'en_GB',
							timezone: 0
						};
					</script>
		    		<?php print $opta; ?>
				</section>
			</article>
<?php
}
?>

<?php if ($path == '/football/la-liga/standings/') { ?>
        <!-- Component Wrapper -->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>La Liga Standings</h3>
			</header>			
            <div class="content__body">
            <article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				<section class="article__body">
				Data coming soon...
				</section>
			</article>

<?php } ?>

<?php

// CHAMPIONS LEAGUE DATA

preg_match("/champions-league\/(.*)/", $path, $return_array);
if (isset($return_array[1])) {
	if(rtrim($return_array[1],'/') == 'fixtures'){
		$heading = rtrim($return_array[1],'/');
		$opta = 'Data coming soon...';
	}elseif(rtrim($return_array[1],'/') == 'results'){
		$heading = rtrim($return_array[1],'/');
		$opta = 'Data coming soon...';
	}
?>
        <!-- Component Wrapper 3-->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>Premier League <?php echo $heading; ?></h3>
			</header>			
            <div class="content__body">
			<article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				
				<section class="article__body">
					<?php
					print $opta_styling;
					?>
					<script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
					<script>
						var _optaParams = {
							custID: 'bec00f1d8469360a24a2f5e2d689f24e',
							lang: 'en_GB',
							timezone: 0
						};
					</script>
		    		<?php print $opta; ?>
				</section>
			</article>
<?php
}
?>

<?php if ($path == '/football/champions-league/standings/') { ?>
        <!-- Component Wrapper -->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>Champions League Standings</h3>
			</header>			
            <div class="content__body">
            <article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				<section class="article__body">
				Data coming soon...
				</section>
			</article>

<?php } ?>

<?php

// EUROPA LEAGUE DATA

preg_match("/europa-league\/(.*)/", $path, $return_array);
if (isset($return_array[1])) {
	if(rtrim($return_array[1],'/') == 'fixtures'){
		$heading = rtrim($return_array[1],'/');
		$opta = 'Data coming soon...';
	}elseif(rtrim($return_array[1],'/') == 'results'){
		$heading = rtrim($return_array[1],'/');
		$opta = 'Data coming soon...';
	}
?>
        <!-- Component Wrapper 3-->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>Premier League <?php echo $heading; ?></h3>
			</header>			
            <div class="content__body">
			<article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				
				<section class="article__body">
					<?php
					print $opta_styling;
					?>
					<script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
					<script>
						var _optaParams = {
							custID: 'bec00f1d8469360a24a2f5e2d689f24e',
							lang: 'en_GB',
							timezone: 0
						};
					</script>
		    		<?php print $opta; ?>
				</section>
			</article>
<?php
}
?>


<?php if ($path == '/football/europa-league/standings/') { ?>
        <!-- Component Wrapper -->
        <div class="content">
			<header class="articleList__header livescores__header">
				<h3>Europa League Standings</h3>
			</header>			
            <div class="content__body">
            <article class="article" style="border-radius: 0px !important; margin-top: 6px;">
				<section class="article__body">
				Data coming soon...
				</section>
			</article>

<?php } ?>

			<script>
				(function($){
					$('.news-menu-link').addClass('current-menu-item');
				})( jQuery );
			</script>

            </div>
        </div>
        <?php get_sidebar(); ?>

    </div>
<?php get_footer(); ?>
