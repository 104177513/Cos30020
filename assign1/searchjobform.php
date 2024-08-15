<!-- This is where we search jobs through a form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Job Form</title>
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
        <h1>Job Vacancy Searching System</h1>
        <!-- This is where the form begins -->
        <form action="searchjobprocess.php" method="get">
            <label for="title">Title: </label>
            <input type="text" id="title" name="title" title="The title can only contain a maximum of 20 alphanumeric characters including spaces, comma, period (full stop), and exclamation point. Other characters or symbols are not allowed.">
            <fieldset>
                <legend>Position</legend>
                <label>
                    <input type="radio" name="position" value="fullTime">
                    Full Time
                </label>

                <label>
                    <input type="radio" name="position" value="partTime">
                    Part Time
                </label>
            </fieldset>
            <br>

            <fieldset>
                <legend>Contract</legend>
                <label>
                    <input type="radio" name="contract" value="onGoing">
                    On-going
                </label>

                <label>
                    <input type="radio" name="contract" value="fixedTerm">
                    Fixed term
                </label>
            </fieldset>
            <br>
            <fieldset>
                <legend>Accept application by: </legend>
                <label>
                    <input type="checkbox" id="postCheckbox" name="postCheckbox" value="postTrue">
                    Post
                </label>
                <label>
                    <input type="checkbox" id="mailCheckbox" name="mailCheckbox" value="mailTrue">
                    Mail
                </label>
            </fieldset>
            <br>
            <label for="location">Location:</label>
            <select id="location" name="location">
                <option value="">---</option>
                <option value="act">ACT</option>
                <option value="nsw">NSW</option>
                <option value="nt">NT</option>
                <option value="qld">QLD</option>
                <option value="sa">SA</option>
                <option value="tas">TAS</option>
                <option value="vic">VIC</option>
                <option value="wa">WA</option>
            </select>
            <br>
            <input type="submit" value="Search">
            <input type="reset" value="Reset">
        </form>

    </main>
    <footer>
        <p>Author: Tran Hoang Hai Anh</p>
        <p><a href="mailto:104177513@student.swin.edu.au">104177513@student.swin.edu.au</a></p>
        <a href="index.php">LinkedOut</a>
    </footer>
</body>

</html>