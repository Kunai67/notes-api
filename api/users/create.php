<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../api/config/Database.php';
include_once '../../models/Users.php';

$db = new Database();
$conn = $db->getConnection();
$users = new Users($conn);

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->firstname) &&
    !empty($data->lastname)
) {
    $users->firstname = $data->firstname;
    $users->lastname = $data->lastname;
  
    if ($users->create()) {
        http_response_code(201);
        echo json_encode(array("message" => "User was created."));
    }
    else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create user."));
    }
}
else {
    http_response_code(400);
    echo json_encode(array("message" => "Data incomplete. Please provide all necessary information."));
}