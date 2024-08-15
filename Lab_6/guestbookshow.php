<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Hai Anh" />
    <title>Guest Book</title>

</head>
<style>
    table {
        border-collapse: collapse;
        width: 80%;
        margin: 20px auto;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    a {
        display: block;
        margin-top: 15px;
        text-decoration: none;
        color: #007BFF;
    }
</style>

<body>
    <h1>Guestbook Show</h1>
    <hr>
    <?php
    echo "<table>";
    $filename = "guestbook.txt";
    $handle = fopen($filename, "r");
    echo "<p>Signed in guest book visitors:</p>";
    $alldata = array();
    while (!feof($handle)) {
        $data = stripslashes(fgets($handle));
        if (strpos($data, ",")) {
            $explodeddata = explode(",", $data);
            $alldata[] = array($explodeddata[0], $explodeddata[1]);
        }
    }
    fclose($handle);
    sort($alldata);
    echo "<tr>";
    echo "<th>Number</th>";
    echo "<th>Name</th>";
    echo "<th>Email</th>";
    echo "</tr>";
    $i = 1;
    foreach ($alldata as $data) {
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>$data[0]</td>";
        echo "<td>$data[1]</td>";
        echo "</tr>";
        $i++;
    }
    echo "</table>";
    echo "<a href=\"./guestbookform.php\">Show Form</a>";
    echo "<br>";
    echo "<a href=\"./guestbookshow.php\">Show Guest Book</a>";
    ?>
</body>

</html>