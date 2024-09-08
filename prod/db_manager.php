<?php 

class db_connection {
    public function database_connection($serveradress, $username, $password, $database){
        new mysqli($serveradress, $username, $password, $database);
    }

}

/// this class gets all the data from the database like player profile
class db_get {

    public function database_get_playerpprofil($uuid){

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