<?
        $number = $_GET['number']; //get으로 게시글 번호 받고 반영하기.
        $board_number = $_GET['board_number'];

       //검색해서 왔을경우.
        $search_idx = $_GET['search_index'];
        $search_for = $_GET['search_for'];
        visitedUpdate( $mysqlDB, 'board', $number );
    
        $sql = "select * FROM board WHERE number = $number";
        $result = mysqli_query( $mysqlDB, $sql );
        $row = mysqli_fetch_assoc( $result );
       
        echo "
        <h2 class='content_subject'>",$row['subject']," </h2>
        <span> 작성자:".$row['writer']."</span>
        <span> 조회수:".$row['visited']."</span>
        <form action='content_modify.php' method='post'>
            <input type='hidden' name='number' value=".$number.">
            <input type='hidden' name='permission' value=".$row['permission'].">
            <input type='hidden' name='writer' value=".$row['writer'].">
            <input class = 'delete content-button' name = 'status' onclick='del()' type = 'button' value = '삭제하기'>
            <input class = 'modify content-button' name = 'status' type = 'submit' value = '수정하기'>       
        </form>
        ";

        echo "<div class='content_body'>
                <pre style='padding:10px;'>",$row['body'],"</pre>
                <pre>",$row['img'],"</pre>
                </div>
        ";    
    ?>


function del() {
        var board = {
            writer : '<? echo $row_board['writer']; ?>',
            permission : <? echo $row_board['permission']; ?>,
            status : "삭제하기",
            number : <? echo $number; ?>,
        };
        $.ajax({
            url : "content_modify.php",
            type : "post",
            data : board, 
        }).done(function(data){
            alert(data);
            alert("삭제되었습니다?");
            location.href = "content_modify.php?number=<?echo $number;?>"
        });
    }



    // echo '
    // <div class="write_box" style="text-align:center;">     
    //  <form name="form" action="" method="post">  
    //     <h3 style="border-bottom:1px solid blue; padding:20px;">비밀번호 확인</h3>
    //     <input type="password" name="password" required class="write_name" placeholder="비밀번호">
    //     <input class="button" type="submit" value="확인하기">
    //  </form>
    //  </div>
    // ';

    // if( $_GET['status'] == '삭제하기' ) {  //상태가 삭제하기일경우.
    //     $input = $_POST['password'];
    //     if( $input == $row['password']) {
    //         $sql = remove( $mysqlDB, 'board', 'number', $number );       
    //         mysqli_query( $mysqlDB, $sql );
    //         $sql = remove( $mysqlDB, 'comment', 'number', $number );
    //         mysqli_query( $mysqlDB, $sql );
          
               
    //         alerting("삭제되었습니다.");
    //         location("../main/list.php?board_number=0");
    //     }
    //     else  {
    //         alerting("비밀번호를 입력해주세요.");
    //         exit;
    //     }
    // }
    // else if( $_GET['status'] == '수정하기' ) { // 상태가 수정하기일 경우 수정하기로 넘어감 
        
    // $input = $_POST['password'];

    //     if( $input == $row['password'] ) {
    //         location("write_modify.php?number=$number");
    //     }
    //     else  {
    //         alerting("비밀번호를 입력해주세요.");
    //         exit;
    //     }
    // }



    //아래 컨텐츠모디파이
    if( $permission == 0 ) {
        echo '
        <div class="write_box" style="text-align:center;">     
         <form name="form" action="" method="post">  
            <h3 style="border-bottom:1px solid blue; padding:20px;">비밀번호 확인</h3>
            <input type="password" name="password" required class="write_name" placeholder="비밀번호">
            <input type = "hidden" value = "',$number,'" name = "number">
            <input type = "hidden" value = "',$status,'" name = "status">
            <input class="button" type="submit" value="확인하기">
         </form>
         </div>
        ';
    
        if( $status == '삭제하기' ) {  //상태가 삭제하기일경우.
            $input = $_POST['password'];
            if( $input == $row['password']) {
                $sql = remove( $mysqlDB, 'board', 'number', $number );       
                mysqli_query( $mysqlDB, $sql );
                $sql = remove( $mysqlDB, 'comment', 'number', $number );
                mysqli_query( $mysqlDB, $sql );
              
                   
                alerting("삭제되었습니다.");
                location("../main/list.php?board_number=0");
            }
            else  {
                alerting("비밀번호를 입력해주세요.");
                exit;
            }
        }
        else if( $status == '수정하기' ) { // 상태가 수정하기일 경우 수정하기로 넘어감 
            
            $input = $_POST['password'];
    
            if( $input == $row['password'] ) {

                location("write_modify.php?number=$number&permission=0");
            }
            else  {
                alerting("비밀번호를 입력해주세요.");
                exit;
            }
        }
    }

    else {   //유저가 쓴글.
        if( isset( $userID )  && $writer == $userID ){ //작성자와 세션 아이디가 같다면.
            if( $_POST['status'] == '삭제하기' ) {  //상태가 삭제하기일경우.
                $sql = remove( $mysqlDB, 'board', 'number', $number );       
                mysqli_query( $mysqlDB, $sql );
                $sql = remove( $mysqlDB, 'comment', 'number', $number );
                mysqli_query( $mysqlDB, $sql );
                echo "테스트용 삭제 알림 ";
            }
            else {
                   location("write_modify.php?number=$number&permission=1");
            }
        }
        else {
            echo '
            <script>
                    alert("다른 사람의 글입니다.");
                    location.href = "',$prePage,'";
                    
            </script>
            ';
        }
    }