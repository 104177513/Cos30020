<?php
    require_once("./hitcounter.php");
    $host = "";
    $user = "";
    $pwd = "";
    $db = "";
    $counter;
    $message = array(); 
    $checker = false;
    $filename ="data/mykeys.txt";
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
            $counter ->startOver();
            $counter ->closeConnection();
    } else {
        $message[] = "Unable to set up";
    }
    header("location: countvisits.php");
?>