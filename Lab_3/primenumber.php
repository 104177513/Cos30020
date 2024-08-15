<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="Web Application Development :: Lab 1" />
<meta name="keywords" content="Web,programming" />
<title>Using if and while statements</title>
</head>
<body>
<h1>Web Programming - Lab 3</h1>
<?php
function is_prime($number) {
    $a = 0;
    for ($i = 1; $i <= $number; $i++) {
        if ($number % $i == 0){
            ++$a;
        }
    }
    if ($a == 2){
        return true;
    } else{
        return false;
    }
}
if (isset ($_GET["number"])) { 
$number = $_GET["number"]; 
if ($number > 0 && $number == round ($number)) { 
    if (is_prime($number)) { 
    echo "<p>", $number, " is a prime number.</p>";
    } else { 
    echo "<p>", $number, " is a standard number.</p>";
    }
    } else { 
    echo "<p>Please enter a valid number. </p>";
    }
    } else {
    echo "<p>Please enter a valid number.</p>";
    }
    ?>
    </body>
    </html>