<?
    include_once "../include/session.php";

    function access_content( $row, $set, $board_num ) {
        $userID = $_SESSION['userID'];
        if( $set == 'reply' ) {
            echo "                              
            <ul class='reply comment_about_".$row[$set.'_number']."'>
                <span class='material-symbols-outlined'>reply</span>";
        }
        else if( $set == 'comment' ) {
            echo "
            <ul class='base comment_about_".$row[$set.'_number']."'>";
        }
        if( ( $row['permission'] == 0 ) || $userID == $row['writer'] ){
            echo"
                <input style='margin:15px;' class='button' type='button' onclick=\"change_remove(",$board_num,",".$row[$set.'_number'].",'",$set,"',",$row['permission'],")\" name='comment_btn' value='remove'> 
                <input class='button ' type='button' onclick=\"change_modify(",$board_num,",".$row[$set.'_number'].",'",$set,"',",$row['permission'],")\" name='comment_btn' value='modify'> ";
        }
        
        echo"
            <!-- 작성자 --!>
            <li class='comment_writer'>",$row['writer'],"</li>
            
            <!-- 숨겨진 버튼들 & POST 정보 --!>           
                <form action='comment_set.php' method='post' style='display:inline;'>     
                    <input type='password' id='",$set,"_password_",$row[$set.'_number'],"' class='write_name hidden' name='password' required>
                    <input id='",$set,"_submit_",$row[$set.'_number'],"' class='button verify_btn hidden' type='submit' value='확인'> 
                    <input class='set' type='hidden' name='set' value=''>
            
                    <!-- 보내기용 정보들 --!>
                    <input  type='hidden' name='",$set,"_number' value='",$row[$set.'_number'],"'> 
                    <input  type='hidden' name='content_number' value='",$board_num,"'> 
                    <input class='set' type='hidden' name='set' value=''>"; 

                    if( $set == 'reply' ){
                        echo"
                        <input class='type' type='hidden' name='type' value='reply'>
                        <li class='comment' id='",$set,"_",$row['reply_number'],"'>",$row['reply_comment'],"</li>
                        <input type='text' id='reply_send_",$row[$set.'_number'],"' name='comment' required size='50px' class='write_subject hidden' value='",$row['reply_comment'],"'>";
                    }
                    else if( $set == 'comment' ){
                        echo "  
                        <input class='type' type='hidden' name='type' value='comment'>
                        <li class='comment' id='",$set,"_",$row[$set.'_number'],"'>",$row['comment'],"</li>
                        <input id=",$row['comment_number']," class='reply_btn button' style='margin:-35px 18px 0px 10px !important;' type='button' value='reply'> 
                        <input type='text' id='comment_send_",$row[$set.'_number'],"' name='comment' required size='50px' class='write_subject hidden' value='",$row['comment'],"'>
                        "; 
                                            
                    }
                    
            echo"
                </form> 
        </ul>";
    }
?>