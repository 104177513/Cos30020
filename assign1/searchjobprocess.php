<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Job Process</title>
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
        $fileName = '../../data/jobposts/jobs.txt';
        function searchJobTitle($searchTitle, $searchPosition, $searchContract, $searchPostCheckbox, $searchMailCheckbox, $searchLocation, $fileName)
        {
            //create an array for error message and get real time
            $errorMessage = array();
            $realDateTime = new DateTime();
            //validate isset from parameters
            if (!empty($searchTitle) && isset($searchTitle)) {
                $proceededTitle = $searchTitle;
            } else {
                $errorMessage[] = "Please enter a job title.";
            }
            if (isset($searchPosition)) {
                $proceededPosition = $searchPosition;
            } else {
                $proceededPosition = "";
            }
            if (isset($searchContract)) {
                $proceededContract = $searchContract;
            } else {
                $proceededContract = "";
            }
            if (isset($searchPostCheckbox)) {
                $proceededPostCheckBox = $searchPostCheckbox;
            } else {
                $proceededPostCheckBox = "";
            }
            if (isset($searchMailCheckbox)) {
                $proceededMailCheckBox = $searchMailCheckbox;
            } else {
                $proceededMailCheckBox = "";
            }
            if (isset($searchLocation)) {
                $proceededLocation = $searchLocation;
            } else {
                $proceededLocation = "";
            }
            //check file existance
            if (!file_exists($fileName)) {
                $errorMessage[] = "The file doesn't exist!";
            } else {
                //read file and add to data variables for coding convenience
                $handle = fopen($fileName, "r");
                if ($handle) {
                    $matchedResult = array();
                    while (($readLine = fgets($handle)) !== false) {
                        $data = explode("\t", $readLine);
                        if (isset($data[1])) {
                            $dataTitle = $data[1];
                        } else {
                            $dataTitle = "";
                        }
                        if (isset($data[2])) {
                            $dataDescription = $data[2];
                        } else {
                            $dataDescription = "";
                        }
                        if (isset($data[3])) {
                            $dataClosingDate = date_create_from_format("d/m/y", $data[3]);
                        } else {
                            $dataClosingDate = "";
                        }
                        if (isset($data[4])) {
                            $dataPosition = $data[4];
                        } else {
                            $dataPosition = "";
                        }
                        if (isset($data[5])) {
                            $dataContract = $data[5];
                        } else {
                            $dataContract = "";
                        }
                        if (isset($data[6])) {
                            $dataPostCheckBox = $data[6];
                        } else {
                            $dataPostCheckBox = "";
                        }
                        if (isset($data[7])) {
                            $dataMailCheckBox = $data[7];
                        } else {
                            $dataMailCheckBox = "";
                        }
                        if (isset($data[8])) {
                            $dataLocation = $data[8];
                        } else {
                            $dataLocation = "";
                        }
                        //check if the data matches the searced criteria
                        if (
                            (strpos(strtolower($dataTitle), strtolower(trim($proceededTitle))) !== false) && ($dataClosingDate >= $realDateTime) &&
                            (empty($proceededPosition) || strtolower(trim($dataPosition)) === strtolower($proceededPosition)) && (empty($proceededContract) || strtolower(trim($dataContract)) === strtolower($proceededContract)) &&
                            (empty($proceededPostCheckBox) || strtolower(trim($dataPostCheckBox)) === strtolower($proceededPostCheckBox)) && (empty($proceededMailCheckBox) || strtolower(trim($dataMailCheckBox)) === strtolower($proceededMailCheckBox)) &&
                            (empty($proceededLocation) || strtolower(trim($dataLocation)) === strtolower($proceededLocation))

                        ) {
                            //assign results to a big array
                            $matchedResult[] = array(
                                "matchedTitle" => $dataTitle, "matchedDescription" => $dataDescription,
                                "matchedClosingDate" => $dataClosingDate, "matchedPosition" => $dataPosition,
                                "matchedContract" => $dataContract, "matchedPostCheckbox" => $dataPostCheckBox,
                                "matchedMailCheckbox" => $dataMailCheckBox, "matchedLocation" => $dataLocation
                            );
                        }
                    }
                    if (!empty($matchedResult)) {
                        //Sort the date using usort PHP method
                        usort($matchedResult, function ($y, $z) {
                            if ($z["matchedClosingDate"] > $y["matchedClosingDate"]) {
                                return 1;
                            } elseif ($z["matchedClosingDate"] < $y["matchedClosingDate"]) {
                                return -1;
                            } else {
                                return 0;
                            }
                        });
                        //loop through the array to print out all the matched results
                        foreach ($matchedResult as $m) {
                            $resultTitle = $m["matchedTitle"];
                            $resultDescription = $m["matchedDescription"];
                            $resultClosingDate = $m["matchedClosingDate"];
                            $resultPosition = $m["matchedPosition"];
                            $resultContract = $m["matchedContract"];
                            $resultPostCheckBox = $m["matchedPostCheckbox"];
                            $resultMailCheckBox = $m["matchedMailCheckbox"];
                            $resultLocation = $m["matchedLocation"];
                            if ($resultPosition == "fullTime") {
                                $resultPosition = "Full-time";
                            } else {
                                $resultPosition = "Part-time";
                            }
                            if ($resultContract == "onGoing") {
                                $resultContract = "On-going";
                            } else {
                                $resultContract = "Fixed-term";
                            }
                            if ($resultPostCheckBox == "postTrue") {
                                $resultPostCheckBox = "Yes";
                            } else {
                                $resultPostCheckBox = "No";
                            }
                            if ($resultMailCheckBox == "mailTrue") {
                                $resultMailCheckBox = "Yes";
                            } else {
                                $resultMailCheckBox = "No";
                            }
                            echo '<fieldset>';
                            echo "Title: " . $resultTitle . "<br>";
                            echo "Description: " . $resultDescription . "<br>";
                            echo "Closing date: " . $resultClosingDate->format("d/m/y") . "<br>";
                            echo "Position: " . $resultPosition . "<br>";
                            echo "Contract: " . $resultContract . "<br>";
                            echo "Application by post: " . $resultPostCheckBox . "<br>";
                            echo "Application by mail: " . $resultMailCheckBox . "<br>";
                            echo "Location: " . $resultLocation . "<br>";
                            echo '</fieldset>';
                        }
                        echo "<p>Click the logo or use the nav bar to move to other pages !</p>";
                    } else {
                        //add some messages for not finding any results
                        $errorMessage[] = "0 results. Please try again later or expand your search criteria.";
                    }
                    if (!empty($errorMessage)) {
                        //display all the error messages
                        echo '<fieldset>';
                        echo "<p class='errorMessage'>" . implode("<br>", $errorMessage) . "</p>";
                        echo "<p>Click the logo or use the nav bar to move to other pages !</p>";
                        echo '</fieldset>';
                    }
                    //close the file after using
                    fclose($handle);
                }
            }
        }
        //get the data from the form upon request method as get
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            if (!isset($_GET["position"])) {
                $_GET["position"] = '';
            }
            if (!isset($_GET["contract"])) {
                $_GET["contract"] = '';
            }
            if (!isset($_GET["postCheckbox"])) {
                $_GET["postCheckbox"] = '';
            }
            if (!isset($_GET["mailCheckbox"])) {
                $_GET["mailCheckbox"] = '';
            }
            searchJobTitle($_GET['title'], $_GET['position'], $_GET['contract'], $_GET['postCheckbox'], $_GET['mailCheckbox'], $_GET['location'], $fileName);
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