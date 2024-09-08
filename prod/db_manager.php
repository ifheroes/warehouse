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

/// this class gets all the data from the database like player profile
class db_get {

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
}

/// this class is creating some data and profil infos in the database

class db_insert {

    /// creates the profile for the player connecting the first time
    public function database_create_playerprofil($uuid, $name) {

    }

    /// modifyes name in Base Profile - First seciton
    public function database_update_base($uuid, $name) {
        
    }

    /// modifyes all the static values in advancedData - Second section
    public function database_update_advancedData($uuid,$json) {

    }

    /// modifyes all the static values in pluginData - Third section
    public function database_update_pluginData($uuid,$json){

    }
}

?>