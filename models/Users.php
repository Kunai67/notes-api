<?php
class Users {
    private $conn;
    public $id;
    public $firstname;
    public $lastname;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function read() {
        $query = 'SELECT * FROM users';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function read_single () {
        $query = 'SELECT * FROM users WHERE id=?';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO users (firstname, lastname) VALUES (:firstname, :lastname);';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);

        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    public function update() {
        $query = 'UPDATE users SET firstname=:firstname, lastname=:lastname WHERE id=:id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);

        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM users WHERE id=?';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        return $stmt;
    }
}