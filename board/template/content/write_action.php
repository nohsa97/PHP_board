<?
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if( !$mysqlDB ) 
    {
        echo "<script>alert('DB연결 실패');</script>";
        exit;
    }

    include_once "../include/session.php";

    $subject = $_POST['subject']; // 게시글 제목
    $body = $_POST['body']; // 게시글 내용
    $writer = $_POST['writer'];
    $password = $_POST['password'];
    $permission = $_POST['permission'];
    $visited = $_POST['visited'];

    $select = $_POST['selected']; //새글 or 수정하기
    $b_seq = $_POST['b_seq'];
    $list_seq = $_POST['list_seq'];

    //검색해서 왔을경우 돌아갈길 확보
    $search_for = $_POST['search_for'];
    $search_idx = $_POST['search_idx'];

   
    $new_board = new board();
    $new_board->b_seq=NULL;
    $new_board->subject = $subject;
    $new_board->writer = $writer;
    $new_board->body = $body;
    $new_board->password = $password;
    $new_board->visited = $visited;
    $new_board->permission = $permission;
   
   
    if( $select == 'new_write' ) 
    {   
        $new_board->insertFunc( $mysqlDB );
        location("../main/list.php?list_seq=0");

        mysqli_close( $mysqlDB );

    }

    else if ( $select == 'modify') 
    {
        $new_board->updateFunc( $mysqlDB, $b_seq );
        
        echo "
            <script>
                location.href= '../content/content.php?b_seq=$b_seq&list_seq=$list_seq&search_for=$search_for&search_index=$search_idx';
            </script>
        ";
        mysqli_close( $mysqlDB );
    }

          
?>


