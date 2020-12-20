<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type:application/json");
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");

    include_once 'models/Server.php';
    include_once 'models/UserApi.php';
    include_once 'config/Database.php';

    $server = new Server(new UserApi(new Database));
    $server->listen();
  
 ?>
