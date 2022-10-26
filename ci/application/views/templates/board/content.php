<?
  $list = $_GET['list'];
  function img($user)
  {
    echo '<img src="/public/asset/user/'.$user.'.jpg"  onerror="this.onerror=null; this.src="/public/asset/user/person.png" " width="25px" height="25px">';  
  }  
?>

<div class="container content_box" id="board" data-permission="<?=$content['permission']?>" data-b_seq="<?=$content['b_seq']?>">
  <h1 style="border-bottom: 3px solid blue;"> <?=$content['subject']?> </h1>

  <p class="content_top2">
    <span class="mr-30">작성자 : <? if ($content['permission'] == 1) img($content['writer']);?> <?=$content['writer']?> </span>
    <span class="mr-30">날짜 :   <?=$content['date']?></span>
    <span class="mr-30">조회수 : <?=$content['visited']?></span>


    <!--  퍼미션이 0인 게시글이거나 세션 로그인된 아이디와 같은 작성자인 게시글은 수정 삭제 표현  -->
    <? if ($content['permission'] == 0 || (isset($_SESSION['ID'])) && ($_SESSION['ID'] == $content['writer'])) {?> 
    <button class="btn btn-primary me-3 b_modify" >수정하기</button>
    <button class="btn btn-danger b_remove" >삭제하기</button>
    <? } ?>
  </p>

  <pre class="content_body">
    <?=$content['body']?>

    <? if (isset($content['upload_file'])) { ?>
    <img src=".<?=$content['upload_file']?>">
    <? } ?>
  </pre>
  <? if (isset($GLOBALS['search_input'])) {?>
  <button class="btn btn-primary" onclick="go_list_search(<?=$list?>, '<?=$GLOBALS['search_by']?>', '<?=$GLOBALS['search_input']?>')">목록으로</button>
  <? } else {?>
  <button class="btn btn-primary" onclick="go_list(<?=$list?>)">목록으로</button>
  <? } ?>

  <? if (isset($content['upload_file'])) { ?>
  <? $file_name = substr( $content['upload_file'], 21) ?>
  <p class="text-end">업로드된 파일 : <a href=".<?=$content['upload_file']?>" download="<?=$file_name?>"><span class="material-symbols-outlined" >file_download</span><?=$file_name?></a></p>
  <? } ?>


  <? if ($count != 0) :?>
  <span class="float-end">댓글 수 : (<?=$count?>개)</span>
  <? endif;?>
</div>

<!-- 댓글 작성-->

<div class="container content_box" style="margin-top:-3px;">

  <!-- <form action="/comment/comment_write" method="post">     -->
  <form method="post" onsubmit="return checkBox(<?=$content['b_seq']?>);" id="comment_insert">    
    <p> <h3 style="border-bottom: 3px solid blue;">댓글 작성</h3> </p>

    <? if (!isset($_SESSION['ID'])) {?>
    <div class="my-1">
      <input type="text" id="logout_writer" class="form-control w-25  mg-auto input_box inline" name="writer" placeholder="아이디를 입력해주세요.">
      <input type="password"id="logout_password" class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">
    </div>
    <?  } else {?>
      <p> <?=img($_SESSION['ID'])?> <b> <?=$_SESSION['ID']?> </b> </p>
      <input type="hidden" id="comment_writer" name="writer" value="<?=$_SESSION['ID']?>">
      <input type="hidden" name="permission" value="1">
    <?  }?>

      <input type="submit" class="btn btn-primary c_write" value="댓글 쓰기">
      <input type="hidden" name="b_seq" value="<?=$content['b_seq']?>">
      <input type="hidden" name="list" value="<?=$list?>">

      <input type="text" id="comment_input" class="form-control my-3 mg-auto input_box" name="body" placeholder="댓글을 입력해주세요">
  </form>

</div>

<!-- 댓글 목록 -->
<? foreach ($comments as $comment) : ?>
  <? if ($comment['c_depth'] != 0) { ?>
  <div class="container content_box reply" style="margin-top:-3px; left: <?=($comment['c_depth'] - 1) * 20 + 13?>px; width: <?=70 - ($comment['c_depth'] * 2)?>% !important;">
  <? }  else {?>
  <div class="container content_box" style="margin-top:-3px;">
  <? } ?>

    <p id="c_writer_<?=$comment['c_seq']?>" style="border-bottom : 3px solid red;">

      <? if ($comment['permission']) { ?>
      <?=img($comment['writer'])?>
      <? } ?>
      <b id="comment_writer_<?=$comment['c_seq']?>"><?=$comment["writer"]?></b>
    </p>

    <span id="comment_body_<?=$comment['c_seq']?>"><?=$comment["body"]?></span>
    <div class="comment content_top2 comment_<?=$comment['c_seq']?>" data-c_seq="<?=$comment['c_seq']?>" data-permission="<?=$comment['permission']?>">
      <? if ($comment['baby'] == 0 || $comment['c_depth'] == 0) {?>
      <button class="btn btn-outline-success btn-sm" onclick="reply_btn(<?=$comment['c_seq']?>, <?=$content['b_seq']?>, <?=(isset($_SESSION['ID']) ? 1 : 0 )?>)">댓글달기</button>
      <? } ?>

      <? if ($comment['permission'] == 0 || ((isset($_SESSION['ID'])) && ($_SESSION['ID'] == $comment['writer']))) {?> 
      <button class="btn btn-outline-primary btn-sm c_modify">수정하기</button>
      <button class="btn btn-outline-danger remove btn-sm c_remove">삭제하기</button>
      <?  } ?>
    </div>  
    <!-- 각종 컨펌들은 js에 구현되어있음.  -->
  </div>
<? endforeach; ?>

<? $pre = $bottom['pre']; $next = $bottom['next']; //네비게이터를 위한 변수 ?>
<!-- 검색결과 없을때 아래 네비게이터 -->
<div class="text-center my-5"> 
  <? 
    if (!isset($_GET['search_input'])) 
    {
      if (isset($pre))
          $pre_url = "/board/get_content_view?b_seq=".$pre['b_seq']."&list=$list"; 
      if (isset($next))
        $next_url = "/board/get_content_view?b_seq=".$next['b_seq']."&list=$list";
    }
    else
    {
      if (isset($pre))
      $pre_url = "/board/get_content_view?b_seq=".$pre['b_seq']."&list=$list&search_by=".$GLOBALS['search_by']."&search_input=".$GLOBALS['search_input']."";
      if (isset($next))
      $next_url = "/board/get_content_view?b_seq=".$next['b_seq']."&list=$list&search_by=".$GLOBALS['search_by']."&search_input=".$GLOBALS['search_input']."";
    }
  ?>
    <? if (!isset($next) && isset($pre)) {?>
    <a href="<?=$pre_url?>">이전 게시글 : <?=$pre['subject']?></a>
    <? } else if (!isset($pre) && isset($next)) {?>
    <a href="<?=$next_url?>">다음 게시글 : <?=$next['subject']?></a>
    <? } else if ((isset($pre) && isset($next))) {?>
    <a href="<?=$next_url?>">다음 게시글 : <?=$next['subject']?></a><br>
    <a href="<?=$pre_url?>">이전 게시글 : <?=$pre['subject']?></a>
    <? } ?>
</div>