<?php
FLEA::loadClass('Controller_Shengchan_Chuku');
class Controller_Shengchan_CangkuBu_Cpck extends Controller_Shengchan_Chuku {
	var $fldMain;
	var $headSon;
	var $rules; //表单元素的验证规则
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '布仓库';
		$this->_kind="成布出库";
		$this->_tuiKind="成布退回";
		//出库主信息
		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('BKCC','cangku_chuku','chukuCode')),
			'chukuDate' => array('title' => '出库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
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
			'clientName'=>array('title' => '客户选择', 'type' =>'text', 'readonly' => true),
			'kuweiId' => array('title' => '仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			// 'departmentId'=> array('title' => '领用部门','type' => 'select', 'value' => '','model'=>'Model_jichu_department'),
			// 'peolingliao' => array('title' => '领用人', 'type' => 'text', 'value' => ''),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注说明','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			'clientId' => array('type' => 'hidden', 'value' => ''),
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
			'proCode' => array('type' => 'bttext', "title" => '产品编码','name' =>'proCode[]','readonly'=>true),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]','readonly'=>true),
			'pihao'=>array('type'=>'bttext',"title"=>'缸号','name'=>'pihao[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)<span style="color:red;">*</span>', 'name' => 'cnt[]'),
			'cntM' => array('type' => 'bttext', "title" => '数量(M)', 'name' => 'cntM[]'),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'danjia' => array('type' => 'bthidden', 'name' => 'danjia[]'),
			'money' => array('type' => 'bthidden', 'name' => 'money[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			'productId' => array('type' => 'bthidden', 'name' => 'productId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'orderId' => 'required',
			'clientId' => 'required',
			'kuweiId' => 'required'
		);

		$this->sonTpl="Shengchan/Cangku/jsRuku.tpl";
		//编辑界面的权限id
		// $this->_addCheck = '3-5-4';
		// $this->_rightCheck = '3-5-5';
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
			'clientId'=>'',
			'commonCode' => '',
			'orderCode'=>'',
		)); 
		$sql="select x.* from cangku_chuku x where 1";
		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['commonCode']!='')$sql.=" and x.rukuCode like '%{$arr['commonCode']}%'";
		if($arr['isCheck']<2)$sql.=" and x.isCheck = '{$arr['isCheck']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId = '{$arr['clientId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['orderCode']!=''){
			//查找符合的订单id
			$str="select id from trade_order where orderCode like '%{$arr['orderCode']}%'";
			$res=$this->_modelExample->findBySql($str);
			//通过in 查找
			if(count($res)>0)$sql.=" and x.orderId in(".join(',',array_col_values($res,'id')).")";
			else $sql.=" and 0";
		}

		$sql.=" order by x.id desc";
		// echo $sql;exit;
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

				$vv['danjia']=round($vv['danjia'],6);

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
				$v['money']+=$vv['money'];
			}

			$chuku2proId=join(',',array_col_values($v['Products'],'id'));
			if($chuku2proId!=''){
				//查找是否有码单
				$sql="select id from cangku_madan where chuku2proId in({$chuku2proId}) limit 0,1";
				$res=$this->_modelExample->findBySql($sql);
				if($res[0]['id']>0){
					$v['madan']="<a href='".url('Shengchan_Madan','export',array(
						'chukuId'=>$v['id']
					))."'>导出</a>";
				}
			}

			//查找客户信息
			$sql="select compName from jichu_client where id='{$v['clientId']}'";
			$ccli = $this->_modelExample->findBySql($sql);
			$v['clientName'] = $ccli[0]['compName'];

			//查找库位信息
			if($v['kuweiId']){
				$sql="select * from jichu_kuwei where id='{$v['kuweiId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Kuwei'] = $temp[0];
			}

			//查找订单信息
			$sql="select orderCode from trade_order where id='{$v['orderId']}'";
			$res=$this->_modelExample->findBySql($sql);
			$v['orderCode']=$res[0]['orderCode'];
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','tuiCnt','money','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作','width'=>170),
			'madan'=>array('text'=>'码单','width'=>50),
			'kind'=>'类型',
			'orderCode'=>'订单号',
			'clientName'=>'客户',
			'Kuwei.kuweiName'=>'仓库',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			// 'peolingliao'=>array('text'=>'领料人','width'=>70),
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			'tuiCnt'=>'退回数量',
			// "money" => array('text'=>'金额','width'=>70),
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=array(
			"_edit" => array('text'=>'操作','width'=>40),
			// "compName" => '供应商', 
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '缸号',
			'dengji'=>'等级', 
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			'tuiCnt'=>'退回数量',
			// "danjia" => array('text'=>'单价','width'=>70),
			// "money" => array('text'=>'金额','width'=>70),
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

	//修改时要显示订单号
	function _beforeDisplayEdit(&$smarty) {
		$rowsSon = $smarty->_tpl_vars['rowsSon'];
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
	}

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
		$sql="select compName from jichu_client where id='{$row['clientId']}'";
		$ccli = $this->_modelExample->findBySql($sql);
		$row['clientName'] = $ccli[0]['compName'];
			
		// dump($row);exit;
		foreach($row['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			// dump($v);dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
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
			'出库日期'=>$row['chukuDate'],
			'客户'=>$row['clientName'],
			'领料部门'=>$row['Department']['depName'],
			'领料人'=>$row['peolingliao'],
			'库位'=>$row['Kuwei']['kuweiName'],
		);
		$smarty = &$this->_getView();
		$smarty->assign("title", $this->_kind.'单');
		$smarty->assign("arr_main_value", $main);
		$smarty->assign("arr_field_info", array(
			'proCode' => '产品编码',
			'pinzhong' => '品种',
			'guige' => '规格',
			'color' => '颜色',
			'pihao'=>'批号',
			'dengji'=>'等级',
			'cntJian' => '件数',
			'cnt' => '数量(Kg)',
			"money" => array('text'=>'金额','width'=>70),
			'memoView' => '备注'
		));
		if($row['isCheck']==1){
			// $smarty->assign("gongzhang", '1');
		}
		$smarty->assign("arr_field_value", $row['Products']);
		$smarty->display('Print.tpl');
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
		// $_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		// $supplier = $_supplier->find($parent['supplierId']);

		//客户信息
		$_client = & FLEA::getSingleton('Model_Jichu_Client');
		$client = $_client->find($parent['Ck']['clientId']);
		// dump($client);exit;
		//整理主要信息
		$data=array(
			'clientName'=>$client['compName'],
			// 'compName'=>$supplier['compName'],
			'kuweiName'=> $kuwei['kuweiName'],
			// 'supplierId'=>$parent['supplierId'],
			'kuweiId'=>$parent['Ck']['kuweiId'],
			'clientId'=>$parent['Ck']['clientId'],
			'color'=>$parent['color'],
			'pihao'=>$parent['pihao'],
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
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		// $data['proName'] = $_temp[0]['proName'];
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

		// //供应商信息
		// $_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		// $supplier = $_supplier->find($pro['supplierId']);

		//客户信息
		$_client = & FLEA::getSingleton('Model_Jichu_Client');
		$client = $_client->find($row['clientId']);

		$data=array(
			'id'=>$pro['id'],
			'cntJian'=>$pro['cntJian'],
			'cnt'=>$pro['cnt'],
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
			'clientName'=>$client['compName'],
			'chukuDate'=>$row['chukuDate'],
			// 'supplierId'=>$pro['supplierId'],
			'kuweiId'=>$row['kuweiId'],
			'clientId'=>$row['clientId'],
			'cntJianParent'=>round($parent['cntJian'],2),
			'cntParent'=>round($parent['cnt'],2),
			'danjia'=>round($parent['danjia'],6),
		);
		
		//查找产品信息
		$sql = "select * from jichu_product where id='{$pro['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		// $data['proName'] = $_temp[0]['proName'];
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
			'chukuCode'=>array('title'=>'退回单号','type'=>'text','value'=>$this->_getNewCode('BKXS','cangku_chuku','chukuCode'),'readonly'=>true),
			'clientName' => array('title' => '客户', 'type' => 'text','readonly'=>true),
			'kuweiName' => array('title' => '仓库', 'type' => 'text','readonly'=>true),
			// 'compName' => array('title' => '供应商', 'type' => 'text','readonly'=>true),
			'proCode'=>array('type'=>'text',"title"=>'产品编码','readonly'=>true),
			'pinzhong'=>array('type'=>'text',"title"=>'品种','readonly'=>true),
			// 'proName'=>array('type'=>'text',"title"=>'纱支','readonly'=>true),
			'guige'=>array('type'=>'text',"title"=>'规格','readonly'=>true),
			'color'=>array('type'=>'text',"title"=>'颜色','readonly'=>true),
			'pihao'=>array('type'=>'text',"title"=>'批号','readonly'=>true),
			'dengjiParent'=>array('type'=>'text',"title"=>'销售等级','readonly'=>true),
			'cntJianParent' => array('type' => 'text', "title" => '销售件数', 'name' => 'cntJianParent','readonly'=>true),
			'cntParent' => array('type' => 'text', "title" => '销售数量', 'name' => 'cntParent','readonly'=>true,'addonEnd'=>'Kg'),
			'danjia' => array('type' => 'text', "title" => '单价','readonly'=>true),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()),
			'cntJian' => array('type' => 'text', "title" => '退回件数'),
			'cnt' => array('type' => 'text', "title" => '退回数量','addonEnd'=>'Kg'),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()),
			'money' => array('type' => 'text', "title" => '金额'),
			'chukuDate' => array('title' => '退回日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'memo' => array('type' => 'textarea', "title" => '备注'),
			// 'gongxuName' => array('type' => 'hidden', 'value' => '本厂'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '0'),
			'kind' => array('type' => 'hidden', 'value' => $this->_tuiKind),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'return4id' => array('type' => 'hidden', 'value' => ''),
			// 'supplierId' => array('type' => 'hidden', 'value' =>''),
			'clientId' => array('type' => 'hidden', 'value' =>''),
			'kuweiId' => array('type' => 'hidden', 'value' =>'')
		);
	
		$rules = array(
			'cntJian'=>'number',
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
		$parent=$this->_subModel->find($_POST['return4id']);
		// dump($parent);exit;
		//处理主要保存的信息
		$row=array(
			'id'=>$_POST['chukuId'],
			'chukuCode'=>$_POST['chukuCode'],
			'chukuDate'=>$_POST['chukuDate'],
			'isGuozhang'=>$_POST['isGuozhang'],
			'kind'=>$_POST['kind'],
			'clientId'=>$_POST['clientId'],
			'orderId'=>$_POST['orderId'],
			'kuweiId'=>$_POST['kuweiId'],
			'memo'=>$this->_tuiKind,
			'kind'=>$_POST['kind'],
			'type'=>$this->_type,
			'creater'=>$_SESSION['REALNAME'].'',
			'kind'=>$_POST['kind'],
			'orderId'=>$parent['Ck']['orderId'],
		);
		//子表保存信息
		$son[]=array(
			'id'=>$_POST['id'],
			'productId'=>$_POST['productId'],
			'color'=>$_POST['color'],
			'pihao'=>$_POST['pihao'],
			'dengji'=>$_POST['dengji'],
			'cntJian'=>abs($_POST['cntJian'])*-1,
			'cnt'=>abs($_POST['cnt'])*-1,
			'danjia'=>$_POST['danjia']+0,
			'money'=>abs($_POST['money'])*-1,
			'memoView'=>$_POST['memo'],
			'return4id'=>$_POST['return4id'],
			'ord2proId'=>$parent['ord2proId'],
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

	/**
	 * 码单出库
	 * Time：2014/06/30 09:23:31
	 * @author li
	*/
	function actionEdit(){
		$_GET['id']=(int)$_GET['id'];
		//查找出库信息
		$rows = $this->_modelExample->find($_GET['id']);
		//获取出库子表id，用于查找是否存在码单关联信息
		$chuku2proId=join(',',array_col_values($rows['Products'],'id'));
		if($chuku2proId!=''){
			//查找是否有码单
			$sql="select id from cangku_madan where chuku2proId in({$chuku2proId}) limit 0,1";
			$res=$this->_modelExample->findBySql($sql);
			if($res[0]['id']>0){
				$madanCk=&FLEA::getSingleton('Controller_Shengchan_CangkuBu_CkWithMadan');
				// dump($madanCk);exit;
				$_GET['controller']="Shengchan_CangkuBu_CkWithMadan";
				$madanCk->actionEdit();exit;
			}
		}
		parent::actionEdit();
	}
}
?>