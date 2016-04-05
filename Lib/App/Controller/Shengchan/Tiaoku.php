<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_Tiaoku extends Tmis_Controller {
	// /构造函数
	function __construct() {
		$this->_modelExample = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku');
		$this->_subModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku2Product');
		$this->_type = '';
		$this->_kind="调整库存";
		$this->_head = "TZKC";
		//出库主信息
		$this->fldMain = array(
			'rukuCode' => array('title' => '调库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode($this->_head,'cangku_ruku','rukuCode')),
			'rukuDate' => array('title' => '调库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
			'kuweiName' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'库位'),
			'proInfo' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'产品信息'),
			'pihao' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'缸号'),
			'compName' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'供应商'),
			'ganghao' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'本厂缸号'),
			'color' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'颜色'),
			'dengji' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'等级'),
			'cntKucun' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'当前库存','addonEnd'=>'Kg'),
			'cntNow' => array('type' => 'text', 'value' => '','title'=>'实际库存','addonEnd'=>'Kg'),
			'cnt' => array('type' => 'text', 'value' => '', 'readonly' => true,'title'=>'调整数量','addonEnd'=>'Kg'),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			'isGuozhang' => array('type' => 'hidden', 'value' => '1'),
			'kuweiId' => array('type' => 'hidden', 'value' => ''),
			'hzl' => array('type' => 'hidden', 'value' => '0'),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'supplierId' => array('type' => 'hidden', 'value' => ''),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'kuweiId' => 'required',
			'rukuDate' => 'required',
			'type' => 'required'
		);
	}

	/**
	 * 库存调整
	 * Time：2014/08/21 15:04:25
	 * @author li
	 * @param GET:（日期，仓库类型）
	*/
	function actionAdd(){
		$this->authCheck();
		//有效性验证
		if(!$_GET['_type'] || !$_GET['kuweiId']){
			echo '缺少基本信息，请刷新后重新操作';
			exit;
		}

		//组织数据
		$arr=array(
			'type'=>$_GET['_type'],
			'rukuDate'=>$_GET['dateTo'],
			'kuweiId'=>$_GET['kuweiId'],
			'productId'=>$_GET['productId'],
			'supplierId'=>$_GET['supplierId'],
			'pihao'=>$_GET['pihao'],
			'ganghao'=>$_GET['ganghao'],
			'color'=>$_GET['color'],
			'dengji'=>$_GET['dengji'],
			'hzl'=>$_GET['hzl']+0,
			'cntKucun'=>$_GET['cntKucun'],
			'memo'=>'库存调整',
		);

		//需要调整显示的信息
		$this->setHeadInfo($arr['type']);

		//查找库位信息
		$sql="select * from jichu_kuwei where id='{$arr['kuweiId']}'";
		$temp = $this->_subModel->findBySql($sql);
		$arr['kuweiName'] = $temp[0]['kuweiName'];

		//查找供应商信息
		$sql="select * from jichu_jiagonghu where id='{$arr['supplierId']}'";
		$temp = $this->_subModel->findBySql($sql);
		$arr['compName'] = $temp[0]['compName'];

		//查找产品基本信息
		$sql="select * from jichu_product where id='{$arr['productId']}'";
		$temp = $this->_subModel->findBySql($sql);
		$t = $temp[0];
		$arr['proInfo'] = $t['proCode'].' '.$t['proName'].' '.$t['pinzhong'].' '.$t['guige'];
				
		foreach ($arr as $k => & $v) {
			if($this->fldMain[$k]){
				$this->fldMain[$k]['value']=$v;
			}
		}
		
		// dump($this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('title','调整库存');
		$smarty->assign('fldMain', $this->fldMain);
		// $smarty->assign('aRow', $arr);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', "shengchan/cangku/TiaokuEdit.tpl");
		$smarty->display('Main/A1.tpl');
	}

	/**
	 * 需要调整显示的信息，按照类型来设置
	 * Time：2014/08/22 08:43:22
	 * @author li
	 * @param Array
	 * @return Array
	*/
	function setHeadInfo($type){
		switch ($type) {
			case '纱':
				$this->fldMain['pihao']['title']="批号/缸号";
				unset($this->fldMain['ganghao']);
				break;
			
			case '坯布':
				unset($this->fldMain['pihao']);
				unset($this->fldMain['compName']);
				break;

			default:
				unset($this->fldMain['ganghao']);
				unset($this->fldMain['compName']);
				break;
		}
	}

	/**
	 * 保存
	 * Time：2014/08/21 20:03:30
	 * @author li
	*/
	function actionSave(){

		$pros[]=array(
			'cnt'=>$_POST['cnt'],
			'pihao'=>$_POST['pihao'].'',
			'ganghao'=>$_POST['ganghao'].'',
			'color'=>$_POST['color'],
			'dengji'=>$_POST['dengji'],
			'productId'=>$_POST['productId'],
			'supplierId'=>$_POST['supplierId']+0,
		);

		//主要信息
		$row = array(
			'rukuCode'=>$_POST['rukuCode'],
			'hzl'=>$_POST['hzl'],
			'type'=>$_POST['type'],
			'kind'=>$_POST['kind'],
			'kuweiId'=>$_POST['kuweiId'],
			'rukuDate'=>$_POST['rukuDate'],
			'isGuozhang'=>$_POST['isGuozhang'],
			'creater'=>$_POST['creater'],
			'Products'=>$pros
		);
		
		// dump($row);exit;
		if(!$this->_modelExample->save($row)) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}
		//跳转
		js_alert(null,'window.parent.parent.showMsg("操作成功");window.parent.location.href=window.parent.location.href;');
	}
}
?>