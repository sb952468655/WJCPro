<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Kuwei extends Tmis_Controller {
	var $_modelExample;
	var $fldMain; 
	// /构造函数
	function __construct() {
		$this->_modelExample = &FLEA::getSingleton('Model_Jichu_Kuwei'); 
		
		$this->fldMain = array(
			'jiagonghuId' => array('title' => '加工户', 'type' => 'select', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=0'),
			'kuwei'=>array('title' => '仓库', "type" => "text", 'value' => ''),
			'kuweiName' => array("type" => "hidden", 'value' => ''),
			'memo' => array('title' => '备注', "type" => "textarea", 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''), 
		);
	}

	function actionRight() {
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			// "kind" => "",
			'jiagonghuId'=>'',
			'key' => '',
		));
		$str = "select x.id,x.kuweiName,x.kuwei,y.compName as jiagonghuId 
		from {$this->_modelExample->qtableName} x
		left join jichu_jiagonghu y on x.jiagonghuId=y.id
		where 1";
		if ($arr['key'] != '') $str .= " and x.kuweiName like '%{$arr['key']}%'";
		if ($arr['jiagonghuId'] != '') $str .= " and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		$str.=" order by x.letters,x.id desc";
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . ' ' . $this->getRemoveHtml($v['id']);

			//查找加工户名称
			// $sql="select * from jichu_jiagonghu where id='{$v['jiagonghuId']}'";
			// $res = $this->_modelExample->findBySql($sql);
			// $v['jiagonghuId']=$res[0]['compName'];
		}
		$smarty = &$this->_getView();
		$smarty->assign('title', '仓库');
		$arr_field_info = array(
			"_edit" => '操作',
			'kuweiName'=>array('text'=>'仓库名称','width'=>180),
		);
		foreach($this->fldMain as $k=>& $v) {
			if($v['type'] == 'hidden') continue;
			$arr_field_info[$k] = $v['title'];
		}
		$smarty->assign('arr_field_info', $arr_field_info);
		$smarty->assign('arr_field_value', $rowset); 
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	} 

	function actionAdd() {
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '仓库信息');
		$smarty->display('Main/A.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row); 
		// dump($row);dump($this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '仓库信息');
		$smarty->assign('aRow', $row);
		$smarty->display('Main/A.tpl');
	}

	function actionSave() {
		// 确保产品编码,品名,规格,颜色都存在
		if (!$_POST['kuwei']) {
			js_alert('请输入库位名!', 'window.history.go(-1)');
			exit;
		}


		// 产品编码不重复
		$sql = "select count(*) cnt from {$this->_modelExample->qtableName} where kuwei='{$_POST['kuwei']}' and  jiagonghuId='{$_POST['jiagonghuId']}' and id<>'{$_POST['id']}'";
		$_rows = $this->_modelExample->findBySql($sql);
		if ($_rows[0]['cnt'] > 0) {
			js_alert('库位重复!',  'window.history.go(-1)');
			exit;
		}

		//查找加工户
		$sql="select * from jichu_jiagonghu where id='{$_POST['jiagonghuId']}'";
		$res = $this->_modelExample->findBySql($sql);
		$_POST['kuweiName']=$res[0]['compName'].$_POST['kuwei'];
		
		//首字母自动获取
		FLEA::loadClass('TMIS_Common');
		$letters=strtoupper(TMIS_Common::getPinyin($_POST['kuweiName']));
		$_POST['letters']=$letters;

		$this->_modelExample->save($_POST);
		js_alert(null, 'window.parent.showMsg("保存成功")', $this->_url($_POST['fromAction']));
		exit;
	}

	/**
	 * 弹出窗口选择
	 * Time：2014/08/06 10:39:09
	 * @author li
	*/
	function actionPopup() {
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			// "kind" => "",
			'jiagonghuId'=>'',
			'key' => '',
		));
		//查找数据sql
		$str = "select x.id,x.kuweiName,x.kuwei,y.compName,x.jiagonghuId
		from {$this->_modelExample->qtableName} x
		left join jichu_jiagonghu y on x.jiagonghuId=y.id
		where 1";
		if ($arr['key'] != '') $str .= " and x.kuweiName like '%{$arr['key']}%'";
		if ($arr['jiagonghuId'] != '') $str .= " and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		//按照加工户首字母排序
		$str.=" order by x.letters,x.id desc";
		//分页查找数据
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll();
		//遍历数组
		foreach($rowset as &$v) {
		}

		$smarty = &$this->_getView();
		$smarty->assign('title', '仓库');
		$arr_field_info = array(
			'kuweiName'=>array('text'=>'仓库名称','width'=>180),
			'compName'=>array('text'=>'加工户','width'=>180),
			'kuwei'=>array('text'=>'库位','width'=>100),

		);
		
		$smarty->assign('arr_field_info', $arr_field_info);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('page_info', $pager->getNavBar($this->_url('Popup', $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	} 
}

?>