function goWrite() {
    location.href="../content/write_modify.php";
}      



function checkUser() {
    prompt("비밀번호를 입력해주세요.")
}



function modify_comment(){
    var password = prompt('비밀번호를 입력해주세요');
}

// 

var check = false;
function change_remove(number){
    var input = '#comment_password_'+number;
    var button = '#comment_submit_'+number;
    var set = $('.set');
    if(check==false){
    $(button).attr('class','write_name');
    $(input).attr('class','write_name');
    set.val("remove");
    check =true;
    }
    else { 
        history.go(0);
        
    }
}   

function change_modify(number) {
    var input = '#comment_password_'+number;
    var button = '#comment_submit_'+number;
    var set = $('.set');
    var comment = '#comment_'+number;
    var nosharp = 'comment_'+number;

    if(check==false){
        var comment_val = document.getElementById(nosharp).innerHTML;
        $(button).attr('class','write_name');
        $(input).attr('class','write_name');
        $(comment).contents().unwrap().wrap('<input type="text" name="comment" required size="50px" class="write_subject" value='+comment_val+' placeholder="댓글 입력해주세요.">');
        set.val("modify");
        check=true;
    }
    else {
        history.go(0);
        
    }

}