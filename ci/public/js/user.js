function get_image(user_id)
{
  $.ajax({
    url : "/User/get_user_img_func",
    type : 'post',
    data : { 'user' : user_id },
  }).done(function(test){
    $('#fist').attr('src', test);
  })
}