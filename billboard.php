<?php include 'databaseConnection.php';
//Check if user has session
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
}

//Get billboard details from database
$sql = "SELECT * FROM billboards WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$id = $_GET['id'];
$stmt->execute();
$billboard = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!-- Page to show billboard details  -->
<!DOCTYPE html>
<html>

<head>
    <title>Billboard Details</title>
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
    <div class="container">
        <h1>Billboard Details</h1>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Billboard at <?php echo $billboard['location']; ?></h3>
            </div>
            <div class="panel-body">
                <p>
                    <strong>Billboard Name:</strong> <?php echo $billboard['name']; ?><br>
                    <strong>Billboard Location:</strong> <?php echo $billboard['location']; ?><br>
                    <strong>Billboard Size:</strong> <?php echo $billboard['size']; ?><br>
                </p>
            </div>
        </div>
    </div>
</body>
</html>