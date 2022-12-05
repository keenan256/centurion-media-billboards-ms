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
            font-size: large;
        }

        .container {
            margin: auto;       
            background-color: #fff;
            border-radius: 5px;
            width: 100%;
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

        <!-- //Bread crumbs to navigate to billboard details -->
        <ol class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li><a href="billboards.php">Billboards</a></li>
            <li class="active">Billboard Details</li>
        </ol>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Billboard at <?php echo $billboard['location']; ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <img src="uploads/<?php echo $billboard['picture']; ?>" class="img-responsive" alt="Billboard Picture">
                        <p><strong>Name:</strong> <?php echo $billboard['name']; ?></p>
                        <p><strong>Location: </strong><?php echo $billboard['location'] ?? ""; ?></p>
                        <p><strong>Size: </strong><?php echo $billboard['size'] ?? ""; ?></p>
                        <p><strong>Price: UGX. </strong><?php echo $billboard['price'] ?? ""; ?></p>
                        <p><strong>Status: </strong><?php echo $billboard['status'] ?? ""; ?></p>
                        <p><strong>Client: </strong><?php echo $billboard['client'] ?? ""; ?></p>
                        <!-- End Date -->
                        <p><strong>End Date: </strong><?php echo $billboard['enddate'] ?? ""; ?></p>
                        <!-- Days Left -->
                        <p><strong>Days Left: </strong><?php
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
                                                        ?></p>
                        <br>
                        <br>
                        <button type="button" class="btn edit" data-toggle="modal" data-target="#editBillboardModal">Edit Billboard</button>
                        <a href="deleteBillboard.php?id=<?php echo $billboard['id']; ?>" class="btn btn-default">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal to edit billboard details  -->
    <div class="modal fade" id="editBillboardModal" tabindex="-1" role="dialog" aria-labelledby="editBillboardLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBillboardLabel">Edit Billboard</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="editBillboard.php?id=<?php echo $billboard['id']; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Billboard Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="<?php echo $billboard['name'] ?? "" ?>">
                        </div>
                        <div class="form-group">
                            <label for="location">Billboard Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo $billboard['location'] ?? ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="size">Billboard Size</label>
                            <input type="text" class="form-control" id="size" name="size" value="<?php echo $billboard['size'] ?? ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <span class="input-group-addon">UGX.</span>
                                <input type="number" name="price" class="form-control" id="price" value="<?php echo $billboard['price'] ?? ""; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active" <?php if ($billboard['status'] == 'active') {
                                                            echo 'selected';
                                                        } ?>>Active</option>
                                <option value="inactive" <?php if ($billboard['status'] == 'inactive') {
                                                                echo 'selected';
                                                            } ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Current Client</label>
                            <!-- Make input disabled if inactive option is selected -->
                            <input type="text" name="client" class="form-control" id="client" value="<?php echo $billboard['client'] ?? ""; ?>">
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="startdate" id="startdate" class="form-control" value="<?php echo $billboard['startdate'] ?? ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="enddate">End Date</label>
                            <input type="date" class="form-control" id="enddate" name="enddate" value="<?php echo $billboard['enddate'] ?? ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="picture">Picture</label>
                            <input type="file" name="picture" class="form-control">
                        </div>
                        <input type="hidden" name="id" value="<?php echo $billboard['id']; ?>">
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
