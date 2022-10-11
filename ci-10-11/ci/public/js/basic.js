function check_ID()
{
    var base_url = "register_con/check";
    var input_val = $('input[name=input_ID]').val();

    if (input_val == "")
    {
        alert("아이디를 입력해주세요.");
        $('input[name=input_ID]').focus();
    }
    
    else
    {
        $.ajax({
            url : base_url,
            data : { 'input_ID' : input_val },
            type : "POST",
        }).done(
            function (data)
            {
                if (data == "이미 존재하는 ID입니다.")
                {
                    alert(data);
                    $('input[name=input_ID]').val("");
                    $('#register_submit').attr('disabled',true);
                    $('input[name=input_ID]').focus();
                }
                
                else 
                {
                    alert(data);
                    $('#register_submit').attr('disabled',false);
                }
            }
        );
    }
}


function go_login()
{
    location.href = "/login_con/loginpage";
}

function go_list(list_seq)
{
    location.href = "/board_con/"+list_seq;
}


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


    if ( $('#b_' + setting[0] + '_pass').hasClass("hidden") )
    {
        $('#b_' + setting[0] + '_pass').attr("class","");
        $('#b_' + setting[0] + '_btn').attr("class","test btn " + arr[set]);
        
        $('#b_' + setting[1] + '_pass').attr("class","hidden");
        $('#b_' + setting[1] + '_pass').val("");
        $('#b_' + setting[1] + '_btn').attr("class","hidden");
    }
    else
    {
        $('#b_' + setting[0] + '_pass').attr("class","hidden");
        $('#b_' + setting[0] + '_pass').val("");
        $('#b_' + setting[0] + '_btn').attr("class","hidden");
    }
}

$(function () 
{ //숨겨진 버튼 클릭시 발생하는 이벤트 - 게시글 삭제 수정
    $('.b_set').on("click", function() {
        var b_seq = $(".b_set").data('b_seq');
        if ($(this).val() == "수정")
        {
            if ( confirm("수정하시겠습니까?") )
            {
        
                $.ajax({
                     url : "/board_con/check",
                     data : {
                        'b_seq' : b_seq,
                        'input_pass' :  $('#b_modify_pass').val()
                     },
                     type : "POST",
                }).done( function (data) 
                {
                   if (data == 1)
                   {
                        location.href = "../write/"+b_seq;
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
                        url : "/board_con/remove_act",
                        data : {
                        'b_seq' : b_seq,
                        'input_pass' :  $('#b_remove_pass').val()
                        },
                        type : "POST",
                }).done( function (data) 
                {
                    if (data == 1)
                    {
                        alert("삭제되었습니다.");
                        location.href = "/board_con";
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
        if ( $('#c_' + setting[0] + '_pass_' + c_seq).hasClass("hidden") )
        {
            $('#c_' + setting[0] + '_pass_' + c_seq).attr("class", "");
            $('#c_' + setting[0] + '_btn_' + c_seq).attr("class", "btn btn-danger");
    
            $('#c_' + setting[1] + '_pass_' + c_seq).attr("class", "hidden");
            $('#c' + setting[1] + '_pass_' + c_seq).val("");
            $('#c_' + setting[1] + '_btn_' + c_seq).attr("class", "hidden");
            $('#c_' + setting[1] + '_body_' + c_seq).attr("class", "hidden");
        }
        else
        {  
            $('#c_' + setting[1] + '_body_' + c_seq).attr("class", "hidden");
            $('#c_' + setting[0] + '_pass_' + c_seq).attr("class", "hidden");
            $('#c_' + setting[0] + '_pass_' + c_seq).val("");
            $('#c_' + setting[0] + '_btn_' + c_seq).attr("class", "hidden");
        }
    }

    else //세팅 값이 수정일때
    {
        if ( $('#c_' + setting[0] + '_body_' + c_seq).hasClass("hidden") )
        {
            $('#c_' + setting[0] + '_body_' + c_seq).attr("class", "form-control my-3 mg-auto input_box");
            $('#c_' + setting[0] + '_pass_' + c_seq).attr("class", "form-control w-25  mg-auto input_box inline");
            $('#c_' + setting[0] + '_btn_' + c_seq).attr("class", "btn btn-primary");
    
            $('#c_' + setting[1] + '_pass_' + c_seq).attr("class", "hidden");
            $('#c_' + setting[1] + '_btn_' + c_seq).attr("class", "hidden btn btn-danger");
        
        }
        else
        {
            $('#c_' + setting[0] + '_body_' + c_seq).attr("class", "hidden form-control my-3 mg-auto input_box");
            $('#c_' + setting[0] + '_pass_' + c_seq).attr("class", "hidden form-control w-25  mg-auto input_box inline");
            $('#c_' + setting[0] + '_btn_' + c_seq).attr("class", "hidden btn btn-primary");
            $('#c_' + setting[0] + '_pass_' + c_seq).val("");
    
        }
    }
}




function remove_comment(c_seq)
{
    if ( confirm("삭제하시겠습니까?") )
    {
        $.ajax({
             url : "/comment_con/remove_act",
             data : {
                'c_seq' : c_seq,
                'input_pass' :  $('#c_remove_pass_' + c_seq).val()
             },
             type : "POST",
        }).done( function (data) 
        {
            if (data == 1)
            {
                alert("삭제되었씁니다.");
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


function modify_comment(c_seq)
{
    $.ajax({
        url : "/comment_con/update_act",
        data : {
           'c_seq' : c_seq,
           'input_pass' :  $('#c_modify_pass_' + c_seq).val(),
           'body' : $('#c_modify_body_' + c_seq).val()
        },
        type : "POST",
   }).done( function (data) 
   {
       alert(data);
       history.go(0);
   });
}


$(function () 
{ //숨겨진 버튼 클릭시 발생하는 이벤트 - 게시글 삭제 수정
    $('.test').on("click", function() {
        var c_seq = $(".test").data('c_seq');
        if ($(this).val() == "수정")
        {
            if ( confirm("수정하시겠습니까?") )
            {
        
                $.ajax({
                     url : "/board_con/check",
                     data : {
                        'c_seq' : c_seq,
                        'input_pass' :  $('#b_modify_pass').val()
                     },
                     type : "POST",
                }).done( function (data) 
                {
                  
                        alert(data);
                
                });
            }
        }

        else //버튼값이 삭제라면
        {
            if ( confirm("삭제하시겠습니까?") )
            {
        
                $.ajax({
                        url : "/board_con/remove_act",
                        data : {
                        'c_seq' : c_seq,
                        'input_pass' :  $('#b_remove_pass').val()
                        },
                        type : "POST",
                }).done( function (data) 
                {
                    
                });
            }
        }
        
    });
});