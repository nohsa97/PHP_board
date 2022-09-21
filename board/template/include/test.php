<? 
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if( !$mysqlDB ) {
        echo "<script>alert('DB연결 실패');</script>";
        exit;
    }

    $board1 = new board("비회원10","노홍석","asdasd","123123",0);
    