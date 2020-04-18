<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../../api/config/Database.php';
include_once '../../models/Users.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare users object
$users = new Users($db);
  
// get users id
$data = json_decode(file_get_contents("php://input"));
  
// set users id to be deleted
$users->id = $data->id;
  
// delete the users
if($users->delete()) {
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "User deleted."));
}
  
// if unable to delete the users
else {
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete users."));
}