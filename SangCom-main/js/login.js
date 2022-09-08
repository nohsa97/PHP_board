function login(){
    $.ajax({
        type : 'post',
        url : 'localhost:8080',
        headers : {
            "Content-Type" : "application/json",      "X-HTTP-Method-Override" : "POST"
        },
        data
    })
}