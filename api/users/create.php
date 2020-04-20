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
  
    return $users->create();
}
else {
    return false;
}