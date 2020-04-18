<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../api/config/Database.php';
include_once '../../models/Users.php';

$db = new Database();
$conn = $db->getConnection();
$users = new Users($conn);

// query users
$stmt = $users->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // users array
    $users_arr=array();
    $users_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $user=array(
            'id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname
        );
  
        array_push($users_arr["records"], $user);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show users data in json format
    echo json_encode($users_arr);
}