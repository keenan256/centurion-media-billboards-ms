<!-- Billboard management system -->
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

<!-- Make sure user is logged in to see this page  -->
<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
?>

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
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">Logout</a></li>
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
                        // $sql = "SELECT COUNT(*) AS total FROM billboards";
                        // $result = mysqli_query($db, $sql);
                        // $row = mysqli_fetch_array($result);
                        echo "0";
                        ?>
                    </div>
                </div>
            </div>
            <!-- Statictics for total number of billboards in cards view-->
            <!-- Statictics for total number of billboards in cards view-->
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Number of Available Billboards</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        // $sql = "SELECT COUNT(*) AS total FROM billboards";
                        // $result = mysqli_query($db, $sql);
                        // $row = mysqli_fetch_array($result);
                        echo "0";
                        ?>
                    </div>
                </div>
            </div>
            <!-- Statictics for total number of billboards in cards view-->
            <!-- Statictics for total number of billboards in cards view-->
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Total Number of Clients</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        // $sql = "SELECT COUNT(*) AS total FROM billboards";
                        // $result = mysqli_query($db, $sql);
                        // $row = mysqli_fetch_array($result);
                        echo "0";
                        ?>
                    </div>
                </div>
            </div>
            <!-- Statictics for total number of billboards in cards view-->
        </div>
        <!-- Button to open modal for new billboard -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
            Add New Billboard
        </button>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Billboard Name</th>
                    <th>Billboard Location</th>
                    <th>Billboard Size</th>
                    <th>client</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($billboards as $billboard) : ?>
                    <tr>
                        <td><?php echo $billboard['billboard_id']; ?></td>
                        <td><?php echo $billboard['billboard_name']; ?></td>
                        <td><?php echo $billboard['billboard_location']; ?></td>
                        <td><?php echo $billboard['billboard_size']; ?></td>
                        <td><?php echo $billboard['current_client']; ?></td>
                        <td><?php echo $billboard['start']; ?></td>
                        <td><?php echo $billboard['end']; ?></td>
                        <td>
                            <a href="index.php?action=view&id=<?php echo $billboard['billboard_id']; ?>">View</a> |
                            <a href="index.php?action=edit&id=<?php echo $billboard['billboard_id']; ?>">Edit</a> |
                            <a href="index.php?action=delete&id=<?php echo $billboard['billboard_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add new billboard form in a modal -->
        <div class="modal fade" id="addModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add New Billboard</h4>
                    </div>
                    <div class="modal-body">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label for="billboard_name">Billboard Name:</label>
                                <input type="text" class="form-control" id="billboard_name" name="billboard_name" placeholder="Enter billboard name">
                            </div>
                            <div class="form-group">
                                <label for="billboard_location">Billboard Location:</label>
                                <input type="text" class="form-control" id="billboard_location" name="billboard_location" placeholder="Enter billboard location">
                            </div>
                            <div class="form-group">
                                <label for="billboard_size">Billboard Size:</label>
                                <input type="text" class="form-control" id="billboard_size" name="billboard_size" placeholder="Enter billboard size">
                            </div>
                            <div class="form-group">
                                <label for="current_client">Current Client:</label>
                                <input type="text" class="form-control" id="current_client" name="current_client" placeholder="Enter current client">
                            </div>
                            <div class="form-group">
                                <label for="start">Start:</label>
                                <input type="text" class="form-control" id="start" name="start" placeholder="Enter start">
                            </div>
                            <div class="form-group">
                                <label for="end">End:</label>
                                <input type="text" class="form-control" id="end" name="end" placeholder="Enter end">

                                <input type="hidden" name="action" value="add">

                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Edit billboard form in a modal -->
        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Billboard</h4>
                    </div>
                    <div class="modal-body">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label for="billboard_name">Billboard Name:</label>
                                <input type="text" class="form-control" id="billboard_name" name="billboard_name" placeholder="Enter billboard name">
                            </div>
                            <div class="form-group">
                                <label for="billboard_location">Billboard Location:</label>
                                <input type="text" class="form-control" id="billboard_location" name="billboard_location" placeholder="Enter billboard location">
                            </div>
                            <div class="form-group">
                                <label for="billboard_size">Billboard Size:</label>
                                <input type="text" class="form-control" id="billboard_size" name="billboard_size" placeholder="Enter billboard size">
                            </div>
                            <div class="form-group">
                                <label for="current_client">Current Client:</label>
                                <input type="text" class="form-control" id="current_client" name="current_client" placeholder="Enter current client">
                            </div>
                            <div class="form-group">
                                <label for="start">Start:</label>
                                <input type="text" class="form-control" id="start" name="start" placeholder="Enter start">
                            </div>
                            <div class="form-group">
                                <label for="end">End:</label>
                                <input type="text" class="form-control" id="end" name="end" placeholder="Enter end">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?php echo $billboard['billboard_id']; ?>">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Footer with copyright info and year -->
<footer class="footer">
    <div class="container">
        <p class="text-muted">Copyright &copy; <?php echo date("Y"); ?> - <?php echo date("Y") + 1; ?>
            <a href="#">Project By Kenaan Akiiki</a>
        </p>
    </div>
</footer>

</html>