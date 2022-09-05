<?php
    $mysqlDB = new mysqli('localhost', 'root', 'clzls123', 'test_board');
    if ($mysqlDB->connect_errno)
    {
        echo 'mysql error';
    }
    else
    {
        $sql = "ALTER TABLE comment ADD number int(11) DEFAULT 0 AFTER comment_number";
        $result = mysqli_query($mysqlDB,$sql);

        echo $result;

        mysqli_close($mysqlDB);
    }
?>