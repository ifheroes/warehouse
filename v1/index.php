<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('api_manager.php');
include('auth_manager.php');

$auth_action = new auth();


// Authenticate the API key
if ($auth_action->bearer_token_auth() == true){

    // API actions are executed only if authentication is successful
    $api_action = new api_manager();
    // Get user
    if(isset($_GET['uuid'])){
        $api_action->api_get_playerpprofil($_GET['uuid']);
    }

    // Create user
    $api_action->api_create_playerprofil();

    // Update base
    $api_action->api_update_base();

    // Update advanced data
    $api_action->api_update_advancedData();

    // Update plugin data
    $api_action->api_update_pluginData();

} else {
    // Authentication failed, the error message is already sent in the auth class
    exit;
}

?>
