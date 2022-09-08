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
        $sql = "select * FROM board WHERE number=$number";
        $result = mysqli_query($mysqlDB,$sql);
        $row=mysqli_fetch_assoc($result);
        
        
        echo "<h2 style='border-bottom:1px blue solid;padding:10px;'>",$row['subject'],"  <input class='button' type='submit' value='삭제하기' onclick='remove()'>
        <input class='button' type='submit' style='margin:20px' value='수정하기' onclick='modify()'></h2>";
        

        echo "<script>
        function remove() {
            location.href = 'remove_content.php?number=$number';
        }
        function modify(){
            location.href = 'write_modify_checkuser.php?number=$number';
        }
        </script>" ;


        echo "<div class='content_body'>
                <pre style='padding:10px;'>",$row['body'],"</pre>
                </div>
        ";    
    ?>

        <div style = "padding:10px;">
            <form action="comment_action.php" method="post"> 
                <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                <input class="button" type="submit" value="댓글쓰기">
                <input type="hidden" name="number" value=<?echo $number;?>>
                <p><input type="text" name="comment" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
            </form>
                <?php
                    $sql = "
                    SELECT B.number , C.number , C.comment , C.writer
                    FROM board as B 
                    JOIN comment as C
                    WHERE B.number = C.number AND B.number=$number;
                    ";
                    $result  = mysqli_query($mysqlDB,$sql);
                
                    while( ( $row = mysqli_fetch_assoc($result) )) {
                        echo "
                        <ul>
                            <input id='comment' class='button' type='button' onclick='modify_comment()' value='댓글수정'>
                            <li class='comment_writer'>",$row['writer'],"</li>
                            <li class='comment'>",$row['comment'],"</li>
                        </ul>
                        ";
                    }
                    // mysqli_close($mysqlDB);
                ?>

          
        </div>
    </div>

</body>
<script src="js/basic.js"></script>
<script  src="http://code.jquery.com/jquery-latest.min.js"></script>
 
<?php
   include_once "comment_modify.php"
?>
<!-- <script>
    function modify_comment(){
    var lis =  $('li')[1];
    $(lis).css('border','1px solid pink');
    $(lis).contents().unwrap().wrap('<input type="text" name="comment" required size="50px" value="test" class="write_subject" placeholder="댓글 입력해주세요.">');
    
}  
</script>  -->
</html>