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
    $list_seq = $_POST['list_seq']; //큰 범위 - 게시판 - 댓글
    $c_seq = $_POST['c_seq']; //작은범위 - 댓글 -
    $comment_body = $_POST['body']; //수정범위

    // 대댓글 정보들.


    $input_pass = $_POST['password'];
    $set = $_POST['set'];


    $sel_comment = new comment_TEST();
    $sel_comment = $sel_comment->getComment($mysqlDB, $c_seq);

  

    if(!$userID || $sel_comment->permission == 0) 
    { 
        //로그인상태가 아니라면
        
        if($sel_comment->c_depth == 0) 
        { // 댓글
            if($input_pass != $sel_comment->password) 
            {
                alerting("비밀번호가 틀립니다.");
                $pre = $_SERVER['HTTP_REFERER'];
                location("$pre");
                exit;
            }
            else {
                if( $sel_comment->c_depth == 0 && $set == 'modify' )
                {
                    $sel_comment->updateFunc($mysqlDB, $comment_body);
                    alerting("수정 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
                else if($sel_comment->c_depth == 0 && $set == 'remove')
                {     
                    $sel_comment->delFunc($mysqlDB);
                    alerting("삭제 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
            }
        }
        else {  //대댓글
            
            if($input_pass != $sel_comment->password) 
            {
                alerting("비밀번호가 틀립니다.");
                $pre = $_SERVER['HTTP_REFERER'];
                location("$pre");
                exit;
            }
            else 
            {
                
                if( $sel_comment->c_depth != 0 && $set == 'modify' )
                {
                    $sel_comment->updateFunc($mysqlDB, $comment_body);
                    alerting("수정 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
                else if($sel_comment->c_depth != 0 && $set == 'remove')
                { 
                        
                    $sel_comment->delFunc($mysqlDB);
                    alerting("대댓글 삭제 되었습니다");
                    $pre = $_SERVER['HTTP_REFERER'];
                    location("$pre");
                }
            }
        }
    
    }
    else if($userID)
    { //로그인 상태라면 
        if($set == 'modify')
        {
            $sel_comment->updateFunc($mysqlDB, $comment_body);
        }
        else if($set == 'remove')
        {     
            $sel_comment->delFunc($mysqlDB);
        }

    }
?>