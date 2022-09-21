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
    $b_number = $_POST['content_number'];
    $c_number = $_POST['comment_number'];
    $comment = $_POST['comment'];

    // 대댓글 정보들.
    $r_number = $_POST['reply_number'];
    $mode = $_POST['mode'];

    // 넘어오는 공통 값
    $type = $_POST['type'];
    $pass = $_POST['password'];
    $set = $_POST['set'];

    if($userID && $mode == 1) {
        $pass = $userPass;
    }
    
    if( $type == 'comment' && $set == 'modify' ){
        modify_action( $mysqlDB, 'comment', 'comment_number', $c_number, $pass, 'comment', $comment, $b_number );
        // db , 테이블 , 조건부, 조건값, 입력값, 바꿀컬럼, 새로운데이터, 이동할 게시판번호
    }
    else if($type == 'comment' && $set == 'remove'){
        remove_action( $mysqlDB, 'comment', 'comment_number', $c_number, $pass, $b_number );
       
        //db 테이블 조건부 조건값 입력값 이동할 게시판번호
    }
    else if( $type == 'reply' && $set == 'modify' ) {
        modify_action( $mysqlDB, 'reply', 'reply_number', $r_number, $pass, 'reply_comment', $comment, $b_number );
    }
    else if( $type == 'reply' && $set == 'remove' ) {
        remove_action( $mysqlDB, 'reply', 'reply_number', $r_number, $pass, $b_number );
    }




    function modify_action( $mysqlDB, $TABLE, $COM_COL, $COM_VAL, $INPUT, $SEL_COL, $NEW_VAL, $B_VAL ) { // db , 테이블 , 조건부, 조건값, 입력값, 바꿀컬럼, 새로운데이터, 이동할 게시판번호
        if( $mysqlDB ){
            $sql = FindSQL( $mysqlDB, $TABLE, $COM_COL, $COM_VAL );
            $result = mysqli_query( $mysqlDB, $sql );
            $row = mysqli_fetch_assoc( $result );
                
            if( $row['password'] == $INPUT ){       
               $sql2 = dataUpdate( $mysqlDB, $TABLE, $SEL_COL, $NEW_VAL, $COM_COL, $COM_VAL );
              
               $result = mysqli_query( $mysqlDB, $sql2 );
               alerting('댓글 수정 완료');
               location('content.php?number='.$B_VAL);
            }
            else {
                alerting('올바른 비밀번호를 입력하세요'); 
                location('content.php?number='.$B_VAL);
            }
        }  
    }

    function remove_action( $mysqlDB, $TABLE, $COM_COL, $COM_VAL, $INPUT, $B_VAL ) { //db 테이블 조건부 조건값 입력값 이동할 게시판번호
        if($mysqlDB){
            $sql = FindSQL( $mysqlDB, $TABLE, $COM_COL, $COM_VAL );
            $result = mysqli_query( $mysqlDB, $sql );
            $row = mysqli_fetch_assoc( $result );
            
            if( $row['password'] == $INPUT ){   
                //댓글 삭제    
                $sql = remove( $mysqlDB, $TABLE, $COM_COL, $COM_VAL ); 
                $result = mysqli_query( $mysqlDB, $sql );
                //대댓글 삭제
                $sql = remove( $mysqlDB, 'reply', $COM_COL, $COM_VAL ); 
                $result = mysqli_query( $mysqlDB, $sql );   

                alerting('댓글을 삭제했습니다.');
                location('content.php?number='.$B_VAL); 
            }
            else {
                alerting('올바른 비밀번호를 입력하세요'); 
                location('content.php?number='.$B_VAL);
            }
        } 
    }

?>