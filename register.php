<!-- Register Page -->
<!-- Include Database Connection Script -->
<?php include 'databaseConnection.php';
// Register users to database
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $password = $_POST['password'];
    $email = $_POST['email'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $phonenumber = $_POST['phone_number'];
    $role = 'admin';

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (password, email, firstname, lastname, phonenumber, role) VALUES (:password, :email, :firstname, :lastname, :phonenumber, :role)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':password', $hash);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':phonenumber', $phonenumber);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    //Echo result
    if ($stmt->rowCount() > 0) {
        echo '<div class="alert alert-success" role="alert">
    User successfully registered!
    </div>';
        header("Location: login.php");
    } else {
        echo '<div class="alert alert-danger" role="alert">
    User not registered!
    </div>';
        //Stay on register page if user not registered
        header("Location: register.php");
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <!-- Add bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Add bootstrap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@300&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            background-color: #198754;
            font-family: 'Karla', sans-serif;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
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
    </style>
</head>
<!-- Form to capture registration details -->

<body>
    <div class="container">
        <!-- Navbar with title -->
        <nav class="navbar bg-success">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Centurion Billboard Management System</a>
                </div>
            </div>
        </nav>
        <h1>Register</h1>
        <form action="<?php
                        echo htmlspecialchars($_SERVER["PHP_SELF"]);
                        ?>" method="post">
            <!-- Capture registration details First name, last name, email, password-->
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
            </div>
            <!-- Phone Nummber -->
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm password">

            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
        <!-- Login Page Link -->
        <p> <a href="login.php">Login</a> </p>
    </div>
</body>

</html>