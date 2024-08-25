<?php 

if (empty($_GET['uuid'])){
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not found']);
} else {
    http_response_code(200);
    header('Content-Type: application/json');

    echo '{"success":"true"}';
}


?>