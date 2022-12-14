<? 
$list = $page;
?>
<script>
function test(user_id)
{
  $.ajax({
    url : "/user/get_user_img_func",
    type : "post",
    data : { 'user' : user_id },
    success : function(data) {
      $('.profile_' + user_id).attr('src', data);
    }
  })
}
</script>

<table class="table table-hover table-bordered list">
  <tr style="background-color:aqua; --bs-table-accent-bg: none !important; ">
    <th class="w-10">번호</th>
    <th class="w-65">제목</th>
    <th class="w-10">작성자</th>
    <th class="w-10">날짜</th>
    <th class="w-5 ">조회수</th>
  </tr>

<? foreach ($lists as $list) :?>
  <? 
    $comment_count = "(".$list['comment_count'].")"; 
    $board_url = "/board/get_content_view?b_seq=".$list['b_seq']."&list=".$page."";
    if (isset($GLOBALS['search_input'])) 
    {
      $board_url .= "&search_by=".$GLOBALS['search_by']."&search_input=".$GLOBALS['search_input']."";
    }  
  ?> 
  <tr>
    <th><?=$MAX--?></th>
    <th>
      <a href="<?=$board_url;?>"> <?=$list['subject']?> <? if ($list['comment_count'] != 0) echo $comment_count; ?> </a>
    </th>
    <th>
      <? if ($list['permission'] == 1) : ?>
      <img src="/public/asset/user/person.png" onerror="this.onerror=null; this.src='/public/asset/user/person.png'" class="profile_<?=$list['writer']?>" data-ts="<?=$list['writer']?>"  alt="" width="25" height="25">
      <script>test('<?=$list['writer']?>')</script>
      <? endif; ?>
      <?=$list['writer']?>
    </th>
    <th><?=date("y-m-d", strtotime($list['date']))?></th>
    <th><?=$list['visited']?></th>
  <tr>
<? endforeach; ?>
</table>

<form action="/board" method="get" class="text-center" >
  <select class="form-select search-select" name="search_by">

  <? if (isset($GLOBALS['search_by']) && $GLOBALS['search_by'] == "writer") {?>
    <option selected value="writer">작성자</option>
    <option value="subject">제목</option>
  <? } else if (isset($GLOBALS['search_by']) && $GLOBALS['search_by'] == "subject") {?>
    <option value="writer">작성자</option>
    <option selected value="subject">제목</option>
  <? } if (!isset($GLOBALS['search_by'])) {?>
    <option value="writer">작성자</option>
    <option value="subject">제목</option>
  <? } ?>
  
  </select>

  <input type="text" required class="form-control w-15  mg-auto inline" style="padding:0.5rem" name="search_input" value="<?if (isset($GLOBALS['search_input'])) echo $GLOBALS['search_input'];?>" placeholder="검색">
  <input type="submit" class="btn btn-info" style="height: 2.5rem; margin-bottom: 4px;" value="검색">
</form>

<p><?=$links?></p>

<div class="align-items-end justify-content-end d-flex">
  <a href="/board/write_page/0"><button class="btn btn-primary mr-80">글 작성</button></a>
</div>

