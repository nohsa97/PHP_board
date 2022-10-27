//게시글 
function write_board()
{
  const subject = $('input[name=subject]'); 
  const ID = $('input[name=input_ID]');
  const Pass = $('input[name=input_pass]');
  const body = $('textarea[name=body]');
  const permission = $('input[name=permission]');
  if (subject.val() == "")
  {
    alert("제목을 입력해주십시오.");
    subject.focus();
    return false;
  }
  else if (ID.val() == "")
  {
    alert("아이디를 입력해주십시오.");
    ID.focus();
    return false;
  }
  else if (Pass.val() == "")
  {
    alert("비밀번호를 입력해주십시오.");
    Pass.focus();
    return false;
  }
  else if (body.val() == "")
  {
    alert("내용를 입력해주십시오.");
    body.focus();
    return false;
  }
  else
  {
    $.ajax({
      url : "/board/write_action_func",
      type : "post",
      data : {
        'subject' : subject.val(),
        'input_ID' : ID.val(),
        'input_pass' : Pass.val(),
        'body' : body.val(),
        'permission' : permission.val()
      }
    }).done(function(response){
      location.href = "/board/get_content_view?b_seq="+ response +"&list=0";
    })
  }
}






$(function()  //수정 버튼 추가
{
  $('.b_modify').on("click", function()
  {
    var b_seq = $("#board").data("b_seq");
    if ($('#board').data('permission') == 1)  //유저권한
    {
      if (confirm("수정하시겠습니까?"))
      {
        location.href = "/board/write_page/" + b_seq;
      } 
    }
    else 
    {
      if ($('#modify_box').length > 0)
      {
          $('#modify_box').remove();
      }
  
      else 
      {
        var add = '<span id="modify_box">\
                    <input type="password" id="b_modify_pass" class="form-control w-75 inline" style="margin-left : -15px;">\
                    <input type="button" id="b_modify_btn" class="btn btn-primary b_set" value="수정">\
                  </span>';
        $('.b_modify').after(add);
        $('#remove_box').remove();
      }
    }
  });
});

$(function()  //삭제 버튼 추가
{
  $('.b_remove').on("click", function()
  {
    var b_seq = $("#board").data("b_seq");
    if ($('#board').data('permission') == 1)  //유저권한
    {
      if (confirm("삭제하시겠습니까?"))
      {
        $.ajax({
          url : "/board/remove_func",
          data : {
          "b_seq" : b_seq,
          "input_pass" :  null
          },
          type : "POST",
          }).done( function (data) 
          {
            if (data == 1)
            {
              alert("삭제되었습니다.");
              location.href = "/board";
            }
            else if (data == 0)
            {
              alert("비밀번호가 다릅니다.");
              history.go(0);
            }
          });
      } 
    }
    else 
    {
      if ($('#remove_box').length > 0)
      {
        $('#remove_box').remove();
      }
  
      else 
      {
        var add = '<span id="remove_box">\
                      <input type="password" id="b_remove_pass" class="form-control w-75 inline">\
                      <input type="button" id="b_remove_btn" class="btn btn-danger b_set" value="삭제">\
                  </span>';
        $('.b_remove').after(add);
        $('#modify_box').remove();
      }
    }
  })
});

$(document).on("click", ".b_set", function() //상황에 맞는 버튼 클릭
{
  var b_seq = $("#board").data("b_seq");

  if ($(this).val() == "수정")
  {
    if($('#b_modify_pass').val() == "")
    {
      alert("비밀번호를 입력해주세요.");
      return;
    }
    if ( confirm("수정하시겠습니까?") )
    {
      $.ajax({
        url : "/board/check_func",
        data : {
        "b_seq" : b_seq,
        "input_pass" :  $("#b_modify_pass").val()
        },
        type : "POST",
      }).done( function (data) 
      {
        if (data == 1)
        {
          location.href = "/board/write_page/" + b_seq;
        }
        else
        {
          alert(data);
        }
      });
      }
  }

  else //버튼값이 삭제라면
  {
    if ( confirm("삭제하시겠습니까?") )
    {
      if($('#b_remove_pass').val() == "")
      {
        alert("비밀번호를 입력해주세요.");
        return;
      }
      $.ajax({
            url : "/board/remove_func",
            data : {
            "b_seq" : b_seq,
            "input_pass" :  $("#b_remove_pass").val()
            },
            type : "POST",
      }).done( function (data) 
      {
        if (data == 1)
        {
          alert("삭제되었습니다.");
          location.href = "/board";
        }
        else if (data == 0)
        {
          alert("비밀번호가 다릅니다.");
          history.go(0);
        }
      });
    }
  }
});

//댓글

// $(function()  //수정 버튼 추가
// {
//   $('.c_modify').on("click", function()
//   {
//     alert("asdsad");
//     var c_seq = $(this).parent().data('c_seq');
//     var permission = $('.comment_' + c_seq).data('permission');

//     if ($('#c_modify_area_' + c_seq).length > 0)
//     {
//       $('#c_modify_area_' + c_seq).remove();
//       $('#c_modify_body_' + c_seq).remove();
//     }
//     else 
//     {
//       if (permission == 0)
//       {
//         var add = '<span id="c_modify_area_'+ c_seq + '">\
//                     <input type="password" id="c_modify_pass_' + c_seq + '" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">\
//                     <input type="button" id="c_modify_btn_' + c_seq + '"  class="btn btn-primary comment_change c_set" data-c_seq="'+c_seq+'" value="수정">\
//                    </span>';
//       }
//       else
//       {
//         var add = '<span id="c_modify_area_'+ c_seq + '">\
//                     <input type="button" id="c_modify_btn_' + c_seq + '"  class="btn btn-primary comment_change c_set" data-c_seq="'+c_seq+'" value="수정">\
//                   </span>';
//       }
//       var before_comment = $('#comment_body_' + c_seq).text(); // 댓글 원본
      
//       var input = '<input type="text" id="c_modify_body_'+ c_seq +'" required class="form-control my-3 mg-auto input_box" name="body" value="' + before_comment + '"></input>';
//       $('#c_writer_' + c_seq).append(add);
//       $('#comment_body_' + c_seq).after(input);
//     }
//   })
// });
$(document).on("click", '.c_modify', function(){
  var c_seq = $(this).parent().data('c_seq');
  var permission = $('.comment_' + c_seq).data('permission');

  if ($('#c_modify_area_' + c_seq).length > 0)
  {
    $('#c_modify_area_' + c_seq).remove();
    $('#c_modify_body_' + c_seq).remove();
  }
  else 
  {
    if (permission == 0)
    {
      var add = '<span id="c_modify_area_'+ c_seq + '">\
                  <input type="password" id="c_modify_pass_' + c_seq + '" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">\
                  <input type="button" id="c_modify_btn_' + c_seq + '"  class="btn btn-primary comment_change c_set" data-c_seq="'+c_seq+'" value="수정">\
                </span>';
    }
    else
    {
      var add = '<span id="c_modify_area_'+ c_seq + '">\
                  <input type="button" id="c_modify_btn_' + c_seq + '"  class="btn btn-primary comment_change c_set" data-c_seq="'+c_seq+'" value="수정">\
                </span>';
    }
    var before_comment = $('#comment_body_' + c_seq).text(); // 댓글 원본
    
    var input = '<input type="text" id="c_modify_body_'+ c_seq +'" required class="form-control my-3 mg-auto input_box" name="body" value="' + before_comment + '"></input>';
    $('#comment_writer_' + c_seq).append(add);
    $('#comment_body_' + c_seq).after(input);
  }
})


$(function()  //삭제 버튼 추가
{
  $('.c_remove').on("click", function()
  {
    const c_seq = $(this).parent().data('c_seq');
    var permission = $('.comment_' + c_seq).data('permission');

    if ($('#c_remove_input_' + c_seq).length > 0)
    {
      $('#c_remove_input_' + c_seq).remove();
    }

    else 
    {
      if (permission == 0)
      {
        const add = '<span id="c_remove_input_'+ c_seq + '">\
                    <input type="password"  id="c_remove_pass_' + c_seq + '" class="form-control w-75 inline">\
                    <input type="button" class="btn btn-danger comment_change c_set" data-c_seq="'+c_seq+'" value="삭제">\
                  </span>';
        $('.comment_' + c_seq).append(add);
      }   
      else
      {
        const id = $('#comment_writer_' + c_seq).text();
        if (confirm("삭제하시겠습니까?"))
        {
          $.ajax({
          url : "/comment/remove_func",
          data : {
          "c_seq" : c_seq,
          "ID" : id
          },
          type : "POST",
          }).done(function (data) 
          {
            if (data == 1)
            {
              alert("삭제되었습니다.");
              history.go(0);
            }
            
            else if (data == 0)
            {
              alert("비밀번호가 다릅니다.");
              history.go(0);
            }
            else
            {
              alert(data);
            }
          }); 
        }
      }
    }
  })
});


$(document).on("click", ".c_set", function() //상황에 맞는 버튼 클릭
{
  const c_seq = $(this).data('c_seq');
  if ($(this).val() == "수정")
  {
    if ( confirm("수정하시겠습니까?") )
    {
      alert( $("#c_modify_body_" + c_seq).val());
      $.ajax({
        url : "/comment/update_func",
        data : {
            "c_seq" : c_seq,
            "input_pass" :  $("#c_modify_pass_" + c_seq).val(),
            "body" : $("#c_modify_body_" + c_seq).val()
        },
        type : "POST",
      }).done(function (data) 
      {
        if (data == 1)
        {
          alert("수정되었습니다.");
          history.go(0);
        }
        
        else if (data == 0)
        {
          alert("비밀번호가 다릅니다.");
          history.go(0);
        }
        else
        {
          alert(data);
        }
      });
    }
  }

  else //버튼값이 삭제라면
  {
    
    if ( confirm("삭제하시겠습니까?") )
    {
      $.ajax({
        url : "/comment/remove_func",
        data : {
        "c_seq" : c_seq,
        "input_pass" :  $("#c_remove_pass_" + c_seq).val()
        },
        type : "POST",
        }).done(function (data) 
        {
          if (data == 1)
          {
            alert("삭제되었습니다.");
            history.go(0);
          }
          
          else if (data == 0)
          {
            alert("비밀번호가 다릅니다.");
            history.go(0);
          }
          else 
          {
            alert(data);
          }
        }); 
    }
  }
});

//대댓글 

function reply_btn(c_seq, b_seq, permission)
{
  if ($('#reply_box_'+c_seq).length > 0) // id값이 존재하는지 
  {
    $('#reply_box_'+c_seq).remove();
  }

  else
  {
    var newForm = $('<form></form>');
    newForm.attr('method', 'post');
    newForm.attr('action', '/comment/comment_write');
    newForm.attr('id', 'reply_box_' + c_seq);
    newForm.attr('class', 'reply_input');

    var input_area = '\
    <input type="submit" class="btn btn-success c_write" value="대댓글 쓰기">\
    <input type="hidden" name="c_seq" value="'+ c_seq +'">\
    <input type="hidden" name="b_seq" value="'+ b_seq +'">\
    <input type="hidden" name="list" value="'+ b_seq +'">\
    <input type="hidden" name="permission" value="'+ permission +'">\
    <input type="text" required class="form-control my-3 mg-auto input_box" name="body" placeholder="댓글을 입력해주세요">\
    ';

    if (permission == 0)
    {
      var user_info = ' \
      <div class="my-1">\
          <input type="text" required class="form-control w-25  mg-auto input_box inline" name="writer" placeholder="아이디를 입력해주세요.">\
          <input type="password" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">\
      </div>';
    }
    else 
    {
      var writer = $('#comment_writer').val();
      var user_info = ' \
      <div class="my-1" style="height:58px;">\
      <img src="/public/asset/user/' + writer + '.jpg"  onerror="this.onerror=null; this.src="/public/asset/user/person.png" " width="25px" height="25px">\
        <b>'+ writer + '</b>\
        <input type="hidden" name="writer" value="'+ writer +'">\
      </div>';
    }
    newForm.append(user_info);
    newForm.append(input_area);
    $('.comment_' + c_seq).after(newForm);
  }
  
}

// $(function() {
//   $('#comment_insert').validate({
//     rules : {
//       logout_writer : {
//         required : true,
//       },
//       logout_password : {
//         required : true,
//       },
//     },
//     message : {
//       logout_writer : {
//         required : alert("작성자를 입력해주세요."),
//       },
//       logout_password : {
//         required : alert("비밀번호를 입력해주세요."),
//       }
//     },
//     submitHandler : function()
//     {
//     }
//   })
// });

function checkBox(b_seq)
{
  if ($('input[name=writer]').val() == "")
  {
    alert ("아이디를 입력해주세요.");
    $('input[name=writer]').focus();
    return false;
  }
  else if ($('input[name=password]').val() == "")
  {
    alert ("비밀번호를 입력해주세요.");
    $('input[name=password]').focus();
    return false;
  }
  else if ($('#comment_input').val() == "")
  {
    alert ("내용을 입력해주세요.");
    $('#comment_input').focus();
    return false;
  }
  else
  {
    $.ajax({
      url : "/comment/comment_write",
      type : "post",
      data : {
        'writer'   : $('input[name=writer]').val(),
        'body'     : $('#comment_input').val(),
        'password' : $('input[name=password]').val(),
        'b_seq'    : b_seq,
        'permission' : $('input[name=permission').val()
      }
    }).done(function(data){
      if (data == 1)
      {
        history.go(0);
      }
    });
  }
}

function test()
{
  $.ajax({
    url : '/comment/get_comment_list',
    type : 'GET',
    data : {'b_seq' : $('#board').data('b_seq')},
    dataType : "json",
    contentType:"text/json",
  }).done(function(data){
    data.reverse(); //넘어오고나서 추가시킬때 거꾸로들어가야함
    data.forEach( function(element) {
      var newForm = $('<div></div>');
      newForm.attr('class', 'container content_box');
      newForm.attr('style', 'margin-top:-3px;');

      var writer_box = $('<p></p>');
      writer_box.attr("style", "border-bottom : 3px solid red;");
      

      var writer = '<b style="margin-left:10px" id="comment_writer_'+ element['c_seq'] +'">'+ element['writer'] +'</b>';
      writer_box.append(writer);

      var com = "<span id='comment_body_"+ element['c_seq'] +"'>" + element['body'] + "</span>";
      newForm.append(writer_box);
      newForm.append(com);
      $('#comment_list').after(newForm);
      var newForm2 = $('<div></div>');
      newForm2.attr('class', 'comment content_top2 comment_'+ element['c_seq']);
      newForm2.attr('data-c_seq', element['c_seq']);
      newForm2.attr('data-permission', element['permission']);
      var btn = '<button class="btn btn-outline-primary btn-sm c_modify">수정하기</button>\
      <button class="btn btn-outline-danger remove btn-sm c_remove">삭제하기</but ton>';
      newForm2.append(btn);

      $(newForm).append(newForm2);
    });
  });
}
