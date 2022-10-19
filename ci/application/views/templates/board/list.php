<?
$list = $page;
?>

<table class="table table-hover table-bordered list">
  <tr style="background-color:aqua; --bs-table-accent-bg: none !important; ">
    <th class="w-10" >번호</th>
    <th class="w-65">제목</th>
    <th class="w-10">작성자</th>
    <th class="w-10">날짜</th>
    <th class="w-5">조회수</th>
  </tr>

  <!-- th2번째 1씩 줄어드는건 다음걸로 넘어가야하니까 줄어듬. -->
    <? foreach ($lists as $list) :?>
      <? $comment_count = "(".$list['comment_count'].")"; ?> 
      <tr>
        <th><?=$MAX--?></th>
        <th>
          <? if (isset($search)) { ?>
          <a href="/board/get_content?b_seq=<?=$list['b_seq']--?>&list=<?=$page?>&search_by=<?=$search['search_by']?>&search_input=<?=$search['search_input']?>"> <? if ($list['comment_count'] != 0) echo $comment_count; ?>  <?=$list['subject']?>  </a>
          <? } else {?>
          <a href="/board/get_content?b_seq=<?=$list['b_seq']--?>&list=<?=$page?>"> <?=$list['subject']?> <? if ($list['comment_count'] != 0) echo $comment_count; ?> </a>
          <? } ?>
        </th>
        <th>
          <? if ($list['permission'] == 1) : ?>
          <img src="/public/asset/person.png" width="25px" height="25px">
          <? endif; ?>
          <?=$list['writer']?>
        </th>
        <th><?=$list['date']?></th>
        <th><?=$list['visited']?></th>
      <tr>
    <? endforeach; ?>
</table>

<!-- 찾는 값이 존재한다면 board search 함수에서 넘겨주는 변수 -->
<?    if (isset($search)) :  ?>

<form action="/board/search" method="get" class="text-center" >
  <select class="form-select search-select" name="search_by">
  <? if ($search['search_by'] == "writer") {?>
    <option selected value="writer">작성자</option>
    <option value="subject">제목</option>
    <? } else {?>
    <option value="writer">작성자</option>
    <option selected value="subject">제목</option>
  <? }?>
  </select>

  <input type="text" required class="form-control w-15  mg-auto inline" style="padding:0.5rem" name="search_input" value="<?=$search['search_input']?>">
  <input type="submit" class="btn btn-info" style="height: 2.5rem; margin-bottom: 4px;" value="검색">
</form>

<!-- 존재하지 않는다 = 기본페이지 -->
<? else : ?>

<form action="/board/search" method="get" class="text-center" >
  <select class="form-select search-select" name="search_by">
    <option value="writer">작성자</option>
    <option value="subject">제목</option>
  </select>

  <input type="text" required class="form-control w-15  mg-auto inline" style="padding:0.5rem" name="search_input" placeholder="검색">
  <input type="submit" class="btn btn-info" style="height: 2.5rem; margin-bottom: 4px;" value="검색">
</form>

<? endif; ?>

<p><?=$links?></p>

<div class="align-items-end justify-content-end d-flex">
  <a href="/board/write_page/0"><button class="btn btn-primary mr-80">글 작성</button></a>
</div>