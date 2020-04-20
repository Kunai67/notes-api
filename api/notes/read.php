<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../api/config/Database.php';
include_once '../../models/Notes.php';

$db = new Database();
$conn = $db->getConnection();
$notes = new Notes($conn);

// query notes
$stmt = $notes->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // notes array
    $notes_arr=array();
    $notes_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $product_item=array(
            'uid' => $uid,
            'title' => $title,
            'body' => $body
        );
  
        array_push($notes_arr["records"], $product_item);
    }
  
    // show notes data in json format
    return json_encode($notes_arr);
}