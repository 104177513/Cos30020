<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="author" content="Tran Hoang Hai Anh" />
<title>Guestbook save</title>
</head>
<body>
<h1>Web Programming - Lab 5</h1>
<?php 
//  umask(0007);
//  $dir = "../../data/lab05";
//  if (!file_exists($dir)) {
//      mkdir($dir, 02770);
//  }
if (isset($_POST['fname']) && isset($_POST['lname']) && !empty($_POST['fname']) && !empty($_POST['lname'])) { 
$fName = $_POST["fname"]; 
$lName = $_POST["lname"]; 
$filename = "data/lab05/guestbook.txt"; 
$handle = fopen($filename, "a"); 
$data = addslashes($fName . " " . $lName . "\n"); 
fwrite($handle, $data); 
fclose($handle); 
echo "Successfully added your name to the guestbook list !"; 
echo '<a href="guestbookshow.php"><button>Check the guestbook</button></a>';
echo '<a href="guestbookform.php"><button>Return to form</button></a>';
} else {
echo "<p>Please enter first and last name in the input form.</p>";
echo '<a href="guestbookshow.php"><button>Check the guestbook</button></a>';
echo '<a href="guestbookform.php"><button>Return to form</button></a>';
}
?>
</body>
</html>