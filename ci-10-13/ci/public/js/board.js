function board_confirm(set) 
{
    var arr = [];
    var setting = [];  // 세팅값에 따라 modi가 앞이면 modi부터 
    arr["modify"] = "btn-primary"; //버튼 색
    arr["remove"] = "btn-danger";

    if (set == "modify")
    {
        setting[0] = "modify";
        setting[1] = "remove";
    }

    else 
    {
        setting[0] = "remove";
        setting[1] = "modify";
    }


    if ( $("#b_" + setting[0] + "_pass").hasClass("hidden") )
    {
        $("#b_" + setting[0] + "_pass").attr("class","");
        $("#b_" + setting[0] + "_btn").attr("class","test btn " + arr[set]);
        
        $("#b_" + setting[1] + "_pass").attr("class","hidden");
        $("#b_" + setting[1] + "_pass").val("");
        $("#b_" + setting[1] + "_btn").attr("class","hidden");
    }
    else
    {
        $("#b_" + setting[0] + "_pass").attr("class","hidden");
        $("#b_" + setting[0] + "_pass").val("");
        $("#b_" + setting[0] + "_btn").attr("class","hidden");
    }
}

$(function () 
{ //숨겨진 버튼 클릭시 발생하는 이벤트 - 게시글 삭제 수정
    $(".b_set").on("click", function() {
        var b_seq = $(this).data("b_seq");
        if ($(this).val() == "수정")
        {
            if ( confirm("수정하시겠습니까?") )
            {
        
                $.ajax({
                     url : "/board/check",
                     data : {
                        "b_seq" : b_seq,
                        "input_pass" :  $("#b_modify_pass").val()
                     },
                     type : "POST",
                }).done( function (data) 
                {
                   if (data == 1)
                   {
                        location.href = "/board/write/"+b_seq;
                   }
                   else
                   {
                        alert(data);
                   }
                });
            }
        }

        else //버튼값이 삭제라면
        {
            if ( confirm("삭제하시겠습니까?") )
            {
        
                $.ajax({
                        url : "/board/remove_act",
                        data : {
                        "b_seq" : b_seq,
                        "input_pass" :  $("#b_remove_pass").val()
                        },
                        type : "POST",
                }).done( function (data) 
                {
                    if (data == 1)
                    {
                        alert("삭제되었습니다.");
                        location.href = "/board";
                    }
                    else if (data == 0)
                    {
                        alert("비밀번호가 다릅니다.");
                        history.go(0);
                    }
                });
            }
        }
        
    });
});

function comment_confirm(set, c_seq)
{
    var arr = [];
    var setting = [];  // 세팅값에 따라 modi가 앞이면 modi부터 
    arr["modify"] = "btn-primary"; //버튼 색
    arr["remove"] = "btn-danger";

    if (set == "modify")
    {
        setting[0] = "modify";
        setting[1] = "remove";
    }
    else 
    {
        setting[0] = "remove";
        setting[1] = "modify";
    }

    if (setting[0] == "remove")
    {
        if ( $("#c_" + setting[0] + "_pass_" + c_seq).hasClass("hidden") )
        {
            $("#c_" + setting[0] + "_pass_" + c_seq).attr("class", "");
            $("#c_" + setting[0] + "_btn_" + c_seq).attr("class", "btn btn-danger test");
    
            $("#c_" + setting[1] + "_pass_" + c_seq).attr("class", "hidden");
            $("#c" + setting[1] + "_pass_" + c_seq).val("");
            $("#c_" + setting[1] + "_btn_" + c_seq).attr("class", "hidden");
            $("#c_" + setting[1] + "_body_" + c_seq).attr("class", "hidden");
        }
        else
        {  
            $("#c_" + setting[1] + "_body_" + c_seq).attr("class", "hidden");
            $("#c_" + setting[0] + "_pass_" + c_seq).attr("class", "hidden");
            $("#c_" + setting[0] + "_pass_" + c_seq).val("");
            $("#c_" + setting[0] + "_btn_" + c_seq).attr("class", "hidden");
        }
    }

    else //세팅 값이 수정일때
    {
        if ( $("#c_" + setting[0] + "_body_" + c_seq).hasClass("hidden") )
        {
            $("#c_" + setting[0] + "_body_" + c_seq).attr("class", "form-control my-3 mg-auto input_box");
            $("#c_" + setting[0] + "_pass_" + c_seq).attr("class", "form-control w-25  mg-auto input_box inline");
            $("#c_" + setting[0] + "_btn_" + c_seq).attr("class", "btn btn-primary test");
    
            $("#c_" + setting[1] + "_pass_" + c_seq).attr("class", "hidden");
            $("#c_" + setting[1] + "_btn_" + c_seq).attr("class", "hidden btn btn-danger");
        
        }
        else
        {
            $("#c_" + setting[0] + "_body_" + c_seq).attr("class", "hidden form-control my-3 mg-auto input_box");
            $("#c_" + setting[0] + "_pass_" + c_seq).attr("class", "hidden form-control w-25  mg-auto input_box inline");
            $("#c_" + setting[0] + "_btn_" + c_seq).attr("class", "hidden btn btn-primary");
            $("#c_" + setting[0] + "_pass_" + c_seq).val("");
    
        }
    }
}

$(function () 
{ //숨겨진 버튼 클릭시 발생하는 이벤트 - 게시글 삭제 수정
    $(".comment_change").on("click", function() {
        var c_seq = $(this).data("c_seq");
        
        if ($(this).val() == "삭제")
        {
            if ( confirm("삭제하시겠습니까?") )
            {
                $.ajax({
                     url : "/comment/remove_act",
                     data : {
                        "c_seq" : c_seq,
                        "input_pass" :  $("#c_remove_pass_" + c_seq).val()
                     },
                     type : "POST",
                }).done( function (data) 
                {
                    if (data == 1)
                    {
                        alert("삭제되었습니다.");
                        history.go(0);
                    }
                    else if (data == 0)
                    {
                        alert("비밀번호가 다릅니다.");
                        history.go(0);
                    }
                });
            }
        }

        else //버튼값이 수정
        {
            $.ajax({
                url : "/comment/update_act",
                data : {
                   "c_seq" : c_seq,
                   "input_pass" :  $("#c_modify_pass_" + c_seq).val(),
                   "body" : $("#c_modify_body_" + c_seq).val()
                },
                type : "POST",
           }).done( function (data) 
           {
               alert(data);
               history.go(0);
           });
        }   
    });
});


function reply_btn(c_seq, b_seq)
{

    if ( $('#reply_box_'+c_seq).length > 0 ) // id값이 존재하는지 
    {
        $('#reply_box_'+c_seq).remove();
    }

    else
    {
        var newForm = $('<form></form>');
        newForm.attr('method','post');
        newForm.attr('action','/comment/reply');
        newForm.attr('id','reply_box_'+c_seq);
        newForm.attr('class','reply_input');

        var test = ' \
            <div class="my-1">\
                <input type="text" required class="form-control w-25  mg-auto input_box inline" name="writer" placeholder="아이디를 입력해주세요.">\
                <input type="password" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">\
            </div>\
            <input type="submit" class="btn btn-success c_write" value="대댓글 쓰기">\
            <input type="hidden" name="c_seq" value="'+c_seq+'">\
            <input type="hidden" name="b_seq" value="'+b_seq+'">\
            <input type="hidden" name="list_seq" value="'+b_seq+'">\
            <input type="text" required class="form-control my-3 mg-auto input_box" name="body" placeholder="댓글을 입력해주세요">\
        ';
        newForm.append(test);
        
        $('.comment_' + c_seq).after(newForm);
    }
    
}
/* <form action="/comment/reply" id="reply_box_<?=$comment['c_seq']?>" class="hidden reply" method="post">    
<div class="my-1">
    <input type="text" required class="form-control w-25  mg-auto input_box inline" name="writer" placeholder="아이디를 입력해주세요.">
    <input type="password" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">
</div>
<input type="submit" class="btn btn-success c_write" value="대댓글 쓰기">
<input type="hidden" name="c_seq" value="<?=$comment['c_seq']?>">
<input type="hidden" name="b_seq" value="<?=$content['b_seq']?>">
<input type="hidden" name="list_seq" value="<?=$list_seq?>">
<input type="text" required class="form-control my-3 mg-auto input_box" name="body" placeholder="댓글을 입력해주세요">
</form> */
