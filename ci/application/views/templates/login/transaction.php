<?
?>

<div class="text-center container">

  <form onsubmit="return get_tran_list()">
    <select name="inout_type" id="inout_type">
      <option value="">입/출금 구분</option>
      <option value="A">ALL</option>
      <option value="I">입금</option>
      <option value="O">출금</option>
    </select>

    <select name="fintech" id="fintech">
      <option value="">핀테크 이용번호</option>
    </select><br>

    조회 시작일자<input type="datetime-local" name="from_date" id="from_date"><br>
    조회 종료일자<input type="datetime-local" name="to_date" id="to_date"><br>
    <input type="text" name="trace" id="">
    <input type="submit" value="제출">
  </form>
  
</div>

<div class="container" style="max-width : 100% !important">
  <table id="transaction" class="table table-hover table-bordered list">
    <tr>
      <th>입/출금 구분</th>
      <th>조회 시작 일자</th>
      <th>조회 끝 일자</th>
      <th>조회 시작 시간</th>
      <th>조회 끝 시간</th>
      <th>계좌 별칭</th>
      <th>계좌 번호(마스킹)</th>
      <th>거래점 명</th>
      <th>통장인자 내용</th>
      <th>회사 명</th>
      <th>주문 번호</th>
      <th>도메인</th>
    </tr>
  </table>
</div>



<script>
  $(function()
  {
    $.ajax
    ({
      url : "/oauth/get_fintech_num_func",
      success : function(data)
      {
        var test = JSON.parse(data);
        test.forEach(function(ele)
        {
          var test = $("<option></option>");
          test.val(ele['fintech_use_num']);
          test.text(ele['fintech_use_num'] + " - " + ele['bank_name'] + " - " + ele['account_num_masked']);
          $('#fintech').append(test);
        });
      }
    })
  })

  function get_tran_list()
  {
    if ($('#inout_type').val() == "" || $('#fintech').val() == "")
    {
      alert("입/출금 & 핀테크 번호를 선택해주세요.");
      return false;
    }

    if ($('from_date').val() == "" || $('#to_date').val() == "")
    {
      alert("조회 하실 시간을 선택해주세요.");
      return false;
    }

    let input_data = {
      'inout_type' : $('#inout_type').val(),
      'fintech' : $('#fintech').val(),
      'from_date' : $('#from_date').val(),
      'to_date' : $('#to_date').val(),
    }
    $.ajax
    ({
      url : "/transaction/get_transaction_list",
      data : input_data,
      type : 'post',
      success : function(data)
      {
        // var list = $('<div></div>');
        // list.attr('id', 'list');
        
        var test = JSON.parse(data);
        test.forEach(function(ele)
        {
          var test2 = $("<tr></tr>");
          var test32 =`<td>${ele['inout_type']}</td>
                      <td>${ele['tran_date']}</td>
                      <td>${ele['tran_date']}</td>
                      <td>${ele['tran_date']}</td>
                      <td>${ele['tran_date']}</td>
                      <td>${ele['account_alias']}</td>
                      <td>${ele['account_num_masked']}</td>
                      <td>${ele['branch_name']}</td>
                      <td>${ele['print_content']}</td>
                      <td>유써트</td>
                      <td>202213320</td>
                      <td>www.naver.com</td>`;
          $(test2).append(test32);
          $('#transaction').append(test2);
          // $(list).append(test2);
        });
        // $('#transaction').append(list);
      }
    })
    return false;
  }
</script>