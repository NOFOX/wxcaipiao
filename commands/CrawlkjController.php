<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\Kaijiang;
use app\models\CurlTool;
use Yii;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CrawlkjController extends Controller
{
	//'http://zx.500.com/static/info/kaijiang/xml/ssq/14081.xml'
	const SSQ_OPEN_XML = 'http://zx.500.com/static/info/kaijiang/xml/ssq/index.xml';
	const DLT_OPEN_XML = 'http://zx.500.com/static/info/kaijiang/xml/dlt/index.xml';
	const PLS_OPEN_XML = 'http://zx.500.com/static/info/kaijiang/xml/pls/index.xml';
	const PLW_OPEN_XML = 'http://zx.500.com/static/info/kaijiang/xml/plw/index.xml';
	const SD_OPEN_XML  = 'http://zx.500.com/static/info/kaijiang/xml/sd/index.xml';
	const QXC_OPEN_XML = 'http://zx.500.com/static/info/kaijiang/xml/qxc/index.xml';
	const EEXW_OPEN_XML= 'http://zx.500.com/static/info/kaijiang/xml/eexw/index.xml';
	
    public function actionIndex()
    {
        foreach (array_keys(Kaijiang::$keyWordMap) as $v){
        	$this->$v();
        	echo $v, " has been crawled!\n";
        }
    }
        
    public function ssq()
    {
    	$xml = $this->get_xml(self::SSQ_OPEN_XML);
    	if ( ! $xml )
	    	return false;
    	
    	$data = json_decode(json_encode($xml), true);
    	$info = array(
    			'redfx'  => $data['RedFX']['@attributes'],
    			'bluefx' => $data['BlueFX']['@attributes'],
    			'tidian' => $data['TiDian']['@attributes']
    	);
    	$istdata = array(
    			'periodicalno' => $data['PeriodicalNO'],
    			'redresult'    => $data['RedResult'],
    			'outball' 	   => $data['OutBall'],
    			'blueresult'   => $data['BlueResult'],
    			'resulttime'   => strtotime($data['ResultTime']),
    			'encashtime'   => strtotime($data['EncashTime']),
    			'money1'  	   => str_replace(',', '', $data['Money1']),
    			'num1'         => str_replace(',', '', $data['Num1']),
    			'money2'       => str_replace(',', '', $data['Money2']),
    			'num2'         => str_replace(',', '', $data['Num2']),
    			'money3'       => str_replace(',', '', $data['Money3']),
    			'num3'         => str_replace(',', '', $data['Num3']),
    			'money4'       => str_replace(',', '', $data['Money4']),
    			'num4'         => str_replace(',', '', $data['Num4']),
    			'money5'       => str_replace(',', '', $data['Money5']),
    			'num5'         => str_replace(',', '', $data['Num5']),
    			'money6'       => str_replace(',', '', $data['Money6']),
    			'num6'         => str_replace(',', '', $data['Num6']),
    			'totalmoney'   => str_replace(',', '', $data['TotalMoney']),
    			'ccmoney'      => str_replace(',', '', $data['CCMoney']),
    			'isoutmoney'   => $data['IsOutMoney'],
    			'info'		   => json_encode($info)
    	);
    	Kaijiang::updateKaijiang($istdata, 'expect_ssq');
    }
    
    
    public function pls()
    {
    	$xml = $this->get_xml(self::PLS_OPEN_XML);
    	if ( ! $xml )
	    	return false;
    	$data = json_decode(json_encode($xml), true);
    	$info = array(
    			'fenxi'  => $data['FenXi']['@attributes']
    	);
    	$istdata = array(
    			'periodicalno' => $data['PeriodicalNO'],
    			'result'       => $data['Result'],
    			'resulttime'   => strtotime($data['ResultTime']),
    			'encashtime'   => strtotime($data['EncashTime']),
    			'money1'  	   => str_replace(',', '', $data['Money1']),
    			'num1'         => str_replace(',', '', $data['Num1']),
    			'money2'       => str_replace(',', '', $data['Money2']),
    			'num2'         => str_replace(',', '', $data['Num2']),
    			'money3'       => str_replace(',', '', $data['Money3']),
    			'num3'         => str_replace(',', '', $data['Num3']),
    			'zuxuantype'   => $data['ZuxuanType'],
    			'totalmoney'   => str_replace(',', '', $data['TotalMoney']),
    			'ccmoney'      => str_replace(',', '', $data['CCMoney']),
    			'isoutmoney'   => $data['IsOutMoney'],
    			'info'		   => json_encode($info)
    	);
    	Kaijiang::updateKaijiang($istdata, 'expect_pls');
    }
    
     
    /**
     * 排列五
     */
    public function plw()
    {
    	$xml = $this->get_xml(self::PLW_OPEN_XML);
    	if ( ! $xml )
	    	return false;
    	$data = json_decode(json_encode($xml), true);
    	$istdata = array(
    			'periodicalno' => $data['PeriodicalNO'],
    			'result'       => $data['Result'],
    			'resulttime'   => strtotime($data['ResultTime']),
    			'encashtime'   => strtotime($data['EncashTime']),
    			'money1'  	   => str_replace(',', '', $data['Money1']),
    			'num1'         => str_replace(',', '', $data['Num1']),
    			'totalmoney'   => str_replace(',', '', $data['TotalMoney']),
    			'ccmoney'      => str_replace(',', '', $data['CCMoney']),
    			'isoutmoney'   => $data['IsOutMoney']
    	);
    	Kaijiang::updateKaijiang($istdata, 'expect_plw');
    }
    
    
    
    /**
     * 大乐透
     */
    public function dlt()
    {
    	$xml = $this->get_xml(self::DLT_OPEN_XML);
    	if ( ! $xml )
	    	return false;
    
    	$data = json_decode(json_encode($xml), true);
    	$info = array(
    			'forefx'  => $data['ForeFX']['@attributes'],
    			'backfx ' => $data['BackFX']['@attributes'],
    			'tidian' => $data['TiDian']['@attributes']
    	);
    	$istdata = array(
    			'periodicalno' =>$data['PeriodicalNO'],
    			'foreresult' 	=>$data['ForeResult'],
    			'outball'		=>$data['OutBall'],
    			'backresult'	=>$data['BackResult'],
    			'resulttime'	=> strtotime($data['ResultTime']),
    			'encashtime'	=> strtotime($data['EncashTime']),
    			'money1'		=>str_replace(',', '', $data['Money1']),
    			'num1'			=>str_replace(',', '', $data['Num1']),
    			'basemoney1'	=>str_replace(',', '', $data['BaseMoney1']),
    			'basenum1'		=>str_replace(',', '', $data['BaseNum1']),
    			'additionmoney1'=>str_replace(',', '', $data['AdditionMoney1']),
    			'additionnum1'	=>str_replace(',', '', $data['AdditionNum1']),
    			'money2'		=>str_replace(',', '', $data['Money2']),
    			'num2'			=>str_replace(',', '', $data['Num2']),
    			'basemoney2'	=>str_replace(',', '', $data['BaseMoney2']),
    			'basenum2'		=>str_replace(',', '', $data['BaseNum2']),
    			'additionmoney2'=>str_replace(',', '', $data['AdditionMoney2']),
    			'additionnum2'	=>str_replace(',', '', $data['AdditionNum2']),
    			'money3'		=>str_replace(',', '', $data['Money3']),
    			'num3'			=>str_replace(',', '', $data['Num3']),
    			'basemoney3'	=>str_replace(',', '', $data['BaseMoney3']),
    			'basenum3'		=>str_replace(',', '', $data['BaseNum3']),
    			'additionmoney3'=>str_replace(',', '', $data['AdditionMoney3']),
    			'additionnum3'	=>str_replace(',', '', $data['AdditionNum3']),
    			'money4'		=>str_replace(',', '', $data['Money4']),
    			'num4'			=>str_replace(',', '', $data['Num4']),
    			'basemoney4'	=>str_replace(',', '', $data['BaseMoney4']),
    			'basenum4'		=>str_replace(',', '', $data['BaseNum4']),
    			'additionmoney4'=>str_replace(',', '', $data['AdditionMoney4']),
    			'additionnum4'	=>str_replace(',', '', $data['AdditionNum4']),
    			'money5'		=>str_replace(',', '', $data['Money5']),
    			'num5'			=>str_replace(',', '', $data['Num5']),
    			'basemoney5'	=>str_replace(',', '', $data['BaseMoney5']),
    			'basenum5'		=>str_replace(',', '', $data['BaseNum5']),
    			'additionmoney5'=>str_replace(',', '', $data['AdditionMoney5']),
    			'additionnum5'	=>str_replace(',', '', $data['AdditionNum5']),
    			'money6'		=>str_replace(',', '', $data['Money6']),
    			'num6'			=>str_replace(',', '', $data['Num6']),
    			'basemoney6'	=>str_replace(',', '', $data['BaseMoney6']),
    			'basenum6'		=>str_replace(',', '', $data['BaseNum6']),
    			'additionmoney6'=>str_replace(',', '', $data['AdditionMoney6']),
    			'additionnum6'	=>str_replace(',', '', $data['AdditionNum6']),
    			'money7'		=>str_replace(',', '', $data['Money7']),
    			'num7'			=>str_replace(',', '', $data['Num7']),
    			'basemoney7'	=>str_replace(',', '', $data['BaseMoney7']),
    			'basenum7'		=>str_replace(',', '', $data['BaseNum7']),
    			'additionmoney7'=>str_replace(',', '', $data['AdditionMoney7']),
    			'additionnum7'	=>str_replace(',', '', $data['AdditionNum7']),
    			'money8'		=>str_replace(',', '', $data['Money8']),
    			'num8'			=>str_replace(',', '', $data['Num8']),
    			'sexemoney1'	=>str_replace(',', '', $data['SEXEMoney1']),
    			'sexenum1'		=>str_replace(',', '', $data['SEXENum1']),
    			'totalmoney'	=>str_replace(',', '', $data['TotalMoney']),
    			'ccmoney'		=>str_replace(',', '', $data['CCMoney']),
    			'addccmoney'	=>str_replace(',', '', $data['AddCCMoney']),
    			'sexetotalmoney'=>str_replace(',', '', $data['SEXETotalMoney']),
    			'isoutmoney'	=>$data['IsOutMoney'],
    			'info'		 	=> json_encode($info)
    	);
    	Kaijiang::updateKaijiang($istdata, 'expect_dlt');
    }
    
    /**
     * 3D开奖号码拉取
     */
    public function sd()
    {
    	$xml = $this->get_xml(self::SD_OPEN_XML);
    	if ( ! $xml )
	    	return false;
    	$data = json_decode(json_encode($xml), true);
    	$info = array(
    			'fenxi'  => $data['FenXi']['@attributes'],
    	);
    	$istdata = array(
    			'periodicalno' => $data['PeriodicalNO'],
    			'result'       => $data['Result'],
    			'resulttime'   => strtotime($data['ResultTime']),
    			'encashtime'   => strtotime($data['EncashTime']),
    			'money1'  	   => str_replace(',', '', $data['Money1']),
    			'num1'         => str_replace(',', '', $data['Num1']),
    			'money2'  	   => str_replace(',', '', $data['Money2']),
    			'num2'         => str_replace(',', '', $data['Num2']),
    			'money3'  	   => str_replace(',', '', $data['Money3']),
    			'num3'         => str_replace(',', '', $data['Num3']),
    			'zuxuantype'   => $data['ZuxuanType'],
    			'totalmoney'   => str_replace(',', '', $data['TotalMoney']),
    			'ccmoney'      => str_replace(',', '', $data['CCMoney']),
    			'isoutmoney'   => $data['IsOutMoney'],
    			'info'		   => json_encode($info)
    	);
    	Kaijiang::updateKaijiang($istdata, 'expect_sd');
    }
    
    /**
     * 七星彩
     */
    public function qxc()
    {
    	$xml = $this->get_xml(self::QXC_OPEN_XML);
    	if ( ! $xml )
	    	return false;
    	$data = json_decode(json_encode($xml), true);
    
    	$istdata = array(
    			'periodicalno' => $data['PeriodicalNO'],
    			'result'    => $data['Result'],
    			'resulttime'   => strtotime($data['ResultTime']),
    			'encashtime'   => strtotime($data['EncashTime']),
    			'money1'  	   => str_replace(',', '', $data['Money1']),
    			'num1'         => str_replace(',', '', $data['Num1']),
    			'money2'       => str_replace(',', '', $data['Money2']),
    			'num2'         => str_replace(',', '', $data['Num2']),
    			'money3'       => str_replace(',', '', $data['Money3']),
    			'num3'         => str_replace(',', '', $data['Num3']),
    			'money4'       => str_replace(',', '', $data['Money4']),
    			'num4'         => str_replace(',', '', $data['Num4']),
    			'money5'       => str_replace(',', '', $data['Money5']),
    			'num5'         => str_replace(',', '', $data['Num5']),
    			'money6'       => str_replace(',', '', $data['Money6']),
    			'num6'         => str_replace(',', '', $data['Num6']),
    			'totalmoney'   => str_replace(',', '', $data['TotalMoney']),
    			'ccmoney'      => str_replace(',', '', $data['CCMoney']),
    			'isoutmoney'   => $data['IsOutMoney']
    	);
    	Kaijiang::updateKaijiang($istdata, 'expect_qxc');
    }
    
    /**
     * 22选5开奖号码拉取
     */
    public function eexw()
    {
    	$xml = $this->get_xml(self::EEXW_OPEN_XML);
    	if ( ! $xml )
	    	return false;
    	$data = json_decode(json_encode($xml), true);
    
    	$istdata = array(
    			'periodicalno' => $data['PeriodicalNO'],
    			'result'       => $data['Result'],
    			'outball'      => $data['OutBall'],
    			'resulttime'   => strtotime($data['ResultTime']),
    			'encashtime'   => strtotime($data['EncashTime']),
    			'money1'  	   => str_replace(',', '', $data['Money1']),
    			'num1'         => str_replace(',', '', $data['Num1']),
    			'money2'  	   => str_replace(',', '', $data['Money2']),
    			'num2'         => str_replace(',', '', $data['Num2']),
    			'money3'  	   => str_replace(',', '', $data['Money3']),
    			'num3'         => str_replace(',', '', $data['Num3']),
    			'totalmoney'   => str_replace(',', '', $data['TotalMoney']),
    			'ccmoney'      => str_replace(',', '', $data['CCMoney']),
    			'isoutmoney'   => $data['IsOutMoney']
    	);
    	Kaijiang::updateKaijiang($istdata, 'expect_eexw');
    }
    
    //get remote xml content
    private function get_xml($xml_url)
    {
    	$ch = new CurlTool($xml_url);
    	$xml_string = $ch->getResult();
    	$xml = @simplexml_load_string($xml_string);
    	if (!$xml)
    		Yii::info("getXml fail, url ".$xml_url);
    	return $xml;
    }
}
