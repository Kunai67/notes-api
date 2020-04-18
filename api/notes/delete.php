<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../../api/config/Database.php';
include_once '../../models/Notes.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare notes object
$notes = new Notes($db);
  
// get notes id
$data = json_decode(file_get_contents("php://input"));
  
// set notes id to be deleted
$notes->uid = $data->uid;
  
// delete the notes
if($notes->delete()) {
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Note deleted."));
}
  
// if unable to delete the notes
else {
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete notes."));
}