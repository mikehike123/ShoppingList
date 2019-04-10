<?php

class ListItem{
 
    // database connection and table name
    private $conn;
    private $table_name = "List";
 
    // object properties
    public $id;
    public $listID;
    public $userID;
    public $description;
    public $created;
    public $completed;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
    function read(){
 
        // select all query
        $query = "SELECT * FROM " . $this->table_name;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
    
    // create list item
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . "
            SET
                userID=:userID, listID=:listID, description=:description, created=:created";
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->userID=htmlspecialchars(strip_tags($this->userID));
        $this->listID=htmlspecialchars(strip_tags($this->listID));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->created=htmlspecialchars(strip_tags($this->created));

        // bind values
        $stmt->bindParam(":userID", $this->userID);
        $stmt->bindParam(":listID", $this->listID);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }
    // delete the product
    function delete(){
 
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
     
    }
    // update the listItem to completed
    function completed(){
 
        // delete query
        $query = "Update " . $this->table_name . " SET completed=:completed WHERE id = :id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->completed = htmlspecialchars(strip_tags($this->completed));

        // bind id of record to delete
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":completed", $this->completed);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
     
    }
}