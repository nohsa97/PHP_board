function checkUser() {
    prompt("비밀번호를 입력해주세요.")
}

function goWrite() {
           location.href="../content/write.php";
}            

function modify_comment(){
    var coments = document.getElementsByTagName("li");     
    coments.item(1).style.border = "1px solid pink";   
}  
