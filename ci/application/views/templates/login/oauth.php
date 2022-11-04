<div class="container text-center">
  <form action="/oauth/get_authorization_code_func"  class="sign-in">
    <label for="response_type">응답 타입</label>
    <input type="text" name="response_type" id="response_type"><br>
    <label for="client_id">클라 아이디</label>
    <input type="text" name="client_id" id="client_id"><br>
    <label for="redirect_uri">리다이렉트</label>
    <input type="text" name="redirect_uri" id="redirect_uri"><br>
    <label for="scope">스코프</label>
    <input type="text" name="scope" id="scope"><br>
    <label for="state">무작위</label>
    <input type="text" name="state" id="state"><br>
    <label for="auth_type">가입타입</label>
    <input type="text" name="auth_type" id="auth_type"><br>
    
    <button id="authbtn">인증받기</button>
    <input type="submit" id="register_submit"  class="btn btn-warning w-100" value="회원가입">
  </form>
</div>

<script src="/public/js/register.js"></script>

<script>
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
  })
</script>