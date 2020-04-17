<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../api/config/Database.php';
include_once '../../models/Notes.php';

$db = new Database();
$conn = $db->getConnection();
$notes = new Notes($conn);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->uid) &&
    !empty($data->title) &&
    !empty($data->body)
) {
    $notes->uid = $data->uid;
    $notes->title = $data->title;
    $notes->body = $data->body;
  
    if ($notes->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "Product was created."));
    }
    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create product."));
    }
}
else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}