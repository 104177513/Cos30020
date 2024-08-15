<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Tran Hoang Hai Anh" />
    <title>Guestbook</title>
</head>

<body>
    <h1>Web Programming Form - Lab 5</h1>
    <fieldset>
        <legend><b>Enter your detail to sign our guest book</b></legend>
    <form action="guestbooksave.php" method="post">
        <label for="fname">First Name: </label>
        <input type="text" name="fname" id="fname" /><br>
        <label for="lname">Last Name: </label>
        <input type="text" name="lname" id="lname" />
        <br>
        <input type="submit">
    </form>
    </fieldset>
    <p><a href="guestbookshow.php">Show Guest Book</a></p>
</body>

</html>