<?php
session_start();
//Reuse settings function
require_once("./functions/settings.php");
//Create connector
$connect = mysqli_connect($hostName, $userName, $password, $databaseName);
$message = array();
//Pattern for email and password
$emailPattern = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
$passwordPattern = '/^[a-zA-Z0-9]+$/';
if (isset($_SESSION["friend_id"]) && isset($_SESSION["friend_email"])) {
    //Redirect if already login
    header("location: friendlist.php");
} else {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        //Trim input for accuracy
        $trimmedEmail = trim($_POST["email"]);
        $trimmedPassword = trim($_POST["password"]);
        if (!empty($trimmedEmail) && !empty($trimmedPassword)) {
            //Validate inputs and display corresponding error messages
            if (!preg_match($emailPattern, $trimmedEmail)) {
                $message[] = "Email must be a valid email format";
            } else {
                if (mysqli_num_rows(mysqli_query($connect, "SELECT friend_email FROM friends WHERE friend_email = '$trimmedEmail';")) == 0) {
                    $message[] = "Email has not been sign up";
                }
            }
            if (!preg_match($passwordPattern, $trimmedPassword)) {
                $message[] = "Password must contain only letters and numbers";
            }
            if (count($message) == 0) {
                //Get user data to set for session to get login for other pages
                $getUserDataQuery = "SELECT friend_id, friend_email FROM friends WHERE friend_email = '$trimmedEmail' AND password = '$trimmedPassword';";
                $getUserData = mysqli_query($connect, $getUserDataQuery);
                if (mysqli_num_rows($getUserData) != 0) {
                    //Set the session assosiative array
                    $userData = mysqli_fetch_assoc($getUserData);
                    $_SESSION["friend_id"] = $userData["friend_id"];
                    $_SESSION["friend_email"] = $userData["friend_email"];
                    header("location: friendlist.php");
                } else {
                    $message[] = "Incorrect password, please try again";
                }
            }
        } else {
            $message[] = "Please fill all the fields";
        }
    } else {
        if (!(!isset($_POST["email"])  && !isset($_POST["password"]))) {
            $message[] = "Please fill all the fields";
        }
    }
}
//Close connection
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="   style/style.css">
    <title>Log in</title>
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
        <h1>My friend System <br> Login Page</h1>
        <form action="login.php" method="post">
            <label for="email">Email </label>
            <!-- Save the email input if been typed before -->
            <input type="text" name="email" id="email" value="<?php if (isset($_POST["email"])) {
                                                                    echo $_POST["email"];
                                                                } ?>" /><br>
            <label for="password">Password </label>
            <input type="password" name="password" id="password" /><br>
            <button type="submit">Log in</button>
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