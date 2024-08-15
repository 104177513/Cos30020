<?php
//Reuse setting function
require_once("./functions/settings.php");
$message = array();
//Create database connector 
$connect = mysqli_connect($hostName, $userName, $password, $databaseName);
//Create friend table if not exists query
$createFriendsTableQuery = "CREATE TABLE IF NOT EXISTS friends (
        friend_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        friend_email VARCHAR(50) NOT NULL,
        password VARCHAR(20) NOT NULL,
        profile_name VARCHAR(30) NOT NULL,
        date_started DATE NOT NULL,
        num_of_friends INT UNSIGNED
    );";
//Create my friend table if not exists query
$createMyfriendsTableQuery = "CREATE TABLE IF NOT EXISTS myfriends (
        friend_id1 INT NOT NULL,
        friend_id2 INT NOT NULL,
        CONSTRAINT isValidFriend CHECK (friend_id1 != friend_id2)
    );";
//Insert some dummy data to the friend table query
$insertDummyFriendsDataQuery = "INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends) VALUES
    ('yua@gmail.com', 'yua012', 'Yua', '2024-01-01', 4),
    ('nozomi@gmail.com', 'nozomi012', 'Nozomi', '2024-02-02', 4),
    ('rara@gmail.com', 'rara012', 'Rara', '2024-03-03', 4),
    ('moe@gmail.com', 'moe012', 'Moe', '2024-04-04', 4),
    ('nao@gmail.com', 'nao012', 'Nao', '2024-05-05', 4),
    ('mahina@gmail.com', 'mahina012', 'Mahina', '2024-06-06', 4),
    ('saeko@gmail.com', 'saeko012', 'Saeko', '2024-07-07', 4),
    ('eimi@gmail.com', 'eimi012', 'Eimi', '2024-08-08', 4),
    ('tsukasa@gmail.com', 'tsukasa012', 'Tsukasa', '2024-09-09', 4),
    ('maria@gmail.com', 'maria012', 'Maria', '2024-10-10', 4);";
//Insert some dummy data to the my friend table query
$insertDummyMyfriendsDataQuery = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES
      (1, 2),
      (2, 3),
      (3, 4),
      (4, 5),
      (5, 6),
      (6, 7),
      (7, 8),
      (8, 9),
      (9, 10),
      (10, 1),
      (1, 4),
      (2, 5),
      (3, 6),
      (4, 7),
      (5, 8),
      (6, 9),
      (7, 10),
      (8, 1),
      (9, 2),
      (10, 3);";
//Execute those queries above with conditions checking if it's valid to execute
$createFriendsTable = mysqli_query($connect, $createFriendsTableQuery);
if (!$createFriendsTable) {
    $message[] = "Errors in create friends table: " . mysqli_error($connect);
}
$createMyfriendsTable = mysqli_query($connect, $createMyfriendsTableQuery);
if (!$createMyfriendsTable) {
    $message[] = "Errors in create myfriends table: " . mysqli_error($connect);
}
if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM friends;")) == 0) {
    $insertDummyFriendsData = mysqli_query($connect, $insertDummyFriendsDataQuery);
    if (!$insertDummyFriendsData) {
        $message[] = "Errors in insert dummy friends data: " . mysqli_error($connect);
    }
}
if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM myfriends;")) == 0) {
    $insertDummyMyfriendsData = mysqli_query($connect, $insertDummyMyfriendsDataQuery);
    if (!$insertDummyMyfriendsData) {
        $message[] = "Errors in insert dummy myfriends data: " . mysqli_error($connect);
    }
}
if (count($message) == 0) {
    $message[] = "Tables successfully created and populated.";
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
    <title>Homepage</title>
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
        <h1>My Friend System<br> Assignment Home Page</h1>
        <p>Name: Tran Hoang Hai Anh <br>
            Student ID: 1041177513 <br>
            Email: <a href="mailto:104177513@student.swin.edu.au">104177513@student.swin.edu.au</a><br>
            I declare that this assignment is my individual work. <br>
            I have not worked collaboratively nor have I copied from any other student’s work or from any other source.<br>
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