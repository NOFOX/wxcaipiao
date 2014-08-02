<?php

namespace app\models;

use Yii;

class WechatMsg extends \yii\base\Object
{
	private $errno = 0;
	private $token = 'u09ikiomn6878';
	private $mpUserId;
	private $reqUserId;
	private $reqMsgType;				
	private $reqText;
	

    public function msgInit() {
    	$requestStr = file_get_contents('php://input');
    	Yii::info('Request data,'.json_encode($_GET).','.json_encode($requestStr));
    	if(!$this->checkSignature()){
    		Yii::info("CheckSignature Fail,".json_encode($_GET));
    		$this->errno = 10001;
    		return;
    	}
    	//wechat server verify
    	if (isset($_GET['echostr'])) {
    		echo $_GET['echostr'];
    		$this->errno = 10000;
    		return;
    	}
    	if (!$this->parseRequest($requestStr))
    		$this->errno = 10002;
    	return;
    }
    
    public function getErrno() { return $this->errno; }
    public function getText() { return $this->reqText; }

    /**
     * parse request xml
     * @param unknown_type $requestStr
     */
    private function parseRequest($requestStr) {
    	try
    	{
	    	$reqObj     		= simplexml_load_string($requestStr, 'SimpleXMLElement', LIBXML_NOCDATA);
	    	$this->mpUserId		= (string)$reqObj->ToUserName;
	    	$this->reqUserId	= (string)$reqObj->FromUserName;
	    	$this->reqMsgType   = (string)$reqObj->MsgType;
	    	$this->reqText = $this->reqMsgType == 'text' ? trim((string)$reqObj->Content) : '';
    	}
    	catch (Exception $e)
    	{
    		Yii::info("parseRequest Fail,".$e->getMessage());
    		return false;
    	}
    	return true;
    }
    
    
    /**
     * generate text
     * @param  array $data
     * @return string 
     */
    public function respText($data){
    	$xml =
    	"<xml>
    	<ToUserName><![CDATA[{$this->reqUserId}]]></ToUserName>
    	<FromUserName><![CDATA[{$this->mpUserId}]]></FromUserName>
    	<CreateTime>".time()."</CreateTime>
    	<MsgType><![CDATA[text]]></MsgType>
    	<Content><![CDATA[{$data['content']}]]></Content>
    	</xml>";
    	Yii::info('[RespText]'.json_encode($xml));
    	ob_end_clean();
		echo $xml;
    }
    

    /**
     * generate news
	 * @param  array $data
	 * @return string
	 */
	public function respNews($data){
		$xml = 
		"<xml>
			 <ToUserName><![CDATA[{$this->reqUserId}]]></ToUserName>
			 <FromUserName><![CDATA[{$this->mpUserId}]]></FromUserName>
			 <CreateTime>".time()."</CreateTime>
			 <MsgType><![CDATA[news]]></MsgType>
			 <ArticleCount>".count($data)."</ArticleCount>
			 <Articles>";
		
		foreach ($data as $item){
			$xml .= 
			"	<item>
					<Title><![CDATA[{$item['title']}]]></Title> 
			 		<Description><![CDATA[{$item['description']}]]></Description>
			 		<PicUrl><![CDATA[{$item['picurl']}]]></PicUrl>
			 		<Url><![CDATA[{$item['url']}]]></Url>
			 	</item>";		
		}
		$xml .=	
		"	</Articles>
		</xml>";	
		Yii::info('[RespNews]'.json_encode($xml));
		ob_end_clean();
		echo $xml;
	}

    
    private function checkSignature()
    {
    	$signature = isset($_GET["signature"]) ? $_GET["signature"] : '';
    	$timestamp = isset($_GET["timestamp"]) ? $_GET["timestamp"] : '';
    	$nonce 	   = isset($_GET["nonce"]) ? $_GET["nonce"] : '';
    
    	$tmpArr = array($this->token, $timestamp, $nonce);
    	sort($tmpArr, SORT_STRING);
    	$tmpStr = implode( $tmpArr );
    	$tmpStr = sha1( $tmpStr );
    	return $tmpStr == $signature ? true : false;
    }
    
	
    
    
}
