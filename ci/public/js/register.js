function check_ID()
{
  var base_url = "register/check_ID";
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
        if (data == "DB") // 3의 경우 db에 해당 아이디 존재.
        {
          alert("이미 존재하는 ID입니다.");
          $('#email_check').attr('disabled', true);
          $('input[name=input_ID]').focus();
          $('input[name=input_pass]').val('');
          $('input[name=input_pass]').attr('disabled',"true");
        }

        else if (data == "success")
        {
          alert("가입이 가능합니다.");
          $('input[name=input_pass]').removeAttr('disabled');
        }
        else if (data == "incongruity") //-1의경우 아이디 패턴에 적합하지 않음 영어 대소문자 숫자 제외 5~20자리의 문자
        {
          alert("적합하지 않은 아이디입니다.");
          $('input[name=input_ID]').val("");
          $('#email_check').attr('disabled', true);
          $('input[name=input_ID]').focus();
        }
        else 
        {
          alert(data);
        }
      }
    );
  }
}


function check_Email_js()
{
  let base_url = "register/check_email";
  const input_val = $('input[name=input_email]').val();

  if (input_val == "")
  {
    alert("이메일를 입력해주세요.");
    $('input[name=input_email]').focus();
  }

  else
  {
    $.ajax({
      url : base_url,
      data : { 'input_email' : input_val },
      type : "POST",
    }).done(
      function (data)
      {
        if (data == "DB") // 3의 경우 db에 해당 아이디 존재.
        {
          alert("이미 존재하는 이메일입니다.");
          $('input[name=input_email]').val("");
          $('#register_submit').attr('disabled', true);
          $('input[name=input_email]').focus();
        }
        else if (data == "success")
        {
          alert("가입이 가능합니다.");
          $('#register_submit').attr('disabled', false);
        }
        else if (data == "incongruity") //-1의경우 아이디 패턴에 적합하지 않음 영어 대소문자 숫자 제외 5~20자리의 문자
        {
          alert("적합하지 않은 이메일입니다.");
          $('input[name=input_email]').val("");
          $('#register_submit').attr('disabled', true);
          $('input[name=input_email]').focus();
        }
      }
    );
  }
}


$(function()
{
  $('input[name=input_pass]').on('change',function(){
    var check = $('input[name=input_pass]').val();
    var test = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/g;
    if (test.test(check))
    {
      $('.password_check').text("유효한 비밀번호입니다.");
      $('.password_check').attr("style","color : blue");
      $('#email_check').attr('disabled', false);
    }
    else
    {
      $('.password_check').text("최소 6자리이상 영문&특수문자(~,!,@,#,$,%) 포함");
      $('.password_check').attr("style","color : red");
      $('#email_check').attr('disabled', true);
    }
  })
});

$(function()
{
  $('input[name=input_pass_check').on('change',function(){
    var base = $('input[name=input_pass]').val();
    var check = $('input[name=input_pass_check').val();
    if (base == check)
    {
      $('.password_same').text("동일하게 입력하셨습니다.");
      $('.password_same').attr("style","color : blue");
      $('#submit').attr('disabled', false);
    }
    else
    {
      $('.password_same').text("새 비밀번호와 동일하게 입력해주세요.");
      $('.password_same').attr("style","color : red");
      $('#submit').attr('disabled', true);
    }
  })
});