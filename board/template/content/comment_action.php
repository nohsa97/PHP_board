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
    $b_seq = $_POST['b_seq']; //게시판 번호
    $c_seq = $_POST['c_seq']; //댓글번호 


    $list_seq = $_POST['list_seq']; //보더넘버
    // $depth_0 = $_POST['depth']; //뎁스가 0인 댓글의 갯수


    //검색해서 왔을경우
    $search_for = $_POST['search_for'];
    $search_idx = $_POST['search_idx'];


    $b_seq = $_POST['b_seq']; //게시글 시퀀스 


    //새로운 댓글 작성
    $new_comment = new comment_TEST();
    $new_comment->c_seq = NULL;
    $new_comment->b_seq = $b_seq;
    $new_comment->parent_seq = 0;
    $new_comment->sort = 0;
    $new_comment->c_depth = 0;
    $new_comment->body = $body;
    $new_comment->writer = $writer;
    $new_comment->password = $password;
    $new_comment->permission = $per;



    if( $_POST['type'] == 'new_write' )
    {   
        $new_comment->insertFunc($mysqlDB); 

        alerting("댓글이 작성되었습니다.");
        location("content.php?b_seq=$b_seq&list_seq=$list_seq&search_index=$search_idx&search_for=$search_for");   
    }

    else if( $_POST['type'] == 'reply_write' ) 
    {

        $parent_comment = new comment_TEST();
        $parent_comment->getComment($mysqlDB, $c_seq);


        
        $VAL = getSort($mysqlDB);


        if($VAL == 0)
        {
            $new_comment->parent_seq = $parent_comment->parent_seq;
            $new_comment->sort = $parent_comment->sort + 1;
            $new_comment->c_depth = $parent_comment->c_depth + 1;
        }

        else 
        {
            $VAL = $VAL + 1; 
            $old_sort = $parent_comment->sort;
            $new_comment->parent_seq = $parent_comment->parent_seq;
            $sql_set = "UPDATE comment_test SET sort = sort + 1 WHERE sort > $old_sort";
            $result_set = mysqli_query($mysqlDB, $sql_set);
            $new_comment->sort = $old_sort + 1;
            $new_comment->c_depth = $parent_comment->c_depth + 1;
    
        }
       

        $new_comment->insertFunc($mysqlDB);
        

        alerting("대댓글이 작성되었습니다.");
        echo "
        <script> 
            opener.location.reload();
            self.close();
        </script>";
    }

                       
    mysqli_close( $mysqlDB );
                    
                
?>
 
 <?
    function getSort($mysqlDB) 
    {       
        $sql = "SELECT MAX(sort) FROM comment_test";

        $result = mysqli_query($mysqlDB, $sql);
        $row = mysqli_fetch_assoc($result);
        $value = $row['MAX(sort)'];
        return $value;
    }
 ?>