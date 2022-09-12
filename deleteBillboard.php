<!-- Script to Delete Billboard -->
<?php
// Include database connection
require_once "databaseConnection.php";

// Get the id of the billboard to delete
$id = $_GET['id'];

// Delete the billboard
$sql = "DELETE FROM billboards WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Redirect to the home page
header("Location: index.php");
?>