$(function()  //수정 버튼 추가
{
        $('.b_modify').on("click", function()
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

        });
});

$(function()  //삭제 버튼 추가
{
        $('.b_remove').on("click", function()
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

        })
});

$(document).on("click", ".b_set", function() //상황에 맞는 버튼 클릭
{
    var b_seq = $("#board").data("b_seq");

    if ($(this).val() == "수정")
    {
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

$(function()  //수정 버튼 추가
{
        $('.c_modify').on("click", function()
        {
            var c_seq = $(this).data('c_seq');
            if ($('#c_modify_area_' + c_seq).length > 0)
            {
                $('#c_modify_area_' + c_seq).remove();
                $('#c_modify_input_' + c_seq).remove();
            }

            else 
            {
                var before_comment = $('#comment_body_' + c_seq).text(); // 댓글 원본
                var add = '<span id="c_modify_area_'+ c_seq + '">\
                                <input type="password" id="c_modify_pass_' + c_seq + '" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">\
                                <input type="button" id="c_modify_btn_' + c_seq + '"  class="btn btn-primary comment_change c_set" value="수정">\
                            </span>';
                var input = '<input type="text" id="c_modify_body_'+ c_seq +'" required class="form-control my-3 mg-auto input_box" name="body" value="' + before_comment + '"></input>';
                
                $('#c_modify_box_' + c_seq).append(add);

                $('#comment_body_' + c_seq).after(input);

            }
        })
});

$(function()  //삭제 버튼 추가
{
        $('.c_remove').on("click", function()
        {
            var c_seq = $(this).data('c_seq');
            if ($('#c_remove_input_' + c_seq).length > 0)
            {
                $('#c_remove_input_' + c_seq).remove();
            }

            else 
            {
                var add = '<span id="c_remove_input_'+ c_seq + '">\
                                <input type="password" id="c_remove_pass_' + c_seq + '" class="form-control w-75 inline">\
                                <input type="button" class="btn btn-danger comment_change c_set" value="삭제">\
                            </span>';
                $('#c_remove_box_' + c_seq).append(add);
            }
        })
});


$(document).on("click", ".c_set", function() //상황에 맞는 버튼 클릭
{
    var c_seq = $("#comment").data("c_seq");

    if ($(this).val() == "수정")
    {
        if ( confirm("수정하시겠습니까?") )
        {
    
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
               alert(data);
               history.go(0);
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


// $(function () 
// { //숨겨진 버튼 클릭시 발생하는 이벤트 - 게시글 삭제 수정
//     $(".comment_change").on("click", function() {
//         var c_seq = $(this).data("c_seq");
        
//         if ($(this).val() == "삭제")
//         {
//             if (confirm("삭제하시겠습니까?"))
//             {
//                 $.ajax({
//                      url : "/comment/remove_func",
//                      data : {
//                         "c_seq" : c_seq,
//                         "input_pass" :  $("#c_remove_pass_" + c_seq).val()
//                      },
//                      type : "POST",
//                 }).done(function (data) 
//                 {
//                     if (data == 1)
//                     {
//                         alert("삭제되었습니다.");
//                         history.go(0);
//                     }
                    
//                     else if (data == 0)
//                     {
//                         alert("비밀번호가 다릅니다.");
//                         history.go(0);
//                     }

//                     else 
//                     {
//                         alert(data);
//                     }
//                 });
//             }
//         }

//         else //버튼값이 수정
//         {
//             $.ajax({
//                 url : "/comment/update_func",
//                 data : {
//                    "c_seq" : c_seq,
//                    "input_pass" :  $("#c_modify_pass_" + c_seq).val(),
//                    "body" : $("#c_modify_body_" + c_seq).val()
//                 },
//                 type : "POST",
//            }).done(function (data) 
//            {
//                alert(data);
//                history.go(0);
//            });
//         }   
//     });
// });


function reply_btn(c_seq, b_seq)
{

    if ( $('#reply_box_'+c_seq).length > 0 ) // id값이 존재하는지 
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

        var test = ' \
            <div class="my-1">\
                <input type="text" required class="form-control w-25  mg-auto input_box inline" name="writer" placeholder="아이디를 입력해주세요.">\
                <input type="password" required class="form-control w-25  mg-auto input_box inline" name="password" placeholder="비밀번호를 입력해주세요.">\
            </div>\
            <input type="submit" class="btn btn-success c_write" value="대댓글 쓰기">\
            <input type="hidden" name="c_seq" value="'+c_seq+'">\
            <input type="hidden" name="b_seq" value="'+b_seq+'">\
            <input type="hidden" name="list_seq" value="'+b_seq+'">\
            <input type="text" required class="form-control my-3 mg-auto input_box" name="body" placeholder="댓글을 입력해주세요">\
        ';
        newForm.append(test);
        
        $('.comment_' + c_seq).after(newForm);
    }
    
}