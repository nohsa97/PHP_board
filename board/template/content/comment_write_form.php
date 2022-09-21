<?
    include_once "../include/session.php";

    echo  '  
        <form class = "comment_input" action = "comment_action.php" method = "post"> ';

    
    if( $per == 1 ) {
        echo '
            <p style = "margin : 0px ;"> ',$userID,' </p>
            <input type = "hidden" name = "writer" required class = "write_name"  value = ',$userID,'>
            <input type = "hidden" name = "password" required class = "write_name" value = ',$userPass,'>
        ';
    }
    else {
        echo '
            <input type = "text" name = "writer" required  class ="write_name" placeholder = "작성자">
            <input type = "password" name = "password" required class = "write_name" placeholder = "비밀번호">
        ';
    }
    echo'   
            <input class = "button" type = "submit" value = "댓글쓰기">
            <input type = "button" style = "margin-right:15px;" onclick = "back()" class = "button" value = "목록으로">
            <input type = "hidden" name = "number" value = ',$number,'>
            <input type = "hidden" name = "type" value = "new_write">
            <p><input type = "text" name = "comment" required size = "50px" class = "write_subject" placeholder = "댓글 입력해주세요."></p>
        </form>
    ';
