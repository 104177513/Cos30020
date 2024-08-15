<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Tran Hoang Hai Anh" />
<title>Guestbook show</title>
</head>
<body>
<h1>Web Programming - Lab 5</h1>
<?php
$filename = "data/lab05/guestbook.txt"; 
if(!file_exists($filename)){
    echo "<p>There is currently nothing in this guestbook !.</p>";
    exit;
} else {
    $nameList = "";
    $handle = fopen($filename, "r");
    while (!feof($handle)) {
        $getName = fgets($handle);
        $addedName = stripslashes($getName);
        $nameList .= $addedName;
    }
    echo "<p>Guests: </p>";
    echo "<pre>$nameList</pre>";
    fclose($handle);
    echo '<a href="guestbookform.php"><button>Return to form</button></a>';
}
?>
</body>
</html>