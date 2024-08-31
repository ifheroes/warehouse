if($headers['Authorization'] == $token){


} else {
    echo json_encode(['error' => 'Not found']);
}$token = "53fe6aee96be991aa1614ba733f82c91";

$headers = getallheaders();
