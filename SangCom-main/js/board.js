var check = true;


let time = new Date();
let month = time.getMonth()+1;
let day = time.getDate();

let comment = document.getElementById('comment');
let comment_favor = document.getElementById('commentFavoriteValue');
let comment_favor_Data = document.getElementsByClassName("commentFavorite");
let comment_add_Data = document.getElementsByClassName("commentAdd");
let vr = '1';

// document.getElementById('Date').innerHTML=today.getFullYear()+"년 "
//   +(today.getMonth()+1)+"월 "+(today.getDate())+"일 "+(Week[(today.getDay())])+"요일" ;

//   document.getElementById('Date2').innerHTML=today.getFullYear()+"년 "
//   +(today.getMonth()+1)+"월 " ;


// comment_favor_Data[0].onclick = function() {
//     {
//       var favor = comment_favor.innerHTML;
//       console.log("1");
//         favor*=1;
//         favor+=1;
//         comment_favor.innerHTML=favor;
//     }
//   }

// comment_add_Data[0].onclick = function(){
//   comment_temp = comment.innerHTML;
//   comment.innerHTML+='<input type="text" placeholder="답글을 입력해주세요." class="comment_input btn_basic"> <input type="submit" class="btnsmall_blue btn_basic" value="입력">';

//   if(vr==='2')
//   {
//     comment.innerHTML='no';

//   }
//   vr = '2';
// }  //이거 잠시 주석처리함 혹시 오류나면 다시 해주셈 js오류나서 
function makecomment(input_text){
  var com ='<p class="commentList"> <span class="material-icons">cloud</span><b>익명/2022-'+month+'-'+day+'</b><br>'+input_text+'</p> <div id="comment_btn" class="justify-content-end d-flex">     <input type="button" class="material-icons commentBtn commentAdd" value="mode_comment">     <input type="button" class="material-icons commentBtn commentFavorite " value="favorite"      <span id="comment_favorite_value">1</span> </div>';
  return com;
}

function addChild() {
  var target = document.getElementById('commentList');
  var text = document.getElementById('body').value;
  var input_comment = makecomment(text);

  if(text=='') {
    alert('댓글을 입력하세요.');
  }
  else {
  document.getElementById('body').value='';
  target.insertAdjacentHTML('beforeend',input_comment);
  }
}

function enter() {
    if (window.event.keyCode == 13) {
      var target = document.getElementById('commentList');
      var text = document.getElementById('body').value;
      var input_comment = makecomment(text);

      if(text=='') {
        alert('댓글을 입력하세요.');
      }
      else {
      document.getElementById('commentText').value='';
      target.insertAdjacentHTML('beforeend',input_comment);
      }
      }
}

function createBoard() {
    var target = document.getElementById('boardCreate');
    target.insertAdjacentHTML('beforeend',"no");
}


function removeContent() {
  
  
  if(confirm("삭제하시겠습니까?")){
    alert("삭제되었습니다.");
    location.href = "main.html"
  }
  else {
    alert("취소되었습니다.");
  }
}

var thumb_check = false;


// $(function(){
//   $('.bottom_icon').click(function(){
//     if(thumb_check==false) {
//       $(this).css("font-variation-settings","'FILL' 1, 'wght' 100, 'GRAD' 200, 'opsz' 48");
//       $(this).css("color","#06cded");
//       thumb_check=true;
//     }
//     else {
//       $(this).css("font-variation-settings","'FILL' 0, 'wght' 100, 'GRAD' 200, 'opsz' 48");
//       $(this).css("color","black");
//       thumb_check=false;
//     }
   
//   });
// });  //개별 색변경  추후에 하얀색으로 바꾸기할예정 하얀색은 fill을 0으로 바꾸면끝.




$(function() {
  $('.bottom_icon').click(function() {
    if($(this).hasClass('filled')) {
      $(this).removeClass('filled');
    }
    else {
      $(this).addClass('filled');
    }
  });
});



$(function(){
  $('.sur_comment_count').click(function(){
    $('#added_comment').attr('class','commentInput');
    check=false;
  });
});  //숨겨진 대댓글창 나타내기



