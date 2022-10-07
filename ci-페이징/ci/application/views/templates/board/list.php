<table class="table table-hover table-bordered list">
    <tr style="background-color:aqua; --bs-table-accent-bg: none !important; ">
        <th class="w-10" >번호</th>
        <th class="w-65">제목</th>
        <th class="w-10">작성자</th>
        <th class="w-10">날짜</th>
        <th class="w-5">조회수</th>
    </tr>

    <?
        $list_seq = $page;
    ?>
<!-- th2번째 1씩 줄어드는건 다음걸로 넘어가야하니까 줄어듬. -->
<? foreach($lists as $list) :?>
    <tr> 
        <th><?=$list['b_seq']?></th> 
        <th><a href="/board_con/content/<?=$list['b_seq']--?>?list_seq=<?=$list_seq?>"> <?=$list['subject']?> </a></th>  
        <th><?=$list['writer']?></th>
        <th><?=$list['date']?></th>
        <th><?=$list['visited']?></th>
    <tr>
<? endforeach; ?>

</table>

<p><?=$links?></p>
<div class="float-end">
    <a href="/board_con/write"><button class="btn btn-primary mr-80">글 작성</button></a>
</div>

