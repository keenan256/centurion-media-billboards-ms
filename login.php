<!-- Login Page -->
<?php include 'databaseConnection.php';
// Handle login and create session
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Check if email and password exist in database
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $email = $_POST['email'];
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        //Check if password is correct
        if (password_verify($_POST['password'], $result['password'])) {
            //Create session
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['firstname'] = $result['firstname'];
            $_SESSION['lastname'] = $result['lastname'];
            $_SESSION['phonenumber'] = $result['phonenumber'];
            $_SESSION['role'] = $result['role'];
            header("location: index.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">
            Incorrect password!
            </div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
        User not registered!
        </div>';
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <!-- Add bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Add bootstrap -->
</head>

<body>
    <div class="container">
        <!-- Navbar with title -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Centurion Billboard Management System</a>
                </div>
            </div>
        </nav>
        <h1>Welcome Back</h1>
        <form action="<?php
                        echo htmlspecialchars($_SERVER["PHP_SELF"]);
                        ?>" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <!-- Registration Page Link -->
        <p> <a href="register.php">Register</a> </p>
    </div>
</body>
</html>