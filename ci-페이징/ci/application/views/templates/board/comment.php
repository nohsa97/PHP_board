<?
    // $result = $comment[0];

    foreach ($comment as $result)
    {
        echo '
            <div class="container content_box" style="margin-top:-3px;">
                <p>
                    <img src="/public/asset/person.png" alt="" width="25px" height="25px">
                    '.$result['writer'].'
                </p>

                <div class="comment">
                    <span>'.$result['body'].'</span>
                    <button class="btn btn-danger remove">삭제하기</button>
                    <button class="btn btn-primary remove">수정하기</button>
                </div> 

            </div>
        ';
        
    }
?>