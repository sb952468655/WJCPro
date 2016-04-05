<?php
FLEA::loadClass('TMIS_Controller');
////////////////////////////////////////控制器名称
class Controller_Caiwu_Ys_Fapiao extends Tmis_Controller {
	var $_modelExample;
	var $_tplEdit='Caiwu/Ys/fapiaEdit.tpl';
	function __construct() {
		$this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Ys_Fapiao');
		$this->_modelGuozhang = & FLEA::getSingleton('Model_Caiwu_Ys_Fapiao2guozhang');

		//搭建过账界面
       //搭建过账界面
        $this->fldMain = array(
        	// 'creater' => array('type' => 'text', 'value' => $_SESSION['REALNAME'],'title'=>'制单人','readonly'=>true),
        	'fapiaoCode' => array('type' => 'text', 'value' => '','title'=>'发票单号'),
			'clientId' => array('title' => '客户名称', 'type' => 'clientpopup', 'clientName' => ''),
        	'headId'=>array('title'=>'公司抬头','type'=>'select','value'=>'','model'=>'Model_jichu_head'),
			'fapiaoDate' => array('title' => '发票日期', "type" => "calendar", 'value' => date('Y-m-d')),
			'money' => array('title' => '发票金额', 'type' => 'text', 'value' => '','name'=>'fpMoney'),
			'bizhong' => array('title' => '币种', 'type' => 'select', 'value' => 'RMB', 'options' => array(
					array('text' => 'RMB', 'value' => 'RMB'),
					array('text' => 'USD', 'value' => 'USD'),
					)),
			'huilv' => array('title' => '汇率', 'type' => 'text', 'value' => '1'),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => '','name'=>'fapiaoId'),
		);

		$this->headSon = array(
			'_edit' => array('type' => 'btCheckbox', "title" => '应收款', 'name' => '_edit[]'),
			'chukuDate' => array('type' =>'btspan',"title" =>'出库日期','name'=>'chukuDate[]','readonly'=>true),
			'Code' => array('type' => 'btspan', "title" =>'单号', 'name'=>'Code[]','readonly'=>true),
				
			//'orderCode' => array('type' => 'btspan', "title" =>'订单号', 'name'=>'orderCode[]','readonly'=>true),
			//'qitaMemo' => array('type' => 'btspan', "title" =>'产品信息', 'name' => 'qitaMemo[]','readonly'=>true),
			'pinzhong' => array('type' => 'btspan', "title" =>'品种', 'name' => 'pinzhong[]','readonly'=>true),
			'guige' => array('type' => 'btspan', "title" =>'规格', 'name' => 'guige[]','readonly'=>true),
			'dengji' => array('type' => 'btspan', "title" =>'等级', 'name' => 'dengji[]','readonly'=>true),
			'color' => array('type' => 'btspan', "title" =>'颜色', 'name' => 'color[]','readonly'=>true),
			'cnt' => array('type' => 'btspan', "title" => '数量', 'name' => 'cnt[]','readonly'=>true),
			'danjia' => array('type' => 'btspan', "title" => '单价', 'name' => 'danjia[]','readonly'=>true),
			'_money' => array('type' => 'btspan', "title" => '发生金额', 'name' => '_money[]','readonly'=>true),
			'ykmoney' => array('type' => 'btspan', "title" => '已开票', 'name' => 'ykmoney[]','readonly'=>true),
			'huilv' => array('type' => 'btspan', "title" => '汇率', 'name' => 'huilv[]','readonly'=>true),
			'money' => array('type' => 'bttext', "title" => '开票金额', 'name' => 'money[]','colmd'=>1),
			// 'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]','colmd'=>1),
			'fapiaoOver' => array('type' => 'btCheckbox', "title" => '发票完成', 'name' => 'fapiaoOver[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'guozhangId' => array('type' => 'bthidden', 'name' => 'guozhangId[]'),
			'orderId' => array('type' => 'bthidden', 'name' => 'orderId[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
		); 

		// 表单元素的验证规则定义
		$this->rules = array(
			'fapiaoCode' => 'required',
			'fapiaoDate' => 'required',
			'clientId' => 'required',
			'money' => 'required number'
		);
	}

	function actionRight() {
		// $this->authCheck('4-2-4');
		FLEA::loadclass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m'),date('d')-30,date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			'key'=>'',
			'no_edit'=>'',
		));
		$sql="select x.*,a.compName from caiwu_ar_fapiao x
			left join jichu_client a on a.id=x.clientId
			where 1";
		if($arr['clientId']!='')$sql.=" and x.clientId='{$arr['clientId']}'";
		if($arr['dateFrom']!=''){
			$sql.=" and x.fapiaoDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.fapiaoDate <='{$arr['dateTo']}'";
		}
		
		if($arr['key']!=''){
			$sql.=" and x.fapiaoCode like '%{$arr['key']}%'";
		}
		$sql.=" order by x.id desc";
		$page=& new TMIS_Pager($sql);
		$rowset=$page->findAll();
		//dump($rowset);exit;
		if(count($rowset)>0)foreach($rowset as & $v) {
				$v['_edit'].=$this->getEditHtml($v['id']).'&nbsp;&nbsp;'.$this->getRemoveHtml($v['id']);
                
                $v['money']=round($v['money'],3);
				//折合人民币
				$v['moneyRmb']=round($v['money']*$v['huilv'],3);
				$sql="select * from jichu_head where id='{$v['head']}'";
				$temp=$this->_modelExample->findBySql($sql);
				//dump($temp);exit;
				$v['headName']=$temp[0]['head'];

				//查找稽核信息
				$v['YingShou'] = $this->_modelGuozhang->findAll(array('fapiaoId'=>$v['id']));
				foreach ($v['YingShou'] as $key => & $c) {
					$c['chukuDate'] = $c['Guozhang']['chukuDate'];
					$c['guozhangDate'] = $c['Guozhang']['guozhangDate'];
					$c['_money'] = $c['Guozhang']['money'];
					$c['kind'] = $c['Guozhang']['kind'];
				}
		}

		$rowset[] = $this->getHeji($rowset, array('money','moneyRmb'), $_GET['no_edit']==1?'fapiaoCode':'_edit');
		
		$arr_field_info=array(
			'_edit'=>'操作',
			'fapiaoCode'=>array('text'=>'发票编码','width'=>100),
			'fapiaoDate'=>'收票日期',
			'compName'=>'客户',
			'headName'=>'公司抬头',
			'money'=>'金额',
			'moneyRmb'=>'金额(RMB)',
			'bizhong'=>'币种',
			'huilv'=>'汇率',
			'memo'=>'备注',
		);

		$arr_field2=array(
			'guozhangDate'=>array('text'=>'过账日期','width'=>100),
			'chukuDate'=>array('text'=>'发生日期','width'=>100),
			'kind'=>'发生类型',
			'_money'=>'应付金额',
			'money'=>'稽核金额',
			'memo'=>'备注',
		);
		$smarty=& $this->_getView();
		$smarty->assign('sub_field',"YingShou");
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_info2',$arr_field2);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$page->getNavBar($this->_url($_GET['action'],$arr)).$note);
		$smarty->display('TblListMore.tpl');
	}
	
	
	function actionSave() {
		//dump($_POST);exit;
		
		$arr=array();
		foreach($this->fldMain as $key=>&$v) {
			$name = $v['name']?$v['name']:$key;
			$arr[$key] = $_POST[$name];
		}
		$arr['huilv']=empty($arr['huilv'])?1:$arr['huilv'];

		//过账明细数据
		$pros=array();
		foreach ($_POST['_edit'] as & $v) {
			if(empty($_POST['money'][$v])) continue;
			$temp = array();
			foreach($this->headSon as $k=>&$vv) {
				$temp[$k] = $_POST[$k][$v];
			}
			$pros[]=$temp;
		}

		//获取完成的应收记录，更新状态
		$_ys=array();//标记已完成
		foreach ($_POST['fapiaoOver'] as & $v) {
			$_ys[]=$_POST['guozhangId'][$v];
		}

		//获取未完成的记录，有可能是取消完成的记录
		$noOver = array_diff($_POST['guozhangId'], $_ys);
		$overStr=join(',',$_ys);
		$noStr=join(',',$noOver);
		// dump($overStr);dump($noStr);exit;
		if($overStr!=''){
			$sql="update caiwu_ar_guozhang set fapiaoOver=1 where id in({$overStr})";
			$this->_modelExample->execute($sql);
		}
		if($noStr!=''){
			$sql="update caiwu_ar_guozhang set fapiaoOver=0 where id in({$noStr})";
			$this->_modelExample->execute($sql);
		}

		//所有需要删除的稽核记录：存在id,但是没有选中
		$ids=array_filter($_POST['id']);
		$clear=array_diff($ids,array_col_values($pros,'id'));
		// dump($clear);exit;

		$arr['Guozhang']=$pros;
		$arr['head']=$_POST['headId'];
		// dump($arr);exit;

		$id=$this->_modelExample->save($arr);
		if($id){
			$remove=join(',',$clear);
			if($remove!=''){
				$sql="delete from caiwu_ar_fapiao2guozhang where id in($remove)";
				$this->_modelExample->execute($sql);
			}
		}
		js_alert(null,'window.parent.showMsg("操作成功");',$this->_url($_POST['fromAction']==''?'add':$_POST['fromAction']));

	}
	function actionAdd() {
		$areaMain = array('title' => '开票基本信息', 'fld' => $this->fldMain); 

		while (count($rowsSon)<5) {
			$rowsSon[]=array();
		}
		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl',array(
				"Caiwu/Ys/Insert.tpl",
				"Caiwu/Ys/FapiaoEdit.tpl",

			));
		$smarty->assign('title', '发票信息编辑');
		$smarty->assign('firstColumn', array(
			'head'=>array('title'=>'应收款','type'=>'btBtnSel','url'=>url('Caiwu_Ys_Guozhang','GetYingshou'))
		));
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		$row['money']=round($row['money'],3);
		$row['huilv']=round($row['huilv'],4);
		// dump($row);exit;
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row); 
		$this->fldMain['clientId']['clientName']=$row['Client']['compName'];

		/*
		* 稽核明细处理
		*/
		//查找本次稽核的记录
		$pros=array();
		!$row['Guozhang'] && $row['Guozhang']=array();
		foreach($row['Guozhang'] as & $v){
			//查找过账信息，订单信息，其他信息
			$sql="select a.chukuCode Code,y.pinzhong,y.guige,x.chukuDate,x.money as _money,x.huilv,x.cnt,x.unit,x.danjia,x.fapiaoOver,x.qitaMemo,z.dengji,b.orderCode
			from caiwu_ar_guozhang x
			left join jichu_product y on x.productId=y.id
			left join cangku_chuku_son z on x.chuku2proId=z.id
			left join cangku_chuku a on x.chukuId=a.id
			left join trade_order b on b.id=x.orderId
			where x.id='{$v['guozhangId']}' order by x.chukuDate,x.guozhangDate";
			$temp=$this->_modelExample->findBySql($sql);
			$temp=$temp[0];
			$v+=$temp;
		}
		// dump($row['Guozhang']);exit;

		//查找还没有稽核的记录
		$guozhangId=join(',',array_col_values($row['Guozhang'],'guozhangId'));
		$guozhangId!='' && $inStr=" and x.id not in ($guozhangId)";
		$clientId = $row['clientId'];
		$sql="select x.chukuDate,x.money as _money,x.huilv,x.cnt,x.unit,x.danjia,x.id as guozhangId,x.orderId,x.ord2proId,x.qitaMemo,z.dengji,b.orderCode from caiwu_ar_guozhang x
		left join jichu_product y on x.productId=y.id
		left join cangku_chuku_son z on x.chuku2proId=z.id
		left join trade_order b on b.id=x.orderId
		where x.clientId='{$clientId}' and x.fapiaoOver=0 {$inStr} order by x.chukuDate,x.guozhangDate";
		// dump($sql);exit;
		$guozhang = $this->_modelExample->findBySql($sql);
		// dump($guozhang);exit;

		//两条记录合并在一起，按照日期排序
		$row['Guozhang']=array_merge($row['Guozhang'],$guozhang);
		$row['Guozhang']=array_column_sort($row['Guozhang'],'chukuDate',SORT_ASC);
		foreach ($row['Guozhang'] as $key => & $v) {

			$v['danjia']=round($v['danjia'],6);
			$v['_money']=round($v['_money'],6);
			$v['money']=round($v['money'],6);
			$v['cnt']=round($v['cnt'],6);
			$v['huilv']=round($v['huilv'],6);

			//查找已开票信息
			$sql="select sum(money) as money from caiwu_ar_fapiao2guozhang where guozhangId='{$v['guozhangId']}' and id<>'{$v['id']}'";
			// dump($sql);
			$_temp = $this->_modelExample->findBySql($sql);
			$v['ykmoney'] = round($_temp[0]['money'],3)+0;

			//未稽核的记录，默认显示的金额
			if(empty($v['id']))$v['money']=$v['_money']-$v['ykmoney'];
		}
		// dump($row['Guozhang']);exit;
		//查找所有的未完成的过账记录
		

		$rowsSon = array();
		foreach($row['Guozhang'] as $key => & $v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			// dump($temp);
			if($v['id']>0)$temp['_edit']['checked']=true;
			if($v['fapiaoOver']==1)$temp['fapiaoOver']['checked']=true;

			$temp['_edit']['value']=$key;
			$temp['fapiaoOver']['value']=$key;

			$rowsSon[] = $temp;
		}

		//补齐5行
		$cnt = count($rowsSon);
		if($cnt<=0)for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}

		$areaMain = array('title' => '开票基本信息', 'fld' => $this->fldMain); 
		// dump($row);exit;
		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules); 
		$smarty->assign('sonTpl',array(
				"Caiwu/Ys/Insert.tpl",
				"Caiwu/Ys/FapiaoEdit.tpl",

			));
		$smarty->assign('title', '发票信息编辑');
		$smarty->display('Main2Son/T1.tpl');
	}

	/**
	 * 删除功能，删除的同时需要更新关联过账记录的状态
	 * Time：2014/08/05 19:02:40
	 * @author li
	*/
	function actionRemove(){
		$this->authCheck();
		//查找需要更新状态的过账记录
		$sql="select group_concat(guozhangId) as guozhangId from caiwu_ar_fapiao2guozhang where fapiaoId='{$_GET['id']}'";
		$temp=$this->_modelExample->findBySql($sql);
		//更新状态
		if($temp[0]['guozhangId']!=''){
			$sql="update caiwu_ar_guozhang set fapiaoOver=0 where id in ({$temp[0]['guozhangId']})";
			$this->_modelExample->execute($sql);
		}

		parent::actionRemove();
	}
	
	/**
	 * 获取开票信息
	 * 用于收款稽核列表
	 * Time：2014/08/25 13:55:30
	 * @author li
	 * @param GET
	 * @return JSON
	*/
	function actionGetFapiaoByClientId(){
		$clientId = (int)$_GET['clientId'];

		//查找收款未完成的信息
		$sql="select * from caiwu_ar_fapiao where clientId='{$clientId}' and incomeOver=0";
		$fapiaoInfo = $this->_modelExample->findBySql($sql);

		foreach ($fapiaoInfo as & $v) {
			//查找已收款信息
			$sql="select sum(money) as money from caiwu_ar_income2fapiao where fapiaoId='{$v['id']}'";
			$income = $this->_modelExample->findBySql($sql);

			$v['ysmoney'] = round($income[0]['money'],2);
			$v['huilv'] = round($v['huilv'],4);
			$v['money'] = round($v['money'],3);
		}

		$success=true;
		if(!$clientId>0){
			$success=false;
			$msg="请选择客户信息";
		}elseif(count($fapiaoInfo)==0){
			$success=false;
			$msg="该客户不存在需要收款的开票信息";
		}

		echo json_encode(array(
			'success'=>$success,
			'msg'=>$msg,
			'data'=>$fapiaoInfo
		));exit;
	}
}
?>