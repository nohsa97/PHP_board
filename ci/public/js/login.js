$(function()
{
  const login_box = $('#login_box');
  const input_ID = $('input[name=input_ID');
  const input_Pass = $('input[name=input_Pass');
  $(login_box).on("submit",function(event)
  {
    if (input_ID.val() == "")
    {
      event.preventDefault();
      $('#warning').text("아이디를 입력해주세요.");
      input_ID.focus();
    }
    else if (input_Pass.val() == "")
    {
      event.preventDefault();
      $('#warning').text("비밀번호를 입력해주세요.");
      input_Pass.focus();
    }
    else
    {
      $.ajax({
        url  : "/login/login_func",
        type : "post",
        data : {"inputID" : input_ID.val(), "inputPass" : input_Pass.val()}
      }).done(function(data){
        if (data == "success")
        {
          alert("환영합니다.");
          location.href = "/board";
        }
        else
        {
          alert("올바른 정보를 입력해주세요.");
          $('#warning').text("올바른 정보를 입력해주세요.");
        }
      })
    }
    return false;
  });
});

