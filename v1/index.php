<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('api_manager.php');
include('auth_manager.php');

$auth_action = new auth();


// Authenticate the API key
if ($auth_action->bearer_token_auth() == true) {

    // API actions are executed only if authentication is successful
    $api_action = new api_manager();

    // Get user profile
    if (isset($_GET['uuid'])) {
        $api_action->api_get_playerpprofil($_GET['uuid']);
    }

    // get key to delete profile
    if (isset($_GET['delete'])) {
        $api_action->api_delete_playerpprofil($_GET['delete']);
    }

    $data_schema = json_decode(file_get_contents("php://input"), true);

    if (is_array($data_schema)) {
        if (isset($data_schema['section'])) {

            /// check if there is a new profile needs to be created
            if ($data_schema['section'] == 'newPlayerData') {
                $api_action->api_create_playerprofil();
            }
    
            /// check if it is a basic data manipulation
            if ($data_schema['section'] == 'basicData') {
                $api_action->api_update_base();
            }
    
            /// check if advanced Data needs to be modified
            if ($data_schema['section'] == 'advancedData') {
                $api_action->api_update_advancedData();
            }
    
            /// check if plugin data needs to be added
            if ($data_schema['section'] == 'pluginData') {
                $api_action->api_update_pluginData();
            }
        } else {
            // Fehler: 'section' wurde nicht im JSON angegeben
            http_response_code(400);
            echo json_encode(['error' => 'Missing section in request data']);
        }
    } else {
        // Fehler: Eingehende Daten sind kein gültiges JSON
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON format']);
    }
} else {
    // Authentication failed, the error message is already sent in the auth class
    exit;
}
