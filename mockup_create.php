<?php

/// this case is made for POC to request simple data sets from the player warehouse

function createProfile($uuid, $name)
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

            $data = json_decode($row['player_data'], true);
            if (isset($data['schema']) && is_array($data['schema'])) {
                $data['basicData']['name'] = $name;
            } else {
                $data['basicData'] = ['name' => $name];
            }

            $new_data = json_encode($data);

            $query_update = "UPDATE player_warehouse SET player_name = '$name', player_data = '$new_data' WHERE player_uuid = '$uuid';";
            $update_result = $connection->query($query_update);

             if ($update_result) {
                echo json_encode(['success' => 'Player data updated successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Failed to update player data']);
            } 
        }
    } else {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Player not found']);
    }
}


//// check if data format from url is valid

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $data = json_decode(file_get_contents("php://input"), true);

    /// select scope

    $section_value = $data['section'];

    /// get all from basic data current only uuid (there is no changing value)
    if ($section_value == 'newPlayerData') {
        $basic_value_uuid = $data['schema']['uuid'];
        $basic_value_name = $data['schema']['name'];

        postBasicData($basic_value_uuid, $basic_value_name);
    }

    http_response_code(200);
    header('Content-Type: application/json');
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not found']);
}
