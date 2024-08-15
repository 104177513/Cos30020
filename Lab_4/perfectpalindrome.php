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
if (isset ($_POST["input"])){ 
$str = $_POST["input"];
$revStr = strrev($str);
$pattern = "/^[A-Za-z ]+$/";
if(preg_match($pattern,$str)){
    if (strcmp(strtolower($str),strtolower($revStr)) === 0) {
        echo "<p>This is a perfect palindrome word!: ", $str, ".</p>";
        } else {
        echo "<p>",$str, " is not a perfect palindrome word !</p>";
        }
}   else{
        echo "<p>Please enter string only.</p>";
        }
} else {
echo "<p>Please enter string from the input form.</p>";
}
?>
</body>
</html>