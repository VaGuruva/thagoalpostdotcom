<?php
/*
	We write all the football data API calls here to display in the ticker
*/

	function contentGenerator($section=football, $competition_id=9, $days=9) {

		if ($section == 'football') { 
			$competition_fixtures = fixtures_by_data(array(
			                "competition_id" => $competition_id,
			                "days" => $days,
			                "has_results" => true
			            ));
			//$competition_fixtures = array_reverse($competition_fixtures);
		} else {
		  echo 'Data to come...';
		}	
		return $competition_fixtures;
	}

    /*
     * Get fixtures by data
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
        return request_data("/fixtures/{$postfix}");
    }

    function request_data($url, $flag = false) {
    	define('FOOTBALL_USR', 'developer');
   	 	define('FOOTBALL_PASS', 'olemediagroup');
    	define('FOOTBALL_LOCAL_MODE', 'production');
    	define('FOOTBALL_API_URL', 'http://' . FOOTBALL_USR . ':' . FOOTBALL_PASS . '@football365api.365.co.za');

        $url = FOOTBALL_API_URL . $url;

        if ($flag) {
            die($url);
        }
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                               
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

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
?>