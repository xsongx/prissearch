<?php
$uid = $_POST['userid'];
#$uid = "1663232781";
$url = 'http://weibo.com/u/'.$uid;
$r = new HttpRequest($url);
$cookies_json ='{"U_TRS1":"00000031.77974ff9.51263761.7c587299","SINAGLOBAL":"60.2.135.130_452615088.1363780463","sso_info":"nick%3D%25E7%25AE%2580%25E6%2597%25B6%25E7%25A9%25BAJscon%26uid%3D1363898634","UOR":"login.sina.com.cn,login.sina.com.cn,", "FSINAGLOBAL":"60.2.135.130_452615088.1363780463", "ULV":"1363855648581:1:1:1:60.2.135.130_237403744.1363829692:","U_TRS2":"000000b6.7aae7f00.514d0d46.ddf74d1a", "Apache":"59.64.255.182_179713936.1364004166"}';
$cookies_str = "UOR=www.vmovier.com,widget.weibo.com,login.sina.com.cn; SINAGLOBAL=611274742907.3606.1363780464846; ULV=1364777023645:9:1:3:1815807434750.124.1364777023467:1364699172560; myuid=1363898634; un=inningbo123@sina.com; ALF=1365266618; wvr=5; USRV5WB=usrmdins312_202; SUS=SID-1363898634-1364777009-JA-m7iva-3c7a35c65693d0629f7b082d4cc03b02; SUE=es%3Ddc7b52adeab1ca04cad8c695f36643f7%26ev%3Dv1%26es2%3Dd59e62c7063bcb819607026d1673adc9%26rs0%3DLXQQyuHcnoqU8N2bS%252BTggANbeWiHGJWjsnkj0gNxXkupe3bF5W351pDZngBWEnqdI6%252Fw8nwdNub72hDutHPBsbXjJZufWysui2BDSX8OrEsSYdPJlFqltJ4eBlp1zHezAYOrar6jzT68hTHYVFPhKzU%252FS4kvhfbJFbh95Tiu2Kk%253D%26rv%3D0; SUP=cv%3D1%26bt%3D1364777009%26et%3D1364863409%26d%3Dc909%26i%3D08ba%26us%3D1%26vf%3D0%26vt%3D0%26ac%3D0%26st%3D0%26uid%3D1363898634%26user%3Dinningbo123%26ag%3D2%26name%3Dinningbo123%2540sina.com%26nick%3D%25E7%25AE%2580%25E6%2597%25B6%25E7%25A9%25BAJscon%26fmp%3D%26lcp%3D2011-12-13%252009%253A30%253A52; SSOLoginState=1364777009; USRUG=usrmdins413160; _s_tentry=login.sina.com.cn; Apache=1815807434750.124.1364777023467";
$r->addHeaders(array("Cookie" => $cookies_str));
$r -> send();
$subject = $r->getResponseBody();

$weiboInfo = array();

$weiboInfo['uid']=$uid;
$weiboInfo['url']=$url;
$weiboInfo['contents']=$subject;
//获取微博用户名
if (preg_match('/\[\'onick\'\] = \'([\w-\x{4e00}-\x{9fa5}]*)\'/u', $subject, $regs)) {
        $result = $regs[1];
    } else {
        $result = "未命名";
    }
$weiboInfo['uname'] = $result;


//获取微博粉丝数
if (preg_match('/node-type=\\\\"follow\\\\">((\d)*)</', $subject, $regs)) {
    $result = $regs[1];
} else {
    $result = "0";
}
$weiboInfo['follow'] = $result;

//获取微博关注数
if (preg_match('/node-type=\\\\"fans\\\\">((\d)*)</', $subject, $regs)) {
    $result = $regs[1];
} else {
    $result = "0";
}
$weiboInfo['fans'] = $result;


//获取微博微博数
if (preg_match('/node-type=\\\\"weibo\\\\">((\d)*)</', $subject, $regs)) {
    $result = $regs[1];
} else {
    $result = "0";
}
$weiboInfo['weibo'] = $result;


//获取个人描述
if (preg_match('/span class=\\\\"S_txt2\\\\" title=\\\\"([\w-\x{4e00}-\x{9fa5}\x{3002}\x{ff1b}\x{ff0c}\x{ff1a}\x{201c}\x{201d}\x{ff08}\x{ff09}\x{3001}\x{ff1f}\x{300a}\x{300b}]*)\\\\">/u', $subject, $regs)) {
        $result = $regs[1];
    } else {
        $result = "他还没有填写个人简介";
    }
$weiboInfo['describe'] = $result;


//获取标签
preg_match_all('/span class=\\\\"S_func1\\\\">([\w-\x{4e00}-\x{9fa5}]*)</u', $subject, $result, PREG_PATTERN_ORDER); 
$weiboInfo['label'] = $result[1];

//地理信息
if (preg_match('/loc=infsign\\\\" title=\\\\"([\w\s-\x{4e00}-\x{9fa5}]*)\\\\">/u', $subject, $regs)) {
            $result = $regs[1];
            } else {
            $result = "";
       }
$weiboInfo['geo'] = $result;

//教育信息
 if (preg_match('/loc=infedu\\\\" title=\\\\"([\w\s-\x{4e00}-\x{9fa5}]*)\\\\">/u', $subject, $regs)) {
            $result = $regs[1];
         } else {
            $result = "";
      }
$weiboInfo['edu'] = $result;




//获取用户近14篇微博内容
preg_match_all('%\Q<div class=\"WB_text\" \E(.*?)\Q<\/div>\n\t\t\t\t\t\t\E%', $subject, $result, PREG_PATTERN_ORDER);      
//去除转义字符
foreach ($result[0] as $key => $value) {
     $weiboInfo['weiboContent'][$key] = stripslashes($value);
     
  }


echo json_encode($weiboInfo);
//var_dump($weiboInfo);
// echo $htmlStr;
// $doc = new DOMDocument();
// @$doc->loadHTML($htmlStr);

// echo $doc -> saveHTML();

// echo "============";
// echo var_dump(json_decode($cookies_json,true))
?>
