<link rel="stylesheet" href="../../css/style.css">
<?
    include_once "../include/header.html";
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) {
        echo "DB Connect Failed";
        exit;
    }
    $board_number = $_GET['number'];
    $sql = "select password from board where number=$board_number";
    $result = mysqli_query($mysqlDB,$sql);
    $row=mysqli_fetch_assoc($result);

     
    echo '
    <div class="write_box" style="text-align:center;">     
     <form name="form" action="" method="post">  
        <h3 style="border-bottom:1px solid blue; padding:20px;">게시글 삭제</h3>
        <input type="password" name="password" required class="write_name" placeholder="비밀번호">
        <input class="button" type="submit" value="확인하기">
     </form>
     </div>
    ';

    $input = $_POST['password'];
    if($input == $row['password']) {
        $sql2 = remove($mysqlDB,'board',$board_number);       
        mysqli_query($mysqlDB,$sql2);
      
        $sql = "select * from comment where number=$board_number";
        $result=mysqli_query($mysqlDB,$sql);
        // $row=mysqli_fetch_assoc($result);

        while($row=mysqli_fetch_assoc($result)) {  //게시글 보내면서 게시글 번호를 전달하기 
              $sql2=remove($mysqlDB,'comment',$board_number);  
              mysqli_query($mysqlDB,$sql2);
              mysqli_close($mysqlDB); //댓글 삭제
        }
        


        
        alerting("삭제되었습니다.");
        location("../main/list.php?board_number=0");
    }
    else  {
        alerting("비밀번호를 입력해주세요.");
        exit;
    }

?>