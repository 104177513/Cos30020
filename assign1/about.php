<!-- This is the about page which answers all the questions from Swinburne -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
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
        <h1>Frequently asked questions</h1>
        <ul>
            <li>Which PHP version is it ? <br>PHP Version: <?php echo phpversion(); ?></li>
            <li>Which tasks have I finished ? <br>All tasks have been accomplished by me.</li>
            <li>Which advance features does my website have ? <br>My website can search jobs by position, contract, application type and location or show all available results.
                It also sort result from most further date and display jobs that had not closed as of today.</li>
        </ul>
    </main>
    <footer>
        <p>Author: Tran Hoang Hai Anh</p>
        <p><a href="mailto:104177513@student.swin.edu.au">104177513@student.swin.edu.au</a></p>
        <a href="index.php">LinkedOut</a>
    </footer>
</body>

</html>