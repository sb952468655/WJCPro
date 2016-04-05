<?php
FLEA::loadClass('Controller_Shengchan_Ruku');
class Controller_Shengchan_Cangku_Qtrk extends Controller_Shengchan_Ruku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '纱仓库';
		$this->_kind="其他入库";
		// 定义模板中的主表字段
		$this->fldMain = array(
			'rukuCode' => array('title' => '单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('SKQT','cangku_ruku','rukuCode')),
			'supplierId' => array('title' => '供应商', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1'),
			'rukuDate' => array('title' => '入库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kuweiId' => array('title' => '库位', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			'jiagonghuId' => array('title' => '加工户', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=0'),
			'kind'=>array('title'=>'入库类型','type'=>'text','readonly'=>true,'name'=>'kind','value'=>$this->_kind),
			// 'songhuoCode' => array('title' => '送货单号', "type" => "text", 'value'=>''),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'cgrkId'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '1'),
			// 'kind' => array('type' => 'hidden', 'value' => ''),
			// 'isTuiku' => array('type' => 'hidden', 'value' => '0'),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
			);
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'plan2proId' => array('title' => '生产计划', "type" => "btPopup", 'value'=>'', 'name' => 'plan2proId[]','url'=>url('Shengchan_Plan','popup'),'textFld'=>'planCode','hiddenFld'=>'id','inTable'=>true,'text'=>''),
			'productId' => array('type' => 'btproductpopup', "title" => '产品选择', 'name' => 'productId[]'),
			// 'zhonglei'=>array('type'=>'bttext',"title"=>'成分','name'=>'zhonglei[]','readonly'=>true),
			'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]','readonly'=>true),
			'pihao'=>array('type'=>'bttext',"title"=>'批号','name'=>'pihao[]'),
			'cnt' => array('type' => 'bttext', "title" => '一等品(Kg)', 'name' => 'cnt[]'),
			'cntCi' => array('type' => 'bttext', "title" => '次品(Kg)', 'name' => 'cntCi[]'),
			// 'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			// 'money' => array('type' => 'bttext', "title" => '金额', 'name' => 'money[]'),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'planCode' => 'required',
			'supplierId' => 'required',
			'jiagonghuId' => 'required',
			'kuweiId' => 'required'
		);

		// $this->son_width='110%';
		$this->sonTpl="Shengchan/Cangku/ScrkSonTpl.tpl";
		$this->_rightCheck='3-10';
		$this->_addCheck='3-9';
	}

	function actionRight(){
		$this->_fieldMain = array(
			"_edit" => '操作',
			'kind'=>'类型',
			'Jgh.compName'=>'加工户',
			'Kuwei.kuweiName'=>'库位',
			"rukuDate" => "发生日期",
			'rukuCode' => array('text'=>'入库单号','width'=>150),
			'cnt'=>'一等品(Kg)',
			'cntCi'=>'次品(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		);

		$this->_fieldSon = array(
			"proCode" => '产品编号', 
			// "zhonglei" => '成分', 
			"proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '批号', 
			'cnt'=>'一等品(Kg)',
			'cntCi'=>'次品(Kg)',
			"danjia" => array('text'=>'加工单价','width'=>70),
			"money" => array('text'=>'加工费','width'=>70),
			"memoView" => array('text'=>'备注','width'=>200), 
		);

		parent::actionRight();
	}
}

?>