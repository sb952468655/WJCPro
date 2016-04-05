<?php
load_class('TMIS_TableDataGateway');
class Model_Trade_Order extends TMIS_TableDataGateway {
	var $tableName = 'trade_order';
	var $primaryKey = 'id';
	var $primaryName = 'orderCode';


	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Jichu_Employ',
			'foreignKey' => 'traderId',
			'mappingName' => 'Trader',
		),
		array(
			'tableClass' => 'Model_Jichu_Client',
			'foreignKey' => 'clientId',
			'mappingName' => 'Client',
		),
		array(
			'tableClass' => 'Model_Jichu_Head',
			'foreignKey' => 'headId',
			'mappingName' => 'Head',
		)
	);
	
	var $hasMany = array (
		array(
			'tableClass' => 'Model_Trade_Order2Product',
			'foreignKey' => 'orderId',
			'mappingName' => 'Products',
		),
		array(
			'tableClass' => 'Model_Trade_OrderFeiyong',
			'foreignKey' => 'orderId',
			'mappingName' => 'Feiyong',
		)
	);

	//取得新合同编号
	function getNewOrderCode() {
		$arr=$this->find(null,'orderCode desc','orderCode');
		$max = substr($arr['orderCode'],2);
		$temp = date("ymd")."001";
		if ($temp>$max) return 'DS'.$temp;
		$a = substr($max,-3)+1001;
		return 'DS'.substr($max,0,-3).substr($a,1);
	}

	//获取流转单号,默认规则。
	function getNewCode($headId){
		$sql="select code from jichu_head where id='{$headId}'";
		$head_arr = mysql_fetch_assoc(mysql_query($sql));

		$head = $headId>0?$head_arr['code']:'HL';
		$ymd=date('ymd');
		//获取最大的
		$sql="select orderCode,substring( orderCode,-3) AS code from trade_order
		where orderCode like '{$head}{$ymd}%' order by substring( orderCode,-3) desc limit 0,1";

		$re = mysql_fetch_assoc(mysql_query($sql));
		// dump($re);exit;
		$max = $re['code'];
		$begin='001';

		$next=substr((1001+$max),1);
		$orderCode=$head.$ymd.$next;
		return $orderCode;
	}

	//得到合同的收款金额
	function getMoneyAccept($orderId) {
		$sql = "select sum(x.money) as money
			from caiwu_ar_guozhang x
			inner join cangku_chuku2product y on x.id=y.guozhangId
			inner join trade_order2product z on y.order2productId=z.id
			where x.incomeId>0 and z.orderId='$orderId'";
		$re = $this->findBySql($sql);
		return $re[0]['money'];
	}

	//获取费用类别的optios
	function getFeiyongOptions(){
		$sql="select DISTINCT feiyongName from trade_order_feiyong where 1 order by id";
		$temp=$this->findBySql($sql);
		// dump($temp);exit;
		$arr=array();
		foreach ($temp as $key =>& $v) {
			$arr[]=array('text'=>$v['feiyongName'],'value'=>$v['feiyongName']);
		}
		return $arr;
	}
}


?>