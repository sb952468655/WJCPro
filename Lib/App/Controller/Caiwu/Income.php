<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Caiwu_Income extends Tmis_Controller {
	var $_modelExample;
	var $title = "收款登记";
	var $funcId = 33;
	function Controller_Caiwu_Income() {
		$this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Income');
//		$this->_modelChuku = & FLEA::getSingleton('Model_Cangku_Chuku');
//		$this->_modelChuku2product = & FLEA::getSingleton('Model_Cangku_ChukuProduct');
//		$this->_modelClient= & FLEA::getSingleton('Model_Jichu_Client');
//		$this->_modelGuozhang = & FLEA::getSingleton('Model_Caiwu_Ar_Guozhang');
	}

	function actionRight()	{
		$this->authCheck('8-3-2');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date("Y-m-01"),
			'dateTo'=>date("Y-m-d"),
			'isShenhe'=>0,
			'incomeCode'=>'',
			'dakuanfang'=>'',
			'key'=>'',
			'bankId'=>''
			//'clientId'=>''
		));
		if($arr['dateFrom']!='') $condition[]=array('incomeDate',$arr['dateFrom'],'>=');
	    if($arr['dateTo']!='') $condition[]=array('incomeDate',$arr['dateTo'],'<=');
	    if($arr['isShenhe']!=2) {
	    	$condition[]=array('isShenhe',$arr['isShenhe'],'=');
		}
		if($arr['bankId']!='') {
	    	$condition[]=array('bankId',$arr['bankId'],'=');
		}
		if($arr['incomeCode']!='') {
	    	$condition[] = array('incomeCode',"%{$arr['incomeCode']}%",'like');
	   }
	   if($arr['key']!='') {
	    	$condition[] = array('zhifuWay',"%{$arr['key']}%",'like');
	   }
	   if($arr['dakuanfang']!='') {
	    	$condition[] = array('dakuanfang',"%{$arr['dakuanfang']}%",'like');
	   }
		//if ($arr['clientId'] != '') $condition[] = array('clientId', $arr['clientId']);
		$pager =& new TMIS_Pager($this->_modelExample,$condition,null,200);
		$rowset =$pager->findAll();
		//dump($rowset); exit;
//		for ($i=0;$i<count($rowset);$i++) {
//			$rowset[$i]['incomeWay'] = $this->_modelExample->getTypeDesc($rowset[$i]['incomeWay']);
////			$rowset[$i]['clientName'] = $rowset[$i]['Client']['compName'];
////			$rowset[$i]['accountName'] = $rowset[$i]['Account']['accountName'];
//			$rowset[$i]['bankName'] = $rowset[$i]['Bank']['itemName'];
////			$tMoney += $rowset[$i]['money'];
//		}
		foreach($rowset as & $v) {
			//$v['incomeWay'] =$this->_modelExample->getTypeDesc($rowset[$i]['incomeWay']);
			$v['bankName'] = $v['Bank']['itemName'];
			if($v['isShenhe']==1){
				$v['_edit']="<span ext:qtip='此信息已审核，禁止操作'>修改&nbsp;&nbsp;删除</span>";
				$v['_edit'].="&nbsp;&nbsp;<a href='".$this->_url('Check', array('isShenhe'=>0,'id'=>$v['id'],'fromAction'=>$_GET['action']))."' >取消审核</a>";
			}else{
				$v['_edit'] = $this->getEditHtml(array(
					'id'=>$v['id'],
					'fromAction'=>'right'
				)) . "&nbsp;&nbsp;" .$this->getRemoveHtml($v['id']);
				$v['_edit'].="&nbsp;&nbsp;<a href='".$this->_url('Check', array('isShenhe'=>1,'id'=>$v['id']))."' >审核</a>";
			}
			
		}

		//合计
		$rowset[] = $this->getHeji($rowset, array('money'),'_edit');
		//$rowset[$i]['moneyIncome'] = $tMoney;

		$pk = $this->_modelExample->primaryKey;
		$arr_field_info = array(
			"_edit"=>"操作",
			"incomeCode" =>"凭证编号",
			"incomeDate" =>"收款日期",
			"zhifuWay" =>"支付方式",
//			"accountName" =>"收款项目名称",
			'dakuanfang' => '打款方',
			'bankName' => "银行帐户",
			"money" => "金额",
			"memo" => "备注",
			
		);

//		#对操作栏进行赋值
//		/*$arr_edit_info = array(
//			"edit" =>"修改",
//			"remove" =>"删除",
//			"jihe"=>"稽核"
//		);*/
//		foreach($rowset as & $v){
//			$con=array(
//					   'incomeId'=>$v[id],
//					   'clientId'=>$v[clientId]
//					   );
//			$chuku=$this->_modelChuku->findAll($con);
//			//dump($chuku);
//			if($chuku){
//				$v['_bgColor']='LightSeaGreen';
//			}
//			if($v['incomeCode']!="合计"){
//				$v['_edit']="<a href='".$this->_url('edit',array('id'=>$v['id']))."'>修改</a>|<a href='".$this->_url('remove',array('id'=>$v['id']))."'>删除</a>";
//			}
//		}
//		$note='<font color=red>背景有颜色的表示已经有稽核记录</font>';
		//dump($rowset);//other_search_item
		$smarty = & $this->_getView();
		$smarty->assign('pk', $pk);
		$smarty->assign('title', $this->title);
		$smarty->assign('arr_edit_info',$arr_edit_info);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$pager->getNavBar($this->_url('right',$arr)));
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty-> display('TableList.tpl');
	}

	//审核
	function actionCheck(){
		$this->authCheck();
		$sql="update caiwu_income set isShenhe='{$_GET['isShenhe']}' where id='{$_GET['id']}'";
		$this->_modelExample->execute($sql);
	    js_alert('',"window.parent.parent.showMsg('操作成功')",$this->_url('right'));
	}

	function _edit($Arr) {
		$this->authCheck('8-3-1');
		//dump($Arr); exit;
		//$this->authCheck($this->funcId);
		//搭建界面
		$this->fldMain = array(
				'incomeCode' => array('title' => '流水号', "type" => "text", 'value' => ''),				
				'dakuanfang' => array('title' => '打款方', 'type' => 'text', 'clientName' => ''),
				'incomeDate' => array('title' => '收款日期', 'type' => 'calendar', 'value' => '','readonly'=>true),
				
				'zhifuWay' => array('title' => '打款方式', 'type' => 'select', 'value' => '', 'options' => array(
					array('text' => '现金', 'value' => '现金'),
					array('text' => '支票', 'value' => '支票'),
					array('text' => '电汇', 'value' => '电汇'),
					array('text' => '承兑', 'value' => '承兑'),
					array('text' => '其它', 'value' => '其它'),
					)),
				'money' => array('title' => '金额', 'type' => 'text', 'value' => ''),
				'bankId' => array('title' => '银行帐户', 'type' => 'select', 'value' => '1','model'=>'Model_caiwu_bank'),
				'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
				'id' => array('type' => 'hidden', 'value' => ''),
		);
		$this->rules = array(
				'dakuanfang' => 'required',
				'money' => 'required',
		);
		
		$this->fldMain = $this->getValueFromRow($this->fldMain,$Arr);

		$smarty = & $this->_getView();
		$smarty->assign('title','收款登记编辑');
		$smarty->assign("aRow",$Arr);
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->display('Main/A1.tpl');
	}

	// 保存
	function actionSave() {
		//dump($_POST); EXIT;
		$_POST['creater']=$_SESSION['USERID'];
		$id = $this->_modelExample->save($_POST);
		js_alert(null, "window.parent.showMsg('保存成功!')",$this->_url($_POST['fromAction']?$_POST['fromAction']:'add'));
	}

	function actionAdd() {
		// $this->authCheck('3-1-1');
		$arr = array(
			'incomeCode'=>$this->getNextNum(),
			'incomeDate'=>date('Y-m-d')
			);
		// dump($arr);exit;
		$this->_edit($arr);
	}

	//取得最大的凭证编号
	function getNextNum(){
		$arr=$this->_modelExample->find(null,'incomeCode desc');
		$maxNum = $arr['incomeCode'];
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