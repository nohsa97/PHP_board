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

    $select = $_POST['selected']; //새글 or 수정하기
    $number = $_POST['number'];
    $b_number = $_POST['b_number'];

    //검색해서 왔을경우 돌아갈길 확보
    $search_for = $_POST['search_for'];
    $search_idx = $_POST['search_idx'];
 
    $new_board = new board(NULL, $subject, $writer, $body, $password, 0, $permission);
   
    if( $select == 'new_write' ) 
    {  
        
        $new_board->insertFunc( $mysqlDB );
        location("../main/list.php?board_number=0");

        mysqli_close( $mysqlDB );

    }

    else if ( $select == 'modify') 
    {
        $number = $_POST['number'];
        $new_board->updateFunc( $mysqlDB, $number );
        
        echo "
            <script>
                location.href= '../content/content.php?number=$number&board_number=$b_number&search_for=$search_for&search_index=$search_idx';
            </script>
        ";
        mysqli_close( $mysqlDB );
    }

          
?>


