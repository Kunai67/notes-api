<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/notes-api/api/config/Database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/notes-api/models/Notes.php';

class NotesController {
    public static function read($request, $response, $args) {
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
            $response->getBody()->write(json_encode($notes_arr));

        }

        return $response;
    }

    public static function create($request, $response, $args) {
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
                $response->getBody()->write(json_encode(array("message" => "Product was created.")));
                return $response->withStatus(201);
            }
            else {
                $response->getBody()->write(json_encode(array("message" => "Unable to create product.")));
                return $response->withStatus(503);
            }
        }
        else {
            $response->getBody()->write(json_encode(array("message" => "Unable to create product. Data is incomplete.")));
            return $response->withStatus(400);
        }
    }

    public static function delete($request, $response, $args) {
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
            $response->getBody()->write(json_encode(array("message" => "Note deleted.")));
            return $response->withStatus(200);
        }
        
        // if unable to delete the notes
        else {
            $response->getBody()->write(json_encode(array("message" => "Unable to delete notes.")));
            return $response->withStatus(503);
        }
    }

    public static function update($request, $response, $args) {
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
                $response->getBody()->write(json_encode(array("message" => "Updated")));
                return $response->withStatus(200);
            }
            else {
                $response->getBody()->write(json_encode(array("message" => "Unable to create product.")));
                return $response->withStatus(503);
            }
        }
        else {
            $response->getBody()->write(json_encode(array("message" => "Unable to create product. Data is incomplete.")));
            return $response->withStatus(400);
        }
    }
}