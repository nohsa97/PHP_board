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

    $b_seq = $_POST['b_seq']; 
    $list_seq = $_POST['list_seq']; //보드넘버
    $status = $_POST['status'];


    $search_idx = $_POST['search_idx'];
    $search_for = $_POST['search_for'];
 

    $new_board = new board();
    $new_board = $new_board->getBoard($mysqlDB, $b_seq);

    $permission = $new_board->permission;
    $writer = $new_board->writer;



    
    if( $permission == 0 )  //비회원 게시글
    {
        echo '
        <div class="write_box" style="text-align:center;">     
         <form name="form" action="" method="post">  
            <h3 style="border-bottom:1px solid blue; padding:20px;">비밀번호 확인</h3>
            <input type="password" name="password" required class="write_name" placeholder="비밀번호">
            <input type = "hidden" value = "',$b_seq,'" name = "b_seq">
            <input type = "hidden" value = "',$list_seq,'" name = "list_seq">
            <input type = "hidden" value = "',$status,'" name = "status">
            <input type = "hidden" value = "',$search_idx,'" name = "search_idx">
            <input type = "hidden" value = "',$search_for,'" name = "search_for">
            <input class="button" type="submit" value="확인하기">
         </form>
         </div>
        ';
        
        $input = $_POST['password'];

        if( $status == 'remove' ) 
        {  //상태가 remove일경우.
            
            if( $input == $new_board->password ) 
            {
   
                $new_board->delFunc($mysqlDB);
                alerting("삭제되었습니다.");
                location("../main/list.php?list_seq=0&search_for=",$search_for,"&search_index=",$search_idx,"");
            }
            else  
            {
                alerting("비밀번호를 입력해주세요.");
                exit;
            }
        }
        else if( $status == 'modify' ) 
        { // 상태가 modify일 경우 modify로 넘어감 

            $list_seq = $_POST['list_seq'];


            if( $input == $new_board->password ) 
            {
                location("write_modify.php?b_seq=$b_seq&permission=0&list_seq=$list_seq&search_for=$search_for&search_index=$search_idx");
            
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
        if( $_POST['status'] == 'remove' ) 
        {  //상태가 remove일경우.
            $new_board->delFunc($mysqlDB);
        }
        else 
            location("write_modify.php?b_seq=$b_seq&permission=1&list_seq=$list_seq&search_for=$search_for&search_index=$search_idx");
    }    
        
            
?>
</body>
</html>