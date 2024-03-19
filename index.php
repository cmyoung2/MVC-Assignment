<?php
// Include necessary model files
include_once('Model/category_db.php');
include_once('Model/item_db.php');
include_once('View/header.php');
include_once('View/footer.php');

// Database connection details
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'todolist';

// Instantiate CategoryDB and ItemDB classes
$categoryDB = new CategoryDB($host, $username, $password, $database);
$itemDB = new ItemDB($host, $username, $password, $database);

// Handling form submission to add new categories
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categoryName'])) {
    $categoryName = $_POST['categoryName'];
    $categoryDB->add_category($categoryName);
}

// Handling removal of categories
if (isset($_GET['removeCategory'])) {
    $categoryId = $_GET['removeCategory'];
    $categoryDB->delete_category($categoryId);
}

// Handling form submission to add new todo items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $itemDB->add_item($title, $description);
}

// Handling removal of todo items
if (isset($_GET['removeItem'])) {
    $itemNum = $_GET['removeItem'];
    $itemDB->delete_item($itemNum);
}

// Get all categories and todo items
$categories = $categoryDB->get_categories();
$items = $itemDB->get_items();

// Close the database connections
$categoryDB->close_connection();
$itemDB->close_connection();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <style>
        .remove-btn {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Add Category</h2>
<form method="POST" action="index.php">
    <label for="categoryName">Category Name:</label>
    <input type="text" id="categoryName" name="categoryName" required maxlength="50"><br><br>
    <input type="submit" value="Add Category">
</form>

<h2>Categories</h2>
<?php
if (!empty($categories)) {
    foreach ($categories as $category) {
        $categoryId = $category['categoryID'];
        $categoryName = $category['categoryName'];
        echo "<p>$categoryName <span class='remove-btn' onclick=\"window.location.href='index.php?removeCategory=$categoryId'\">X</span></p>";
    }
} else {
    echo "No categories exist yet.";
}
?>

<h2>Add Item</h2>
<form method="POST" action="index.php">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required maxlength="20"><br><br>
    <label for="description">Description:</label>
    <input type="text" id="description" name="description" required maxlength="50"><br><br>
    <input type="submit" value="Add">
</form>

<h2>Todo Items</h2>
<?php
if (!empty($items)) {
    foreach ($items as $item) {
        $itemNum = $item['ItemNum'];
        $title = $item['Title'];
        $description = $item['Description'];
        echo "<p>$title: $description <span class='remove-btn' onclick=\"window.location.href='index.php?removeItem=$itemNum'\">X</span></p>";
    }
} else {
    echo "No to-do list items exist yet.";
}
?>

</body>
</html>