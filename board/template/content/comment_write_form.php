<form class='comment_input' action="comment_action.php" method="post"> 
                <input type="text" name="writer" required  class="write_name" placeholder="작성자">
                <input type="password" name="password" required class="write_name" placeholder="비밀번호">
                <input class="button" type="submit" value="댓글쓰기">
                <input type="button" style="margin-right:15px;" onclick="back()" class="button" value="목록으로">
                <input type="hidden" name="number" value=<?echo $number;?>>
                <input type="hidden" name="type" value="new_write">
                <p><input type="text" name="comment" required size="50px" class="write_subject" placeholder="댓글 입력해주세요."></p>
</form>