<?php
FLEA::loadClass('Controller_Shengchan_Ruku');
class Controller_Shengchan_CangkuBu_Cprk extends Controller_Shengchan_Ruku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = "布仓库";
		$this->_kind="成品入库";
		// 定义模板中的主表字段
		$this->fldMain = array(
			'rukuCode' => array('title' => '单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('BKCR','cangku_ruku','rukuCode')),
			'rukuDate' => array('title' => '入库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind'=>array('title'=>'入库类型','type'=>'text','readonly'=>true,'name'=>'kind','value'=>$this->_kind),
			'kuweiId' => array('title' => '仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			'orderId' => array(
				'title' => '相关订单', 
				'type' => 'popup', 
				'value' => '',
				'name'=>'orderId',
				'text'=>'',
				'url'=>url('Trade_Order','Popup'),
				//'jsTpl'=>'Cangku/Chengpin/jsRuku.tpl',//需要载入的模板文件，这个文件中不需要使用{literal},因为是通过file_get_content获得的
				'onSelFunc'=>'onSel',//选中后需要执行的回调函数名,需要在jsTpl中书写
				'textFld'=>'orderCode',//显示在text中的字段
				'hiddenFld'=>'orderId',//显示在hidden控件中的字段
			),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'cgrkId'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '1'),
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
			// 'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'proCode' => array('type' => 'bttext', "title" => '产品编码', 'name' => 'proCode[]','readonly'=>true),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]','readonly'=>true),
			'pihao'=>array('type'=>'bttext',"title"=>'批号','name'=>'pihao[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)<span style="color:red;">*</span>', 'name' => 'cnt[]'),
			'cntM' => array('type' => 'bttext', "title" => '数量(M)', 'name' => 'cntM[]'),
			// 'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			// 'money' => array('type' => 'bttext', "title" => '金额', 'name' => 'money[]','readonly'=>true),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			'productId' => array('type' => 'bthidden', 'name' => 'productId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'orderId' => 'required',
			'supplierId' => 'required',
			'kuweiId' => 'required'
		);

		// $this->_rightCheck='3-5-2';
		// $this->_addCheck='3-5-1';
		$this->sonTpl="Shengchan/Cangku/jsRuku.tpl";
	}

	function actionRight(){
		//权限判断
		$this->authCheck($this->_rightCheck);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			// 'supplierId'=>'',
			'kuweiId'=>'',
			'commonCode' => '',
			'orderCode'=>'',
		)); 
		// $this->_beforeSearch($arr);

		$condition=array();
		$condition[]=array('kind',$this->_kind,'=');
		$condition[]=array('type',$this->_type,'=');
		if($arr['orderCode']!=''){
			//查找符合的订单id
			$sql="select id from trade_order where orderCode like '%{$arr['orderCode']}%'";
			$res=$this->_modelExample->findBySql($sql);
			//通过in 查找
			if(count($res)>0)$condition['in()']=array('orderId'=>array_col_values($res,'id'));
			else $condition[]=array('id',0,'=');
		}
		if($arr['commonCode']!='')$condition[]=array('rukuCode',"%{$arr['commonCode']}%",'like');
		if($arr['supplierId']!='')$condition[]=array('supplierId',$arr['supplierId'],'=');
		if($arr['kuweiId']!='')$condition[]=array('kuweiId',$arr['kuweiId'],'=');
		//查找计划
		$pager = &new TMIS_Pager($this->_modelExample,$condition,'id desc');
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

				//设置码单
				//查找是否存在码单
				$sql="select id from cangku_madan where ruku2proId='{$vv['id']}' limit 0,1";
				$temp=$this->_modelExample->findBySql($sql);
				$color='';
				$title='';
				if($temp[0]['id']>0){
					$color="green";
					$title="码单已设置";
				}
				$vv['_edit']="<a style='color:{$color}' href='".$this->_url('SetMadan',array('ruku2proId'=>$vv['id']))."' title='{$title}'>码单</a>";
			}

			//查找订单信息
			$sql="select orderCode from trade_order where id='{$v['orderId']}'";
			$res=$this->_modelExample->findBySql($sql);
			$v['orderCode']=$res[0]['orderCode'];

		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => '操作',
			'kind'=>'类型',
			'Kuwei.kuweiName'=>'仓库',
			"rukuDate" => "发生日期",
			'orderCode'=>'订单号',
			'rukuCode' => array('text'=>'入库单号','width'=>120),
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		);

		$arrField = array(
			"_edit" => array('text'=>'操作','width'=>70),
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			// "proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '批号', 
			'dengji'=>'等级',
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			'cntM'=>'数量(M)',
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

	//修改时要显示订单号
	function _beforeDisplayEdit(&$smarty) {
		$rowsSon = $smarty->_tpl_vars['rowsSon'];
		$areaMain = & $smarty->_tpl_vars['areaMain'];
		// dump($smarty->_tpl_vars);dump($areaMain);exit;
		$orderId= $areaMain['fld']['orderId']['value'];
		$sql = "select orderCode from trade_order where id='{$orderId}'";
		// dump($sql);
		$_rows = $this->_modelExample->findBySql($sql);

		$areaMain['fld']['orderId']['text'] = $_rows[0]['orderCode'];
	}

	/**
	 * 添加码单信息
	 * Time：2014/06/25 15:30:23
	 * @author li
	*/
	function actionSetMadan(){
		$this->authCheck();
		$_GET['ruku2proId']=(int)$_GET['ruku2proId'];
		//查找所有已设置的码单信息
		$madan = & FLEA::getSingleton('Model_Shengchan_Cangku_Madan');
		$madan->clearLinks();
		//查找所有码单
		$madanArr = $madan->findAll(array('ruku2proId'=>$_GET['ruku2proId']));
		$temp=array();
		foreach ($madanArr as $key => & $v) {
			if($v['chuku2proId']>0)$v['readonly']=true;
			$temp[$v['number']-1]=$v;
		}
		$madanArr=$temp;
		//组织数组信息
		$row = array('id'=>$_GET['ruku2proId'],'Madan'=>$madanArr);

		$smarty = & $this->_getView();
		$smarty->assign('title', "设置码单");
		$smarty->assign('ruku2proId', $_GET['ruku2proId']);
		$smarty->assign('madanRows', json_encode($madanArr));
		$smarty->display("Shengchan/Cangku/RkDajuanEdit.tpl");
	}

	/**
	 * 保存码单信息
	 * Time：2014/06/25 17:15:18
	 * @author li
	*/
	function actionSaveMadanByAjax(){
		// dump($_POST);exit;
		$_P = json_decode($_POST['jsonStr'],true);
		// dump($_P);exit;
		$madan_arr = array();//需要保存的码单信息
		$madan_clear = array();//需要删除的码单信息

		foreach ($_P as $key => & $v) {
			//数量不存在，说明该码单不需要保存
			if(empty($v['cntFormat']) && empty($v['cnt_M'])){
				//如果id存在，则说明该码单需要在数据表中删除
				if($v['id']>0){
					$madan_clear[]=$v['id'];
				}
				continue;
			}
			//入库明细表id
			$madan_arr[]=array(
				'id'=>$v['id']+0,
				'ruku2proId'=>$_POST['ruku2proId'],
				'number'=>$v['number'],
				'cntFormat'=>$v['cntFormat'],
				'cnt'=>$v['cnt'],
				'cntM'=>$v['cntM'],
				'cnt_M'=>$v['cnt_M'],
				'lot'=>$v['lot'].'',
			);
		}
		// dump($madan_arr);exit;

		//如果码单信息存在，则保存
		if(count($madan_arr)>0){
			$madan = & FLEA::getSingleton('Model_Shengchan_Cangku_Madan');
			$madan->saveRowset($madan_arr);
		}
		//处理需要清空的数据
		$strSonId=join(',',$madan_clear);
		if($strSonId!=''){
			$sql="delete from cangku_madan where id in ({$strSonId})";
			$this->_subModel->execute($sql);
		}
		
		echo json_encode(array(
			'success'=>true,
			'msg'=>'操作完成'
		));exit;

	}
}

?>