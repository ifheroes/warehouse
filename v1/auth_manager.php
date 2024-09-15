<?php

class auth
{
    public function bearer_token_auth()
    {
        // Check if the 'Authorization' header is set
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
        
            // Read the JSON content from the file
            $json_str = file_get_contents('./sec/auth_token.json');
            
            // Decode the JSON string into an associative array
            $data = json_decode($json_str, true);
        
            // Compare the Authorization header with the stored key
            if ($headers['Authorization'] == $data['key']) {
                return true;
                
            } else {
                
                // Invalid API key
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Unauthorized']);
                return false;
            }
        } else {
            // Error if the API key is not in the header
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Unauthorized']);
            return false;
        }
    }
}
