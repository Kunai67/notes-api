<?php
class Notes {
    private $conn;
    private $uid;
    private $title = 'Untitled';
    private $body = 'Empty Note';

    public function __construct($conn) {
        $this->conn = $conn;
        $this->uid = $uid;
    }

    public function read() {
        $query = 'SELECT * FROM notes';

        $stmt = $conn->prepare($query);

        $stmt->execute();

        $stmt;
    }

    public function read_single () {
        $query = 'SELECT * FROM notes WHERE uid=?';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(1, $this->uid);

        $stmt->execute();

        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO notes VALUES (:uid, :title, :body);';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':uid', $this->uid);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);

        $stmt->execute();

        return $stmt;
    }

    public function update() {
        $query = 'UPDATE notes SET title=:title, body=:body WHERE uid=:uid';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(':uid', $this->uid);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);

        $stmt->execute();

        return $stmt;
    }

    public function delete() {
        $query = 'DELETE FROM notes WHERE uid=?';

        $stmt = $conn->prepare($query);

        $stmt->bindParam(1, $this->uid);

        $stmt->execute();

        return $stmt;
    }
}