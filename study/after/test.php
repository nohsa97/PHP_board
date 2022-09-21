<form action="" method="get">
    <input type="text" name="id" id="id">
    <input type="text" name="pass" id="pass">
    <input type="button" value="로그인" onclick="login()">
</form>

<p id="target">asd</p>

<script src="//code.jquery.com/jquery.min.js"></script>
<script>

    function login() {
        var input  = {
        id : $('#id').val(),
        pass : $('#pass').val()
    };
        $.ajax({
            url : 'myname.php',
            type : "get",
            data : input,
        }).done(function(data) {
            $('#target').text(data);
        });
    }
</script>