function goWrite() 
{
    location.href="../content/write_modify.php";
}  


function loginBtn() 
{
    var text = $('.logout').data("value");
    var msg = text+"하시겠습니까?";

    if (!confirm(msg)) 
        return false;
    
    else 
        location.href = "../../login/login.php";
    
    
}



function change_test(b_number, number, mode, come, per) { //보드넘버 , 해당 코멘트 넘버 , 모드(삭제,수정),유형(댓글 대댓글), 권한
    var input = '#'+come+'_password_'+ number; // 비밀번호 입력창
    var button = '#'+come+'_submit_'+ number; // 확인버튼
    var modi = '#'+come+'_send_'+ number; //수정눌렀을때 나오는 입력창
    var set = $('.set');
    
    if(per == 0 && mode == "modify") 
    { //회원권한 아닐때.
        if($(button).hasClass('hidden')){
            $(button).attr('class', 'write_name');
            $(input).attr('class', 'write_name');
            $(modi).attr('class', 'write_name');
        
            set.val("modify");
        }
        else 
        {
            $(button).attr('class', 'write_name hidden');
            $(input).attr('class', 'write_name hidden');
            $(modi).attr('class', 'write_name hidden');
            
            set.val("");
        }
    }
    else if(per == 0 && mode == "remove") 
    {
        if($(button).hasClass('hidden')){
            $(button).attr('class', 'write_name');
            $(input).attr('class', 'write_name');
            set.val("remove");
            }
        else { 
            $(button).attr('class', 'write_name hidden');
            $(input).attr('class', 'write_name hidden');
            $(modi).attr('class', 'write_name hidden');
            set.val("");
        }
    }
    else 
    { //유저권한 대댓글  
        if(mode == "remove") 
        {
            if(come == "comment") 
            {
                if( confirm( "삭제하시겠습니까?" ) ) 
                {
                    $.ajax({
                        url : "comment_set.php",
                        type : "POST",
                        data : {
                            content_number : b_number,
                            type : "comment",
                            set : "remove",
                            comment_number : number,
                            mode : 1,
                        },
                    }).done( function(){
                        alert( "회원님의 댓글이 삭제됐습니다." );
                    });
                    history.go(0);
                }
                else 
                    history.go(0);
            }
            else if(come == "reply")  
            {
                if( confirm( "삭제하시겠습니까?" ) ) 
                {
                    $.ajax({
                        url : "comment_set.php",
                        type : "POST",
                        data : {
                            comment_number : b_number,
                            type : "reply",
                            set : "remove",
                            reply_number : number,
                            mode : 1,
                        },
                    }).done( function(){
                        alert( "회원님의 대댓글이 삭제됐습니다." );
                    });
                    history.go(0);
                }
                else 
                    history.go(0);
            }
        }

        else if(mode == "modify") 
        {
            if($(button).hasClass('hidden')) 
            {
                $(button).attr('class', 'write_name');
                $(modi).attr('class', 'write_name');
                set.val("modify");
            }
            else 
            {
                $(button).attr('class', 'write_name hidden');
                $(modi).attr('class', 'write_name hidden');
                set.val("");
            }

            if(come == "comment") 
            {
                $(button).click(function(){
                    $.ajax({
                        url : "comment_set.php",
                        type : "POST",
                        data : {
                            body : $(modi).val(),
                            content_number : b_number,
                            type : "comment",
                            set : "modify",
                            comment_number : number,
                            mode : 1,
                        },
                        }).done( function(){
                            alert("댓글이 수정되었습니다.");
                            history.go(0);
                        });
    
                });
            }
            else if(come == "reply") 
            {
                $(button).click(function(){
                    $.ajax({
                        url : "comment_set.php",
                        type : "POST",
                        data : {
                            body : $(modi).val(),
                            comment_number : b_number,
                            type : "reply",
                            set : "modify",
                            reply_number : number,
                            mode : 1,
                        },
                        }).done( function(){
                            alert("댓글이 수정되었습니다.");
                            history.go(0);
                        });
    
                });
            }
        }
    }

}
