<?php
session_start();
//Reuse setting functions
require_once("./functions/settings.php");
//Create an object connecting database
$connect = mysqli_connect($hostName, $userName, $password, $databaseName);
//Checking if login or not to redirect
if (!isset($_SESSION["friend_id"]) || !isset($_SESSION["friend_email"])) {
    header("location: login.php");
} else {
    //Get current user information from session
    $message = array();
    $currentUserId = $_SESSION["friend_id"];
    $currentUserEmail = $_SESSION["friend_email"];
    if (isset($_GET["unfriendId"])) {
        //Find if friend relationship exists or not
        $unfriendId = $_GET["unfriendId"];
        $isValidFriendQuery = "SELECT friend_id1, friend_id2 FROM myfriends WHERE 
        (friend_id1 = '$currentUserId' AND friend_id2 = '$unfriendId')
        OR
        (friend_id2 = '$currentUserId' AND friend_id1 = '$unfriendId');
        ";
        $isValidFriend = mysqli_query($connect, $isValidFriendQuery);
        if (mysqli_num_rows($isValidFriend) != 0) {
            //Delete friend query
            $unfriendQuery = "DELETE FROM myfriends WHERE
            (friend_id1 = '$unfriendId' AND friend_id2 = '$currentUserId')
            OR 
            (friend_id2 = '$unfriendId' AND friend_id1 = '$currentUserId');";
            $unfriend = mysqli_query($connect, $unfriendQuery);
            //Decrease nums of friend query
            $updateNumOfFriends1Query = "UPDATE friends SET num_of_friends = num_of_friends - 1 WHERE friend_id = '$currentUserId' AND num_of_friends > 0;";
            $subtractNumOfFriends1 = mysqli_query($connect, $updateNumOfFriends1Query);
            $updateNumOfFriends2Query = "UPDATE friends SET num_of_friends = num_of_friends - 1 WHERE friend_id = '$unfriendId' AND num_of_friends > 0;";
            $subtractNumOfFriends2 = mysqli_query($connect, $updateNumOfFriends2Query);
        }
    }
    //Get user data in this session
    $getCurrentUserDataQuery = "SELECT friend_id, profile_name, num_of_friends FROM friends WHERE friend_id = '$currentUserId' AND friend_email = '$currentUserEmail';";
    $currentUserData = mysqli_fetch_assoc(mysqli_query($connect, $getCurrentUserDataQuery));
    $currentUserProfileName = $currentUserData["profile_name"];
    $currentUserFriendCounter = $currentUserData["num_of_friends"];
    //Get friend list
    $getFriendListQuery = "SELECT friends.friend_id, friends.profile_name FROM friends JOIN myfriends 
    ON friends.friend_id = myfriends.friend_id1 OR friends.friend_id = myfriends.friend_id2
    WHERE (myfriends.friend_id1 = '$currentUserId' OR myfriends.friend_id2 = '$currentUserId') 
    AND '$currentUserId' != friends.friend_id;";
    $getFriendList = mysqli_query($connect, $getFriendListQuery);
    //Pagination for friend list
    $currentPage = 1;
    $numberOfFriendRows = mysqli_num_rows($getFriendList);
    $totalPage = ceil($numberOfFriendRows / 5.0);
    if (isset($_GET["currentPage"]) && is_numeric($_GET["currentPage"])) {
        $currentPage = (int) $_GET["currentPage"];
    }
    if ($currentPage > $totalPage) {
        $currentPage = $totalPage;
    }
    if ($currentPage < 1) {
        $currentPage = 1;
    }
    //Return paginated query
    $getPaginationQuery = "SELECT friends.friend_id, friends.profile_name
    FROM friends JOIN myfriends 
    ON friends.friend_id = myfriends.friend_id1 OR friends.friend_id = myfriends.friend_id2
    WHERE (myfriends.friend_id1 = '$currentUserId' OR myfriends.friend_id2 = '$currentUserId') 
    AND '$currentUserId' != friends.friend_id
    LIMIT 5 OFFSET " . ($currentPage - 1) * 5;
    $getPagination = mysqli_query($connect, $getPaginationQuery);
}
//Close connection
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Friend list</title>
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
        <h1>My Friend System</h1>
        <!-- Print out the result from the pagination query -->
        <h2><?php echo $currentUserProfileName; ?>'s Friend List Page</h2>
        <h2>Total number of friends is <?php echo $currentUserFriendCounter; ?></h2>
        <?php while ($rows = mysqli_fetch_assoc($getPagination)) : ?>
            <p><?php echo $rows["profile_name"]; ?> | <a href="friendlist.php?unfriendId=<?php echo $rows["friend_id"]; ?>"> Unfriend </a> </p>
        <?php endwhile; ?>
        <?php if ($currentPage > 1) : ?>
            <a href="friendlist.php?currentPage=<?php echo $currentPage - 1; ?>">Prev</a>
        <?php endif; ?>
        <?php if ($currentPage < $totalPage) : ?>
            <a href="friendlist.php?currentPage=<?php echo $currentPage + 1; ?>">Next</a>
        <?php endif; ?>
        <br>
        <a href="friendadd.php">Friend add</a> | <a href="logout.php">Logout</a>
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