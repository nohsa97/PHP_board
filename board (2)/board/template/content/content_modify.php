<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?
    include_once "../include/header.php";
    ?>
<?
    include_once "../include/dbConnection.php";
    include_once "../include/session.php";

    $prePage = $_SERVER['HTTP_REFERER'];
    
    $mysqlDB = mysqlConnect();
    if( !$mysqlDB ) 
    {
        alerting("DB연결 실패");
        exit;
    }

    $number = $_POST['number']; 
    $b_number = $_POST['b_number']; //보드넘버
    $status = $_POST['status'];


    $search_idx = $_POST['search_idx'];
    $search_for = $_POST['search_for'];



    $sql = FindSQL($mysqlDB, 'board', 'number', $number);
    $result = mysqli_query($mysqlDB, $sql);
    $row = mysqli_fetch_assoc($result); 

    $new_board = new board($row['number'], $row['subject'], $row['writer'], $row['body'], $row['password'], $row['visited'], $row['permission']);

    $permission = $new_board->permission;
    $writer = $new_board->writer;

    $sql = "select password from board where number =$number";
    $result = mysqli_query( $mysqlDB, $sql );
    $row = mysqli_fetch_assoc($result);
    if( $permission == 0 ) 
    {
        echo '
        <div class="write_box" style="text-align:center;">     
         <form name="form" action="" method="post">  
            <h3 style="border-bottom:1px solid blue; padding:20px;">비밀번호 확인</h3>
            <input type="password" name="password" required class="write_name" placeholder="비밀번호">
            <input type = "hidden" value = "',$number,'" name = "number">
            <input type = "hidden" value = "',$b_number,'" name = "b_number">
            <input type = "hidden" value = "',$status,'" name = "status">
            <input type = "hidden" value = "',$search_idx,'" name = "search_idx">
            <input type = "hidden" value = "',$search_for,'" name = "search_for">
            <input class="button" type="submit" value="확인하기">
         </form>
         </div>
        ';
    
        if( $status == '삭제하기' ) 
        {  //상태가 삭제하기일경우.
            $input = $_POST['password'];
            if( $input == $row['password']) 
            {
                $sql = remove( $mysqlDB, 'board', 'number', $number );       
                mysqli_query( $mysqlDB, $sql );
                $sql = remove( $mysqlDB, 'comment', 'number', $number );
                mysqli_query( $mysqlDB, $sql );
                alerting("삭제되었습니다.");
                location("../main/list.php?board_number=0&search_for=",$search_for,"&search_index=",$search_idx,"");
            }
            else  
            {
                alerting("비밀번호를 입력해주세요.");
                exit;
            }
        }
        else if( $status == '수정하기' ) 
        { // 상태가 수정하기일 경우 수정하기로 넘어감 
 
            $input = $_POST['password'];
            $b_number = $_POST['b_number'];
            $search_idx = $_POST['search_idx'];
            $search_for = $_POST['search_for'];

            if( $input == $row['password'] ) 
            {
                location("write_modify.php?number=$number&permission=0&board_number=$b_number&search_for=$search_for&search_index=$search_idx");
            
            }
            
            else  
            {
                alerting("비밀번호를 입력해주세요.");
                exit;
            }
        }
    }

    else if( isset( $userID )  && $writer == $userID ) 
    {//유저퍼미션
        if( $_POST['status'] == '삭제하기' ) 
        {  //상태가 삭제하기일경우.
            $new_board->delFunc($mysqlDB);
        }
        else 
            location("write_modify.php?number=$number");
    }    
    else   //유저가 쓴글. 수정시작.
        location("write_modify.php?number=$number&permission=1&board_number=$b_number&search_for=$search_for&search_index=$search_idx");
        
            
?>
</body>
</html>