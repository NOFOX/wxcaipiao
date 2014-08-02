<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\WechatMsg;
use app\models\CurlTool;
use app\models\Kaijiang;

class WechatController extends Controller
{

    //wechat message
    public function actionMessage()
    {
    	$wx = new WechatMsg();
    	$wx->msgInit();
    	if ($wx->getErrno() > 0)
    		return;
    	
    	$text = $wx->getText();
 		$caizhong = $periodicalno = '';
    	foreach (Kaijiang::$keyWordMap as $cz=>$czAlise){
    		$patt = implode('|', $czAlise);
			switch (true){
    			case preg_match("#^({$patt})$#", $text, $m):
    				$caizhong 	  = $cz;
    				break 2;
    			case preg_match("#^({$patt})(\d+)$#", $text, $m):
    				$caizhong 	  = $cz;
    				$periodicalno = $m[2];
    				break 2;
    		}
    	}
    	
    	if($caizhong)
    		$news_data = Kaijiang::fetchData($caizhong, $periodicalno);
    	else 
    		$news_data = Kaijiang::fetchHelp();
    	
    	//只回复图文消息
    	$wx->respNews($news_data);
    }
    
    
    //show kaijiang detail page
    public function actionDetail()
    {
    	$this->layout	= 'h5';
    	return $this->render('kaijiang');
    }
    
    //show kaijiang detail page
    public function actionHelp()
    {
    	$this->layout	= 'h5';
    	return $this->render('help');
    }
    
    //debug wechat message
    public function actionWxdbg()
    {
    	$timestamp = 'timesstr';
    	$nonce 	   = 'noncestr';
    	$token     = 'u09ikiomn6878';
    	
    	$tmpArr = array($token, $timestamp, $nonce);
    	sort($tmpArr, SORT_STRING);
    	$tmpStr = implode( $tmpArr );
    	$tmpStr = sha1( $tmpStr );
    	$signature = $tmpStr;
    	$text      = isset($_GET['text']) ? $_GET['text'] : '';
    	
    	$args = array(
    			'signature'=>$signature,
    			'nonce'	   =>$nonce,
    			'timestamp'=>$timestamp
    	);
    	$query_string = http_build_query($args);
    	$url = 'http://127.0.0.1/?r=wechat/message&'.$query_string; //@todo 不能写死
    	$request_xml = 
<<<EOT
<xml>
	<ToUserName><![CDATA[toUser]]></ToUserName>
	<FromUserName><![CDATA[fromUser]]></FromUserName>
	<CreateTime>1348831860</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[{$text}]]></Content>
	<MsgId>1234567890123456</MsgId>
</xml>
EOT;
    	
    	$ch = new CurlTool($url);
    	$ch->setPostString($request_xml);
    	$ret = $ch->getResult();
    	echo $ret;
    }
    
    

    
}
