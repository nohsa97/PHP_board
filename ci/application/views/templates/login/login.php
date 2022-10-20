<div class="container text-center">
  <h1 class="sign-in"> 회원 로그인 </h1>
  <form action="/login/login_func" method="post" class="sign-in">
    <div class="form-floating">
      <input type="text" class="form-control" name="inputID" required placeholder="아이디">
      <label for="inputID">ID</label>
    </div>

    <div class="form-floating my-3">
      <input type="password" class="form-control" name="inputPass" required placeholder="비밀번호">
      <label for="inputPass">PASSWORD</label>
    </div>
    <input type="submit" class="btn btn-warning w-100" value="로그인">
    
    <input type="button" onclick="register_page()" class="btn btn-warning w-40 my-3" value="회원가입">
    
    <input type="button" class="btn btn-warning w-40 my-3" onclick="findPw_page()" value="ID/PW 찾기">
    <input type="button" id="no-login" onclick="no_login_page()" class="btn btn-warning w-100" value="비회원접속">
  </form>
</div>