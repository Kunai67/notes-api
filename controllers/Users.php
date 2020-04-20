<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/notes-api/api/config/Database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/notes-api/models/Users.php';

class UsersController {
    public static function read($request, $response, $args) {
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
        
            // show notes data in json format
            $response->getBody()->write(json_encode($users_arr));

        }

        return $response;
    }

    public static function create($request, $response, $args) {
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
        
        // prepare users object
        $users = new Users($db);
        
        // get users id
        $data = json_decode(file_get_contents("php://input"));
        
        // set users id to be deleted
        $users->id = $data->id;
        
        // delete the notes
        if($users->delete()) {
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
        $database = new Database();
            $db = $database->getConnection();
            
            // prepare users object
            $users = new Users($db);
            
            // get id of users to be edited
            $data = json_decode(file_get_contents("php://input"));

            if (
                !empty($data->id) &&
                !empty($data->firstname) &&
                !empty($data->lastname)
            ) {
                $users->id = $data->id;
                $users->firstname = $data->firstname;
                $users->lastname = $data->lastname;
        
            // update the notes
            if($users->update()){
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