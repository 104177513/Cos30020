<?php
//Start sessions with settings to reuse
session_start();
require_once("./functions/settings.php");
//Create an object connecting database
$connect = mysqli_connect($hostName, $userName, $password, $databaseName);
//Checking if user is login or not
if (!isset($_SESSION["friend_id"]) || !isset($_SESSION["friend_email"])) {
    header("location: login.php");
} else {
    //Taking session assosiative array value to a local variable
    $message = array();
    $saveAllFriendsId = array();
    $currentUserId = $_SESSION["friend_id"];
    $currentUserEmail = $_SESSION["friend_email"];
    //Checking if the page sents the add friend ID
    if (isset($_GET["addfriendId"])) {
        $addfriendId = $_GET["addfriendId"];
        //Checking if friend to add exists or not
        $isValidFriendQuery = "SELECT friend_id1, friend_id2 FROM myfriends WHERE 
        (friend_id1 = '$currentUserId' AND friend_id2 = '$addfriendId')
        OR
        (friend_id2 = '$currentUserId' AND friend_id1 = '$addfriendId');
        ";
        $isValidFriend = mysqli_query($connect, $isValidFriendQuery);
        $countTotalAvailableUsersQuery = "SELECT * FROM friends;";
        $countTotalAvailableUsers = mysqli_query($connect,$countTotalAvailableUsersQuery);
        if (mysqli_num_rows($isValidFriend) == 0 && mysqli_num_rows($countTotalAvailableUsers) >= $addfriendId) {
            //Checking if 0 means no friend relationship exists
            $addfriendQuery = "INSERT INTO myfriends (friend_id1, friend_id2) VALUES ('$currentUserId','$addfriendId');";
            $addfriend = mysqli_query($connect, $addfriendQuery);
            //Update the num of friends counter for ourself and our newly added friend
            $updateNumOfFriends1Query = "UPDATE friends SET num_of_friends = num_of_friends + 1 WHERE friend_id = '$currentUserId';";
            $addingNumOfFriends1 = mysqli_query($connect, $updateNumOfFriends1Query);
            $updateNumOfFriends2Query = "UPDATE friends SET num_of_friends = num_of_friends + 1 WHERE friend_id = '$addfriendId';";
            $addingNumOfFriends2 = mysqli_query($connect, $updateNumOfFriends2Query);
        }
    }
    //Get current user data 
    $getCurrentUserDataQuery = "SELECT friend_id, profile_name, num_of_friends FROM friends WHERE friend_id = '$currentUserId' AND friend_email = '$currentUserEmail';";
    $currentUserData = mysqli_fetch_assoc(mysqli_query($connect, $getCurrentUserDataQuery));
    $currentUserProfileName = $currentUserData["profile_name"];
    $currentUserFriendCounter = $currentUserData["num_of_friends"];
    //Get friend add list
    $getFriendListQuery = "SELECT friend_id, friend_email, profile_name FROM friends 
    WHERE friend_id NOT IN (SELECT friend_id1 FROM myfriends WHERE friend_id2 = '$currentUserId') 
    AND friend_id NOT IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = '$currentUserId') 
    AND  '$currentUserId' != friend_id ;";

    $getFriendList = mysqli_query($connect, $getFriendListQuery);
    //Page counter for pagination
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
    //Paginated result
    $getPaginationQuery = "SELECT friend_id, friend_email, profile_name FROM friends 
    WHERE friend_id NOT IN (SELECT friend_id1 FROM myfriends WHERE friend_id2 = '$currentUserId') 
    AND friend_id NOT IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = '$currentUserId') 
    AND '$currentUserId' !=  friend_id 
    LIMIT 5 OFFSET " . ($currentPage - 1) * 5;
    $getPagination = mysqli_query($connect, $getPaginationQuery);
    $getAllFriendsInId1Query = "SELECT friend_id1 FROM myfriends WHERE friend_id2 = '$currentUserId';";
    $getAllFriendsInId2Query = "SELECT friend_id2 FROM myfriends WHERE friend_id1 = '$currentUserId';";
    $getAllFriendsInId1 = mysqli_query($connect, $getAllFriendsInId1Query);
    $getAllFriendsInId2 = mysqli_query($connect, $getAllFriendsInId2Query);
    while ($rows = mysqli_fetch_assoc($getAllFriendsInId1)) {
        $saveAllFriendsId[] = $rows["friend_id1"];
    }
    while ($rows = mysqli_fetch_assoc($getAllFriendsInId2)) {
        $saveAllFriendsId[] = $rows["friend_id2"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Friend add</title>
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
        <h2><?php echo $currentUserProfileName; ?>'s Friend Add Page</h2>
        <h2>Total number of friends is <?php echo $currentUserFriendCounter; ?></h2>
        <?php if (mysqli_num_rows($getPagination) > 0) : ?>
            <?php while ($rows = mysqli_fetch_assoc($getPagination)) : ?>
                <!-- Checking mutual friend by checking potential friend's friends -->
                <?php
                $counter = 0;
                $checker = array();
                $getStrangerFriendsInId1Query = "SELECT friend_id1 FROM myfriends WHERE friend_id2 = " . $rows["friend_id"];
                $getStrangerFriendsInId2Query = "SELECT friend_id2 FROM myfriends WHERE friend_id1 = " . $rows["friend_id"];
                $getStrangerFriendsInId1 = mysqli_query($connect, $getStrangerFriendsInId1Query);
                $getStrangerFriendsInId2 = mysqli_query($connect, $getStrangerFriendsInId2Query);
                while ($rows1 = mysqli_fetch_assoc($getStrangerFriendsInId1)) {
                    $checker[] = $rows1["friend_id1"];
                }
                while ($rows2 = mysqli_fetch_assoc($getStrangerFriendsInId2)) {
                    $checker[] = $rows2["friend_id2"];
                }
                foreach ($checker as $c) {
                    foreach ($saveAllFriendsId as $s) {
                        if ($c == $s) {
                            $counter = $counter + 1;
                        }
                    }
                }
                ?>
                <p><?php echo $rows["profile_name"]; ?> | <?php echo $counter; ?> mutual friends | <a href="friendadd.php?addfriendId=<?php echo $rows["friend_id"]; ?>"> Add as friend </a> </p>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php if ($currentPage > 1) : ?>
            <a href="friendadd.php?currentPage=<?php echo $currentPage - 1; ?>">Prev</a>
        <?php endif; ?>
        <?php if ($currentPage < $totalPage) : ?>
            <a href="friendadd.php?currentPage=<?php echo $currentPage + 1; ?>">Next</a>
        <?php endif; ?>
        <br>
        <a href="friendlist.php">Friend list</a> | <a href="logout.php">Logout</a>
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
<?php mysqli_close($connect); ?>