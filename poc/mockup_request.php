<?php

/// this case is made for POC to request simple data sets from the player warehouse

function getPlayerData($uuid)
{
    $serveradress = "localhost";
    $username = "root";
    $password = "";
    $database = "ifheroes_warehouse";


    $connection = new mysqli($serveradress, $username, $password, $database);

    $query = "SELECT * FROM player_warehouse WHERE player_uuid = '$uuid';";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['player_data'];
        }
    } else {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Not found']);
    }
}



//// check if data format from url is valid

if (empty($_GET['uuid'])) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not found']);
} else {
    http_response_code(200);
    header('Content-Type: application/json');

    getPlayerData($_GET['uuid']);

}
