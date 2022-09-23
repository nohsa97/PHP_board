<link rel="stylesheet" href="../../css/style.css">

<?
    include_once '../include/dbConnection.php';
    include_once '../include/session.php';
?>

<?
$b_number = $_GET['number'];
$c_number = $_GET['comment_number'];


    if(!$userID) 
    { //세션에 로그인아디가 없을경우
        echo '
        <form class="comment_input" action="comment_action.php" method="post"> 
                    <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                    <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                    <input class="button" type="submit" value="댓글쓰기">
                    <input type="hidden" name="number" value=<?echo $number;?>
                    <input type="hidden" name="type" value="reply_write">
                    <input type="hidden" name="number" value="',$b_number,'">
                    <input type="hidden" name="comment_number" value="',$c_number,'">
                    <p><input type="text" name="body" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
        </form>
        ';
    }
    else 
    {
        echo '
        <form class="comment_input" action="comment_action.php" method="post"> 
                    <p class="write_name user">',$userID,'</p>
                    <input class="button" type="submit" value="댓글쓰기">
                    <input type="hidden" name="number" value=<?echo $number;?>
                    <input type="hidden" name="type" value="reply_write">
                    <input type="hidden" name="writer" value="',$userID,'">
                    <input type="hidden" name="number" value="',$b_number,'">
                    <input type="hidden" name="comment_number" value="',$c_number,'">
                    <p><input type="text" name="body" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
        </form>
        ';
    }
?>


<!-- 700 *  180 -->