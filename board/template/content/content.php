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
        $board_number = $_GET['board_number'];

       //검색해서 왔을경우.
        $search_idx = $_GET['search_index'];
        $search_for=$_GET['search_for'];
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
                <pre>",$row['img'],"</pre>
                </div>
        ";    
    ?>
    <!-- 댓글 작성 -->

        <div style = "padding:10px;">
            
                <?php
                    include_once 'comment_write_form.php';
                    $sql = "
                    SELECT B.number , C.number , C.comment , C.writer , C.comment_number
                    FROM board as B 
                    JOIN comment as C
                    WHERE B.number = C.number AND B.number=$number;
                    ";
                    $result  = mysqli_query($mysqlDB,$sql);
                
                    while( ( $row = mysqli_fetch_assoc($result) )) {
                        echo "                              
            
                                    <ul class='comment_about_".$row['comment_number']."'>
                                        <input style='margin:15px;' class='button' type='button' onclick='change_remove(".$row['comment_number'].")' name='comment_btn' value='remove'> 
                                        <input class='button ' type='button' onclick='change_modify(".$row['comment_number'].")' name='comment_btn' value='modify'> 
                        
                                        <!-- 작성자 --!>
                                        <li class='comment_writer'>",$row['writer'],"</li>
                                        <!-- 숨겨진 버튼들 & POST 정보 --!>           
                                        <form action='comment_set.php' method='post' style='display:inline;'>     
                                            <input type='password' id='comment_password_",$row['comment_number'],"' class='write_name hidden' name='password' required class='write_name'>
                                            <input id='comment_submit_",$row['comment_number'],"' class='button verify_btn hidden' type='submit' value='확인'> 
                                            <input class='button set' type='hidden' name='set' value=''>   
                                            <input type='hidden' name='comment_number' value='",$row['comment_number'],"'> 
                                            <input type='hidden' name='board_number' value='",$number,"'> 
                                            <li class='comment' id='comment_",$row['comment_number'],"'>",$row['comment'],"</li>
                                            <input class='button' style='margin:-35px 18px 0px 10px !important;' onclick='test2(",$row['comment_number'],")' type='button' value='reply'> 
                                        </form> 
                                    </ul>
                            
                        ";              

                    }

                ?>

                <div class="content_footer"> 
                    <? include_once 'content_bottom.php';?>
                </div>

                
                  
        </div>
    </div>

</body>
<!-- 함수부분 -->
<?

//목록으로 돌아가기 함수.
 if(!$search_idx){
    echo '
        <script>
            function back() {
                location.href = "../main/list.php?board_number=',$board_number,'";
            }
        </script>
    ';
 }

 else {
    echo '
        <script>
            function back() {
                location.href = "../main/list_search.php?board_number=',$board_number,'&search_index=',$search_idx,'&search_for=',$search_for,'";
            }
        </script>
    ';
 }

 
 echo '
    <script>
        function test(){
           // $(".comment_about_141").append("<input type=\"text\" name=\"comment\" required size=\"50px\" class=\"write_subject\" placeholder=\"댓글 입력해주세요.\">");
        }
    </script>
 ';

?>

<script> 
    function test2(number){
        var input = '.comment_about_'+number;
        $(input).append("<input type=\"text\" name=\"comment\" required size=\"50px\" class=\"sub_com write_subject\" placeholder=\"대댓글 입력해주세요.\">");
    }
</script>



<script src="../../js/basic.js"></script>
<script  src="http://code.jquery.com/jquery-latest.min.js"></script>


</html>