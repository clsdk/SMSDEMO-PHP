<?php
/**
 * Created by PhpStorm.
 * User: ChuangLan
 * Date: 2018/12/26
 * Time: 13:19
 */
//http请求
function curlPost($url,$postFields){
    //$postFields = json_encode($postFields);
    $postFields = http_build_query($postFields);
    //echo $postFields;die;
    $ch = curl_init ();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'charset=utf-8'   //json版本需要填写  Content-Type: application/json;
        )
    );
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
   // curl_setopt($ch,CURLOPT_HEADER,1);
    curl_setopt( $ch, CURLOPT_POST, 1 );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt( $ch, CURLOPT_TIMEOUT,10);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
    $ret = curl_exec ( $ch );
    //var_dump( curl_getinfo( $ch, CURLINFO_HTTP_CODE));die;
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
    //用户名，由商务提供
    'username'=>'',
    //时间戳（10位）
    'timestamp'=>time(),
    //签名，例如signature=md5(username+password+timestamp)两边通过相同的签名进行校验
    'signature'=>md5(''.time()),
    //子账号添加之后返回的id，在其他接口中写作sub_id
    'account_id'=>'118542',
    //需要添加产品id 49行业验证码 50国际短信 52营销短信
    'appid'=>'49',
    //要调拨的条数
    'amount'=>'1',
    //调拨类型：1主帐号给子账号调拨，2子账号给主帐号调拨
    'type'=>'1'
);
$res = json_decode(curlPost('https://zz.253.com/apis/subaccount/allot',$array),true);
var_dump($res);die;
?>