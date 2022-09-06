function checkUser() {
    prompt("비밀번호를 입력해주세요.")
}

function goWrite() {
           location.href="write.php";
        }            

function header () {
    document.write( '<div class="nav"><a href="list.php">UCERT 자유게시판 </a></div>');
}

// function alerting(text) {
//     alert(text);
// }


// function includeHTML(){
//     var allTag;
//     var element;s
//     var HTML;
//     allTag = document.getElementsByTagName('*');
//     for(i=0;i<allTag.length<i++){
//         element=allTag[i];
//         HTML = element.getAttribute("include-HTML");
//         if(HTML) {
//             xhttp = new XMLHttpRequest();
//             xhttp.onreadystatechange == function () {
//                 if(this.readyState)
//             }
//         }
//     }
// }