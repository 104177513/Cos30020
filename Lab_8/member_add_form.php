<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="author" content="Tran Hoang Hai Anh" />
</head>

<body>
    <form action="member_add.php" method="post">
        <label for="fname">First Name: </label>
        <input type="text" name="fname" id="fname" />
        <label for="lname">Last Name: </label>
        <input type="text" name="lname" id="lname" />
        <p>Gender:</p>
        <label for="male">M</label>
        <input type="radio" name="gender" value="m" id="male" checked />
        <label for="female">F</label>
        <input type="radio" name="gender" value="f" id="female" />
        <label for="email">Email: </label>
        <input type="text" name="email" id="email" />
        <label for="phone">Phone number: </label>
        <input type="text" name="phone" id="phone" />
        <input type="submit" value="Submit" />
        <input type="reset" value="Reset" />
    </form>
    <a href="vip_member.php">Return Homepage</a>
    <a href="member_add_form.php">Add page</a>
    <a href="member_display.php">Display page</a>
    <a href="member_search.php">Search page</a>
</body>

</html>