<?php

class CategoryDB {

    private $conn;

    // Constructor to initialize the database connection
    public function __construct($host, $username, $password, $database) {
        $this->conn = mysqli_connect($host, $username, $password, $database);
        if(!$this->conn) {
            die("Connection Failed: " . mysqli_connect_error());
        }
    }

    // Retrieve all categories from the database
    public function get_categories() {
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($this->conn, $sql);
        $categories = [];
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row;
            }
        }
        return $categories;
    }

    // Add a new category to the database
    public function add_category($categoryName) {
        $categoryName = mysqli_real_escape_string($this->conn, $categoryName);
        $sql = "INSERT INTO categories (categoryName) VALUES ('$categoryName')";
        return mysqli_query($this->conn, $sql);
    }

    // Delete a category from the database
    public function delete_category($categoryId) {
        $categoryId = mysqli_real_escape_string($this->conn, $categoryId);
        $sql = "DELETE FROM categories WHERE categoryID = $categoryId";
        return mysqli_query($this->conn, $sql);
    }

    // Close the database connection
    public function close_connection() {
        mysqli_close($this->conn);
    }
}
?>