
<!-- result[0]인 이유는 넘어올때 0번째 인덱스에 배열이 담겨져 넘어옴[연관배열] 즉 0번째 배열을 꺼내야함 아니 -->
<?
    $content = $result[0];
    $list_seq = $this->input->get("list_seq");
?>


<div class="container content_box">
    <h1 style="border-bottom: 3px solid blue;"><?=$content['subject']?></h1>

    <p class="content_top2">

        <span class="mr-30">작성자 : <?=$content['writer']?></span>
        <span class="mr-30">날짜 : <?=$content['date']?></span>
        <span class="mr-30">조회수 : <?=$content['visited']?></span>

        <button class="btn btn-primary" style="margin-right : 15px;">수정하기</button>
        <button class="btn btn-danger" onclick="remove_confirm()">삭제하기</button>
        <input type="password" id="remove_pass" class="hidden" name="" class="">
        <input type="button" id="remove_btn" class="hidden btn btn-danger" onclick="remove_board(<?=$content['b_seq']?>)" value="삭제">

    </p>

    <pre class="content_body"><?=$content['body']?></pre>

    <button class="btn btn-primary" onclick="go_list(<?=$list_seq?>)">목록으로</button>

</div>