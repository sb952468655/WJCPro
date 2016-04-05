<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Jiagonghu extends Tmis_Controller {
	var $_modelExample;
	var $title = "加工户资料";
	var $funcId = 26;
	var $_tplEdit='Jichu/JiagonghuEdit.tpl';
	function Controller_Jichu_Jiagonghu() {
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$this->_modelGongxu = & FLEA::getSingleton('Model_Jichu_Gongxu');
		$this->fldMain = array(
        	'id'=>array('title'=>'','type'=>'hidden','value'=>''),
        	'compCode'=>array('title'=>'加工户编号','type'=>'text','value'=>$this->_autoCode('','02','jichu_jiagonghu','compCode')),
        	'kind'=>array('title'=>'加工户分类','type'=>'combobox','value'=>'','options'=>'','autoOption'=>true),
        	'compName'=>array('title'=>'加工户名称','type'=>'text','value'=>''),
        	//'gongxuId'=>array('title'=>'加工户类型','type'=>'select','value'=>'','options'=>$this->_modelGongxu->getOptions()),
        	'fuzeren'=>array('title'=>'联系人','type'=>'text','value'=>''),
        	'isStop'=>array('title'=>'停止往来','type'=>'select','value'=>'','options'=>array(
        			array('text'=>'否','value'=>0),
        			array('text'=>'是','value'=>1)
        		)),
        	'feeBase'=>array('title'=>'加工费依据','type'=>'select','value'=>'','options'=>array(
        			array('text'=>'按发外计算','value'=>'0'),
        			array('text'=>'按产量计算','value'=>'1')
        		)),
        	'address'=>array('title'=>'地址','type'=>'text','value'=>''),
        	'tel'=>array('title'=>'电话','type'=>'text','value'=>''),
        	'isSelf'=>array('title'=>'是否本厂','type'=>'radio','value'=>'0','radios'=>array(
        			array('title'=>'否','value'=>0),
        			array('title'=>'是','value'=>1)
        	)),
        	'memo'=>array('title'=>'备注','type'=>'textarea','value'=>''),
        );

        $this->rules = array(
			'compCode'=>'required repeat',
			'compName'=>'required repeat',
			'kind'=>'required'
		);
	}

	function actionRight() {
	//dump($_GET['kind']);exit;
		$title = '加工户档案';
		///////////////////////////////模板文件
		$tpl = 'TableList.tpl';

		$hasZhizao = & FLEA::getAppInf('hasZhizao');
		//dump($hasZhizao);
		///////////////////////////////表头
		$arr_field_info = array(
			'_edit'=>'操作',
			"compCode" =>array('text'=>"编码",'align'=>'left'),
			"kind" =>"分类",
			"compName" =>"名称",
			// "Gongxu.itemName"=>'加工户类型',
			'fuzeren'=>'联系人',
			"tel" =>"电话",
			"addr" =>"地址",
			'memo'=>'备注'
		);
		
		///////////////////////////////模块定义
		$this->authCheck('6-4');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'key'=>''
		));
		$sql="select * from jichu_jiagonghu where isSupplier=0";
		// $condition[]=array('isSupplier',1,'=');
		if($arr['key']!='') {
			$sql.=" and compName like '%{$arr['key']}%'";
			// $condition[] = array('compCode',"%{$arr['key']}%",'like','or');
			// $condition[] = array('compName',"%{$arr['key']}%",'like');
		}
		
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		// dump($rowset);exit;
		if(count($rowset)>0) foreach($rowset as & $v) {
			///////////////////////////////
			//$this->makeEditable($v,'memoCode');
				$v['_edit'] = $this->getEditHtml($v['id']) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
				if($v['isStop']==1)$v['_bgColor']="#cce8f8";
			}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		//$smarty->assign('hasZhizao',$hasZhizao);
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
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
		
		//首字母自动获取
		FLEA::loadClass('TMIS_Common');
		$letters=strtoupper(TMIS_Common::getPinyin($_POST['compName']));
		$_POST['letters']=$letters;
		// parent::actionSave();
		//dump($_POST);exit;
		$id = $this->_modelExample->save($_POST);
		// if($_POST['Submit']=='保 存')
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url($_POST['fromAction']==''?'add':$_POST['fromAction']));
		// else
			// js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url('add'));
	}

	function actionRemove() {
		//如果已使用该加工户，禁止删除
    	if($_GET['id']>0){
	        $url=$this->_url($_GET['fromAction']==''?'right':$_GET['fromAction']);
	        //判断是否生产计划中中使用了该产品
	        $str="select count(*) as cnt from shengchan_plan2product_gongxu where jiagonghuId='{$_GET['id']}'";
	        $temp=$this->_modelExample->findBySql($str);
	        if($temp[0]['cnt']>0){
	            js_alert('生产计划中已设置该加工户，禁止删除','',$url);
	        }

	        //判断是否入库界面已使用该加工户
	        $str="select count(*) as cnt from cangku_ruku where jiagonghuId='{$_GET['id']}'";
	        $temp=$this->_modelExample->findBySql($str);
	        if($temp[0]['cnt']>0){
	            js_alert('仓库验收入库已使用该加工户，禁止删除','',$url);
	        }

	        //判断是否出库界面已使用该加工户
	        $str="select count(*) as cnt from cangku_chuku where jiagonghuId='{$_GET['id']}'";
	        $temp=$this->_modelExample->findBySql($str);
	        if($temp[0]['cnt']>0){
	            js_alert('仓库出库已使用该加工户，禁止删除','',$url);
	        }
     	}
		parent::actionRemove();
	}

	function actionEdit(){
		//填充options
		$this->_getOptions();
		//查找对应的信息
		$row = $this->_modelExample->find(array('id'=>$_GET['id']));
	    $this->fldMain = $this->getValueFromRow($this->fldMain,$row);
	    // dump($row);dump($this->fldMain);exit;
	    $smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('rules',$this->rules);
	    $smarty->assign('title','加工户信息编辑');
	    $smarty->assign('aRow',$row);
	    $smarty->display('Main/A1.tpl');
	}

	function actionAdd($Arr){
		//填充options
		$this->_getOptions();

		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$this->fldMain);
	    $smarty->assign('title','加工户信息编辑');
	    $smarty->assign('rules',$this->rules);
	    $smarty->display('Main/A1.tpl');
	}

	/**
	 * 自动填充需要options的选项,修改 $this->fldMain 的值
	 * Time：2014/07/11 14:01:07
	 * @author li
	*/
	function _getOptions(){
		$kind=array();
		foreach($this->fldMain as $key => & $main){
			if(!$main['autoOption'])continue;
			//查找数据
			$sql="select distinct {$key} from jichu_jiagonghu where 1 order by {$key}";
			$temp = $this->_modelExample->findBySql($sql);

			//处理选项
			foreach($temp as & $v){
				$kind[]=array(
					'text'=>$v['kind'],
					'value'=>$v['kind'],
				);
			}
			//赋给选项
			$main['options']=$kind;
		}
	}
}
?>