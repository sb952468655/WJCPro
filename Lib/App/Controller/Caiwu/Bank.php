<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Caiwu_Bank extends Tmis_Controller {
	var $_modelExample;
	var $funcId = 35;
	function Controller_Caiwu_Bank() {
		$this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Bank');

		$this->fldMain = array(
        	'id'=>array('title'=>'','type'=>'hidden','value'=>''),
        	'itemName'=>array('title'=>'账户名称','type'=>'text','value'=>''),
        	'address'=>array('title'=>'地址','type'=>'text','value'=>''),
        	'manger'=>array('title'=>'负责人','type'=>'text','value'=>''),
        	'tel'=>array('title'=>'电话','type'=>'text','value'=>''),
        	'contacter'=>array('title'=>'联系人','type'=>'text','value'=>''),
        	'phone'=>array('title'=>'电话','type'=>'text','value'=>''),
        	'tel'=>array('title'=>'营业厅电话','type'=>'text','value'=>''),
        	'acountCode'=>array('title'=>'开户账号','type'=>'text','value'=>''),
        	'xingzhi'=>array('title'=>'性质','type'=>'select','value'=>'','options'=>array(
        			array('text'=>'基本户','value'=>'基本户'),
        			array('text'=>'一般户','value'=>'一般户'),
        			array('text'=>'税务专用','value'=>'税务专用')
        		)),
        	'memo'=>array('title'=>'备注','type'=>'textarea','value'=>''),
        );

        $this->rules = array(
			'itemName'=>'required'
		);
	}

	function actionRight() {
		$this->authCheck('6-16');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array('key'=>''));
		$pager =& new TMIS_Pager($this->_modelExample);
		//dump($this->_modelExample);exit;
		$rowset =$pager->findAll();
		//dump($rowset);exit;
		if(count($rowset)>0) foreach($rowset as & $v) {
			$v['_edit'] = $this->getEditHtml($v['id']) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
			}
		//dump($rowset);
		$smarty = & $this->_getView();
		$smarty->assign('title', '银行帐户');
		#对操作栏进行赋值
		
		$arr_field_info = array(
			'_edit'=>'操作',
			"itemName" =>"账户名称",
			"address"=>"地址",
			"manger"=>"负责人",
			"tel"=>"电话",
			"contacter"=>"联系人",
			"phone"=>"营业厅电话",
			"acountCode"=>"开户账号",
			"xingzhi"=>"性质"
		);

		// $smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('right')));
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid')));
		$smarty-> display('TableList.tpl');
	}

	function actionSave() {
		$id = $this->_modelExample->save($_POST);
		if($_POST['Submit']=='保 存')
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url($_POST['fromAction']==''?'add':$_POST['fromAction']));
		else
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url('add'));
	}

	function actionEdit(){
		$row = $this->_modelExample->find(array('id'=>$_GET['id']));
	    $this->fldMain = $this->getValueFromRow($this->fldMain,$row);
	    // dump($row);dump($this->fldMain);exit;
	    $smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('rules',$this->rules);
	    $smarty->assign('title','银行账户编辑');
	    $smarty->assign('aRow',$row);
	    $smarty->display('Main/A.tpl');
	}

	function actionAdd($Arr){
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('title','银行账户编辑');
	    $smarty->assign('rules',$this->rules);
	    $smarty->display('Main/A.tpl');
	}
}
?>