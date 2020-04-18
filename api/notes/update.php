<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../../api/config/Database.php';
include_once '../../models/Notes.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare notes object
$notes = new Notes($db);
  
// get id of notes to be edited
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->uid) &&
    !empty($data->title) &&
    !empty($data->body)
) {
    $notes->uid = $data->uid;
    $notes->title = $data->title;
    $notes->body = $data->body;
  
    // update the notes
    if($notes->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "Updated"));
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