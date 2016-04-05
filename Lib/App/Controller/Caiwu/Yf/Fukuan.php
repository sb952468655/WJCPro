<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Caiwu_Yf_Fukuan extends Tmis_Controller {
	var $_modelExample;
	var $_tplEdit='Caiwu/Yf/FukuanEdit.tpl';
	function __construct() {
		$this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Yf_Fukuan');
		$this->_modelFapiao = & FLEA::getSingleton('Model_Caiwu_Yf_Fukuan2fapiao');
		 //搭建过账界面
        $this->fldMain = array(
        	'fukuanCode' => array('type' => 'text', 'value' => '','title'=>'付款单号'),
			'fukuanDate' => array('title' => '付款日期', "type" => "calendar", 'value' => date('Y-m-d')),
        	'headId'=>array('title'=>'公司抬头','type'=>'select','value'=>'','model'=>'Model_jichu_head'),
        	'bankId'=> array('title' => '银行账号', 'type' => 'select', 'value' => '', 'model' =>'Model_Caiwu_bank'),
			'supplierId' => array('title' => '应付对象', 'type' => 'select', 'value' => '','model'=>'Model_Jichu_Jiagonghu'),
			'fkType' => array('title' => '付款方式', 'type' => 'combobox', 'value' => '','options'=>$this->_modelExample->typeOptions()),
			'money' => array('title' => '本次付款', 'type' => 'text', 'value' => '','addonEnd'=>'元','name'=>'fkMoney'),
			'creater' => array('type' => 'text', 'value' => $_SESSION['REALNAME'],'title'=>'制单人','readonly'=>true),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => '','name'=>'fkId'),
		);

		$this->headSon = array(
			'_edit' => array('type' => 'btCheckbox', "title" => '应付款', 'name' => '_edit[]'),
			'fapiaoDate' => array('type' =>'btspan',"title" =>'收票日期','name'=>'fapiaoDate[]','readonly'=>true),
			'fapiaoCode' => array('type' => 'btspan', "title" =>'发票单号', 'name'=>'fapiaoCode[]','readonly'=>true),
			'head' => array('type' => 'btspan', "title" =>'发票抬头', 'name'=>'head[]','readonly'=>true),
			'_money' => array('type' => 'btspan', "title" => '票面金额', 'name' => '_money[]','readonly'=>true),
			'ysmoney' => array('type' => 'btspan', "title" => '已付款', 'name' => 'ysmoney[]','readonly'=>true),
			// 'bizhong' => array('type' => 'btspan', "title" => '开票币种', 'name' => 'bizhong[]','readonly'=>true),
			// 'huilv' => array('type' => 'btspan', "title" => '汇率', 'name' => 'huilv[]','readonly'=>true),
			'money' => array('type' => 'bttext', "title" => '收款金额', 'name' => 'money[]','colmd'=>1),
			// 'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]','colmd'=>1),
			'fukuanOver' => array('type' => 'btCheckbox', "title" => '付款完成', 'name' => 'fukuanOver[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'fapiaoId' => array('type' => 'bthidden', 'name' => 'fapiaoId[]'),
		);

		// 表单元素的验证规则定义
		$this->rules = array(
			'fukuanCode' => 'required',
			'fukuanDate' => 'required',
			'supplierId' => 'required',
			'money' => 'required number'
		);
	}
	function actionRight() {
		// $this->authCheck('4-1-6');
		FLEA::loadclass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m'),date('d')-30,date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'supplierId2'=>'',
			'key'=>'',
			'no_edit'=>'',
		));
		$sql="select x.*,a.compName,y.head headname from caiwu_yf_fukuan x
			left join jichu_jiagonghu a on a.id=x.supplierId
			left join jichu_head y on x.head=y.id
			where 1";
		if($arr['supplierId2']!='')$sql.=" and x.supplierId='{$arr['supplierId2']}'";
		if($arr['dateFrom']!=''){
			$sql.=" and x.fukuanDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.fukuanDate <='{$arr['dateTo']}'";
		}
		if($arr['key']!=''){
			$sql.=" and x.fukuanCode like '%{$arr['key']}%'";
		}
		$sql.=" order by x.id desc";
		$page=& new TMIS_Pager($sql);
		$rowset=$page->findAll();
		//dump($rowset);exit;
		if(count($rowset)>0)foreach($rowset as & $v) {
				$v['_edit'].=$this->getEditHtml($v['id']).'&nbsp;&nbsp;'.$this->getRemoveHtml($v['id']);
				$v['money']=round($v['money'],3);

				//查找稽核信息
				$v['Fapiao'] = $this->_modelFapiao->findAll(array('fapiaoId'=>$v['id']));
				foreach ($v['Fapiao'] as $key => & $c) {
					$c['fapiaoDate'] = $c['Fapiao']['fapiaoDate'];
					$c['fapiaoCode'] = $c['Fapiao']['fapiaoCode'];
					$c['_money'] = $c['Fapiao']['money'];
				}
		}
		// dump($rowset);exit;
		$rowset[] = $this->getHeji($rowset, array('money'), $_GET['no_edit']==1?'fukuanCode':'_edit');
		
		$arr_field_info=array(
			'_edit'=>'操作',
			'fukuanCode'=>array('text'=>'付款单号','width'=>100),
			'fukuanDate'=>'付款日期',
			'headname'=>'公司抬头',
			'compName'=>'付款对象',
			'fkType'=>'付款方式',
			'money'=>'金额',
			'memo'=>'备注',
		);

		$arr_field_info2=array(
			'fapiaoDate'=>array('text'=>'发票日期','width'=>100),
			'fapiaoCode'=>'发票单号',
			'_money'=>'票面金额',
			'money'=>'金额',
			'memo'=>'备注',
		);

		$smarty=& $this->_getView();
		$smarty->assign('sub_field',"Fapiao");
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_info2',$arr_field_info2);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$page->getNavBar($this->_url($_GET['action'],$arr)).$note);
		$smarty->display('TblListMore.tpl');
	}

	// function _edit($arr) {
	// 	$this->authCheck('4-1-5');
	// 	parent::_edit($arr);
	// }

	function actionSave() {
		$arr=array();
		foreach($this->fldMain as $key=>&$v) {
			$name = $v['name']?$v['name']:$key;
			$arr[$key] = $_POST[$name];
		}

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
		foreach ($_POST['fukuanOver'] as & $v) {
			$_ys[]=$_POST['fapiaoId'][$v];
		}

		//获取未完成的记录，有可能是取消完成的记录
		$noOver = array_diff($_POST['fapiaoId'], $_ys);
		$overStr=join(',',$_ys);
		$noStr=join(',',$noOver);
		$noStr2=join('',$noOver);
		// dump($overStr);dump($noStr);exit;
		

		//所有需要删除的稽核记录：存在id,但是没有选中
		$ids=array_filter($_POST['id']);
		$clear=array_diff($ids,array_col_values($pros,'id'));
		// dump($clear);exit;

		$arr['Fapiao']=$pros;
		// dump($arr);exit;
		$arr['head']=$arr['headId'];
		//保存收款纪录
		$id=$this->_modelExample->save($arr);

		//保存后处理的动作
		if($id){
			//删除需要取消的关联发票信息
			$remove=join(',',$clear);
			if($remove!=''){
				$sql="delete from caiwu_yf_fukuan2fapiao where id in($remove)";
				$this->_modelExample->execute($sql);
			}

			//改变是否收款完成的状态信息
			if($overStr!=''){
				$sql="update caiwu_yf_fapiao set fukuanOver=1 where id in({$overStr})";
				$this->_modelExample->execute($sql);
			}
			if($noStr2!=''){
				$sql="update caiwu_yf_fapiao set fukuanOver=0 where id in({$noStr})";
				$this->_modelExample->execute($sql);
			}
		}

		//界面跳转
		js_alert(null,'window.parent.showMsg("操作成功");',$this->_url($_POST['fromAction']==''?'add':$_POST['fromAction']));

	}

	function actionGetSelectByAjax(){
		$sql="select fkType as text from caiwu_yf_fukuan group by fkType order by count(id) desc";
		$res=$this->_modelExample->findBySql($sql);
		echo json_encode($res);
	}

	function actionAdd() {
		$areaMain = array('title' => '付款基本信息', 'fld' => $this->fldMain); 

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
				"Caiwu/Yf/FukuanEdit.tpl",
			));
		//dump($rowsSon);exit;
		$smarty->assign('firstColumn', array(
			'head'=>array('title'=>'开票列表','type'=>'btBtnSel','url'=>url('Caiwu_Yf_Fapiao','GetFapiaoInfo'))
		));
		$smarty->assign('title', '付款信息编辑');
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		$row['money']=round($row['money'],3);

		// dump($row);exit;
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row);

		/*
		* 稽核明细处理
		*/
		//查找本次稽核的记录
		$pros=array();
		!$row['Fapiao'] && $row['Fapiao']=array();
		foreach($row['Fapiao'] as & $v){
			//查找过账信息，订单信息，其他信息
			$sql="select x.fapiaoDate,x.fapiaoCode,x.money as _money,x.fukuanOver from caiwu_yf_fapiao x
			where x.id='{$v['fapiaoId']}' order by x.fapiaoDate,id asc";
			$temp=$this->_modelExample->findBySql($sql);
			$temp=$temp[0];
			$v+=$temp;
		}
		// dump($row['Fapiao']);exit;

		//查找还没有稽核的记录
		$fapiaoId=join(',',array_col_values($row['Fapiao'],'fapiaoId'));
		$fapiaoId!='' && $inStr=" and x.id not in ($fapiaoId)";
		$supplierId = $row['supplierId'];
		$sql="select x.fapiaoDate,x.fapiaoCode,x.money as _money,x.id as fapiaoId from caiwu_yf_fapiao x
		where x.supplierId='{$supplierId}' and x.fukuanOver=0 {$inStr} order by x.fapiaoDate,id asc";
		// dump($sql);exit;
		$fapiao = $this->_modelExample->findBySql($sql);
		// dump($fapiao);exit;

		//两条记录合并在一起，按照日期排序
		$row['Fapiao']=array_merge($row['Fapiao'],$fapiao);
		// dump($row);exit;
		$row['Fapiao']=array_column_sort($row['Fapiao'],'fapiaoDate',SORT_ASC);
		foreach ($row['Fapiao'] as $key => & $v) {

			$v['_money']=round($v['_money'],6);
			$v['money']=round($v['money'],6);

			//查找已开票信息
			$sql="select sum(money) as money from caiwu_yf_fukuan2fapiao where fapiaoId='{$v['fapiaoId']}' and id<>'{$v['id']}'";
			// dump($sql);
			$_temp = $this->_modelExample->findBySql($sql);
			$v['ysmoney'] = round($_temp[0]['money'],3)+0;

			//未稽核的记录，默认显示的金额
			if(empty($v['id']))$v['money']=$v['_money']-$v['ysmoney'];
		}
		// dump($row['Guozhang']);exit;
		//查找所有的未完成的过账记录
		

		$rowsSon = array();
		foreach($row['Fapiao'] as $key => & $v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			// dump($temp);
			if($v['id']>0)$temp['_edit']['checked']=true;
			if($v['fukuanOver']==1)$temp['fukuanOver']['checked']=true;

			$temp['_edit']['value']=$key;
			$temp['fukuanOver']['value']=$key;

			$rowsSon[] = $temp;
		}

		//补齐5行
		$cnt = count($rowsSon);
		if($cnt<=0)for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}

		$areaMain = array('title' => '付款基本信息', 'fld' => $this->fldMain); 
		$areaMain['fld']['headId']['value']=$row['head'];
		// dump($row);exit;
		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules); 
		$smarty->assign('sonTpl',array(
				"Caiwu/Ys/Insert.tpl",
				"Caiwu/Yf/FukuanEdit.tpl",

			));
		$smarty->assign('title', '付款信息编辑');
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
		$sql="select group_concat(fapiaoId) as fapiaoId from caiwu_yf_fukuan2fapiao where fukuanId='{$_GET['id']}'";
		$temp=$this->_modelExample->findBySql($sql);
		//更新状态
		if($temp[0]['fapiaoId']!=''){
			$sql="update caiwu_yf_fapiao set fukuanOver=0 where id in ({$temp[0]['fapiaoId']})";
			$this->_modelExample->execute($sql);
		}

		parent::actionRemove();
	}
}
?>