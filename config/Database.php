<?php

    class Database
    {
        // db params
        private $host = "localhost";
        private $db_name = "footballdb";
        private $user = "root";
        private $password = "";
        private $conn;

        // db connect
        public function connect()
        {
            $this->conn = null;

            try
            {
                $this->conn = new PDO('mysql:host=' . $this->host .';dbname=' . $this->db_name,
                $this->user, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOexception $e)
            {
                echo ("Connection Error: ".$e->getMessage());
            }
            return $this->conn;
        }

        private function getMatchStats($match)
        {
            $stats = array('winner' => null,
                            'loser' => null,
                            'draw' => false
                        );

            if($match["status"] != "complete")
            {
                return $stats;
            }else
            {
                if($match["home_team_goals"] > $match["away_team_goals"])
                {
                    $stats["winner"] = $match["home_team"];
                    $stats["loser"] = $match["away_team"];
                }
                elseif ($match["home_team_goals"] < $match["away_team_goals"])
                {
                    $stats["winner"] = $match["away_team"];
                    $stats["loser"] = $match["home_team"];
                }
                elseif ($match["home_team_goals"] == $match["away_team_goals"]) {
                    $stats["draw"] = true;
                }
                return $stats;
                }
            
        }

        private function executeQuery($query)
        {
            $this->connect();
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();
            $this->conn = NULL;
            return $stmt;
        }

        private function produceQueryResult($query)
        {
            $stmt = $this->executeQuery($query);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        private function movePlayerToArchive($data)
        {
            $moveToArchiveQuery = "INSERT INTO players_archive(player_id, player_name, player_team_id, player_dob, player_photo) VALUE (:player_id, :player_name, :player_team_id, :player_dob, :player_photo)";
            $this->connect();
            $stmt = $this->conn->prepare($moveToArchiveQuery);
            $stmt->execute(array(
                'player_id' => $data['id'],
                'player_name' => $data['name'],
                'player_dob' => $data['dob'],
                'player_team_id' => $data['team_id'],
                'player_photo' => $data['photo']
                ));
            $this->conn = NULL;
        }

        // 
        // get functions
        // 

        public function getUser($login, $pass)
        {
            $query = "SELECT
                        user
                      FROM 
                        users
                      WHERE
                        user='".$login."'
                        AND
                        passw='".$pass."'";
            $users = $this->produceQueryResult($query);
            $num_users = count($users);
            if($num_users > 0)
            {
                return array('login' => True);
            }
            return array('login' => False);   
        }
        
        public function getPlayerDetails($name)
        {
            // create query
            $query1 = "SELECT
                        players.id,
                        name,
                        team_id,
                        dob,
                        photo,
                        position,
                        nationality                        
                    FROM
                        players
                    WHERE
                        players.name='".$name."'";
            
            $playerData = $this->produceQueryResult($query1);
            $playerID = $playerData[0]["id"];

            $query2 = "SELECT 
                        assists,
                        cards_red,
                        cards_yellow,
                        fouls,
                        goals 
                    FROM
                        player_stats
                    WHERE
                        player_id='".$playerID."'";

            $stats = $this->produceQueryResult($query2);

            $merged_array = array_merge($playerData[0], $stats[0]);

            $teams = $this->getTeams();
            foreach ($teams as $team) {
                if($merged_array["team_id"] == $team["team_id"]) 
                {
                    $merged_array["team_name"] = $team["team_name"];
                }
            }

            return $merged_array;
        }

        public function getMatches()
        {
            // create query
            $query = "SELECT
                        match_id,
                        match_date,
                        round_id,
                        home_team,
                        away_team,
                        home_team_goals,
                        away_team_goals,
                        status
                      FROM
                        matches";

            return $this->produceQueryResult($query);
        }
        public function getPlayersByTeam($team)
        {
            // create query
            $query = "SELECT
                          players.id,
                          players.name
                      FROM
                          players
                      JOIN
                          teams
                      ON
                          teams.team_id=players.team_id
                      WHERE
                          teams.team_name='".$team."'";



            return $this->produceQueryResult($query);

        }
        public function getTeams()
        {
            $query = "SELECT
                        team_id,
                        team_name
                      FROM
                        teams";

            return $this->produceQueryResult($query);
        }
        public function getMatchesByLeague($league,$season)
        {
            // create query
            $query = "SELECT
                            matches.id,
                            match_date,
                            h.name AS home,
                            a.name AS away,
                            home_team_goals,
                            away_team_goals
                        FROM
                            matches
                        JOIN
                            teams AS h ON matches.home_team=h.id
                        JOIN
                            teams AS a ON matches.away_team=a.id
                        JOIN rounds ON matches.round_id=rounds.id
                        JOIN seasons ON rounds.season_id=seasons.id
                        JOIN league ON league.id=seasons.league_id
                        WHERE league.title='".$league."'"."
                        AND seasons.name='".$season."'" ;

            return $this->produceQueryResult($query);
        }

        public function getTeamsAndResults()
        {
            $teams = $this->getTeams();
            $matches = $this->getMatches();
            $teams_and_results = $teams;

            $matches_and_results = $matches;
            
            foreach ($matches_and_results as $key => $value) {
                if($matches_and_results[$key]["status"] == "complete")
                {
                    $matches_and_results[$key] = array_merge($matches_and_results[$key],
                                                        $this->getMatchStats($value));
                } 
                else
                {
                    unset($matches_and_results[$key]);
                }        
            }
            foreach ($teams_and_results as $key => $value) {
                $teams_and_results[$key] = array_merge($teams_and_results[$key], array(
                    "wins" => 0,
                    "losses" => 0,
                    "draws" => 0,
                    "points" => 0
                ));
            }
            foreach ($teams_and_results as $key => $value) {

                foreach ($matches_and_results as $keyM => $valueM) {
                    if($value["team_name"] == $valueM["winner"]){
                        $teams_and_results[$key]["wins"] += 1;
                    }
                    elseif ($value["team_name"] == $valueM["loser"]) {
                        $teams_and_results[$key]["losses"] += 1;
                    }
                    elseif (($value["team_name"] == $valueM["home_team"] || $value["team_name"] == $valueM["away_team"]) && $valueM["draw"] == true)
                    {
                        $teams_and_results[$key]["draws"] += 1;
                    }
                }
                $teams_and_results[$key]["points"] = $teams_and_results[$key]["wins"] * 3 + $teams_and_results[$key]["draws"];
            }
            usort($teams_and_results, function ($a,$b){
                if($a["points"] < $b["points"]) return 1;
                if($a["points"] > $b["points"]) return -1;
            });
            return $teams_and_results;
        }

        // 
        // put functions
        // 

        public function updatePlayerDetails(Array $playerDetails)
        {
            $teams = $this->getTeams();
            foreach($teams as $team)
            {
                if($playerDetails["team_name"] == $team["name"])
                {
                    $playerDetails["team_id"] = $team["id"];
                }
            }

            $updatePlayerDetails = "UPDATE
                        players
                    SET 
                        name = '".$playerDetails['name']."',
                        dob='".$playerDetails['dob']."',
                        photo='".$playerDetails['photo']."', 
                        team_id='".$playerDetails['team_id']."'                       
                    WHERE
                        id='".$playerDetails['id']."'";
            
            $this->executeQuery($updatePlayerDetails);
            
        }

        //
        // delete functions 
        //

        public function deletePlayer($player) 
        {
            // move player details to archive
            if($player["name"] != NULL)
            {
                $playerDetailsData = $this->getPlayerDetails($player["name"]);
                $this->movePlayerToArchive($playerDetailsData);
            }
            
            $deletePlayerQuery = "DELETE FROM players WHERE id=".$player['id'].".";
            $this->executeQuery($deletePlayerQuery);

            // check if player details is delited

            $isPlayerDeleted= $this->getPlayerDetails($player["name"]);

            if($isPlayerDeleted == null)
            {
                return true;
            }
            return false;
        }

        public function insertNewPlayer(Array $input)
        {
            $query = "INSERT INTO 
                    players(
                        name,
                        team_id)
                      VALUES (
                        :name,
                        :team_id
            )";
            $this->connect();
            $stmt = $this->conn->prepare($query);
            $stmt->execute(array(
                'name' => $input['name'],
                'team_id' => $input['team_id']
                ));
            $this->conn = NULL;
        }
    }

?>
