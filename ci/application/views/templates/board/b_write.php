<div class="container my-3">
  <form method="post" onsubmit="return write_board();" enctype="multipart/form-data">
    <h1 style="border-bottom : 3px solid black">게시글 작성</h1>
    <input type="text"  class="form-control my-3 mg-auto input_box" name="subject" id="" placeholder="제목을 입력해주세요">
    <!-- 로그인 시  -->
    <? if (isset($_SESSION['ID'])) {?>

    <div class="my-1">
      <input type="hidden" name="input_ID" value="<?=$_SESSION['ID']?>">
      <input type="hidden" name="permission" value="1">
    </div>

    <? } else  {?>

    <div class="my-1">
      <input type="text"  class="form-control w-25  mg-auto input_box inline" name="input_ID"  placeholder="아이디">
      <input type="password"  class="form-control w-25  mg-auto input_box inline" name="input_pass" placeholder="비밀번호">
      <input type="hidden" name="permission" value="0">
    </div>

    <? } ?>
    <input type="file" name="file" accept="image/png, image/jpeg" id="imgSelector" onchange="setImageFromFile(event);">


    <textarea name="body"  id="body" cols="30" rows="10" style="width: 100%;" class="w-100 my-3 h-50"></textarea>
    <h3>업로드된 파일</h3>
    <div id="thumbnail" class="thumbnail-box"></div>

    <input type="submit" class="btn btn-primary" style="float:right;" value="게시글 작성">
  </form>
</div>

<script src="/public/js/board.js"></script>

<script>
  $('#imgSelector').change(function(){
    setImageFromFile(this, '#thumbnail');
});

function setImageFromFile(input, expression) {
    if (input.files && input.files[0]) {
      var box = $('<div></div>');
      var text = $('<span></span>');
      var file_name = input.files[0]['name'];
      text.text(file_name);
      var thumb = $('<img>');
      var reader = new FileReader();
      reader.onload = function (e) {
        $(thumb).attr('src', e.target.result);
        $(thumb).attr('class', "thumbnail");
        $(box).append(thumb);
        $(box).append(text);
        $(expression).append(box);
        // $(expression).append(thumb);
        // $(expression).append(file_name);
      }
      reader.readAsDataURL(input.files[0]);
      console.log(input.files);
      console.log(file_name);
    }
}
</script>