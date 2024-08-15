<?php
$message = array();
$filename = "data/mykeys.txt";
if (isset($_POST["host"]) && isset($_POST["user"]) && isset($_POST["pwd"]) && isset($_POST["db"])) {
    $trimmedHost = trim($_POST["host"]);
    $trimmedUser = trim($_POST["user"]);
    $trimmedDb = trim($_POST["db"]);
    if (!empty($trimmedHost) && !empty($trimmedUser) && !empty($trimmedDb)) {
        $handle = fopen($filename, "w");
        $data = $trimmedHost . "\n" . $trimmedUser . "\n" . $_POST["pwd"] . "\n" . $trimmedDb;
        $writeData = fwrite($handle, $data); // write string to text file
        if (strlen($data) == $writeData) {
            $message[] = "Write data successfully";
        } else {
            $message[] = "Write data failed";
        }
        fclose($handle);
        $connect = new mysqli($trimmedHost, $trimmedUser, $_POST["pwd"]);

        if ($connect->connect_error) {
            die("Connection failed: " . $connect->connect_error);
        }

        $checkDbQuery = "CREATE DATABASE IF NOT EXISTS " . $trimmedDb . ";";

        $createTableQuery = "CREATE TABLE `hitcounter` ( `id` SMALLINT NOT NULL PRIMARY KEY, `hits` SMALLINT NOT NULL );";
        $insertTableQuery = "INSERT INTO hitcounter (id, hits) VALUES (1, 0);";
            $checkCreateDb = $connect->query($checkDbQuery);
            $connect->query("USE " . $trimmedDb . " ;");
            $checkCreateTableQuery = $connect->query($createTableQuery);
            $checkInsertTableQuery = $connect->query($insertTableQuery);
            if ($checkCreateDb && $checkCreateTableQuery && $insertTableQuery) {
                $message[] = "Successfully created table and database";
            } else {
                $message[] = "Failed to create table and database";
            }
        $connect->close();
    } else {
        $message[]="Please fill all the fields";
    }
} else {
    if (!(!isset($_POST["host"]) && !isset($_POST["user"]) && !isset($_POST["pwd"]) && !isset($_POST["db"]))) {
        $message[]="Please fill all the fields";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Hai Anh" />
    <title>Set up</title>
</head>

<body>
    <h1>Web Programming – Lab10 - Set up</h1>
    <form action="setup.php" method="post">
        <label for="host">Host name: </label>
        <input type="text" name="host" id="host" />
        <label for="user">User name: </label>
        <input type="text" name="user" id="user" />
        <label for="pwd">Password: </label>
        <input type="password" name="pwd" id="pwd" />
        <label for="db">Database name: </label>
        <input type="text" name="db" id="db" />

        <p><?php 
            foreach($message as $mmb){
                echo $mmb . "<br/>";
            }
         ?></p>

        <input type="submit" value="Submit" />
    </form>
</body>

</html>