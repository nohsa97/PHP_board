<div class="container text-center mt-sm-4">
  <button class="btn btn-warning btn-lg align-center" id="reset" style="margin-right : 20px;">아이디찾기</button>
  <button class="btn btn-warning btn-lg align-center" onclick="changePage()">비밀번호 찾기</button>
</div>


<div class="container text-center">

  <form action="/login/find_ID" id="find_form" method="post" class="sign-in">
    <div class="form-floating" style="margin-top: 10px;">
      <input type="text"  class="form-control"  name="input_name" required placeholder="이름">
      <label for="input_name">NAME</label>
    </div>
    <div class="form-floating my-2">
      <input type="email" class="form-control" name="input_email" required placeholder="이메일">
      <label for="input_email">EMAIL</label>
    </div>
    <input type="submit" id="submit"  class="btn btn-warning w-100" value="아이디 찾기">
  </form>
    
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
  var test2 = true;
  function changePage()
{
    if (test2 == true)
    {
      test2 = false;
      var test = '<div class="form-floating">\
                    <input type="text"  class="form-control" name="input_ID" required placeholder="아이디">\
                    <label for="input_name">ID</label>\
                  </div>\
      ';
      $("#find_form").prepend(test);
      $("#submit").val("비밀번호 변경");
    }
  }
  $(function()
  {
    $("#reset").on("click",function () {
        history.go(0);
    })
  });
</script>