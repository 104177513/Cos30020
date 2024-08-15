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
$days = array("Sunday, ", "Monday, ", "Tuesday, ", "Wednesday, ", "Thursday, ", "Friday, ", "Saturday.");
echo "The days of the week in English are: ";
echo "<br>";
foreach ($days as $x) {
    echo $x;
  }
  echo "<br><br>";
$days = array("Dimanche, ", "Lundi, ", "Mardi, ", "Mercredi, ", "Jeudi, ", "Vendredi, ", "Samedi.");
  echo "The days of the week in French are: ";
  echo "<br>";
  foreach ($days as $x) {
      echo $x;
    }
?>
</body>
</html>