<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Hai Anh" />
    <title>Guest Book</title>
</head>

<body>
    <h1>Guest Book Save</h1>
    <?php
    $newdata = true;
    if (isset($_POST["name"], $_POST["email"]) && !empty($_POST["name"]) && !empty($_POST["email"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $filename = "guestbook.txt";
        if (file_exists($filename)) {
            $handle = fopen($filename, "r");
            while (!feof($handle)) {
                $onedata = fgets($handle);
                if (strpos($onedata, ',') !== false) {
                    $data = explode(",", $onedata);
                    if (trim($data[0]) == $name || trim($data[1]) == $email) {
                        $newdata = false;
                        break;
                    }
                }
            }
            fclose($handle);
        } else {
            $newdata = true;
        }

        if ($newdata) {
            $handle = fopen($filename, "a");
            $data = $name . "," . $email . "\n";
            fwrite($handle, $data);
            fclose($handle);
            echo "<p>Successfully added</p>";
        } else {
            echo "<p>Unable to add</p>";
        }
    } else {
        echo "<p>Please enter in the input form</p>";
    }
    echo "<a href=\"./guestbookform.php\">Show Form</a>";
    echo "<br>";
    echo "<a href=\"./guestbookshow.php\">Show Guest Book</a>";
    ?>
</body>

</html>