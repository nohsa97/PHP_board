$(function() {

    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
       oAppRef: oEditors,
       elPlaceHolder: "content",
       sSkinURI: "/se2/SmartEditor2Skin.html",
       fCreator: "createSEditor2",
    });
 
 });