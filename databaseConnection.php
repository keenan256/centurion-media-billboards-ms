<!-- Connect to mysqlite database try and catch-->
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