<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" >
<meta name="description" content="Web Programming :: Lab 2" >
<meta name="keywords" content="Web,programming" >
<title>Using variables, arrays and operators</title>
</head>
<body>
<h1>Web Programming - Lab 2</h1>
<?php
$number = 1.5;
if(is_numeric($number) && round($number)%2 == 0){
    echo "The variable " . round($number) . "<b> contains an even</b> number";
}else if (is_numeric($number) && round($number)%2 == 1){
    echo "The variable " . round($number) . "<b> contains an odd</b> number";
}else{
    echo "Invalid !!!";
}
?>
</body>
</html>