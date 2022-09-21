

$('#login').click(function() {
    var user  = {
        id : $('input[name=id]').val(),
        pass : $('input[name=pass]').val()
    }
    alert("로그인실행");
    $.ajax({
        type:'POST',
        url : "test_post.php",
        data : user,
        dataType : "json",
        success : function(data) {
            alert("실행되었씀");
        }
    });
});
