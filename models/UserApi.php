<?php

    include_once 'Request.php';
    include_once 'Response.php';

    class UserApi 
    {
        const ERROR_NOT_FOUND = 'ERROR: Not Found';
        const TOKEN_FIELD = 'token';
        // db items
        private $db;
        // constructor with db
        public function __construct($db)
        {
            $this->db = $db;
        }

        public function get(Request $request, Response $response)
        {
            $resource = $request->getData();
            $result = null;
            if(isset($resource['player']) && $resource['player'] != "")
            {
                $result = $this->getPlayer($resource['player']);
            }
            else if(isset($resource['results']))
            {
                $result = $this->getResults();
            }
            else if(isset($resource['team']) && $resource['team'] != "")
            {
                $result = $this->getTeam($resource['team']);
            }
            else if(isset($resource['matches']))
            {
                $result = $this->getMatches();
            }
            else if(isset($resource['teams']))
            {
                $result = $this->getTeams();
            }

            if ($result)
            {
                $response->setData($result);
                $response->setStatus(Request::STATUS_200);
            }
            else
            {
                $response->setData([self::ERROR_NOT_FOUND]);
                $response->setStatus(Request::STATUS_500);
            }
        }
        public function post(Request $request, Response $response)
        {
            $resource = $request->getData();
           
            if(isset($resource['login']) && $resource['login'] != "" 
                && isset($resource['password']) && $resource['password'] != "")
            {
                $result = json_encode($this->db->getUser($resource['login'], $resource['password']));
                if ($result)
                {
                    $response->setData($result);
                    $response->setStatus(Request::STATUS_200);
                }
                else
                {
                    $response->setData([self::ERROR_NOT_FOUND]);
                    $response->setStatus(Request::STATUS_500);
                }
            }
            else if($resource['name'])
            {
                $this->db->insertNewPlayer($resource);
                $response->setData(Request::STATUS_200);
            }

            

        }
        public function put(Request $request, Response $response)
        {
            $resource = $request->getData();
            if(isset($resource['updatedDetails']) && $resource['updatedDetails'] != "")
            {
                $result = json_encode($this->db->updatePlayerDetails($resource['updatedDetails']));
                if ($result)
                {
                    $response->setStatus(Request::STATUS_200);
                }
                else
                {
                    $response->setData([self::ERROR_NOT_FOUND]);
                    $response->setStatus(Request::STATUS_500);
                }
            }            
        }
        public function delete(Request $request, Response $response)
        {
            $resource = $request->getData();
            if(isset($resource['deletePlayer']) && $resource['deletePlayer'] != "")
            {
                $result = $this->db->deletePlayer($resource['deletePlayer']);
                if($result)
                {
                    $response->setStatus(Request::STATUS_200);
                }
                else
                {
                    $response->setData(Request::STATUS_500);
                }
            }
            
        }
        public function getPlayer($name)
        {
            $result = $this->db->getPlayerDetails($name);

                return $result;
        }

        public function getTeam($team)
        {
            $result = $this->db->getPlayersByTeam($team);
            
            if($result)
            {
                return $result;
            }
        }

        public function getResults()
        {
            $result = $this->db->getTeamsAndResults();
            $num = count($result);

            if($num > 0)
            {
                return $result;
            }
        }

        public function getMatches()
        {
            $result = $this->db->getMatches();
            $num = count($result);

            if($num > 0)
            {
                return $result;
            }
        }

        public function getTeams()
        {
            $result = $this->db->getTeams();
            $num = count($result);

            if($num > 0)
            {
                return $result;
            }
        }
    }