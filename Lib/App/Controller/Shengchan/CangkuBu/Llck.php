<?php
FLEA::loadClass('Controller_Shengchan_Chuku');
class Controller_Shengchan_CangkuBu_Llck extends Controller_Shengchan_Chuku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '布仓库';
		$this->_kind="领料出库";
		$this->_tuiKind="领料退回";
		//出库主信息
		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('BKLL','cangku_chuku','chukuCode')),
			'chukuDate' => array('title' => '出库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
			'jiagonghuId' => array('title' => '加工户', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=0','emptyText'=>'选择加工户'),
			'kuweiId' => array('title' => '仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			'departmentId'=> array('title' => '领用部门','type' => 'select', 'value' => '','model'=>'Model_jichu_department'),
			'peolingliao' => array('title' => '领用人', 'type' => 'text', 'value' => ''),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			'isJiagong' => array('type' => 'hidden', 'value' => '1'),
			// 'isGuozhang' => array('type' => 'hidden', 'value' => '0'),
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
			'pihao'=>array('type'=>'bttext',"title"=>'批号','name'=>'pihao[]'),
			// 'supplierId' => array('title' => '供应商', 'type' => 'btselect', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1','inTable'=>true,'name'=>'supplierId[]'),
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

		$this->sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			"Shengchan/Cangku/ScrkSonTpl.tpl"
		);

		$this->_rightCheck='3-2-12';
		$this->_addCheck='3-2-11';
	}

	/**
	* 查询
	*/
	function actionRight(){
		//权限判断
		$this->authCheck($this->_rightCheck);
		$ishaveCheck = $this->authCheck('3-100-1',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'isCheck'=>2,
			'kuweiId'=>'',
			'jiagonghuId'=>'',
			// 'supplierId'=>'',
			'commonCode' => '',
		));
		
		$sql="select x.* from cangku_chuku x where 1";
		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['commonCode']!='')$sql.=" and x.rukuCode like '%{$arr['commonCode']}%'";
		if($arr['isCheck']<2)$sql.=" and x.isCheck = '{$arr['isCheck']}'";
		if($arr['jiagonghuId']!='')$sql.=" and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		$sql.=" order by x.id desc";

		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		// dump($rowset);exit;
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

			//查找明细数据
			$v['Products'] = $this->_subModel->findAll(array('chukuId'=>$v['id']));
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

				//查找退回数量信息
				$sql="select sum(cnt) as cnt from cangku_chuku_son where return4id='{$vv['id']}'";
				$result=$this->_subModel->findBySql($sql);
				$vv['tuiCnt']=abs($result[0]['cnt']);
				$vv['tuiCntCi']=abs($result[0]['cntCi']);

				/**
				 * 销售退回操作添加
				*/
				if($v['kind']==$this->_tuiKind){
					$vv['_edit']="<span ext:qtip='{$v['kind']}数据，禁止退回'>退回</span>";
				}else{
					$vv['_edit']="<a href='".$this->_url('TuiAdd',array(
							'return4id'=>$vv['id'],
							'fromAction'=>$_GET['action']
						))."' ext:qtip='客户退货'>退回</a>";
				}

				//处理显示的退纱信息
				if($vv['return4id']>0){
					$temp=$this->_subModel->find($vv['return4id']);
					$v['kind']="<a href='#' style='color:red' ext:qtip='从{$temp['Ck']['chukuCode']}单退回'>{$v['kind']}</a>";
				}


				//计算合计，显示在上面的信息中
				$v['cnt']+=$vv['cnt'];
				$v['cntJian']+=$vv['cntJian'];
				$v['cntCi']+=$vv['cntCi'];
				$v['tuiCnt']+=$vv['tuiCnt'];
				$v['tuiCntCi']+=$vv['tuiCntCi'];
			}

			//查找库位信息
			if($v['kuweiId']){
				$sql="select * from jichu_kuwei where id='{$v['kuweiId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Kuwei'] = $temp[0];
			}

			//查找加工户信息
			if($v['jiagonghuId']){
				$sql="select * from jichu_jiagonghu where id='{$v['jiagonghuId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Jgh'] = $temp[0];
			}
			//查找加工户信息
			if($v['departmentId']){
				$sql="select * from jichu_department where id='{$v['departmentId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Department'] = $temp[0];
			}
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','tuiCnt','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo =array(
			"_edit" => array('text'=>'操作','width'=>170),
			'kind'=>'类型',
			'Kuwei.kuweiName'=>'仓库',
			'Jgh.compName'=>'加工户',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			'Department.depName'=>array('text'=>'部门名称','width'=>80),
			'peolingliao'=>array('text'=>'领料人','width'=>70),
			'cntJian'=>array('text'=>'件数','width'=>80),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			'tuiCnt'=>'退回数量',
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=array(
			"_edit" => array('text'=>'操作','width'=>40),
			// "compName" => '供应商', 
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '批号', 
			'cntJian'=>'件数',
			'dengji'=>'等级',
			'cnt'=>'数量(Kg)',
			'tuiCnt'=>'退回数量',
			'memoView'=>'备注',
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
	 * 客户退货登记界面
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionTuiAdd(){
		//查找需要退回的数据
		$parent = $this->_subModel->find($_GET['return4id']);
		// dump($parent);exit;
		//库位信息
		$_kuwei = & FLEA::getSingleton('Model_Jichu_Kuwei');
		$kuwei = $_kuwei->find($parent['Ck']['kuweiId']);

		//供应商信息
		$_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$supplier = $_supplier->find($parent['supplierId']);

		//加工户信息
		$jgh = $_supplier->find($parent['Ck']['jiagonghuId']);
		// dump($client);exit;
		//整理主要信息
		$data=array(
			'jghName'=>$jgh['compName'],
			// 'compName'=>$supplier['compName'],
			'kuweiName'=> $kuwei['kuweiName'],
			// 'supplierId'=>$parent['supplierId'],
			'kuweiId'=>$parent['Ck']['kuweiId'],
			'jiagonghuId'=>$parent['Ck']['jiagonghuId'],
			'pihao'=>$parent['pihao'],
			'color'=>$parent['color'],
			'dengjiParent'=>$parent['dengji'],
			'dengji'=>$parent['dengji'],
			'cntJianParent'=>round($parent['cntJian'],2),
			'cntParent'=>round($parent['cnt'],2),
			'return4id'=>$parent['id'],
			'productId'=>$parent['productId'],
			'memo'=>$this->_tuiKind,
			'danjia'=>round($parent['danjia'],6),
		);
		// dump($data);exit;
		//查找产品信息
		$sql = "select * from jichu_product where id='{$parent['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		// $data['zhonglei'] = $_temp[0]['zhonglei'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		$data['guige'] = $_temp[0]['guige'];
		// $data['color'] = $_temp[0]['color'];

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
		$par_main = $parent['Ck'];

		//供应商信息
		$_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$supplier = $_supplier->find($pro['supplierId']);

		//加工户信息
		$jgh = $_supplier->find($row['jiagonghuId']);

		$data=array(
			'id'=>$pro['id'],
			'cnt'=>$pro['cnt'],
			'cntJian'=>$pro['cntJian'],
			'danjia'=>round($parent['danjia'],6),
			'money'=>$pro['money'],
			'memo'=>$pro['memoView'],
			'pihao'=>$pro['pihao'],
			'color'=>$pro['color'],
			'dengji'=>$pro['dengji'],
			'dengjiParent'=>$parent['dengji'],
			'productId'=>$pro['productId'],
			'return4id'=>$pro['return4id'],
			'chukuId'=>$pro['chukuId'],
			// 'compName'=> $supplier['compName'],
			'kuweiName'=> $row['Kuwei']['kuweiName'],
			'jghName'=>$jgh['compName'],
			'chukuDate'=>$row['chukuDate'],
			// 'supplierId'=>$pro['supplierId'],
			'kuweiId'=>$row['kuweiId'],
			'jiagonghuId'=>$row['jiagonghuId'],
			'cntJianParent'=>round($parent['cntJian'],2),
			'cntParent'=>round($parent['cnt'],2),
		);
		
		//查找产品信息
		$sql = "select * from jichu_product where id='{$pro['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		// $data['zhonglei'] = $_temp[0]['zhonglei'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		$data['guige'] = $_temp[0]['guige'];
		// $data['color'] = $_temp[0]['color'];

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
			'chukuId'=>array('title'=>'','type'=>'hidden','value'=>''),
			'chukuCode'=>array('title'=>'退回单号','type'=>'text','value'=>$this->_getNewCode('BKLL','cangku_chuku','chukuCode'),'readonly'=>true),
			'jghName' => array('title' => '加工户', 'type' => 'text','readonly'=>true),
			'kuweiName' => array('title' => '仓库', 'type' => 'text','readonly'=>true),
			// 'compName' => array('title' => '供应商', 'type' => 'text','readonly'=>true),
			'proCode'=>array('type'=>'text',"title"=>'产品编码','readonly'=>true),
			'pinzhong'=>array('type'=>'text',"title"=>'品种','readonly'=>true),
			// 'proName'=>array('type'=>'text',"title"=>'纱支','readonly'=>true),
			'guige'=>array('type'=>'text',"title"=>'规格','readonly'=>true),
			'color'=>array('type'=>'text',"title"=>'颜色','readonly'=>true),
			'pihao'=>array('type'=>'text',"title"=>'批号','readonly'=>true),
			'dengjiParent'=>array('type'=>'text',"title"=>'领用等级','readonly'=>true),
			'cntJianParent' => array('type' => 'text', "title" => '领用件数', 'name' => 'cntJianParent','readonly'=>true),
			'cntParent' => array('type' => 'text', "title" => '领用数量', 'name' => 'cntParent','readonly'=>true,'addonEnd'=>'Kg'),
			'danjia' => array('type' => 'text', "title" => '加工单价','readonly'=>true),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()), 
			'cntJian' => array('type' => 'text', "title" => '退回件数'),
			'cnt' => array('type' => 'text', "title" => '退回数量','addonEnd'=>'Kg'),
			'money' => array('type' => 'text', "title" => '加工费'),
			'chukuDate' => array('title' => '退回日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'memo' => array('type' => 'textarea', "title" => '备注'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '0'),
			'isJiagong' => array('type' => 'hidden', 'value' => '0'),
			'kind' => array('type' => 'hidden', 'value' => $this->_tuiKind),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'return4id' => array('type' => 'hidden', 'value' => ''),
			// 'supplierId' => array('type' => 'hidden', 'value' =>''),
			'jiagonghuId' => array('type' => 'hidden', 'value' =>''),
			'kuweiId' => array('type' => 'hidden', 'value' =>'')
		);
	
		$rules = array(
			'cnt'=>'number',
			'cntCi'=>'number'
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
		$sql="select plan2proId,planTlId from cangku_chuku_son where id='{$_POST['return4id']}'";
		$parentCkInfo = $this->_subModel->findBySql($sql);
		$parentCkInfo = $parentCkInfo[0];
		//处理主要保存的信息
		$row=array(
			'id'=>$_POST['chukuId'],
			'chukuCode'=>$_POST['chukuCode'],
			'chukuDate'=>$_POST['chukuDate'],
			'isGuozhang'=>$_POST['isGuozhang'],
			'isJiagong'=>$_POST['isJiagong'],
			'kind'=>$_POST['kind'],
			'jiagonghuId'=>$_POST['jiagonghuId'],
			'kuweiId'=>$_POST['kuweiId'],
			'memo'=>$this->_tuiKind,
			'kind'=>$_POST['kind'],
			'type'=>$this->_type,
			'creater'=>$_SESSION['REALNAME'].'',
			'kind'=>$_POST['kind']
		);
		//子表保存信息
		$son[]=array(
			'id'=>$_POST['id'],
			'productId'=>$_POST['productId'],
			// 'supplierId'=>$_POST['supplierId'],
			'pihao'=>$_POST['pihao'],
			'color'=>$_POST['color'],
			'dengji'=>$_POST['dengji'],
			'cnt'=>abs($_POST['cnt'])*-1,
			'cntJian'=>abs($_POST['cntJian'])*-1,
			'danjia'=>$_POST['danjia']+0,
			'money'=>abs($_POST['money'])*-1,
			'memoView'=>$_POST['memo'],
			'return4id'=>$_POST['return4id'],
			'plan2proId'=>$parentCkInfo['plan2proId'],
			'planTlId'=>$parentCkInfo['planTlId'],
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