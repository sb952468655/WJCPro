<?php
FLEA::loadClass('Controller_Shengchan_Chuku');
class Controller_Shengchan_CangkuBu_Qtck extends Controller_Shengchan_Chuku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '布仓库';
		$this->_kind="其他出库";
		//出库主信息
		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('BKQC','cangku_chuku','chukuCode')),
			'chukuDate' => array('title' => '出库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
			'kuweiId' => array('title' => '仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			'departmentId'=> array('title' => '领用部门','type' => 'select', 'value' => '','model'=>'Model_jichu_department'),
			'peolingliao' => array('title' => '领用人', 'type' => 'text', 'value' => ''),
			// 定义了name以后，就不会以memo作为input的id了
			'yuanyin'=>array('title'=>'出库原因','type'=>'textarea'),
			'memo'=>array('title'=>'备注说明','type'=>'textarea','name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			'isGuozhang' => array('type' => 'hidden', 'value' => '1'),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
		);
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			// 'plan2proId' => array('title' => '生产计划', "type" => "btPopup", 'value'=>'', 'name' => 'plan2proId[]','url'=>url('Shengchan_Plan','popup'),'textFld'=>'planCode','hiddenFld'=>'id','inTable'=>true,'text'=>''),
			'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'pihao'=>array('type'=>'bttext',"title"=>'批号','name'=>'pihao[]'),
			// 'supplierId' => array('title' => '供应商', 'type' => 'btselect', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1','inTable'=>true,'name'=>'supplierId[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]'),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
		);
		
		// 表单元素的验证规则定义
		$this->rules = array(
			// 'jiagonghuId' => 'required',
			'kuweiId' => 'required'
		);

		// $this->sonTpl="";
		$this->_rightCheck='3-2-16';
		$this->_addCheck='3-2-15';
	}

	/**
	 * ps ：查询方法，定义需要显示的列信息，调用父类right方法
	 * Time：2014/06/12 10:57:18
	 * @author li
	*/
	function actionRight(){
		//权限判断
		$this->authCheck($this->_rightCheck);
		$ishaveCheck = $this->authCheck('3-100-1',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'isCheck'=>2,
			'kuweiId'=>'',
			// 'jiagonghuId'=>'',
			// 'supplierId'=>'',
			'commonCode' => '',
		));
		//搜索前处理搜索项
		// $this->_beforeSearch($arr);//exit;

		$condition=array();
		$condition[]=array('kind',$this->_kind,'=');
		$condition[]=array('type',$this->_type,'=');
		if($arr['commonCode']!='')$condition[]=array('chukuCode',"%{$arr['commonCode']}%",'like');
		if($arr['supplierId']!='')$condition[]=array('Products.supplierId',$arr['supplierId'],'=');
		// if($arr['jiagonghuId']!='')$condition[]=array('jiagonghuId',$arr['jiagonghuId'],'=');
		if($arr['kuweiId']!='')$condition[]=array('kuweiId',$arr['kuweiId'],'=');
		if($arr['isCheck']<2)$condition[]=array('isCheck',$arr['isCheck'],'=');
		//查找计划
		$pager = &new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);
			//删除操作
			$v['_edit'] .= '&nbsp;' .$this->getRemoveHtml($v['id']);
			//打印
			if($v['isCheck']==1){
				$v['_edit'] = "<span title='已审核，禁止操作'>修改  删除</span>";
				$v['_edit'].="&nbsp;<a href='".$this->_url('print',array(
					'id'=>$v['id']
					))."' target='_blank'>打印</a>";
			}else{
				$v['_edit'].="&nbsp;<span ext:qtip='未审核，不能打印'>打印</span>";
			}
			//审核，有权限的才显示
			if($ishaveCheck){
				$msg='';
				$isCheck=0;
				if($v['isCheck']==0){
					$isCheck=1;
					$msg='';
				}else{
					$isCheck=0;
					$msg='取消';
				}
				$v['_edit'].="&nbsp;<a href='".$this->_url('shenhe',array(
					'id'=>$v['id'],
					'isCheck'=>$isCheck,
					))."'>{$msg}审核</a>";
			}
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

				//查找供应商信息
				if($vv['supplierId']){
					$sql="select compName from jichu_jiagonghu where id='{$vv['supplierId']}'";
					$temp=$this->_subModel->findBySql($sql);
					$vv['compName']=$temp[0]['compName'];
				}

				//计算合计，显示在上面的信息中
				$v['cnt']+=$vv['cnt'];
				$v['cntCi']+=$vv['cntCi'];
				$v['cntJian']+=$vv['cntJian'];
			}
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作','width'=>170),
			'kind'=>'类型',
			'Kuwei.kuweiName'=>'仓库',
			"chukuDate" => "发生日期",
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			'Department.depName'=>array('text'=>'部门名称','width'=>80),
			'peolingliao'=>array('text'=>'领料人','width'=>70),
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			"yuanyin" => array('text'=>'出库原因','width'=>120), 
			"memo" => array('text'=>'备注','width'=>200), 
		);

		$arrField = array(
			// "compName" => '供应商', 
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '批号', 
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

	/**
	 * ps ：处理搜索项
	 * Time：2014/06/13 09:19:38
	 * @author li
	 * @param Array
	 * @return Array
	*/
	// function _beforeSearch(& $arr){
	// 	// unset($arr['jiagonghuId']);
	// 	// return true;
	// }


	/**
	 * 打印
	 */
	function actionPrint() {
		$m = & $this->_subModel;
		$rowset = $m->find($_GET['id']); 
		$row = $this->_modelExample->find(array('id'=>$_GET['id']));
		if($row['isCheck']==0){
			echo "未审核，不能打印";exit;
		}
		// dump($row);exit;
		foreach($row['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			// dump($v);dump($_temp);exit;
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];

			//计划编号
			if(!$v['plan2proId']['value'])continue;
			// dump($v);exit;
			$sql="select y.planCode from shengchan_plan2product x 
					left join shengchan_plan y on x.planId=y.id
					where x.id='{$v['plan2proId']}'";
			// echo $sql;exit;
			$_temp = $this->_modelExample->findBySql($sql);
			$v['planCode']=$_temp[0]['planCode'];
			// dump($temp);

			/*if($v['supplierId']){
				$sql="select compName from jichu_jiagonghu where id='{$v['supplierId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$v['compName']=$temp[0]['compName'];
			}*/
		} 
		$row['Products'][] = $this->getHeji($row['Products'],array('cnt','cntCi','money'),'proCode') ;
		//补齐5行
		$cnt = count($row['Products']);
		for($i=5;$i>$cnt;$i--) {
			$row['Products'][] = array();
		}
		// dump($row);exit;
		$main = array(
			'出库单号'=>$row['chukuCode'],
			'日期'=>$row['chukuDate'],
			'领料部门'=>$row['Department']['depName'],
			'领料人'=>$row['peolingliao'],
			'库位'=>$row['Kuwei']['kuweiName'],			
		);
		$smarty = &$this->_getView();
		$smarty->assign("title", $this->_kind.'单');
		$smarty->assign("arr_main_value", $main);
		$smarty->assign("arr_field_info", array(
			// 'planCode' => '计划编号',
			// 'compName'=>'供应商',
			'proCode' => '产品编码',
			'pinzhong' => '品种',
			'guige' => '规格',
			'color' => '颜色',
			'pihao'=>'批号',
			'cntJian'=>'件数',
			'dengji'=>'等级',
			'cnt' => '数量(Kg)',
			'memoView' => '备注'
		));
		/**
		* 打印界面加载公章信息
		*/
		// if($row['isCheck']==1){
		// 	$smarty->assign("gongzhang", '1');
		// }
		$smarty->assign("arr_field_value", $row['Products']);
		$smarty->display('Print.tpl');
	}
}

?>