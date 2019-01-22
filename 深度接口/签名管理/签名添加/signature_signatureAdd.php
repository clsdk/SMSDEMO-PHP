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
    //需要设置的产品id（appid） 49 行业验证码 50 国际短信 52营销短信
    'appid'=>'49',
   //签名，比如“253云通讯”
   'signature_name'=>'253云通讯',
    //(可选参数)是否需要审核提醒，1需要，0不需要 默认为不需要
    //'remind_type'=>'0',
    //(可选参数)提醒手机，remind_type为1的情况下此值必须
    //'remind_phone'=>'150****0029'
    //应用场景，默认为1备注：1 签名为公司2 签名为媒体，报社，学校，医院，机关事业单位名称3 签名为自己产品名/网站名/APP名称等 4 签名为他人产品名/网站名等
    'signature_scene_type'=>'1',
    //(当signature_scene_type 为 3 时 必须有此参数)是否上线  ，
    //'is_online'=>'1',
    //(当is_online为1时 必须有此参数)网站地址
    //'web_site'=>'http://zz.253.com',
    //（当is_online为0时 必须有此参数）上传证明
    //'logo'=>array(
          //具有版权的商标或logo
          //'0'=>base64_encode(file_get_contents('./image/1.jpg')),
          //设计图——首页
          //'1'=>base64_encode(file_get_contents('./image/2.jpg')),
          //设计图——功能
          //'2'=>base64_encode(file_get_contents('./image/3.jpg')),
          //设计图——功能二
          //'3'=>base64_encode(file_get_contents('./image/4.jpg')),
          //设计图——个人中心
          //'4'=>base64_encode(file_get_contents('./image/5.jpg'))
    // )
    //(当signature_scene_type=4时)
    //'logo'=>array(
    //      授权委托书
    //      '0'=>base64_encode(file_get_contents('./image/1.jpg')),
    //      授权人手持授权书半身照
    //      '1'=>base64_encode(file_get_contents('./image/2.jpg')),
    //      授权人身份证正面
    //      '2'=>base64_encode(file_get_contents('./image/3.jpg')),
    //      授权人身份证背面
    //      '3'=>base64_encode(file_get_contents('./image/4.jpg')),
    //)

);
$res = json_decode(curlPost('https://zz.253.com/apis/signature/signatureAdd',$array),true);
var_dump($res);die;
?>