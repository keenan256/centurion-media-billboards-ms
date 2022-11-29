<?php
include 'databaseConnection.php';
//Check if user has session
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
}
//Search billboards by name or location
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    // $sql = "SELECT * FROM billboards WHERE name LIKE '%$search%'";
    $sql = "SELECT * FROM billboards WHERE name LIKE '%$search%' OR location LIKE '%$search%'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $billboards = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!-- Page to show billboard details  -->
<!DOCTYPE html>
<html>

<head>
    <title>Centurion Media</title>
    <!-- Add bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Add bootstrap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #198754;
            font-family: 'Karla', sans-serif;
        }

        .container {
            margin: auto;
            background-color: #fff;
            border-radius: 5px;
        }

        .container h1 {
            text-align: center;
        }

        .container .form-group {
            margin-bottom: 20px;
        }

        .container .form-control {
            border-radius: 5px;
        }

        .container .btn {
            border-radius: 5px;
            background-color: #198754;
            color: #fff;
        }

        .container .btn:hover {
            background-color: #fff;
            color: #000;
        }

        .container .panel {
            border-color: #198754;
        }
    </style>
</head>

<body>
    <!-- List of search results -->
    <div class="container">
        <h1>Search Results</h1>
        <nav class="navbar bg-success">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <img alt="Brand" src="images/logo.png" width="30" height="30">
                    </a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                </ul>
            </div>
        </nav>
        <div class="row">
            <?php foreach ($billboards as $billboard) : ?>
                <!-- Use an ordered list to show the results -->
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= $billboard['name'] ?></h3>
                        </div>
                        <div class="panel-body">
                            <p>Location: <?= $billboard['location'] ?></p>
                            <p>Size: <?= $billboard['size'] ?></p>
                            <p>Price: <?= $billboard['price'] ?></p>
                            <p>Status: <?= $billboard['status'] ?></p>
                        </div>
                        <div class="panel-footer">
                            <a href="billboard.php?id=<?= $billboard['id'] ?>" class="btn btn-default">View</a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>