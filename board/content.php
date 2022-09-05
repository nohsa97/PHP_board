<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="nav">
        UCERT 자유게시판 
    </div>

    <div class='write_box'>
    <?php
        $mysqlDB = new mysqli('localhost', 'root', 'clzls123', 'test_board');
        if ($mysqlDB->connect_errno)
        {
            echo 'mysql error';
        }
        else
        {
            $number = $_GET['number']; //get으로 게시글 번호 받고 반영하기.
            $sql = "select * FROM board WHERE number=$number";
            $result = mysqli_query($mysqlDB,$sql);
            $row=mysqli_fetch_assoc($result);
            
            
            echo "<h2 style='border-bottom:1px blue solid;padding:10px;'>",$row['subject'],"  <input class='button' type='submit' value='수정하기' onclick='modify()'></h2>";

            echo "<script>
            function modify(){
                location.href = 'write_modify.php?number=$number';
            }
            </script>" ;

            
            // echo "<input type='submit' value='글쓰기'>";
            echo "<div class='content_body'>
                   ",$row['body'],"
                  </div>
            ";
            mysqli_close($mysqlDB);
        }
    ?>

        <div style = "padding:10px;">
            <form action="comment_action.php" method="post"> 
                <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                <input class="button" type="submit" value="글쓰기">
                <p><input type="text" name="comment" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
               <!-- <p><input class="button" type="submit" value="글쓰기"></p> -->
            </form>

            <ul>
                <li class="comment_writer">작성자</li>
                <li class="comment">댓글</li>
            </ul>
        </div>
    </div>

    <script>
        function modify(){
            location.href = "write_modify.php?number=";
        }
    </script>
    
</body>
</html>