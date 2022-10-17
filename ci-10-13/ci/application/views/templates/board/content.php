
<!-- result[0]인 이유는 넘어올때 0번째 인덱스에 배열이 담겨져 넘어옴[연관배열] 즉 0번째 배열을 꺼내야함 아니 -->
<?
    $content = $result[0];
    $list_seq = $_SESSION['list_seq'];
?>


<div class="container content_box" id="board" data-b_seq="<?=$content['b_seq']?>">
    <h1 style="border-bottom: 3px solid blue;"> <?=$content['subject']?> </h1>

    <p class="content_top2">
        

        <span class="mr-30">작성자 : <?=$content['writer']?></span>
        <span class="mr-30">날짜 : <?=$content['date']?></span>
        <span class="mr-30">조회수 : <?=$content['visited']?></span>
        <!--  퍼미션이 0인 게시글이거나 세션 로그인된 아이디와 같은 작성자인 게시글은 수정 삭제 표현  -->
        <? if ($content['permission'] == 0 || (isset($_SESSION['ID'])) && ($_SESSION['ID'] == $content['writer'])) {?> 
        
        <button class="btn btn-primary me-3 b_modify" >수정하기</button>
        <button class="btn btn-danger b_remove" >삭제하기</button>

        <? } ?>

    </p>

    <pre class="content_body"><?=$content['body']?></pre>
    <!-- 세션이 존재할 경우 -->
    <? if (isset ($_SESSION['search_for']) ) : ?> 
        <button class="btn btn-primary" onclick="go_list_search(<?=$list_seq?>)">목록으로</button>
    <? else : ?>
        <button class="btn btn-primary" onclick="go_list(<?=$list_seq?>)">목록으로</button>
    <? endif; ?>

</div>

<!-- 댓글 작성-->

<div class="container content_box" style="margin-top:-3px;">

        <form action="/comment/comment_write" method="post">    
            <p> <h3 style="border-bottom: 3px solid blue;">댓글 작성</h3> </p>

            <? if (!isset($_SESSION['ID'])) {?>
            <div class="my-1">
                <input type="text" required class="form-control w-25  mg-auto input_box inline" name="writer" placeholder="아이디를 입력해주세요.">
                <input type="password" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">
            </div>
            <?  } else {?>
                <p> <img src="/public/asset/person.png" width="25px" height="25px">  <?=$_SESSION['ID']?> </p>
                <input type="hidden" name="writer" value="<?=$_SESSION['ID']?>">
                <input type="hidden" name="permission" value="1">
            <?  }?>

            <input type="submit" class="btn btn-primary c_write" value="댓글 쓰기">
            <input type="hidden" name="b_seq" value="<?=$content['b_seq']?>">
            <input type="hidden" name="list_seq" value="<?=$list_seq?>">

            <input type="text" required class="form-control my-3 mg-auto input_box" name="body" placeholder="댓글을 입력해주세요">
        </form>
        
</div>

<!-- 댓글 목록 -->
<? foreach ($comments as $comment) : ?>
    <? if ($comment['c_depth'] != 0) { ?>
    <div class="container content_box reply" id="comment" data-c_seq="<?=$comment['c_seq']?>" style="margin-top:-3px; left: <?=($comment['c_depth'] - 1) * 20 + 13?>px; width: <?=70 - ($comment['c_depth'] * 2)?>% !important;">
    <? }  else {?>
    <div class="container content_box"  id="comment" data-c_seq="<?=$comment['c_seq']?>" style="margin-top:-3px;">
    <? } ?>
        <p id="c_modify_box_<?=$comment['c_seq']?>" style="border-bottom : 3px solid red;">
            <? if ($comment['permission']) { ?>
            <img src="/public/asset/person.png" width="25px" height="25px">
            <? } ?>
            <span id="comment_writer_<?=$comment['c_seq']?>"> <?=$comment["writer"]?> </span>
            
            
        </p>
        
        <span id="comment_body_<?=$comment['c_seq']?>"><?=$comment["body"]?></span>

        <div class="comment content_top2 comment_<?=$comment['c_seq']?>">
            <? if ($comment['baby'] == 0 || $comment['c_depth'] == 0) {?>
            <button class="btn btn-outline-success btn-sm" onclick="reply_btn(<?=$comment['c_seq']?>, <?=$content['b_seq']?>)">댓글달기</button>
            <? } ?>

            <? if ($comment['permission'] == 0 || ((isset($_SESSION['ID'])) && ($_SESSION['ID'] == $comment['writer']))) {?> 

            <button class="btn btn-outline-primary btn-sm c_modify" data-c_seq="<?=$comment['c_seq']?>">수정하기</button>
            <button class="btn btn-outline-danger remove btn-sm c_remove" data-c_seq="<?=$comment['c_seq']?>">삭제하기</button>

            <?  } ?>
            <span id="c_remove_box_<?=$comment['c_seq']?>"></span>
                     
        </div>  
<!-- 각종 컨펌들은 js에 구현되어있음.  -->
    </div>
    
<? endforeach; ?>