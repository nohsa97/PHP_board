<script src="js/basic.js"></script>
<?
include_once "../include/dbConnection.php";
$mysqlDB = mysqlConnect();
if (!$mysqlDB) {
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
    include_once "../include/header.php";
    include_once "../include/session.php";
    ?>

    <?php
    $b_seq = $_GET['b_seq']; //get으로 게시글 번호 받고 반영하기.
    $list_seq = $_GET['list_seq'];

    //검색해서 왔을경우 돌아갈길 확보
    $search_for = $_GET['search_for'];
    $search_idx = $_GET['search_index'];

    if ($b_seq) 
    { //게시글 번호가 있다 >> 수정 
        // $sql = "select * FROM board WHERE seq = $seq";
        // $result = mysqli_query($mysqlDB, $sql);

        // $row = mysqli_fetch_assoc($result);  
        $select_board = new board();
        $select_board = $select_board->getBoard($mysqlDB, $b_seq);
        //데이터 전송
        echo '
            <div class="write_box">
                <form action="write_action.php" method="post"> 
                    <h3 style="border-bottom:1px solid blue; padding:20px;">게시글 수정</h3>';

            
            if ( !$userID || ( $select_board->permission == 0)) 
            { //세션에 유저아이디가 없거나 보드퍼미션이 0인 경우
                echo '
                        <input type="text" name="writer" required  class="write_name" placeholder="작성자" value=', $select_board->writer, '>
                        <input type="password" name="password" required class="write_name" placeholder="비밀번호" value=', $select_board->password, '>
                        <input type="hidden" name="permission" value="0">
                    ';
            } 
            
            else if ( $userID && ( $select_board->permission== 1)) 
            {

                echo '
                        <input type="hidden" name="writer"   class="write_name" placeholder="작성자" value=',$select_board->writer, '>
                        <input type="hidden" name="password"  class="write_name" placeholder="비밀번호" value=',$select_board->password, '>
                        <input type="hidden" name="permission" value="1">
                        ';

            }
            if($search_for)
            {
                echo '            
                        <input type = "hidden" value = "',$search_idx,'" name = "search_idx">
                        <input type = "hidden" value = "',$search_for,'" name = "search_for">
                       ';
            }

                echo '
                        <p><input type="text" required name="subject" size="50px" class="write_subject" value=', $select_board->subject, '></p>
                        <textarea name="body" required class="write_body" id="">', $select_board->body, '</textarea>

                        <input class="button" type="submit" value="글쓰기">
                        
                        <input type="hidden" name="selected" value="modify">
                        <input type="hidden" name="list_seq" value="',$list_seq,'">
                        <input type="hidden" name="b_seq" value="' . $b_seq . '">
                        <input type="hidden" name="visited" value="' .$select_board->visited. '">
                </form>
            </div>
                ';
    } 

            else 
            {  // 없다 // 새로쓰기
                        echo '
                        <div class="write_box">
                            <!--write_action.php로 post방식으로 데이터 전송. -->
                            <form action="write_action.php" method="post"> 
                                <h3 style="border-bottom:1px solid blue; padding:20px;">게시글 작성</h3>';
                    if (!$userID) 
                    {     //비로그인 
                        echo '
                                <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                                <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                                <input type="hidden" name="permission" value="0">';
                    } 
                    else 
                    {  //로그인 정보 넘기기. 
                        echo '
                            <input type="hidden" name="writer"  class="write_name" value=', $userID, '>
                            <input type="hidden" name="password" class="write_name" value=', $userPass, '>
                            <input type="hidden" name="permission" value="1">';
                    }
                        echo '
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
<script  src = "http://code.jquery.com/jquery-latest.min.js"></script>
<script src = "../../js/basic.js"></script>

</html>