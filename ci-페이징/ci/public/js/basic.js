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
                // alert(data);
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


function remove_confirm()
{
    if ( $('#remove_pass').hasClass("hidden") )
    {
        $('#remove_pass').attr("class","");
        $('#remove_btn').attr("class","btn btn-danger");
    }
    else
    {
        $('#remove_pass').attr("class","hidden");
        $('#remove_pass').val("");
        $('#remove_btn').attr("class","hidden");
    }
}

function remove_board(b_seq)
{
    if ( confirm("삭제하시겠습니까?") )
    {

        $.ajax({
             url : "/board_con/remove_act",
             data : {
                'b_seq' : b_seq,
                'input_pass' :  $('#remove_pass').val()
             },
             type : "POST",
        }).done( function (data) 
        {
            if (data == 1)
            {
                alert("삭제되었씁니다.");
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