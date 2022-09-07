document.getElementById("btnAdd").addEventListener("click",addList);
// html에서 id가 btnAdd인 요소를 찾고 클릭 시 동작할 addList 함수 연결

document.getElementById("btnDelAll").addEventListener("click",delAllElement);
// html에서 id가 btnDelAll인 요소를 찾고 클릭 시 동작할 addList 함수 연결

document.getElementById("btnDelLast").addEventListener("click",delLastElement);
// html에서 id가 btnDelLast인 요소를 찾고 클릭 시 동작할 addList 함수 연결

document.getElementById("DeleteSel").addEventListener("click",delSelected);
// html에서 id가 DeleteSel인 요소를 찾고 클릭 시 동작할 addList 함수 연결

function addList() {
    var contents = document.querySelector(".text-basic");
    // 입력창에 접근

    if(!contents.value) // 입력창에 값이 없으면
    {
        alert("일정을 입력해주세요."); // 경고창 출력

        contents.focus();
        // 입력창에 포커스 (활성화)

        return false;
        // 함수 종료
    }

    // ***** 데이터 추가 *****
    var tr = document.createElement("tr"); // 추가할 테이블 <tr> 생성
    var input = document.createElement("input"); // 테이블 <tr> 안에 들어갈 체크박스의 <input> 생성

    // 여기서 생성된 <tr> 안에는
    // <td>체크박스</td>
    // <td>텍스트<td>
    // 이렇게 두 가지의 요소가 들어가야 함

    // 체크박스 만들기
    input.setAttribute("type","checkbox"); // <input type="checkbox">
    input.setAttribute("class","btn-chk"); // <input type="checkbox" class="btn-chk">

    var td01=document.createElement("td"); // 첫 번째 <td> 생성 (체크박스를 담음)
    td01.appendChild(input); // 첫 번째 <td> 안에 <input> 추가

    var td02 = document.createElement("td"); // 두 번째 <td> 생성 (텍스트를 담음)
    td02.innerHTML = contents.value; // 두 번째 <td> 안에 입력창의 텍스트를 저장

    tr.appendChild(td01);
    tr.appendChild(td02); // 생성된 <tr> 안에 체크박스 td와 텍스트 td를 넣음

    document.getElementById("listBody").appendChild(tr); // tbody의 #listBody에 접근하여 tr을 자식요소로 추가

    contents.value=""; // 입력창의 내용이 추가되었으므로 입력창 지우기

    contents.focus(); // 입력창 포커스 (활성화)
}

// 전체 삭제
function delAllElement() {
    var list = document.getElementById("listBody"); // listBody에 접근

    var listChild = list.children; // listBody의 자식요소 정보가 들어옴

    for(var i = 0; i < listChild.length; i++) // 자식요소 개수만큼 반복하며 제거
    {
        list.removeChild(listChild[i]); // list의 자식요소 0번째, 1번째, 2번째 ... 제거

        i--;
    }

    /*
        [i-- 없을 때]

        0 HTML
        1 JS
        2 헬스

        0 JS
        1 헬스

        0 JS (완전히 삭제되지 않음)

        ------------------------------

        [i-- 있을 때]

        0 HTML
        1 JS
        2 헬스

        0 JS
        1 헬스

        0 헬스

        X (완전히 삭제됨)
    */
}

// 마지막 항목 삭제
function delLastElement() {
    var list = document.getElementById("listBody"); // listBody에 접근

    var listChild = list.children;

    if (listChild.length > 0) {
        var lastIdx=listChild.length - 1; // listBody의 자식요소 정보가 들어옴

        list.removeChild(listChild[lastIdx]);
    }
    else {
        alert("삭제할 항목이 없습니다.");
    }

}

// 선택 항목 삭제
function delSelected() {
    var list = document.getElementById("listBody"); // listBody에 접근

    var chkbox=document.querySelectorAll("#listBody .btn-chk"); // listBody 하위의 체크박스 모두 선택

    for (var i in chkbox) // i에 체크박스 인덱스 들어옴
    {
        if (chkbox[i].checked) // 체크박스가 체크되었으면
        {
            list.removeChild(chkbox[i].parentNode.parentNode); //체크박스 i번째의 부모(<td>)의 부모(<tr>) 제거
        }

    }
}
// https://2boki.tistory.com/142
