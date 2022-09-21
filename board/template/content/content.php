<?
    include_once "../include/dbConnection.php";
    include_once "comment_list.php";

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?
        include_once "../include/header.php";
    ?>

    <div class='write_box'>
    <?
        $number = $_GET['number']; //get으로 게시글 번호 받고 반영하기.
        $board_number = $_GET['board_number'];

       //검색해서 왔을경우.
        $search_idx = $_GET['search_index'];
        $search_for = $_GET['search_for'];
        visitedUpdate( $mysqlDB, 'board', $number );
    
        $sql = "select * FROM board WHERE number = $number";
        $result = mysqli_query( $mysqlDB, $sql );
        $row_board = mysqli_fetch_assoc( $result );
       
        echo "
        <h2 class='content_subject'>",$row_board['subject']," </h2>
        <span style='margin:0px 3em 10px 0px;'> 작성자:".$row_board['writer']."</span> 
        <span> 조회수:".$row_board['visited']."</span>
        <form action='content_modify.php' method='post'>
            <input type='hidden' name='number' value=".$number.">
            <input type='hidden' name='permission' value=".$row_board['permission'].">
            <input type='hidden' name='writer' value=".$row_board['writer'].">";
    if( $row_board['permission'] == 0 ){ //비회원 게시글 일때
        echo "
            <input class = 'delete content-button' name = 'status' type = 'submit' value = '삭제하기'>
            <input class = 'modify content-button' name = 'status' type = 'submit' value = '수정하기'>       
        </form>
        ";
    }
    else if($row_board['writer']==$userID) {
        echo "
            <input class = 'delete content-button' name = 'status' onclick='del()' type = 'button' value = '삭제하기'>
            <input class = 'modify content-button' name = 'status' type = 'submit' value = '수정하기'>       
        </form>
        ";
    }
    else { echo "</form>"; } //로그인상태에서 다른유저 게시글 들어갔을때는 form이 깨지므로 추후에 이쁘게 바꾸겠지만 지금당장은 땜빵.
        echo "
                <div class='content_body'>
                <pre style='padding:10px;'>",$row_board['body'],"</pre>
                <pre>",$row_board['img'],"</pre>
                </div>
        ";    
    ?>
    <!-- 댓글 작성 -->

        <div style = "padding:10px;">
                <?php
                    include_once 'comment_write_form.php';
                    $sql = "
                    SELECT B.number , C.number , C.comment , C.writer , C.comment_number, C.permission
                    FROM board as B 
                    JOIN comment as C
                    WHERE B.number = C.number AND B.number = $number;
                    ";
                    // echo $sql;
                    $result  = mysqli_query( $mysqlDB, $sql );
                
                    while( ( $row = mysqli_fetch_assoc( $result ) ) ) {
                        access_content( $row, 'comment', $number );
                
                        include 'reply.php';
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
 if( !$search_idx ){
    echo '
        <script>
            function back() {
                location.href = "../main/list.php?board_number=',$board_number,'&comment_number=',$number,'";
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

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script  src = "http://code.jquery.com/jquery-latest.min.js"></script>
<script src = "../../js/basic.js"></script>


<script>
    function del() {
        var permission = <? echo $row_board['permission']; ?>;
        if( permission == 1 ) {
                if (!confirm("삭제하시겠습니까?")) {
            } else {
                var board = {
                writer : '<? echo $row_board['writer']; ?>',
                permission : 1,
                status : "삭제하기",
                number : <? echo $number; ?>,
                };
                $.ajax({
                    url : "content_modify_login.php",
                    type : "post",
                    data : board, 
                }).done(function(result){
                    alert(result);
                    history.back();
                });
            }
        }
        else if( permission == 0 ) {
           var input_pass =  prompt( "비밀번호를 입력해주세요." );
        }
    }
</script>


<? 
echo  
"
    <script>
        var link = 'reply_create.php?number=",$number,"&comment_number=';
        $(document).ready(function() {
            $('.reply_btn').on('click',function(){
                    window.open(link+$(this).attr('id'),'_blank','width=700,height=180,top=300,left=300, resizeable=no');
            });
        })

        </script>
";
      
?>

</html>