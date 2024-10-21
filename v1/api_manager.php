<?php

// Import of database manager and class
include('db_manager.php');

// This class is creating some data and profile infos in the database
class api_manager
{

    // This function gets all the data from the database like player profile
    public function api_get_playerpprofil($uuid)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $sql_action = new db_manager();
            $sql_action->database_get_playerpprofil($uuid);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Needs to be a GET']);
            exit;
        }
    }

    // This function deletes all the data for a specific player profile
    public function api_delete_playerpprofil($uuid)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

            $sql_action = new db_manager();
            $sql_action->database_delete_playerpprofil($uuid);
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Needs to be a DELETE']);
            exit;
        }
    }

    // Creates the profile for the player connecting the first time
    public function api_create_playerprofil()
    {
        $sql_action = new db_manager();

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data !== null) {
            // Scope selection from JSON file
            $section_value = $data['section'] ?? '';
            $basic_value_uuid = $data['schema']['uuid'] ?? null;
            $basic_value_name = $data['schema']['name'] ?? null;

            // Pattern for schema in database
            $basic_value_data = '{
                "basicData": {
                    "version": "v1",
                    "uuid": "' . $basic_value_uuid . '",
                    "name": "' . $basic_value_name . '"
                },
                "advancedData": {
                    "language": "DE"
                },
                "pluginData": {
                    "values": {}
                }
            }';

            // Convert to a real JSON string
            $minified_json = json_encode(json_decode($basic_value_data, true));

            // Get all from basic data, currently only UUID (there is no changing value)
            if ($section_value === 'newPlayerData' && !empty($basic_value_uuid) && !empty($basic_value_name)) {
                $sql_action->database_create_playerprofil($basic_value_uuid, $basic_value_name, $minified_json);
            }
        }
    }

    // Modifies name in base profile - First section
    public function api_update_base()
    {
        $sql_action = new db_manager();

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data !== null) {
            // Select scope
            $section_value = $data['section'] ?? '';

            // Get all from basic data, currently only UUID (there is no changing value)
            if ($section_value === 'basicData') {
                $basic_value_uuid = $data['schema']['uuid'] ?? null;
                $basic_value_name = $data['schema']['name'] ?? null;

                if ($basic_value_uuid && $basic_value_name) {
                    $sql_action->database_update_base($basic_value_uuid, $basic_value_name);
                }
            }
        }
    }

    // Modifies all the static values in advancedData - Second section
    public function api_update_advancedData()
    {
        $sql_action = new db_manager();

        $data = json_decode(file_get_contents("php://input"), true);

        if ($data !== null && $data['section'] === 'advancedData') {
            $advanced_value_uuid = $data['schema']['uuid'] ?? null;
            $language = $data['schema']['language'] ?? null;

            if ($advanced_value_uuid && $language) {
                // Hand over to database
                $sql_action->database_update_advancedData($advanced_value_uuid, $language);
            }
        }
    }

    // Modifies all the static values in pluginData - Third section
    public function api_update_pluginData()
    {
        // Read JSON data from the POST body
        $data = json_decode(file_get_contents("php://input"), true);

        // Check if the JSON data was parsed correctly
        if ($data !== null && isset($data['schema'])) {
            $sql_action = new db_manager();

            // Check if both 'uuid' and 'updater' exist in the 'schema'
            if (isset($data['schema']['uuid']) && isset($data['schema']['updater'])) {

                // Get the player profile
                $uuid = $data['schema']['uuid'];
                $updater = $data['schema']['updater'];

                // Check if 'updater' is already an array (decoded JSON)
                if (is_string($updater)) {
                    // If 'updater' is a string, decode it
                    $updater = json_decode($updater, true);
                }

                // Now you can safely use the $updater as an array
                $sql_action->database_update_pluginData($uuid, $updater);

                // Optionally, get the player profile
                $sql_action->database_get_playerpprofil($uuid);
            } else {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'There is something missing in the schema']);
            }
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid JSON input']);
        }
    }
}
