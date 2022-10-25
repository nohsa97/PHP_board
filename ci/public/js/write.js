function test(FILE_ELEMENT)
{
  var reader = new FileReader();
  var img = '<iframe src="/public/asset/user/test1.jpg" width="300px" height="300px">';
  reader.onload = function () 
  {
    console.log(reader.result);
    $('textarea[name=body]').after(img);

  }
  reader.readAsDataURL(FILE_ELEMENT.files[0], "UTF-8");

}



//스마트 에디터
let oEditors = []

smartEditor = function() {
  console.log("Naver SmartEditor")
  nhn.husky.EZCreator.createInIFrame({
    oAppRef: oEditors,
    elPlaceHolder: "body",
    sSkinURI: "/public/smarteditor/SmartEditor2Skin.html",
    fCreator: "createSEditor2"
  })
}

$(document).ready(function() {
  smartEditor()
})

