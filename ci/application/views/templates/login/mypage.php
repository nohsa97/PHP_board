<div class="container my-3">
  <div style="border: 5px solid black; border-radius:5px;">
    <h1 class="text-center">내정보</h1>

    <h2 class="text-center"> 아이디 : <span id="user_id"><?=$ID?></span>  </h2>
    <h2 class="text-center"> 이름 : <?=$Name?> </h2>
    <h2 class="text-center"> 이메일 : <?=$Email?> </h2>
    
    <h2 class="text-center">프로필 이미지: <img class="align-center" src="<?=$user_img?>" onerror="this.onerror=null; this.src='/public/asset/user/person.png'"  alt="이미지" width="80px" height="80px"></h2>
    <!-- enctype  데이터가 인코딩되는 방법을 명시  -->
    <h2 class="text-center"> 프로필 이미지 변경 </h2>
    <form class="text-center" enctype="multipart/form-data" action="/User/upload_userImg" method="post"> 
      <input type="file" name="image" accept="image/jpeg, image/png">
      <input class="btn btn-primary" type="submit" value="변경">
    </form>
    <h2 class="text-center">회원탈퇴<br> <button class="btn btn-danger" onclick="withdrawal()">탈퇴</button></h2>
  </div>
</div>



<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<p class="text-end"><a href="/user/test">test</a></p>