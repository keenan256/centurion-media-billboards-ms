<!-- Connect to mysqlite database try and catch-->
<?php
try {
    $db = new PDO('sqlite:./database/database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Unable to connect to the database: " . $e->getMessage();
    exit();
}

//Create users table if it doesn't exist
try {
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        password CHAR(128) NOT NULL,
        email CHAR(128) NOT NULL,
        firstname CHAR(128) NOT NULL,
        lastname CHAR(128) NOT NULL,
        phonenumber TEXT,
        role TEXT
    )");
    //Create billboards table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS billboards (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name CHAR(128) NOT NULL,
    location CHAR(128) NOT NULL,
    size TEXT,
    image TEXT,
    status TEXT CHECK(status IN ('active', 'inactive')) NOT NULL DEFAULT 'active',
    client TEXT,
    startdate DATE,
    enddate DATE,
    addedby INTEGER,
    FOREIGN KEY(addedby) REFERENCES users(id)
)");
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}

?>