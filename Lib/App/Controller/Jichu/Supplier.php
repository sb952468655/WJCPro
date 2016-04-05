<?php
FLEA::loadClass('Controller_Jichu_Jiagonghu');
class Controller_Jichu_Supplier extends Controller_Jichu_Jiagonghu {
	var $_modelExample;
	var $title = "供应商资料";
	var $funcId = 26;
	var $_tplEdit='Jichu/SupplierEdit.tpl';
	function Controller_Jichu_Supplier() {
		//if(!//$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
        // $this->_modelTaitou = & FLEA::getSingleton('Model_Jichu_SupplierTaitou');

        $this->fldMain = array(
        	'id'=>array('title'=>'','type'=>'hidden','value'=>''),
        	'compCode'=>array('title'=>'供应商编号','type'=>'text','value'=>$this->_autoCode('','01','jichu_jiagonghu','compCode')),
        	'compName'=>array('title'=>'供应商名称','type'=>'text','value'=>''),
        	'gongxuId'=>array('title'=>'供应商类型','type'=>'hidden','value'=>'0'),
        	'fuzeren'=>array('title'=>'联系人','type'=>'text','value'=>''),
        	'isStop'=>array('title'=>'停止往来','type'=>'select','value'=>'','options'=>array(
        			array('text'=>'否','value'=>0),
        			array('text'=>'是','value'=>1)
        		)),
        	'address'=>array('title'=>'地址','type'=>'text','value'=>''),
        	'tel'=>array('title'=>'电话','type'=>'text','value'=>''),
        	'memo'=>array('title'=>'备注','type'=>'textarea','value'=>''),
        	'isSupplier'=>array('title'=>'','type'=>'hidden','value'=>'1'),
        );

        $this->rules = array(
			'compCode'=>'required repeat',
			'compName'=>'required repeat'
		);
	}

	function actionRight() {
    	$title = '加工户档案';
		///////////////////////////////模板文件
		$tpl = 'TableList.tpl';

		// $hasZhizao = & FLEA::getAppInf('hasZhizao');
		
		$arr_field_info = array(
			'_edit'=>'操作',
			"compCode" =>array('text'=>"编码",'align'=>'left'),
			"compName" =>"名称",
			// "jghCode"=>'简称',
			'fuzeren'=>'联系人',
			"tel" =>"电话",
			"addr" =>"地址",
			'memo'=>'备注'
		);
		
		///////////////////////////////模块定义
		$this->authCheck('6-2');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'key'=>''
		));
		$sql="select * from jichu_jiagonghu where isSupplier=1";
		// $condition[]=array('isSupplier',1,'=');
		if($arr['key']!='') {
			$sql.=" and compName like '%{$arr['key']}%'";
			// $condition[] = array('compCode',"%{$arr['key']}%",'like','or');
			// $condition[] = array('compName',"%{$arr['key']}%",'like');
		}
		
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		if(count($rowset)>0) foreach($rowset as & $v) {
			//$this->makeEditable($v,'memoCode');
				$v['_edit'] = $this->getEditHtml($v['id']) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
				if($v['isStop']==1)$v['_bgColor']="#cce8f8";
			}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr))."<font color='blue'>蓝色表示停止往来</font>");
		$smarty->display($tpl);
    }

    function actionSave() {
		if(empty($_POST['id'])) {
			$sql = "SELECT count(*) as cnt FROM `jichu_jiagonghu` where compCode='".$_POST['compCode']."' or compName='".$_POST['compName']."'";
			$rr = $this->_modelExample->findBySql($sql);
			//dump($rr);exit;
			if($rr[0]['cnt']>0) {
				js_alert('加工户名称或加工户代码重复!',null,$this->_url('add'));
			}
		} else {
		//修改时判断是否重复
			$str1="SELECT count(*) as cnt FROM `jichu_jiagonghu` where id!=".$_POST['id']." and (compCode='".$_POST['compCode']."' or compName='".$_POST['compName']."')";
			$ret=$this->_modelExample->findBySql($str1);
			if($ret[0]['cnt']>0) {
				js_alert('加工户名称或加工户代码重复!',null,$this->_url('Edit',array('id'=>$_POST['id'])));
			}
		}
		
		// parent::actionSave();
		//首字母自动获取
		FLEA::loadClass('TMIS_Common');
		$letters=strtoupper(TMIS_Common::getPinyin($_POST['compName']));
		$_POST['letters']=$letters;
		// dump($_POST);exit;
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
	    $smarty->assign('title','供应商信息编辑');
	    $smarty->assign('aRow',$row);
	    $smarty->display('Main/A1.tpl');
	}

	function actionAdd($Arr){
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('title','供应商信息编辑');
	    $smarty->assign('rules',$this->rules);
	    $smarty->display('Main/A1.tpl');
	}

	function actionRemove() {
		//如果已使用该加工户，禁止删除
    	if($_GET['id']>0){
	        $url=$this->_url($_GET['fromAction']==''?'right':$_GET['fromAction']);
	        //判断是否生产计划中中使用了该产品
	        $str="select count(*) as cnt from pisha_plan_son where supplierId='{$_GET['id']}'";
	        $temp=$this->_modelExample->findBySql($str);
	        if($temp[0]['cnt']>0){
	            js_alert('采购计划中已设置该供应商，禁止删除','',$url);
	        }

	        //判断是否入库界面已使用该加工户
	        $str="select count(*) as cnt from cangku_ruku_son where supplierId='{$_GET['id']}'";
	        $temp=$this->_modelExample->findBySql($str);
	        if($temp[0]['cnt']>0){
	            js_alert('仓库入库已使用该供应商，禁止删除','',$url);
	        }
     	}
		parent::actionRemove();
	}
}
?>