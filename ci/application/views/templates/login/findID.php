<div class="container text-center mt-sm-4">
  <button class="btn btn-warning btn-lg align-center" onclick="findID()" style="margin-right : 20px;">아이디찾기</button>
  <button class="btn btn-warning btn-lg align-center" onclick="findPW()">비밀번호 찾기</button>
</div>

<div class="container text-center">
  <form onsubmit="return findUser_ID();" id="find_form" method="post" class="sign-in">
    <div class="form-floating" style="margin-top: 10px;">
      <input type="search"  class="form-control" autocomplete="off"  name="input_name"  placeholder="이름">
      <label for="input_name">NAME</label>
    </div>
    <div class="form-floating my-2">
      <input type="email" class="form-control" autocomplete="off" name="input_email"  placeholder="이메일">
      <label for="input_email">EMAIL</label>
    </div>
    <p id="warning" style="color:red;"></p>
    <input type="submit" id="submit"  class="btn btn-warning w-100" value="아이디 찾기">
  </form>
</div>
<script src="/public/js/findUser.js"></script>