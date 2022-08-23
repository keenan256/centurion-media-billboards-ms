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
</head>

<body>
    <div class="container">
        <h1>Billboard Details</h1>
        <!-- Check database connection -->
        <?php
        try {
            $db = new PDO('sqlite:./database/database.db');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Database connection established successfully<br>";
        } catch (PDOException $e) {
            echo "Unable to connect to the database: " . $e->getMessage();
            exit();
        }
        ?>
    </div>
</body>
</html>