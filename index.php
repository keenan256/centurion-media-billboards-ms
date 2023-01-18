<!-- Billboard management system -->
<!-- Include Database Connection Script -->
<?php include 'databaseConnection.php';
//Check if user has session
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
}

//Get all data in billboards table
$sql = "SELECT * FROM billboards";
$stmt = $db->prepare($sql);
$stmt->execute();
$billboards = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Get total number of billboards
$sql = "SELECT COUNT(*) FROM billboards";
$stmt = $db->prepare($sql);
$stmt->execute();
$totalbillboards = $stmt->fetchColumn();

//Get total number of billboards with active status
$sql = "SELECT COUNT(*) FROM billboards WHERE status = 'active'";
$stmt = $db->prepare($sql);
$stmt->execute();
$totalactivebillboards = $stmt->fetchColumn();

//Get total number of uniqe clients excluding null values
$sql = "SELECT COUNT(DISTINCT client) FROM billboards WHERE client IS NOT NULL";
$stmt = $db->prepare($sql);
$stmt->execute();
$totalclients = $stmt->fetchColumn();

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
            border-color: #3b59db;
            border-width: 2px;
        }

        /* Nav border color to red */
        .navbar {
            border-color: #f54269;
            border-width: 3px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Centurion Media Billboard Management System</h1>
        <!-- Navigation bar with logo and links to home, register, login, and logout -->
        <nav class="navbar bg-success ">
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
            <form class="navbar-form navbar-right" action="search.php" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search Billboard" name="search">
                    <!-- Small submit button -->
                    <button type="submit" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </form>
        </nav>
        <!-- Three clickable Widgets to show total number of billboards, total number of active billboards, and total number of clients -->
        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Dashboard Overview</h3>
                    </div>
                    <!-- //Forward Icon -->
                    <div class="panel-footer">
                        <a href="overview.php">
                            <span class="glyphicon glyphicon-forward"></span>
                            <span>See Overview</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>All Billboards</h3>
                    </div>
                    <div class="panel-footer">
                        <a href="billboards.php">
                            <span class="glyphicon glyphicon-forward"></span>
                            <span>View Billboards</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Available Billboards</h3>
                    </div>
                    <div class="panel-footer">
                        <a href="availableBillboards.php">
                            <span class="glyphicon glyphicon-forward"></span>
                            <span>View Billboards</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Rented Billboards</h3>
                    </div>
                    <div class="panel-footer">
                        <a href="rentedBillboards.php">
                            <span class="glyphicon glyphicon-forward"></span>
                            <span>View Billboards</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>Expired Rental Contracts</h3>
                    </div>
                    <div class="panel-footer">
                        <a href="expiredRentalContracts.php">
                            <span class="glyphicon glyphicon-forward"></span>
                            <span>View All</span>
                        </a>
                    </div>
                </div>
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