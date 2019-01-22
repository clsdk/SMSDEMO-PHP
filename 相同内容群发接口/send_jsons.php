<?php
/**
 * Created by PhpStorm.
 * User: ChuangLan
 * Date: 2018/12/26
 * Time: 13:19
 */
//http请求
function curlPost($url,$postFields){
    $postFields = json_encode($postFields);
    //echo $postFields;die;
    $ch = curl_init ();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
        )
    );
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt( $ch, CURLOPT_TIMEOUT,10);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec ( $ch );
    if (false == $ret) {
        $result = curl_error(  $ch);
    } else {
        $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
        if (200 != $rsp) {
            $result = "请求状态 ". $rsp . " " . curl_error($ch);
        } else {
            $result = $ret;
        }
    }
    curl_close ( $ch );
    return $result;
}
$array = array(
    //API账号，管理后台获取
    'account'=>'N1011631',
    //API密码，管理后台获取（8-16位）
    'password'=>'Admin123',
    //审核通过的签名以及模板，长度不超过536个字符
    //注:营销账号请在内容末尾加上"退订"字样 例如 退订回T
    'msg'=>'【253通讯】您的验证码是255535',
    'phone'=>'150****0029,159****6184',
    //(可选参数)定时发送时间，小于或等于当前时间则立即发送 格式YYYYmmddHHmm
    //'sendtime'=>'201812262030',
    //(可选参数)是否需要状态报告，默认false；如需状态报告则传”true”
    //'report'=>'true',
    //(可选参数)下发短信号码扩展码,建议1-3位
    //'extend'=>'233',
    //(可选参数)该条短信在您业务系统内的ID，如订单号或者短信发送记录流水号
    //'uid'=>'158798798416513'
);
$res = json_decode(curlPost('https://smssh1.253.com//msg/send/json',$array),true);
?>