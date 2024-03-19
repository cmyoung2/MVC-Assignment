<?php

class ItemDB {

    private $conn;

    // Constructor to initialize the database connection
    public function __construct($host, $username, $password, $database) {
        $this->conn = mysqli_connect($host, $username, $password, $database);
        if(!$this->conn) {
            die("Connection Failed: " . mysqli_connect_error());
        }
    }

    // Retrieve all todo items from the database
    public function get_items() {
        $sql = "SELECT * FROM todoitems";
        $result = mysqli_query($this->conn, $sql);
        $items = [];
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
        }
        return $items;
    }

    // Add a new todo item to the database
    public function add_item($title, $description) {
        $title = mysqli_real_escape_string($this->conn, $title);
        $description = mysqli_real_escape_string($this->conn, $description);
        $sql = "INSERT INTO todoitems (Title, Description) VALUES ('$title', '$description')";
        return mysqli_query($this->conn, $sql);
    }

    // Delete a todo item from the database
    public function delete_item($itemNum) {
        $itemNum = mysqli_real_escape_string($this->conn, $itemNum);
        $sql = "DELETE FROM todoitems WHERE ItemNum = $itemNum";
        return mysqli_query($this->conn, $sql);
    }

    // Retrieve todo items belonging to a specific category from the database
    public function get_items_by_category($categoryID) {
        $category = mysqli_real_escape_string($this->conn, $categoryID);
        $sql = "SELECT * FROM todoitems WHERE categoryId = '$categoryID'";
        $result = mysqli_query($this->conn, $sql);
        $items = [];
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $items[] = $row;
            }
        }
        return $items;
    }

    
    public function close_connection() {
        mysqli_close($this->conn);
    }
}
?>