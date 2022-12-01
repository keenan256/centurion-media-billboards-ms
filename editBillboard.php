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
    // Get the details from the form
    $name = $_POST['name'];
    $location = $_POST['location'];
    $size = $_POST['size'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $client = $_POST['client'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $picture = $_FILES['picture'];
    // Update the billboard
    $sql = "UPDATE billboards SET name = :name, location = :location, size = :size, status = :status, price = :price, client = :client, startdate = :startdate, enddate = :enddate, picture = :picture WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':size', $size);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':client', $client);
    $stmt->bindParam(':startdate', $startdate);
    $stmt->bindParam(':enddate', $enddate);
    $stmt->bindParam(':picture', $picture['name']);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);

    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["picture"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }


    // Redirect to the home page
    header("Location: overview.php");

?>
