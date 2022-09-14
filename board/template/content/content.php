<?
    include_once "../include/dbConnection.php";

    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) {
        echo "DB Connect Failed";
        exit;
    }
?>
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
        include_once "../include/header.html";
    ?>

    <div class='write_box'>
    <?        
        $number = $_GET['number']; //get으로 게시글 번호 받고 반영하기.

        visitedUpdate($mysqlDB,'board',$number);
    
        $sql = "select * FROM board WHERE number=$number";
        $result = mysqli_query($mysqlDB,$sql);
        $row=mysqli_fetch_assoc($result);
       
        echo "
        <h2 style='border-bottom:1px blue solid;padding:10px;'>",$row['subject']," 
        <span style='position: relative; left: 75%;'> 조회수:".$row['visited']."</span>
        <form action='content_modify.php' method='get'>
            <input type='hidden' name='number' value=".$number.">
            <input class='button' name='status' type='submit' value='삭제하기'>
            <input class='button' name='status' type='submit' style='margin:20px' value='수정하기'>
        </form>
        </h2>";


        echo "<div class='content_body'>
                <pre style='padding:10px;'>",$row['body'],"</pre>
                </div>
        ";    
    ?>
    <!-- 댓글 작성 -->

        <div style = "padding:10px;">
            <form action="comment_action.php" method="post"> 
                <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                <input class="button" type="submit" value="댓글쓰기">
                <input type="hidden" name="number" value=<?echo $number;?>>
                <input type="hidden" name="type" value="new_write">
                <p><input type="text" name="comment" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
            </form>
                <?php
                    $sql = "
                    SELECT B.number , C.number , C.comment , C.writer , C.comment_number
                    FROM board as B 
                    JOIN comment as C
                    WHERE B.number = C.number AND B.number=$number;
                    ";
                    $result  = mysqli_query($mysqlDB,$sql);
                
                    while( ( $row = mysqli_fetch_assoc($result) )) {
                       
                        echo "                              
                                <form action='comment_set.php' method='post'>
                                    <ul>
                                        <input style='margin:15px;' class='button comment_btn' type='submit' onclick='change(".$row['comment_number'].",remove)' name='comment_btn'  value='댓글삭제'> 
                                        <input class='button' type='submit' onclick='change(".$row['comment_number'].",modify)' name='comment_btn' value='댓글수정'> 
                                        <input type='hidden' name='comment_number' value='",$row['comment_number'],"'> 
                                        <input type='hidden' name='board_number' value='",$number,"'>                                    
                                        <li class='comment_writer'>",$row['writer'],"</li>
                                        <input type='hidden' id='comment_password_",$row['comment_number'],"' class='write_name' name='password' required class='write_name'>
                                        <li class='comment' id='comment_",$row['comment_number'],"'>",$row['comment'],"</li>
                                    </ul>
                              </form>
                        ";              

                    }
                    
                ?>

          
        </div>
    </div>

</body>

<script>
    var check = false;
        function change(number , set){
            var input = '#comment_password_'+number;
            if(set=='remove') {
                    if(check==false) {
                    $(input).attr('type','password');
                    check = true;
                }
            }
            else if(set=='modify'){
                if(check==false) {
                    $(input).attr('type','password');
                    check = true;
                }
            }
           
        }
    
</script>

<script src="../../js/basic.js"></script>
<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
 


</html>