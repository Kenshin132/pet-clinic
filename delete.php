<?php
require_once("dbConnection.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete record from the database
    $sql = "DELETE FROM drugs WHERE id = $id";

    if ($mysqli->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect to the index page after successful deletion
        exit();
    } else {
        echo "Error deleting record: " . $mysqli->error;
    }
} else {
    echo "Invalid request. Please provide a valid ID.";
}
?>
