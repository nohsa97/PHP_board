<script src="js/basic.js"></script>
<?
    include_once "../include/dbConnection.php";
    $mysqlDB = mysqlConnect();
    if(!$mysqlDB) {
        echo "<script>alert('DB연결 실패');</script>";
        exit;
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/style.css">
    <title>Document</title>
</head>
<body>
    <?
        include_once "../include/header.html";
    ?>

    <?php
        $number = $_GET['number']; //get으로 게시글 번호 받고 반영하기.

        if($number) { //게시글 번호가 있다 >> 수정 
            $sql = "select * FROM board WHERE number=$number";
            $result = mysqli_query($mysqlDB,$sql);
            $row=mysqli_fetch_assoc($result);
            //데이터 전송
            echo '
            <div class="write_box">
                <form action="write_action.php" method="post"> 
                    <h3 style="border-bottom:1px solid blue; padding:20px;">게시글 수정</h3>
                    <input type="text" name="writer" required  class="write_name" placeholder="작성자" value=',$row['writer'],'>
                    <input type="password" name="password" required class="write_name" placeholder="비밀번호" value=',$row['password'],'>
                    <p><input type="text" required name="subject" size="50px" class="write_subject" value=',$row['subject'],'></p>
                    <textarea name="body" required class="write_body" id="">',$row['body'],'</textarea>
                    <input class="button" type="submit" value="글쓰기">
                    <input type="hidden" name="selected" value="modify">
                    <input type="hidden" name="number" value="'.$number.'">
                </form>
            </div>
            ';
        }

        else {  // 없다 // 새로쓰기
            echo '
            <div class="write_box">
                <!--write_action.php로 post방식으로 데이터 전송. -->
                <form action="write_action.php" method="post"> 
                    <h3 style="border-bottom:1px solid blue; padding:20px;">게시글 작성</h3>
                    <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                    <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                    <!-- <input type="file" class="upload_img" name="img" id="" accept="image/png,image/jpeg" multiple="true" value="input_image"> -->
                    <p><input type="text" required name="subject" size="50px" class="write_subject" placeholder="게시글 제목을 입력해주세요."></p>
                    <textarea name="body" required class="write_body" id="" placeholder="내용을 입력해주세요."></textarea>
                    <input type="hidden" name="selected" value="new_write">
                    <input class="button" type="submit" value="글쓰기">
                </form>
            </div>
            ';
        }
        
    ?>



</body>
</html>