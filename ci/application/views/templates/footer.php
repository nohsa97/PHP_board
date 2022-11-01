
<? if (isset($_SESSION['ID'])) :?>
<script>
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

  get_image($('#login_user').data('id'));
  </script>
<? endif; ?>
  <script src="/public/js/page.js"></script>
  </body>

</html>