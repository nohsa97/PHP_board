<?
    include_once "../include/dbConnection.php";
    // include_once "content.php";
    $mysqlDB = mysqlConnect();
    if( !$mysqlDB ) 
    {
        alerting("DB연결 실패.");
        exit;
    }

    include_once "../include/session.php";

    if( $userID )
        $per = 1;
    else
        $per = 0;


    $body = $_POST['body']; // 댓글내용
    $writer = $_POST['writer'];
    $password = $_POST['password'];
    $number = $_POST['number'];
    $b_number = $_POST['b_number']; //보더넘버 저장.x


    //검색해서 왔을경우
    $search_for = $_POST['search_for'];
    $search_idx = $_POST['search_idx'];


    $c_number = $_POST['comment_number'];
    

    $new_comment = new comment(NULL, $number, $writer, $body, $password, $per);


    if( $_POST['type'] == 'new_write' )
    {

        $new_comment->insertFunc($mysqlDB);

        alerting("댓글이 작성되었습니다.");
        location("content.php?number=$number&board_number=$b_number&search_index=$search_idx&search_for=$search_for");   
    }
    else if( $_POST['type'] == 'reply_write' ) 
    {
        $new_reply = new reply(NULL, $number, $c_number, $writer, $password, $body, $per);

        $new_reply->insertFunc($mysqlDB);


        alerting("대댓글이 작성되었습니다.");
        echo "
        <script> 
            opener.location.reload();
            self.close();
        </script>";
    }

                       
    mysqli_close( $mysqlDB );
                    
                
?>
