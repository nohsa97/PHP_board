
<div class="container text-center">
  <h1 class="sign-in"> 회원 로그인 </h1>
  <!-- <form action="/login/login_func" id="login_box" method="post" class="sign-in"> -->
  <form id="login_box"  method="post" class="sign-in" >
    <div class="form-floating">
      <input type="search" class="form-control" autocomplete="off" name="input_ID" placeholder="　">
      <label for="inputID">ID</label>
    </div>
  

    <div class="form-floating my-3">
      <input type="password" class="form-control" name="input_Pass" placeholder="　">
      <label for="inputPass">PASSWORD</label>
    </div>

    <p id="warning" style="color: red;"></p>
    <p id="warning2" style="color: red;"></p>
    <input type="submit" id="login_btn" class="btn btn-warning w-100" value="로그인">
  
    <input type="button" onclick="register_page()" class="btn btn-warning w-40 my-3" value="회원가입">
    
    <input type="button" class="btn btn-warning w-40 my-3" onclick="findPw_page()" value="ID/PW 찾기">
    <input type="button" id="no-login" onclick="no_login_page()" class="btn btn-warning w-100" value="비회원접속">
  </form>
    <a href="/oauth/authorization"><button>OAuth 테스트</button></a>
    <a href="/oauth/get_authorization_code2_func"><button id="test">OAuth2 테스트</button></a>
    
    <a href="/oauth/authorize_acount"><button>1년 테스트</button></a>
    <a href="/oauth/refresh_token_func"><button>OAuth 갱신?</button></a>
    <a href="/oauth/account_list"><button>계좌</button></a>
    <a href="/oauth/transaction_list"><button>거래내역 조회</button></a>
    <a href="/oauth/transaction_list_save_func"><button>거래내역 조회</button></a>
</div>
<script src="/public/js/login.js"></script>

<script>

</script>