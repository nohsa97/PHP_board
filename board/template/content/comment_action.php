<?
    include_once "../include/dbConnection.php";
    // include_once "content.php";
    $mysqlDB = mysqlConnect();
    if(!$mysqlDB) {
        alerting("DB연결 실패.");
        exit;
    }

    if($_POST['type']=='new_write') {
        $comment = $_POST['comment']; // 댓글내용
        $writer = $_POST['writer'];
        $password = $_POST['password'];
        $number = $_POST['number'];
    
        $mysqlDB = mysqlConnect();
        $sql = "
        INSERT INTO comment SET
        comment_number = NULL,
        number = $number,
        comment = '$comment',
        writer = '$writer',
        password = '$password',
        date = NOW(),
        re_comment =NULL;
        ";
    
        $result = mysqli_query($mysqlDB,$sql);
        alerting("댓글이 작성되었습니다.");
        location("content.php?number=$number");
                
    }
    // else if

                       
    mysqli_close($mysqlDB);
                    
                
?>