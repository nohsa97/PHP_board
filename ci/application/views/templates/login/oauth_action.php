
<div class="container text-center">
  <form onsubmit="return send()" method="post" class="sign-in" enctype="application/x-www-form-urlencoded">
    <label for="user_id">이름</label>
    <input type="text" name="user_id" id="user_id"><br>

    <label for="access_token">access토큰</label>
    <input type="text" name="access_token" id="access_token"><br>

    <label for="refresh_token">refresh토큰</label>
    <input type="text" name="refresh_token" id="refresh_token"><br>

    <input type="hidden" name="user_seq_no" id="user_seq_no" value="">
    <input type="hidden" name="code" id="code" value="<?if (isset($_GET['code'])) echo $_GET['code'];?>"><br>
    
    <button id="authbtn">인증받기</button>
    <button id="token"> 토큰 받기</button>
    <input type="submit" id="register_submit"  class="btn btn-warning w-100" value="회원가입">
  </form>
</div>

<script src="/public/js/register.js"></script>

<script>
  function send()
  {
    if ($("#access_token") == "" || $("#refresh_token") == "" || $("#user_seq_no") == "")
    {
      alert("토큰부터 발급받아주세요");
      return false;
    }
    else 
    {
      $.ajax({
        url : "/oauth/save_data_func",
        type : "post",
        data : {
          "access_token" : $("#access_token").val(),
          "refresh_token" :  $("#refresh_token").val(),
          "user_seq_no" :  $("#user_seq_no").val()
        }
      }).done(function(data){
        if (data == 1)
        {
          alert("데이터 삽입 성공");
          location.href = "/login";
        }
        else
        {
          alert("데이터 삽입 실패");
        }
      })
    }
    return false;
  }

  $(function(){
    $('#token').on("click", function(){
    if ($("#code").val() == "")
    {
      alert ("인증부터");
      return false;
    }
    else 
    {
      $.ajax({
        url : "/oauth/get_access_token_func",
        type : "post",
        data : {
          "code" : $("#code").val()
        },
        success : function(data)
        {
          alert(data);
          var test = JSON.parse(data);

          if (test['rsp_code'] == "")
          {
            alert(test['rsp_code']);
            alert(test['rsp_message']);
            return false;
          }
          else
          {
            $("#access_token").val(test['access_token']);
            $("#refresh_token").val(test['refresh_token']);
            $("#user_seq_no").val(test['user_seq_no']);
          }

        }
      })
    }
    return false;
    })
  });

  $(function(){
    $('#authbtn').on("click", function(){
      $.ajax({
        url : "/oauth/get_authorization_code_func",
        success : function(data)
        {
          location.href = data;
        }
      })
    })
  });
</script>