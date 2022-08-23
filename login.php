<!-- Login Page -->
<?php
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
// Handle login and create session
$username = $password = "";

session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["username"]) && isset($_POST["password"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        if($username == "admin" && $password == "admin"){
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            header("location: index.php");
            exit;
        }
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
        <form action="<?php
                        echo htmlspecialchars($_SERVER["PHP_SELF"]);
                        ?>" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
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
<!-- Footer with copyright info and year -->
<footer class="footer">
    <div class="container">
        <p class="text-muted">Copyright &copy; <?php echo date("Y"); ?> - <?php echo date("Y") + 1; ?>
            <a href="#">Project By Kenaan Akiiki</a>
        </p>
    </div>
</footer>

</html>