<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="nav">
        UCERT 자유게시판 
    </div>

    <?php
        $number = $_GET['number']; //get으로 게시글 번호 받고 반영하기.
        $sql = "select * FROM board WHERE number=$number";
        $result = mysqli_query($mysqlDB,$sql);
        $row=mysqli_fetch_assoc($result);
        
    ?>


    <div class="write_box">
        <!--write_action.php로 post방식으로 데이터 전송. -->
        <form action="write_action.php" method="post"> 
            <h3 style="border-bottom:1px solid blue; padding:20px;">게시글 작성</h3>
            <input type="text" name="writer" required  class="write_name" placeholder="작성자">
            <input type="password" name="password" required class="write_name" placeholder="비밀번호">
            <p><input type="text" name="subject" size="50px" class="write_subject" placeholder="게시글 제목을 입력해주세요."></p>
            <textarea name="body" class="write_body" id="" placeholder="내용을 입력해주세요."></textarea>

            <input class="button" type="submit" value="글쓰기">
        </form>


    </div>


</body>
</html>