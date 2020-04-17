<?php
class Users {
    private $table = 'user-details';
    private $conn;

    private $id;
    private $firstName;
    private $lastName;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT * FROM ' . $this->table;

        $stmt = $conn->prepare($query);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function read_single() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id=:id';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':id', $this->id);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->firstName = $result['firstName'];
        $this->lastName = $result['lastName'];
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' firstName=:firstName, lastName=:lastName';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':firstName', $this->firstName);
        $stmt->bindParam(':lastName', $this->lastName);

        $stmt->execute();
    }
}