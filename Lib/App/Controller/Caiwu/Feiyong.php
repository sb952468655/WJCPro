<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Caiwu_Feiyong extends Tmis_Controller {
	var $_modelExample;
	function Controller_Caiwu_Feiyong() {
		$this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Feiyong');
	}

	function actionRight(){
		$this->authCheck('8-3-4');
		FLEA::loadclass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m'),date('d')-30,date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'feiyongId'=>'',
			'isShenhe'=>0
		));
	//dump($arr);exit;
		if($arr['feiyongId']!='')$condition[]=array('itemId',"{$arr['feiyongId']}",'=');
		if($arr['dateFrom']!=''){
			$condition[]=array('comeDate',"{$arr['dateFrom']}",'>=');
		}
		if($arr['dateTo']!=''){
			$condition[]=array('comeDate',"{$arr['dateTo']}",'<=');
		}
		if($arr['isShenhe']!=2){
			$condition[]=array('isShenhe',"{$arr['isShenhe']}",'=');
		}
		$page=& new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset=$page->findAll();
		//dump($rowset);exit;
		if(count($rowset)>0)foreach($rowset as & $v) {
			 if($v['isShenhe']==1){
			 	$v['_edit']="<span ext:qtip='此信息已审核，禁止操作'>修改  |   删除</span>";
					$v['_edit'].='  |  '."<a href='".$this->_url('Check', array('isShenhe'=>0,'id'=>$v['id'],'fromAction'=>$_GET['action']))."' >取消审核</a>";
			 }else{
				 	$v['_edit'].=$this->getEditHtml(array(
						'id'=>$v['id'],
						'fromAction'=>'right'
					)).'  |  '.$this->getRemoveHtml(array(
						'id'=>$v['id'],
						'fromAction'=>'right'
					));
					$v['_edit'].='  |  '. "<a href='".$this->_url('Check', array('isShenhe'=>1,'id'=>$v['id']))."' >审核</a>";
			 }
				
			}
		$rowset[]=$this->getHeji($rowset,array('money'),'_edit');
		//dump($rowset);
		$arr_field_info=array(
			'_edit'=>'操作',
			'comeDate'=>'往来日期',
			'payDate'=>'付款日期',
			'shoukuanfang'=>'收款方',
			'itemName'=>'费用名称',
			'money'=>'金额',
			'memo'=>'备注',

		);
		//$note="<font color='red'>绿色表示已经到账完成。</font>";
		$smarty=& $this->_getView();
		$smarty->assign('arr_condition',$arr);
		//$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('add_display','none');
		$smarty->assign('page_info',$page->getNavBar($this->_url($_GET['action'],$arr)).$note);
		$smarty->display('TableList.tpl');
	}

	//审核
	function actionCheck(){
		$this->authCheck();
		$sql="update caiwu_xianjin set isShenhe='{$_GET['isShenhe']}' where id='{$_GET['id']}'";
		$this->_modelExample->execute($sql);
	    js_alert('',"window.parent.parent.showMsg('操作成功')",$this->_url('right'));
	}

	function _edit($Arr) {
		$this->authCheck('8-3-3');
		
		//搭建界面
		$this->fldMain = array(
				'payCode' => array('title' => '流水号', "type" => "text", 'value' => ''),
				//'dakuanfang' => array('title' => '打款方', 'type' => 'text', 'clientName' => ''),
				'comeDate' => array('title' => '来往日期', 'type' => 'calendar', 'value' => '','readonly'=>true),
		
				'itemId' => array('title' => '付款科目', 'type' => 'select', 'value' => '','model'=>'Model_jichu_feiyong'),
				'shoukuanfang' => array('title' => '付款方', 'type' => 'text', 'clientName' => ''),
				'pingzhengCode' => array('title' => '凭证号', "type" => "text", 'value' => ''),	
				'payDate' => array('title' => '付款日期', 'type' => 'calendar', 'value' => '','readonly'=>true),
				'zhifuWay' => array('title' => '打款方式', 'type' => 'select', 'value' => '', 'options' => array(
						array('text' => '现金', 'value' => '现金'),
						array('text' => '支票', 'value' => '支票'),
						array('text' => '电汇', 'value' => '电汇'),
						array('text' => '承兑', 'value' => '承兑'),
						array('text' => '其它', 'value' => '其它'),
				)),
				'bankId' => array('title' => '银行帐户', 'type' => 'select', 'value' => '1','model'=>'Model_caiwu_bank'),
				'money' => array('title' => '金额', 'type' => 'text', 'value' => ''),
				'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
				'id' => array('type' => 'hidden', 'value' => ''),
		);
		$this->rules = array(
				'itemId' =>'required',
				'shoukuanfang' =>'required',
				'money' =>'required'
		);
		
		$this->fldMain = $this->getValueFromRow($this->fldMain,$Arr);

		$smarty = & $this->_getView();
		$smarty->assign('title', "费用登记");
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->display('Main/A1.tpl');
	}

	function actionAdd() {
		// $this->authCheck('3-1-3');
		$arr = array(
			'payCode'=>$this->getNextNum(),
			'comeDate'=>date('Y-m-d'),
			'payDate'=>date('Y-m-d'),
			);
		// dump($arr);exit;
		$this->_edit($arr);
	}

	function actionSave() {
//		dump($_SESSION);EXIT;
		$_POST['creater'] = $_SESSION['USERID'];
		$sql = "select * from jichu_feiyong where id='{$_POST['itemId']}'";
		$_r = $this->_modelExample->findBySql($sql);
		$_POST['itemName'] = $_r[0]['feiyongName'];
		//dump($_POST);exit;
		$id = $this->_modelExample->save($_POST);
		js_alert(null, "window.parent.showMsg('保存成功!')",$this->_url($_POST['fromAction']?$_POST['fromAction']:'add'));
	}

	function actionEdit() {
		// $this->authCheck('3-1-4-2');
		$aRow=$this->_modelExample->find($_GET[id]);
		$this->_edit($aRow);
	}

	//取得最大的凭证编号
	function getNextNum(){
		$arr=$this->_modelExample->find(null,'payCode desc');
		$maxNum = $arr['payCode'];
		$temp = date("ym")."001";
		if ($temp>$maxNum) return $temp;
		$a = substr($maxNum,-3)+1001;
		return substr($maxNum,0,-3).substr($a,1);
	}
    function actionRemove(){
		$this->authCheck();
		parent::actionRemove();
	}

}
?>