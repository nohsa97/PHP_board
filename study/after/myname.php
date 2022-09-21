<? 
    $id = $_GET['id'];
    $pass = $_GET['pass'];

    $arr = array(
        "id" => $id,
        "pass" => $pass
    );
    $send = json_encode($arr);
    echo $send;
?>