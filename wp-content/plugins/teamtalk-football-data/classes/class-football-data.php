<?php

class Football_Data {
    /**
     * Retrieves the response from the specified URL using one of PHP's outbound request facilities.
     *
     * @params  $url    The URL of the feed to retrieve.
     * @returns     The response from the URL; null if empty.
     */
    private function request_data($url, $flag = false) {

        $API_OPTIONS =  get_option('teamtalk_football_data_api_settings');
        $football_api_base_url = trim($API_OPTIONS['football_data_api_url']);
        $football_api_password = trim($API_OPTIONS['football_data_api_password']);
        $football_api_username = trim($API_OPTIONS['football_data_api_username']);

        $football_api_url =  'http://' . $football_api_username .':'. $football_api_password . '@' . $football_api_base_url;

        $url = $football_api_url . $url;

        if ($flag) {
            die($url);
        }

        // do a wordpress api call here
        $response = $this->get_url($url);
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
     * Get logs by data
     */

    public function competitions_by_data($data = array()) {
        $postfix = "";
        if (!empty($data["id"])) {
            $postfix = $data["id"];
        }

        if (!empty($data["competition_id"])) {
            $postfix = $data["competition_id"];
        }

        if (!empty($data["season_id"])) {
            $postfix .= "/season/" . $data["season_id"];
        }

        return $this->request_data("/competitions/{$postfix}", !empty($data["debug"]));
    }

    /*
     * Get logs by data
     */

    public function logs_by_data($data = array()) {

        $postfix = "";
        if (!empty($data["competition_id"])) {
            $postfix = $data["competition_id"];
        }

        if (!empty($data["season_id"])) {
            $postfix .= "/season/" . $data["season_id"];
        }

        if (!empty($data["team_id"])) {
            $postfix .= "/team/" . $data["team_id"];
        }

        if (!empty($data["limit"])) {
            $postfix .= "/limit/" . $data["limit"];
        }

        return $this->request_data("/logs/competition/{$postfix}", !empty($data["debug"]));
    }

    /*
     * Get actions by data
     */

    public function actions_by_data($data = array()) {

        $postfix = "";
        if (!empty($data["event"])) {
            $postfix .= $data["event"];
        }

        if (!empty($data["team_id"])) {
            $postfix .= "/team/" . $data["team_id"];
        }

        if (!empty($data["competition_id"])) {
            $postfix .= "/competition/" . $data["competition_id"];
        }

        if (!empty($data["season_id"])) {
            $postfix .= "/season/" . $data["season_id"];
        }

        if (!empty($data["debug"])) {
            die("/actions/{$postfix}");
        }

        return $this->request_data("/actions/{$postfix}", !empty($data["debug"]));
    }

    /*
     * Get match by data
     */

    public function match_by_data($data = array()) {

        $postfix = "";
        if (!empty($data["match_id"])) {
            $postfix = $data["match_id"];
        }

        if (!empty($data["section"])) {
            $postfix .= "/" . $data["section"];
        }

        return $this->request_data("/match/{$postfix}", !empty($data["debug"]));
    }

    /*
     * Get match scores
     */

    public function match_by_scores($data = array()) {

        $postfix = "";
        if (!empty($data["match_id"])) {
            $postfix = $data["match_id"];
        }

        if (!empty($data["section"])) {
            $postfix .= "/" . $data["section"];
        }

        return $this->request_data("/scores/match/{$postfix}", !empty($data["debug"]));
    }

    /*
     * Get match by data
     */

    public function teams_by_data($data = array()) {
        $postfix = "";
        if (!empty($data["team_id"])) {
            $postfix = $data["team_id"];
        }

        if (!empty($data["competition_id"])) {
            $postfix = "competition/" . $data["competition_id"];
        }

        if (!empty($data["section"])) {
            $postfix .= "/" . $data["section"];
        }
        return $this->request_data("/teams/{$postfix}", !empty($data["debug"]));
    }

    /*
     * Get fixtures by data
     */

    public function fixtures_by_data($data = array()) {
        $postfix = "";

        if (!empty($data["has_results"])) {
            $postfix .= "/results";
        }

        if (!empty($data["is_live"])) {
            $postfix .= "/live";
        }

        if (!empty($data["competition_id"])) {
            $postfix .= "/competition/" . $data["competition_id"];
        }
        if (!empty($data["team_id"])) {
            $postfix .= "/team/" . $data["team_id"];
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

        if (!empty($data["limit"])) {
            $postfix .= "/limit/" . $data["limit"];
        }

        return $this->request_data("/fixtures{$postfix}", !empty($data["debug"]));
    }

    /*
     * Get results by data
     */

    public function results_by_data($data = array()) {
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

        if (!empty($data["limit"])) {
            $postfix .= "/limit/" . $data["limit"];
        }
        
        return $this->request_data("/results/{$postfix}", !empty($data["debug"]));
    }

    /*
     * Check the response and route to next step
     */

    public function check_response($response) {
        if (@$response->code == 404) {
            $this->bug(serialize($response));
            return;
        } else {
            return $response;
        }
    }

    /*
     * We have a bug or broken API, send out an alert via email
     */

    protected function bug($type) {
        $to = FOOTBALLPOOL_DEBUG_EMAIL;
        $subject = '[TTM] Soccer API Error';
        $headers = 'From: ' . FOOTBALLPOOL_DEBUG_RETURN_EMAIL . "\r\n" .
                'Reply-To: ' . FOOTBALLPOOL_DEBUG_RETURN_EMAIL . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $type, $headers);
    }


    protected function get_url ($url, $time_out=2) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);                               
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time_out);
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }      

   public static function update_db_check() {

    } 
    
    /**
     * Further hooks setup, loading files, etc.
     *
     * Note that for hooked methods name equals hook (when possible).
     */
    static function init(  ) {

    }       

}

