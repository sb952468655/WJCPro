<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_Cangku_Plan extends Tmis_Controller {
	// /构造函数
	function __construct() {
		$this->_modelExample = &FLEA::getSingleton('Model_Shengchan_Cangku_Plan');
		$this->_modelPro = &FLEA::getSingleton('Model_Shengchan_Cangku_Plan2Product');
		$this->_subModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Plan2Product');
		// $this->_supplierModel = &FLEA::getSingleton('Model_Jichu_jiagonghu');
		// 定义模板中的主表字段
		$this->fldMain = array(
			'planCode' => array('title' => '计划单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('CGJH','pisha_plan','planCode')),
			// 'supplierId' => array('title' => '供应商', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1'),
			'planDate' => array('title' => '计划日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'plan2proId' => array('title' => '生产计划', 'type' => 'popup', 'value' =>'','url'=>url('Shengchan_Plan','Popup'),'textFld'=>'planCode','hiddenFld'=>'id'),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'计划备注','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'planId'),
			);
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'productId' => array('type' => 'btproductpopup', "title" => '产品选择', 'name' => 'productId[]','kind'=>'坯纱'),
			// 'zhonglei'=>array('type'=>'bttext',"title"=>'成分','name'=>'zhonglei[]','readonly'=>true),
			'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]','readonly'=>true),
			'supplierId' => array('title' => '供应商', 'type' => 'btselect', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1','name'=>'supplierId[]','inTable'=>true),
			'cntKg' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cntKg[]'),
			'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			'money' => array('type' => 'bttext', "title" => '金额', 'name' => 'money[]','readonly'=>true),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'plan2tlId' => array('type' => 'bthidden', 'name' => 'plan2tlId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'planCode' => 'required',
			// 'supplierId' => 'required'
		);
	}

	function actionRight(){
		//权限判断
		$this->authCheck('3-2-1');
		$isCk = $this->authCheck('3-2-3',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'supplierId'=>'',
			'planCode' => '',
			'isCheck'=>2,
		)); 
		$condition=array();
		if($arr['planCode']!='')$condition[]=array('planCode',"%{$arr['planCode']}%",'like');
		if($arr['supplierId']!='')$condition[]=array('Products.supplierId',$arr['supplierId'],'=');
		if($arr['isCheck']<2)$condition[]=array('isCheck',$arr['isCheck'],'=');
		//查找计划
		$pager = &new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']) ./* ' ' . "<a href='".$this->_url('print',array(
				'planId'=>$v['id']
			))."' target='_blank'>打印</a>". */' ' .$this->getRemoveHtml($v['id']);

			//判断是否有审核权限
			if($isCk){
				$msg=$v['isCheck']==0?"":"取消";
				$v['_edit'].=" <a title='{$msg}审核' href='".$this->_url('Shenhe',array(
					'id'=>$v['id'],
					'isCheck'=>$v['isCheck']
				))."'>{$msg}审核</a>";
			}

			//查找生产计划
			$sql="select y.planCode from shengchan_plan2product x
			left join shengchan_plan y on x.planId=y.id
			where x.id='{$v['plan2proId']}'";
			$temp=$this->_modelPro->findBySql($sql);
			$v['planCode_sc']=$temp[0]['planCode'];

			//显示明细数据
			foreach($v['Products'] as & $vv){
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_modelPro->findBySql($sql);
				$vv['proCode']=$temp[0]['proCode'];
				// $vv['pinzhong']=$temp[0]['pinzhong'];
				$vv['proName']=$temp[0]['proName'];
				$vv['zhonglei']=$temp[0]['zhonglei'];
				$vv['guige']=$temp[0]['guige'];
				$vv['color']=$temp[0]['color'];

				//查找供应商
				$sql="select compName from jichu_jiagonghu where id='{$vv['supplierId']}'";
				$temp=$this->_modelPro->findBySql($sql);
				$vv['compName']=$temp[0]['compName'];				

				$vv['danjia']=round($vv['danjia'],6);
			}
			
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作','width'=>150),
			"planDate" => "日期",
			'planCode' => array('text'=>'计划单号','width'=>150),
			'planCode_sc' => array('text'=>'生产计划','width'=>150),
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=array(
			'compName'=>'供应商',
			"proCode" => '产品编号', 
			// "zhonglei" => '成分', 
			"proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色', 
			"cntKg" => '数量',
			"danjia" => '单价', 
		);

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_info2', $arrField);
		$smarty->assign('sub_field', 'Products');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $serachArea));
		$smarty->display('TblListMore.tpl');
	}

	/*********************************************************************\
	*  Copyright (c) 1998-2013, TH. All Rights Reserved.
	*  Author :li
	*  FName  :Plan.php
	*  Time   :2014/05/20 10:44:55
	*  Remark :审核标记方法
	\*********************************************************************/
	function actionShenhe(){
		$shenhe=$_GET['isCheck']==0?1:0;
		$msg="操作失败";
		if(is_numeric($_GET['isCheck']) && is_numeric($_GET['isCheck']) && $_GET['id']>0){
			$arr=array(
				'id'=>$_GET['id'],
				'isCheck'=>$shenhe
			);
			$this->_modelExample->update($arr);
			$msg = "操作成功";
		}
		js_alert(null,'window.parent.showMsg("'.$msg.'")',$this->_url('right'));
		
	}

	function actionAdd() {
		$this->authCheck('3-1');
		// 从表区域信息描述
		$smarty = &$this->_getView();
		$areaMain = array('title' => '采购计划基本信息', 'fld' => $this->fldMain); 
		$smarty->assign('areaMain', $areaMain);
		// 从表信息字段,默认5行
		for($i = 0;$i < 5;$i++) {
			$rowsSon[] = array();
		} 
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', 'Shengchan/Cangku/PlanEdit.tpl'); 
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit() {
		$this->authCheck('3-1');
		$arr = $this->_modelExample->find(array('id' => $_GET['id'])); 
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value']; 
		}

		//查找对应的生产计划信息
		$sql="select y.planCode from shengchan_plan2product x
			left join shengchan_plan y on x.planId=y.id
			where x.id='{$arr['plan2proId']}'";
		$_temp = $this->_subModel->findBySql($sql);
		$this->fldMain['plan2proId']['text']=$_temp[0]['planCode'];
		// //加载库位信息的值
		$areaMain = array('title' => '采购计划基本信息', 'fld' => $this->fldMain); 

		// 入库明细处理
		$rowsSon = array();
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			$v['color'] = $_temp[0]['color'];

			$v['danjia']=round($v['danjia'],6);
		} 
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}
		//补齐5行
		$cnt = count($rowsSon);
		for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}
		// dump($areaMain);exit;

		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', 'Shengchan/Cangku/PlanEdit.tpl'); 
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionSave(){
		//有效性验证,没有明细信息禁止保存
		//开始保存
		$pros = array();
		foreach($_POST['productId'] as $key=>&$v) {
			if($v=='') continue;
			$temp = array();
			foreach($this->headSon as $k=>&$vv) {
				$temp[$k] = $_POST[$k][$key];
			}
			$pros[]=$temp;
		}
		if(count($pros)==0) {
			js_alert('请选择有效的产品明细信息!','window.history.go(-1)');
			exit;
		}
		$row = array();
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$row[$k] = $_POST[$name];
		}

		$row['Products'] = $pros;
		// dump($row);exit;
		if(!$this->_modelExample->save($row)) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	//删除
	function actionRemove(){
		$this->authCheck('3-2-2');
		parent::actionRemove();
	}


	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 */
	function actionPopup() {
		// $this->authCheck('1-2');
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'supplierId'=>'',
			'planCode' => '',
		)); 
		$sql = "select x.planCode,x.planDate,x.id,z.compName,x.plan2proId,y.supplierId from pisha_plan x
			left join pisha_plan_son y on x.id=y.psPlanId
			left join jichu_jiagonghu z on y.supplierId = z.id
			where x.isCheck=1";
		$arr['planCode'] != '' && $sql .= " and x.planCode like '%{$arr['planCode']}%'";
		$arr['supplierId'] != '' && $sql .= " and y.supplierId='{$arr['supplierId']}'";
		$sql .= " group by y.supplierId,y.psPlanId order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as & $v) {
			$sql="select x.planCode from shengchan_plan x 
				left join shengchan_plan2product y on x.id=y.planId
				where y.id='{$v['plan2proId']}'";
			$temp=$this->_subModel->findBySql($sql);
			// dump($sql);exit;
			$v['planCode2']=$temp[0]['planCode'];
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			'planCode' => array('text'=>'计划单号','width'=>'130'),
			"planDate" => "计划日期",
			"compName" => "供应商",
			"planCode2" => array('text'=>'生产计划','width'=>'130'),
		); 
		

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action']), $serachArea));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	* 获取计划明细：按照计划主表id，供应商来获取
	*/
	function actionGetPlanInfo(){
		$arr = $this->_subModel->findAll(array('psPlanId'=>$_GET['psPlanId'],'supplierId'=>$_GET['supplierId']));
		foreach($arr as & $v){
			$str="select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_subModel->findBySql($str);
			$v['Product'] = $temp[0];
		}
		echo json_encode(array('success'=>count($arr)>0,'Products'=>$arr));exit;
	}

}

?>