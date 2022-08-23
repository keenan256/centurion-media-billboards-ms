<!-- Register Page -->

<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <!-- Add bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Add bootstrap -->
    </head>
    <!-- Form to capture registration details -->
    <body>
        <div class="container">
            <h1>Register</h1>
            <form action="index.php" method="post">
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
</html>