<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Web application development" />
    <meta name="keywords" content="PHP" />
    <meta name="author" content="Hai Anh" />
    <title>Guest Book</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        padding: 0;
    }

    h1 {
        color: #333;
    }

    form {
        max-width: 400px;
        margin: 20px 0;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        box-sizing: border-box;
    }

    button {
        padding: 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    a {
        display: block;
        margin-top: 15px;
        text-decoration: none;
        color: #007BFF;
    }
</style>

<body>
    <h1>Guest Book Form</h1>
    <form action="./guestbooksave.php" method="post">
        <label for="name">Name</label>
        <input type="text" id="name" name="name">
        <label for="email">Email</label>
        <input type="text" id="email" name="email">
        <button type="submit">Submit</button>
    </form>
    <a href="./guestbookshow.php">Show Guest Book</a>
</body>

</html>