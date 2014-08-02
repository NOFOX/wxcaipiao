<?php

namespace app\models;

class Kaijiang extends \yii\base\Object
{
	//todo，多关键词模糊查询
	public static $keyWordMap = [
		'ssq'	=> ['ssq','双色球'],
		'dlt'   => ['dlt','大乐透'],
		'sd'	=> ['sd','3D','3d'],
		'pls'	=> ['pls','排列3','排列三','排3','排三'],
		'plw'	=> ['plw','排列5','排列五','排5','排五'],
		'qxc'	=> ['qxc','七星彩','7星彩'],
		'eexw'  => ['eexw','22选5']
	];
	public static $site_url = 'http://203.195.153.124'; //FIXME  不放在这
	
	
	public static function fetchHelp()
	{
		return [
			[
				'title' 	  =>	'操作指示',
				'description' => 	'输入双色球、大乐透、双色球14087试试',
				'picurl'	  => 	self::$site_url."/img/logo.jpg",	//url暂时写死
				'url'		  =>	self::$site_url.'/?r=wechat/help'
			]
		];
	}
	
	
	public static function fetchData($caizhong, $periodicalno)
	{
		$method  = 'fetchData'.ucfirst($caizhong);
		$data    =  self::$method($periodicalno);
		//@todo cache result
		return  $data;
	}
	
	
	//ssq
	public static function fetchDataSsq($periodicalno)
	{
		
		$data = [
			[
				'title' 	  =>	'双色球第14087期开奖号码：06,18,22,23,32,33|06',
				'description' => 	'一等奖：6注，每注8,003,802元；二等奖89注，每注253,129元；三等奖1319注，每注3,000元',
				'picurl'	  => 	self::$site_url."/img/lot_ssq.jpg",	//url暂时写死
				'url'		  =>	self::$site_url.'/?r=wechat/detail'
			]
		];
		
		return $data;
		
		/*
		$text  = "双色球第{$result['periodicalno']}期开奖结果：".PHP_EOL;
		$text .= "红球：{$result['redresult']}".PHP_EOL;
		$text .= "蓝球：{$result['blueresult']}".PHP_EOL;
		$text .= "出球顺序：{$result['outball']}".PHP_EOL;
		$text .= "一等每注：".number_format($result['money1'])."元".PHP_EOL;
		$text .= "一等注数：{$result['num1']}注".PHP_EOL;
		$text .= "二等每注：".number_format($result['money2'])."元".PHP_EOL;
		$text .= "二等注数：{$result['num2']}注".PHP_EOL;
		$text .= $result['isoutmoney'] == 1 ? '已算奖' : '暂未算奖';
		$text .= PHP_EOL;
		$info   = json_decode($result['info'],true);
		$tidian = $info['tidian'];
		$tidian_text = "小帮提点：".PHP_EOL;
		foreach ($tidian as $t) {
			$tidian_text .= $t.PHP_EOL;
		}
		return $text.PHP_EOL.$tidian_text;
		*/
	}
	
	
	//dlt
	public static function fetchDataDlt()
	{
		
		$data = [
			[
				'title' 	  =>	'大乐透第14088期开奖号码：07,13,20,25,26|08,11',
				'description' => 	'一等奖（基本）：3注，每注10,000,000元；一等奖（追加）：1注，每注6,000,000元；二等奖（基本）：108注，每注80,866元；二等奖（追加）：13注，每注48,519元',
				'picurl'	  => 	self::$site_url."/img/lot_dlt.jpg",	//url暂时写死
				'url'		  =>	self::$site_url.'/?r=wechat/detail'
			]
		];
		
		
		return $data;
		
		/*
		$result = $this->db
		->select()
		->from('expect_dlt')
		->order_by('periodicalno','DESC')
		->limit(1)
		->get()
		->first_row();
		$result = (array) $result;
	
		$text  = "大乐透第{$result['periodicalno']}期开奖结果：".PHP_EOL;
		$text .= "前区：{$result['foreresult']}".PHP_EOL;
		$text .= "后区：{$result['backresult']}".PHP_EOL;
		$text .= "出球顺序：{$result['outball']}".PHP_EOL;
		$text .= "一等基本每注：".number_format($result['basemoney1'])."元".PHP_EOL;
		$text .= "一等基本注数：{$result['basenum1']}注".PHP_EOL;
		$text .= "一等追加每注：".number_format($result['additionmoney1'])."元".PHP_EOL;
		$text .= "一等追加注数：{$result['additionnum1']}注".PHP_EOL;
		$text .= "二等基本每注：".number_format($result['basemoney2'])."元".PHP_EOL;
		$text .= "二等基本注数：{$result['basenum2']}注".PHP_EOL;
		$text .= "二等追加每注：".number_format($result['additionmoney2'])."元".PHP_EOL;
		$text .= "二等追加注数：{$result['additionnum2']}注".PHP_EOL;
		$text .= $result['isoutmoney'] == 1 ? '已算奖' : '暂未算奖';
		$text .= PHP_EOL;
		$info   = json_decode($result['info'],true);
		$tidian = $info['tidian'];
		$tidian_text = "小帮提点：".PHP_EOL;
		foreach ($tidian as $t) {
			$tidian_text .= $t.PHP_EOL;
		}
		return $text.PHP_EOL.$tidian_text;
		*/
		
	}
	
	
	/**
	 * 获取排列三开奖信息
	 */
	public static function fetchDataPls($periodicalno)
	{
		$result = $this->db
					->select()
					->from('expect_pls')
					->order_by('periodicalno','DESC')
					->limit(1)
					->get()
					->first_row();
		$result = (array) $result;		
		$zxtype = $result['zuxuantype'] == 'z3' ? '三' : '六';
		$zxnum  = $result['zuxuantype'] == 'z3' ? '2' : '3';		
		$text  = "排列三第{$result['periodicalno']}期开奖结果：".PHP_EOL;
    	$text .= "开奖号码：{$result['result']}".PHP_EOL;
    	$text .= "直选每注：".number_format($result['money1'])."元".PHP_EOL;
    	$text .= "直选注数：{$result['num1']}注".PHP_EOL;
    	$text .= "组{$zxtype}每注：".number_format($result['money'.$zxnum])."元".PHP_EOL;
    	$text .= "组{$zxtype}注数：{$result['num'.$zxnum]}注".PHP_EOL;
    	$text .= $result['isoutmoney'] == 1 ? '已算奖' : '暂未算奖';
    	return $text;
	}
	
	/**
	 * 获取排列五开奖信息
	 */
	public static function get_plw_latest_kj()
	{
		$result = $this->db
					->select()
					->from('expect_plw')
					->order_by('periodicalno','DESC')
					->limit(1)
					->get()
					->first_row();
		$result = (array) $result;		
		$text  = "排列五第{$result['periodicalno']}期开奖结果：".PHP_EOL;
    	$text .= "开奖号码：{$result['result']}".PHP_EOL;
    	$text .= "一等每注：".number_format($result['money1'])."元".PHP_EOL;
    	$text .= "一等注数：{$result['num1']}注".PHP_EOL;
    	$text .= $result['isoutmoney'] == 1 ? '已算奖' : '暂未算奖';    	
    	return $text;	
	}
	
	
	
	
	

	/**
	 * 获取福彩3D开奖信息
	 */
	public static function get_sd_latest_kj()
	{
		$result = $this->db
					->select()
					->from('expect_sd')
					->order_by('periodicalno','DESC')
					->limit(1)
					->get()
					->first_row();
		$result = (array) $result;		
		$zxword = $result['zuxuantype'] == 'z3' ? '三' : '六';
		$zxnum  = $result['zuxuantype'] == 'z3' ? '2' : '3';		
		$text  = "福彩3D第{$result['periodicalno']}期开奖结果：".PHP_EOL;
    	$text .= "开奖号码：{$result['result']}".PHP_EOL;
    	$text .= "直选每注：".number_format($result['money1'])."元".PHP_EOL;
    	$text .= "直选注数：{$result['num1']}注".PHP_EOL;
    	$text .= "组选{$zxword}每注：".number_format($result['money'.$zxnum])."元".PHP_EOL;
    	$text .= "组选{$zxword}注数：{$result['num'.$zxnum]}注".PHP_EOL;
    	$text .= $result['isoutmoney'] == 1 ? '已算奖' : '暂未算奖';
    	$text .= PHP_EOL;   	
    	return $text;
	}
	
	
	/**
	 * 获取七星彩开奖信息
	 */
	public static function get_qxc_latest_kj()
	{
		$result = $this->db
					->select()
					->from('expect_qxc')
					->order_by('periodicalno','DESC')
					->limit(1)
					->get()
					->first_row();
		$result = (array) $result;	
		$text  = "七星彩第{$result['periodicalno']}期开奖结果：".PHP_EOL;
    	$text .= "开奖号码：{$result['result']}".PHP_EOL;
    	$text .= "一等每注：".number_format($result['money1'])."元".PHP_EOL;
    	$text .= "一等注数：{$result['num1']}注".PHP_EOL;
    	$text .= "二等每注：".number_format($result['money2'])."元".PHP_EOL;
    	$text .= "二等注数：{$result['num2']}注".PHP_EOL;
    	$text .= "三等每注：".number_format($result['money3'])."元".PHP_EOL;
    	$text .= "三等注数：{$result['num3']}注".PHP_EOL;
    	$text .= $result['isoutmoney'] == 1 ? '已算奖' : '暂未算奖';
    	$text .= PHP_EOL; 	
    	return $text.PHP_EOL;	
	}

	/**
	 * 获取22选5开奖信息
	 */
	public static function get_eexw_latest_kj()
	{
		$result = $this->db
					->select()
					->from('expect_eexw')
					->order_by('periodicalno','DESC')
					->limit(1)
					->get()
					->first_row();
		$result = (array) $result;		
		$text  = "22选5第{$result['periodicalno']}期开奖结果：".PHP_EOL;
    	$text .= "开奖号码：{$result['result']}".PHP_EOL;
    	$text .= "一等每注：".number_format($result['money1'])."元".PHP_EOL;
    	$text .= "一等注数：{$result['num1']}注".PHP_EOL;
    	$text .= "二等每注：".number_format($result['money2'])."元".PHP_EOL;
    	$text .= "二等注数：{$result['num2']}注".PHP_EOL;
    	$text .= "三等每注：".number_format($result['money3'])."元".PHP_EOL;
    	$text .= "三等注数：{$result['num3']}注".PHP_EOL;
    	$text .= $result['isoutmoney'] == 1 ? '已算奖' : '暂未算奖';
    	$text .= PHP_EOL;
    	return $text.PHP_EOL;	
	}
	
	/**
	 * 更新开奖数据
	 * @param array $data
	 * @param string $table
	 */
	public function updateKaijiang($data, $table)
	{
		try
		{
			return $this->db->where('periodicalno', $data['periodicalno'])->replace($table, $data);
		}
		catch (Exception $e)
		{
			var_dump($e->getMessage());
		}
	}
	
	
}
