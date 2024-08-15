<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="author" content="Tran Hoang Hai Anh" />
    <title>Add member</title>
</head>

<body>
    <?php
    if (
        isset($_POST["fname"]) &&
        !empty($_POST["fname"]) &&
        isset($_POST["lname"]) &&
        !empty($_POST["lname"]) &&
        isset($_POST["gender"]) &&
        !empty($_POST["gender"]) &&
        isset($_POST["email"]) &&
        !empty($_POST["email"]) &&
        isset($_POST["phone"]) &&
        !empty($_POST["phone"])
    ) {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $gender = $_POST["gender"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        if (preg_match("/^\\S+@\\S+\\.\\S+$/", $email)) {
            require_once("settings.php");
            $conn = new mysqli($host, $user, $pswd, $dbnm);
            if ($conn->connect_error) {
                die($conn->connect_error);
            }
            // mysqli_select_db($conn, "s104177513_db");
            $conn->query("
                        CREATE TABLE IF NOT EXISTS vipmembers (
                            member_id INT AUTO_INCREMENT PRIMARY KEY,
                            fname VARCHAR(40),
                            lname VARCHAR(40),
                            gender VARCHAR(1),
                            email VARCHAR(40),
                            phone VARCHAR(20)
                        );
                    ");
            $result = $conn->query("
                        INSERT INTO vipmembers (fname,lname,gender,email,phone) VALUES 
                        (
                            '" . addslashes($fname) . "',
                            '" . addslashes($lname) . "',
                            '" . addslashes($gender) . "',
                            '" . addslashes($email) . "',
                            '" . addslashes($phone) . "'
                        );
                    ");
            if ($result) {
                echo "<p>Successfully.</p>";
            } else {
                echo "<p>Unable to add.</p>";
            }
            $conn->close();
        } else {
            echo "<p>Please enter a valid email.</p>";
        }
    } else {
        echo "<p>Please fill all the blank.</p>";
    }
    ?>
    <a href="vip_member.php">Return Homepage</a>
    <a href="member_add_form.php">Add page</a>
    <a href="member_display.php">Display page</a>
    <a href="member_search.php">Search page</a>
</body>

</html>