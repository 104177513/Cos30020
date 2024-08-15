<?php
session_start();
//Reuse the settings function
require_once("./functions/settings.php");
//Create connection object
$connect = mysqli_connect($hostName, $userName, $password, $databaseName);
$message = array();
//Pattern for email, profile name and password
$emailPattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
$profileNamePattern = '/^[a-zA-Z]+$/';
$passwordPattern = '/^[a-zA-Z0-9]+$/';
if (isset($_SESSION["friend_id"]) && isset($_SESSION["friend_email"])) {
    //Redirect to friendlist if already login
    header("location: friendlist.php");
} else {
    if (isset($_POST["email"]) && isset($_POST["profileName"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {
        //Trim inputs for accuracy
        $trimmedEmail = trim($_POST["email"]);
        $trimmedProfileName = trim($_POST["profileName"]);
        $trimmedPassword = trim($_POST["password"]);
        $trimmedConfirmPassword = trim($_POST["confirmPassword"]);
        //Validate inputs 
        if (!empty($trimmedEmail) && !empty($trimmedProfileName) && !empty($trimmedPassword) && !empty($trimmedConfirmPassword)) {
            if (!preg_match($emailPattern, $trimmedEmail)) {
                $message[] = "Email must be a valid email format";
            } else {
                if (mysqli_num_rows(mysqli_query($connect, "SELECT friend_email FROM friends WHERE friend_email = '$trimmedEmail';")) != 0) {
                    $message[] = "Email has already been used";
                }
            }
            if (!preg_match($profileNamePattern, $trimmedProfileName)) {
                $message[] = "Profile must contain only letters and cannot be blank";
            }
            if (!preg_match($passwordPattern, $trimmedPassword)) {
                $message[] = "Password must contain only letters and numbers";
            }
            if (!preg_match($passwordPattern, $trimmedConfirmPassword)) {
                $message[] = "Confirm password must contain only letters and numbers";
            }
            if ($trimmedConfirmPassword != $trimmedPassword) {
                $message[] = "Both passwords must match";
            }
            if (count($message) == 0) {
                //Register a new user to the database query
                $insertNewUserQuery = "INSERT INTO friends (friend_email, password, profile_name, date_started,num_of_friends ) VALUES ('$trimmedEmail','$trimmedPassword','$trimmedProfileName', CURRENT_TIMESTAMP(),0);";
                $insertNewUser = mysqli_query($connect, $insertNewUserQuery);
                //Get the newly created user data to set for the session associative array
                if ($insertNewUser) {
                    $getNewUserDataQuery = "SELECT friend_id, friend_email FROM friends WHERE friend_email = '$trimmedEmail' AND password = '$trimmedPassword';";
                    $getNewUserData = mysqli_query($connect, $getNewUserDataQuery);
                    if ($getNewUserData) {
                        $newUserData = mysqli_fetch_assoc($getNewUserData);
                        $_SESSION["friend_id"] = $newUserData["friend_id"];
                        $_SESSION["friend_email"] = $newUserData["friend_email"];
                        header("location: friendadd.php");
                    } else {
                        $message[] = "Failed to insert a new user";
                    }
                } else {
                    $message[] = "Failed to insert a new user";
                }
            }
        } else {
            $message[] = "Please fill all the fields";
        }
    } else {
        if (!(!isset($_POST["email"]) && !isset($_POST["profileName"]) && !isset($_POST["password"]) && !isset($_POST["confirmPassword"]))) {
            $message[] = "Please fill all the fields";
        }
    }
}
//Close connector
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Sign up</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php">Homepage</a>
                </li>
                <li>
                    <a href="login.php">Log in here !</a>
                </li>
                <li>
                    <a href="signup.php">Sign up a new account !</a>
                </li>
                <li>
                    <a href="about.php">About us</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>My friend System <br> Registration Page</h1>
        <form action="signup.php" method="post">
            <label for="email">Email </label>
            <!-- Save values for email and profile name if been typed before -->
            <input type="text" name="email" id="email" value="<?php if (isset($_POST["email"])) {
                                                                    echo $_POST["email"];
                                                                } ?>" /><br>
            <label for="profileName">Profile Name </label>
            <input type="text" name="profileName" id="profileName" value="<?php if (isset($_POST["profileName"])) {
                                                                                echo $_POST["profileName"];
                                                                            } ?>" /><br>
            <label for="password">Password </label>
            <input type="password" name="password" id="password" /><br>
            <label for="confirmPassword">Confirm Password </label>
            <input type="password" name="confirmPassword" id="confirmPassword" /><br>
            <button type="submit">Register</button>
            <button type="reset">Clear</button>
        </form>
        <p>
            <?php
            foreach ($message as $m) {
                echo $m . "<br>";
            }
            ?>
        </p>
    </main>
    <footer>
        <ul>
            <nav>
                <li>
                    <a href="index.php">Homepage</a>
                </li>
                <li>
                    <a href="login.php">Log in here !</a>
                </li>
                <li>
                    <a href="signup.php">Sign up a new account !</a>
                </li>
                <li>
                    <a href="about.php">About us</a>
                </li>
        </ul>
        </nav>
    </footer>
</body>

</html>