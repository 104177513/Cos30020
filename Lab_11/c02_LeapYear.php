<!DOCTYPE html>
<html>

<head>
	<title>Leap Year</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	<?php
	if (isset($_GET["year"])) {
		$Year = $_GET["year"];
		if (is_numeric($Year)) {
			if ($Year % 4 != 0) {
				echo "The year you entered is a standard year.";
			} else if ($Year % 400 == 0) {
				echo "The year you entered is a leap year.";
			} else if ($Year % 100 == 0) {
				echo "The year you entered is a standard year.";
			} else {
				echo "The year you entered is a leap year.";
			}
		} else {
			echo "Please enter a numeric.";
		}
	} else {
		echo "Please fill all the blank.";
	}
	?>
</body>

</html>