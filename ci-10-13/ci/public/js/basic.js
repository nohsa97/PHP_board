function check_ID()
{
    var base_url = "register/check";
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
    location.href = "/login/loginpage";
}

function go_list(list_seq)
{
    location.href = "/board/"+list_seq;
}


function go_list_search(list_seq)
{
    location.href = "/board/search/"+list_seq;
}