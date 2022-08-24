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

//Script to post new billboard form data to database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $size = $_POST['size'];
    $image = NULL;
    $status = $_POST['status'];
    //if empty client field, set to NULL
    if (empty($_POST['client'])) {
        $client = NULL;
    } else {
        $client = $_POST['client'];
    }
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $addedby = $_SESSION['id'];
    $sql = "INSERT INTO billboards (name, location, size, image, status, client, startdate, enddate, addedby) VALUES (:name, :location, :size, :image, :status, :client, :startdate, :enddate, :addedby)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':size', $size);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':client', $client);
    $stmt->bindParam(':startdate', $startdate);
    $stmt->bindParam(':enddate', $enddate);
    $stmt->bindParam(':addedby', $addedby);
    $stmt->execute();
    header("Location: index.php");
}

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
</head>

<body>
    <div class="container">
        <h1>Centurion Media Billboard Management System</h1>
        <!-- Navigation bar with logo and links to home, register, login, and logout -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">
                            <img alt="Brand" src="images/logo.png" width="30" height="30">
                        </a>
                    </div> -->
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <!-- Show if role is admin -->
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <li><a href="#">Manage Users</a></li>
                    <?php } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <span>Hi, <?php echo $firstname ?></span>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Statictics for total number of billboards in cards view-->
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Number of Billboards</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $totalbillboards;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Number of Available Billboards</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $totalactivebillboards;
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Number of Clients</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $totalclients;
                        ?>
                    </div>
                </div>
            </div>
            <!-- Statictics for total number of billboards in cards view-->
        </div>
        <!-- Button to open modal for new billboard -->
        <div class="col">
            <div class="mb-1">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    Add New Billboard
                </button>
            </div>
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
                                    $startdate = strtotime($billboard['startdate']);
                                    $enddate = strtotime($billboard['enddate']);
                                    $daysleft = ($enddate - $startdate) / 86400;
                                    //Highlight with red if less than 7 days left 
                                    if ($daysleft < 7) {
                                        echo '<span style="color:red;">' . $daysleft . '</span>';
                                    } else {
                                        echo '<span style="color:green;">' . $daysleft . '</span>';
                                    }

                                    ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?php echo $billboard['id']; ?>" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Add new billboard form in a modal -->
        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add New Billboard</h4>
                    </div>
                    <div class="modal-body">
                        <!-- Form to post new billboard -->
                        <form action="<?php
                                        echo htmlspecialchars($_SERVER["PHP_SELF"]);
                                        ?>" method="post">
                            <div class="form-group">
                                <label>Billboard Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Billboard Location</label>
                                <input type="text" name="location" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Billboard Size</label>
                                <input type="text" name="size" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Billboard Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Current Client</label>
                                <!-- Make input disabled if inactive option is selected -->
                                <input type="text" name="client" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" name="startdate" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" name="enddate" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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