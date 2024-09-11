<?php

/// import of database manager and class
include('db_manager.php');

/// this class is creating some data and profil infos in the database

class api_manager {
    
    /// this function gets all the data from the database like player profile
    public function api_get_playerpprofil($uuid){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $sql_action = new db_manager();
            $sql_action->database_get_playerpprofil($uuid);

        }
    }

    /// creates the profile for the player connecting the first time
    public function api_create_playerprofil() {
        header("Access-Control-Allow-Methods: POST");
        $sql_action = new db_manager();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = json_decode(file_get_contents("php://input"), true);
        
            // scope selction from json file
            $section_value = $data['section'];
            $basic_value_uuid = $data['schema']['uuid'] ?? null;
            $basic_value_name = $data['schema']['name'] ?? null;
        
            // pattern for schema in database
            $basic_value_data = '{
                "basicData": {
                    "uuid": "'.$basic_value_uuid.'",
                    "name": "'.$basic_value_name.'"
                },
                "advancedData": {
                    "schema":"v1",
                    "language": "DE"
                },
                "pluginData": {
                    "schema":"v1",
                    "values": {}
                    }
                }';    
        
                /// convert to a real json string
                $minified_json = json_encode(json_decode($basic_value_data, true));
        
            /// get all from basic data current only uuid (there is no changing value)
            if ($section_value === 'newPlayerData' && !empty($basic_value_uuid) && !empty($basic_value_name)) {
                $sql_action->database_create_playerprofil($basic_value_uuid, $basic_value_name, $minified_json);
            }
            
        }       
    }

    /// modifyes name in Base Profile - First seciton
    public function api_update_base() {

        header("Access-Control-Allow-Methods: POST");
        $sql_action = new db_manager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = json_decode(file_get_contents("php://input"), true);
        
            /// select scope
        
            $section_value = $data['section'];
        
            /// get all from basic data current only uuid (there is no changing value)
            if ($section_value == 'basicData') {
                $basic_value_uuid = $data['schema']['uuid'];
                $basic_value_name = $data['schema']['name'];
        
                $sql_action->database_update_base($basic_value_uuid, $basic_value_name);
            }
        
 
        }
    }

    /// modifyes all the static values in advancedData - Second section
    public function api_update_advancedData() {
        
    }

    /// modifyes all the static values in pluginData - Third section
    public function api_update_pluginData($uuid,$json){

    }
}
?>