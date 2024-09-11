<?php 

class db_connection {
    public function database_connection(){
        $connection = new mysqli('localhost', 'root', '', 'ifheroes_warehouse');
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        return $connection; 
    }

}


/// this class is creating some data and profil infos in the database

class db_manager {

    /// this function gets all the data from the database like player profile

    public function database_get_playerpprofil($uuid){

        // creates database connection
        $db_conn = new db_connection();
        $connection = $db_conn->database_connection(); 

        // gets playerprofile from database
        $query = "SELECT * FROM player_warehouse WHERE player_uuid = '$uuid';";
        $result = $connection->query($query); 

        // if exist print it out or return error
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                header('Content-Type: application/json');
                echo $row['player_data'];
            }
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Not found']);
        }

        $connection->close();
    }

    /// creates the profile for the player connecting the first time
    public function database_create_playerprofil($uuid, $name, $data) {

        // creates database connection
        $db_conn = new db_connection();
        $connection = $db_conn->database_connection(); 

        /// performs a query
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

    /// modifyes name in Base Profile - First seciton
    public function database_update_base($uuid, $name) {
        $db_conn = new db_connection();
        $connection = $db_conn->database_connection(); 

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
                    http_response_code(200);
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

    /// modifyes all the static values in advancedData - Second section
    public function database_update_advancedData($uuid,$json) {

    }

    /// modifyes all the static values in pluginData - Third section
    public function database_update_pluginData($uuid,$json){

    }
}

?>