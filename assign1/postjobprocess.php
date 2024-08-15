<!-- This is where we display and process our job searching system -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job Process</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1><a href="index.php">LinkedOut</a></h1>
        <p>A job searching platform by Hai Anh</p>
        <nav>
            <a href="index.php">Homepage</a>
            <a href="postjobform.php">Post jobs</a>
            <a href="searchjobform.php">Search jobs</a>
            <a href="about.php">About</a>
        </nav>
    </header>
    <main>
        <?php
        umask(0007);
        $dir = "../../data/jobposts";
        if (!file_exists($dir)) {
            mkdir($dir, 02770, true);
        }
        $fileName = '../../data/jobposts/jobs.txt';
        function checkData($positionId, $title, $description, $closingDate, $position, $contract, $postCheckbox, $mailCheckbox, $location, $fileName)
        {
            // create result array to store valid result and an array to display all the invalid input
            $result = array();
            $errorMessage = array();
            if (empty($positionId) || !preg_match('/^PID\d{4}$/', $positionId)) {
                $errorMessage[] = "The code is 7 characters in length. It must start with 3 uppercase letter “PID” followed by 4 digits.";
            } else {
                if (!file_exists($fileName)) {
                    $errorMessage[] = "The file doesn't exist!";
                    //checking file exists or not
                } else {
                    //read file
                    $handle = fopen($fileName, "r");
                    $idExist = false;
                    while (!feof($handle)) {
                        $data = explode("\t", fgets($handle));
                        if ($data[0] == $positionId) {
                            $errorMessage[] = "The positionID has been used before!";
                            $idExist = true;
                            break;
                        }
                    }
                    if (!$idExist) {
                        $result[] = $positionId;
                    }
                    fclose($handle);
                }
            }
            //validate the input and append to result if valid
            if (empty($title) || !preg_match('/^[a-zA-Z0-9 ,.!]{1,20}$/', $title)) {
                $errorMessage[] = "The title can only contain a maximum of 20 alphanumeric characters including spaces, comma, period (full stop), and exclamation point. Other characters or symbols are not allowed.";
            } else {
                $result[] = $title;
            }
            if (empty($description) || !preg_match('/^.{1,250}$/', $description)) {
                $errorMessage[] = "The description can only contain a maximum of 250 characters.";
            } else {
                $result[] = $description;
            }
            if (empty($closingDate) || !preg_match('/\d{1,2}\/\d{1,2}\/\d{2}$/', $closingDate)) {
                $errorMessage[] = "The date can only contain a dd/mm/yy format.";
            } else {
                $explodedClosingDate = explode("/", $closingDate);
                if (checkdate((int)$explodedClosingDate[1], (int)$explodedClosingDate[0], 2000 + (int)$explodedClosingDate[2])) {
                    $result[] = $closingDate;
                } else {
                    $errorMessage[] = "The date must be a real date.";
                }
            }
            if (empty($position)) {
                $errorMessage[] = "Please choose a position option";
            } else {
                $result[] = $position;
            }
            if (empty($contract)) {
                $errorMessage[] = "Please choose a contract";
            } else {
                $result[] = $contract;
            }
            if (empty($postCheckbox) && empty($mailCheckbox)) {
                $errorMessage[] = "Please choose an accept method";
            } else {
                if (!empty($postCheckbox)) {
                    $result[] = $postCheckbox;
                } else {
                    $result[] = "postFalse";
                }
                if (!empty($mailCheckbox)) {
                    $result[] = $mailCheckbox;
                } else {
                    $result[] = "mailFalse";
                }
            }
            if (empty($location)) {
                $errorMessage[] = "Please choose a location option other than (---)";
            } else {
                $result[] = $location . "\n";
            }
            //write the valid input into a text file
            if (empty($errorMessage)) {
                $handle = fopen($fileName, "a");
                $data = implode("\t", $result);
                fwrite($handle, $data);
                fclose($handle);
                echo '<fieldset>';
                echo ("<p>Successfully added !</p>");
                echo "<p>Click the logo or use the nav bar to move to other pages !</p>";
                echo '</fieldset>';
            } else {
                //display errors to fix the input
                echo '<fieldset>';
                echo "<p class='errorMessage'>Please follow these rules: " . implode("<br>", $errorMessage) . "</p>";
                echo "<p>Click the logo or use the nav bar to move to other pages !</p>";
                echo '</fieldset>';
            }
        }
        //get the input upon request method as post
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isset($_POST["postCheckbox"])) {
                $_POST["postCheckbox"] = '';
            }
            if (!isset($_POST["mailCheckbox"])) {
                $_POST["mailCheckbox"] = '';
            }
            checkData($_POST['positionId'], $_POST['title'], $_POST['description'], $_POST['closingDate'], $_POST['position'], $_POST['contract'], $_POST['postCheckbox'], $_POST['mailCheckbox'], $_POST['location'], $fileName);
        }
        ?>
    </main>
    <footer>
        <p>Author: Tran Hoang Hai Anh</p>
        <p><a href="mailto:104177513@student.swin.edu.au">104177513@student.swin.edu.au</a></p>
        <a href="index.php">LinkedOut</a>
    </footer>
</body>

</html>