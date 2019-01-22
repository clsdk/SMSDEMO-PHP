<?php
/**
 * Created by PhpStorm.
 * User: ChuangLan
 * Date: 2018/12/26
 * Time: 11:02
 */
//http请求
function curlPost($url,$postFields){
    $postFields = json_encode($postFields);
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
    //API账号
    'account'=>'',
    //API密码
    'password'=>'',
    'data'=>array(
        array(
            //该条短信在用户业务系统内的ID，用户自定义,长度不超过20位
            'msgid'=>'123456',
            //短信内容，长度不能超过536个字符
            'content'=>'验证码是2555',
            //手机号码，多个手机号码使用英文逗号分隔
            'phones'=>'150***0029',
            //短信需要使用的签名，例如【253云通讯】
            'sign'=>'【253云通讯】',
            //(可选参数)自定义扩展码，纯数字，长度不超过3位
            //'subcode'=>'233',
            //(可选参数)定时下发时间，格式为yyyyMMddHHmm
            //'sendtime'=>'201812261120'
        ),
        array(
            //该条短信在用户业务系统内的ID，用户自定义,长度不超过20位
            'msgid'=>'654321',
            //短信内容，长度不能超过536个字符
            'content'=>'验证码是你猜对我我就告诉你',
            //手机号码，多个手机号码使用英文逗号分隔
            'phones'=>'150***0027',
            //短信需要使用的签名，例如【253云通讯】
            'sign'=>'【253云通讯】',
            //(可选参数)自定义扩展码，纯数字，长度不超过3位
            //'subcode'=>'233',
            //(可选参数)定时下发时间，格式为yyyyMMddHHmm
            //'sendtime'=>'201812261120'
        )
    )
);
$res = json_decode(curlPost('https://smssh1.253.com/msg/BatchSubmit',$array),true);
?>