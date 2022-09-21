<?
    include_once "../include/dbConnection.php";
    // include_once "content.php";
    $mysqlDB = mysqlConnect();
    if( !$mysqlDB ) {
        alerting("DB연결 실패.");
        exit;
    }

    include_once "../include/session.php";

    $comment = $_POST['comment']; // 댓글내용
    $writer = $_POST['writer'];
    $password = $_POST['password'];
    $number = $_POST['number'];
    $c_number = $_POST['comment_number'];
    $b_number = $_POST['content_number'];

    if( $userID )
        $per = 1;
    else
        $per = 0;

    if( $_POST['type'] == 'new_write' ) {


        $sql = "
        INSERT INTO comment SET
        comment_number = NULL,
        number = $number,
        comment = '$comment',
        writer = '$writer',
        password = '$password',
        date = NOW(),
        permission = $per;
        ";
    
        $result = mysqli_query( $mysqlDB, $sql );
        alerting("댓글이 작성되었습니다.");
        location("content.php?number=$number&board_number=$b_number");   
    }
    else if( $_POST['type'] == 'reply_write' ) {

        $sql = "
        INSERT INTO reply SET
        comment_number = $c_number,
        reply_number = null,
        reply_comment = '$comment',
        writer = '$writer',
        password = '$password',
        date = NOW(),
        permission = $per;
        ";

    
        $result = mysqli_query( $mysqlDB, $sql );
        alerting("댓글이 작성되었습니다.");
        echo "<script> 
        opener.location.reload();
        self.close(); </script>";
    }

                       
    mysqli_close( $mysqlDB );
                    
                
?>