
    <script src="/public/smarteditor/js/HuskyEZCreator.js"></script>

    <form action="/board/write_action_func" method="post">
    <input type="text" required class="form-control my-3 mg-auto input_box" name="subject" id="" placeholder="제목을 입력해주세요">

    <div class="my-1">
      <input type="text" required class="form-control w-25  mg-auto input_box inline" name="input_ID"  placeholder="아이디">
      <input type="password" required class="form-control w-25  mg-auto input_box inline" name="input_pass" placeholder="비밀번호">
      <input type="hidden" name="permission" value="0">
    </div>

      <div id="smarteditor" style="background-color: white; width : 80%; margin : 30px auto">
        <textarea name="body" id="body" 
                  rows="20" cols="10" 
                  placeholder="내용을 입력해주세요"
                  style="width : 100%"></textarea>
      </div>
      <input type="submit" value="제출">

    </form>

    <script src="/public/js/write.js"></script>