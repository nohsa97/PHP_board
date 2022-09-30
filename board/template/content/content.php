<?
    include_once "../include/dbConnection.php";
    include_once "comment_list.php";

    $mysqlDB = mysqlConnect();
    if (!$mysqlDB) 
    {
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
        include_once "../include/session.php";
    ?>

    <div class='write_box'>
        <?
            $b_seq = $_GET['b_seq']; //get으로 게시글 번호 받고 반영하기.
            $list_seq = $_GET['list_seq']; //get으로 넘어온 보드 넘버(리스트 페이징넘버)

            //검색해서 왔을경우.
            $search_idx = $_GET['search_index'];
            $search_for = $_GET['search_for'];

            $depth_0 = getCount_table_option($mysqlDB, 'comment_test', 'c_depth', 0);//댓글 수 
            //입장시 조회수 증가
            // visitedUpdate( $mysqlDB, 'board', $b_seq );
        

            $select_board = new board();
            $select_board = $select_board->getBoard($mysqlDB, $b_seq); //시퀀스 넘버를 넘겨서 보드 값을 데베에서 가져옴.

            echo "
            <h2 class='content_subject'>",$select_board->subject," </h2>
            <span style='margin:0px 3em 10px 0px;'> 작성자:".$select_board->writer."</span> 
            <span> 조회수:".$select_board->visited."</span>

            <form action='content_modify.php' method='post'>
                <input type='hidden' name='b_seq' value=".$b_seq."> 
                <input type='hidden' name='list_seq' value=".$list_seq.">
                ";
                

        if($search_for)
        {
            echo "
                <input type='hidden' name='search_for' value=".$search_for.">
                <input type='hidden' name='search_idx' value=".$search_idx.">";
        }
                
        if( $select_board->permission == 0 )
        { //비회원 게시글 일때
            echo "
                <input class = 'delete content-button' name = 'status' type = 'submit' value = 'remove'>
                <input class = 'modify content-button' name = 'status' type = 'submit' value = 'modify'>       
            </form>
            ";
        }
        
        else if($select_board->writer == $userID)  // 회원 게시글이며 동일한 유저 게시글일때
        {
            echo "
                <input class = 'delete content-button' name = 'status' onclick='del()' type = 'button' value = 'remove'>
                <input class = 'modify content-button' name = 'status' type = 'submit' value = 'modify'>       
            </form>
            ";
        }
        else { echo "</form>"; } //로그인상태에서 다른유저 게시글 들어갔을때는 form이 깨지므로 추후에 이쁘게 바꾸겠지만 지금당장은 땜빵.
            echo "
                    <div class='content_body'>
                    <pre style='padding:10px;'>",$select_board->body,"</pre>
                    
                    </div>
            ";    
        ?>
    <!-- 댓글 작성 -->

        <div style = "padding:10px;">
                <?php
                    $depth_num = 0;
                    include_once 'comment_write_form.php';
            
                    $result = $select_board->comment_list($mysqlDB, $b_seq);
                    


                    while( ( $row = mysqli_fetch_assoc( $result ) ) ) 
                    {
                        access_content( $row, $b_seq,  $row['c_depth']); //conmment_list에 있음        
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
 if( !$search_idx )
 {
    echo '
        <script>
            function back() {
                location.href = "../main/list.php?list_seq=',$list_seq,'";
            }
        </script>
    ';
 }
 else 
 {
    echo '
        <script>
            function back() {
                location.href = "../main/list_search.php?list_seq=',$list_seq,'&search_index=',$search_idx,'&search_for=',$search_for,'";
            }
        </script>
    ';
 }

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script  src = "http://code.jquery.com/jquery-latest.min.js"></script>
<script src = "../../js/basic.js"></script>


<script>
    function del() //삭제 누를시 (로그인시 나오는 컨텐츠 페이지에서 버튼 클릭시)
    {
        var permission = <? echo  $select_board->permission; ?>;
        var sel_seq = <? echo  $select_board->b_seq; ?>;
        if( permission == 1 ) 
        {
            if (!confirm("삭제하시겠습니까?")) 
            {
                return false;
            } 
            else 
            {

                $.ajax({
                    url : "content_modify.php",
                    type : "post",
                    data : {
                        status : 'remove',
                        b_seq : sel_seq,
                        
                    }, 
                }).done(function()
                {
                    alert("회원님 게시글이 삭제되었습니다.");
                    location.href = "../main/list.php?list_seq=0"
                });
            }
        }

    }
</script>


<? 
echo  
"
    <script>
        var wind;
        var link = 'reply_create.php?b_seq=",$b_seq,"&c_seq=';
        $(document).ready(function() 
        {
            $('.reply_btn').on('click',function()
            {
                if(wind != null)
                {
                    wind.close();    
                   
                }
                wind = window.open(link+$(this).attr('id'),'_blank','width=700,height=200,top=300,left=300, resizeable=no');
            });
        });

        </script>
";
      
?>

</html>