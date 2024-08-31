<?php 

// Header für JSON-Ausgabe setzen und CORS ermöglichen
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$token = "53fe6aee96be991aa1614ba733f82c91";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $headers = getallheaders();

    if($headers['Authorization'] == $token){
        $data = json_decode(file_get_contents("php://input"), true);

        echo $data['name'];

    } else {
        echo json_encode(['error' => 'Not found']);
    }


} else {
    echo json_encode(['error' => 'Not found']);
}

?>