            <div class="media" style="margin-top:10px;">
                <div class="media-left" style="padding-top:5px;">
                    <a href="#">
                        <img class="media-object" src="<?=((!empty($mem_picture) && $mem_level !== 'manager')?$mem_picture:"/static/image/komment.png")?>">
                    </a>
                </div>
                <div class="media-body">
                    <span style="font-size:11px;line-height:25px;"><span class="label label-default">레벨<?=get_level($mem_point)?></span> <?=($mem_level !== 'manager')?$mem_name:"Komment"?></span>
                    <span style="font-size:11px;float:right;margin-right:20px;margin-top:5px;"><?=remain_datetime($end_time)?></span>
<?
if(!empty($question_image)) {
?>
                    <h6><a href="/answer/view/<?=$que_srl?>"><img src="<?=$question_image?>" style="border-radius:0px;width:auto;max-width:250px;height:auto"></a></h6>
<?
}
?>
                    <h5 class="media-heading link" style="line-height:22px;cursor:pointer;" data-link="/answer/view/<?=$que_srl?>"><?=convert_hashtag($question)?></h5>
                    <span style="font-size:11px;">응답 <?=number_format($respond)?> &nbsp; 좋아요 <span id="likecount<?=$que_srl?>"><?=number_format($likes)?></span></span>
<?
/* // 요거는 아직 미해결 - 안나오게 하는 것도 나쁘지 않은듯
        if($mem_srl !== $member['mem_srl']) {
?>
                    <a href="javascript:;" class="likethis" id="likethis<?=$v['que_srl']?>" data-question="<?=$v['que_srl']?>" data-status="<?=(empty($like[$v['que_srl']]))?"false":"true"?>" style="float:right;margin-right:25px;"><span class="glyphicon glyphicon-heart" id="like<?=$v['que_srl']?>" style="font-size:20px;color:<?=(empty($like[$v['que_srl']]))?"gray":"darkorange"?>;"></span></a>
<?
        }
        */
?>
                </div>
                <hr style="margin-top:5px;margin-bottom:0px">
            </div>
