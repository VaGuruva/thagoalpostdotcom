<?php

define('DB_HOST_TENNIS', 'teamtalk-dfs.365.co.za');
define('DB_USER_TENNIS', 'tennis');
define('DB_PASS_TENNIS', 's3cu53tennis');
define('DB_NAME_TENNIS', 'tennis_data');


class CustomDatabase
{
    private $db;
    public function __construct() {
        // Connect To Database
        try {
            $this->db = new wpdb(DB_USER_TENNIS, DB_PASS_TENNIS, DB_NAME_TENNIS, DB_HOST_TENNIS);
            $this->db->show_errors(); // Debug
        } catch (Exception $e) {    // Database Error
            echo $e->getMessage();
        }
    }

    //get the tournament
    public function tournament($id=1) {
        $sql = "select * from tournaments where id=".$id;
        return $this->db->get_results($sql);
    }

    //get the competitions
    public function competitions($tournament_id) {
        $sql = "select * from competitions where tournament_id=".$tournament_id;
        return $this->db->get_results($sql);
    }   

    //get the matches
    public function matches($tournament_id, $date_end) {
        $sql = "SELECT 
                    c.id as competition_id, 
                    c.tournament_id as tournament_id,
                    c.name as match_type,
                    c.sex,
                    m.*,
                    t.name as tournament_name,
                    t.location
                FROM 
                    matches as m
                LEFT JOIN competitions AS c ON c.id = m.competition_id
                LEFT JOIN tournaments AS t ON t.id = c.tournament_id
                WHERE
                    m.match_status != 'NULL'
                AND
                    m.match_time <= '".$date_end."'    
                AND 
                    t.id = $tournament_id   
                ORDER BY 
                    m.match_time DESC
                 LIMIT 30   
                        
        ";


        return $this->db->get_results($sql);
    }         

    //get the scores
    public function scores($match_id) {
        $sql = "select * from set_scores where match_id=$match_id ORDER BY set_number ASC";
        return $this->db->get_results($sql);
    }   

}


//print_r ( $Custom_DB->tournament(1) );
//print_r ( $Custom_DB->competitions(1) );

//print_r($Custom_DB->matches(8449, '2013-12-30 00:00:00', '2013-12-31 00:00:00'));
//die();
//print_r ( $Custom_DB->scores(333409) );
//die('test');

?>
