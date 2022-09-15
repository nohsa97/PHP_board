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
    $pass = $_POST['password'];
    $c_number = $_POST['comment_number'];
    $set = $_POST['set'];
    $comment = $_POST['comment'];



    if($set=='modify'){
        if($mysqlDB){
            $sql = FindSQL($mysqlDB,'comment','comment_number',$c_number);
            $result = mysqli_query($mysqlDB,$sql);
            $row=mysqli_fetch_assoc($result);
            
            if($row['password']==$pass){       
               $sql2 = dataUpdate($mysqlDB,'comment','comment',$comment,'comment_number',$c_number);
              
               $result = mysqli_query($mysqlDB,$sql2);
               alerting('댓글 수정 완료');
               location('content.php?number='.$b_number);
            }
            else {
                alerting('올바른 비밀번호를 입력하세요'); 
                location('content.php?number='.$b_number);
            }
        }  
    }
    else if($set == 'remove'){
        if($mysqlDB){
            $sql = FindSQL($mysqlDB,'comment','comment_number',$c_number);
            $result = mysqli_query($mysqlDB,$sql);
            $row=mysqli_fetch_assoc($result);
            
            if($row['password']==$pass){       
                $sql = remove($mysqlDB,'comment','comment_number',$c_number);      
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

