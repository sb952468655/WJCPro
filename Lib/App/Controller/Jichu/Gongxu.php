<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Gongxu extends Tmis_Controller {
	var $_modelExample;

	function __construct() {
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_Gongxu');

		$this->fldMain = array(
        	'id'=>array('title'=>'','type'=>'hidden','value'=>''),
        	'itemName'=>array('title'=>'工序名称','type'=>'text','value'=>''),
        	'orderLine'=>array('title'=>'排列顺序','type'=>'text','value'=>''),  
        );

        $this->rules = array(
			'jitaiCode'=>'required repeat',
			'orderLine'=>'number'
		);
	}

	function actionRight() {
		$title = '工序档案';
		///////////////////模板文件
		$tpl = 'TableList.tpl';
		///////////////////////表头
		$arr_field_info = array(
			'_edit'=>'操作',
			"itemName" =>"工序名称",
			'orderLine'=>'排列顺序',
			// 'memo'=>'备注'
		);
		
		///////////////////////////////模块定义
		$this->authCheck('6-9');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'key'=>''
		));
		
		if($arr['key']!='') {
			$condition[] = array('itemName',"%{$arr['key']}%",'like');
		}
		
		$pager =& new TMIS_Pager($this->_modelExample,$condition,'orderLine');
		$rowset =$pager->findAll();
		// dump($rowset);exit;
		foreach($rowset as & $v) {
			$this->makeEditable($v,'orderLine');
			$v['_edit'] = $this->getEditHtml($v['id']) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display($tpl);
	}


	function actionEdit(){
		$row = $this->_modelExample->find(array('id'=>$_GET['id']));
	    $this->fldMain = $this->getValueFromRow($this->fldMain,$row);
	    // dump($row);dump($this->fldMain);exit;
	    $smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('rules',$this->rules);
	    $smarty->assign('title','工序信息编辑');
	    $smarty->assign('aRow',$row);
	    $smarty->display('Main/A1.tpl');
	}

	function actionAdd($Arr){
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('title','工序信息编辑');
	    $smarty->assign('rules',$this->rules);
	    $smarty->display('Main/A1.tpl');
	}

	function actionSave(){
		$row = array();
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$row[$k] = $_POST[$name];
		}
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