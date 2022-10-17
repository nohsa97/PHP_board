<h3 class="text-center mt-sm-4"><?=$ID?> 비밀번호 변경</h3>

<form action="/login/newPW_func" id="find_form" method="post" class="sign-in">

    <div class="form-floating" style="margin-top: 10px;">
        <input type="password"  class="form-control"  name="before_PW" required placeholder=".">
        <label for="input_name">이전 비밀번호</label>
    </div>

    <div class="form-floating my-2">
        <input type="password" class="form-control" name="after_PW" required placeholder=".">
        <label for="input_email">바꿀 비밀번호</label>
    </div>
    <input type="hidden" name="ID" value="<?=$ID?>">

    <input type="submit" id="submit"  class="btn btn-warning w-100" value="아이디 찾기">

</form>