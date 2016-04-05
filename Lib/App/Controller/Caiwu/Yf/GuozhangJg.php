<?php
FLEA::loadClass('Controller_Caiwu_Yf_Guozhang');
class Controller_Caiwu_Yf_GuozhangJg extends Controller_Caiwu_Yf_Guozhang {
	
    function __construct() {
    	parent::__construct();
        //搭建过账界面
        //搭建过账界面
        $this->fldMain = array(
			'guozhangDate' => array('title' => '过账日期', "type" => "calendar", 'value' => date('Y-m-d')),
			
			'supplierId' => array('title' => '加工户', 'type' => 'select', 'value' => '','model'=>'Model_Jichu_Jiagonghu','condition'=>'isSupplier=0'),//,'condition'=>'isSupplier=1'),
			// 'qitaMemo' => array('title' => '描述', 'type' => 'text', 'value' => '','readonly'=>true),
			'rukuDate' => array('title' => '发生日期', 'type' => 'text', 'value' => '','readonly'=>true),
			'cnt' => array('title' => '验收数量', 'type' => 'text', 'value' => '','readonly'=>true),
			'Lcnt' => array('title' => '领用数量', 'type' => 'text', 'value' => '','readonly'=>true),
			//'danjia' => array('title' => '单价', 'type' => 'text', 'value' => ''),
			'_money' => array('title' => '金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
			'zhekouMoney' => array('title' => '折扣金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
			'money' => array('title' => '入账金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
			'kind' => array('type' => 'hidden', 'value' => ''),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'rukuId' => array('type' => 'hidden', 'value' => ''),
			'chukuId' => array('type' => 'hidden', 'value' => ''),
			'isJiagong' => array('type' => 'hidden', 'value' => ''),
			'isLingyong' => array('type' => 'hidden', 'value' => ''),
			'isY' => array('type' => 'hidden', 'value' => ''),
		);

		// 表单元素的验证规则定义
		$this->rules = array(
			'guozhangDate' => 'required',
			'supplierId' => 'required',
			'money' => 'required number',
			'zhekouMoney' => 'number'
		);
    }
}
?>