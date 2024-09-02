<?php

$serveradress = "localhost";
$username = "root";
$password = "";
$database = "ifheroes_warehouse";

$connection = new mysqli($serveradress, $username, $password, $database);

$query = "SELECT player_uuid FROM player_warehouse WHERE player_uuid = '504bf585-2d78-4ef7-864f-71eb47ccef4e';";
$result = $connection->query($query);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo $row['player_uuid'];
    }
}
?>