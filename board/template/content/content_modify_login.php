<? 
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) {
        echo "DB Connect Failed";
        exit;
    }
    include_once "../include/session.php";
    $number = $_POST['number']; 
    $writer = $_POST['writer'];
    $status = $_POST['status'];
    // echo $number,$writer,$status;
    // exit; 
    $sql = "select password from board where number =$number";
    $result = mysqli_query( $mysqlDB, $sql );
    $row = mysqli_fetch_assoc($result);
    if( isset( $userID )  && $writer == $userID ){ //작성자와 세션 아이디가 같다면.
        if( $_POST['status'] == '삭제하기' ) {  //상태가 삭제하기일경우.
            $sql = remove( $mysqlDB, 'board', 'number', $number );       
            mysqli_query( $mysqlDB, $sql );
            $sql = remove( $mysqlDB, 'comment', 'number', $number );
            mysqli_query( $mysqlDB, $sql );
            echo "삭제되었습니다. ";
        }
        else {
            location("write_modify.php?number=$number");
        }
    }
    else {
        $ans = '다른사람 글입니다.';
        echo $ans;
    }
    ?>