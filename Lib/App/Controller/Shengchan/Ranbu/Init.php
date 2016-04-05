<?php
FLEA::loadClass('Controller_Shengchan_Ruku');
class Controller_Shengchan_Ranbu_Init extends Controller_Shengchan_Ruku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '染色布';
		$this->_kind="初始化";
		$this->_head = "BKCS";
		// 定义模板中的主表字段
		$this->fldMain = array(
			'rukuCode' => array('title' => '单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode($this->_head,'cangku_ruku','rukuCode')),
			// 'supplierId' => array('title' => '供应商', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1'),
			'rukuDate' => array('title' => '入库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kuweiId' => array(
				'title' => '仓库', 
				"type" => "Popup",
				'url'=>url('Jichu_kuwei','popup'),
				'textFld'=>'kuweiName',
				'hiddenFld'=>'id',
			),
			// 'kuweiId' => array('title' => '仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			// 'songhuoCode' => array('title' => '送货单号', "type" => "text", 'value'=>''),
			'kind'=>array('title'=>'入库类型','type'=>'text','readonly'=>true,'name'=>'kind','value'=>$this->_kind),
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
			'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'pihao'=>array('type'=>'bttext',"title"=>'缸号','name'=>'pihao[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]'),
			// 'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			// 'money' => array('type' => 'bttext', "title" => '金额', 'name' => 'money[]','readonly'=>true),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'planCode' => 'required',
			// 'supplierId' => 'required',
			'kuweiId' => 'required'
		);

		$this->sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/kuweiJs.tpl'
		);

		$this->_rightCheck='3-2-1-13';
		$this->_addCheck='3-2-1-12';
	}

	function actionRight(){
		//权限判断
		$this->authCheck($this->_rightCheck);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			// 'supplierId'=>'',
			'kuweiId'=>'',
			'ganghao'=>'',
			'key'=>'',
		)); 

		$sql="select x.*,b.kuweiName,y.supplierId
			from cangku_ruku x
			inner join cangku_ruku_son y on x.id=y.rukuId
			left join jichu_product z on z.id=y.productId
			left join Jichu_kuwei b on b.id=x.kuweiId
			where 1";

		$sql.=" and x.kind='{$this->_kind}'";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['key']!='')$sql.=" and (z.guige like '%{$arr['key']}%' or z.pinzhong like '%{$arr['key']}%')";
		if($arr['supplierId']!='')$sql.=" and y.supplierId = '{$arr['supplierId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['ganghao']!='')$sql.=" and y.pihao like '%{$arr['ganghao']}%'";

		$sql.=" group by x.id order by x.rukuDate desc,x.id desc";
		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);
			//删除操作
			$v['_edit'] .= ' ' .$this->getRemoveHtml($v['id']);

			$v['Products'] = $this->_subModel->findAll(array('rukuId'=>$v['id']));
			//显示明细数据
			foreach($v['Products'] as & $vv){
				//查找产品明细信息
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$vv['proCode']=$temp[0]['proCode'];
				$vv['pinzhong']=$temp[0]['pinzhong'];
				$vv['proName']=$temp[0]['proName'];
				$vv['zhonglei']=$temp[0]['zhonglei'];
				$vv['guige']=$temp[0]['guige'];
				// $vv['color']=$temp[0]['color'];
				//合计
				$v['cnt']+=$vv['cnt'];
				$v['cntJian']+=$vv['cntJian'];
				$v['money']+=$vv['money'];
				$vv['danjia']=round($vv['danjia'],6);
			}

			//查找供应商信息
			$v['supplierId']=$v['Products'][0]['supplierId'];
			$sql="select * from jichu_jiagonghu where id='{$v['supplierId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['compName'] = $temp[0]['compName'];
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo =$this->_fieldMain ? $this->_fieldMain :  array(
			"_edit" => '操作',
			'kind'=>'类型',
			// 'compName'=>'供应商',
			'kuweiName'=>'仓库',
			"rukuDate" => "发生日期",
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			// "songhuoCode" => "送货单号",
			'cntJian'=>'包数',
			'cnt'=>'数量(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=$this->_fieldSon ? $this->_fieldSon : array(
			"proCode" => '产品编号',
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '缸号', 
			'dengji'=>'等级',
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			"memoView" => array('text'=>'备注','width'=>200), 
		);

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_info2', $arrField);
		$smarty->assign('sub_field', 'Products');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblListMore.tpl');
	}

}

?>