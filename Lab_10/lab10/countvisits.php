<?php
    require_once("./hitcounter.php");
    $host = "";
    $user = "";
    $pwd = "";
    $db = "";
    $counter;
    
    $message = array(); 
    $filename ="data/mykeys.txt";
    $checker = false;

    if(file_exists($filename)) {
        $handle = fopen($filename, "r"); 
        if(!feof($handle)) {
            $host = trim(fgets($handle));
        } 
        if(!feof($handle)) {
            $user = trim(fgets($handle)); 
        }
        if(!feof($handle)){
            $pwd = trim(fgets($handle));
        } 
        if(!feof($handle)){
            $db = trim(fgets($handle)); 
        } 
        fclose($handle);
    } else {
        $message[] = "Cannot open file";
    }
    if(!empty($host) && !empty($user) && !empty($db)) {
            $counter = new HitCounter($host, $user, $pwd, $db, 'hitcounter');
            $counter->setHits();
            $checker = $counter->getHits();
            $counter->closeConnection();
    } else {
        $message[] = "Cannot set hit counter";
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="description" content="Web application development" />
        <meta name="keywords" content="PHP" />
        <meta name="author" content="Hai Anh" />
        <title>Count visits</title>
    </head>
    <body>
        <h1>Web Programming – Lab10</h1>
        <p>This page has received <?php if ($checker) {echo $checker;} else {echo 0;}?> hits</p>
        <a href="startover.php">Click here to redo !</a>
        <p><?php 
        foreach($message as $mmb) {
            echo $mmb. "<br/>";
        }
        ?></p>
    </body>
</html>

<!-- //  umask(0007);
//  $dir = "../../data/lab10";
//  if (!file_exists($dir)) {
//    echo "<p>No file exists !</p>";
//  } -->