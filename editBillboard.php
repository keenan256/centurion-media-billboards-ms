<!-- Script to edit billboard details -->

<?php
// Include database connection
require_once "databaseConnection.php";

// Get the id of the billboard to edit
$id = $_GET['id'];

// Get the details of the billboard to edit
$sql = "SELECT * FROM billboards WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$billboard = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Get the details from the form
    $name = $_POST['name'];
    $location = $_POST['location'];
    $size = $_POST['size'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $client = $_POST['client'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];

    // Update the billboard
    $sql = "UPDATE billboards SET name = :name, location = :location, size = :size, status = :status, price = :price, client = :client, startdate = :startdate, enddate = :enddate WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':size', $size);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':client', $client);
    $stmt->bindParam(':startdate', $startdate);
    $stmt->bindParam(':enddate', $enddate);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect to the home page
    header("Location: index.php");
}

?>
