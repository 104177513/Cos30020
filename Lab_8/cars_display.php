<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="author" content="Tran Hoang Hai Anh" />
    <title>Cars display</title>
</head>

<body>
    <?php
    require_once("settings.php");
    $conn = new mysqli($host, $user, $pswd, $dbnm);
    if ($conn->connect_error) {
        die($conn->connect_error);
    }
    // mysqli_select_db($conn, "s104177513_db");

    $sql = "SELECT car_id, make, model, price FROM cars;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                    <th>ID</th>
                    <th>Maker</th>
                    <th>Model</th>
                    <th>Price</th>
                </tr>";
        while ($rows = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $rows["car_id"] . "</td>
                    <td>" . $rows["make"] . "</td>
                    <td>" . $rows["model"] . "</td>
                    <td>" . $rows["price"] . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No results available";
    }
    $conn->close();
    ?>
</body>

</html>