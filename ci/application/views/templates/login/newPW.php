<h3 class="text-center mt-sm-4"><?=$ID?>회원님 비밀번호 변경</h3>

<form action="/login/newPW_func" id="find_form" method="post" class="sign-in">

  <div class="form-floating my-2">
    <input type="password" style="margin-top: 17px;" class="form-control" name="input_pass" required placeholder="비밀번호">
    <label for="input_pass">새 비밀번호</label>
  </div>
  <div class="password_check">최소 6자리이상 영문&숫자&특수문자 포함 </div>

  <div class="form-floating my-2">
    <input type="password" style="margin-top: 17px;" class="form-control" name="input_pass_check" required placeholder="비밀번호">
    <label for="input_pass_check">비밀번호 확인</label>
  </div>

  <div class="password_same" style="color:red;">비밀번호를 다시 입력해주세요.</div>
  <input type="hidden" name="ID" value="<?=$ID?>">
  <input type="submit" id="submit" disabled=""  class="btn btn-warning w-100" value="비밀번호 변경">

</form>

<script src="/public/js/register.js"></script>