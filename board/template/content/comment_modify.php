 
<?php
    echo "
        <script>
            function modify_comment(){
            var lis =  $('li')[1];
            $(lis).css('border','1px solid pink');
            $(lis).contents().unwrap().wrap('<input type=\"text\" name=\"comment\" required size=\"50px\" value=\"sszxc\" class=\"write_subject\" placeholder=\"댓글 입력해주세요.\">');
            }  
        </script> 
    ";
?>