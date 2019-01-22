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
    //需要设置子账号的扣款类型，格式为 产品id:扣款类型，比如 49:1 代表行业验证码主帐号计费，49:0代表示子账号独立计费
    'product_permit_pay'=>'49:1',
    //用途分类 如：0其它,1web，2app
    'use_type'=>'2',
    //子账户用途（1-50字符）
    'use_desc'=>'测试专用子账号',
    //姓名（<50字符）
    'name'=>'对接人员',
    //部门或分部名称（<=8个字）
    'department'=>'技术对接',
    //职位（<=8个字）
    'position'=>'技术对接',
    //要开通的子账号名称（6-20字符）
    'account_username'=>'testdemo',
    //要开通的子账号密码（6-16字符）
    'account_password'=>'a.123456'
);
$res = json_decode(curlPost('https://zz.253.com/apis/subaccount/add',$array),true);
var_dump($res);die;
?>