<?
 session_start();
 $userID = $_SESSION['userID'];
 $userPass = $_SESSION['userPass'];
?>
<?
    include_once "../include/dbConnection.php";
    include_once "../include/session.php";

    $mysqlDB = mysqlConnect();
    if ( !$mysqlDB ) {
        echo "DB Connect Failed";
        exit;
    }


    // 댓글 정보들.
    $b_number = $_POST['content_number']; //큰 범위 - 게시판 - 댓글
    $c_number = $_POST['comment_number']; //작은범위 - 댓글 -
    $comment_body = $_POST['body'];

    // 대댓글 정보들.
    $r_number = $_POST['reply_number'];
    $mode = $_POST['mode'];
    
    // 넘어오는 공통 값
    $type = $_POST['type'];
    $pass = $_POST['password'];
    $set = $_POST['set'];




    if($type == "comment") 
    {
        $sql = FindSQL($mysqlDB, 'comment', "number", $c_number);
        $result = mysqli_query($mysqlDB, $sql);
        $row = mysqli_fetch_assoc($result);
    
    }
    else 
    {
        $sql = FindSQL($mysqlDB, 'reply', "number", $r_number);
        $result = mysqli_query($mysqlDB, $sql);
        $row = mysqli_fetch_assoc($result);
    }
    

    $sel_comment = new comment($c_number,$row['b_number'], $row['writer'], $row['body'], $row['password'], $row['permission']);
    $sel_reply = new reply($r_number, $b_number, $c_number, $row['writer'], $row['password'], $row['body'], $row["permission"]);
    
 

    if(!$userID || $sel_comment->permission == 0 || $sel_reply->permission == 0) 
    { //로그인상태가 아니라면
        if($type == "comment") 
        { // 댓글
            if($pass != $sel_comment->password) 
            {
                alerting("비밀번호가 틀립니다.");
                $pre = $_SERVER['HTTP_REFERER'];
                location("$pre");
                exit;
            }
            else {
                if( $type == 'comment' && $set == 'modify' )
                {
                    $sel_comment->updateFunc($mysqlDB, $comment_body);
                    alerting("수정 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
                else if($type == 'comment' && $set == 'remove')
                {     
                    $sel_comment->delFunc($mysqlDB);
                    alerting("삭제 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
            }
        }
        else {  //대댓글
            if($pass != $sel_reply->password) 
            {
                alerting("비밀번호가 틀립니다.");
                $pre = $_SERVER['HTTP_REFERER'];
                location("$pre");
                exit;
            }
            else 
            {
                if( $type == 'reply' && $set == 'modify' )
                {
                    $sel_reply->updateFunc($mysqlDB, $comment_body);
                    alerting("수정 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
                else if($type == 'reply' && $set == 'remove')
                {     
                    $sel_reply->delFunc($mysqlDB);
                    alerting("대댓글 삭제 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
            }
        }
    
    }
    else if($userID)
    { //로그인 상태라면 
        if( $type == 'comment' && $set == 'modify' )
        {
            $sel_comment->updateFunc($mysqlDB, $comment_body);
        }
        else if($type == 'comment' && $set == 'remove')
        {     
            $sel_comment->delFunc($mysqlDB);
        }
        else 
        {  //대댓글      
                if( $type == 'reply' && $set == 'modify' )
                {
                    $sel_reply->updateFunc($mysqlDB, $comment_body);
                    alerting("수정 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }

                else if($type == 'reply' && $set == 'remove')     
                    $sel_reply->delFunc($mysqlDB);
                
            
        }
    }
?>