<?
    include_once "../include/dbConnection.php";

    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) {
        echo "DB Connect Failed";
        exit;
    }
?>
<?php 
    $b_number = $_POST['board_number'];
    $set = $_POST['comment_btn'];
    $pass = $_POST['password'];
    $comment_number = $_POST['comment_number'];
    if($set == '댓글수정'){
        echo "asdasd";
        exit;
        if($mysqlDB){
            $sql = FindSQL($mysqlDB,'comment','comment_number',$comment_number);
            $result = mysqli_query($mysqlDB,$sql);
            $row=mysqli_fetch_assoc($result);
            
            if($row['password']==$pass){       
               echo "123123";
            }
            else {
                alerting('올바른 비밀번호를 입력하세요'); 
                location('content.php?number='.$b_number);
            }
        }  
    }
    else if($set == '댓글삭제'){
        if($mysqlDB){
            $sql = FindSQL($mysqlDB,'comment','comment_number',$comment_number);
            $result = mysqli_query($mysqlDB,$sql);
            $row=mysqli_fetch_assoc($result);
            
            if($row['password']==$pass){       
                $sql = remove($mysqlDB,'comment','comment_number',$comment_number);      
                $result = mysqli_query($mysqlDB,$sql);          
                alerting('댓글을 삭제했습니다.');
                location('content.php?number='.$b_number); 
            }
            else {
                alerting('올바른 비밀번호를 입력하세요'); 
                location('content.php?number='.$b_number);
            }
        }  
    }
?>

