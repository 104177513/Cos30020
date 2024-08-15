<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Tran Hoang Hai Anh" />
<title>TITLE</title>
</head>
<body>
<h1>Web Programming - Lab 4</h1>
<?php 
if (!empty($_POST['input']) && isset($_POST['input'])) {
    $pattern = "/^[A-Za-z]+$/";
    $str = $_POST['input'];
    $processedString = "";
    for ($i = 0; $i < strlen($str); $i++) {
        $letter = substr($str, $i, 1);
        if (preg_match($pattern, $letter)) {
            $processedString = $processedString . $letter;
        }
    }
    $revStr = strrev($processedString);
    if (strcmp(strtolower($revStr),strtolower($processedString)) === 0) {
        echo "<p>This is a standard palindrome word!: ", $str, ".</p>";
    } else {
        echo "<p>",$str, " is not a standard palindrome word !</p>";
    }
} else {
    "<p>Please enter string from the input form.</p>";
}
?>
</body>
</html>