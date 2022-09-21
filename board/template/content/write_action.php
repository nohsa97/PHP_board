<?
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if( !$mysqlDB ) {
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

    $new_board = new board($subject,$writer,$body,$password,$permission);
   
    if( $select == 'new_write' ) {  
   
        $new_board->insertFunc( $mysqlDB );

        location("../main/list.php");

        mysqli_close( $mysqlDB );
    }
    else if ( $select == 'modify') {
        $number = $_POST['number'];
        $findSQL = FindSQL( $mysqlDB, 'board', 'number', $number );
        $result = mysqli_query( $mysqlDB, $findSQL );

        $row = mysqli_fetch_assoc( $result );

        $new_board->updateFunc( $mysqlDB, $number, $row['visited'] );
        
        echo "
            <script>
                location.href= '../content/content.php?number=$number';
            </script>
        ";
        mysqli_close( $mysqlDB );
        }

          
?>


