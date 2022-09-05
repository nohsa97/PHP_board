<?php
    $mysqli = new mysqli('localhost', 'root', 'clzls123', 'information_schema');
    if ($mysqli->connect_errno)
    {
        echo 'mysql error';
    }
    else
    {
        echo 'mysql connect';
    }
 
    mysqli_close($mysqli);
?>