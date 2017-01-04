=== League Standings ===
Contributors: MarkODonnell
Donate link: http://shoalsummitsolutions.com
Tags: sports,leagues,standings,sports leagues,team standings,rankings  
Requires at least: 3.3.1
Tested up to: 4.4.1
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


THIS PLUGIN HAS BEEN REPLACED BY MSTW LEAGUE MANAGER AND IS NO LONGER SUPPORTED.

== Description ==

Welcome to the MSTW League Standings Plugin from [Shoal Summit Solutions](http://shoalsummitsolutions.com/).

The MSTW League Standings plugin manages standings tables for multiple leagues including the fields used for most major sports (football, soccer, basketball, baseball, hockey). Standings tables are highly configurable. Each column (field) may be hidden and each column may be re-labeled, so fields can be re-purposed for various uses. Site defaults may be set in the Admin Display Settings page but they can be over-ridden by [shortcode] arguements for each individual table. See my development site for some examples [Shoal Summit Solutions Dev Site](http://shoalsummitsolutions.com/dev/league-standings/)

The following features enhance the user experience on both the front and back ends:

* Unlimited Number of Teams and Leagues - may be created. Historical (final) results can be saved.
* Highly configurable standings tables - plugin settings allow an adminstrator to set defaults for a site. But each standings table may configured to show/hide individual columns (fields) and their headings. So data fields may be re-purposed for various uses.
* Standings may be sorted and ordered by win percentage (which is automatically calculated), points, or rank (on the front end).
* "Teams" may be displayed as team name, team mascot, or both (on the front end). (A "team" may be repurposed to be a driver, for example.)
* Filter "All Teams" admin screen by League. This is a really cool feature that allows the admin to filter teams by their leagues. I've wanted this feature for some time and will backfit it into the Game Schedules and Team Rosters plugins.
* Plugin Stylesheet - allows an administrator to style standings tables displays via one simple, well-documented CSS stylesheet (css/mstw-ls-style.css).
* Internationalization - the plugin is fully internationalized (as of v 3.0) and Croatian, Spanish, and Swiss German translations are included with the distribution. (Many thanks to Juraj, Roberto, and Chris!)

= Notes =

* The League Standings plugin is member of the My Sports Team Website (MSTW) family of plugins; a framework for sports team websites. Others include MSTW Schedules & Scoreboards, Team Rosters, Coaching Staffs, and MSTW CSV Exporter, which are available now on [WordPress.org](http://wordpress.org/extend/plugins). [Learn more about MSTW](http://shoalsummitsolutions.com/my-sports-team-website/).

= Helpful Links =

* [Read the complete user's manual at shoalsummitsolutions.com»](http://shoalsummitsolutions.com/category/ls-plugin)

== Installation ==

[See the installation man page at shoalsummitsolutions.com»](http://shoalsummitsolutions.com/ls-installation/) 

== Frequently Asked Questions ==

[See the FAQ page at shoalsummitsolutions.com»](http://shoalsummitsolutions.com/ls-faq/) 

== Screenshots ==

1. Sample Basketball (NBA)League Standings
2. Sample Soccer (Premier) League Standings
3. Sample Hockey (NHL) League Standings
4. Sample NASCAR (Sprint Cup) Standings
5. Editor - all teams (in all leagues) - table
6. Editor - single team
7. Display Settings Admin Page

== Changelog ==

= 1.3 =
* Fixed the league filter in the All Teams table
* Removed the deprecated PHP 4 WP_Widget constructors
* Changed the text domain to league-standings to comply with the new WP plugin I18n standards
* Removed the /lang/ directory. Will use the new WP polygots translation capabilities (See https://make.wordpress.org/plugins/2015/09/01/plugin-translations-on-wordpress-org/)

= 1.3 =
* Fixed a bug which could cause league standings to sort incorrectly. For example: 1, 11, 2, 30, 4 instead of 1, 2, 4, 11, 30
* Improved the display of win percentage so 1 displays as 1.000

= 1.2 =
* Cleared up name collisions in the admin utils for the MSTW Framework. YOU MUST USE THIS VERSION OF THE PLUGIN WITH THE MSTW FRAMEWORK.
* Added a tag (mstw_league_standings) to settings_errors() to prevent multiple "Settings Saved" messages.

= 1.1 =
* Removed Popular Items from Leagues admin screen (annoying)
* Fixed filter on league in Manage All Teams admin screen
* Upgraded MSTW icons on admin menus and screens

= 1.0 =
* Initial release.

== Upgrade Notice ==

The current version of League Standings has been tested on WP 4.3. If you use older version of WordPress, good luck! If you are using a newer version of WP, please let me know how the plugin works, especially if you encounter problems.

Upgrading to this version of League Standings should not impact any existing schedules. (But backup your DB before you upgrade, just in case. :) **NOTE that it will overwrite the css folder and the plugin's stylesheet - mstw-ls-styles.css.** So if you've made modifications to the stylesheet, you may want to move them to a safe location before installing the new version of the plugin.