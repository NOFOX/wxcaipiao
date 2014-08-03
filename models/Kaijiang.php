<?php

namespace app\models;
use Yii;

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
				'title' 	  =>	'操作提示',
				'description' => 	'输入双色球、大乐透、双色球14087、3d、七星彩、排列3试试',
				'picurl'	  => 	self::$site_url."/img/logo.jpg",
				'url'		  =>	self::$site_url.'/?r=wechat/help'
			]
		];
	}
	
	
	public static function fetchData($caizhong, $periodicalno)
	{
		$method  = 'fetchData'.ucfirst($caizhong);
		$data    =  self::$method($periodicalno);
		return  $data;
	}
	
	public static function fetchDetail($caizhong, $periodicalno)
	{
		if ($periodicalno)
		{
			$sql = "select * from expect_{$caizhong} where periodicalno = {$periodicalno}";
		}
		else
		{
			$sql = "select * from expect_{$caizhong} order by periodicalno desc limit 1";
		}
		$row = Yii::$app->db->createCommand($sql)->queryOne();
		//@todo cache result
		return  $row;
	}
	
	//ssq
	public static function fetchDataSsq($periodicalno)
	{
		$row = self::fetchDetail('ssq',$periodicalno);
		//@todo 使用消息模板
		$data = 
		[
			[
			'title' 	  => "双色球第{$row['periodicalno']}期开奖号码：{$row['redresult']}|{$row['blueresult']}",
			'description' => "一等奖：{$row['num1']}注，每注{$row['money1']}元；二等奖{$row['num2']}注，每注{$row['money2']}元；三等奖{$row['num3']}注，每注{$row['money3']}元",
			'picurl'	  => self::$site_url."/img/lot_ssq.jpg",
			'url'		  => self::$site_url."/?r=wechat/detail&cz=ssq&periodicalno={$row['periodicalno']}"
			]
		];
		return $data;
	}
	
	
	//dlt
	public static function fetchDataDlt($periodicalno)
	{
		$row = self::fetchDetail('dlt',$periodicalno);
		$data =
		[
			[
			'title' 	  => "大乐透第{$row['periodicalno']}期开奖号码：{$row['foreresult']}|{$row['backresult']}",
			'description' => "一等奖（基本）：{$row['basenum1']}注，每注{$row['basemoney1']}元；一等奖（追加）：{$row['additionnum1']}注，每注{$row['additionmoney1']}元；二等奖（基本）：{$row['basenum2']}注，每注{$row['basemoney2']}元；二等奖（追加）：{$row['additionnum2']}注，每注{$row['additionmoney2']}元",
			'picurl'	  => self::$site_url."/img/lot_dlt.jpg",
			'url'		  => self::$site_url."/?r=wechat/detail&cz=dlt&periodicalno={$row['periodicalno']}"
			]
		];
		return $data;
	}
	
	
	//pls
	public static function fetchDataPls($periodicalno)
	{
		$row = self::fetchDetail('pls',$periodicalno);
		$data =
		[
			[
			'title' 	  => "排列3第{$row['periodicalno']}期开奖号码：{$row['result']}",
			'description' => "一等奖：{$row['num1']}注，每注{$row['money1']}元；二等奖{$row['num2']}注，每注{$row['money2']}元；三等奖{$row['num3']}注，每注{$row['money3']}元",
			'picurl'	  => self::$site_url."/img/lot_pls.jpg",
			'url'		  => self::$site_url."/?r=wechat/detail&cz=pls&periodicalno={$row['periodicalno']}"
			]
		];
		return $data;
	}
	
	//plw
	public static function fetchDataPlw($periodicalno)
	{
		$row = self::fetchDetail('plw',$periodicalno);
		$data =
		[
			[
			'title' 	  => "排列5第{$row['periodicalno']}期开奖号码：{$row['result']}",
			'description' => "一等奖：{$row['num1']}注，每注{$row['money1']}元",
			'picurl'	  => self::$site_url."/img/lot_plw.jpg",
			'url'		  => self::$site_url."/?r=wechat/detail&cz=plw&periodicalno={$row['periodicalno']}"
			]
		];
		return $data;
	}
	

	//sd
	public static function fetchDataSd($periodicalno)
	{
		$row = self::fetchDetail('sd',$periodicalno);
		$data =
		[
			[
			'title' 	  => "3D第{$row['periodicalno']}期开奖号码：{$row['result']}",
			'description' => "一等奖：{$row['num1']}注，每注{$row['money1']}元；二等奖{$row['num2']}注，每注{$row['money2']}元；三等奖{$row['num3']}注，每注{$row['money3']}元",
			'picurl'	  => self::$site_url."/img/lot_sd.jpg",
			'url'		  => self::$site_url."/?r=wechat/detail&cz=sd&periodicalno={$row['periodicalno']}"
			]
		];
		return $data;
	}
	
	
	//qxc
	public static function fetchDataQxc()
	{
		$row = self::fetchDetail('qxc',$periodicalno);
		$data =
		[
			[
			'title' 	  => "七星彩第{$row['periodicalno']}期开奖号码：{$row['result']}",
			'description' => "一等奖：{$row['num1']}注，每注{$row['money1']}元；二等奖{$row['num2']}注，每注{$row['money2']}元；三等奖{$row['num3']}注，每注{$row['money3']}元",
			'picurl'	  => self::$site_url."/img/lot_qxc.jpg",
			'url'		  => self::$site_url."/?r=wechat/detail&cz=qxc&periodicalno={$row['periodicalno']}"
			]
		];
		return $data;
	}

	//eexw
	public static function fetchDataEexw()
	{
		$row = self::fetchDetail('eexw',$periodicalno);
		$data =
		[
			[
			'title' 	  => "22选5第{$row['periodicalno']}期开奖号码：{$row['result']}",
			'description' => "一等奖：{$row['num1']}注，每注{$row['money1']}元；二等奖{$row['num2']}注，每注{$row['money2']}元；三等奖{$row['num3']}注，每注{$row['money3']}元",
			'picurl'	  => self::$site_url."/img/lot_eexw.jpg",
			'url'		  => self::$site_url."/?r=wechat/detail&cz=eexw&periodicalno={$row['periodicalno']}"
			]
		];
		return $data;	
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
			//@todo 事务回滚
			Yii::$app->db->createCommand()->delete($table, 'periodicalno = '.$data['periodicalno'])->execute();
			Yii::$app->db->createCommand()->insert($table, $data)->execute();
		}
		catch (Exception $e)
		{
			var_dump($e->getMessage());
			Yii::info("update db fail, table ".$table." ".$e->getMessage());
		}
	}
	
	
}
