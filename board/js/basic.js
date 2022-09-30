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



function change_test(b_number, number, mode, depth, per) { //보드넘버 , 해당 코멘트 넘버 , 모드(삭제,수정),유형(댓글 대댓글), 권한
    var input = '#password_'+ number; // 비밀번호 입력창
    var button = '#submit_'+ number; // 확인버튼
    var modi = '#send_'+ number; //수정눌렀을때 나오는 입력창
    var set = $('input[name="set"]');
    
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
    else  //유저권한
    {

            if(per == 1 && mode == "remove") //유저체크는 안해도됨. 세션에서 아이디비교하고 버튼을 보여주기때문.
            {
                if( confirm("삭제하시겠습니까?") )
                {
                    $.ajax({
                        url : 'comment_set.php',
                        type : 'POST',
                        data : {
                            // depth : 0,
                            set : 'remove',
                            c_seq : number,
                        }
                    }).done( function () {
                        alert("회원님의 댓글이 삭제되었습니다.");
                        history.go(0);
                    });
                }
                else
                {
                    //거절시 아무것도 반응 x
                }
            }
            
                
            else if(per == 1 && mode == "modify") 
            { 
                    if($(button).hasClass('hidden')){
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

                $(button).click(function () {
                    $.ajax({
                        url : 'comment_set.php',
                        type : 'POST',
                        data : {
                            // depth : 0,
                            set : 'modify',
                            c_seq : number,
                            body : $(modi).val(),
                        }
                    }).done(function() {
                        alert("수정 성공");
                        history.go(0);
                    })
                });
            }

        else //대댓글이면
        {

        }

    }
}
