<div class="container my-3">
  <form action="/board/write_action_func" method="post">
    <h1 style="border-bottom : 3px solid black">게시글 수정</h1>

    <input type="text" required class="form-control my-3 mg-auto input_box" name="subject" id="" value="<?=$subject?>">
    <input type="hidden" name="b_seq" value="<?=$b_seq?>">
    <!-- 회원 로그인 상태. 세션으로 안한 이유는 게시글 퍼미션 따라서 해야하기 때문.  -->
    <? if ($permission == 1) {?> 

    <div class="my-1">
      <input type="hidden" name="input_ID" value="<?=$_SESSION['ID']?>">
      <input type="hidden" name="permission" value="1"> 
    </div>

    <? } else  {?>

    <div class="my-1">
      <input type="text" required class="form-control w-25  mg-auto input_box inline" name="input_ID"  value="<?=$writer?>">
      <input type="password" required class="form-control w-25  mg-auto input_box inline" name="input_pass" placeholder="비밀번호">
      <input type="hidden" name="permission" value="0">
    </div>

    <? } ?>

    <textarea name="body" required id="" cols="30" rows="10" class="w-100 my-3 h-50"><?=$body?></textarea>

    <input type="submit" class="btn btn-primary" style="float:right;" value="게시글 수정">
  </form>
</div>