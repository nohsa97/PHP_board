<div class="container text-center">
  <form action="register/register_ID" method="post" class="sign-in">
    <div class="form-floating id-box">
      <input type="text" class="form-control" name="input_ID" required placeholder="아이디">
      <label for="input_ID">ID</label>  
    </div>
    
    <input class="btn btn-warning" style="margin-top: 10px;" type="button" onclick="check_ID()" value="ID 중복확인">

    <div class="form-floating my-2">
      <input type="password" style="margin-top: 17px;" class="form-control" name="input_pass" disabled required placeholder="비밀번호">
      <label for="input_pass">PASSWORD</label>
    </div>
    <div class="password_check">최소 6자리이상 영문&숫자&특수문자 포함 </div>

    <div class="form-floating">
      <input type="text"  class="form-control" name="input_name" required placeholder="이름">
      <label for="input_name">NAME</label>
    </div>

    <div class="form-floating my-2">
      <input type="email" class="form-control" name="input_email" required placeholder="이메일">
      <label for="input_email">EMAIL</label>
      <input type="button" disabled="true" id="email_check" onclick="check_Email_js()"  class="btn btn-warning w-100" value="이메일 중복확인">    
    </div>
    
    <input type="submit" disabled="true" id="register_submit"  class="btn btn-warning w-100" value="회원가입">
  </form>
</div>

<script src="/public/js/register.js"></script>