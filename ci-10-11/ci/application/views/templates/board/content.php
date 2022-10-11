
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

        <button class="btn btn-primary" onclick="board_confirm('modify')" style="margin-right : 15px;">수정하기</button>
        <input type="password" id="b_modify_pass" class="hidden" name="" class="" style="margin-left : -15px;">
        <input type="button" id="b_modify_btn" data-b_seq="<?=$content['b_seq']?>" class="hidden b_set" value="수정">
    
        <button class="btn btn-danger" onclick="board_confirm('remove')">삭제하기</button>
        <input type="password" id="b_remove_pass" class="hidden" name="" class="">
        <input type="button" id="b_remove_btn" data-b_seq="<?=$content['b_seq']?>" class="hidden b_set" value="삭제">

        

    </p>

    <pre class="content_body"><?=$content['body']?></pre>

    <button class="btn btn-primary" onclick="go_list(<?=$list_seq?>)">목록으로</button>

</div>

<!-- 댓글 -->

<div class="container content_box" style="margin-top:-3px;">

        <form action="/comment_con/comment_write" method="post">    
            <p> <h3 style="border-bottom: 3px solid blue;">댓글 작성</h3> </p>
            <div class="my-1">
                <input type="text" required class="form-control w-25  mg-auto input_box inline" name="writer" id="" placeholder="아이디를 입력해주세요.">
                <input type="password" required class="form-control w-25  mg-auto input_box inline" name="password" id="" placeholder="비밀번호를 입력해주세요.">
            </div>

            <input type="submit" class="btn btn-primary c_write" value="댓글 쓰기">
            <input type="hidden" name="b_seq" value="<?=$content['b_seq']?>">
            <input type="hidden" name="list_seq" value="<?=$list_seq?>">

            <input type="text" required class="form-control my-3 mg-auto input_box" name="body" id="" placeholder="댓글을 입력해주세요">
        </form>
        
</div>

<? foreach ($comments as $comment) : ?>
    <div class="container content_box" style="margin-top:-3px;">
        <p>
            <img src="/public/asset/person.png" alt="" width="25px" height="25px">
            <span id="comment_writer_<?=$comment['c_seq']?>"> <?=$comment["writer"]?> </span>
            <input type="password" required class="hidden form-control w-25  mg-auto input_box inline" name="password" id="c_modify_pass_<?=$comment['c_seq']?>" placeholder="비밀번호를 입력해주세요.">
            <input type="button" id="c_modify_btn_<?=$comment['c_seq']?>" data-c_seq="<?=$comment['c_seq']?>" class="hidden btn btn-primary test" onclick="modify_comment(<?=$comment['c_seq']?>)" value="수정">
        </p>
        
        <span id="comment_body_<?=$comment['c_seq']?>"><?=$comment["body"]?></span>
        <input type="text" required class="hidden form-control my-3 mg-auto input_box" name="body" id="c_modify_body_<?=$comment['c_seq']?>" value="<?=$comment['body']?>">

        <div class="comment content_top2">
            <button class="btn btn-primary" onclick="comment_confirm('modify', <?=$comment['c_seq']?>)">수정하기</button>
            <button class="btn btn-danger remove" onclick="comment_confirm('remove', <?=$comment['c_seq']?>)">삭제하기</button>
            <input type="password" id="c_remove_pass_<?=$comment['c_seq']?>" class="hidden">
            <input type="button" id="c_remove_btn_<?=$comment['c_seq']?>" onclick="remove_comment(<?=$comment['c_seq']?>)" data-c_seq="<?=$comment['c_seq']?>"  class="hidden btn btn-danger test" value="삭제">     
        </div> 
    </div>
<? endforeach; ?>