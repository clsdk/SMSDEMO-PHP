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
    //用户名，由商务提供
    'username'=>'',
    //时间戳（10位）
    'timestamp'=>time(),
    //签名，例如signature=md5(username+password+timestamp)两边通过相同的签名进行校验
    'signature'=>md5(''.time()),
    //需要设置的产品id（appid）49 行业验证码 50 国际短信 52营销短信
    'appid'=>'49',
    //(可选参数)偏移量，默认为0
    //'start'=>'0',
    //(可选参数)查询的长度，默认为10，最大值为100
    //'length'=>'20',
    //（可选参数）子账号id 如果填写视为操作子账号
    //'sub_id'=>''
);
$res = json_decode(curlPost('https://zz.253.com/apis/template/list',$array),true);
echo  '<pre>';
var_dump($res);
?>