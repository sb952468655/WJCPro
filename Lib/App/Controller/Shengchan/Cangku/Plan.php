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
			'daohuoDate' => array('title' => '预计交期', 'type' => 'calendar', 'value' =>''),
			'touliaoId' => array('title' => '投料计划', 'type' => 'popup', 'value' =>'','url'=>url('Shengchan_PlanTl','PopupShazhi'),'textFld'=>'touliaoCode','hiddenFld'=>'id','dialogWidth'=>900),
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
			'productId' => array('type' => 'btproductpopup', "title" => '产品选择', 'name' => 'productId[]'),
			// 'zhonglei'=>array('type'=>'bttext',"title"=>'成分','name'=>'zhonglei[]','readonly'=>true),
			'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'supplierId' => array('title' => '供应商', 'type' => 'btselect', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1','name'=>'supplierId[]','inTable'=>true),
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
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
		$this->authCheck('3-1-2-1');
		$isCk = $this->authCheck('3-1-2-3',true);
		$isViewMoney = $this->authCheck('3-1-2-4',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'supplierId'=>'',
			'isCheck'=>2,
			'planCode' => '',
			'key'=>'',
			
		));
		// $condition=array();
		// if($arr['planCode']!='')$condition[]=array('planCode',"%{$arr['planCode']}%",'like');
		// if($arr['supplierId']!='')$condition[]=array('Products.supplierId',$arr['supplierId'],'=');
		// if($arr['isCheck']<2)$condition[]=array('isCheck',$arr['isCheck'],'=');

		$sql="select x.*
			from pisha_plan x
			inner join pisha_plan_son y on x.id=y.psPlanId
			left join jichu_product z on z.id=y.productId
			where 1";

		if($arr['planCode']!='')$sql.=" and x.planCode like '%{$arr['planCode']}%'";
		if($arr['proName']!='')$sql.=" and z.proName like '%{$arr['proName']}%'";
		if($arr['guige']!='')$sql.=" and z.guige like '%{$arr['guige']}%'";
		if($arr['key']!='')$sql.=" and (z.guige like '%{$arr['key']}%' or z.proName like '%{$arr['key']}%')";
		if($arr['supplierId']!='')$sql.=" and y.supplierId = '{$arr['supplierId']}'";
		if($arr['isCheck']<2)$sql.=" and x.isCheck='{$arr['isCheck']}'";

		$sql.=" group by x.id order by x.planDate desc,x.id desc";
		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			if($v['isCheck']==0){
				$v['_edit'] = $this->getEditHtml($v['id']) .' '.$this->getRemoveHtml($v['id']);
			}else{
				$v['_edit'] = "<span title='已审核，禁止操作'>修改  删除</span>";
			}

			//判断是否有审核权限
			if($isCk){
				$msg=$v['isCheck']==0?"":"取消";
				$v['_edit'].=" <a title='{$msg}审核' href='".$this->_url('Shenhe',array(
					'id'=>$v['id'],
					'isCheck'=>$v['isCheck']
				))."'>{$msg}审核</a>";
			}

			//查找生产计划
			/*$sql="select x.touliaoCode from shengchan_plan_touliao x
			where x.id='{$v['touliaoId']}'";
			$temp=$this->_modelPro->findBySql($sql);
			$v['touliaoCode']=$temp[0]['touliaoCode'];*/

			$v['Products'] = $this->_modelPro->findAll(array('psPlanId'=>$v['id']));
			//显示明细数据
			foreach($v['Products'] as & $vv){
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_modelPro->findBySql($sql);
				$vv['proCode']=$temp[0]['proCode'];
				// $vv['pinzhong']=$temp[0]['pinzhong'];
				$vv['proName']=$temp[0]['proName'];
				$vv['zhonglei']=$temp[0]['zhonglei'];
				$vv['guige']=$temp[0]['guige'];
				// $vv['color']=$temp[0]['color'];

				//查找供应商
				$sql="select compName from jichu_jiagonghu where id='{$vv['supplierId']}'";
				$temp=$this->_modelPro->findBySql($sql);
				$vv['compName']=$temp[0]['compName'];				

				$vv['danjia']=round($vv['danjia'],6);
				$vv['money']=round($vv['money'],6);

				$v['cnt']+=$vv['cntKg'];
			}

			//查找采购计划对应的入库数量
			$sql="select sum(x.cnt) as cnt from cangku_ruku_son x
			left join cangku_ruku y on y.id=x.rukuId
			where y.cgPlanId='{$v['id']}'";
			$res=$this->_subModel->findBySql($sql);
			$v['yrk']=round($res[0]['cnt'],2);
			$v['rate']=round($v['yrk']/$v['cnt'],4)*100;
			
			$v['yrk']="<a href='".url('Shengchan_Cangku_Cgrk','ViewMingxi',array(
					'cgPlanId'=>$v['id'],
					'no_edit'=>1,
					'width'=>900,
					'baseWindow'=>'parent',
					'TB_iframe'=>1
				))."' class='thickbox'>{$v['yrk']}</a>";

			

			$v['daohuoDate']=='0000-00-00' && $v['daohuoDate'] = '';
			$v['daohuoDate'] != '' && $v['daohuoDate']="<font color='green'>{$v['daohuoDate']}</font>";
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作','width'=>150),
			"planDate" => "日期",
			"daohuoDate" => "预计交期",
			'planCode' => array('text'=>'计划单号','width'=>150),
			// 'touliaoCode' => array('text'=>'投料计划','width'=>150),
			'cnt'=>'计划采购数量',
			'yrk'=>'已入库数量',
			'rate'=>'入库比列(%)',
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=array(
			'compName'=>'供应商',
			"proCode" => '产品编号', 
			// "zhonglei" => '成分', 
			"proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色', 
			"cntJian" => '件数',
			"cntKg" => '数量',
			"danjia" => '单价', 
			'money'=>'金额',
			'memoView'=>'备注',
		);

		if(!$isViewMoney){
			unset($arrField['danjia']);
			unset($arrField['money']);
		}

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
		$sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/Cangku/PlanEdit.tpl'
		);
		$smarty->assign('sonTpl', $sonTpl); 
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit() {
		$this->authCheck('3-1');
		$arr = $this->_modelExample->find(array('id' => $_GET['id'])); 
		if($arr['daohuoDate'] == '0000-00-00')$arr['daohuoDate']='';
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value']; 
		}

		// 入库明细处理
		$rowsSon = array();
		$touliaoId=array();
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];

			$v['danjia']=round($v['danjia'],6);

			//查找对应的投料计划信息
			$sql="select group_concat(id) as id,group_concat(touliaoId) as touliaoId from shengchan_plan2product_touliao where psPlan2proId='{$v['id']}'";
			$temp = $this->_modelExample->findBySql($sql);
			// dump($v);exit;
			$v['plan2tlId']=$temp[0]['id'];
			$touliaoId[]=$temp[0]['touliaoId'];
		}

		//汇总投料计划id，查找相关的投料code
		$touliaoId = join(',',$touliaoId);
		if($touliaoId!=''){
			//查找对应的生产计划信息
			// dump($arr);exit;
			$sql="select group_concat(x.touliaoCode) as touliaoCode,group_concat(x.id) as touliaoId from shengchan_plan_touliao x
				where x.id in({$touliaoId})";
			$_temp = $this->_subModel->findBySql($sql);
			$this->fldMain['touliaoId']['text']=$_temp[0]['touliaoCode'];
			$this->fldMain['touliaoId']['value']=$_temp[0]['touliaoId'];
			// //加载库位信息的值
			$areaMain = array('title' => '采购计划基本信息', 'fld' => $this->fldMain);
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
		// dump($rowsSon);exit;

		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']);
		$smarty->assign('rules', $this->rules);
		$sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/Cangku/PlanEdit.tpl'
		);
		$smarty->assign('sonTpl', $sonTpl); 
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
		$this->authCheck('3-1-2-2');

		//修改投料计划中已设置采购计划的相关联id信息，需要制空
		$arr = $this->_modelExample->find($_GET['id']);
		$psPlan2proId = join(',',array_col_values($arr['Products'],'id'));
		if($psPlan2proId!=''){
			$sql="update shengchan_plan2product_touliao set psPlan2proId=0 where psPlan2proId in({$psPlan2proId})";
			$this->_modelExample->execute($sql);
		}
		

		parent::actionRemove();
	}

	//利用ajax删除订单明细，在订单编辑界面中使用,需要定义subModel
	function actionRemoveByAjax() {
		$id=$_REQUEST['id'];
		$m = $this->_subModel;
		$arr = $m->find($id);
		
		if($m->removeByPkv($id)) {

			//更新投料计划的状态信息
			//修改投料计划中已设置采购计划的相关联id信息，需要制空
			if($arr['id']!=''){
				$sql="update shengchan_plan2product_touliao set psPlan2proId=0 where psPlan2proId in({$arr['id']})";
				$this->_modelExample->execute($sql);
			}

			echo json_encode(array('success'=>true));
			exit;
		}
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
			'guige'=>'',
		)); 
		$sql = "select x.planCode,x.planDate,x.id,z.compName,y.supplierId,group_concat(y.productId) as productId,sum(y.cntKg) as cntKg
			from pisha_plan x
			left join pisha_plan_son y on x.id=y.psPlanId
			left join jichu_product a on a.id=y.productId
			left join jichu_jiagonghu z on y.supplierId = z.id
			where x.isCheck=1";
		$arr['guige'] != '' && $sql .= " and a.guige like '%{$arr['guige']}%'";
		$arr['planCode'] != '' && $sql .= " and x.planCode like '%{$arr['planCode']}%'";
		$arr['supplierId'] != '' && $sql .= " and y.supplierId='{$arr['supplierId']}'";
		$sql .= " group by y.supplierId,y.psPlanId order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as & $v) {
			//查找产品信息
			$sql="select x.cntKg,concat(y.proName,' ',y.guige,' ',x.color) as proMemo from pisha_plan_son x
				left join jichu_product y on y.id=x.productId
				where x.psPlanId='{$v['id']}' and x.supplierId='{$v['supplierId']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$guige=array();
			foreach ($_temp as & $t) {
				$guige[]=$t['proMemo']."(".round($t['cntKg']).")";
			}
			$v['proInfo']="<a href='#' ext:qtip='".(join('<br>',$guige))."'>".(join('，',$guige))."</a>";
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"planDate" => "计划日期",
			"compName" => array('text'=>'供应商','width'=>'130'),
			"proInfo" => array('text'=>'规格','width'=>'220'),
			// "cnt" => array('text'=>'计划数量','width'=>'130'),
			'planCode' => array('text'=>'计划单号','width'=>'130'),
		); 
		

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
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
	
	/**
	 * 查询明细报表
	 * Time：2014/08/12 10:30:17
	 * @author wjb
	*/
	function actionViewMingxi(){
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'supplierId'=>'',
			'planCode' => '',
			// 'commonCode'=>'',
			'color'=>'',
			// 'pihao'=>'',
			'key'=>'',
		)); 

		$str="select q.id,s.planDate,s.planCode,p.proCode,p.zhonglei,p.proName,p.guige,q.color,q.cntKg,q.cntJian,q.supplierId,j.compName,q.memoView,s.daohuoDate,s.touliaoId
		from  pisha_plan_son q
		left join pisha_plan s on s.id=q.psPlanId
		left join jichu_product	p on q.productId=p.id
		left join jichu_jiagonghu j on j.id=q.supplierId
		where 1";
		
		if($arr['planCode']!='')$str.=" and s.planCode like '%{$arr['planCode']}%'";
		if($arr['supplierId']!='')$str.=" and q.supplierId={$arr['supplierId']}";
		if($arr['color']!='')$str.=" and q.color='{$arr['color']}'";
		if($arr['key']!='')$str.=" and(p.proCode like '%{$arr['key']}%' or p.zhonglei like '%{$arr['key']}%' or p.proName like '%{$arr['key']}%' or p.guige like '%{$arr['key']}%')";
		$str.=" order by s.planDate desc,s.planCode desc";
		// dump($str);exit;
		$pager=& new TMIS_Pager($str);
		$rowset = $pager->findAll();
		//dump($rowset);exit;
		//处理数量的小数位	
		foreach($rowset as &$v) {
			$v['cntKg']=round($v['cntKg'],6);

			//查找生产计划
			$sql="select x.touliaoCode from shengchan_plan_touliao x
			where x.id='{$v['touliaoId']}'";
			$temp=$this->_modelPro->findBySql($sql);
			$v['touliaoCode']=$temp[0]['touliaoCode'];

			$v['daohuoDate']=='0000-00-00' && $v['daohuoDate'] = '';
			$v['daohuoDate'] != '' && $v['daohuoDate']="<font color='green'>{$v['daohuoDate']}</font>";

			
		}
		$arrFieldInfo = array(
			"planDate" => "日期",
			// "daohuoDate" => "日期",
			'planCode' => array('text'=>'计划单号','width'=>120),
			'touliaoCode' => array('text'=>'投料计划','width'=>100),
			//"memo" => array('text'=>'备注','width'=>200), 
			'compName'=>'供应商',
			"proCode" => '产品编号', 
			// "zhonglei" => '成分', 
			"proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色', 
			"cntJian" => '件数',
			"cntKg" => '数量',
			"memoView" => '备注', 
			//'money'=>'金额',
		);
		
		$smarty = &$this->_getView(); 
		$smarty->assign('title', '计划明细查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	}

	//数据补丁
	function actionBuilding(){
		//查找所有已设置的计划明细id信息
		$sql="select id , plan2tlId from pisha_plan_son";
		$temp = $this->_modelExample->findBySql($sql);
		// dump($temp);exit;

		foreach ($temp as $key => & $v) {
			if($v['plan2tlId']==0)continue;
			$sql="update shengchan_plan2product_touliao set psPlan2proId='{$v['id']}' where id='{$v['plan2tlId']}'";
			$this->_modelExample->execute($sql);
		}

		echo '补丁完成';
	}
}
?>