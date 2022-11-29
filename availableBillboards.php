<!-- Billboard management system -->
<!-- Include Database Connection Script -->
<?php include 'databaseConnection.php';
//Check if user has session
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
}

//Get all data in billboards table where status is inactive
$sql = "SELECT * FROM billboards WHERE status = 'inactive'";
$stmt = $db->prepare($sql);
$stmt->execute();
$billboards = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get Firstname of user currently logged in
$sql = "SELECT firstname FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->execute();
$firstname = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html>

<head>
    <title>All billboards</title>
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
        <h1>Dashboards</h1>
        <!-- Navigation bar with logo and links to home, register, login, and logout -->
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
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <span>Hi, <?php echo $firstname ?></span>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <form class="navbar-form navbar-right" action="search.php" method="GET">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search Billboard" name="search">
                    <!-- Small submit button -->
                    <button type="submit" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </form>
        </nav>
        <!-- Button to open modal for new billboard -->
        <div class="col">
            <div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Billboard Name</th>
                            <th>Billboard Location</th>
                            <th>Billboard Size</th>
                            <th>Billboard Status</th>
                            <th>Curent Client</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Days Left</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($billboards as $billboard) : ?>
                            <tr>
                                <td><?php echo $billboard['id']; ?></td>
                                <td><?php echo $billboard['name']; ?></td>
                                <td><?php echo $billboard['location']; ?></td>
                                <td><?php echo $billboard['size']; ?></td>
                                <td><?php
                                    //If status is active, display green checkmark, else display red cross
                                    if ($billboard['status'] == 'active') {
                                        echo '<span class="glyphicon glyphicon-ok" style="color:green;"></span>';
                                    } else {
                                        echo '<span class="glyphicon glyphicon-remove" style="color:red;"></span>';
                                    }
                                    ?></td>
                                <td><?php echo $billboard['client']; ?></td>
                                <td><?php echo $billboard['startdate']; ?></td>
                                <td><?php echo $billboard['enddate']; ?></td>
                                <!-- //Calculate days left until billboard expires -->
                                <td>
                                    <?php
                                    //Check if billboard is active
                                    if ($billboard['status'] == 'active') {
                                        //Get current date
                                        $currentdate = date('Y-m-d');
                                        //Get end date
                                        $enddate = $billboard['enddate'];
                                        //Calculate days left
                                        $daysleft = (strtotime($enddate) - strtotime($currentdate)) / (60 * 60 * 24);
                                        //Display days left
                                        echo $daysleft;
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="billboard.php?id=<?php echo $billboard['id']; ?>" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    //Check value of status dropdown and disable client input if inactive option is selected
    $('select[name="status"]').change(function() {
        if ($(this).val() == 'inactive') {
            $('input[name="client"]').prop('disabled', true);
            $('input[name="startdate"]').prop('disabled', true);
            $('input[name="enddate"]').prop('disabled', true);
        } else {
            $('input[name="client"]').prop('disabled', false);
            $('input[name="startdate"]').prop('disabled', false);
            $('input[name="enddate"]').prop('disabled', false);
        }
    });
</script>

</html>