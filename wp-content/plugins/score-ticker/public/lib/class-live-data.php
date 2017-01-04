<?php

Class LiveData {

    /*
        Get football data for the last few results and fixtures according
        to competition ID and days
    */
    function get_football_data($competition_id=9, $days=9) {

        $competition_fixtures = $this->fixtures_by_data(array(
            "competition_id" => $competition_id,
            "days" => $days,
            "has_results" => true
        ));

        return $competition_fixtures;
    }

    /*
        Get football data for the last few results and fixtures according
        to competition ID and days
    */
    function get_cricket_data($match_type=3) {

        $cricket_url = 'http://teamtalk-dfs.365.co.za:9007/'; 
        $fixtures    = json_decode($this->get_url($cricket_url.'getfixtures'));
        $results     = json_decode($this->get_url($cricket_url.'getresults'));
        $live        = json_decode($this->get_url($cricket_url.'getlivematches'));

        $xml_cricket    = '';
        $fixtures_count = 0;
        $results_count  = 0;
        $live_count     = 0;

            foreach ($live as $key=>$value) {
                //match_type_id 1/50 overs, 3 Test, 4 20/20
                //match_level_id
                if (($value->match_level_id == 14) && (isset($value->team_1_id)) && ($value->match_type_id == $match_type)) {
                   if ($live_count < 5) { 
                        $xml_cricket .= "<item><id>".$value->id."</id>
                        <comp-id>".$value->competition_id."</comp-id>
                        <comp-name>".$value->competition_name."</comp-name>
                        <home-team>".substr($value->team_1_name, 0, 3)."</home-team>
                        <home-team-id>".$value->team_1_id ."</home-team-id>
                        <home-overs>".$value->team_1_overs_display ."</home-overs>
                        <home-runs>".$value->team_1_runs."</home-runs>
                        <home-wickets>".$value->team_1_wickets ."</home-wickets>
                        <away-team>".substr($value->team_2_name, 0, 3)."</away-team>
                        <away-team-id>".$value->team_2_id ."</away-team-id>
                        <away-overs>".$value->team_2_overs_display ."</away-overs>
                        <away-runs>".$value->team_2_runs."</away-runs>
                        <away-wickets>".$value->team_2_wickets ."</away-wickets>                        
                        <datetime>".date('D, d M Y H:i:s O', strtotime($value->fixture_date.' '.$value->fixture_time)) ."</datetime>
                        <type>live</type>
                    </item>";     

                   } 
                }
               $live_count++;    
            }

            foreach (@$fixtures as $key=>$value) {
                if (($value->match_level_id == 14) && (isset($value->team_1_id)) && ($value->match_type_id == $match_type)) {

                   if ($fixtures_count < 3) { 
                        $xml_cricket .= "<item><id>".$value->id."</id>
                        <comp-id>".$value->competition_id."</comp-id>
                        <comp-name>".$value->competition_name."</comp-name>
                        <home-team>".substr($value->team_1_name, 0, 3)."</home-team>
                        <home-team-id>".$value->team_1_id ."</home-team-id>
                        <home-scorers></home-scorers>
                        <away-team>".substr($value->team_2_name, 0, 3)."</away-team>
                        <away-team-id>".$value->team_2_id ."</away-team-id>
                        <away-scorers />
                        <result-home></result-home>
                        <result-away></result-away>
                        <datetime>".date('D, d M Y H:i:s O', strtotime($value->fixture_date.' '.$value->fixture_time)) ."</datetime>
                        <type>fixture</type>
                    </item>";     
                   } 
                }
               $fixtures_count++;    
            }

            foreach ($results as $key=>$value) {
                if (($value->match_level_id == 14)) {
                if (($value->match_type_id == $match_type)) {
                   //if ($results_count < 6) { 

                       $xml_cricket .= "<item><id>".$value->match_id."</id>
                        <comp-id>".$value->competition_id."</comp-id>
                        <comp-name>".$value->competition_name."</comp-name>
                        <home-team>".substr($value->team_1_name, 0, 3)."</home-team>
                        <home-team-id>".$value->team_1_id ."</home-team-id>
                        <home-overs>".$value->team_1_overs_display ."</home-overs>
                        <home-runs>".$value->team_1_runs."</home-runs>
                        <home-wickets>".$value->team_1_wickets ."</home-wickets>
                        <away-team>".substr($value->team_2_name, 0, 3)."</away-team>
                        <away-team-id>".$value->team_2_id ."</away-team-id>
                        <away-overs>".$value->team_2_overs_display ."</away-overs>
                        <away-runs>".$value->team_2_runs."</away-runs>
                        <away-wickets>".$value->team_2_wickets ."</away-wickets>                        
                        <marquee>".$value->marquee ."</marquee>
                        <datetime>".date('D, d M Y H:i:s O', strtotime($value->fixture_date)) ."</datetime>
                        <type>result</type>
                    </item>";     

                   //} 
                }
                }
               $results_count++;    
            }
            //print_r();
            //die();

        return $xml_cricket;
    }    

    /*
        Get the rugby data
    */
    function get_rugby_data($competition_id=205) {

        $API_OPTIONS =  get_option('teamtalk_rugby_data_api_settings');
        $rugby_api_base_url = trim($API_OPTIONS['rugby_data_api_url']);

        $rugby_url =  'http://'. $rugby_api_base_url;

        $rugby_details = array();

        $fixtures    = $this->get_url($rugby_url.'getfixturesbycompid/'.$competition_id);
        $results     = $this->get_url($rugby_url.'getresultsbycompid/'.$competition_id.'/10');
        $todays_fixtures = $this->get_url($rugby_url.'gettodaysfixtures');
        $a      = (json_decode($fixtures));
        $b      = (json_decode($results));
        $c      = (json_decode($todays_fixtures));

        $rugby_details['fixtures'][] = $a;
        $rugby_details['results'][] = $b;
        foreach($c as $fixture_id){
            $rugby_details['today_fixture_ids'][] = $fixture_id->id;
        }

        return $rugby_details;

        }    

    /*
        Get the endpoints for the football data
    */
    function fixtures_by_data($data = array()) {
        $postfix = "";
        if (!empty($data["competition_id"])) {
            $postfix = "competition/" . $data["competition_id"];
        }
        if (!empty($data["team_id"])) {
            $postfix = "team/" . $data["team_id"];
        }

        if (!empty($data["position"])) {
            $postfix .= "/" . $data["position"];
        }

        if (!empty($data["season_id"])) {
            $postfix .= "/season/" . $data["season_id"];
        }

        if (!empty($data["days"])) {
            $postfix .= "/days/" . $data["days"];
        }

        if (!empty($data["is_live"])) {
            $postfix .= "live";
        }

        if ($postfix == "") {
            $postfix = "competition/9";
        }
        return $this->request_data("/fixtures/{$postfix}");
    }    

    /*
        Make the call the the live API on soccer
    */
    function request_data($url, $flag = false) {

        $url = 'http://developer:olemediagroup@football365api.365.co.za' . $url;

        if ($flag) {
            die($url);
        }
 
        $response = $this->get_url ($url);

        if (!empty($_REQUEST["debug"])) {
            $data = array(
                "url" => $url,
                "response" => $response
            );
        }

        if (!empty($response)) {
            $body = json_decode($response);
            if (!empty($body->error)) {
                return array();
            }
            return $body;
        }

        return array();
    }


    /*
     * Do the CURL with a time out setting
     */

    function get_url ($url) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                               
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }    


    /*
        Caching
        Host and uri for unique keys
        Cache time in seconds (1 day)
    */
    function get_cache ($host, $uri, $competition_id, $cacheTime=10, $sport_type) {        

        $memcached = new Memcached;
        $memcached->addServer('127.0.0.1', 11211);

        // Cache time in seconds (1 day)
        //$cacheTime = 120;
        $cacheKey = "fullpage:{".$host."}{".$uri."}{".$sport_type."}{".$competition_id."}";

        $debugMessage = 'Page retrieved from cache in %f seconds';
        $html = $memcached->get($cacheKey);

        if ( ! $html) {
            $debugMessage = 'Page generated in %f seconds';

            ob_start();
            if ($sport_type == 'football') {

                if ($competition_id == 9) {
                    $html = $this->get_football_data($competition_id, 30);
                } else {
                    $html = $this->get_football_data($competition_id, 30);
                }

            } else if ($sport_type == 'rugby') {

                //die('Rugby');
                $html = $this->get_rugby_data($competition_id);

            }  else if ($sport_type == 'cricket') {

                //die('Rugby');
                $html = $this->get_cricket_data($competition_id);
            }     

            $memcached->set($cacheKey, $html, $cacheTime);

            ob_end_clean();
        }

        return $html;
    }    

}
?>