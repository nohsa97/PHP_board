
<?
    include_once "../include/session.php";
    $userID = $_SESSION['userID'];

    function access_content( $row, $list_seq, $depth_num)
    {  // 검색된 row값들, 댓글 대댓글판단, 게시물번호     
        include_once "../include/session.php";
        $userID = $_SESSION['userID'];
        $tests = 100;
        $base = 67;
        
        if( $depth_num != 0 ) 
        {
            echo "                              
            <ul class='reply comment_about_".$row['c_seq']."'  style = 'width:";
            echo $tests - (5 * $depth_num),"%; left : ";echo $base * $depth_num + (($depth_num - 1) * 13),"px ' >
                <span class='material-symbols-outlined'>reply</span>";
        }
        else if( $depth_num == 0 ) 
        {
            echo "
            <ul class='base comment_about_".$row['c_seq']."'>";
        }
    
        if( ( $row['permission'] == 0 ) || $userID == $row['writer'] )
        {
            
            echo"
                <input style='margin:15px;' class='button' type='button' onclick=\"change_test(",$list_seq,",".$row['c_seq'].", 'remove',",$row['c_depth'],",",$row['permission'],")\" name='comment_btn' value='remove'> 
                <input class='button ' type='button' onclick=\"change_test(",$list_seq,",".$row['c_seq'].", 'modify',",$row['c_depth'],",",$row['permission'],")\" name='comment_btn' value='modify'> ";
        }
        
        echo"
            <!-- 작성자 --!>
                <li class='comment_writer'>",$row['writer'],"</li>
            
            <!-- 숨겨진 버튼들 & POST 정보 --!>           
                <form action='comment_set.php' method='post' style='display:inline;'>     
                    <input type='password' id='password_",$row['c_seq'],"' class='write_name hidden' name='password' required>
                    <input id='submit_",$row['c_seq'],"' class='button verify_btn hidden' type='submit' value='확인'> 
                   
                    <input type='hidden' name='set' value=''>
            
                    <!-- 보내기용 정보들 --!>
                    <input  type='hidden' name='c_seq' value='",$row['c_seq'],"'> 
                    <input  type='hidden' name='list_seq' value='",$list_seq,"'> 
                    "; 
                    

                    echo "  
                    <li class='comment' id='",$row['c_seq'],"'>",$row['body'],"</li>
                    
                    <input id=",$row['c_seq']," class='reply_btn button' style='margin:-35px 18px 0px 10px !important;' type='button' value='reply'> 
                    <input type='text' id='send_",$row['c_seq'],"' name='body' required size='50px' class='write_subject hidden' value='",$row['body'],"'>
                </form> 
             </ul>";                                           
   
    }
?>