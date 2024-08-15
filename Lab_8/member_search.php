<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="author" content="Tran Hoang Hai Anh" />
    <title>Search member</title>
</head>

<body>
    <form action="member_search.php" method="get">
        <label for="lname">Enter your last name: </label>
        <input type="text" name="lname" id="lname" />
        <input type="submit" value="Submit" />
        <input type="reset" value="Reset" />
    </form>

    <?php
    if (isset($_GET["lname"]) && !empty($_GET["lname"])) {
        require_once("settings.php");

        $conn = new mysqli($host, $user, $pswd, $dbnm);
        $lname = $_GET["lname"];
        if ($conn->connect_error) {
            die($conn->connect_error);
        }

        mysqli_select_db($conn, "s104177513_db");

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

        $sql = "SELECT member_id, fname, lname, email FROM vipmembers WHERE lname LIKE '%$lname%';";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                            <th>ID</th>
                            <th>Fname</th>
                            <th>Lname</th>
                            <th>Email</th>
                        </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                                <th>" . $row["member_id"] . "</th>
                                <td>" . $row["fname"] . "</td>
                                <td>" . $row["lname"] . "</td>
                                <td>" . $row["email"] . "</td>
                            </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results available</p>";
        }
        $conn->close();
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