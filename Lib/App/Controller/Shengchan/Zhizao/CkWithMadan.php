<?php
FLEA::loadClass('Controller_Shengchan_Chuku');
class Controller_Shengchan_Zhizao_CkWithMadan extends Controller_Shengchan_Chuku {
	var $fldMain;
	var $headSon;
	var $rules; //表单元素的验证规则
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '坯布';
		$this->_kind="销售出库";
		$this->_tuiKind="销售退回";
		$this->_head="ZZXS";
		//出库主信息
		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode($this->_head,'cangku_chuku','chukuCode')),
			'chukuDate' => array('title' => '出库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
			'orderId' => array(
				'title' => '相关订单', 
				'type' => 'popup', 
				'name'=>'orderId',
				'url'=>url('Trade_Order','PopupHuaxing'),
				'onSelFunc'=>'onSel',//选中后需要执行的回调函数名,需要在jsTpl中书写
				'textFld'=>'orderCode',//显示在text中的字段
				'hiddenFld'=>'orderId',//显示在hidden控件中的字段
				'dialogWidth'=>860
			),
			// 'orderCode' =>array('title' => '相关订单', 'type' =>'text', 'readonly' => true),
			'clientName'=>array('title' => '客户选择', 'type' =>'text', 'readonly' => true),
			'cntYaohuo'=>array('type'=>'text',"title"=>'要货数量','readonly' => true),
			'proCode' => array('title' => '产品编号', 'type' => 'text', 'value' => '', 'readonly' => true),
			'pinzhong' => array('title' => '品种', 'type' => 'text', 'value' => '', 'readonly' => true),
			'guige' => array('title' => '规格', 'type' => 'text', 'value' => '', 'readonly' => true),
			'color' => array('title' => '颜色', 'type' => 'text', 'value' => '', 'readonly' => true),
			'menfu'=>array('type'=>'text',"title"=>'门幅', 'readonly' => true,'addonEnd'=>'M'),
			'kezhong'=>array('type'=>'text',"title"=>'克重', 'readonly' =>true,'addonEnd'=>'g/m<sup>2</sup>'),
			'kuweiId' => array(
				'title' => '仓库名称', 
				"type" => "Popup",
				'url'=>url('Jichu_kuwei','popup'),
				'textFld'=>'kuweiName',
				'hiddenFld'=>'id',
			),
			'people' => array('title' => '联系人', 'type' => 'text', 'value' => ''),
			'phone' => array('title' => '联系电话', 'type' => 'text', 'value' => ''),
			'addressCk' => array('title' => '发货地址', 'type' => 'textarea', 'value' => ''),

			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注说明','type'=>'textarea','name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			'clientId' => array('type' => 'hidden', 'value' => ''),
			'ord2proId' => array('type' => 'hidden', 'value' => ''),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			'unit'=>array('type'=>'hidden',"title"=>'要货单位','readonly' => true),
			'danjia'=>array('type'=>'hidden',"title"=>'单价'),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
		);
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			// 'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'ruku2proId'=>array(
				'title' => '验收记录', 
				"type" => "btPopup",
				'url'=>url('Shengchan_Zhizao_CkWithMadan','ListMadan'),
				'textFld'=>'rukuCode',
				'hiddenFld'=>'id',
				'inTable'=>true,
				'dialogWidth'=>900,
				'name'=>'ruku2proId[]',
			),
			// 'proCode' => array('type' => 'bttext', "title" => '产品编码','name' =>'proCode[]','readonly'=>true),
			// 'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			// 'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'rukuDate'=>array('type'=>'bttext',"title"=>'入库日期','name'=>'rukuDate[]','readonly'=>true),
			'ganghao'=>array('type'=>'bttext',"title"=>'本厂缸号','name'=>'ganghao[]','style'=>'min-width:110','readonly'=>true),
			'shahao'=>array('type'=>'bttext',"title"=>'纱号','name'=>'shahao[]','readonly'=>true),
			'chehao'=>array('type'=>'bttext',"title"=>'车号','name'=>'chehao[]','readonly'=>true),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]','readonly'=>true),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]','readonly'=>true),
			'cntM' => array('type' => 'bttext', "title" => '数量(M)', 'name' => 'cntM[]','readonly'=>true),
			'Madan' => array('type' => 'btBtnMadan', "title" => '码单', 'name' => 'Madan[]'),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'money' => array('type' => 'bthidden', 'name' => 'money[]'),
			// 'productId' => array('type' => 'bthidden', 'name' => 'productId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'orderId' => 'required',
			// 'clientId' => 'required',
			'kuweiId' => 'required'
		);

		$this->sonTpl=array(
			"Shengchan/Cangku/MadanCkJs.tpl",
			'Shengchan/kuweiJs.tpl'
		);

		$this->_addCheck="3-2-1-5";
		$this->_rightCheck="";
	}

	/**
	 * 按码单出库跳转
	 * Time：2014/06/27 10:39:52
	 * @author li
	*/
	function actionCkMadan(){
		//入库明细信息，入库关联信息
		$mm = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku2Product');
		$rk_arr = $mm->find(array('id' => $_GET['ruku2proId']));
		// dump($rk_arr);exit;

		//查找计划信息
		$plan = &FLEA::getSingleton('Model_Shengchan_Plan');
		$sql="select z.orderCode,y.orderId,x.planId,z.clientId,a.compName,x.ord2proId,y.danjia from shengchan_plan2product x
		left join trade_order2product y on x.ord2proId=y.id
		left join trade_order z on z.id=y.orderId
		left join jichu_client a on a.id=z.clientId
		where x.id='{$rk_arr['plan2proId']}'";
		$planInfo = $plan->findBySql($sql);
		$planInfo = $planInfo[0];
		// dump($planInfo);exit;

		//创建数组，组织需要显示的信息
		$arr=array(
			'orderId'=>$planInfo['orderId'],
			'orderCode'=>$planInfo['orderCode'],
			'clientId'=>$planInfo['clientId'],
			'clientName'=>$planInfo['compName'],
			'kuweiId'=>$rk_arr['Rk']['kuweiId'],
		);
		// dump($arr);exit;
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}
		// dump($this->fldMain);exit;
		// //加载库位信息的值
		$areaMain = array('title' => '码单出库基本信息', 'fld' => $this->fldMain);

		// 入库明细处理
		$product=array();
		/**
		* 产品明细信息
		*/
		$sql = "select * from jichu_product where id='{$rk_arr['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql);
		$temp['proCode'] = $_temp[0]['proCode'];
		$temp['pinzhong'] = $_temp[0]['pinzhong'];
		$temp['guige'] = $_temp[0]['guige'];

		$temp['color'] = $rk_arr['color'];
		$temp['menfu'] = $rk_arr['menfu'];
		$temp['kezhong'] = $rk_arr['kezhong'];
		$temp['ganghao'] = $rk_arr['ganghao'];
		$temp['dengji'] = $rk_arr['dengji'];
		$temp['productId'] = $rk_arr['productId'];
		$temp['ord2proId'] = $planInfo['ord2proId'];
		$temp['ruku2proId'] = $rk_arr['id'];
		$temp['danjia']=$planInfo['danjia'];
		
		$product[]=$temp;

		$rowsSon = array();
		foreach($product as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}
		// dump($rowsSon);exit;
		

		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']);
		$smarty->assign('sonTpl', $this->sonTpl);
		$smarty->assign('rules', $this->rules);
		// $this->_beforeDisplayEdit($smarty);
		$smarty->display('Main2Son/T1.tpl');
	}

	//修改
	function actionEdit(){
		$this->authCheck($this->_addCheck);
		$arr = $this->_modelExample->find(array('id' => $_GET['id']));
		//子表中的部分信息放到主表信息中
		$ord2proId=$arr['Products'][0]['ord2proId'];
		$productId=$arr['Products'][0]['productId'];
		$arr['ord2proId']=$ord2proId;
		$arr['productId']=$productId;

		//查找数据
		$sql="select * from jichu_product where id='{$productId}'";
		$res = $this->_modelExample->findBySql($sql);
		$arr['proCode']=$res[0]['proCode'];
		$arr['pinzhong']=$res[0]['pinzhong'];
		$arr['guige']=$res[0]['guige'];

		//查找订单明细信息
		$sql="select * from trade_order2product where id='{$ord2proId}'";
		$res = $this->_modelExample->findBySql($sql);
		$arr['cntYaohuo']=$res[0]['cntYaohuo'].$res[0]['unit'];
		$arr['unit']=$res[0]['unit'];
		$arr['menfu']=$res[0]['menfu'];
		$arr['kezhong']=$res[0]['kezhong'];
		$arr['danjia']=$res[0]['danjia'];

		//
		$arr['color']=$arr['Products'][0]['color'];
		$arr['ord2proId']=$arr['Products'][0]['ord2proId'];

		//主信息
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}
		// dump($arr);exit;

		//仓库信息
		if($arr['kuweiId']>0){
			$sql="select kuweiName from jichu_kuwei where id='{$arr['kuweiId']}'";
			$temp=$this->_subModel->findBySql($sql);
			$this->fldMain['kuweiId'] && $this->fldMain['kuweiId']['text']=$temp[0]['kuweiName'];
		}

		// //加载库位信息的值
		$areaMain = array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain);

		$orderId= $arr['orderId'];
		$sql = "select orderCode,clientId from trade_order where id='{$orderId}'";
		$_rows = $this->_modelExample->findBySql($sql);
		$areaMain['fld']['orderId']['text'] = $_rows[0]['orderCode'];

		//查找客户信息
		$sql="select compName from jichu_client where id='{$arr['clientId']}'";
		$_rows = $this->_modelExample->findBySql($sql);
		$areaMain['fld']['clientName']['value'] = $_rows[0]['compName'];

		// 入库明细处理
		$rowsSon = array();
		foreach($arr['Products'] as &$v) {
			$v['cnt'] = round($v['cnt'],2);
			$v['cntM'] = round($v['cntM'],2);
		}
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}

		//查找码单对应的ruku2proId信息
		foreach($rowsSon as & $v){
			if(empty($v['id']['value']))continue;
			$sql="select ruku2proId,number,id from cangku_madan where chuku2proId='{$v['id']['value']}'";
			$temp=$this->_modelExample->findBySql($sql);
			// dump($temp);exit;
			$v['ruku2proId']['value']=$temp[0]['ruku2proId'];
			//处理已选择的码单信息
			$v['Madan']['value']=join(',',array_col_values($temp,'id')).';'.join(',',array_col_values($temp,'number'));

			//查找验收信息
			$sql="select x.*,y.rukuCode,y.rukuDate from cangku_ruku_son x
			left join cangku_ruku y on x.rukuId=y.id
			where x.id='{$v['ruku2proId']['value']}'";
			$temp=$this->_modelExample->findBySql($sql);
			// dump($temp);exit;
			$v['ruku2proId']['text']=$temp[0]['rukuCode'];
			$v['rukuDate']['value']=$temp[0]['rukuDate'];
			$v['chehao']['value']=$temp[0]['chehao'];
			$v['shahao']['value']=$temp[0]['shahao'];
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
		$smarty->assign('sonTpl', $this->sonTpl);
		$smarty->assign('rules', $this->rules);
		$smarty->display('Main2Son/T1.tpl');
	}
	

	//修改时要显示订单号
	function _beforeDisplayEdit(& $smarty) {
		$rowsSon = & $smarty->_tpl_vars['rowsSon'];
		$areaMain = & $smarty->_tpl_vars['areaMain'];
		// dump($smarty->_tpl_vars);dump($areaMain);exit;
		$orderId= $areaMain['fld']['orderId']['value'];
		$sql = "select orderCode,clientId from trade_order where id='{$orderId}'";
		// dump($sql);
		$_rows = $this->_modelExample->findBySql($sql);

		$areaMain['fld']['orderId']['text'] = $_rows[0]['orderCode'];

		//查找客户信息
		$sql="select compName from jichu_client where id='{$_rows[0]['clientId']}'";
		$_rows = $this->_modelExample->findBySql($sql);
		$areaMain['fld']['clientName']['value'] = $_rows[0]['compName'];

		// dump($rowsSon);exit;
		//订单明细id
		$ord2proId = $areaMain[''];
		//查找产品信息
		$sql="select * from jichu_product where id='{}'";

		//查找码单对应的ruku2proId信息
		foreach($rowsSon as & $v){
			if(empty($v['id']['value']))continue;
			$sql="select ruku2proId,number,id from cangku_madan where chuku2proId='{$v['id']['value']}'";
			$temp=$this->_modelExample->findBySql($sql);
			// dump($temp);exit;
			$v['ruku2proId']['value']=$temp[0]['ruku2proId'];
			//处理已选择的码单信息
			$v['Madan']['value']=join(',',array_col_values($temp,'id')).';'.join(',',array_col_values($temp,'number'));

			//查找验收信息
			$sql="select x.*,y.rukuCode,y.rukuDate from cangku_ruku_son x
			left join cangku_ruku y on x.rukuId=y.id
			where x.id='{$v['ruku2proId']['value']}'";
			$temp=$this->_modelExample->findBySql($sql);
			// dump($temp);exit;
			$v['ruku2proId']['text']=$temp[0]['rukuCode'];
			$v['rukuDate']['value']=$temp[0]['rukuDate'];
			$v['chehao']['value']=$temp[0]['chehao'];
			$v['shahao']['value']=$temp[0]['shahao'];
		}
		// dump($areaMain);exit;
	}

	/**
	 * 按照码单出库
	 * Time：2014/06/26 15:12:24
	 * @author li
	*/
	function actionListMadanCk(){
		// $this->authCheck('3-2-1-5');
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'kuweiId'=>'',
			// 'clientId'=>'',
			// 'orderCode'=>'',
			'pinzhong'=>'',
			'guige'=>'',
			'color'=>'',
		));
		//查找码单没有出完的入库id
		$str="select distinct ruku2proId from cangku_madan where chuku2proId=0";
		$temp=$this->_subModel->findBySql($str);
		$ruku2proId = join(',',array_col_values($temp,'ruku2proId'));
		$ruku2proId=='' && $ruku2proId="null";
		//查找数据
		$sql="select x.*,z.pinzhong,z.proCode,z.guige,y.rukuCode,y.rukuDate,b.kuweiName from cangku_ruku_son x
			inner join cangku_ruku y on x.rukuId=y.id
			left join jichu_product z on z.id=x.productId
			left join jichu_kuwei b on b.id=y.kuweiId
			where 1";
		$sql.=" and y.type='{$this->_type}'";
		// $sql.=" and y.kind='织布验收'";
		$sql.=" and x.id in({$ruku2proId})";
		$arr['kuweiId']!='' && $sql.=" and y.kuweiId='{$arr['kuweiId']}'";
		$arr['clientId']!='' && $sql.=" and a.clientId='{$arr['clientId']}'";
		$arr['orderCode']!='' && $sql.=" and a.orderCode like '%{$arr['orderCode']}%'";
		$arr['pinzhong']!='' && $sql.=" and z.pinzhong like '%{$arr['pinzhong']}%'";
		$arr['guige']!='' && $sql.=" and z.guige like '%{$arr['guige']}%'";
		$arr['color']!='' && $sql.=" and z.color like '%{$arr['color']}%'";
		//排序
		$sql.=" order by y.rukuCode desc,y.id desc,x.id desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach ($rowset as $key => & $v) {
			$v['_edit']="<a href='".$this->_url('CkMadan',array(
				'ruku2proId'=>$v['id'],
				'rukuId'=>$v['rukuId'],
				'fromAction'=>$_GET['action']
				))."'>整单出库</a>";
		}
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => '操作',
			"rukuDate" => array('text'=>'入库日期','width'=>80),
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			// 'orderCode'=>'订单号',
			// 'compName'=>'客户',
			'kuweiName'=>array('text'=>'仓库','width'=>80),			
			"proCode" => array('text'=>'产品编号','width'=>80), 
			"pinzhong" => array('text'=>'品种','width'=>80), 
			"guige" => '规格', 
			"color" => array('text'=>'颜色','width'=>80),
			"ganghao" => array('text'=>'本厂缸号','width'=>80), 
			'dengji'=>array('text'=>'等级','width'=>80),
			'cntJian'=>array('text'=>'件数','width'=>50),
			'cnt'=>array('text'=>'数量(Kg)','width'=>70),
			'cntM'=>array('text'=>'数量(M)','width'=>70),
			"memoView" => array('text'=>'备注','width'=>200), 
		);
		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	}

	/**
	 * ps ：选择出库码单信息
	 * Time：2014/08/14 16:12:25
	 * @author li
	*/
	function actionListMadan(){
		// $this->authCheck('3-2-1-5');
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'kuweiId2'=>'',
			// 'clientId'=>'',
			// 'orderCode'=>'',
			'productId'=>'',
			'ganghao'=>'',
			// 'pinzhong'=>'',
			// 'guige'=>'',
			'color2'=>'',
		));
		//查找码单没有出完的入库id
		$str="select distinct ruku2proId from cangku_madan where chuku2proId=0";
		$temp=$this->_subModel->findBySql($str);
		$ruku2proId = join(',',array_col_values($temp,'ruku2proId'));
		$ruku2proId=='' && $ruku2proId="null";
		//查找数据
		$sql="select x.*,z.pinzhong,z.proCode,z.guige,y.rukuCode,y.rukuDate,b.kuweiName from cangku_ruku_son x
			inner join cangku_ruku y on x.rukuId=y.id
			left join jichu_product z on z.id=x.productId
			left join jichu_kuwei b on b.id=y.kuweiId
			where 1";
		$sql.=" and y.type='{$this->_type}'";
		// $sql.=" and y.kind='织布验收'";
		$sql.=" and x.id in({$ruku2proId})";
		$arr['kuweiId2']!='' && $sql.=" and y.kuweiId='{$arr['kuweiId2']}'";
		$arr['clientId']!='' && $sql.=" and a.clientId='{$arr['clientId']}'";
		$arr['productId']!='' && $sql.=" and x.productId='{$arr['productId']}'";
		$arr['orderCode']!='' && $sql.=" and a.orderCode like '%{$arr['orderCode']}%'";
		$arr['pinzhong']!='' && $sql.=" and z.pinzhong like '%{$arr['pinzhong']}%'";
		$arr['ganghao']!='' && $sql.=" and x.ganghao like '%{$arr['ganghao']}%'";
		$arr['guige']!='' && $sql.=" and z.guige like '%{$arr['guige']}%'";
		$arr['color2']!='' && $sql.=" and z.color like '%{$arr['color2']}%'";
		//排序
		$sql.=" order by y.rukuCode desc,y.id desc,x.id desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		foreach ($rowset as $key => & $v) {
			$v['cnt']=round($v['cnt'],2);
			$v['cntM']=round($v['cntM'],2);
		}
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"rukuDate" => array('text'=>'入库日期','width'=>80),
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			'kuweiName'=>array('text'=>'仓库','width'=>120),			
			"proCode" => array('text'=>'产品编号','width'=>80), 
			"pinzhong" => array('text'=>'品种','width'=>80), 
			"guige" => '规格', 
			"color" => array('text'=>'颜色','width'=>80),
			"ganghao" => array('text'=>'本厂缸号','width'=>100), 
			'dengji'=>array('text'=>'等级','width'=>80),
			'cntJian'=>array('text'=>'件数','width'=>50),
			'cnt'=>array('text'=>'数量(Kg)','width'=>70),
			'cntM'=>array('text'=>'数量(M)','width'=>70),
		);
		$smarty->assign('title', '验收列表');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 显示码单界面，操作需要出库的码单信息
	 * Time：2014/06/27 13:37:30
	 * @author li
	*/
	function actionViewMadan(){
		// dump($_GET);exit;
		$this->authCheck();
		$_GET['ruku2proId']=(int)$_GET['ruku2proId'];
		//查找所有已设置的码单信息
		$madan = & FLEA::getSingleton('Model_Shengchan_Cangku_Madan');
		$madan->clearLinks();
		//查找所有码单
		$madanArr = $madan->findAll(array('ruku2proId'=>$_GET['ruku2proId']));
		$temp=array();
		foreach ($madanArr as $key => & $v) {
			//如果以有出库信息的，默认选中，出库id不同的，表示不能操作了
			$v['isChecked']=$v['chuku2proId']>0?true:false;
			if(!empty($v['chuku2proId']) && $v['chuku2proId']!=$_GET['chuku2proId']){
				$v['disabled']=true;
			}else $v['disabled']=false;

			$temp[$v['number']-1]=$v;
		}
		$madanArr=$temp;
		//组织数组信息
		$row = array('Madan'=>$madanArr);
		// dump($row);exit;
		$smarty = & $this->_getView();
		$smarty->assign('title', "设置码单");
		// $smarty->assign('fromAction', $_GET['fromAction']);
		$smarty->assign('madanRows', json_encode($madanArr));
		$smarty->display("Shengchan/Cangku/CkDajuanEdit.tpl");
	}

	/**
	 * 保存重写，因为这里需要处理码单信息
	 * Time：2014/06/27 17:23:09
	 * @author li
	*/
	function actionSave(){
		// dump($_POST);exit;
		//开始保存
		$pros = array();//明细信息
		$madan_clear = array();//需要清空的码单数据:原来选中，后来取消的情况下

		//获取主要信息中需要保存在明细表中的数据
		$product=array(
			'productId'=>$_POST['productId'],
			'ord2proId'=>$_POST['ord2proId'],
			'danjia'=>$_POST['danjia'],
			'color'=>$_POST['color'],
			'menfu'=>$_POST['menfu'],
			'kezhong'=>$_POST['kezhong'],
		);
		//循环处理数据,有效判断为是否存在ruku2proId(ruku明细表id)
		foreach ($_POST['ruku2proId'] as $key => & $v) {
			if($v=='' || empty($_POST['cnt'][$key])) continue;
			//产品信息取主信息中的数据
			$temp = $product;
			foreach($this->headSon as $k=>&$vv) {
				//查找码单是否设置
				if($k=='Madan'){
					$_madan=explode(';', $_POST[$k][$key]);
					$_madanId=$_madan[0];
					$_madan=explode(',', $_madanId);
					//如果已出库的信息，则需要删除取消掉的码单信息
					if($_POST['id'][$key]>0 && count($_madan)>0){
						$sql="select id from cangku_madan where chuku2proId='{$_POST['id'][$key]}' and id not in({$_madanId})";
						$res=$this->_modelExample->findBySql($sql);
						$madan_clear+=$res;
					}
					// dump($vv);exit;
					foreach($_madan as & $cc){
						$temp[$k][]=array('id'=>$cc);
					}
					// dump($temp);exit;
				}else $temp[$k] = $_POST[$k][$key];
			}

			//计算金额，需要考虑单位信息
			$temp['money']=$_POST['kezhong']=='Kg' ? $temp['danjia']*$temp['cnt'] : $temp['danjia']*$temp['cntM'];

			//明细数据
			$pros[]=$temp;
		}

		//判断是否存在有效明细数据
		if(count($pros)==0) {
			js_alert('请选择有效的产品明细信息!','window.history.go(-1)');
			exit;
		}

		//主信息
		$row = array();
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$row[$k] = $_POST[$name];
		}

		$row['Products'] = $pros;
		// dump($row);dump($madan_clear);exit;
		if(!$this->_modelExample->save($row)) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}

		//该出库单取消出库的码单信息，码单的出库Id 更新为0
		$strSonId=join(',',array_col_values($madan_clear,'id'));
		if($strSonId!=''){
			$sql="update cangku_madan set chuku2proId='0' where id in ({$strSonId})";
			mysql_query($sql);
		}

		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;

	}

	//原来的保存动作，暂时取消掉
	function actionSaveOld(){
		// dump($_POST);exit;
		//开始保存
		$pros = array();
		$madan_clear = array();
		foreach($_POST['productId'] as $key=>&$v) {
			if($v=='' || empty($_POST['cnt'][$key])) continue;
			$temp = array();
			foreach($this->headSon as $k=>&$vv) {
				//查找码单是否设置
				if($k=='Madan'){
					$_madan=explode(';', $_POST[$k][$key]);
					$_madanIdStr=$_madan[0];
					$_madan=explode(',', $_madanIdStr);
					//如果已出库的信息，则需要删除取消掉的码单信息
					if($_POST['id'][$key]>0 && count($_madan)>0){
						$sql="select id from cangku_madan where chuku2proId='{$_POST['id'][$key]}' and id not in({$_madanIdStr})";
						// dump($sql);exit;
						$res=$this->_modelExample->findBySql($sql);
						$madan_clear+=$res;
						// dump($res);exit;
					}
					// dump($vv);exit;
					foreach($_madan as & $cc){
						$temp[$k][]=array('id'=>$cc);
					}
					// dump($temp);exit;
				}else $temp[$k] = $_POST[$k][$key];
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
		// dump($madan_clear);exit;
		if(!$this->_modelExample->save($row)) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}

		//该出库单取消出库的码单信息，码单的出库Id 更新为0
		$strSonId=join(',',array_col_values($madan_clear,'id'));
		if($strSonId!=''){
			$sql="update cangku_madan set chuku2proId='0' where id in ({$strSonId})";
			mysql_query($sql);
		}

		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	/**
	 * 查询界面使用成品出库界面的查询
	 * Time：2014/07/01 10:42:39
	 * @author li
	*/
	function actionRight(){
		redirect(url("Shengchan_Zhizao_Cpck",'right'));	exit;
	}
}
?>