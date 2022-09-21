
function checkUser() {
    prompt("비밀번호를 입력해주세요.")
}



function modify_comment(){
    var password = prompt('비밀번호를 입력해주세요');
}

// 


function change_remove(b_number,number,come,per){ // 보드넘버, 댓글번호 , 종류,  퍼미션
    if( per == 0 ){
        if(come=='comment'){
            var input = '#comment_password_'+ number;
            var button = '#comment_submit_'+ number;
            var modi = '#comment_send_'+ number;
        }
        else if(come=='reply'){
            var input = '#reply_password_'+ number;
            var button = '#reply_submit_'+ number;
            var modi = '#reply_send_'+ number;
        }
    
        var set = $('.set');
        if($(button).hasClass('hidden')){
        $(button).attr('class','write_name');
        $(input).attr('class','write_name');
        set.val("remove");
        }
        else { 
            $(button).attr('class','write_name hidden');
            $(input).attr('class','write_name hidden');
            $(modi).attr('class','write_name hidden');
            set.val("");
        }
    }
    else { //유저권한 
        if( confirm( "삭제하시겠습니까?" ) ){
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
}   

function change_modify(b_number,number,come,per) {
    if(come=='comment'){
        var input = '#comment_password_'+number;
        var button = '#comment_submit_'+number;
        var modi = '#comment_send_'+number;
    }
    else if(come=='reply'){
        var input = '#reply_password_'+number;
        var button = '#reply_submit_'+number;
        var modi = '#reply_send_'+number;
    }
    var set = $('.set');
    if(per==0) {
    
        if($(button).hasClass('hidden')){
            $(button).attr('class','write_name');
            $(input).attr('class','write_name');
            $(modi).attr('class','write_name');
        
            set.val("modify");
        }
        else {
            $(button).attr('class','write_name hidden');
            $(input).attr('class','write_name hidden');
            $(modi).attr('class','write_name hidden');
            
            set.val("");
        }
    }
    else {
            
            if($(button).hasClass('hidden')){
                $(button).attr('class','write_name');
                $(modi).attr('class','write_name');
                set.val("modify");
            }
            else {
                $(button).attr('class','write_name hidden');
                $(modi).attr('class','write_name hidden');
                set.val("");
            }
            $('.write_name').click(function(){
                $.ajax({
                    url : "comment_set.php",
                    type : "POST",
                    data : {
                        content_number : b_number,
                        type : "comment",
                        set : "modify",
                        comment_number : number,
                        mode : 1,
                    },
                    }).done( function(){
                    });

            });

    }

}
