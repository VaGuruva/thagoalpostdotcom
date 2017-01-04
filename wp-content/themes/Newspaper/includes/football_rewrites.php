<?php


add_filter('single_template', function($original){

  global $post;

  $post_type = $post->post_type;
      if ($post_type == 'driver') {
          $base_name = 'single-drivers.php';
          $template = locate_template($base_name);
          if ($template && ! empty($template)) return $template;

    }
  return $original;

});

function the_slugs($echo=true, $post_id, $cat, $home=false){
  $slug = basename(get_permalink());
  $path = $_SERVER['REQUEST_URI'];
  $path = str_replace("news/","",$path);
  $path = str_replace("wp-admin/","",$path);
  $path = substr($path, 0, strpos($path, '/', strpos($path, '/')+1)) . '/';
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  if( $echo ) echo $slug;
  do_action('after_slug', $slug);

  //build the url here
    $key_1_values = get_post_meta( $post_id, '_ttcms_feed_id' );
    //print_r($key_1_values[0]);

        if (!empty($key_1_values[0])) {
            $key = $key_1_values[0]; 
        } else {
            $key = $post_id; 
        }
 
    $category = str_replace(" ", "-", strtolower($cat));  

    if ($category == 'formula-1') {
        $category == 'f1';
    } elseif ($category == 'moto-gp') {
        $category == 'motogp';
    }

    $server = $_SERVER['REQUEST_URI'];
    $server_string  = str_replace("/", " ", strtolower($server)); 

    //post/article key url to be used
    $key_url = '/news/detail/item'.$key.'/'.$slug;


//***********************************
// Set some localisation constants
//***********************************

    //localisation to define the tag
    $local_sec = @Mlp_Helpers::get_blog_language();

    if ($local_sec == 'zh') {

        if (!empty($category)) {  

            $key_url = '/news/detail/item'.$key.'/'.$slug;

            if ( //football
                ($category == 'football')
                ) {

                if (strpos($server_string,' football') === false) {
                    if ($category  != 'football') { 
                        $category = 'football/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/news/'.$slug;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/news/'.$slug;

                }
            } 

            if ( //other-sports
                ($category == 'other-sports')
                ) {

                if (strpos($server_string,' other-sports') === false) {
                    if ($category  != 'other-sports') { 
                        $category = 'other-sports/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/other-sports/news/'.$slug;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/other-sports/news/'.$slug;

                }
            }             

            if ( //motogp
                ($category == 'formula-1') ||
                ($category == 'circuit-guides') ||
                ($category == 'driver-profiles') ||
                ($category == 'driver-standings') ||
                ($category == 'live-commentary') ||
                ($category == 'race-calendar') ||
                ($category == 'team-profiles') ||
                ($category == 'team-standings') 

                ) {

                if (strpos($server_string,' formula-1') === false) {
                    if ($category  != 'formula-1') { 
                        $category = 'formula-1/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/motorsports/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/motorsports/formula-1/'.$category .$key_url;

                }
            }  

            if ( //motogp
                ($category == 'moto-gp')
                ) {

                if (strpos($server_string,' moto-gp') === false) {
                    if ($category  != 'moto-gp') { 
                        $category = 'moto-gp/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/motorsports/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/motorsports/'.$category .$key_url;

                }
            }  


            if ( //motorsports
                ($category == 'motorsports')
                ) {

                if (strpos($server_string,' motorsports') === false) {
                    if ($category  != 'motorsports') { 
                        $category = 'motorsports/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                }
            }    

            if ( //
                ($category == 'golf') || 
                ($category == 'the-open') || 
                ($category == 'the-masters') || 
                ($category == 'us-open') || 
                ($category == 'serie-a')
                ) {

                if (strpos($server_string,' golf') === false) {
                    if ($category  != 'golf') { 
                        $category = 'golf/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                }
            }    


            if ( //basketball
                ($category == 'basketball') || 
                ($category == 'nba') || 
                ($category == 'hbl') || 
                ($category == 'uba')
                ) {

                if (strpos($server_string,' basketball') === false) {
                    if ($category  != 'basketball') { 
                        $category = 'basketball/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                }
            } 

            if ( //tennis
                ($category == 'tennis') || 
                ($category == 'australian-open') || 
                ($category == 'french-open') || 
                ($category == 'wimbledon') ||
                ($category == 'us-open')
                ) {

                if (strpos($server_string,' tennis') === false) {
                    if ($category  != 'tennis') { 
                        $category = 'tennis/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                }
            }  


            if ( //tennis
                ($category == 'baseball') || 
                ($category == 'mlb') || 
                ($category == 'cpbl') || 
                ($category == 'npb')
                ) {

                if (strpos($server_string,' baseball') === false) {
                    if ($category  != 'baseball') { 
                        $category = 'baseball/'.$category;
                    }
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/zh-tw/'.$category .$key_url;

                }
            }                                              




        } else {

            if (strpos($server, 'news') !== false) {
                $url = $server.'detail/item'.$key.'/'.$slug;
            } else {
                $url = $server.'news/detail/item'.$key.'/'.$slug;
            }    
            return $url;

        }    

    } else {

        //English version: Primary blog
        if (!empty($category)) {  

            if ( //football
                ($category == 'premier-league') || 
                ($category == 'bundesliga') || 
                ($category == 'la-liga') || 
                ($category == 'eredivisie') || 
                ($category == 'serie-a') || 
                ($category == 'champions-league') || 
                ($category == 'europa-league') || 
                ($category == 'league-cup') || 
                ($category == 'fa-cup') || 
                ($category == 'asian-football') ||
                ($category == 'afc-cup') ||
                ($category == 'afc-champions-league')
                ) {

                if (strpos($server_string,' football') === false) {
                    $category = 'football/'.$category;
                } 
            }

            if ( //motorsports
                ($category == 'f1') || 
                ($category == 'formula-1') || 
                ($category == 'motogp') || 
                ($category == 'moto-gp') || 
                ($category == 'sbk') || 
                ($category == 'formula-e') || 
                ($category == 'dakar')
                ) {

                if (strpos($server_string,' motorsports') === false) {
                    $category = 'motorsports/'.$category;
                } 
            }  

            //sub for motorsport Formula 1
            if ( //motorsports f1
                ($category == 'bahrain') || 
                ($category == 'abu-dhabi') || 
                ($category == 'australian') || 
                ($category == 'austrian') || 
                ($category == 'bahrain') || 
                ($category == 'belgian') || 
                ($category == 'brazilian') || 
                ($category == 'british') || 
                ($category == 'canadian') || 
                ($category == 'chinese') || 
                ($category == 'european-gp') || 
                ($category == 'german') || 
                ($category == 'hungarian') || 
                ($category == 'italian') || 
                ($category == 'japanese') || 
                ($category == 'malaysian') || 
                ($category == 'mexican') || 
                ($category == 'monaco') || 
                ($category == 'russian') || 
                ($category == 'singapore') || 
                ($category == 'spanish') || 
                ($category == 'united-states') || 
                ($category == 'daniil-kvyat') || 
                ($category == 'esteban-gutierrez') || 
                ($category == 'felipe-massa') || 
                ($category == 'felipe-nasr') || 
                ($category == 'fernando-alonso') || 
                ($category == 'jenson-button') || 
                ($category == 'jolyon-palmer') || 
                ($category == 'kevin-magnussen') || 
                ($category == 'kimi-raikkonen') || 
                ($category == 'lewis-hamilton') || 
                ($category == 'marcus-ericsson') || 
                ($category == 'max-verstappen') || 
                ($category == 'nico-hulkenberg') || 
                ($category == 'nico-rosberg') || 
                ($category == 'pascal-wehrlein') || 
                ($category == 'rio-haryanto') || 
                ($category == 'roberto-merhi') || 
                ($category == 'romain-grosjean') || 
                ($category == 'sebastian-vettel') || 
                ($category == 'sergio-perez') || 
                ($category == 'valtteri-bottas') || 
                ($category == 'will-stevens')

                ) {

                if (strpos($server_string,' motorsports') === false) {
                    $category = 'motorsports/'.$category;
                }         
            }

            if ( //tennis
                ($category == 'australian-open')
                ) {

                if (strpos($server_string,' tennis') === false) {
                    $category = 'tennis/'.$category;
                } 
            }     

            if ( //golf
                ($category == 'lpga')
                ) {

                if (strpos($server_string,' golf') === false) {
                    $category = 'golf/'.$category;
                } 
            }      

            if ( //baseball
                ($category == 'mlb')
                ) {

                if (strpos($server_string,' baseball') === false) {
                    $category = 'baseball/'.$category;
                } 
            }   

            if ( //tennis
                ($category == 'tennis') || 
                ($category == 'australian-open') || 
                ($category == 'french-open') || 
                ($category == 'wimbledon') ||
                ($category == 'us-open') ||
                ($category == 'u.s.-open')
                ) {

                if (strpos($server_string,' tennis') !== false) {
                    if ($category  != 'tennis') { 
                        $category = 'tennis/'.$category;
                    }
                    if (strpos($server_string,' us-open') !== false) {
                        $category = 'tennis/us-open';
                    }    
                    
                    return "http://".$_SERVER['HTTP_HOST'].'/'.$category .$key_url;

                } else {
                    return "http://".$_SERVER['HTTP_HOST'].'/'.$category .$key_url;

                }
            }  

            if ($home === true) {

                //build the section for the football section
                if ( //football
                    ($category == 'premier-league') || 
                    ($category == 'bundesliga') || 
                    ($category == 'la-liga') || 
                    ($category == 'eredivisie') || 
                    ($category == 'serie-a') || 
                    ($category == 'champions-league') || 
                    ($category == 'europa-league') || 
                    ($category == 'league-cup') || 
                    ($category == 'fa-cup') || 
                    ($category == 'asian-football') ||
                    ($category == 'afc-cup') ||
                    ($category == 'afc-champions-league')
                    ) 
                {                    
                    $category = 'football/'.$category;
                }


                //return the link formation for the homepage and other widgets
                return "http://".$_SERVER['HTTP_HOST'].'/'.$category .'/news/detail/item'.$key.'/'.$slug;

            }


             if ( //sub sections of other
                ($category == 'cricket') ||
                ($category == 'basketball') ||
                ($category == 'baseball') ||
                ($category == 'badminton') ||
                ($category == 'boxing') ||
                ($category == 'other-sports') ||            
                ($category == 'ufc')
                ) 
             {
                if ($home === true) {
                    return $category.'/news/detail/item'.$key.'/'.$slug;
                } else {
                    return $path.'news/detail/item'.$key.'/'.$slug;
                } 

            }    




                $url = $path.$category.'/news/detail/item'.$key.'/'.$slug;
        } else {

            if (strpos($server, 'news') !== false) {
                $url = $server.'detail/item'.$key.'/'.$slug;
            } else {
                $url = $server.'news/detail/item'.$key.'/'.$slug;
            }    
        }
      return $url;

    }   //end localisation  
}

    function determine_main_baskets ($categories){

        $basket = '';
        $amount = 1;
        $parent = $categories[0]->name;

        foreach ( $categories as $category ) {
            if (
                ($category->name  != 'Football') && 
                ($category->name  != 'Top Stories') &&
                ($category->name  != 'Promos') &&
                ($category->name  != 'Latest News') &&
                ($category->name  != 'Motorsport') && 
                //($category->name  != 'Tennis') && 
                ($category->name  != 'Golf') && 
                ($category->name  != 'News') && 
                ($category->name  != 'More') && 
                ($category->name  != 'Uncategorized') &&
                ($category->name  != 'Latest News') &&
                ($category->name  != 'Football Popular Now') &&
                ($category->name  != 'Golf Popular Now') &&
                ($category->name  != 'More Popular Now') &&
                ($category->name  != 'Motorsport Popular Now') &&
                ($category->name  != 'Popular Now') &&
                ($category->name  != 'Tennis Popular Now')
                ) {
                if ($amount == 1) {
                    $basket =  esc_attr( $category->name ); 
                }
               $amount++; 
            }
        }
    	if(!$basket){
    		$basket = $parent;
    	}
        return $basket;
   
}

//
//RSS FEED SETUP
// 
add_action( 'after_setup_theme', 'my_rss_template' );
/**
 * Register custom RSS template.
 */
function my_rss_template() {
    add_feed( 'short', 'my_custom_rss_render' );
}
/**
 * Custom RSS template callback.
 */
function my_custom_rss_render() {
    get_template_part( 'feed', 'short' );
}

function custom_query_vars_filter($vars) {
  $vars[] = 'basket';
  $vars[] = 'section';
  $vars[] = 'comp';
  return $vars;
}
add_filter( 'query_vars', 'custom_query_vars_filter' );
//
//END RSS
//

function pmg_rewrite_add_rewrites()
{
    global $wpdb;
    global $wp_rewrite; 
    //$wp_rewrite->flush_rules();
    //$wp_rewrite->init();
    

    //post_type=gallery&name=
/*    add_rewrite_rule('ufc/news/details/item123465/(.*)/?$','index.php?name=$matches[1]','top');*/

//add_rewrite_rule('football/news$','index.php?category_name=news','top'); 

/*//Football
add_rewrite_rule('football/','index.php?category_name=football','top');    


//Motorsports
add_rewrite_rule('motorsports/','index.php?category_name=motorsport','top'); 
add_rewrite_rule('motorsports/news/','index.php?category_name=news-motorsport','top'); 

*/


    
    //RSS More News
    add_rewrite_rule('rss/basketball?$', 'index.php?feed=short&basket=basketball', 'top');
    add_rewrite_rule('rss/basketball/nba?$', 'index.php?feed=short&basket=nba', 'top');
    add_rewrite_rule('rss/basketball/pba?$', 'index.php?feed=short&basket=pba', 'top');
    add_rewrite_rule('rss/baseball?$', 'index.php?feed=short&basket=baseball', 'top');
    add_rewrite_rule('rss/baseball/mlb?$', 'index.php?feed=short&basket=mlb', 'top');
    add_rewrite_rule('rss/ufc?$', 'index.php?feed=short&basket=ufc', 'top');
    add_rewrite_rule('rss/badminton?$', 'index.php?feed=short&basket=badminton', 'top');
    add_rewrite_rule('rss/boxing?$', 'index.php?feed=short&basket=boxing', 'top');
    add_rewrite_rule('rss/other-sports?$', 'index.php?feed=short&basket=other-sports', 'top');


    //RSS Golf
    add_rewrite_rule('rss/golf/pga-championship$', 'index.php?feed=short&basket=pga-championship', 'top');
    add_rewrite_rule('rss/golf/the-open$', 'index.php?feed=short&basket=the-open', 'top');
    add_rewrite_rule('rss/golf/us-open$', 'index.php?feed=short&basket=us-open', 'top');
    add_rewrite_rule('rss/golf/masters$', 'index.php?feed=short&basket=masters', 'top');
    add_rewrite_rule('rss/golf/lpga$', 'index.php?feed=short&basket=lpga', 'top');
    add_rewrite_rule('rss/golf$', 'index.php?feed=short&basket=golf', 'top');

    //RSS Tennis
    add_rewrite_rule('rss/tennis/us-open?$', 'index.php?feed=short&basket=us-open', 'top');
    add_rewrite_rule('rss/tennis/wimbledon?$', 'index.php?feed=short&basket=wimbledon', 'top');
    add_rewrite_rule('rss/tennis/roland-garros?$', 'index.php?feed=short&basket=roland-garros', 'top');
    add_rewrite_rule('rss/tennis/australian-open?$', 'index.php?feed=short&basket=australian-open', 'top');
    add_rewrite_rule('rss/tennis?$', 'index.php?feed=short&basket=tennis', 'top');

    //RSS Motorsport
    add_rewrite_rule('rss/motorsports/dakar?$', 'index.php?feed=short&basket=dakar', 'top');
    add_rewrite_rule('rss/motorsports/formula-e?$', 'index.php?feed=short&basket=formula-e', 'top');
    add_rewrite_rule('rss/motorsports/sbk?$', 'index.php?feed=short&basket=superbikes', 'top');
    add_rewrite_rule('rss/motorsports/motogp?$', 'index.php?feed=short&basket=motogp', 'top');
    add_rewrite_rule('rss/motorsports/f1?$', 'index.php?feed=short&basket=formula-1', 'top');
    add_rewrite_rule('rss/motorsports?$', 'index.php?feed=short&basket=motorsport', 'top');

    //RSS Football
    add_rewrite_rule('rss/football/asian-football?$', 'index.php?feed=short&basket=asian-football', 'top');
    add_rewrite_rule('rss/football/afc-champions-league?$', 'index.php?feed=short&basket=afc-champions-league', 'top');
    add_rewrite_rule('rss/football/afc-cup?$', 'index.php?feed=short&basket=afc-cup', 'top');
    add_rewrite_rule('rss/football/league-cup?$', 'index.php?feed=short&basket=league-cup', 'top');
    add_rewrite_rule('rss/football/fa-cup?$', 'index.php?feed=short&basket=fa-cup', 'top');
    add_rewrite_rule('rss/football/europa-league?$', 'index.php?feed=short&basket=europa-league', 'top');    
    add_rewrite_rule('rss/football/champions-league?$', 'index.php?feed=short&basket=champions-league', 'top');
    add_rewrite_rule('rss/football/serie-a?$', 'index.php?feed=short&basket=serie-a', 'top');
    add_rewrite_rule('rss/football/eredivisie?$', 'index.php?feed=short&basket=eredivisie', 'top');
    add_rewrite_rule('rss/football/la-liga?$', 'index.php?feed=short&basket=la-liga', 'top');
    add_rewrite_rule('rss/football/bundesliga?$', 'index.php?feed=short&basket=bundesliga', 'top');
    add_rewrite_rule('rss/football/premier-league?$', 'index.php?feed=short&basket=premier-league', 'top');
    add_rewrite_rule('rss/football?$', 'index.php?feed=short&basket=football', 'top');

    //**************************************************************************************************
    //football
    //**************************************************************************************************
    //add_rewrite_rule('football/scores$','index.php?pagename=live-scores','top');
    add_rewrite_rule('football/news$','index.php?category_name=news','top'); 
    add_rewrite_rule('football/football$','index.php?category_name=football','top');
    //add_rewrite_rule('motorsports/f1$','index.php?category_name=formula-1','top');

    //premier league
    add_rewrite_rule('football/premier-league/news?$','index.php?category_name=football/premier-league/news-premier-league','top');
    add_rewrite_rule('football/premier-league/fixtures?$','index.php?category_name=football/premier-league/fixtures-premier-league','top');
    add_rewrite_rule('football/premier-league/standings?$','index.php?category_name=football/premier-league/standings-premier-league','top');
    add_rewrite_rule('football/premier-league$','index.php?category_name=football/premier-league','top');

    //bundesliga
    add_rewrite_rule('football/bundesliga/standings$','index.php?category_name=standings-bundesliga','top');
    add_rewrite_rule('football/bundesliga/results$','index.php?category_name=results-bundesliga','top');
    add_rewrite_rule('football/bundesliga/fixtures$','index.php?category_name=fixtures-bundesliga','top');
    add_rewrite_rule('football/bundesliga/news$','index.php?category_name=news-bundesliga','top');
    add_rewrite_rule('football/bundesliga$','index.php?category_name=football/bundesliga','top');
     
    //la-liga
    add_rewrite_rule('football/la-liga/news$','index.php?category_name=news-la-liga','top');
    add_rewrite_rule('football/la-liga$','index.php?category_name=football/la-liga','top');

    //asian-football
    add_rewrite_rule('football/afc-champions-league$','index.php?category_name=afc-champions-league','top');
    add_rewrite_rule('football/afc-cup$','index.php?category_name=afc-cup','top');
    add_rewrite_rule('football/asian-football/news$','index.php?category_name=news-asian-football','top');
    add_rewrite_rule('football/asian-football$','index.php?category_name=asian-football','top');

    //eredivisie
    add_rewrite_rule('football/eredivisie/standings$','index.php?category_name=standings-eredivisie','top');
    add_rewrite_rule('football/eredivisie/fixtures$','index.php?category_name=fixtures-eredivisie','top');
    add_rewrite_rule('football/eredivisie/news$','index.php?category_name=news-eredivisie','top');
    add_rewrite_rule('football/eredivisie$','index.php?category_name=football/eredivisie','top');

    //champions-league
    add_rewrite_rule('football/champions-league/news$','index.php?category_name=champions-league','top');
    add_rewrite_rule('football/champions-league$','index.php?category_name=football/champions-league','top');

    //serie-a
    add_rewrite_rule('football/serie-a/news$','index.php?category_name=news-serie-a','top');
    add_rewrite_rule('football/serie-a$','index.php?category_name=football/serie-a','top');

    //europa-league
    add_rewrite_rule('football/europa-league/news$','index.php?category_name=news-europa-league','top');
    add_rewrite_rule('football/europa-league$','index.php?category_name=football/europa-league','top');

    //league-cup
    add_rewrite_rule('football/league-cup/news$','index.php?category_name=news-league-cup','top');
    add_rewrite_rule('football/league-cup$','index.php?category_name=football/league-cup','top');  

    //fa-cup
    add_rewrite_rule('football/fa-cup/news$','index.php?category_name=news-fa-cup','top');
    add_rewrite_rule('football/fa-cup$','index.php?category_name=football/fa-cup','top');  

    // END
    //**************************************************************************************************

    //**************************************************************************************************
    //Motorsports
    //**************************************************************************************************

    //circuit-guides
    add_rewrite_rule('motorsports/formula-1/circuit-guides/australian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/australian-grand-prix)','top');

    add_rewrite_rule('motorsports/formula-1/circuit-guides/bahrain-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/bahrain-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/chinese-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/chinese-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/russian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/russian-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/spanish-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/spanish-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/monaco-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/monaco-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/canadian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/canadian-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/grand-prix-europe$','index.php?category_name=motorsport/formula-1/circuit-guides/grand-prix-europe)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/austrian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/austrian-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/british-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/british-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/hungarian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/hungarian-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/german-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/german-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/belgian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/belgian-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/italian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/italian-grand-prix$)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/singapore-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/singapore-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/malaysian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/malaysian-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/japanese-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/japanese-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/united-states-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/united-states-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/mexican-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/amexican-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/brazilian-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/brazilian-grand-prix)','top');
    add_rewrite_rule('motorsports/formula-1/circuit-guides/abu-dhabi-grand-prix$','index.php?category_name=motorsport/formula-1/circuit-guides/abu-dhabi-grand-prix)','top');


    //driver-profiles
    add_rewrite_rule('motorsports/formula-1/driver-profiles$','index.php?category_name=motorsport/formula-1/driver-profiles)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/kevin-magnussen$','index.php?category_name=motorsport/formula-1/drivers/kevin-magnussen)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/rio-haryanto$','index.php?category_name=motorsport/formula-1/drivers/rio-haryanto)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/pascal-wehrlein$','index.php?category_name=motorsport/formula-1/drivers/pascal-wehrlein)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/lewis-hamilton$','index.php?category_name=motorsport/formula-1/drivers/lewis-hamilton)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/nico-rosberg$','index.php?category_name=motorsport/formula-1/drivers/nico-rosberg)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/kimi-raikkonen$','index.php?category_name=motorsport/formula-1/drivers/kimi-raikkonen)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/valtteri-bottas$','index.php?category_name=motorsport/formula-1/drivers/valtteri-bottas)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/felipe-massa$','index.php?category_name=motorsport/formula-1/drivers/felipe-massa)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/daniil-kvyat$','index.php?category_name=motorsport/formula-1/drivers/daniil-kvyat)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/daniel-ricciardo$','index.php?category_name=motorsport/formula-1/drivers/daniel-ricciardo)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/romain-grosjean$','index.php?category_name=motorsport/formula-1/drivers/romain-grosjean)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/sergio-perez$','index.php?category_name=motorsport/formula-1/drivers/sergio-perez)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/nico-hulkenberg$','index.php?category_name=motorsport/formula-1/drivers/nico-hulkenberg)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/max-verstappen$','index.php?category_name=mmotorsport/formula-1/drivers/max-verstappen)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/felipe-nasr$','index.php?category_name=motorsport/formula-1/drivers/felipe-nasr)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/carlos-sainz-jr$','index.php?category_name=motorsport/formula-1/drivers/carlos-sainz-jr)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/jenson-button$','index.php?category_name=motorsport/formula-1/drivers/jenson-button)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/fernando-alonso$','index.php?category_name=mmotorsport/formula-1/drivers/fernando-alonso)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/marcus-ericsson$','index.php?category_name=motorsport/formula-1/drivers/marcus-ericsson)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/esteban-gutierrez$','index.php?category_name=motorsport/formula-1/drivers/esteban-gutierrez)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/jolyon-palmer$','index.php?category_name=motorsport/formula-1/drivers/jolyon-palmer)','top');
    add_rewrite_rule('motorsport/formula-1/drivers/sebastian-vettel$','index.php?category_name=motorsport/formula-1/drivers/sebastian-vettel)','top');

    //F1 Teams
  add_rewrite_rule('motorsport/formula-1/teams/mclaren-honda$','index.php?category_name=motorsport/formula-1/teams/mclaren-honda)','top');
   add_rewrite_rule('motorsport/formula-1/teams/toro-rosso$','index.php?category_name=motorsport/formula-1/teams/toro-rosso)','top');
   add_rewrite_rule('motorsport/formula-1/teams/force-india$','index.php?category_name=motorsport/formula-1/teams/force-india)','top');
   add_rewrite_rule('motorsport/formula-1/teams/sauber-f1$','index.php?category_name=motorsport/formula-1/teams/sauber-f1)','top');
   add_rewrite_rule('motorsport/formula-1/teams/lotus$','index.php?category_name=motorsport/formula-1/teams/lotus)','top');
   add_rewrite_rule('motorsport/formula-1/teams/manor$','index.php?category_name=motorsport/formula-1/teams/manor)','top');
   add_rewrite_rule('motorsport/formula-1/teams/haas-f1$','index.php?category_name=motorsport/formula-1/teams/haas-f1)','top');
   add_rewrite_rule('motorsport/formula-1/teams/williams-2$','index.php?category_name=motorsport/formula-1/teams/williams-2)','top');
   add_rewrite_rule('motorsport/formula-1/teams/red-bull-racing$','index.php?category_name=motorsport/formula-1/teams/red-bull-racing)','top');
   add_rewrite_rule('motorsport/formula-1/teams/mercedes$','index.php?category_name=motorsport/formula-1/teams/mercedes)','top');
   add_rewrite_rule('motorsport/formula-1/teams/ferrari$','index.php?category_name=motorsport/formula-1/teams/ferrari)','top');


    //f1/race-calendar/
    add_rewrite_rule('motorsports/formula-1/race-calendar/australian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/australian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/bahrain-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/bahrain)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/chinese-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/chinese)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/russian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/russian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/spanish-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/spanish)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/monaco-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/monaco)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/canadian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/canadian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/grand-prix-europe$','index.php?category_name=motorsport/formula-1/race-calendar/european-gp)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/austrian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/austrian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/british-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/british)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/hungarian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/hungarian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/german-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/german)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/belgian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/belgian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/italian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/italian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/singapore-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/singapore)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/malaysian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/malaysian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/japanese-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/japanese)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/united-states-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/united-states)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/mexican-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/mexican)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/brazilian-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/brazilian)','top');
    add_rewrite_rule('motorsports/formula-1/race-calendar/abu-dhabi-grand-prix$','index.php?category_name=motorsport/formula-1/race-calendar/abu-dhabi)','top');


    add_rewrite_rule('motorsports/f1/commentary$','index.php?category_name=live-commentary','top'); 
    add_rewrite_rule('motorsports/f1/circuit-guides$','index.php?category_name=motorsport/formula-1/circuit-guides','top'); 
    add_rewrite_rule('motorsports/f1/driver-profiles$','index.php?category_name=motorsport/formula-1/driver-profiles','top');
    add_rewrite_rule('motorsports/f1/team-profiles$','index.php?category_name=team-profiles','top'); 
    add_rewrite_rule('motorsports/f1/race-calendar$','index.php?category_name=race-calendar','top'); 
    add_rewrite_rule('motorsports/f1/team-standings$','index.php?category_name=team-standings','top'); 
    add_rewrite_rule('motorsports/f1/driver-standings$','index.php?category_name=motorsport/formula-1/driver-standings','top'); 
    add_rewrite_rule('motorsports/f1/news$','index.php?category_name=news-formula-1','top'); 
    add_rewrite_rule('motorsports/f1$','index.php?category_name=motorsport/formula-1','top'); 
    add_rewrite_rule('motorsports/formula-1$','index.php?category_name=motorsport/formula-1','top');

    //f1
    add_rewrite_rule('motorsports/news$','index.php?category_name=motorsport/news-motorsport','top'); 
    add_rewrite_rule('motorsports$','index.php?category_name=motorsport','top'); 
    
    //motogp
    add_rewrite_rule('motorsports/motogp/news$','index.php?category_name=motorsport/moto-gp/news-moto-gp','top'); 
    add_rewrite_rule('motorsports/motogp$','index.php?category_name=moto-gp','top');

    //motogp
    add_rewrite_rule('motorsports/sbk/news$','index.php?category_name=motorsport/superbikes/news-superbikes','top'); 
    add_rewrite_rule('motorsports/sbk$','index.php?category_name=superbikes','top');    

    //motogp
    add_rewrite_rule('motorsports/formula-e/news$','index.php?category_name=motorsport/formula-e/news-formula-e','top'); 
    add_rewrite_rule('motorsports/formula-e$','index.php?category_name=formula-e','top');    

    //motogp
    add_rewrite_rule('motorsports/dakar/news$','index.php?category_name=motorsport/dakar/news-dakar','top'); 
    add_rewrite_rule('motorsports/dakar$','index.php?category_name=dakar','top');
 
    // END
    //**************************************************************************************************

    //**************************************************************************************************
    // Golf
    //**************************************************************************************************
    //lpga
    add_rewrite_rule('golf/lpga/news$','index.php?category_name=news-lpga','top'); 
    add_rewrite_rule('golf/lpga$','index.php?category_name=golf/lpga','top');

    //pga-championship
    add_rewrite_rule('golf/pga-championship/leaderboard$','index.php?category_name=leaderboard-pga-championship','top'); 
    add_rewrite_rule('golf/pga-championship/tee-times$','index.php?category_name=tee-times-pga-championship','top'); 
    add_rewrite_rule('golf/pga-championship/news$','index.php?category_name=news-pga-championship','top'); 
    add_rewrite_rule('golf/pga-championship$','index.php?category_name=golf/pga-championship','top'); 

    add_rewrite_rule('golf/news$','index.php?category_name=golf/news-golf','top'); 
    add_rewrite_rule('golf$','index.php?category_name=golf','top'); 

    // END
    //**************************************************************************************************

    //**************************************************************************************************
    // Olympics
    //**************************************************************************************************
    add_rewrite_rule('olympics/medal-tally$','index.php?page=medal-tally','top'); 
    add_rewrite_rule('olympics/news$','index.php?category_name=news-olympics','top'); 
    add_rewrite_rule('olympics$','index.php?category_name=olympics','top'); 

    // END
    //**************************************************************************************************    

    //**************************************************************************************************
    // More
    //**************************************************************************************************  
    add_rewrite_rule('icons-of-asia$','index.php?category_name=more/icons-of-asia','top');

    add_rewrite_rule('baseball/mlb$','index.php?category_name=more/baseball/mlb','top');
    add_rewrite_rule('baseball$','index.php?category_name=more/baseball','top');

    add_rewrite_rule('cricket/scorecard?$','index.php?pagename=cricket-scorecard','top');
    add_rewrite_rule('cricket/scores$','index.php?category_name=live-scores-cricket','top');
    add_rewrite_rule('cricket/results$','index.php?category_name=cricket/results-cricket','top');
    add_rewrite_rule('cricket/fixtures$','index.php?category_name=cricket/fixtures-cricket','top');
    add_rewrite_rule('cricket/t20$','index.php?category_name=cricket/t20','top');
    add_rewrite_rule('cricket/odi$','index.php?category_name=cricket/odi','top');
    add_rewrite_rule('cricket/tests$','index.php?category_name=cricket/internationals','top');
    add_rewrite_rule('cricket/news$','index.php?category_name=cricket/news-cricket','top');
    add_rewrite_rule('cricket$','index.php?category_name=cricket','top');

    add_rewrite_rule('pba$','index.php?category_name=more/baseball/pba','top');
    add_rewrite_rule('nba$','index.php?category_name=more/basketball/nba','top');
    add_rewrite_rule('basketball$','index.php?category_name=more/basketball','top');

    add_rewrite_rule('tennis/scores$','index.php?category_name=live-scores-tennis','top');
    add_rewrite_rule('tennis/news$','index.php?category_name=tennis/news-tennis','top');
    add_rewrite_rule('tennis$','index.php?category_name=tennis','top'); 
        
    add_rewrite_rule('tennis/us-open/scores$','index.php?category_name=scores','top');
    add_rewrite_rule('tennis/us-open/news$','index.php?category_name=news-u-s-open','top');    
    add_rewrite_rule('tennis/us-open/schedule$','index.php?category_name=schedule','top');
    add_rewrite_rule('tennis/us-open$','index.php?category_name=tennis/u-s-open','top');
    
    add_rewrite_rule('ufc/news$','index.php?category_name=more/ufc/news-ufc','top');
    add_rewrite_rule('ufc$','index.php?category_name=more/ufc','top');     

    add_rewrite_rule('badminton$','index.php?category_name=more/badminton','top');  

    add_rewrite_rule('boxing$','index.php?category_name=more/boxing','top'); 

    add_rewrite_rule('volleyball/uaap$','index.php?category_name=more/volleyball/uaap','top'); 
    add_rewrite_rule('volleyball$','index.php?category_name=more/volleyball','top'); 

    add_rewrite_rule('other-sports/news$','index.php?category_name=more/other-sports/news-other-sports','top'); 
    add_rewrite_rule('other-sports$','index.php?category_name=more/other-sports','top');   

    // END
    //**************************************************************************************************      

    //mapping the main sections of the website
    add_rewrite_rule('features/page/(.*)?$','index.php?category_name=features&paged=$matches[1]&page=page%2F$matches[1]','top');
    add_rewrite_rule('features','index.php?category_name=features','top');

    //mapping the main sections of the website
    add_rewrite_rule('transfer-gossip/page/(.*)?$','index.php?category_name=transfer-gossip&paged=$matches[1]&page=page%2F$matches[1]','top');
    add_rewrite_rule('transfer-gossip','index.php?category_name=transfer-gossip','top');


    //test news
    add_rewrite_rule('all-the-news/page/(.*)?$','index.php?category_name=news&paged=$matches[1]&page=page%2F$matches[1]','top');
    add_rewrite_rule('all-the-news','index.php?category_name=news','top');
    add_rewrite_rule('galleries','index.php?category_name=galleries','top');
    add_rewrite_rule('videos','index.php?category_name=videos','top');

    //LiveScores
    add_rewrite_rule('football/scores/match/','index.php?pagename=live-scores','top');
    add_rewrite_rule("match/(.*)/(.*)?$", 'index.php?pagename=football-live-match&match=$matches[3]', "top");

    add_rewrite_rule('cricket/scorecard/','index.php?pagename=cricket-scorecard','top');
    add_rewrite_rule('tennis/stats/','index.php?pagename=tennis-live','top');

    add_rewrite_rule("scoreticker/(.*)/(.*)?$", 'index.php?pagename=scoreticker', "top");

    add_rewrite_rule("motorsports/f1/drivers/sebastian-vettel/?$", 'index.php?post_type=drivers', "top");

    add_rewrite_rule('football/scores?$','index.php?category_name=football/live-scores','top');

}

add_action( 'init', 'pmg_rewrite_add_rewrites' );