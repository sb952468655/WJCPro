<?php
FLEA::loadClass('Controller_Shengchan_Ruku');
class Controller_Shengchan_Zhizao_Scrk extends Controller_Shengchan_Ruku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->chukuModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Chuku');
		$this->_type = '坯布';
		$this->_kind="织布验收";
		$this->_tuiKind="织布验收退回";
		$this->_kindLl="织布领料";
		$this->_YlType="纱";
		$this->_head="ZBYS";
		// 定义模板中的主表字段
		$this->fldMain = array(
			'rukuCode' => array('title' => '验收单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode($this->_head,'cangku_ruku','rukuCode')),
			'rukuDate' => array('title' => '入库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind'=>array('title'=>'入库类型','type'=>'text','readonly'=>true,'name'=>'kind','value'=>$this->_kind),
			'jiagonghuId' => array('title' => '加工户', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=0'),
			'kuweiIdLl' => array(
				'title' => '领料仓库', 
				"type" => "Popup",
				'url'=>url('Jichu_kuwei','popup'),
				'textFld'=>'kuweiName',
				'hiddenFld'=>'id',
			),
			'kuweiIdYs' => array(
				'title' => '验收仓库', 
				"type" => "Popup",
				'url'=>url('Jichu_kuwei','popup'),
				'textFld'=>'kuweiName',
				'hiddenFld'=>'id',
			),
			// 'kuweiId' => array('title' => '仓库名称', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'cgrkId'),
			'llckId' => array('type' => 'hidden', 'value' => '','name'=>'llckId'),
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
			'planGxId' => array(
				'title' => '投料计划', 
				"type" => "btPopup",
				'name' => 'planGxId[]',
				'url'=>url('Shengchan_PlanTl','popupGx',array('gongxuName'=>'坯布织造','ColType'=>$this->_kind)),
				'textFld'=>'touliaoCode',
				'hiddenFld'=>'plangxId',
				'inTable'=>true,
				'dialogWidth'=>960
			),
			'productId' => array(
				'title' => '产品选择', 
				"type" => "btPopup",
				'name' => 'productId[]',
				'url'=>url('jichu_product','PopupReport'),
				'textFld'=>'proCode',
				'hiddenFld'=>'productId',
				'inTable'=>true,
				'dialogWidth'=>900
			),
			// 'productId' => array('type' => 'btproductpopup', "title" => '产品选择', 'name' => 'productId[]'),
			// 'zhonglei'=>array('type'=>'bttext',"title"=>'成分','name'=>'zhonglei[]','readonly'=>true),
			'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'pihao'=>array('type'=>'bttext',"title"=>'批号','name'=>'pihao[]'),
			'supplierId' => array('title' => '供应商', 'type' => 'btselect', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1','name'=>'supplierId[]','inTable'=>true),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true),
			'cntJian' => array('type' => 'bttext', "title" => '包数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]'),
			// 'danjia' => array('type' => 'bttext', "title" => '加工单价', 'name' => 'danjia[]'),
			// 'money' => array('type' => 'bttext', "title" => '加工费', 'name' => 'money[]','readonly'=>true),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			// 'plan2proId' => array('type' => 'bthidden', 'name' => 'plan2proId[]'),
		);
	
		//其他明细信息
		$this->qitaSon = array(
			'_edit' => array('type' => 'btBtnCopy', "title" => '+5行', 'name' => '_edit[]'),
			'planGxId' => array(
				'title' => '投料计划', 
				"type" => "btPopup",
				'name' => 'planGxId[]',
				'url'=>url('Shengchan_PlanTl','popupGx',array('gongxuName'=>'坯布织造','ColType'=>$this->_kind)),
				'textFld'=>'touliaoCode',
				'hiddenFld'=>'plangxId',
				'inTable'=>true,
				'dialogWidth'=>960
			),
			'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name'=>'productId[]','kind'=>$this->_type),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'ganghao'=>array('type'=>'bttext',"title"=>'本厂缸号','name'=>'ganghao[]','style'=>"min-width:110px;"),
			'chehao'=>array('type'=>'bttext',"title"=>'车号','name'=>'chehao[]'),
			'shahao'=>array('type'=>'bttext',"title"=>'纱号','name'=>'shahao[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true),
			'Madan' => array('type' => 'btBtnMadan', "title" => '码单', 'name' => 'Madan[]'),
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]'),
			'danjia' => array('type' => 'bttext', "title" => '加工单价', 'name' => 'danjia[]'),
			'money' => array('type' => 'bttext', "title" => '加工费', 'name' => 'money[]','readonly'=>true),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			'autoZhizao' => array('type' => 'btBtnCommon', "title" => '<a href="javascript:;" title="所有验收记录一起投料" id="touliaoAuto" class="btn btn-default">自动投料</a>', 'name' =>'autoZhizao[]','textFld'=>'投料'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'qtid[]'),
			// 'plan2proId' => array('type' => 'bthidden', 'name' => 'plan2proId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'jiagonghuId' => 'required',
			'kuweiIdLl' => 'required',
			'kuweiIdYs' => 'required',
			'pihao[]'=>'pihaoCheck'
		);

		// $this->son_width='110%';
		$this->sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			"Shengchan/Cangku/ScrkSonTpl.tpl",
			"Shengchan/Cangku/plan2GxSelTpl.tpl",
			"Shengchan/Cangku/MadanRkJs.tpl",
			"Shengchan/Cangku/AutoZzTollJs.tpl",
			"Shengchan/Cangku/SelfToEdit.tpl",
		);
		$this->_rightCheck='3-2-1-2';
		$this->_addCheck='3-2-1-1';
	}

	//明细查询
	function actionListView(){
		$this->authCheck('3-2-1-20');
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'jiagonghuId'=>'',
			'kuweiId'=>'',
			'ganghao' => '',
			'pinzhong' => '',
			'guige' => '',
			'color' => '',
			'key' => '',
		)); 

		$sql="select x.*,a.compName,b.kuweiName,
			z.proCode,z.pinzhong,z.guige,
			y.ganghao,y.pihao,y.color,y.shahao,y.chehao,y.dengji,y.cnt,y.cntJian,y.memoView,y.id as ruku2ProId,y.return4id
			from cangku_ruku x 
			left join cangku_ruku_son y on x.id=y.rukuId
			left join jichu_product z on z.id=y.productId
			left join jichu_jiagonghu a on a.id=x.jiagonghuId
			left join jichu_kuwei b on b.id=x.kuweiId
			where 1";

		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['dateFrom']!='')$sql.=" and x.rukuDate >= '{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$sql.=" and x.rukuDate <= '{$arr['dateTo']}'";
		if($arr['ganghao']!='')$sql.=" and y.ganghao like '%{$arr['ganghao']}%'";
		if($arr['pinzhong']!='')$sql.=" and z.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['guige']!='')$sql.=" and z.guige like '%{$arr['guige']}%'";
		if($arr['color']!='')$sql.=" and y.color like '%{$arr['color']}%'";
		if($arr['key']!='')$sql.=" and (y.shahao like '%{$arr['key']}%' or y.chehao like '%{$arr['key']}%')";
		if($arr['jiagonghuId']!='')$sql.=" and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		$sql.=" order by x.rukuDate desc,x.id desc,y.id";

		//查找计划
		if($_GET['export']==1){
			$rowset = $this->_modelExample->findBySql($sql);
		}else{
			$pager = &new TMIS_Pager($sql);
			$rowset = $pager->findAll();
		}

		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);

			//退回的修改
			if($v['kind']==$this->_tuiKind){
				$v['_edit']="<a href='".$this->_url('TuiEdit',array(
							'id'=>$v['id'],
							'fromAction'=>$_GET['action']
						))."'>修改</a>";
			}

			//删除操作
			$v['_edit'] .= ' ' .$this->getRemoveHtml(array('id'=>$v['id'],'msg'=>'确认删除'.$v['rukuCode'].'整单信息吗?'));

			//退回操作
			if($v['kind']==$this->_tuiKind){
				//处理显示的退纱信息
				if($v['return4id']>0){
					$temp=$this->_subModel->find($v['return4id']);
					$v['rukuCode']="<a href='#' style='color:red' ext:qtip='从{$temp['Rk']['rukuCode']}单退回'>{$v['rukuCode']}</a>";
				}
				$v['_edit'].="&nbsp;<span ext:qtip='{$v['kind']}数据，禁止退回'>退回</span>";
			}else{
				$v['_edit'].="&nbsp;<a href='".$this->_url('TuiAdd',array(
						'return4id'=>$v['ruku2ProId'],
						'fromAction'=>$_GET['action']
					))."' ext:qtip='退回操作'>退回</a>";
			}

			//处理数量
			$v['cnt'] =round($v['cnt'],2);
		} 
		$heji=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$_GET['export']==1 && $heji['rukuCode']="合计";
		$rowset[]=$heji;

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => '操作',
			// 'kind'=>array('text'=>'类型','width'=>80),
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			'compName'=>'加工户',
			'kuweiName'=>'仓库',
			"rukuDate" => "发生日期",
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => array('text'=>'规格','width'=>150), 
			"color" => '颜色',
			"ganghao" => '本厂缸号', 
			"chehao" => array('text'=>'车号.','width'=>60), 
			"shahao" => array('text'=>'纱号.','width'=>60), 
			'dengji'=>array('text'=>'等级','width'=>60),
			'cntJian'=>array('text'=>'件数','width'=>60),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			"memoView" => array('text'=>'备注','width'=>100), 
		);

		$title="坯布验收列表";
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);

		//处理导出
		$smarty->assign('fn_export',$this->_url($_GET['action'],array('export'=>1)+$arr));
		if($_GET['export']==1){
			$this->_exportList(array('fileName'=>$title),$smarty);
		}

		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');

	}

	function actionRight(){
		//权限判断
		$this->authCheck($this->_rightCheck);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'jiagonghuId'=>'',
			'kuweiId'=>'',
			'ganghao' => '',
			'key' => '',
		)); 

		$sql="select x.*,a.compName,b.kuweiName
			from cangku_ruku x 
			inner join cangku_ruku_son y on x.id=y.rukuId
			left join jichu_product z on z.id=y.productId
			left join jichu_jiagonghu a on a.id=x.jiagonghuId
			left join jichu_kuwei b on b.id=x.kuweiId
			where 1";

		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['ganghao']!='')$sql.=" and y.ganghao like '%{$arr['ganghao']}%'";
		if($arr['key']!='')$sql.=" and (z.guige like '%{$arr['key']}%' or z.pinzhong like '%{$arr['key']}%')";
		if($arr['jiagonghuId']!='')$sql.=" and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		$sql.=" group by x.id order by x.rukuDate desc,x.id desc";

		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);

			//退回的操作
			if($v['kind']==$this->_tuiKind){
				$v['_edit']="<a href='".$this->_url('TuiEdit',array(
							'id'=>$v['id'],
							'fromAction'=>$_GET['action']
						))."'>修改</a>";
			}
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
				$vv['guige']=$temp[0]['guige'];

				//合计
				$v['cnt']+=$vv['cnt'];
				$v['cntJian']+=$vv['cntJian'];
				$v['money']+=$vv['money'];
				$vv['danjia']=round($vv['danjia'],6);


				/**
				 * 销售退回操作添加
				*/
				if($v['kind']==$this->_tuiKind){
					$vv['_edit']="<span ext:qtip='{$v['kind']}数据，禁止退回'>退回</span>";
				}else{
					$vv['_edit']="<a href='".$this->_url('TuiAdd',array(
							'return4id'=>$vv['id'],
							'fromAction'=>$_GET['action']
						))."' ext:qtip='退货'>退回</a>";
				}
				
				//处理显示的退纱信息
				if($vv['return4id']>0){
					$temp=$this->_subModel->find($vv['return4id']);
					$v['kind']="<a href='#' style='color:red' ext:qtip='从{$temp['Rk']['rukuCode']}单退回'>{$v['kind']}</a>";
				}
			}
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => '操作',
			'kind'=>'类型',
			'compName'=>'加工户',
			'kuweiName'=>'仓库',
			"rukuDate" => "发生日期",
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		);

		$arrField = array(
			"_edit" => '操作',
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			// "proName" => '纱支', 
			"guige" => array('text'=>'规格','width'=>150), 
			"color" => '颜色',
			"ganghao" => '本厂缸号', 
			"chehao" => '车号', 
			"shahao" => '纱号', 
			'dengji'=>'等级',
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			// "danjia" => array('text'=>'加工单价','width'=>70),
			// "money" => array('text'=>'加工费','width'=>70),
			"memoView" => array('text'=>'备注','width'=>100), 
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
	 * 新增方法
	*/
	function actionAdd() {
		$this->authCheck($this->_addCheck);

		while (count($rowsSon) < 5) {
			$rowsSon[]=array(
				'dengji'=>array('value'=>'一等品')
			);
		}

		while (count($row4sSon) < 5) {
			$row4sSon[]=array(
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
		$smarty->assign('sonTitle', '纱投料明细信息');
	 	$smarty->assign("otherInfoTpl",'Main2Son/OtherInfoTpl.tpl');
	 	$smarty->assign('qitaSon',$this->qitaSon);
		$smarty->assign('otherInfo','坯布验收明细信息');
	    $smarty->assign('row4sSon',$row4sSon);
		$smarty->display('Main2Son/T1.tpl');
	}

	/**
	 * 修改方法，需要修改两个信息，一个为验收（产量入库），一个为领料出库
	 * Time：2014/07/26 14:31:51
	 * @author li
	*/
	function actionEdit(){
		//权限判断
		$this->authCheck($this->_addCheck);

		/*
		* 查找验收信息
		*/
		$arr = $this->_modelExample->find(array('id' => $_GET['id']));
		$arr['kuweiIdYs']=$arr['kuweiId'];

		/*
		* 查找验收对应的领用信息
		*/
		$llInfo = $this->chukuModel->find(array('rukuId' => $_GET['id']));
		$arr['llckId']=$llInfo['id'];
		$arr['kuweiIdLl']=$llInfo['kuweiId'];

		/*
		* 整理数据，主信息
		*/
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}

		//查找库位信息，赋值给仓库选择框
		$sql="select kuweiName from jichu_kuwei where id='{$arr['kuweiId']}'";
		$temp=$this->_subModel->findBySql($sql);
		$this->fldMain['kuweiIdYs']['text']=$temp[0]['kuweiName'];
		
		//查找库位信息，赋值给仓库选择框
		$sql="select kuweiName from jichu_kuwei where id='{$llInfo['kuweiId']}'";
		$temp=$this->_subModel->findBySql($sql);
		$this->fldMain['kuweiIdLl']['text']=$temp[0]['kuweiName'];

		// 加载库位信息的值
		$areaMain = array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain);

		// 验收明细处理
		$row4sSon = array();
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];

			$v['danjia'] = round($v['danjia'],6);
			$v['money'] = round($v['money'],6);
			$v['cnt'] = round($v['cnt'],6);

			//查找码单信息，并json_encode
			$sql="select * from cangku_madan where ruku2ProId='{$v['id']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$temp=array();
			foreach($_temp as & $m){
				if($m['chuku2proId']>0)$m['readonly']=true;
				$temp[$m['number']-1]=$m;
			}
			$temp['isCheck']=1;
			$v['Madan'] = json_encode($temp);
		}

		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->qitaSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$row4sSon[] = $temp;
		}

		//填充计划显示的信息
		foreach ($row4sSon as $key => & $v) {
			if(!$v['planGxId']['value'])continue;

			$sql="select y.touliaoCode from shengchan_plan2product_gongxu x 
					left join shengchan_plan_touliao y on x.touliaoId=y.id
					where x.id='{$v['planGxId']['value']}'";

			$_temp = $this->_modelExample->findBySql($sql);
			
			$v['planGxId']['text']=$_temp[0]['touliaoCode'];

		}

		// 领用明细处理
		$rowsSon = array();
		foreach($llInfo['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];

			$v['danjia'] = round($v['danjia'],6);
			$v['money'] = round($v['money'],6);
			$v['cnt'] = round($v['cnt'],6);
		}

		foreach($llInfo['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}
		//填充计划显示的信息
		foreach ($rowsSon as $key => & $v) {
			//查找产品编号并显示
			$sql="select proCode from jichu_product where id='{$v['productId']['value']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$v['productId']['text']=$_temp[0]['proCode'];
			
			if(!$v['planGxId']['value'])continue;

			$sql="select y.touliaoCode from shengchan_plan2product_gongxu x 
					left join shengchan_plan_touliao y on x.touliaoId=y.id
					where x.id='{$v['planGxId']['value']}'";

			$_temp = $this->_modelExample->findBySql($sql);
			$v['planGxId']['text']=$_temp[0]['touliaoCode'];
		}

		while (count($rowsSon) < 5) {
			$rowsSon[]=array();
		}

		while (count($row4sSon) < 5) {
			$row4sSon[]=array();
		}
		// dump($rowsSon);exit;

		$smarty = &$this->_getView();
		$areaMain = array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain);
		$smarty->assign('areaMain', $areaMain);		
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']==''?'add':$_GET['fromAction']);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', $this->sonTpl);
		$smarty->assign('sonTitle', '纱投料明细信息');
	 	$smarty->assign("otherInfoTpl",'Main2Son/OtherInfoTpl.tpl');
	 	$smarty->assign('qitaSon',$this->qitaSon);
		$smarty->assign('otherInfo','坯布验收明细信息');
	    $smarty->assign('row4sSon',$row4sSon);
		$smarty->display('Main2Son/T1.tpl');
	}

	/**
	 * 保存，需要同时保存两条记录，一个为验收（产量入库），一个为领料出库
	 * Time：2014/07/26 13:21:00
	*/
	function actionSave(){
		// dump($_POST);exit;
		//开始保存
		/*
		* 领料明细数据处理
		*/
		$pros = array();
		$_llCnt=count($_POST['id']);
		foreach($_POST['id'] as $key=>&$v) {
			if(empty($_POST['productId'][$key]) || empty($_POST['cnt'][$key])) continue;
			$temp = array();
			foreach($this->headSon as $k=>&$vv) {
				$name = $vv['name']?str_replace('[]', '', $vv['name']):$k;
				$temp[$k] = $_POST[$name][$key];
			}
			$pros[]=$temp;
		}
		if(count($pros)==0) {
			js_alert('请选择有效的投料明细信息!','window.history.go(-1)');
			exit;
		}
		// dump($pros);exit;

		/*
		* 验收明细数据处理
		*/
		$yanshou = array();
		$_ysCnt=count($_POST['qtid']);
		foreach($_POST['qtid'] as $key=>&$v) {
			$temp = array();
			foreach($this->qitaSon as $k=>&$vv) {
				//获取对应的信息
				$name = $vv['name']?str_replace('[]', '', $vv['name']):$k;

				//判断，如果总个数 > 验收id的数量，则需要计算需要取数据的序号，
				$i=count($_POST[$name]) > $_ysCnt ? $_llCnt+$key : $key;
				
				$temp[$k] = $_POST[$name][$i];
			}
			if(empty($temp['productId']) || empty($temp['cnt']))continue;
			$yanshou[]=$temp;
		}
		if(count($yanshou)==0) {
			js_alert('请选择有效的验收明细信息!','window.history.go(-1)');
			exit;
		}
		// dump($_POST);
		// dump($yanshou);exit;

		/*
		* 主表数据处理
		*/
		$row = array();
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$row[$k] = $_POST[$name];
		}
		$row['isCheck']=1;

		$lingliao = $row;
		//织布验收领料信息，不需要过账
		$lingliao['isGuozhang']=1;

		$lingliao['kuweiId']=$row['kuweiIdLl']+0;
		$row['kuweiId']=$row['kuweiIdYs']+0;

		//验收信息，保存在入库表
		$row['Products'] = $yanshou;

		/*
		* 处理码单信息
		*/
		foreach($row['Products'] as & $v){
			$madan = json_decode($v['Madan']);
			$_temp=array();
			foreach($madan as & $m){
				$m = (Array)$m;
				//数量不存在，说明该码单不需要保存
				if(empty($m['cntFormat']) && empty($m['cnt_M'])){
					//如果id存在，则说明该码单需要在数据表中删除
					if($m['id']>0){
						$madan_clear[]=$m['id'];
					}
					continue;
				}
				if($m)$_temp[]=$m;
			}

			$v['Madan'] = $_temp;
		}

		// dump($row);exit;
		$id = $this->_modelExample->save($row);
		if(!$id) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}else{
			/*
			* 处理领料信息
			*/

			$lingliao['id']=$_POST['llckId'];
			$lingliao['chukuCode']=$row['rukuCode'].'领料';
			$lingliao['chukuDate']=$row['rukuDate'];
			$lingliao['type']=$this->_YlType;
			$lingliao['kind']=$this->_kindLl;

			$lingliao['Products'] = $pros;

			$id=$_POST['cgrkId']>0 ? $_POST['cgrkId'] : $id;
			$lingliao['rukuId'] = $id;

			$this->chukuModel->save($lingliao);
		}

		/*
		* 处理需要清空的数据
		*/
		$strSonId=join(',',$madan_clear);
		if($strSonId!=''){
			$sql="delete from cangku_madan where id in ({$strSonId})";
			$this->_subModel->execute($sql);
		}

		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	//利用ajax删除订单明细，在订单编辑界面中使用,需要定义subModel
	function actionRemoveByAjax() {
		$id=$_REQUEST['id'];
		$m = &FLEA::getSingleton('Model_Shengchan_Cangku_Chuku2Product');
		if($m->removeByPkv($id)) {
			echo json_encode(array('success'=>true));
			exit;
		}
	}

	//利用ajax删除订单明细，在订单编辑界面中使用,需要定义subModel
	function actionRemoveQitaByAjax() {
		$id=$_REQUEST['id'];
		$m = $this->_subModel;
		if($m->removeByPkv($id)) {
			echo json_encode(array('success'=>true));
			exit;
		}
	}

	/**
	 * 删除时同时删除两条数据
	 * Time：2014/07/26 15:35:03
	 * @author li
	*/
	function actionRemove(){
		//查找领用的数量信息
		$info = $this->chukuModel->find(array('rukuId'=>$_GET['id']));

		$from = $_GET['fromAction']?$_GET['fromAction']:$_GET['from'];
		if ($this->_modelExample->removeByPkv($_GET['id'])) {
			//删除领用信息
			$this->chukuModel->removeByPkv($info['id']);
			
			if($from=='') redirect($this->_url("right"));
			else js_alert(null,"window.parent.showMsg('成功删除')",$this->_url($from));
		}
		else js_alert('出错，不允许删除!',$this->_url($from));

	}

	/**
	 * 损耗统计报表
	*/
	function actionSunhaoTongji(){
		$this->authCheck('3-2-1-9');
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
			x.planGxId,
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
			f.touliaoId,
			c.compName as jghName
			from cangku_ruku_son x
			inner join cangku_ruku y on y.id=x.rukuId
			left join shengchan_plan2product_gongxu f on f.id=x.planGxId
			left join (select plan2proId,touliaoId from shengchan_plan_touliao2product group by touliaoId) d on d.touliaoId=f.touliaoId
			left join shengchan_plan2product z on z.id=d.plan2proId
			left join shengchan_plan m on m.id=z.planId
			left join trade_order n on n.id=m.orderId
			left join jichu_client a on n.clientId=a.id
			left join jichu_product b on b.id=x.productId
			left join jichu_jiagonghu c on c.id=y.jiagonghuId
			where 1 and x.planGxId<>0";

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
		$sql.=" group by f.touliaoId,y.jiagonghuId order by n.clientId,z.id desc,y.id desc,x.id";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		foreach ($rowset as & $v) {
			//查找领料数量
			$sql="select sum(x.cnt) as cnt , sum(x.cntJian) as cntJian from cangku_chuku_son x
			left join cangku_chuku y on y.id=x.chukuId
			left join shengchan_plan2product_gongxu a on a.id=x.planGxId
			where 1 and y.jiagonghuId='{$v['jiagonghuId']}'
					and a.touliaoId='{$v['touliaoId']}'";
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


			//查找生产计划明细中的颜色信息
			$sql="select group_concat(x.color) as color from shengchan_plan2product x
			left join shengchan_plan_touliao2product y on y.plan2proId=x.id
			where y.touliaoId='{$v['touliaoId']}'";

			$res = $this->_modelExample->findBySql($sql);
			$v['color'] = $res[0]['color'];
		}

		// 合计行
		$heji = $this->getHeji($rowset, array('cntJian','cnt','llCnt','llCntJian'), 'compName');

		//处理明细信息
		foreach($rowset as & $v) {
			$v['cnt'] = "<a href='".url($_GET['controller'],'SunhaoView',array(
				'touliaoId'=>$v['touliaoId'],
				'jiagonghuId'=>$v['jiagonghuId'],
				'type'=>$this->_type,
				'kind'=>$this->_kind,
				'no_edit'=>1
			))."' target='_blank'>{$v['cnt']}</a>";

			$v['llCnt'] = "<a href='".url(str_replace( 'Scrk', 'Llck',$_GET['controller']),'SunhaoView',array(
				'touliaoId'=>$v['touliaoId'],
				'jiagonghuId'=>$v['jiagonghuId'],
				'type'=>$this->_YlType,
				'kind'=>$this->_kindLl,
				'no_edit'=>1
			))."' target='_blank'>{$v['llCnt']}</a>";
		}

		$rowset[] = $heji;

		$arrFieldInfo = array(
			"compName" => "客户",
			'orderCode'=>'订单号',
			'planCode'=>'计划单号',
			'proCode'=>'产品编码',
			'pinzhong'=>'品种',
			'guige'=>'规格',
			'color'=>'颜色',
			'jghName'=>'加工户',
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
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display('TableList.tpl');
	}

	/**
	 * 库存统计报表入库明细
	 * Time：2014/07/28 16:09:52
	 * @author li
	*/
	function actionPopup(){
		$this->authCheck();
		$filed=array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
			'ganghao'=>'本厂缸号',
			'chehao'=>'车号',
			'shahao'=>'纱号',
		);
		parent::actionPopup($filed);
	}

	/**
	 * 损耗统计报表入库明细
	 * Time：2014/07/28 16:09:52
	 * @author li
	*/
	function actionSunhaoView(){
		$this->authCheck();
		$filed=array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
			'ganghao'=>'本厂缸号',
			'chehao'=>'车号',
			'shahao'=>'纱号',
		);
		parent::actionSunhaoView($filed);
	}

	/**
	 * 导入生产入库记录时使用(领料出库界面使用)
	 * Time：2014/08/18 14:44:15
	 * @author li
	 * @return JSON
	 * 提供验收信息列表，按照入库编号列出
	*/
	function actionGetScrkData(){
		$this->authCheck();

		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'jiagonghuId'=>'',
			'kuweiId'=>'',
			// 'ganghao' => '',
			'key' => '',
			'isSelect'=>'',
			'type'=>''
		)); 

		$sql="select x.*,a.compName,b.kuweiName
			from cangku_ruku x 
			inner join cangku_ruku_son y on x.id=y.rukuId
			left join jichu_product z on z.id=y.productId
			left join jichu_jiagonghu a on a.id=x.jiagonghuId
			left join jichu_kuwei b on b.id=x.kuweiId
			where 1";

		if($arr['type']=='all'){
			$sql.=" and (x.kind='{$this->_kind}' or x.kind='预定型验收')";
			$sql.=" and x.type='{$this->_type}'";
		}else{
			$sql.=" and x.kind='{$this->_kind}'";
			$sql.=" and x.type='{$this->_type}'";
		}

		if($arr['ganghao']!='')$sql.=" and y.ganghao like '%{$arr['ganghao']}%'";
		if($arr['key']!='')$sql.=" and (z.guige like '%{$arr['key']}%' or z.pinzhong like '%{$arr['key']}%')";
		if($arr['jiagonghuId']!='')$sql.=" and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['isSelect']==0)$sql.=" and x.llCnt = 0";
		else $sql.=" and x.llCnt <> 0";
		$sql.=" group by x.id order by x.rukuDate desc,x.id desc";
		
		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		foreach($rowset as & $v) {
			//查找子表信息
			$sql="select productId,color,pihao,ganghao,cnt,cntJian,cntM,planGxId,dengji
			from cangku_ruku_son where rukuId='{$v['id']}'";
			$v['Products'] = $this->_subModel->findBySql($sql);
			// dump($v);exit;
			//查找产品信息
			$_temp=array();
			foreach ($v['Products'] as & $vv) {
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$t = $temp[0];
				
				$_temp[$vv['productId']] = $t['pinzhong'].' '.$t['guige'];

				$vv['proCode']=$t['proCode'];
				$vv['pinzhong']=$t['pinzhong'];
				$vv['guige']=$t['guige'];

				//查找投料编号
				$sql="select y.touliaoCode from shengchan_plan2product_gongxu x 
					left join shengchan_plan_touliao y on x.touliaoId=y.id
					where x.id='{$vv['planGxId']}'";
				$temp = $this->_modelExample->findBySql($sql);
				$vv['touliaoCode']=$temp[0]['touliaoCode'];
				
			}
			$v['proInfo'] = "<a href='#' ext:qtip='".join('<br>',$_temp)."'>".join('，',$_temp)."</a>";
			
			$v['llCnt'] = "<input type='checkbox' name='llCnt[]' ".($v['llCnt']>0 ? 'checked' : '')." value='{$v['id']}'>";
			/*if($v['llCnt']>0){
				$v['_bgColor']="#D3E1F1";
			}*/
		} 
		// $rowset[]=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');
		// dump($rowset);exit;

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"rukuDate" =>array('text'=>'发生日期','width'=>80) ,
			// 'kind'=>'类型',
			'compName'=>'加工户',
			'kuweiName'=>'仓库',
			'proInfo' => array('text'=>'产品信息','width'=>220),
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			// 'cntJian'=>'件数',
			// 'cnt'=>'数量(Kg)',
			// "memo" => array('text'=>'备注','width'=>200), 
			"llCnt" => array('text'=>'已选过','width'=>50), 
		);

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('jsTpl', "Shengchan/Cangku/LLCntTpl.tpl");
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 通过本厂缸号获取对应的发外信息
	 * 需要计算平均每件的数量，按照平均数来算
	 * Time：2014/09/28 14:26:50
	 * @author li
	 * @param GET
	 * @return JSON
	*/
	function actionGetInfoByGanghao(){
		$sql="select sum(x.cnt) as cnt,sum(x.cntJian) as cntJian,x.color,x.dengji,sum(x.cnt)/sum(x.cntJian) as cntEve,x.ganghao,x.pihao,z.pinzhong,z.guige,x.productId,z.proCode
		from cangku_ruku_son x 
		left join cangku_ruku y on y.id=x.rukuId
		left join jichu_product z on z.id=x.productId
		where x.ganghao='{$_GET['ganghao']}' and y.kind='{$this->_kind}'";
		
		$arr = $this->_modelExample->findBySql($sql);
		$arr = $arr[0];

		echo json_encode(array(
			'data'=>$arr,
			'success'=>count($arr)>0
			));
	}

	/**
	 * 查找选择工序有问题的数据
	 * 可以自动修正的自动修正，不可以的显示出来
	 * Time：2014/10/21 09:03:11
	*/
	function actionBuildingYanshou(){
		$sql="select count(distinct x.planGxId) as cnt,group_concat(distinct x.planGxId) as planGxId,y.id as rukuId 
			from cangku_ruku_son x
			left join cangku_ruku y on y.id=x.rukuId
			where y.kind='织布验收' group by x.planGxId,x.rukuId having cnt=1";
		$rowset = $this->_modelExample->findBySql($sql);
		// dump($rowset);exit;
		foreach ($rowset as $key => & $v) {
			$sql="select id as chukuId from cangku_chuku where rukuId='{$v['rukuId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$temp = $temp[0];
			// dump($temp);exit;
			$sql="update cangku_chuku_son set planGxId='{$v['planGxId']}' where chukuId='{$temp['chukuId']}'";
			$this->_modelExample->execute($sql);
		}
		echo '补丁结束';
	}


	/**
	 * 客户退货登记界面
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionTuiAdd(){
		//查找需要退回的数据
		$parent = $this->_subModel->find($_GET['return4id']);

		//查找调入数据
		$lingliao = $this->chukuModel->find(array('rukuId'=>$parent['Rk']['id']));
		// dump($dbInfo);exit;
		//库位信息
		$_kuwei = & FLEA::getSingleton('Model_Jichu_Kuwei');
		$kuwei = $_kuwei->find($parent['Rk']['kuweiId']);
		//调入数据的仓库
		$kuweiTo = $_kuwei->find($lingliao['kuweiId']);

		//供应商信息
		$_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$supplier = $_supplier->find($parent['Rk']['jiagonghuId']);

		//整理主要信息
		$data=array(
			// 'jghName'=>$jgh['compName'],
			'compName'=>$supplier['compName'],
			'kuweiName'=> $kuwei['kuweiName'],
			'jiagonghuId'=>$parent['Rk']['jiagonghuId'],
			'kuweiId'=>$parent['Rk']['kuweiId'],
			'kuweiIdLl'=>$lingliao['kuweiId'],
			'ganghao'=>$parent['ganghao'],
			'color'=>$parent['color'],
			'danjia'=>round($parent['danjia'],6),
			'dengjiParent'=>$parent['dengji'],
			'dengji'=>$parent['dengji'],
			'cntParent'=>round($parent['cnt'],2),
			'return4id'=>$parent['id'],
			'productId'=>$parent['productId'],
			'memo'=>$this->_tuiKind,
			// 'danjia'=>round($parent['danjia'],6),
		);
		// dump($data);exit;
		//查找产品信息
		$sql = "select * from jichu_product where id='{$parent['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql);
		$data['proCode'] = $_temp[0]['proCode'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		$data['guige'] = $_temp[0]['guige'];

		//加载界面信息
		$arr = $this->setTsFldMain($data);

		//把需要初始值的信息加载初始值
		foreach($data as $key => & $v){
			$arr['fldMain'][$key]['value']=$v;
		}
		// dump($arr);exit;
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$arr['fldMain']);
	    $smarty->assign('title',$this->_tuiKind.'信息编辑');
	    $smarty->assign('rules',$arr['rules']);
	    if($_GET['fromAction']!=''){
	    	$smarty->assign('other_button',"<input class='btn btn-default' type='button' name='back' value='返 回' onclick=\"window.location.href='".$this->_url($_GET['fromAction'])."'\">");
	    }
	    $smarty->assign('form',array('action'=>'SaveTui'));
	    $smarty->assign('sonTpl','Shengchan/Cangku/tuiKuEdit.tpl');
	    $smarty->display('Main/A1.tpl');
	}

	/**
	 * 客户退货修改界面
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionTuiEdit(){
		$row = $this->_modelExample->find($_GET['id']);
		// dump($row);exit;
		//整理主要信息
		$pro=$row['Products'][0];
		//查找原始入库信息
		$parent = $this->_subModel->find($pro['return4id']);
		//供应商信息
		$_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$jgh = $_supplier->find($row['jiagonghuId']);

		/*
		* 查找验收退回对应的领用退回信息
		*/
		$llInfo = $this->chukuModel->find(array('rukuId' => $_GET['id']));

		$data=array(
			'id'=>$pro['id'],
			'cnt'=>$pro['cnt'],
			'cntJian'=>$pro['cntJian'],
			'memo'=>$pro['memoView'],
			'ganghao'=>$pro['ganghao'],
			'color'=>$pro['color'],
			'dengji'=>$pro['dengji'],
			'dengjiParent'=>$parent['dengji'],
			'productId'=>$pro['productId'],
			'return4id'=>$pro['return4id'],
			'rukuId'=>$pro['rukuId'],
			'danjia'=>round($pro['danjia'],6),
			'money'=>round($pro['money'],6),
			'compName'=> $jgh['compName'],
			'kuweiName'=> $row['Kuwei']['kuweiName'],
			'rukuDate'=>$row['rukuDate'],
			'jiagonghuId'=>$row['jiagonghuId'],
			'kuweiId'=>$row['kuweiId'],
			'kuweiIdLl'=>$llInfo['kuweiId'],
			'cntParent'=>round($parent['cnt'],2),
		);
		
		//查找产品信息
		$sql = "select * from jichu_product where id='{$pro['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql);
		$data['proCode'] = $_temp[0]['proCode'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		$data['guige'] = $_temp[0]['guige'];

		//加载界面信息
		$arr = $this->setTsFldMain($data);
		//把需要初始值的信息加载初始值
		foreach($data as $key => & $v){
			$arr['fldMain'][$key]['value']=$v;
		}

		// dump($arr);exit;
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$arr['fldMain']);
	    $smarty->assign('title',$this->_tuiKind.'信息编辑');
	    $smarty->assign('rules',$arr['rules']);
	    if($_GET['fromAction']!=''){
	    	$smarty->assign('other_button',"<input class='btn btn-default' type='button' name='back' value='返 回' onclick=\"window.location.href='".$this->_url($_GET['fromAction'])."'\">");
	    }
	    $smarty->assign('form',array('action'=>'SaveTui'));
	    $smarty->assign('sonTpl','Shengchan/Cangku/tuiKuEdit.tpl');
	    $smarty->display('Main/A1.tpl');
	}

	/**
	 * 客户退货操作，需要显示的界面信息
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function setTsFldMain(){
		$tsFldMain = array(
			'id'=>array('title'=>'','type'=>'hidden','value'=>''),
			'rukuId'=>array('title'=>'','type'=>'hidden','value'=>''),
			'rukuCode'=>array('title'=>'退回单号','type'=>'text','value'=>$this->_getNewCode($this->_head,'cangku_ruku','rukuCode'),'readonly'=>true),
			'kuweiName' => array('title' => '验收仓库', 'type' => 'text','readonly'=>true),
			'kuweiIdLl' => array('type' => 'select', 'title' =>'退到仓库','model'=>'model_jichu_kuwei'),
			'compName' => array('title' => '加工户', 'type' => 'text','readonly'=>true),
			'proCode'=>array('type'=>'text',"title"=>'产品编码','readonly'=>true),
			// 'zhonglei'=>array('type'=>'text',"title"=>'成分','readonly'=>true),
			'pinzhong'=>array('type'=>'text',"title"=>'品种','readonly'=>true),
			'guige'=>array('type'=>'text',"title"=>'规格','readonly'=>true),
			'color'=>array('type'=>'text',"title"=>'颜色','readonly'=>true),
			'ganghao'=>array('type'=>'text',"title"=>'本厂缸号','readonly'=>true),
			'dengjiParent'=>array('type'=>'text',"title"=>'验收等级','readonly'=>true),
			'cntParent' => array('type' => 'text', "title" => '验收数量', 'name' => 'cntParent','readonly'=>true,'addonEnd'=>'Kg'),
			'danjia' => array('type' => 'text', "title" => '加工单价'),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()), 
			'cntJian' => array('type' => 'text', "title" => '退回件数'),
			'cnt' => array('type' => 'text', "title" => '退回数量','addonEnd'=>'Kg'),
			'money' => array('type' => 'text', "title" => '加工费'),
			'rukuDate' => array('title' => '退回日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'memo' => array('type' => 'textarea', "title" => '备注'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '1'),
			// 'isJiagong' => array('type' => 'hidden', 'value' => '1'),
			'kind' => array('type' => 'hidden', 'value' => $this->_tuiKind),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'return4id' => array('type' => 'hidden', 'value' => ''),
			'jiagonghuId' => array('type' => 'hidden', 'value' =>''),
			'kuweiId' => array('type' => 'hidden', 'value' =>''),
		);
	
		$rules = array(
			'cnt'=>'number'
		);
		// dump($tsFldMain);exit;
		return array('fldMain'=>$tsFldMain,'rules'=>$rules);
	}

	/**
	 * 客户退货操作，保存方法
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionSaveTui(){
		// dump($_POST);exit;
		if(empty($_POST['cnt'])){
			echo "数量不能为空……";exit;
		}

		//查询之前设置的单价
		$sql="select planGxId from cangku_ruku_son where id='{$_POST['return4id']}'";
		$parentCkInfo = $this->_subModel->findBySql($sql);
		$parentCkInfo = $parentCkInfo[0];
		//处理主要保存的信息
		$row=array(
			'id'=>$_POST['rukuId'],
			'rukuCode'=>$_POST['rukuCode'],
			'rukuDate'=>$_POST['rukuDate'],
			'isGuozhang'=>$_POST['isGuozhang'],
			'kuweiId'=>$_POST['kuweiId'],
			'jiagonghuId'=>$_POST['jiagonghuId'],
			'memo'=>$this->_tuiKind,
			'kind'=>$_POST['kind'],
			'isJiagong'=>1,
			'type'=>$this->_type,
			'creater'=>$_SESSION['REALNAME'].'',
		);
		//子表保存信息
		$son[]=array(
			'id'=>$_POST['id'],
			'productId'=>$_POST['productId'],
			'ganghao'=>$_POST['ganghao'],
			'color'=>$_POST['color'],
			'cntJian'=>abs($_POST['cntJian'])*-1,
			'cnt'=>abs($_POST['cnt'])*-1,
			'danjia'=>$_POST['danjia'],
			'money'=>abs($_POST['money'])*-1,
			'dengji'=>$_POST['dengji'],
			'memoView'=>$_POST['memo'],
			
			'return4id'=>$_POST['return4id'],
			'planGxId'=>$parentCkInfo['planGxId'],
		);

		$row['Products']=$son;
		// dump($row);exit;
		$id=$this->_modelExample->save($row);
		if(!$id) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}else{
			////////////////////////////保存调入的信息///////////////////////////////////////////////
			//获取调出的信息，用于生成调入的信息
			$rukuId = $_POST['rukuId']>0?$_POST['rukuId']:$id;
			$info = $this->_modelExample->find(array('id'=>$rukuId));
			
			//如果存在则需要先删除原来表信息，重新插入
			if($_POST['rukuId']>0){
				$chuku = $this->chukuModel->find(array('rukuId'=>$rukuId));
				$this->chukuModel->removeByPkv($chuku['id']);
			}

			//组织调出的信息，用于插入调入信息
			$row_in=$info;
			//处理主表信息
			$row_in['kuweiId']=$_POST['kuweiIdLl']+0;
			$row_in['rukuId']=$rukuId;
			$row_in['id']='';
			$row_in['id']=$temp['id'];
			$row_in['chukuDate']=$_POST['rukuDate'];
			$row_in['chukuCode'] .= $_POST['rukuCode'].'调';
			$row_in['isCheck']=1;
			//加工户信息应该为负数记录
			foreach($row_in['Products'] as & $v){
				//处理关联的调拨id
				$v['id']='';
				$v['memoView'].="调入数据";
			}
			// dump($row_in);exit;
			$this->chukuModel->save($row_in);

		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}
}

?>