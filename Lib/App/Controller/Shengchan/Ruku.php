<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_Ruku extends Tmis_Controller {
	var $fldMain;
	var $headSon;
	var $rules; //表单元素的验证规则
	var $_subModel;
	var $_kind='';
	var $_type='';
	var $_modelExample;
	var $_rightCheck='';//查询界面的权限
	var $_addCheck='';//编辑界面的权限

	// /构造函数
	function __construct() {
		$this->_modelExample = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku');
		$this->_subModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku2Product');
		//出库主信息
		$this->fldMain = array();
		//子信息
		$this->headSon = array();
		// 表单元素的验证规则定义
		$this->rules = array();
	}

	/**
	 * 等级信息，通过方法获取
	 * Time：2014/06/24 10:35:16
	 * @author li
	 * @return array 返回值类型
	*/

	function setDengji(){
		return array(
			array("text"=>'一等品',"value"=>'一等品'),
			array("text"=>'二等品',"value"=>'二等品'),
			array("text"=>'等外品',"value"=>'等外品'),
		);
	}


	/**
	 * ps ：处理搜索项
	 * Time：2014/06/13 09:19:38
	 * @author li
	 * @param Array
	 * @return Array
	*/
	function _beforeSearch(& $arr){
		return true;
	}

	function actionRight(){
		//权限判断
		$this->authCheck($this->_rightCheck);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'supplierId'=>'',
			'kuweiId'=>'',
			'commonCode' => '',
		)); 
		$this->_beforeSearch($arr);
		$condition=array();
		$condition[]=array('kind',$this->_kind,'=');
		$condition[]=array('type',$this->_type,'=');
		if($arr['commonCode']!='')$condition[]=array('rukuCode',"%{$arr['commonCode']}%",'like');
		if($arr['supplierId']!='')$condition[]=array('supplierId',$arr['supplierId'],'=');
		if($arr['jiagonghuId']!='')$condition[]=array('jiagonghuId',$arr['jiagonghuId'],'=');
		if($arr['kuweiId']!='')$condition[]=array('kuweiId',$arr['kuweiId'],'=');
		//查找计划
		$pager = &new TMIS_Pager($this->_modelExample,$condition,'rukuDate desc,id desc');
		$rowset = $pager->findAll();
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);
			//删除操作
			$v['_edit'] .= ' ' .$this->getRemoveHtml($v['id']);
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
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo =$this->_fieldMain ? $this->_fieldMain :  array(
			"_edit" => '操作',
			'kind'=>'类型',
			'Supplier.compName'=>'供应商',
			'Kuwei.kuweiName'=>'仓库',
			"rukuDate" => "发生日期",
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			// "songhuoCode" => "送货单号",
			'cntJian'=>'包数',
			'cnt'=>'数量(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=$this->_fieldSon ? $this->_fieldSon : array(
			"proCode" => '产品编号', 
			// "zhonglei" => '成分', 
			"proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '批号', 
			'dengji'=>'等级',
			'cntJian'=>'包数',
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

	function actionAdd() {
		$this->authCheck($this->_addCheck);
		while (count($rowsSon) < 5) {
			$rowsSon[]=array(
				'dengji'=>array('value'=>'一等品')
			);
		}
		$smarty = &$this->_getView();
		$areaMain = array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain);
		$smarty->assign('areaMain', $areaMain);		
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']==''?'add':$_GET['fromAction']);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', $this->sonTpl);
		$this->_beforeDisplayAdd($smarty);
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit() {
		$this->authCheck($this->_addCheck);
		$arr = $this->_modelExample->find(array('id' => $_GET['id']));
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}

		//如果存在采购计划id，需要显示计划单号
		if($arr['cgPlanId']>0){
			$sql="select planCode from pisha_plan where id='{$arr['cgPlanId']}'";
			$temp=$this->_subModel->findBySql($sql);
			$this->fldMain['cgPlanId'] && $this->fldMain['cgPlanId']['text']=$temp[0]['planCode'];
		}

		//仓库信息
		if($arr['kuweiId']>0){
			$sql="select kuweiName from jichu_kuwei where id='{$arr['kuweiId']}'";
			$temp=$this->_subModel->findBySql($sql);
			$this->fldMain['kuweiId'] && $this->fldMain['kuweiId']['text']=$temp[0]['kuweiName'];
		}

		// //加载库位信息的值
		$areaMain = array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain);

		// 入库明细处理
		$rowsSon = array();
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];

			$v['danjia'] = round($v['danjia'],6);

			//查找码单信息，并json_encode
			/*$sql="select * from cangku_madan where ruku2ProId='{$v['id']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$temp=array();
			foreach($_temp as & $m){
				if($m['chuku2proId']>0)$m['readonly']=true;
				$temp[$m['number']-1]=$m;
			}

			$v['Madan'] = json_encode($temp);*/
		}
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}

		//填充计划显示的信息
		foreach ($rowsSon as $key => & $v) {
			if(!$v['plan2proId']['value'])continue;
			// dump($v);exit;
			$sql="select y.planCode from shengchan_plan2product x 
					left join shengchan_plan y on x.planId=y.id
					where x.id='{$v['plan2proId']['value']}'";
			// echo $sql;exit;
			$_temp = $this->_modelExample->findBySql($sql);
			$v['planGxId'] && $v['planGxId']['text']=$_temp[0]['planCode'];
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
		$smarty->assign('sonTpl', $this->sonTpl);
		$this->_beforeDisplayEdit($smarty);
		$smarty->display('Main2Son/T1.tpl');
	}

	/**
	 * 数据集传递到修改编辑界面前的处理操作
	 * Time：2014/06/24 17:24:05
	 * @author li
	*/
	function _beforeDisplayEdit(& $smarty){
		return true;
	}

	/**
	 * 数据集传递到修改编辑界面前的处理操作
	 * Time：2014/06/24 17:24:05
	 * @author li
	*/
	function _beforeDisplayAdd(& $smarty){
		return true;
	}

	function actionSave(){
		//有效性验证,没有明细信息禁止保存
		//开始保存
		$pros = array();
		foreach($_POST['productId'] as $key=>&$v) {
			if($v=='' || $_POST['cnt'][$key]=='') continue;
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

	/**
	*	显示入库明细数据
	*/
	function actionPopup($filed){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' => $_GET['dateFrom'],
			'dateTo' => $_GET['dateTo'],
			'productId' => $_GET['productId'],
			'kuweiId' => $_GET['kuweiId'],
			'pihao' => $_GET['pihao'],
			'ganghao' => $_GET['ganghao'],
			'color' => $_GET['color'],
			'type'=>$_GET['type'],
			'dengji'=>$_GET['dengji'],
			'no_edit'=>'',
		)); 
		$sql = "select 
			y.rukuCode,
			y.rukuDate,
			y.jiagonghuId,
			y.memo as rukuMemo,
			y.kind,
			y.songhuoCode,
			x.supplierId,
			x.id,
			x.pihao,
			x.dengji,
			x.rukuId,
			x.productId,
			x.cnt,
			x.danjia,
			x.money,
			x.memoView,
			x.color,
			x.ganghao,
			x.chehao,
			x.shahao,
			b.proCode,
			b.pinzhong,
			b.zhonglei,
			b.proName,
			b.guige,
			b.kind as proKind,
			a.kuweiName,
			c.compName as supplierName
			from cangku_ruku y
			left join cangku_ruku_son x on y.id=x.rukuId
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_jiagonghu c on x.supplierId=c.id
			left join jichu_product b on x.productId=b.id
			where 1 and y.type='{$arr['type']}'";

		$sql .= " and rukuDate >= '{$arr['dateFrom']}' and rukuDate<='{$arr['dateTo']}'";		
		if ($arr['productId'] != '') $sql .= " and x.productId = '{$arr['productId']}'";
		if ($arr['kuweiId'] != '') $sql .= " and y.kuweiId = '{$arr['kuweiId']}'"; 
		$sql .= " and x.pihao = '{$arr['pihao']}'"; 
		$sql .= " and x.ganghao = '{$arr['ganghao']}'"; 
		$sql .= " and x.color = '{$arr['color']}'"; 
		$arr['dengji'] && $sql .= " and x.dengji='{$arr['dengji']}'";
		$sql .= " order by y.rukuCode desc";
		// dump($sql);exit;

		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as &$v) {
			if($v['jiagonghuId']>0){
				$sql="select compName from jichu_jiagonghu where id='{$v['jiagonghuId']}'";
				$temp = $this->_subModel->findBySql($sql);
				$v['compName'] = $temp[0]['compName'];
			}
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'rukuDate');
		$rowset[] = $heji;

		$filed = $filed ? $filed :array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
		);
		
		// 左边信息
		$arrFieldInfo = array(
			"rukuDate" => "发生日期",
			'kind'=>'入库类型',
			'compName'=>'加工户',
			'supplierName'=>'供应商',
			'kuweiName'=>'库位',
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			)
		+
		$filed
		+
		array(
			'dengji'=>'等级',
			"cnt" => '数量(Kg)',
		); 

		$smarty = &$this->_getView();
		$smarty->assign('title', '明细查询'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', $isShowAdd?'display':'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl'); 
	}

	/**
	 * 应付过账显示，选择过账记录
	 * Time：2014/07/07 13:13:53
	 * @author li
	*/
	function actionPopupOnGuozhang(){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'type'=>$_GET['type'],
			'productId' => '',
			'supplierId' => '',
			'kuweiId' => '',
			'key'=>'',
			'dengji'=>'',
		)); 
		$sql = "select 
			y.id rid,
			y.rukuCode,
			y.rukuDate,
			x.supplierId,
			y.jiagonghuId,
			y.memo as rukuMemo,
			y.kind,
			y.isJiagong,
			y.songhuoCode,
			x.id,
			x.pihao,
			x.dengji,
			x.rukuId,
			x.cnt,
			x.danjia,
			x.money,
			x.memoView,
			x.color,
			a.kuweiName,
			c.compName as supplierName
			from cangku_ruku y
			left join cangku_ruku_son x on y.id=x.rukuId
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_jiagonghu c on x.supplierId=c.id
			where y.isGuozhang=0 and y.isJiagong=0 and x.isHaveGz=0";
		// $sql .= " and rukuDate >= '{$arr['dateFrom']}' and rukuDate<='{$arr['dateTo']}'";		
		if ($arr['productId'] != '') $sql .= " and x.productId = '{$arr['productId']}'";
		if ($arr['supplierId'] != '') $sql .= " and y.supplierId = '{$arr['supplierId']}'";
		if ($arr['kuweiId'] != '') $sql .= " and y.kuweiId = '{$arr['kuweiId']}'"; 
		if ($arr['pihao'] != '') $sql .= " and x.pihao = '{$arr['pihao']}'"; 
		if ($arr['color'] != '') $sql .= " and x.color = '{$arr['color']}'";
		if($arr['key']!=''){
			//如果客户输入：60s 格子布，可以支持搜索多个模糊查询
			$keys = explode(' ',$arr['key']);
			foreach ($keys as & $_key) {
				$str="like '%{$_key}%'";
				$sql .= " and (x.pihao {$str} or x.color {$str} or b.pinzhong {$str} or b.proName {$str} or b.zhonglei {$str} or b.guige {$str})";
			}
		}
		$arr['dengji'] && $sql .= " and x.dengji='{$arr['dengji']}'";
		$arr['type']!='' && $sql.=" and y.type='{$arr['type']}'";
		$sql .= " group by y.id order by y.rukuDate,y.rukuCode desc";
		// dump($sql);exit;

		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//取得总数量和金额
			$sql="select danjia,sum(y.cnt) cnt,sum(y.money) money from cangku_ruku x
			left join cangku_ruku_son y on x.id=y.rukuId
			where x.id='{$v['rid']}'";
			$temp = $this->_modelExample->findBySql($sql);
			//dump($temp);exit;
			$v['cnt']=round($temp[0]['cnt'],6);
			$v['money']=$temp[0]['money'];
			$v['danjia']=$temp[0]['danjia'];
			
			
			if($v['danjia']==0){
			//当单价为空时，默认此加工户最近一次的单价
			$sql="select y.danjia,x.rukuDate from cangku_ruku x
					left join cangku_ruku_son y on x.id=y.rukuId
					where x.jiagonghuId='{$v['jiagonghuId']}' and y.danjia>0 order by x.rukuDate desc";
			$temp = $this->_modelExample->findBySql($sql);
			//dump($temp);exit;
			$v['danjia']=$temp[0]['danjia'];
			$v['money']=$v['danjia']*$v['cnt'];
		}
			$v['danjia']=round($v['danjia'],6);
			$v['qitaMemo']=$v['pinzhong'].' '.$v['proName'].' '.$v['guige'].' '.$v['color'].' '.$v['pihao'];
			$v['mingxi']="<a href='".url("Shengchan_Ruku",'LookMX',array(
					'id'=>$v['rid'],
					'JGtype'=>'0',
					'width'=>'500',
					'TB_iframe'=>1
				))."' title='入库明细'  class='thickbox'>明细</a> ";
			
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'rukuDate');
		$rowset[] = $heji; 
		// 左边信息
		$arrFieldInfo = array(
			"mingxi"=>"查看",
			"rukuDate" => "发生日期",
			'kind'=>'入库类型',
			"cnt" => '数量(Kg)',
			"money" => '金额',
			'supplierName'=>'供应商',
			'kuweiName'=>'库位',
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			 "rukuMemo" => '备注', 
			// "pinzhong" => '品种',
			// "zhonglei" => '成分', 
			// "proName" => '纱支', 
			// "guige" => '规格', 
			// "color" => '颜色',
			//'qitaMemo'=>array('text'=>'产品描述','width'=>260),
			//"dengji" => '等级',
		
		); 

		if($arr['type']=='纱仓库'){
			unset($arrFieldInfo['pinzhong']);
		}elseif($arr['type']=='布仓库'){
			// $arrFieldInfo['zhonglei']="品种";
			unset($arrFieldInfo['zhonglei']);
			unset($arrFieldInfo['proName']);
		}
		// dump($rowset);exit;

		$smarty = &$this->_getView();
		$smarty->assign('title', '加工过账查询'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', $isShowAdd?'display':'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		$smarty->display('Popup/commonNew.tpl');
	}
	
	
	/**
	 * by shirui
	 * 选择过账
	 * 
	 */
	function actionPopupOnGuozhang2(){
		FLEA::loadClass('TMIS_Pager');
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
				'type'=>$_GET['type'],
				'productId' => '',
				'supplierId' => '',
				//'kuweiId' => '',
				'key'=>'',
				'dengji'=>'',
		));
		$sql = "select
			y.id rid,
			y.id rukuId,
			y.type,
			y.rukuCode,
			y.rukuDate,
			x.supplierId,
			y.jiagonghuId,
			y.memo as rukuMemo,
			y.kind,
			y.isJiagong,
			y.songhuoCode,
			x.id,
			x.pihao,
			x.dengji,
			x.rukuId,
			x.cnt,
			x.danjia,
			x.money,
			x.memoView,
			x.color,
		    z.proName,
			z.guige,
			z.pinzhong,
			a.kuweiName,
			c.compName as supplierName
			from cangku_ruku y
			left join cangku_ruku_son x on y.id=x.rukuId
			left join jichu_product z on x.productId=z.id
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_jiagonghu c on x.supplierId=c.id
			where y.isGuozhang=0 and y.isJiagong=0 and x.supplierId>0";
		// $sql .= " and rukuDate >= '{$arr['dateFrom']}' and rukuDate<='{$arr['dateTo']}'";
		if ($arr['productId'] != '') $sql .= " and x.productId = '{$arr['productId']}'";
		if ($arr['supplierId'] != '') $sql .= " and x.supplierId = '{$arr['supplierId']}'";
		if ($arr['kuweiId'] != '') $sql .= " and y.kuweiId = '{$arr['kuweiId']}'";
		if ($arr['pihao'] != '') $sql .= " and x.pihao = '{$arr['pihao']}'";
		if ($arr['color'] != '') $sql .= " and x.color = '{$arr['color']}'";
		if($arr['key']!=''){
		//如果客户输入：60s 格子布，可以支持搜索多个模糊查询
		$keys = explode(' ',$arr['key']);
		foreach ($keys as & $_key) {
		$str="like '%{$_key}%'";
		$sql .= " and (x.pihao {$str} or x.color {$str}) ";
		}
		}
		$arr['dengji'] && $sql .= " and x.dengji='{$arr['dengji']}'";
		$arr['type']!='' && $sql.=" and y.type='{$arr['type']}'";
		$sql.=" and not exists(select id from caiwu_yf_guozhang where rukuId=y.id)";
		//$sql .= " group by y.id order by y.rukuDate,y.rukuCode desc";
		$sql .= " order by y.rukuDate,y.rukuCode desc";
		// dump($sql);exit;

		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//dump($v);exit;
			$sql="select x.*,y.compName,z.rukuDate,z.kind,z.rukuCode,a.proName,a.guige,pinzhong from cangku_ruku_son x
					left join jichu_jiagonghu y on x.supplierId=y.id
			 		left join cangku_ruku z on z.id=x.rukuId
					left join jichu_product a on x.productId=a.id
					where x.rukuId='{$v['rukuId']}' and x.supplierId>0
					and not exists(select * from caiwu_yf_guozhang where ruku2ProId=x.id)
					";
			$temp = $this->_modelExample->findBySql($sql);
			
		   foreach ($temp as & $vv){
    			$vv['isChecked']="<input type='checkbox' id='isChecked[]' name='isChecked[]' value='{$vv['id']}'/>";
    			$vv['zhekouMoney']="<input type='text' id='zhekouMoney[]' name='zhekouMoney[]' value=''/>";
    			$vv['_money']="<input type='text' id='_money[]' name='_money[]' value='{$vv['money']}'/>";
    			$vv['money']="<input type='text' id='money[]' name='money[]' value='{$vv['money']}' readonly='readonly'/>";
    			$vv['money'].="<input type='hidden' id='id[]' name='id[]' value='{$vv['id']}' readonly='readonly'/>";
    			$vv['cnt']="<input type='text' id='cnt[]' name='cnt[]' value='{$vv['cnt']}' readonly='readonly'/>";
    			$vv['danjia']=round($vv['danjia'],6);
    			$vv['danjia']="<input type='text' id='danjia[]' name='danjia[]' value='{$vv['danjia']}'/>";
    			$vv['rukuCode']="<input type='text' id='Code[]' name='Code[]' value='{$vv['rukuCode']}'  readonly='readonly'/>";
    			
    			$ret[]=$vv; 	
    			
    		}
			
// 			$v['cnt']="<input type='text' id='cnt[]' name='cnt[]' value='{$v['cnt']}' readonly='readonly'/>";
// 			$v['danjia']=round($v['danjia'],6);
// 			$v['danjia']="<input type='text' id='danjia[]' name='danjia[]' value='{$v['danjia']}'/>";
// 			$v['qitaMemo']=$v['pinzhong'].' '.$v['proName'].' '.$v['guige'].' '.$v['color'].' '.$v['pihao'];
// // 			$v['mingxi']="<a href='".url("Shengchan_Ruku",'LookMX',array(
// // 					'type'=>$v['type'],
// // 					'id'=>$v['rid'],
// // 					'JGtype'=>'2',
// // 					'width'=>'800',
// // 					'TB_iframe'=>1
// // 			))."' title='入库明细'  class='thickbox'>明细</a> ";
// 			$id=$v['id'];
// 			$v['isChecked']="<input type='checkbox' id='isChecked[]' name='isChecked[]' value='{$id}'/>";
// 			//dump($v);exit;
// 			$v['zhekouMoney']="<input type='text' id='zhekouMoney[]' name='zhekouMoney[]' value=''/>";
// 			$v['_money']="<input type='text' id='_money[]' name='_money[]' value='{$v['money']}'/>";
// 			$v['money']="<input type='text' id='money[]' name='money[]' value='{$v['money']}' readonly='readonly'/>";
// 			$v['money'].="<input type='hidden' id='id[]' name='id[]' value='{$v['id']}' readonly='readonly'/>";
		}
		// 合计行
			$heji = $this->getHeji($ret, array('cnt'), 'rukuDate');
			$ret[] = $heji;
			// 左边信息
			$arrFieldInfo = array(
				"isChecked"=>"过账选择",
				//"mingxi"=>"查看",
				"rukuDate" => "发生日期",
				'rukuCode' => array('text'=>'入库单号','width'=>120),
				'kind'=>'入库类型',
				"cnt" => '数量(Kg)',
				'danjia'=>'单价',
				"money" => '发生金额',
				"zhekouMoney" =>'折扣金额',
				"_money" =>'入账金额',
				'compName'=>'供应商',
				//'kuweiName'=>'库位',
				'color'=>'颜色',
				'proName'=>'纱支',
				'guige'=>'规格',
				'pinzhong'=>'品种',
					
				
			 	"memoView" => '备注',
			 // "pinzhong" => '品种',
			 // "zhonglei" => '成分',
			 // "proName" => '纱支',
		// "guige" => '规格',
			// "color" => '颜色',
			 	//'qitaMemo'=>array('text'=>'产品描述','width'=>260),
			 	//"dengji" => '等级',

	);

		if($arr['type']=='纱仓库'){
		unset($arrFieldInfo['pinzhong']);
		}elseif($arr['type']=='布仓库'){
						// $arrFieldInfo['zhonglei']="品种";
		unset($arrFieldInfo['zhonglei']);
		unset($arrFieldInfo['proName']);
						}
		// dump($rowset);exit;
	
		$smarty = &$this->_getView();
		$smarty->assign('title', '采购过账查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', $isShowAdd?'display':'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $ret);
		$other_url="<input type='button' id='save' name='save' value='保存'/>";
		$smarty->assign('other_url', $other_url);
		$smarty->assign('sonTpl', 'Caiwu/Yf/GuozhangTpl.tpl');
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr))."<font color='green'>一次过账>10,速度变慢！</font>");			
		$smarty->display('TableList.tpl');
		}
	/*function actionPopupOnGuozhang_old(){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			// 'dateFrom' => $_GET['dateFrom'],
			// 'dateTo' => $_GET['dateTo'],
			'type'=>$_GET['type'],
			'productId' => '',
			'supplierId' => '',
			'kuweiId' => '',
			// 'pihao' => '',
			// 'color' => '',
			'key'=>'',
			'dengji'=>'',
		)); 
		$sql = "select 
			y.rukuCode,
			y.rukuDate,
			x.supplierId,
			y.jiagonghuId,
			y.memo as rukuMemo,
			y.kind,
			y.isJiagong,
			y.songhuoCode,
			x.id,
			x.pihao,
			x.dengji,
			x.rukuId,
			x.productId,
			x.cnt,
			x.danjia,
			x.money,
			x.memoView,
			x.color,
			b.pinzhong,
			b.zhonglei,
			b.proName,
			b.guige,
			b.kind as proKind,
			a.kuweiName,
			c.compName as supplierName
			from cangku_ruku y
			left join cangku_ruku_son x on y.id=x.rukuId
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_jiagonghu c on x.supplierId=c.id
			left join jichu_product b on x.productId=b.id
			where y.isGuozhang=0 and y.isJiagong=0 and x.isHaveGz=0";
		// $sql .= " and rukuDate >= '{$arr['dateFrom']}' and rukuDate<='{$arr['dateTo']}'";		
		if ($arr['productId'] != '') $sql .= " and x.productId = '{$arr['productId']}'";
		if ($arr['supplierId'] != '') $sql .= " and y.supplierId = '{$arr['supplierId']}'";
		if ($arr['kuweiId'] != '') $sql .= " and y.kuweiId = '{$arr['kuweiId']}'"; 
		if ($arr['pihao'] != '') $sql .= " and x.pihao = '{$arr['pihao']}'"; 
		if ($arr['color'] != '') $sql .= " and x.color = '{$arr['color']}'";
		if($arr['key']!=''){
			//如果客户输入：60s 格子布，可以支持搜索多个模糊查询
			$keys = explode(' ',$arr['key']);
			foreach ($keys as & $_key) {
				$str="like '%{$_key}%'";
				$sql .= " and (x.pihao {$str} or x.color {$str} or b.pinzhong {$str} or b.proName {$str} or b.zhonglei {$str} or b.guige {$str})";
			}
		}
		$arr['dengji'] && $sql .= " and x.dengji='{$arr['dengji']}'";
		$arr['type']!='' && $sql.=" and y.type='{$arr['type']}'";
		$sql .= " order by y.rukuCode desc";
		// dump($sql);exit;

		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['danjia']=round($v['danjia'],6);
			$v['qitaMemo']=$v['pinzhong'].' '.$v['proName'].' '.$v['guige'].' '.$v['color'].' '.$v['pihao'];
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'rukuDate');
		$rowset[] = $heji; 
		// 左边信息
		$arrFieldInfo = array(
			"rukuDate" => "发生日期",
			'kind'=>'入库类型',
			'supplierName'=>'供应商',
			'kuweiName'=>'库位',
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			// "pihao" => '批号', 
			// "pinzhong" => '品种',
			// "zhonglei" => '成分', 
			// "proName" => '纱支', 
			// "guige" => '规格', 
			// "color" => '颜色',
			'qitaMemo'=>array('text'=>'产品描述','width'=>260),
			"dengji" => '等级',
			"cnt" => '数量(Kg)',
		); 

		if($arr['type']=='纱仓库'){
			unset($arrFieldInfo['pinzhong']);
		}elseif($arr['type']=='布仓库'){
			// $arrFieldInfo['zhonglei']="品种";
			unset($arrFieldInfo['zhonglei']);
			unset($arrFieldInfo['proName']);
		}
		// dump($arrFieldInfo);exit;

		$smarty = &$this->_getView();
		$smarty->assign('title', '订单查询'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', $isShowAdd?'display':'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		$smarty->display('Popup/commonNew.tpl');
	}*/

	/**
	 * 应付过账显示，选择过账记录
	 * Time：2014/07/07 13:13:53
	 * @author li
	*/
	function actionPopupOnGuozhangJg(){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			// 'dateFrom' => $_GET['dateFrom'],
			// 'dateTo' => $_GET['dateTo'],
 			//'isRuku' =>'',//$_GET['isRuku'],
 			'type'=>$_GET['type'],
			//'isHaveGz'=>$_GET['isHaveGz'],
			'productId' => '',
			'jiagonghuId' => '',
			'kuweiId' => '',
			//'key' => '',
			// 'color' => '',
			//'dengji'=>'',
			'no_edit'=>'',
				
		)); //dump($arr);exit;

			$sql = "select
			y.id,
			y.id rukuId,
			y.rukuCode,
			y.rukuDate,
			y.type,
			y.jiagonghuId as supplierId,
			y.jiagonghuId,
			y.memo as rukuMemo,
			y.kind,
			y.isJiagong,
			y.songhuoCode,
			y.memo,			
			a.kuweiName,
			c.compName
			from cangku_ruku y
			left join cangku_chuku x on x.rukuId=y.id
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_jiagonghu c on y.jiagonghuId=c.id
			where y.isGuozhang=0 and y.isJiagong=1";
			if ($arr['jiagonghuId'] != '') $sql .= " and y.jiagonghuId = '{$arr['jiagonghuId']}'";
			if ($arr['kuweiId'] != '') $sql .= " and y.kuweiId = '{$arr['kuweiId']}'";			
		    $arr['type']!='' && $sql.=" and y.type='{$arr['type']}'";
			$sql .= " order by y.rukuDate,y.rukuCode desc";
			// dump($sql);exit;
			
			$pager = &new TMIS_Pager($sql);
			$rowset = $pager->findAll();
			//$i=0;
			if (count($rowset) > 0) foreach($rowset as &$v) {
			//单价
				$v['danjia']=round($v['danjia'],6);
				//取得总数量和金额
				$sql="select danjia,sum(y.cnt) cnt,sum(y.money) money from cangku_ruku x
				left join cangku_ruku_son y on x.id=y.rukuId
				where x.id='{$v['id']}'";
				$temp = $this->_modelExample->findBySql($sql);
				//dump($v);exit;
				$v['cnt']=round($temp[0]['cnt'],6);
				$v['money']=$temp[0]['money'];
				$v['danjia']=$temp[0]['danjia'];
				if($v['danjia']==0){
					//当单价为空时，默认此加工户最近一次的单价
					$sql="select y.danjia,x.rukuDate from cangku_ruku x
							left join cangku_ruku_son y on x.id=y.rukuId
							where x.jiagonghuId='{$v['jiagonghuId']}' and y.danjia>0 order by x.rukuDate desc";
					$temp = $this->_modelExample->findBySql($sql);
					//dump($temp);exit;
					$v['danjia']=$temp[0]['danjia'];
					$v['money']=$v['danjia']*$v['cnt'];
				}
				$v['danjia']=round($v['danjia'],2);
				//获得领用数量
				$sql="select danjia,sum(y.cnt) cnt,sum(y.money) money from cangku_chuku x
				left join cangku_chuku_son y on x.id=y.chukuId
				where x.rukuId='{$v['id']}'";
				$temp = $this->_modelExample->findBySql($sql);
				//dump($sql);exit;
				$v['Lcnt']=$temp[0]['cnt'];
				$v['Lmoney']=$temp[0]['money'];
				//if($temp[0]['money']==0)$v['Lmoney']=$v['danjia']*$v['Lcnt'];
				//dump($v['danjia']);dump($v['Lcnt']);dump($v['Lmoney']);exit;
				//描述拼接字符串
				$v['qitaMemo']=$v['compName'].' '.$v['kuweiName'];//.' '.$v['guige'].' '.$v['color'].' '.$v['pihao'];
				$v['mingxi']="<a href='".url("Shengchan_Ruku",'LookMX',array(
						'id'=>$v['id'],
						'JGtype'=>'1',
						'width'=>'800',
						'TB_iframe'=>1
				))."' title='明细'  class='thickbox'>明细</a> ";

			}

			
			// 合计行
// 			$heji = $this->getHeji($rowset, array('cnt'), 'rukuDate');
// 			$rowset[] = $heji;
			// 左边信息
			$arrFieldInfo = array(
					"mingxi"=>"查看",
					"rukuDate" => array('text'=>'发生日期','width'=>80),
					'kind'=>'入库类型',
					'compName'=>'加工户',
					'kuweiName'=>'库位',
					'rukuCode' => array('text'=>'入库单号','width'=>120),
// 					'qitaMemo'=>array('text'=>'产品描述','width'=>260),
 					"type" => array('text'=>'类型','width'=>80),
					"cnt" => array('text'=>'验收数量(Kg)','width'=>80),
					"Lcnt" => array('text'=>'领用数量(Kg)','width'=>80),
					"money" => array('text'=>'验收金额','width'=>80),
					"Lmoney" => array('text'=>'领用金额','width'=>80),
// 					"cntM" => '数量(M)',
					'memo'=>'备注',
					//"isHaveGz" => '是否需要过账',
			);
			
			
			$smarty = &$this->_getView();
			$smarty->assign('title', '过账查询');
			$smarty->assign('arr_field_info', $arrFieldInfo);
			$smarty->assign('add_display', $isShowAdd?'display':'none');
			$smarty->assign('arr_condition', $arr);
			$smarty->assign('arr_field_value', $rowset);
			$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
			$tpl = 'Popup/commonNew.tpl';
			$arr['isHaveGz']==2 && $tpl="Tbllist.tpl";
			$smarty->display($tpl);
		
		
			
// 		if($arr['isRuku']==1){
// 			$sql = "select
// 			y.chukuCode,
// 			y.jiagonghuId,
// 			y.clientId,
// 			y.chukuDate,
// 			y.memo as chukuMemo,
// 			y.kind,
// 			y.isJiagong,
// 			x.id,
// 			x.chukuId,
// 			x.pihao,
// 			x.dengji,
// 			x.productId,
// 			x.cnt,
// 			x.danjia,
// 			x.money,
// 			x.memoView,
// 			x.isHaveGz,
// 			b.pinzhong,
// 			b.zhonglei,
// 			b.proName,
// 			b.guige,
// 			x.color,
// 			b.kind as proKind,
// 			z.compName as supplierName,
// 			a.kuweiName
// 			from cangku_chuku y
// 			left join cangku_chuku_son x on y.id=x.chukuId
// 			left join jichu_product b on x.productId=b.id
// 			left join jichu_jiagonghu z on x.supplierId=z.id
// 			left join jichu_kuwei a on y.kuweiId=a.id
// 			where y.isCheck=1 and y.isGuozhang=0 and y.isJiagong=1";
			
// 			// $sql .= " and y.chukuDate >= '{$arr['dateFrom']}' and y.chukuDate<='{$arr['dateTo']}'";
// 			$arr['productId']>0 && $sql .= " and x.productId='{$arr['productId']}'";
// 			$arr['jiagonghuId']>0 && $sql .= " and y.jiagonghuId='{$arr['jiagonghuId']}'";
// 			$arr['kuweiId']>0 && $sql .= " and y.kuweiId='{$arr['kuweiId']}'";
// 			if ($arr['isHaveGz'] != '') $sql .= " and x.isHaveGz = '{$arr['isHaveGz']}'";
// 			else $sql.=" and x.isHaveGz = 0";
// 			if($arr['key']!=''){
// 				//如果客户输入：60s 格子布，可以支持搜索多个模糊查询
// 				$keys = explode(' ',$arr['key']);
// 				foreach ($keys as & $_key) {
// 					$str="like '%{$_key}%'";
// 					$sql .= " and (x.pihao {$str} or x.color {$str} or b.pinzhong {$str} or b.proName {$str} or b.zhonglei {$str} or b.guige {$str})";
// 				}
// 			}
// 			$arr['dengji']!='' && $sql .= " and x.dengji='{$arr['dengji']}'";
// 			$arr['type']!='' && $sql .= " and y.type='{$arr['type']}'";
// 			$sql .= " order by chukuDate desc, chukuCode desc";
// 			// dump($sql);exit;
// 			$pager = &new TMIS_Pager($sql);
// 			$rowset = $pager->findAll();
			
// 			if (count($rowset) > 0) foreach($rowset as &$v) {
// 				//查找加工户
// 				if($v['jiagonghuId']>0){
// 					$sql="select compName from jichu_jiagonghu where id='{$v['jiagonghuId']}'";
// 					$temp = $this->_subModel->findBySql($sql);
// 					$v['compName'] = $temp[0]['compName'];
// 				}
// 				//拼接描述信息
// 				$v['qitaMemo']=$v['pinzhong'].' '.$v['proName'].' '.$v['guige'].' '.$v['color'].' '.$v['pihao'];
// 				//单价信息
// 				$v['danjia']=round($v['danjia'],6);
// 				$v['cnt']=round($v['cnt'],6);
			
// 				//不需要过账的支持手动隐藏
// 				if($v['isHaveGz']==0){
// 					$view="不需过账";
// 					$guozhang='2';
// 				}elseif($v['isHaveGz']==2){
// 					$view="需要过账";
// 					$guozhang='0';
// 				}else{
// 					$v['isHaveGz']="已过帐";
// 					$view='';
// 				}
// 				// dump($v);exit;
// 				if($view!=''){
// 					$v['isHaveGz']="<a href='".$this->_url('isHaveGz',array(
// 							'id'=>$v['id'],
// 							'isHaveGz'=>$guozhang,
// 							'fromAction'=>$_GET['action']
// 					))."'>{$view}</a>";
// 				}
// 			}
// 			// 合计行
// 			$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
// 			$rowset[] = $heji;
// 			// 显示信息
// 			$arrFieldInfo = array(
// 					"chukuDate" => array('text'=>'发生日期','width'=>80),
// 					'kind'=>'类型',
// 					'kuweiName'=>'仓库',
// 					'compName'=>'加工户',
// 					// 'clientName'=>'客户',
// 					'chukuCode' => array('text'=>'出库单号','width'=>120),
// 					'qitaMemo'=>array('text'=>'产品描述','width'=>260),
// 					'dengji'=>array('text'=>'等级','width'=>80),
// 					// 'danjia'=>'单价',
// 					"cnt" => array('text'=>'数量(Kg)','width'=>80),
// 					//"isHaveGz" => '是否需要过账',
// 			);
			
			
// 			$smarty = &$this->_getView();
// 			$smarty->assign('title', '出库清单');
// 			$smarty->assign('arr_field_info', $arrFieldInfo);
// 			$smarty->assign('add_display', 'none');
// 			$smarty->assign('arr_condition', $arr);
// 			$smarty->assign('arr_field_value', $rowset);
// 			$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
// 			$tpl = 'Popup/commonNew.tpl';
// 			$arr['isHaveGz']==2 && $tpl="Tbllist.tpl";
// 			$smarty->display($tpl);
// 		}
	}
    /*
     * by li
     * 进行加工过账
     */
	function actionPopupOnGuozhangJg2(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
				'type'=>$_GET['type'],
				'productId' => '',
				'jiagonghuId' => '',
				'pinzhong' => '',
				'shazhi' => '',
				'guige' => '',
				'color' => '',
				'ganghao' => '',
				'benchangganghao' => '',
				'no_edit'=>'',
		));

		$_where="";
		if($arr['pinzhong']!='')$_where.=" and p.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['shazhi']!='')$_where.=" and p.proName like '%{$arr['shazhi']}%'";
		if($arr['guige']!='')$_where.=" and p.guige like '%{$arr['guige']}%'";
		if($arr['color']!='')$_where.=" and x.color like '%{$arr['color']}%'";
		if($arr['ganghao']!='')$_where.=" and x.pihao like '%{$arr['ganghao']}%'";
		if($arr['jiagonghuId']!='')$_where.=" and (c.id = '{$arr['jiagonghuId']}')";
		if($arr['benchangganghao']!='')$_where.=" and x.ganghao like '%{$arr['benchangganghao']}%'";
		//验收数据
		$sql_yanshou="select
			1 as isLingyong,
			y.id rukuId,
			y.rukuCode as code,
			y.rukuDate as date,
			y.type,
			y.kind,
			x.id,
			x.money,
			x.danjia,
			x.cnt,
			x.cntM,
			x.cntJian,
			x.color,
			x.pihao,
			x.ganghao,
			x.memoView,
			p.proName,
			p.guige,
			p.pinzhong,
		    c.id jiagonghuId,
			c.compName,
			c.feeBase
			from cangku_ruku y
			left join cangku_ruku_son x on x.rukuId=y.id			
			left join jichu_jiagonghu c on y.jiagonghuId=c.id
			left join jichu_product p on p.id=x.productId
			where y.isGuozhang=0 and y.isJiagong=1 and y.jiagonghuId>0 and c.feeBase=1 {$_where}
			and not exists(select * from caiwu_yf_guozhang where ruku2ProId=x.id and isLingyong=1)";
		//领用数据
		$sql_ling="select
			0 as isLingyong,
			y.id rukuId,
			y.chukuCode as code,
			y.chukuDate as date,
			y.type,
			y.kind,
			x.id,
			x.money,
			x.danjia,
			x.cnt,
			x.cntM,
			x.cntJian,
			x.color,
			x.pihao,
			x.ganghao,
			x.memoView,
			p.proName,
			p.guige,
			p.pinzhong,
		    c.id jiagonghuId,
			c.compName,
			c.feeBase
			from cangku_chuku y
			left join cangku_chuku_son x on x.chukuId=y.id			
			left join jichu_jiagonghu c on y.jiagonghuId=c.id
			left join jichu_product p on p.id=x.productId
			where y.isGuozhang=0 and y.isJiagong=1 and y.jiagonghuId>0 and c.feeBase=0 {$_where} 
			and not exists(select * from caiwu_yf_guozhang where ruku2ProId=x.id and isLingyong=0)";

		//把验收和领用一起显示
		$sql="{$sql_yanshou} union {$sql_ling}";
		//排序
		$sql .= " order by date,code";
			
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach ($rowset as & $v){
			$v['isChecked']="<input type='checkbox' id='isChecked[]' name='isChecked[]' value='{$v['id']}'/>";
			$v['zhekouMoney']="<input type='text' id='zhekouMoney[]' name='zhekouMoney[]' value=''/>";
			$v['_money']="<input type='text' id='_money[]' name='_money[]' value='{$v['money']}'/>";
			$v['money']="<input type='text' id='money[]' name='money[]' value='{$v['money']}' readonly='readonly'/>";
			$v['money'].="<input type='hidden' id='id[]' name='id[]' value='{$v['id']}' readonly='readonly'/>";
			$v['compName']=$v['compName'];
			$v['cnt']="<input type='text' id='cnt[]' name='cnt[]' value='{$v['cnt']}' readonly='readonly'/>";
			$v['danjia']=round($v['danjia'],6);
			$v['danjia']="<input type='text' id='danjia[]' name='danjia[]' value='{$v['danjia']}'/><input type='hidden' id='isLingyong[]' name='isLingyong[]' value='1' />";
			$v['code']="<input type='text'  style='width:100px'  id='Code[]' name='Code[]' value='{$v['code']}'  readonly='readonly'/>";
		}

		$heji = $this->getHeji($rowset, array('cnt'), 'date');
		$rowset[] = $heji;
		// 左边信息
		$arrFieldInfo = array(
		"isChecked"=>array('text'=>'选择','width'=>40),
		//"mingxi"=>"查看",
		"date" => array('text'=>'发生日期','width'=>80),
		"type" => array('text'=>'产品类型','width'=>80),
		'kind'=>'加工类型',
		'compName'=>'加工户',
		//'kuweiName'=>'库位',
		'code' => array('text'=>'单号','width'=>120),
		"cnt" => array('text'=>'加工数量(Kg)','width'=>80),
		//"Lcnt" => array('text'=>'领用数量(Kg)','width'=>80),
		'danjia'=>'单价',
		"money" => array('text'=>'发生金额','width'=>80),
		"zhekouMoney" =>'折扣金额',
		"_money" =>'入账金额',
		'pinzhong'=>'品种',
		'proName'=>'纱支',
		'guige'=>'规格',
		'color'=>'颜色',
		'pihao'=>'缸号',
		'ganghao'=>'本厂缸号',
		///"Lmoney" => array('text'=>'领用金额','width'=>80),
		'memoView'=>'备注',

		);
        //dump($rowset);exit;
		$smarty = &$this->_getView();
		$smarty->assign('title', '加工过账查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', $isShowAdd?'display':'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$other_url="<input type='button' id='save' name='save' value='保存'/>";
		$smarty->assign('other_url', $other_url);
		$smarty->assign('sonTpl', 'Caiwu/Yf/GuozhangTpl.tpl');
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr))."<font color='green'>一次过账>10,速度变慢！</font>");
		$tpl ="Tbllist.tpl";
		$smarty->display($tpl);
	}

	/**
	 * by shirui
	 * 进行加工过账
	 * 代码有问题，取消掉 by li
	 */
	/*function actionPopupOnGuozhangJg3(){
		FLEA::loadClass('TMIS_Pager');
		// /构造搜索区域的搜索类型
		// TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
				// 'dateFrom' => $_GET['dateFrom'],
				// 'dateTo' => $_GET['dateTo'],
				//'isRuku' =>'',//$_GET['isRuku'],
				'type'=>$_GET['type'],
				//'isHaveGz'=>$_GET['isHaveGz'],
				'productId' => '',
				'jiagonghuId' => '',
				//'kuweiId' => '',
				//'key' => '',
				// 'color' => '',
				//'dengji'=>'',
				'no_edit'=>'',
	
		)); //dump($arr);exit;
	
		$sql = "select
			y.id rukuId,			
		    c.id jiagonghuId,
			c.compName,
			c.feeBase
			from cangku_ruku y
			left join cangku_ruku_son x on x.rukuId=y.id			
			left join jichu_jiagonghu c on y.jiagonghuId=c.id
			where y.isGuozhang=0 and y.isJiagong=1 and y.jiagonghuId>0";
		if ($arr['jiagonghuId'] != '') $sql .= " and y.jiagonghuId = '{$arr['jiagonghuId']}'";
		//if ($arr['kuweiId'] != '') $sql .= " and y.kuweiId = '{$arr['kuweiId']}'";
		$arr['type']!='' && $sql.=" and y.type='{$arr['type']}'";
		//$sql.=" and not exists(select id from caiwu_yf_guozhang where rukuId=y.id)";
		$sql .= " order by y.rukuDate,y.rukuCode desc";
			
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		
		$ret=null;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//领用
			    if($v['feeBase']==0){			    	
			    	$sql="select x.*,y.chukuDate date,y.kind,y.type,y.chukuCode Code,z.proName,z.guige,pinzhong from cangku_chuku_son x 
			    			left join cangku_chuku y on y.id=x.chukuId
			    			left join jichu_product z on x.productId=z.id
			    			where y.rukuId='{$v['rukuId']}'
			    			and not exists(select * from caiwu_yf_guozhang where ruku2ProId=x.id)
			    	";
			    	$temp = $this->_modelExample->findBySql($sql);
			    		      	
		    		//dump($temp);exit;
		    		foreach ($temp as & $vv){
		    			$vv['isChecked']="<input type='checkbox' id='isChecked[]' name='isChecked[]' value='{$vv['id']}'/>";
		    			$vv['zhekouMoney']="<input type='text' id='zhekouMoney[]' name='zhekouMoney[]' value=''/>";
		    			$vv['_money']="<input type='text' id='_money[]' name='_money[]' value='{$vv['money']}'/>";
		    			$vv['money']="<input type='text' id='money[]' name='money[]' value='{$vv['money']}' readonly='readonly'/>";
		    			$vv['money'].="<input type='hidden' id='id[]' name='id[]' value='{$vv['id']}' readonly='readonly'/>";
		    			$vv['compName']=$v['compName'];
		    			$vv['cnt']="<input type='text' id='cnt[]' name='cnt[]' value='{$vv['cnt']}' readonly='readonly'/>";
		    			$vv['danjia']=round($vv['danjia'],6);
		    			$vv['danjia']="<input type='text' id='danjia[]' name='danjia[]' value='{$vv['danjia']}'/><input type='hidden' id='isLingyong[]' name='isLingyong[]' value='1' />";
		    			$vv['is']='领用';
		    			//$v['danjia'].="<input type='hidden' id='isLingyong[]' name='isLingyong[]' value=1/>";
		    			$ret[]=$vv; 	
		    			
		    		}
		    		
			    }
			    
			   //验收 
			    if($v['feeBase']==1){
			    	
			    	$sql="select x.*,y.rukuDate date,y.kind,y.type,y.rukuCode Code,z.proName,z.guige,pinzhong from cangku_ruku_son x
			    	left join cangku_ruku y on y.id=x.rukuId
			    	left join jichu_product z on x.productId=z.id
			    	where y.id='{$v['rukuId']}'
			    	and not exists(select * from caiwu_yf_guozhang where ruku2ProId=x.id)
			    	";
			    	$temp = $this->_modelExample->findBySql($sql);
			    	//dump($temp);exit;
			        foreach ($temp as & $vv){
			    		$vv['isChecked']="<input type='checkbox' id='isChecked[]' name='isChecked[]' value='{$vv['id']}'/>";
		    			$vv['zhekouMoney']="<input type='text' id='zhekouMoney[]' name='zhekouMoney[]' value=''/>";
		    			$vv['_money']="<input type='text' id='_money[]' name='_money[]' value='{$vv['money']}'/>";
		    			$vv['money']="<input type='text' id='money[]' name='money[]' value='{$vv['money']}' readonly='readonly'/>";
		    			$vv['money'].="<input type='hidden' id='id[]' name='id[]' value='{$vv['id']}' readonly='readonly'/>";
		    			$vv['compName']=$v['compName'];
		    			$vv['cnt']="<input type='text' id='cnt[]' name='cnt[]' value='{$vv['cnt']}' readonly='readonly'/>";
		    			$vv['danjia']=round($vv['danjia'],6);
		    			$vv['danjia']="<input type='text' id='danjia[]' name='danjia[]' value='{$vv['danjia']}'/><input type='hidden' id='isLingyong[]' name='isLingyong[]' value='0' />";		    			 
		    			$vv['is']='验收';
		    			//$v['danjia'].="<input type='hidden' id='isLingyong[]' name='isLingyong[]' value=0/>";
		    			$ret[]=$vv; 	
			    	}
			    	
			    }
			  
				
			
		}
	
			//dump($ret);exit;
		    // 合计行
 			$heji = $this->getHeji($ret, array('cnt'), 'date');
 			$ret[] = $heji;
			// 左边信息
			$arrFieldInfo = array(
			"isChecked"=>"过账选择",
			//"mingxi"=>"查看",
			"date" => array('text'=>'发生日期','width'=>80),
			'kind'=>'类型',
			'is'=>'过账类型',
			'compName'=>'加工户',
			//'kuweiName'=>'库位',
			
			'Code' => array('text'=>'单号','width'=>120),
			"type" => array('text'=>'类型','width'=>80),
			"cnt" => array('text'=>'加工数量(Kg)','width'=>80),
			//"Lcnt" => array('text'=>'领用数量(Kg)','width'=>80),
			'danjia'=>'单价',
			"money" => array('text'=>'发生金额','width'=>80),
			"zhekouMoney" =>'折扣金额',
			"_money" =>'入账金额',
			'proName'=>'纱支',
			'guige'=>'规格',
			'color'=>'颜色',
			///"Lmoney" => array('text'=>'领用金额','width'=>80),
			'memoView'=>'备注',

			);
            //dump($rowset);exit;
			$smarty = &$this->_getView();
			$smarty->assign('title', '加工过账查询');
			$smarty->assign('arr_field_info', $arrFieldInfo);
			$smarty->assign('add_display', $isShowAdd?'display':'none');
			$smarty->assign('arr_condition', $arr);
			$smarty->assign('arr_field_value', $ret);
			$other_url="<input type='button' id='save' name='save' value='保存'/>";
			$smarty->assign('other_url', $other_url);
			$smarty->assign('sonTpl', 'Caiwu/Yf/GuozhangTpl.tpl');
			$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr))."<font color='green'>一次过账>10,速度变慢！</font>");
			$tpl ="Tbllist.tpl";
			$smarty->display($tpl);
	}*/
	
	/**
	 * 标记是否需要过账
	 * Time：2014/08/19 14:34:23
	 * @author li
	*/
	function actionIsHaveGz(){
		$arr=array(
			'id'=>$_GET['id'],
			'isHaveGz'=>$_GET['isHaveGz'],
		);
		$_GET['isHaveGz']=='2' && $isHaveGz='0';
		$_GET['isHaveGz']=='0' && $isHaveGz='2';
		$this->_subModel->update($arr);
		js_alert(null,'',$this->_url($_GET['fromAction'],array('isHaveGz'=>$isHaveGz)));
	}

	/**
	 * 显示入库码单信息
	 * Time：2014/07/18 14:06:30
	 * @author li
	*/
	function actionViewMadan(){
		$smarty = & $this->_getView();
		$smarty->assign('title', "入库码单编辑");
		$smarty->display("Shengchan/Cangku/RkDajuanEdit.tpl");
	}


	/**
	 * 损耗统计报表，按照生产计划统计，可以统计到明细信息，看以查看订单号信息
	 * Time：2014/07/28 13:31:41
	 * @author li
	*/
	function actionSunhaoTongji(){
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'clientId'=>'',
			'jiagonghuId'=>'',
			'orderCode'=>'',
			'planCode'=>'',
			'key'=>'',
		));

		//按照计划信息显示列表，统计损耗信息
		$sql="select 
			x.productId,
			x.plan2proId,
			x.pihao,
			x.color,
			x.color,
			x.menfu,
			x.kezhong,
			sum(x.cnt) as cnt,
			sum(x.cntJian) as cntJian,
			y.jiagonghuId,
			z.planId,
			m.planCode,
			m.orderId,
			n.orderCode,
			n.clientId,
			a.compName,
			b.proCode,
			b.proName,
			b.pinzhong,
			b.zhonglei,
			b.guige,
			c.compName as jghName
			from cangku_ruku_son x
			inner join cangku_ruku y on y.id=x.rukuId
			left join shengchan_plan2product z on z.id=x.plan2proId
			left join shengchan_plan m on m.id=z.planId
			left join trade_order n on n.id=m.orderId
			left join jichu_client a on n.clientId=a.id
			left join jichu_product b on b.id=z.productId
			left join jichu_jiagonghu c on c.id=y.jiagonghuId
			where 1";

		$sql .= " and y.type='{$this->_type}'";
		$sql .= " and y.kind='{$this->_kind}'";
		if($arr['clientId']!='')$sql.=" and n.clientId = '{$arr['clientId']}'";
		if($arr['jiagonghuId']!='')$sql.=" and y.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['orderCode']!='')$sql.=" and n.orderCode like '%{$arr['orderCode']}%'";
		if($arr['planCode']!='')$sql.=" and m.planCode like '%{$arr['planCode']}%'";
		if($arr['key']!=''){
			$sql.=" and (x.color like '%{$arr['key']}%'
					  or b.proCode like '%{$arr['key']}%'
					  or b.pinzhong like '%{$arr['key']}%'
					  or b.guige like '%{$arr['key']}%'
				)";
		}
		$sql.=" group by x.plan2proId,y.jiagonghuId order by n.clientId,z.id desc,y.id desc,x.id";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach ($rowset as & $v) {
			//查找领料数量
			$sql="select sum(cnt) as cnt , sum(cntJian) as cntJian from cangku_chuku_son x
			left join cangku_chuku y on y.id=x.chukuId
			where 1 and y.jiagonghuId='{$v['jiagonghuId']}'
					and x.plan2proId='{$v['plan2proId']}'";
			//原料的类型，领用类别名称
			$sql.=" and y.type='{$this->_YlType}'";
			$sql .= " and y.kind='{$this->_kindLl}'";

			$_temp = $this->_modelExample->findBySql($sql);
			$v['llCnt'] = $_temp[0]['cnt'];
			$v['llCntJian'] = $_temp[0]['cntJian'];

			//损耗计算
			$v['sunhao'] = round(($v['llCnt']-$v['cnt'])/$v['llCnt']*100,2).' %';

			//显示的数量处理
			$v['llCnt'] = $v['llCnt']==0 ? '' : round($v['llCnt'],2);
			$v['llCntJian'] = $v['llCntJian']==0 ? '' : round($v['llCntJian'],2);
			$v['cntJian'] = $v['cntJian']==0 ? '' : round($v['cntJian'],2);
			$v['cnt'] = $v['cnt']==0 ? '' : round($v['cnt'],2);

		}

		// 合计行
		$heji = $this->getHeji($rowset, array('cntJian','cnt','llCnt','llCntJian'), 'compName');

		//处理明细信息
		foreach($rowset as & $v) {
			$v['cnt'] = "<a href='".url($_GET['controller'],'SunhaoView',array(
				'plan2proId'=>$v['plan2proId'],
				'jiagonghuId'=>$v['jiagonghuId'],
				'type'=>$this->_type,
				'kind'=>$this->_kind,
				'no_edit'=>1
			))."' target='_blank'>{$v['cnt']}</a>";

			$v['llCnt'] = "<a href='".url(str_replace( 'Scrk', 'Llck',$_GET['controller']),'SunhaoView',array(
				'plan2proId'=>$v['plan2proId'],
				'jiagonghuId'=>$v['jiagonghuId'],
				'type'=>$this->_YlType,
				'kind'=>$this->_kindLl,
				'no_edit'=>1
			))."' target='_blank'>{$v['llCnt']}</a>";
		}

		$rowset[] = $heji;

		$arrFieldInfo = $this->sunFiled ? $this->sunFiled : array(
			"compName" => "客户",
			'orderCode'=>'订单号',
			'planCode'=>'计划单号',
			'proCode'=>'产品编码',
			'pinzhong'=>'品种',
			'guige'=>'规格',
			'color'=>'颜色',
			'jghName'=>'加工户',
			'llCntJian'=>'领料件数',
			'llCnt'=>'领料数量',
			'cntJian'=>'验收件数',
			'cnt'=>'验收数量',
			'sunhao'=>'损耗(%)',
		);

		$smarty = &$this->_getView();
		$smarty->assign('title', '出库清单'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	/**
	 * 损耗明细信息(验收明细)
	 * Time：2014/07/28 14:39:43
	 * @author li
	*/
	function actionSunhaoView($filed){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$arr = TMIS_Pager::getParamArray(array(
			'plan2proId'=>'',
			'touliaoId'=>'',
			'planGxId'=>'',
			'jiagonghuId'=>'',
			'type'=>'',
			'color'=>'',
			'ganghao'=>'',
			'pihao'=>'',
			'rukuId'=>'',
			'productId'=>'',
			'kind'=>'',
			'rukuId'=>'',
			'no_edit'=>'',
		));
		// dump($serachArea);exit;
		$sql = "select 
			y.rukuCode,
			y.jiagonghuId,
			y.rukuDate,
			y.memo as chukuMemo,
			y.kind,
			x.planGxId,
			x.id,
			x.rukuId,
			x.pihao,
			x.dengji,
			x.productId,
			x.cnt,
			x.memoView,
			b.proCode,
			b.pinzhong,
			b.zhonglei,
			b.proName,
			b.guige,
			x.color,
			x.ganghao,
			x.chehao,
			x.shahao,
			b.kind as proKind,
			z.compName,
			a.kuweiName,
			g.touliaoId
			from cangku_ruku y
			left join cangku_ruku_son x on y.id=x.rukuId
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_product b on x.productId=b.id
			left join jichu_jiagonghu z on y.jiagonghuId=z.id
			left join shengchan_plan2product_gongxu g on g.id=x.planGxId
			where 1";

		$arr['type']!='' && $sql.=" and y.type='{$arr['type']}'";
		$arr['kind']!='' && $sql.=" and y.kind='{$arr['kind']}'";
		$arr['touliaoId']>0 && $sql.=" and g.touliaoId='{$arr['touliaoId']}'";
		$arr['planGxId']>0 && $sql.=" and x.planGxId='{$arr['planGxId']}'";
		$arr['plan2proId']>0 && $sql.=" and x.plan2proId='{$arr['plan2proId']}'";
		$arr['color']!='' && $sql.=" and x.color='{$arr['color']}'";
		$arr['ganghao']!='' && $sql.=" and x.ganghao='{$arr['ganghao']}'";
		$arr['pihao']!='' && $sql.=" and x.pihao='{$arr['pihao']}'";
		$arr['rukuId']!='' && $sql.=" and x.rukuId='{$arr['rukuId']}'";
		$arr['productId']!='' && $sql.=" and x.productId='{$arr['productId']}'";
		$arr['jiagonghuId']>0 && $sql.=" and y.jiagonghuId='{$arr['jiagonghuId']}'";
		$sql .= " order by rukuDate desc, rukuCode desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach($rowset as &$v) {
			
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
		$rowset[] = $heji;
		// 显示信息
		$filed = $filed ? $filed :array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
		);
		// 左边信息
		$arrFieldInfo = array(
			// 'touliaoId'=>'touliaoId',
			"rukuDate" => "发生日期",
			'kind'=>'入库类型',
			'compName'=>'加工户',
			'kuweiName'=>'库位',
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			)
		+
		$filed
		+
		array(
			
			'dengji'=>'等级',
			"cnt" => '数量(Kg)',
		); 

		$smarty = &$this->_getView();
		$smarty->assign('title', '验收明细'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	/**
	 * 获取单价信息：财务过账时候单价为0的情况需要自动判断单价
	 * Time：2014/08/19 10:57:19
	 * @author li
	 * @param GET:ruku2proId入库明细的id
	 * @return json
	*/
	function actionGetDanjiaByLs(){
		$ruku2ProId = (int)$_GET['ruku2ProId'];
		//查找该记录的信息
		$ruku2Info = $this->_subModel->find($ruku2ProId);

		//查找之前类似的信息是否存在单价
		$sql="select x.danjia from cangku_ruku_son x
		left join cangku_ruku y on x.rukuId=y.id
		where 
		x.productId='{$ruku2Info['productId']}'
		and x.color='{$ruku2Info['color']}' 
		and x.dengji='{$ruku2Info['dengji']}' 
		and y.isJiagong='{$ruku2Info['Rk']['isJiagong']}'
		and y.kind='{$ruku2Info['Rk']['kind']}'
		and y.type='{$ruku2Info['Rk']['type']}'
		and y.isGuozhang=0 and x.id<>'{$ruku2ProId}'";
		//加工则判断加工户，否则判断供应商
		if($ruku2Info['Rk']['isJiagong']==1){
			$sql.=" and y.jiagonghuId='{$ruku2Info['Rk']['jiagonghuId']}'";
		}else{
			$sql.=" and y.supplierId='{$ruku2Info['Rk']['supplierId']}'";
		}
		$sql.=" order by y.rukuDate desc,x.id desc limit 0,1";
		// echo $sql;
		$temp=$this->_subModel->findBySql($sql);
		$temp=$temp[0];
		$temp['danjia']=round($temp['danjia'],6);

		echo json_encode($temp);
	}

	/**
	 * 处理选择验收弹出界面中的ajax事件，标记是否已经选择过该记录
	 * Time：2014/10/17 13:44:58
	 * @author li
	 * @param get
	*/
	function actionIsLLAjax(){
		$cnt = $_GET['isTrue'];
		$arr=array(
			'id'=>$_GET['id'],
			'llCnt'=>$cnt,
		);
		// dump($arr);
		$true=$this->_modelExample->update($arr);
		echo json_encode(array('success'=>$true));
	}
	
	
	/*
	 * by shirui
	 * 显示入库明细
	 */
	function actionLookMX(){
		//dump($_GET);exit;
		if($_GET['JGtype']==0){
			$sql = "SELECT x.rukuCode,y.* FROM cangku_ruku x
			left join cangku_ruku_son y on x.id=y.rukuId
			WHERE x.id='{$_GET['id']}'";
			$rowset = $this->_modelExample->findBySql($sql);
			foreach ($rowset as & $v){
				$v['danjia']=round($v['danjia'],2);
			}			
			$heji = $this->getHeji($rowset, array('cnt','money'), 'rukuCode');
			//dump($rowset);exit;
			$tpl = "Caiwu/Yf/CaigouTpl.tpl";
			$smarty = & $this->_getView();
			$smarty->assign("title","开票记录");
			$smarty->assign("ret",$rowset);
			$smarty->assign("heji",$heji);
			$smarty->display($tpl);
		}
		
		if($_GET['JGtype']==1){
			
			//获得验收明细
			$sql = "SELECT x.jiagonghuId,x.rukuCode,y.*,z.proName,z.guige,pinzhong FROM cangku_ruku x
			left join cangku_ruku_son y on x.id=y.rukuId
			left join jichu_product z on y.productId=z.id
			WHERE x.id='{$_GET['id']}'";
			$rowset1 = $this->_modelExample->findBySql($sql);
	
			foreach ($rowset1 as & $v){
				$v['danjia']=round($v['danjia'],2);
				$v['money']=round($v['money'],2);
			}
			//dump($rowset1);exit;
			$heji1 = $this->getHeji($rowset1, array('cnt','money'), 'rukuCode');			
			
			//获得领用明细
			$sql = "SELECT x.chukuCode,y.*,z.proName,z.guige,pinzhong FROM cangku_chuku x
			left join cangku_chuku_son y on x.id=y.chukuId
			left join jichu_product z on y.productId=z.id
			WHERE x.rukuId='{$_GET['id']}'";
			$rowset2 = $this->_modelExample->findBySql($sql);			
			foreach ($rowset2 as & $v){
				$v['danjia']=round($v['danjia'],2);
				$v['money']=round($v['money'],2);
			}
			$heji2 = $this->getHeji($rowset2, array('cnt','money'), 'rukuCode');
			
			//dump($rowset2);exit;
			$tpl = "Caiwu/Yf/viewTpl.tpl";
			$smarty = & $this->_getView();
			$smarty->assign("title","开票记录");
			$smarty->assign("ret1",$rowset1);
			$smarty->assign("heji1",$heji1);
			$smarty->assign("ret2",$rowset2);
			$smarty->assign("heji2",$heji2);
			$smarty->display($tpl);
		}
		
		//加工过账
		if($_GET['JGtype']==2){
			if($_GET['type']=='纱'){		
				$sql = "SELECT x.rukuCode,y.*,z.proName,z.guige FROM cangku_ruku x
				left join cangku_ruku_son y on x.id=y.rukuId
				left join jichu_product z on y.productId=z.id
				WHERE x.id='{$_GET['id']}'";
				$rowset = $this->_modelExample->findBySql($sql);
				foreach ($rowset as & $v){
				$v['danjia']=round($v['danjia'],2);
				}
				$heji = $this->getHeji($rowset, array('cnt','money'), 'rukuCode');
				$tpl = "Caiwu/Yf/CaigouTpl.tpl";
				$smarty = & $this->_getView();
				$smarty->assign("title","开票记录");
				$smarty->assign("ret",$rowset);
				$smarty->assign("heji",$heji);
				$smarty->display($tpl);
			}else{
				$sql = "SELECT x.rukuCode,y.*,z.proName,z.guige,z.pinzhong FROM cangku_ruku x
				left join cangku_ruku_son y on x.id=y.rukuId
				left join jichu_product z on y.productId=z.id
				WHERE x.id='{$_GET['id']}'";
				$rowset = $this->_modelExample->findBySql($sql);
				foreach ($rowset as & $v){
				$v['danjia']=round($v['danjia'],2);
				}
				$heji = $this->getHeji($rowset, array('cnt','money'), 'rukuCode');
				$tpl = "Caiwu/Yf/CaigouTpl2.tpl";
				$smarty = & $this->_getView();
				$smarty->assign("title","开票记录");
				$smarty->assign("ret",$rowset);
				$smarty->assign("heji",$heji);
				$smarty->display($tpl);		
			}
		}
	}
	

	/*
	 * by shirui
	* 修改数据库中的单价金额
	*/
	function actionUpdateDanjia(){
	     //dump($_GET);exit;
	     if($_GET['isLingyong']>0){
	     	
	     	$sql="update cangku_chuku_son set danjia='{$_GET['danjia']}',money='{$_GET['money']}' where id='{$_GET['id']}'";
	     	//dump($sql);exit;
	     	$this->_modelExample->findBySql($sql);
	     	echo json_encode(true);	     	
	     }else{
	     	$sql="update cangku_ruku_son set danjia='{$_GET['danjia']}',money='{$_GET['money']}' where id='{$_GET['id']}'";
	     	$this->_modelExample->findBySql($sql);
	     	echo json_encode(true);
	     }
	}
	
	
	
	/*
	 * by shirui
	* 应付过账保存
	*/
	function actionJsonGuozhang(){
		//dump($_GET);exit;
		$ruku2ProId=explode(',', $_GET['ruku2ProId']);
		$isLingyong=explode(',', $_GET['str1']);
		$zhekouMoney=explode(',', $_GET['str2']);
		$_money=explode(',', $_GET['str3']);
		//dump($isLingyong[0]!=null);exit;
		if($isLingyong[0]!=null){		
			$i=0;
			foreach ($ruku2ProId as & $v){
				//获得验收明细
				$sql = "SELECT y.id,x.id rukuId,x.rukuDate,x.jiagonghuId,y.id ruku2ProId,y.supplierId,x.kind,x.memo,x.rukuCode,y.productId,y.danjia,y.money,y.cnt,z.proName,z.guige,pinzhong FROM cangku_ruku x
				left join cangku_ruku_son y on x.id=y.rukuId
				left join jichu_product z on y.productId=z.id			
				WHERE y.id='{$v}'";
				$rowset1 = $this->_modelExample->findBySql($sql);
				//dump($sql);exit;
				//获得领用明细
				$sql = "SELECT y.id,a.id rukuId,a.rukuDate,x.chukuCode,x.kind,x.memo,x.jiagonghuId,y.supplierId,y.productId,y.danjia,y.money,y.cnt,z.proName,z.guige,pinzhong FROM cangku_chuku x
				left join cangku_chuku_son y on x.id=y.chukuId
				left join jichu_product z on y.productId=z.id
				left join cangku_ruku a on a.id=x.rukuId
				WHERE y.id='{$v}'";
				$rowset2 = $this->_modelExample->findBySql($sql);			
				//dump($sql);exit;
				//dump($rowset1);exit;
				if($isLingyong[$i]==0){
					$rowset=$rowset1;
					$rowset[0]['isLingyong']=1;
				}else if($isLingyong[$i]==1){
					$rowset=$rowset2;
					$rowset[0]['isLingyong']=0;								
				}
				$rowset[0]['isJiagong']=0;
				//dump($rowset);exit;
				$rowset[0]['qitaMemo']=' ';
				
				$rowset[0]['creater']=$_SESSION['REALNAME'];
				$rowset[0]['guozhangDate']=date('Y-m-d');
				//dump($rowset);exit;
				$sql="insert into caiwu_yf_guozhang(rukuDate,ruku2ProId,rukuId,supplierId,guozhangDate,kind,productId,cnt,danjia,_money,money,zhekouMoney,qitaMemo,memo,isJiagong,isLingyong,creater)
				values('{$rowset[0]['rukuDate']}','{$rowset[0]['id']}','{$rowset[0]['rukuId']}','{$rowset[0]['jiagonghuId']}','{$rowset[0]['guozhangDate']}','{$rowset[0]['kind']}','{$rowset[0]['productId']}','{$rowset[0]['cnt']}','{$rowset[0]['danjia']}','{$rowset[0]['money']}','{$_money[$i]}','{$zhekouMoney[$i]}','{$rowset[0]['qitaMemo']}','{$rowset[0]['memo']}','{$rowset[0]['isJiagong']}','{$rowset[0]['isLingyong']}','{$rowset[0]['creater']}')";
				$re=$this->_modelExample->findBySql($sql);
				//dump($re);exit;
				// $sql="update cangku_ruku set isGuozhang=1 where id='{$v}'";
				// $this->_modelExample->findBySql($sql);
				$i++;
			}
			echo json_encode(true);
		}else{			
			$i=0;
			foreach ($ruku2ProId as & $v){
			$sql = "SELECT y.id,x.id rukuId,x.rukuDate,y.id ruku2ProId,y.supplierId,x.kind,x.memo,x.rukuCode,y.productId,y.danjia,y.money,y.cnt,z.proName,z.guige,pinzhong FROM cangku_ruku x
			left join cangku_ruku_son y on x.id=y.rukuId
			left join jichu_product z on y.productId=z.id
			WHERE y.id='{$v}'";
			$rowset = $this->_modelExample->findBySql($sql);
			$rowset[0]['isLingyong']=1;			
			$rowset[0]['isJiagong']=0;
			//dump($rowset);exit;
			$rowset[0]['qitaMemo']=' ';
			
			$rowset[0]['creater']=$_SESSION['REALNAME'];
			$rowset[0]['guozhangDate']=date('Y-m-d');
			//dump($rowset);exit;
			$sql="insert into caiwu_yf_guozhang(rukuDate,ruku2ProId,rukuId,supplierId,guozhangDate,kind,productId,cnt,danjia,_money,money,zhekouMoney,qitaMemo,memo,isJiagong,isLingyong,creater)
			values('{$rowset[0]['rukuDate']}','{$rowset[0]['id']}','{$rowset[0]['rukuId']}','{$rowset[0]['supplierId']}','{$rowset[0]['guozhangDate']}','{$rowset[0]['kind']}','{$rowset[0]['productId']}','{$rowset[0]['cnt']}','{$rowset[0]['danjia']}','{$rowset[0]['money']}','{$_money[$i]}','{$zhekouMoney[$i]}','{$rowset[0]['qitaMemo']}','{$rowset[0]['memo']}','{$rowset[0]['isJiagong']}','{$rowset[0]['isLingyong']}','{$rowset[0]['creater']}')";
			$re=$this->_modelExample->findBySql($sql);			
			$i++;
		}
		echo json_encode(true);
	  }
	}
	
	/*
	 * by shirui
	 * 获得明细修改后的money
	 */
	function actionGetMoney(){
		//dump($_GET);exit;
		$sql="select sum(money) money from cangku_ruku_son where rukuId='{$_GET['id']}'";
		$re=$this->_modelExample->findBySql($sql);
		$money=round($re[0]['money']-$_GET['zhekouMoney'],2);
		$sql="update caiwu_yf_guozhang set _money='{$re[0]['money']}',money='{$money}' where rukuId='{$_GET['id']}'";
		$this->_modelExample->findBySql($sql);
		
		$ret['money']=$re[0]['money'];
		$ret['money2']=$money;
		//dump($ret);exit;
		echo json_encode($ret);
	}
}
?>