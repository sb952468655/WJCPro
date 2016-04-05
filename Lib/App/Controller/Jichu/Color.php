<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Color extends Tmis_Controller {
	var $_modelExample;
	var $fldMain;
	// /构造函数
	function __construct() {
		$this->_modelExample = &FLEA::getSingleton('Model_Jichu_Color');
		$this->fldMain = array(
			'color' => array('title' => '颜色', "type" => "text", 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''),
		);

		$this->rules=array(
			'color'=>'required repeat'
		);
	}

	function actionRight() {
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'key' => '',
		));
		$str = "select * from jichu_color where 1";
		if ($arr['key'] != '') $str .= " and color like '%{$arr['key']}%'";
		$str.=" order by letters,id";
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll();
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . ' ' . $this->getRemoveHtml($v['id']);
		}
		$smarty = &$this->_getView();
		$smarty->assign('title', '颜色档案');
		$arr_field_info = array(
			"_edit" => '操作',
			'color'=>'颜色',
			'letters'=>'助记码',
		);
		
		$smarty->assign('arr_field_info', $arr_field_info);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('arr_js_css', $this->makeArrayJsCss(array('thickbox')));
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url('Popup', $arr)));
		$smarty->display('TblList.tpl');
	}

	function actionAdd() {
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '仓库信息');
		$smarty->assign('rules', $this->rules);
		$smarty->display('Main/A1.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row);
		// dump($row);dump($this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('title', '仓库信息');
		$smarty->assign('aRow', $row);
		$smarty->assign('rules', $this->rules);
		$smarty->display('Main/A1.tpl');
	}

	function actionSave() {
		// 确保产品编码,品名,规格,颜色都存在
		if (!$_POST['color']) {
			js_alert('请输入颜色!', 'window.history.go(-1)');
			exit;
		}

		// 产品编码不重复
		$sql = "select count(*) cnt from {$this->_modelExample->qtableName} where color='{$_POST['color']}' and id<>'{$_POST['id']}'";
		$_rows = $this->_modelExample->findBySql($sql);
		if ($_rows[0]['cnt'] > 0) {
			js_alert('颜色重复!',  'window.history.go(-1)');
			exit;
		}

		FLEA::loadClass('TMIS_Common');
		$_POST['letters']=strtolower(TMIS_Common::getPinyin($_POST['color']));
		$this->_modelExample->save($_POST);
		js_alert(null, 'window.parent.showMsg("保存成功")', $this->_url($_POST['fromAction']));
		exit;
	}


	/**
	 * 颜色弹出窗口显示，用于显示颜色信息；支持多选功能
	 * Time：2014/07/01 14:15:54
	 * @author li
	*/
	function actionPopup(){

	}

	/**
	 * 自动完成控件
	 * Time：2014/07/02 14:41:31
	 * @author li
	 * @param $_POST
	 * @return json
	*/
	function actionGetColorByAjax(){
		$param=mysql_escape_string($_POST['title']);

		//如果选中了产品，则需要在产品对应的颜色中筛选
		$productId = (int)$_POST['productId'];
		if($productId>0){
			$sql="select color from jichu_product where id='{$productId}'";
			$temp = $this->_modelExample->findBySql($sql);
			$temp=explode(',',$temp[0]['color']);
			$data=array();
			foreach($temp as & $v){
				$data[]="'".$v."'";
			}
			$color=join(',',$data);
		}
		
		//查找颜色信息，
		$sql="select color from jichu_color where (color like '%{$param}%' or letters like '%{$param}%')";
		if($color!='')$sql.=" and color in ({$color})";
		$data = $this->_modelExample->findBySql($sql);

		echo json_encode($data);
	}

	/**
	 * 获取颜色信息
	 * Time：2014/08/08 09:55:54
	 * @author li
	 * @param GET
	 * @return JSON
	*/
	function actionGetColorByProId(){
		//如果选中了产品，则需要在产品对应的颜色中筛选
		// dump($_GET);exit;
		$productId = (int)$_GET['productId'];
		$_color=array();//颜色信息
		if($productId>0){
			$sql="select color from jichu_product where id='{$productId}'";
			$temp = $this->_modelExample->findBySql($sql);
			$color=explode(',',$temp[0]['color']);

			FLEA::loadClass('TMIS_Common');
			//添加首字母
			foreach ($color as $key => & $v) {
				$letter = strtoupper(TMIS_Common::getPinyin($v));
				$_color[]=array(
					'color'=>$v,
					'letter'=>substr($letter, 0,1),
				);
			}

			//按照首字母排序
			$_color=array_column_sort($_color,'letter');

			//处理数据，首字母第一次出现的需要做标记
			$_letter='';
			foreach ($_color as $key => & $v) {
				if($_letter!=$v['letter']){
					$v['first']=true;
					$_letter=$v['letter'];
				}
			}
			// dump($_color);exit;
		}
		echo json_encode(array('success'=>count($_color)>0,'data'=>$_color));
	}
}

?>