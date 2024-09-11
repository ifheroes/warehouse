<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include('api_manager.php');




/// get user
$api_action = new api_manager();
$api_action->api_get_playerpprofil($_GET['uuid']);

/// create user

$api_action->api_create_playerprofil();

/// update base
$api_action->api_update_base()

?>