<div class="container my-3">
  <form action="/board/write_action_func" method="post" enctype="multipart/form-data">
    <h1 style="border-bottom : 3px solid black">게시글 작성</h1>
    <input type="text" required class="form-control my-3 mg-auto input_box" name="subject" id="" placeholder="제목을 입력해주세요">
    <!-- <input type="file" onchange="test(this)" name="board_image" accept="image/jpeg, image/png"> -->
    <!-- 로그인 시  -->
    <? if (isset($_SESSION['ID'])) {?>

    <div class="my-1">
      <input type="hidden" name="input_ID" value="<?=$_SESSION['ID']?>">
      <input type="hidden" name="permission" value="1">
    </div>

    <? } else  {?>

    <div class="my-1">
      <input type="text" required class="form-control w-25  mg-auto input_box inline" name="input_ID"  placeholder="아이디">
      <input type="password" required class="form-control w-25  mg-auto input_box inline" name="input_pass" placeholder="비밀번호">
      <input type="hidden" name="permission" value="0">
    </div>

    <? } ?>
    <input type="file" name="file" id="file">

    <textarea name="body" required id="body" cols="30" rows="10" style="width: 100%;" class="w-100 my-3 h-50"></textarea>

    <input type="submit" class="btn btn-primary" style="float:right;" value="게시글 작성">
  </form>
</div>
