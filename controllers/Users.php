<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/notes-api/api/config/Database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/notes-api/models/Users.php';

class UsersController {
    public static function read() {
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
        
            // show users data in json format
            return json_encode($users_arr);
        }
    }
}