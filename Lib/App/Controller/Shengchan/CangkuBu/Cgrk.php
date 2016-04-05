<?php
FLEA::loadClass('Controller_Shengchan_Ruku');
class Controller_Shengchan_CangkuBu_Cgrk extends Controller_Shengchan_Ruku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = "布仓库";
		$this->_kind="采购入库";
		// 定义模板中的主表字段
		$this->fldMain = array(
			'rukuCode' => array('title' => '单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('BKCG','cangku_ruku','rukuCode')),
			// 'cgPlanId' => array('title' => '采购计划', 'type' => 'popup', 'value' =>'','url'=>url('Shengchan_Cangku_Plan','Popup'),'textFld'=>'planCode','hiddenFld'=>'id'),
			'rukuDate' => array('title' => '入库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'songhuoCode' => array('title' => '送货单号', "type" => "text", 'value'=>''),
			'kuweiId' => array('title' => '仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),			
			'supplierId' => array('title' => '供应商', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1'),
			'kind'=>array('title'=>'入库类型','type'=>'text','readonly'=>true,'name'=>'kind','value'=>$this->_kind),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'cgrkId'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '0'),
			// 'kind' => array('type' => 'hidden', 'value' => ''),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			// 'isTuiku' => array('type' => 'hidden', 'value' => '0'),
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
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]'),
			'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			'money' => array('type' => 'bttext', "title" => '金额', 'name' => 'money[]','readonly'=>true),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'supplierId' => 'required',
			'kuweiId' => 'required'
		);

		$this->_rightCheck='3-2-6';
		$this->_addCheck='3-2-5';

		$this->sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			"Shengchan/Cangku/CgrkSonTpl.tpl"
		);
	}

	function actionRight(){
		//权限判断
		// $this->authCheck($this->_rightCheck);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'supplierId'=>'',
			'kuweiId'=>'',
			'commonCode' => '',
		));

		$sql="select x.* from cangku_ruku x where 1";
		$sql.=" and (x.kind='{$this->_kind}' or x.kind='采购退回')";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['commonCode']!='')$sql.=" and x.rukuCode like '%{$arr['commonCode']}%'";
		if($arr['supplierId']!='')$sql.=" and x.supplierId = '{$arr['supplierId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		$sql.=" order by x.id desc";
		// dump($sql);exit;
		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);
			//退回的操作
			if($v['kind']=="采购退回"){
				$v['_edit']="<a href='".$this->_url('TuiEdit',array(
							'id'=>$v['id'],
							'fromAction'=>$_GET['action']
						))."'>修改</a>";
				// $v['_bgColor']="#FFCCCC";
			}
			//删除操作
			$v['_edit'] .= ' ' .$this->getRemoveHtml($v['id']);

			//查找明细数据
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
				

				//添加操作列
				//退纱操作
				if($v['kind']=='采购退回'){
					$vv['_edit']="<span ext:qtip='{$v['kind']}数据，禁止退回'>退回</span>";
				}else{
					$vv['_edit']="<a href='".$this->_url('TuiAdd',array(
							'return4id'=>$vv['id'],
							'fromAction'=>$_GET['action']
						))."' ext:qtip='退回给供应商'>退回</a>";
				}


				//查找退纱数量信息
				$sql="select sum(cnt) as cnt from cangku_ruku_son where return4id='{$vv['id']}'";
				$result=$this->_subModel->findBySql($sql);
				$vv['tuiCnt']=abs($result[0]['cnt']);
				//处理显示的退纱信息
				if($vv['return4id']>0){
					$temp=$this->_subModel->find($vv['return4id']);
					$v['kind']="<a href='#' style='color:red' ext:qtip='从{$temp['Rk']['rukuCode']}单退纱'>{$v['kind']}</a>";
				}

				//实际入库数量
				$vv['rkCnt']=$vv['cnt']+$result[0]['cnt'];
				$vv['return4id']>0 && $vv['rkCnt']='';


				//合计
				$v['cnt']+=$vv['cnt'];
				$v['cntJian']+=$vv['cntJian'];
				$v['rkCnt']+=$vv['rkCnt'];
				$v['tuiCnt']+=$vv['tuiCnt'];
				$v['money']+=$vv['money'];
				$vv['danjia']=round($vv['danjia'],6);
			}

			//查找库位信息
			if($v['kuweiId']){
				$sql="select * from jichu_kuwei where id='{$v['kuweiId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Kuwei'] = $temp[0];
			}

			//查找供应商信息
			if($v['supplierId']){
				$sql="select * from jichu_jiagonghu where id='{$v['supplierId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Supplier'] = $temp[0];
			}

		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		
		$arrFieldInfo = array(
			"_edit" => '操作',
			'kind'=>'类型',
			'Supplier.compName'=>'供应商',
			'Kuwei.kuweiName'=>'仓库',
			"rukuDate" => "发生日期",
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			"songhuoCode" => "送货单号",
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			'tuiCnt'=>'退回数量(Kg)',
			'rkCnt'=>'实际入库(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		); 

		$arrField = array(
			"_edit" => '操作',
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '批号',
			'dengji'=>'等级',
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			'tuiCnt'=>'退回数量(Kg)',
			'rkCnt'=>'实际入库(Kg)',
			"danjia" => array('text'=>'单价','width'=>100),
			"money" => array('text'=>'金额','width'=>100),
			"memoView" => array('text'=>'备注','width'=>150), 
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

	//退纱操作
	function actionTuiAdd(){
		//查找退纱数据
		$parent = $this->_subModel->find($_GET['return4id']);
		// dump($parent);exit;
		//查找供应商信息
		$kuwei = & FLEA::getSingleton('Model_Jichu_Kuwei');
		$supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$comp = $supplier->find($parent['Rk']['supplierId']);
		$kuweiInfo = $kuwei->find($parent['Rk']['kuweiId']);
		// dump($kuweiInfo);exit;
		//整理主要信息
		$data=array(
			'compName'=>$comp['compName'],
			'kuweiName'=> $kuweiInfo['kuweiName'],
			'supplierId'=>$parent['Rk']['supplierId'],
			'kuweiId'=>$parent['Rk']['kuweiId'],
			'pihao'=>$parent['pihao'],
			'dengjiParent'=>$parent['dengji'],
			'dengji'=>$parent['dengji'],
			'cntParent'=>round($parent['cnt'],2),
			'cntJianParent'=>round($parent['cntJian'],2),
			'return4id'=>$parent['id'],
			'productId'=>$parent['productId'],
			'memo'=>'坯纱退库',
			'danjia'=>round($parent['danjia'],6),
		);
		//查找产品信息
		$sql = "select * from jichu_product where id='{$parent['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		// $data['zhonglei'] = $_temp[0]['zhonglei'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		// $data['proName'] = $_temp[0]['proName'];
		$data['guige'] = $_temp[0]['guige'];
		$data['color'] = $_temp[0]['color'];
		// dump($data);exit;
		//加载界面信息
		$arr = $this->setTsFldMain($data);
		//把需要初始值的信息加载初始值
		foreach($data as $key => & $v){
			$arr['fldMain'][$key]['value']=$v;
		}
		// dump($arr);exit;
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$arr['fldMain']);
	    $smarty->assign('title','退回信息编辑');
	    $smarty->assign('rules',$arr['rules']);
	    if($_GET['fromAction']!=''){
	    	$smarty->assign('other_button',"<input class='btn btn-default' type='button' name='back' value='返 回' onclick=\"window.location.href='".$this->_url($_GET['fromAction'])."'\">");
	    }
	    $smarty->assign('form',array('action'=>'SaveTuisha'));
	    $smarty->assign('sonTpl','Shengchan/Cangku/tuisha.tpl');
	    $smarty->display('Main/A1.tpl');
	}

	/**
	* 修改退纱信息
	*/
	function actionTuiEdit(){
		$row = $this->_modelExample->find($_GET['id']);
		// dump($row);exit;
		//整理主要信息
		$pro=$row['Products'][0];
		//查找原始入库信息
		$parent = $this->_subModel->find($pro['return4id']);
		$par_main = $parent['Rk'];

		$data=array(
			'id'=>$pro['id'],
			'cnt'=>$pro['cnt'],
			'cntJian'=>$pro['cntJian'],
			'money'=>$pro['money'],
			'memo'=>$pro['memoView'],
			'pihao'=>$pro['pihao'],
			'productId'=>$pro['productId'],
			'return4id'=>$pro['return4id'],
			'rukuId'=>$pro['rukuId'],
			'compName'=> $row['Supplier']['compName'],
			'kuweiName'=> $row['Kuwei']['kuweiName'],
			'rukuDate'=>$row['rukuDate'],
			'supplierId'=>$row['supplierId'],
			'kuweiId'=>$row['kuweiId'],
			'dengji'=>$pro['dengji'],
			'dengjiParent'=>$parent['dengji'],
			'cntParent'=>round($parent['cnt'],2),
			'cntJianParent'=>round($parent['cntJian'],2),
			'danjia'=>round($parent['danjia'],6),
		);
		
		//查找产品信息
		$sql = "select * from jichu_product where id='{$pro['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		// $data['zhonglei'] = $_temp[0]['zhonglei'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		// $data['proName'] = $_temp[0]['proName'];
		$data['guige'] = $_temp[0]['guige'];
		$data['color'] = $_temp[0]['color'];

		//加载界面信息
		$arr = $this->setTsFldMain($data);
		//把需要初始值的信息加载初始值
		foreach($data as $key => & $v){
			$arr['fldMain'][$key]['value']=$v;
		}

		// dump($arr);exit;
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$arr['fldMain']);
	    $smarty->assign('title','退纱信息编辑');
	    $smarty->assign('rules',$arr['rules']);
	    if($_GET['fromAction']!=''){
	    	$smarty->assign('other_button',"<input class='btn btn-default' type='button' name='back' value='返 回' onclick=\"window.location.href='".$this->_url($_GET['fromAction'])."'\">");
	    }
	    $smarty->assign('form',array('action'=>'SaveTuisha'));
	    $smarty->assign('sonTpl','Shengchan/Cangku/tuisha.tpl');
	    $smarty->display('Main/A1.tpl');
	}

	/*********************************************************************\
	*  Copyright (c) 1998-2013, TH. All Rights Reserved.
	*  Author :li
	*  FName  :Ruku.php
	*  Time   :2014/05/22 16:32:07
	*  Remark :设置退纱需要显示的信息
	\*********************************************************************/
	function setTsFldMain(){
		$tsFldMain = array(
			'id'=>array('title'=>'','type'=>'hidden','value'=>''),
			'rukuId'=>array('title'=>'','type'=>'hidden','value'=>''),
			'rukuCode'=>array('title'=>'退纱单号','type'=>'text','value'=>$this->_getNewCode('BKCG','cangku_ruku','rukuCode'),'readonly'=>true),
			'compName' => array('title' => '供应商', 'type' => 'text','readonly'=>true),
			'kuweiName' => array('title' => '仓库', 'type' => 'text','readonly'=>true),
			'proCode'=>array('type'=>'text',"title"=>'产品编码','readonly'=>true),
			'pinzhong'=>array('type'=>'text',"title"=>'品种','readonly'=>true),
			// 'proName'=>array('type'=>'text',"title"=>'纱支','readonly'=>true),
			'guige'=>array('type'=>'text',"title"=>'规格','readonly'=>true),
			'color'=>array('type'=>'text',"title"=>'颜色','readonly'=>true),
			'pihao'=>array('type'=>'text',"title"=>'批号','readonly'=>true),
			'dengjiParent'=>array('type'=>'text',"title"=>'入库等级','readonly'=>true),
			'cntJianParent' => array('type' => 'text', "title" => '入库件数', 'name' => 'cntJianParent','readonly'=>true),
			'cntParent' => array('type' => 'text', "title" => '入库数量', 'name' => 'cntParent','readonly'=>true,'addonEnd'=>'Kg'),
			'danjia' => array('type' => 'text', "title" => '单价','readonly'=>true),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()), 
			'cntJian' => array('type' => 'text', "title" => '退回件数'),
			'cnt' => array('type' => 'text', "title" => '退回数量','addonEnd'=>'Kg'),
			'money' => array('type' => 'text', "title" => '金额','readonly'=>true),
			'rukuDate' => array('title' => '退纱日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'memo' => array('type' => 'textarea', "title" => '备注'),
			// 'gongxuName' => array('type' => 'hidden', 'value' => '本厂'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '0'),
			'kind' => array('type' => 'hidden', 'value' => '采购退回'),
			'productId' => array('type' => 'hidden', 'value' => ''),
			// 'isTuiku' => array('type' => 'hidden', 'value' => '0'),
			'return4id' => array('type' => 'hidden', 'value' => ''),
			'supplierId' => array('type' => 'hidden', 'value' =>''),
			'kuweiId' => array('type' => 'hidden', 'value' =>'')
		);
	
		$rules = array(
			'cnt'=>'required number'
		);
		// dump($tsFldMain);exit;
		return array('fldMain'=>$tsFldMain,'rules'=>$rules);
	}

	/*********************************************************************\
	*  Copyright (c) 1998-2013, TH. All Rights Reserved.
	*  Author :li
	*  FName  :Ruku.php
	*  Time   :2014/05/23 14:41:39
	*  Remark :退纱保存action处理地址
	*  return Array 
	\*********************************************************************/
	function actionSaveTuisha(){
		// dump($_POST);exit;
		if(empty($_POST['cnt'])){
			echo "数量不能为空……";exit;
		}
		//处理主要保存的信息
		$row=array(
			'id'=>$_POST['rukuId'],
			'rukuCode'=>$_POST['rukuCode'],
			'rukuDate'=>$_POST['rukuDate'],
			// 'gongxuName'=>$_POST['gongxuName'],
			'isGuozhang'=>$_POST['isGuozhang'],
			'kind'=>$_POST['kind'],
			// 'isTuiku'=>$_POST['isTuiku'],
			'supplierId'=>$_POST['supplierId'],
			'kuweiId'=>$_POST['kuweiId'],
			'memo'=>'采购退回',
			'kind'=>$_POST['kind'],
			'type'=>$this->_type,
			'creater'=>$_SESSION['REALNAME'].'',
			'kind'=>$_POST['kind']
		);
		//子表保存信息
		$son[]=array(
			'id'=>$_POST['id'],
			'productId'=>$_POST['productId'],
			'pihao'=>$_POST['pihao'],
			'dengji'=>$_POST['dengji'],
			'cnt'=>abs($_POST['cnt'])*-1,
			'cntJian'=>abs($_POST['cntJian'])*-1,
			'danjia'=>$_POST['danjia']+0,
			'money'=>abs($_POST['money'])*-1,
			'memoView'=>$_POST['memo'],
			'return4id'=>$_POST['return4id'],
		);

		$row['Products']=$son;
		// dump($row);exit;
		if(!$this->_modelExample->save($row)) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}
}

?>