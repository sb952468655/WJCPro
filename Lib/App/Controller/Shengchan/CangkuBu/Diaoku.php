<?php
FLEA::loadClass('Controller_Shengchan_Chuku');
class Controller_Shengchan_Cangku_Diaoku extends Controller_Shengchan_Chuku {
	
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '纱仓库';
		$this->_kind="调拨出库";
		//出库主信息
		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('SKDB','cangku_chuku','chukuCode')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
			'chukuDate' => array('title' =>'调拨日期', 'type' =>'calendar','value' => date('Y-m-d')),
			'kuweiIdfrom' => array('title' =>'调出方','type' =>'select','model' =>'Model_Jichu_Kuwei','emptyText'=>'选择库位'),
			'kuweiIdTo' => array('title' =>'调入方', 'type' =>'select','model' =>'Model_Jichu_Kuwei','emptyText'=>'选择库位'),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			'isGuozhang' => array('type' => 'hidden', 'value' => '1'),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
		);
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			// 'plan2proId' => array('title' => '生产计划', "type" => "btPopup", 'value'=>'', 'name' => 'plan2proId[]','url'=>url('Shengchan_Plan','popup'),'textFld'=>'planCode','hiddenFld'=>'id','inTable'=>true,'text'=>''),
			'supplierId' => array('title' => '供应商', 'type' => 'btselect', 'model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1','inTable'=>true,'name'=>'supplierId[]'),
			'productId' => array('type' => 'btproductpopup', "title" => '产品选择', 'name' => 'productId[]'),
			// 'zhonglei'=>array('type'=>'bttext',"title"=>'成分','name'=>'zhonglei[]','readonly'=>true),
			'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]','readonly'=>true),
			'pihao'=>array('type'=>'bttext',"title"=>'批号','name'=>'pihao[]'),
			'cnt' => array('type' => 'bttext', "title" => '一等品(Kg)', 'name' => 'cnt[]'),
			'cntCi' => array('type' => 'bttext', "title" => '次品(Kg)', 'name' => 'cntCi[]'),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			// 'diaoboId' => array('type' => 'bthidden', 'name' => 'diaoboId[]')
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'kuweiIdfrom' => 'required',
			'kuweiIdTo'=>'required'
		);

		//编辑界面的权限id
		$this->_addCheck = '3-17';
		$this->_rightCheck = '3-18';
	}

	/**
	 * ps ：查询方法，定义需要显示的列信息，调用父类right方法
	 * Time：2014/06/12 10:57:18
	 * @author li
	*/
	function actionRight(){
		$this->_fieldMain = array(
			"_edit" => array('text'=>'操作','width'=>170),
			'kind'=>'类型',
			'Kuwei.kuweiName'=>'库位',
			"chukuDate" => "发生日期",
			'chukuCode' => array('text'=>'出库单号','width'=>140),
			'cnt'=>'一等品(Kg)',
			'cntCi'=>'次品(Kg)',
			"memo" => array('text'=>'备注','width'=>200), 
		);

		parent::actionRight();
	}

	/**
	 * ps ：处理搜索项
	 * Time：2014/06/13 09:19:38
	 * @author li
	 * @param Array
	 * @return Array
	*/
	function _beforeSearch(& $arr){
		unset($arr['jiagonghuId']);
	}
	

	/**
	* 调拨保存方法
	* 保存两条数据，一条为调出数据，一条为调入数据
	* 相当于调库操作
	*/
	function actionSave(){
		// dump($_POST);exit;
		if($_POST['kuweiIdfrom'] == $_POST['kuweiIdTo']){
			js_alert('调入方与调出方不能相同，请确认!','window.history.go(-1)');
			exit;
		}
		//开始保存
		$pros = array();
		foreach($_POST['productId'] as $key=>&$v) {
			if($v=='') continue;
			$temp = array();
			foreach($this->headSon as $k=>&$vv) {
				$temp[$k] = $_POST[$k][$key];
			}
			$pros[]=$temp;
		}
		if(count($pros)==0) {
			js_alert('请选择有效的产品明细信息!','window.history.go(-1)');
			exit;
		}
		$row = array();
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$row[$k] = $_POST[$name];
		}

		$row['Products'] = $pros;
		
		//调入数据
		$row['kuweiId']=$row['kuweiIdfrom']+0;
		
		// dump($row);exit;
		$id=$this->_modelExample->save($row);
		if(!$id) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}else{
			////////////////////////////保存调入的信息///////////////////////////////////////////////
			//获取调出的信息，用于生成调入的信息
			$dbId = $_POST['chukuId']>0?$_POST['chukuId']:$id;
			$info = $this->_modelExample->find(array('id'=>$dbId));
			// unset($info['Jgh']);
			// dump($info);exit;

			//查找是否存在调入的信息
			$temp=$this->_modelExample->find(array('dbId'=>$info['id']));

			//如果存在则需要先删除原来的子表信息，重新插入
			if($temp['id']>0){
				//删除原来的调入子表信息，重新插入
				$this->_subModel->removeByPkvs(array_col_values($temp['Products'],'id'));
			}

			//组织调出的信息，用于插入调入信息
			$row_in=$info;
			//处理主表信息
			$row_in['kuweiId']=$_POST['kuweiIdTo']+0;
			$row_in['dbId']=$dbId;
			$row_in['id']='';
			$row_in['id']=$temp['id'];
			$row_in['chukuCode'] .= '调';
			//加工户信息应该为负数记录
			foreach($row_in['Products'] as & $v){
				$v['cnt']=$v['cnt']*-1;
				$v['cntCi']=$v['cntCi']*-1;
				//处理关联的调拨id
				$v['diaoboId']=$v['id'];
				$v['id']='';
				$v['memoView'].="调入数据";
			}
			// dump($row_in);exit;
			$this->_modelExample->save($row_in);

		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	/**
	* 删除：需要同时删除两条数据，因为调拨会产生两条数据，所以需要同步进行
	*/
	function actionRemove(){
		//查找需要删除的信息
		$dbInfo = $this->_modelExample->find($_GET['id']);
		// dump($dbInfo);exit;
		$id1=$_GET['id'];
		$id2=0;
		//查找对应的另外一条数据
		if($dbInfo['dbId']>0){
			$id2=$dbInfo['dbId'];
		}else{
			$temp = $this->_modelExample->find(array('dbId'=>$_GET['id']));
			$id2=$temp['id'];
			// dump($temp);exit;
		}
		//开始删除
		
		$this->_modelExample->removeByPkv($id1);
		$this->_modelExample->removeByPkv($id2);

		$from = $_GET['fromAction']?$_GET['fromAction']:'right';
		js_alert(null,"window.parent.showMsg('成功删除')",$this->_url($from));
	}

	/**
	*通过ajax删除子表信息
	*/
	function actionRemoveByAjax(){
		$id=$_REQUEST['id'];
		$m = $this->_subModel;
		$sec = $m ->find(array('diaoboId'=>$id));
		if($m->removeByPkv($id)) {
			$m->removeByPkv($sec['id']);
			echo json_encode(array('success'=>true));
			exit;
		}
	}
	/**
	* 修改
	*/
	function actionEdit(){
		$this->authCheck($this->_addCheck);
		//查找调出的那一条信息作为主要的信息显示，调入的那条信息按照调出的信息保存
		//查找对应的调出信息
		$dbInfo = $this->_modelExample->find(array('id' => $_GET['id']));
		if($dbInfo['dbId']>0){
			$arr=$this->_modelExample->find(array('id' => $dbInfo['dbId']));
			$kuweiTo=$dbInfo['kuweiId'];
		}else{
			$arr=$dbInfo;
			$db=$this->_modelExample->find(array('dbId' => $dbInfo['id']));
			$kuweiTo=$db['kuweiId'];
		}
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}
		$this->fldMain['kuweiIdfrom']['value']=$arr['kuweiId'];
		$this->fldMain['kuweiIdTo']['value']=$kuweiTo;
		// //加载库位信息的值
		$areaMain = array('title' => '调拨出库基本信息', 'fld' => $this->fldMain);

		// 入库明细处理
		$rowsSon = array();
		foreach($arr['Products'] as &$v) {
			//产品信息
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			$v['color'] = $_temp[0]['color'];

		}
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}
		
		//补齐5行
		$cnt = count($rowsSon);
		for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}
		// dump($rowsSon);exit;

		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', $this->sonTpl);
		$smarty->display('Main2Son/T1.tpl');
	}

	/**
	 * 打印
	 */
	function actionPrint() {
		$m = & $this->_subModel;
		$rowset = $m->find($_GET['id']); 
		$row = $this->_modelExample->find(array('id'=>$_GET['id']));
		if($row['isCheck']==0){
			echo "未审核，不能打印";exit;
		}
		//判断调入，调出信息
		$dbInfo = $row;
		if($dbInfo['dbId']>0){
			$arr=$this->_modelExample->find(array('id' => $dbInfo['dbId']));
			$kuweiTo=$dbInfo['Kuwei']['kuweiName'];
		}else{
			$arr=$dbInfo;
			$db=$this->_modelExample->find(array('dbId' => $dbInfo['id']));
			$kuweiTo=$db['Kuwei']['kuweiName'];
		}
		$kuweifrom=$arr['Kuwei']['kuweiName'];
		// dump($row);exit;
		foreach($row['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			// dump($v);dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			$v['color'] = $_temp[0]['color'];

			$v['cnt']=abs($v['cnt']);
			$v['cntCi']=abs($v['cntCi']);
			
			//供应商信息
			if($v['supplierId']){
				$sql="select compName from jichu_jiagonghu where id='{$v['supplierId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$v['compName']=$temp[0]['compName'];
			}
		} 
		$row['Products'][] = $this->getHeji($row['Products'],array('cnt','cntCi','money'),'compName') ;
		//补齐5行
		$cnt = count($row['Products']);
		for($i=5;$i>$cnt;$i--) {
			$row['Products'][] = array();
		}
		// dump($row);exit;
		$main = array(
			'出库单号'=>$row['chukuCode'],
			'调出方'=>$kuweifrom,
			'调入方'=>$kuweiTo,
			'调拨日期'=>$row['chukuDate'],
		);
		$smarty = &$this->_getView();
		$smarty->assign("title", $this->_kind.'单');
		$smarty->assign("arr_main_value", $main);
		$smarty->assign("arr_field_info", array(
			'compName'=>'供应商',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'pihao'=>'批号',
			'cnt' => '一等品(Kg)',
			'cntCi' => '次品(Kg)', 
			'memoView' => '备注'
		));
		/**
		* 打印界面加载公章信息
		*/
		// if($row['isCheck']==1){
		// 	$smarty->assign("gongzhang", '1');
		// }
		$smarty->assign("arr_field_value", $row['Products']);
		$smarty->display('Print.tpl');
	}
}
?>