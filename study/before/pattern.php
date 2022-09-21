<? 
    session_start();
    // echo session_id();
    $_SESSION['login']=session_regenerate_id();
    echo $_SESSION['login'];

    session_destroy();

    echo $_SESSION['login'];
?>