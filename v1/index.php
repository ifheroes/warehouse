<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



include('api_manager.php');




$api_action = new api_manager();


/// get user
if(isset($_GET['uuid'])){
    $api_action->api_get_playerpprofil($_GET['uuid']);
    
}

/// create user

$api_action->api_create_playerprofil();

/// update base
$api_action->api_update_base();

/// update advanced
$api_action->api_update_advancedData();

/// update plugindata
$api_action->api_update_pluginData();


?>