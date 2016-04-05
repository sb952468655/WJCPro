<?php
FLEA::loadClass('Controller_Shengchan_Ruku');
class Controller_Shengchan_CangkuBu_Scrk extends Controller_Shengchan_Ruku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '布仓库';
		$this->_kind="生产回收";
		// 定义模板中的主表字段
		$this->fldMain = array(
			'rukuCode' => array('title' => '单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('BKHS','cangku_ruku','rukuCode')),
			// 'supplierId' => array('title' => '供应商', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1'),
			'rukuDate' => array('title' => '入库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind'=>array('title'=>'入库类型','type'=>'text','readonly'=>true,'name'=>'kind','value'=>$this->_kind),
			'jiagonghuId' => array('title' => '加工户', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=0'),
			'kuweiId' => array('title' => '仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			// 'songhuoCode' => array('title' => '送货单号', "type" => "text", 'value'=>''),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'cgrkId'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '0'),
			// 'kind' => array('type' => 'hidden', 'value' => ''),
			'isJiagong' => array('type' => 'hidden', 'value' => '1'),
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
			'planGxId' => array('title' => '生产计划', "type" => "btPopup", 'value'=>'', 'name' => 'planGxId[]','url'=>url('Shengchan_Plan','popupGx'),'textFld'=>'codeAndGx','hiddenFld'=>'plangxId','inTable'=>true,'text'=>'','dialogWidth'=>860),
			'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'pihao'=>array('type'=>'bttext',"title"=>'缸号','name'=>'pihao[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]'),
			'danjia' => array('type' => 'bttext', "title" => '加工单价', 'name' => 'danjia[]'),
			'money' => array('type' => 'bttext', "title" => '加工费', 'name' => 'money[]','readonly'=>true),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'plan2proId' => array('type' => 'bthidden', 'name' => 'plan2proId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'jiagonghuId' => 'required',
			'kuweiId' => 'required'
		);

		// $this->son_width='110%';
		$this->sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			"Shengchan/Cangku/ScrkSonTpl.tpl"
		);
		$this->_rightCheck='3-2-8';
		$this->_addCheck='3-2-7';
	}

	function actionRight(){
		$this->_fieldMain = array(
			"_edit" => '操作',
			'kind'=>'类型',
			'Jgh.compName'=>'加工户',
			'Kuwei.kuweiName'=>'仓库',
			"rukuDate" => "发生日期",
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		);

		$this->_fieldSon = array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			// "proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '缸号', 
			'dengji'=>'等级',
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			"danjia" => array('text'=>'加工单价','width'=>70),
			"money" => array('text'=>'加工费','width'=>70),
			"memoView" => array('text'=>'备注','width'=>200), 
		);

		parent::actionRight();
	}

	/**
	 * ps ：处理搜索项
	 * Time：2014/06/13 09:19:38
	 * @author li
	 * @param Array
	 * @return Array
	*/
	function _beforeSearch(& $arr){
		unset($arr['supplierId']);
		return true;
	}
}

?>