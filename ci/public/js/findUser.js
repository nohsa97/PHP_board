let space_pattern = /\s/g; //공백 테스트
let mail_pattern  = /^[a-zA-Z0-9+-\_.]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/; 


function findUser_ID() //required를 제거했을 경우
{
  if ($('input[name=input_name]').val() == "" || space_pattern.test($('input[name=input_name]').val()))
  {
    alert('이름을 확인해주세요.');
    $('input[name=input_name]').focus();
    $('#warning').text('이름을 입력해주세요(공백 없이)');
    return false;
  }
  else if (!mail_pattern.test($('input[name=input_email').val()))
  {
    alert('이메일을 확인해주세요.');
    $('input[name=input_email]').focus();
    $('#warning').text('유효한 이메일을 입력해주세요.');
    return false;
  }
  else
  {
    $.ajax({
      url : "/login/find_User",
      type : "post",
      data : {
        'input_name' : $('input[name=input_name]').val(),
        'input_email' : $('input[name=input_email]').val()
      },
      success : function(response)
      {
        if (response != "")
        {
          alert("회원님의 아이디는 "+ response +"입니다.");
          location.href = "/login";
        }
        else if (response == "")
        {
          alert("일치하는 정보가 없습니다.");
          history.go(0);
        }
      }
    })
    return false;
  }
}

function findUser_Pass()
{
  if ($('input[name=input_ID').val() == "")
  {
    alert('아이디 확인해주세요.');
    $('input[name=input_ID]').focus();
    $('#warning').text('아이디 입력해주세요(공백 없이)');
    return false;
  }
  else if ($('input[name=input_name]').val() == "" || space_pattern.test($('input[name=input_name]').val()))
  {
    alert('이름을 확인해주세요.');
    $('input[name=input_name]').focus();
    $('#warning').text('이름을 입력해주세요(공백 없이)');
    return false;
  }
  else if (!mail_pattern.test($('input[name=input_email').val()))
  {
    alert('이메일을 확인해주세요.');
    $('input[name=input_email]').focus();
    $('#warning').text('유효한 이메일을 입력해주세요.');
    return false;
  }
  else
  {
    $.ajax({
      url : "/login/find_User",
      type : "post",
      data : {
        'input_name' : $('input[name=input_name]').val(),
        'input_email' : $('input[name=input_email]').val(),
        'input_ID' : $('input[name=input_ID]').val()
      },
      success : function(response)
      {
       if(response != "")
       {
        location.href = "/login/newPW";
       }
       else if (response == "")
       {
        alert("일치하는 정보가 없습니다.");
        history.go(0);
       }
      }
    })
    return false;
  }
}