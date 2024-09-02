<?php

/// this case is made for POC to request simple data sets from the player warehouse

function createProfile($uuid, $name, $data)
{
    $serveradress = "localhost";
    $username = "root";
    $password = "";
    $database = "ifheroes_warehouse";

    $connection = new mysqli($serveradress, $username, $password, $database);

    // SQL-Abfrage, um die Zeile mit der entsprechenden UUID aus der Tabelle zu holen
    $query = "SELECT * FROM player_warehouse WHERE player_uuid = '$uuid';";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            http_response_code(403);
            echo json_encode(['error' => 'Set already in storage!']);

            }
        
    } else {
        http_response_code(200);
        echo json_encode(['success' => 'Found none created one!']);
        $query = "INSERT INTO `player_warehouse`(`player_uuid`, `player_name`, `player_data`) VALUES ('$uuid','$name','$data');";
        $result = $connection->query($query);

 
    }
}


//// check if data format from url is valid

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



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
        createProfile($basic_value_uuid, $basic_value_name, $minified_json);
    } else {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not found!']);
    }
    
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not found!']);
}
