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
function is_leapyear($year) {
    if($year % 4 == 0 && $year % 100 != 0 || $year % 4 == 0 && $year % 100 == 0 && $year % 400 == 0){
        return true;
    }
    // else if($year % 4 == 0 && $year % 100 == 0 && $year % 400 == 0){
    //     return true;
    // }
    else {
        return false;
    }
}
if (isset ($_GET["year"])) { 
$year = $_GET["year"]; 
if ($year > 0 && $year == round ($year)) { 
    if (is_leapyear($year)) { 
    echo "<p>", $year, " is a Leap year.</p>";
    } else { 
    echo "<p>", $year, " is a Standard year.</p>";
    }
    } else { 
    echo "<p>Please enter a positive integer year number. </p>";
    }
    } else {
    echo "<p>Please enter a year.</p>";
    }
    ?>
    </body>
    </html>