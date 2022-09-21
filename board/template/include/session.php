<?
    session_start();
    $userID = $_SESSION['userID'];
    $userPass = $_SESSION['userPass'];
    if( $userID )
        $per = 1;
    else
        $per = 0;
?>