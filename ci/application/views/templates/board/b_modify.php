<div class="container my-3">
  <form onsubmit="return modify_board();" method="post">
    <h1 style="border-bottom : 3px solid black">게시글 수정</h1>

    <input type="text"  class="form-control my-3 mg-auto input_box" name="subject" value="<?=$subject?>">
    <input type="hidden" name="b_seq" value="<?=$b_seq?>">
    <!-- 회원 로그인 상태. 세션으로 안한 이유는 게시글 퍼미션 따라서 해야하기 때문.  -->
    <? if ($permission == 1) {?> 
    <div class="my-1">
      <input type="hidden" name="input_ID" value="<?=$_SESSION['ID']?>">
      <input type="hidden" name="permission" value="1"> 
    </div>

    <? } else  {?>

    <div class="my-1">
      <input type="text"  class="form-control w-25  mg-auto input_box inline" name="input_ID"  value="<?=$writer?>">
      <input type="password"  class="form-control w-25  mg-auto input_box inline" name="input_pass" placeholder="비밀번호">
      <input type="hidden" name="permission" value="0">
    </div>

    <? } ?>

    <textarea name="body" cols="30" rows="10" class="w-100 my-3 h-50"><?=$body?></textarea>
    <input type="submit" class="btn btn-primary" style="float:right;" value="게시글 수정">
  </form>
</div>

<script src="/public/js/board.js"></script>
<script>
	function test()
	{
		if ($('input[name=CorpNum]').val()== "")
		{
			alert("입력하십쇼");
			return false;
		}
		else
		{
			$.ajax({
				url : "https://newapi.ucert.co.kr/barobill_new/get_corp_state_search",
				type : "post",
				dataType : 'json',
				contentType : 'application/json',
				data : {
					'CorpNum' : $('input[name=CorpNum]').val()
				},
				success : function(data){
						alert("성공");
						alert(data);
					}
			});
		}
	}

</script>