<div class="container" style="margin-top : 50px;">

  <table id="account" class="table table-hover table-bordered list">
    <tr>
      <th>계좌 별칭</th>
      <th>계좌 번호</th>
      <th>핀테크 번호</th>
    </tr>
  </table>

  <a href="/oauth/get_authorization_code_func"><button>계좌 등록</button></a>
  <!-- <a href="/account/get_account"><button>계좌 갱신</button></a> -->
  <button onclick="test()">계좌 갱신</button>
  
</div>

<script>
  $(function(){
    $.ajax({
      url : "/account/get_account_list_func",
      success : function(data)
      {
        data = JSON.parse(data);
        data.forEach(element => {
          var account_list = 
          `<tr>
            <td>${element['account_alias']}</td>
            <td>${element['account_num_masked']}</td>
            <td>${element['fintech_use_num']}</td>
          <tr>
          `;
          $('#account').append(account_list);
        });

      }
    })
  })

  function test()
  {
    $.ajax({
      url : "/account/get_account",
      success : function()
      {
        history.go(0);
      },
      error : function()
      {
        alert("실패했서");
      }
    })
  }
</script>