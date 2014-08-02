<?php 

namespace app\models;

class CurlTool extends \yii\base\Object
{
	
	private $url;
	private $args;
	private $type;
	private $options = array(
	    CURLOPT_HEADER 			=> false,
	    CURLOPT_RETURNTRANSFER  => true,
	    CURLOPT_FOLLOWLOCATION	=> true,
	    CURLOPT_TIMEOUT			=> 30
	);
	
	function __construct($url, $args = array(), $type = 'get')
	{
		$this->url 	= $url;
		$this->args	= $args;
		$this->type = $type;
	}
	
	public function setOpt($opts)
	{
		foreach ($opts as $opt=>$value){
			$this->options[$opt] = $value;
		}
	}
	
	public function setFakeIp($ip = '')
	{
		if ( !$ip )
		{
			$ip = rand(1,255).".".rand(1,255).".".rand(1,255).".".rand(1,255);
		}
		$this->options[CURLOPT_HTTPHEADER]['CLIENT-IP'] 	  = $ip;
		$this->options[CURLOPT_HTTPHEADER]['X-FORWARDED-FOR'] = $ip;
	}
	
	public function setRerfer($ref = '')
	{
		if ( !$ref )
		{
			$ref = $this->url;
		}
		$this->options[CURLOPT_HTTPHEADER]['Referer'] = $ref;
	}
	
	public function setAgent($agent = '')
	{
		if ( !$agent )
		{
			$agent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)';
		}
		$this->options[CURLOPT_HTTPHEADER]['User-Agent'] = $agent;
	}
	
	public function setCookie($cookie = '')
	{
		$this->options[CURLOPT_HTTPHEADER]['Cookie']	= $cookie;
	}
	
	public function setPostArray($arr)
	{
		$this->options[CURLOPT_POST] 		= true;
		$this->options[CURLOPT_POSTFIELDS]	= $arr;
	}
	
	public function setPostString($str)
	{
		$this->options[CURLOPT_POSTFIELDS]					= $str;
		$this->options[CURLOPT_HTTPHEADER]['Content-Type']	= 'text/xml';
		$this->options[CURLOPT_POST] 						= true;
		
	}
	
	public function setSSL()
	{
		$this->options[CURLOPT_SSL_VERIFYPEER] = false;
		$this->options[CURLOPT_SSL_VERIFYHOST] = false;
	}
	
	public function getResult()
	{
		$ch = curl_init($this->url);
		curl_setopt_array($ch, $this->options);
		$body = curl_exec($ch);
		curl_close($ch);
		return $body;
	}
	
}


