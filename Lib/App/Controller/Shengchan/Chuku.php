<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_Chuku extends Tmis_Controller {
	var $fldMain;
	var $headSon;
	var $rules; //表单元素的验证规则
	var $_subModel;
	var $_kind='';
	var $_modelExample;
	var $_rightCheck='';//查询界面的权限
	var $_addCheck='';//编辑界面的权限

	// /构造函数
	function __construct() {
		$this->_modelExample = &FLEA::getSingleton('Model_Shengchan_Cangku_Chuku');
		$this->_subModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Chuku2Product');

		//出库主信息
		$this->fldMain = array();
		//子信息
		$this->headSon = array();
		// 表单元素的验证规则定义
		$this->rules = array();

		$this->sonTpl = array(
			'Trade/ColorAuutoCompleteJs.tpl',
			"Shengchan/Cangku/ChukuEditCommon.tpl"
		);
	}

	/**
	 * ps ：处理搜索项
	 * Time：2014/06/13 09:19:38
	 * @author li
	 * @param Array
	 * @return Array
	*/
	// function _beforeSearch(& $arr){
	// 	return true;
	// }

	/**
	 * 等级信息，通过方法获取
	 * Time：2014/06/24 10:35:16
	 * @author li
	 * @return array 返回值类型
	*/
	function setDengji(){
		return array(
			array("text"=>'一等品',"value"=>'一等品'),
			array("text"=>'二等品',"value"=>'二等品'),
			array("text"=>'等外品',"value"=>'等外品'),
		);
	}

	/**
	* 查询
	*/
	function actionRight(){
		//权限判断
		$this->authCheck($this->_rightCheck);
		$ishaveCheck = $this->authCheck('3-100-1',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'isCheck'=>2,
			'kuweiId'=>'',
			'jiagonghuId'=>'',
			'supplierId'=>'',
			'commonCode' => '',
		));
		//搜索前处理搜索项
		// $this->_beforeSearch($arr);//exit;

		$condition=array();
		$condition[]=array('kind',$this->_kind,'=');
		$condition[]=array('type',$this->_type,'=');
		if($arr['commonCode']!='')$condition[]=array('chukuCode',"%{$arr['commonCode']}%",'like');
		if($arr['supplierId']!='')$condition[]=array('Products.supplierId',$arr['supplierId'],'=');
		if($arr['jiagonghuId']!='')$condition[]=array('jiagonghuId',$arr['jiagonghuId'],'=');
		if($arr['kuweiId']!='')$condition[]=array('kuweiId',$arr['kuweiId'],'=');
		if($arr['isCheck']<2)$condition[]=array('isCheck',$arr['isCheck'],'=');
		//查找计划
		$pager = &new TMIS_Pager($this->_modelExample,$condition,'id desc');
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);
			//删除操作
			$v['_edit'] .= '&nbsp;' .$this->getRemoveHtml($v['id']);
			//打印
			if($v['isCheck']==1){
				$v['_edit'] = "<span title='已审核，禁止操作'>修改  删除</span>";
				$v['_edit'].="&nbsp;<a href='".$this->_url('print',array(
					'id'=>$v['id']
					))."' target='_blank'>打印</a>";
			}else{
				$v['_edit'].="&nbsp;<span ext:qtip='未审核，不能打印'>打印</span>";
			}
			//审核，有权限的才显示
			if($ishaveCheck){
				$msg='';
				$isCheck=0;
				if($v['isCheck']==0){
					$isCheck=1;
					$msg='';
				}else{
					$isCheck=0;
					$msg='取消';
				}
				$v['_edit'].="&nbsp;<a href='".$this->_url('shenhe',array(
					'id'=>$v['id'],
					'isCheck'=>$isCheck,
					))."'>{$msg}审核</a>";
			}
			//显示明细数据
			foreach($v['Products'] as & $vv){
				//查找产品明细信息
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$vv['proCode']=$temp[0]['proCode'];
				$vv['pinzhong']=$temp[0]['pinzhong'];
				$vv['proName']=$temp[0]['proName'];
				$vv['zhonglei']=$temp[0]['zhonglei'];
				$vv['guige']=$temp[0]['guige'];
				// $vv['color']=$temp[0]['color'];

				//查找供应商信息
				if($vv['supplierId']){
					$sql="select compName from jichu_jiagonghu where id='{$vv['supplierId']}'";
					$temp=$this->_subModel->findBySql($sql);
					$vv['compName']=$temp[0]['compName'];
				}

				//计算合计，显示在上面的信息中
				$v['cnt']+=$vv['cnt'];
			}
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo =$this->_fieldMain ? $this->_fieldMain : array(
			"_edit" => array('text'=>'操作','width'=>170),
			'kind'=>'类型',
			'Kuwei.kuweiName'=>'仓库',
			'Jgh.compName'=>'加工户',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			'Department.depName'=>array('text'=>'部门名称','width'=>80),
			'peolingliao'=>array('text'=>'领料人','width'=>70),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=$this->_fieldSon ? $this->_fieldSon : array(
			// "_edit" => '操作',
			"compName" => '供应商', 
			"proCode" => '产品编号', 
			// "zhonglei" => '成分', 
			"proName" => '纱支', 
			"guige" => '规格', 
			"color" => '颜色',
			"pihao" => '批号', 
			'dengji'=>'等级',
			'cnt'=>'数量(Kg)',
			'memoView'=>'备注',
		);

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_info2', $arrField);
		$smarty->assign('sub_field', 'Products');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblListMore.tpl');
	}

	/**
	* add方法，
	*/
	function actionAdd(){
		// dump($this->_addCheck);exit;
		$this->authCheck($this->_addCheck);
		// 从表信息字段,默认5行
		while (count($rowsSon) < 5) {
			$rowsSon[]=array(
				'dengji'=>array('value'=>'一等品')
			);
		}
		$smarty = &$this->_getView();
		$areaMain = array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain);
		$smarty->assign('areaMain', $areaMain);		
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']==''?'add':$_GET['fromAction']);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl', $this->sonTpl);
		$this->_beforeDisplayAdd($smarty);
		$smarty->display('Main2Son/T1.tpl');
	}

	/**
	* edit方法，
	*/
	function actionEdit(){
		$this->authCheck($this->_addCheck);
		$arr = $this->_modelExample->find(array('id' => $_GET['id']));
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}

		//仓库信息
		if($arr['kuweiId']>0){
			$sql="select kuweiName from jichu_kuwei where id='{$arr['kuweiId']}'";
			$temp=$this->_subModel->findBySql($sql);
			$this->fldMain['kuweiId'] && $this->fldMain['kuweiId']['text']=$temp[0]['kuweiName'];
		}

		// //加载库位信息的值
		$areaMain = array('title' => $this->_kind.'基本信息', 'fld' => $this->fldMain);

		// 入库明细处理
		$rowsSon = array();
		foreach($arr['Products'] as &$v) {
			//产品信息
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];

			$v['danjia'] = round($v['danjia'],6);
			$v['money'] = round($v['money'],6);
			$v['cnt'] = round($v['cnt'],6);
		}
		foreach($arr['Products'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}
		//填充计划显示的信息
		foreach ($rowsSon as $key => & $v) {
			//查找产品编号并显示
			$sql="select proCode from jichu_product where id='{$v['productId']['value']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$v['productId']['text']=$_temp[0]['proCode'];
			
			if(!$v['plan2proId']['value'])continue;
			// dump($v);exit;
			$sql="select y.planCode from shengchan_plan2product x 
					left join shengchan_plan y on x.planId=y.id
					where x.id='{$v['plan2proId']['value']}'";
			// echo $sql;exit;
			$_temp = $this->_modelExample->findBySql($sql);
			$v['planTlId'] && $v['planTlId']['text']=$_temp[0]['planCode'];
			$v['planGxId'] && $v['planGxId']['text']=$_temp[0]['planCode'];
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
		$smarty->assign('sonTpl', $this->sonTpl);
		$smarty->assign('rules', $this->rules);
		$this->_beforeDisplayEdit($smarty);
		$smarty->display('Main2Son/T1.tpl');
	}
	
	/**
	 * 数据集传递到修改编辑界面前的处理操作
	 * Time：2014/06/24 17:24:05
	 * @author li
	*/
	function _beforeDisplayEdit(& $smarty){
		return true;
	}

	/**
	 * 数据集传递到修改编辑界面前的处理操作
	 * Time：2014/06/24 17:24:05
	 * @author li
	*/
	function _beforeDisplayAdd(& $smarty){
		return true;
	}

	/**
	* 保存
	*/
	function actionSave(){
		// dump($_POST);exit;
		//有效性验证,没有明细信息禁止保存
		//开始保存
		$pros = array();
		foreach($_POST['productId'] as $key=>&$v) {
			if($v=='' || $_POST['cnt'][$key]=='') continue;
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
		// dump($row);exit;
		if(!$this->_modelExample->save($row)) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	/**
	* 审核功能：在pisha_llck表中修改字段isCheck的状态（0未审核，1已审核）
	*/
	function actionShenhe(){
		$this->authCheck('3-100-1');
		$arr=array(
			'id'=>$_GET['id'],
			'isCheck'=>$_GET['isCheck'],
			'checkPeople'=>$_GET['isCheck']==0 ? '' : $_SESSION['REALNAME'].'',
		);
		
		
		//修改出库表中的记录
		$this->_modelExample->update($arr);
		$temp=mysql_affected_rows();
		//如果审核成功后，则相应的也改变中间表中的记录
		if($temp>0){
			//修改库存表中的记录
			$sql="select group_concat(id) as chukuId from cangku_chuku_son where chukuId='{$_GET['id']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$res =$temp[0];
			// dump($res);exit;
			if($res['chukuId']!=''){
				$sql="update cangku_kucun set isCheck='{$_GET['isCheck']}' where chukuId in ({$res['chukuId']})";
				$this->_modelExample->execute($sql);
			}
			$msg='操作成功';
		}else{
			$msg='操作失败';
		}

		//跳转
		$from = $_GET['fromAction']!=''?$_GET['fromAction']:'right';
		js_alert(null,'window.parent.showMsg("'.$msg.'")',$this->_url($from));
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
		// dump($row);exit;
		foreach($row['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			// dump($v);dump($_temp);exit;
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];

			//计划编号
			if($v['plan2proId']['value']){
				// dump($v);exit;
				$sql="select y.planCode from shengchan_plan2product x 
						left join shengchan_plan y on x.planId=y.id
						where x.id='{$v['plan2proId']}'";
				// echo $sql;exit;
				$_temp = $this->_modelExample->findBySql($sql);
				$v['planCode']=$_temp[0]['planCode'];
			}
			// dump($temp);

			if($v['supplierId']){
				$sql="select compName from jichu_jiagonghu where id='{$v['supplierId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$v['compName']=$temp[0]['compName'];
			}
		} 
		$row['Products'][] = $this->getHeji($row['Products'],array('cnt','cntCi','money'),'planCode') ;
		//补齐5行
		$cnt = count($row['Products']);
		for($i=5;$i>$cnt;$i--) {
			$row['Products'][] = array();
		}
		// dump($row);exit;
		$main = array(
			'出库单号'=>$row['chukuCode'],
			'加工户'=>$row['Jgh']['compName'],
			'日期'=>$row['chukuDate'],
			'领料部门'=>$row['Department']['depName'],
			'领料人'=>$row['peolingliao'],
			'库位'=>$row['Kuwei']['kuweiName'],			
		);
		$filed = array(
			'planCode' => '计划编号',
			'compName'=>'供应商',
			'proCode' => '产品编码',
			'pinzhong' => '品种',
			'proName' => '品名',
			'guige' => '规格',
			'color' => '颜色',
			'pihao'=>'批号',
			'cntJian' => '件数',
			'dengji'=>'等级',
			'cnt' => '数量(Kg)',
			'memoView' => '备注'
		);
		if($this->_type != '布仓库'){
			unset($filed['cntJian']);
			unset($filed['pinzhong']);
		}else{
			unset($filed['proName']);
		}
		$smarty = & $this->_getView();
		$smarty->assign("title", $this->_kind.'单');
		$smarty->assign("arr_main_value", $main);
		$smarty->assign("arr_field_info", $filed);
		/**
		* 打印界面加载公章信息
		*/
		// if($row['isCheck']==1){
		// 	$smarty->assign("gongzhang", '1');
		// }
		$smarty->assign("arr_field_value", $row['Products']);
		$smarty->display('Print.tpl');
	}

	/**
	 * 收发存报表
	 */
	function actionReport($filed) {		
		FLEA::loadClass("TMIS_Pager");
		$_search = $this->_search ? $this->_search : array(
			"dateFrom" => date('Y-m-01'), 
			"dateTo" => date('Y-m-d'),
			'kuweiId'=>'',
			// 'pihao'=>'',
			'color'=>'',
			'key'=>'',
			'from'=>'',
			'sortBy'=>'',
			'sort'=>'',
		);
		$arr = &TMIS_Pager::getParamArray($_search); 
		// $this->_subModel->getSfcSql();
		$this->authCheck();

		//其他搜索信息
		$strCon = " and type='{$this->_type}'";
		
		if($arr['kuweiId']!=''){
			$strCon.=" and kuweiId='{$arr['kuweiId']}'";
		}
		if($arr['supplierId']!=''){
			$strCon.=" and supplierId='{$arr['supplierId']}'";
		}
		if($arr['pihao']!=''){
			$strCon.=" and pihao like '%{$arr['pihao']}%'";
		}
		if($arr['pihao2']!=''){
			$strCon.=" and pihao like '%{$arr['pihao2']}%'";
		}
		if($arr['ganghao']!=''){
			$strCon.=" and ganghao like '%{$arr['ganghao']}%'";
		}
		if($arr['color']!=''){
			$strCon.=" and color like '%{$arr['color']}%'";
		}
		if($arr['key']!=''){
			$sql="select id from jichu_product where pinzhong like '%{$arr['key']}%' or proName like '%{$arr['key']}%' or guige like '%{$arr['key']}%'";
			$res=$this->_subModel->findBySql($sql);
			if(count($res)>0){
				$productIds = join(',',array_col_values($res,'id'));
				if($productIds!='')$strCon.=" and productId in($productIds)";
			}else{
				$strCon.=" and 0";
			}
		}

		$strGroup="kuweiId,productId,pihao,color";
		if($this->strGroup)$strGroup=$this->strGroup;

		$sqlUnion="select {$strGroup},sum(cnt) as cntInit,sum(cntJian) as cntJianInit,0 as cntRuku,0 as cntJianRuku,0 as cntChuku,0 as cntChukuTui,0 as cntJianChuku
		from `cangku_kucun` where dateFasheng<'{$arr['dateFrom']}' 
		 {$strCon} group by {$strGroup} 
		union 
		select {$strGroup},
		0 as cntInit,0 as cntJianInit,sum(cnt) as cntRuku,sum(cntJian) as cntJianRuku,0 as cntChuku,0 as cntChukuTui,0 as cntJianChuku
		from `cangku_kucun` where 
		dateFasheng>='{$arr['dateFrom']}' and dateFasheng<='{$arr['dateTo']}'
		and rukuId>0  {$strCon} group by {$strGroup} 
		union 
		select {$strGroup},
		0 as cntInit,0 as cntJianInit,0 as cntRuku,0 as cntJianRuku,sum(if(cnt<0,cnt*-1,0)) as cntChuku,sum(if(cnt>0,cnt,0)) as cntChukuTui,sum(cntJian*-1) as cntJianChuku
		from `cangku_kucun` where 
		dateFasheng>='{$arr['dateFrom']}' and dateFasheng<='{$arr['dateTo']}'
		and chukuId>0 and isCheck=1 {$strCon} group by {$strGroup}";
		$sql="select 
		{$strGroup},sum(cntInit) as cntInit,sum(cntJianInit) as cntJianInit,sum(cntRuku) as cntRuku,sum(cntJianRuku) as cntJianRuku,sum(cntChuku) as cntChuku,sum(cntChukuTui) as cntChukuTui,sum(cntJianChuku) as cntJianChuku
		from ({$sqlUnion}) as x
		group by {$strGroup}
		having  sum(cntInit)<>0 or sum(cntJianInit)<>0 or sum(cntRuku)<>0 or sum(cntJianRuku)<>0 or sum(cntChuku)<>0 or sum(cntChukuTui)<>0 or sum(cntJianChuku)<>0";

		
		if($arr['sortBy'] !=''){
			$_Sort=$arr['sortBy']=='cntKucun' ? "(sum(cntInit)+sum(cntRuku)-sum(cntChuku)+sum(cntChukuTui))" : $arr['sortBy'];
			$sql.=" order by {$_Sort} {$arr['sort']}";
		}
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		//得到合计信息	
		
		foreach($rowset as &$v) {
			// dump($v);exit;
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['proCode'] = $temp[0]['proCode'];
			$v['pinzhong'] = $temp[0]['pinzhong'];
			// $v['zhonglei'] = $temp[0]['zhonglei'];
			$v['proName'] = $temp[0]['proName'];
			$v['guige'] = $temp[0]['guige'];

			//一等品
			$v['cntKucun'] = round($v['cntInit'] + $v['cntRuku'] - $v['cntChuku'] +  $v['cntChukuTui'], 2);
			$v['cntInit']==0 && $v['cntInit']='';
			$v['cntRuku']==0 && $v['cntRuku']='';
			$v['cntChuku']==0 && $v['cntChuku']='';
			$v['cntChukuTui']==0 && $v['cntChukuTui']='';

			//本期入库和本期出库点击可看到明细
			//查找加工户信息
			$sql="select kuweiName from jichu_kuwei where id='{$v['kuweiId']}'";
			$jgh = $this->_modelExample->findBySql($sql);
			$v['kuweiName']=$jgh[0]['kuweiName'];

			//查找供应商信息
			if($v['supplierId']>0){
				$sql="select compName from jichu_jiagonghu where id='{$v['supplierId']}'";
				$jgh = $this->_modelExample->findBySql($sql);
				$v['compName']=$jgh[0]['compName'];
			}
		} 
		$heji = $this->getHeji($rowset,array('cntInit','cntRuku','cntChuku','cntKucun','cntChukuTui'),'kuweiName');

		//出入库数量形成可弹出明细的链接
		$group_search = explode(',',$strGroup);
		// dump($strGroup);exit;
		foreach($rowset as & $v) {
			$v['cntRuku']=$v['cntRuku']==0?'':round($v['cntRuku'],2);
			$v['cntChuku']=$v['cntChuku']==0?'':round($v['cntChuku'],2);
			//处理明细需要传递的参数
			$_temp=array();
			foreach ($group_search as $key => & $s) {
				$_temp+=array($s=>$v[$s]);
			}
			// dump($_GET);exit;
			$conRk = str_replace( 'Llck', 'Scrk',$_GET['controller']);
			$v['cntRuku'] = "<a href='".url($conRk,'popup',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				)+$_temp+array(
				'type'=>$this->_type,
			))."' target='_blank'>{$v['cntRuku']}</a>";

			$v['cntChuku'] = "<a href='".url($_GET['controller'],'popup',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				)+$_temp+array(
				'type'=>$this->_type,
			))."' target='_blank'>{$v['cntChuku']}</a>";

			//调库
			if($this->_type!=''){
				$v['_edit']="<a href='".url('Shengchan_Tiaoku','add',array(
						'dateTo'=>$arr['dateTo'],
						)+$_temp+array(
						'_type'=>$this->_type,
						'width'=>'750',
						'height'=>500,
						'cntKucun'=>$v['cntKucun'],
						'TB_iframe'=>1
					))."' class='thickbox' title='调整库存'>调库</a>";
			}
		}

		$rowset[] = $heji;

		$filed = $filed ? $filed :array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
		);
		// dump($filed);exit;
		// 显示信息
		$arrFieldInfo = array(
			'kuweiName' => array('text'=>'仓库','width'=>150), 
			)
		+
		$filed
		+
		array(
			// 'dengji'=>array('text'=>'等级','width'=>80), 
			'cntInit' => array('text'=>'期初','width'=>80),
			'cntRuku' => array('text'=>'入库','width'=>80),
			'cntChuku' => array('text'=>'出库','width'=>80),
			'cntChukuTui' => array('text'=>'退回','width'=>80),
			'cntKucun' => array('text'=>'余存','width'=>80,'sort'=>true),
			);

		//调库的权限是否显示
		if($this->authCheck('3-100-2',true)){
			$arrFieldInfo += array(
				'_edit' => '操作', 
			);
		}
		
		$smarty = &$this->_getView();
		$smarty->assign('title', '收发存报表'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}
	

	/**
	 * 收发存报表，区分0库存与非0库存的显示方式
	 */
	function actionPopupReport($filed) {
		$this->authCheck();	
		FLEA::loadClass("TMIS_Pager");
		TMIS_Pager::clearCondition();
		$arrInfo=array_merge(array(
			'isKucun'=>'1',
			'from'=>'',
			'productType'=>'0',
			'productId'=>'',
			'type'=>'',
			'sortBy'=>'',
			'sort'=>'',
		),$filed['search']);
		$arr = &TMIS_Pager::getParamArray($arrInfo);
		// dump($arr);exit;
		//如果显示所有库存，则搜索框需要处理
		if($arr['isKucun']==0){
			unset($arr['kuweiId']);
			unset($arr['pihao']);
			unset($arr['ganghao']);
			unset($arr['color']);
		}

		//其他搜索信息
		//显示库存的情况与显示全部产品的情况
		if($arr['isKucun']==1){
			$strCon = " and type='{$this->_type}'";
			//存在库存的情况，需要查找产品id
			$arr['productId']>0 && $strCon.=" and productId = '{$arr['productId']}'";

			if($arr['kuweiId']!=''){
				$strCon.=" and kuweiId='{$arr['kuweiId']}'";
			}
			if($arr['pihao']!=''){
				$strCon.=" and pihao like '%{$arr['pihao']}%'";
			}
			if($arr['ganghao']!=''){
				$strCon.=" and ganghao like '%{$arr['ganghao']}%'";
			}
			if($arr['color']!=''){
				$strCon.=" and color like '%{$arr['color']}%'";
			}
		}else{
			$arr['productId']>0 && $strCon.=" and id = '{$arr['productId']}'";
		}
		
		//关键字搜索需要处理
		if($arr['key']!=''){
			$strKey=" guige like '%{$arr['key']}%'";
			if(isset($filed['field']['pinzhong']))$strKey.=" or pinzhong like '%{$arr['key']}%'";
			if(isset($filed['field']['zhonglei']))$strKey.=" or zhonglei like '%{$arr['key']}%'";
			if(isset($filed['field']['proName']))$strKey.=" or proName like '%{$arr['key']}%'";

			$strKey!='' && $strKey=" and ({$strKey})";
		}
		

		//查询显示的信息
		//区别0库存与所有产品信息
		if($arr['isKucun']==1){//需要显示库存的时候，处理sql语句
			$strGroup="kuweiId,productId,pihao,color,dengji";
			if($this->strGroup)$strGroup=$this->strGroup;

			//关键字搜索
			if($strKey!=''){
				$str="select id from jichu_product where 1";
				$str.=$strKey;
				$res=$this->_subModel->findBySql($str);
				if(count($res)>0){
					$productIds = join(',',array_col_values($res,'id'));
					if($productIds!='')$strCon.=" and productId in($productIds)";
				}
			}

			//显示库存的代码
			$sql="select {$strGroup},sum(cnt) as cnt,sum(cntJian) as cntJian,1 as kucun
				from cangku_kucun where 1 {$strCon} and (rukuId>0 or (chukuId>0 and isCheck=1)) group by {$strGroup} having sum(cnt)>0 ";
			if($arr['sortBy'] !=''){
				$_Sort=$arr['sortBy']=='cnt' ? "sum(cnt)" : $arr['sortBy'];
				$sql.=" order by {$_Sort} {$arr['sort']}";
			}else{
				$sql.=" order by productId";
			}

		}elseif($arr['isKucun']==0){//不需要显示库存的时候，处理sql语句
			//关键字搜索
			if($strKey!='')$strCon.=$strKey;
			//显示所有信息的代码
			$sql="select *,id as productId,0 as kucun from jichu_product where 1 and type='{$arr['productType']}' {$strCon}";
		}

		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		
		foreach($rowset as &$v) {
			//如果没有产品信息，则取产品信息
			if(!$v['proCode'] && $v['productId']>0){
				$sql = "select * from jichu_product where id='{$v['productId']}'";
				$temp = $this->_modelExample->findBySql($sql);
				$v['proCode'] = $temp[0]['proCode'];
				$v['pinzhong'] = $temp[0]['pinzhong'];
				$v['zhonglei'] = $temp[0]['zhonglei'];
				$v['proName'] = $temp[0]['proName'];
				$v['guige'] = $temp[0]['guige'];
			}

			//如果没有数量信息，则取数量信息
			if($v['kucun']==0){
				$sql="select sum(cnt) as cnt,sum(cntJian) as cntJian from cangku_kucun where type='{$this->_type}' and (rukuId>0 or (chukuId>0 and isCheck=1)) and productId='{$v['productId']}'";
				// dump($sql);exit;
		      	$res=$this->_modelExample->findBySql($sql);
		      	$v['cnt']=$res[0]['cnt']==0?'':round($res[0]['cnt'],2);
		     	$v['cntJian']=$res[0]['cntJian'];

		     	$v['color']='';
			}

			//查找库位信息
			if($v['kuweiId']>0){
				$sql="select kuweiName from jichu_kuwei where id='{$v['kuweiId']}'";
				$kuwei = $this->_modelExample->findBySql($sql);
				$v['kuweiName']=$kuwei[0]['kuweiName'];
			}

			//查找供应商信息
			if($v['supplierId']>0){
				$sql="select compName from jichu_jiagonghu where id='{$v['supplierId']}'";
				$jgh = $this->_modelExample->findBySql($sql);
				$v['compName']=$jgh[0]['compName'];
			}

			//数量
			$v['cnt']=$v['cnt']==0?'':round($v['cnt'],2);
			$v['cntJian']=$v['cntJian']==0?'':round($v['cntJian'],2);
		} 

		$filedInfo = $filed['field'] ? $filed['field'] :array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格',
		);

		$filedInfo2 = $arr['isKucun']==1 ? $filed['fieldKucun'] : array();
		// dump($filed);exit;
		// 显示信息
		$kuweiFiled=array('kuweiName'=>array('text'=>'库位','width'=>120));
		if($arr['isKucun']==0){
			$kuweiFiled=array();
		}
		$arrFieldInfo = $kuweiFiled
		+
		$filedInfo
		+
		$filedInfo2
		+
		array(
			'cnt' => array('text'=>'库存','width'=>80,'sort'=>$arr['isKucun']),
			'cntJian' => array('text'=>'件数','width'=>80),
		);

		// dump($arrFieldInfo);exit;
		
		$smarty = &$this->_getView();
		$smarty->assign('title', '收发存报表'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 收发存报表中点击出库数量弹出窗口
	 */
	function actionPopup($filed) {
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' => $_GET['dateFrom'],
			'dateTo' => $_GET['dateTo'],
			'kuweiId'=>$_GET['kuweiId'],
			'productId'=>$_GET['productId'],
			'pihao'=>$_GET['pihao'],
			'color'=>$_GET['color'],
			'type'=>$_GET['type'],
			'dengji'=>$_GET['dengji'],
			'no_edit'=>'',
		));
		// dump($serachArea);exit;
		$sql = "select 
			y.chukuCode,
			y.jiagonghuId,
			y.clientId,
			y.chukuDate,
			y.memo as chukuMemo,
			y.kind,
			y.isJiagong,
			x.id,
			x.chukuId,
			x.pihao,
			x.dengji,
			x.productId,
			x.cnt,
			x.memoView,
			b.proCode,
			b.pinzhong,
			b.zhonglei,
			b.proName,
			b.guige,
			x.color,
			b.kind as proKind,
			c.depName,
			z.compName as supplierName,
			a.kuweiName
			from cangku_chuku y
			left join cangku_chuku_son x on y.id=x.chukuId
			left join jichu_product b on x.productId=b.id
			left join jichu_jiagonghu z on x.supplierId=z.id
			left join jichu_department c on y.departmentId=c.id
			left join jichu_kuwei a on y.kuweiId=a.id
			where 1 and y.type='{$arr['type']}' and y.isCheck=1";

		$sql .= " and y.chukuDate >= '{$arr['dateFrom']}' and y.chukuDate<='{$arr['dateTo']}'";
		$sql .= " and x.productId='{$arr['productId']}'";
		$sql .= " and y.kuweiId='{$arr['kuweiId']}'";
		$sql .= " and x.pihao='{$arr['pihao']}'";
		$sql .= " and x.color='{$arr['color']}'";
		// $sql .= " and x.dengji='{$arr['dengji']}'";
		$sql .= " order by chukuDate desc, chukuCode desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		if (count($rowset) > 0) foreach($rowset as &$v) {
			if($v['clientId']>0){
				$sql="select compName from jichu_client where id='{$v['clientId']}'";
				$temp = $this->_subModel->findBySql($sql);
				$v['clientName'] = $temp[0]['compName'];
			}
			if($v['jiagonghuId']>0){
				$sql="select compName from jichu_jiagonghu where id='{$v['jiagonghuId']}'";
				$temp = $this->_subModel->findBySql($sql);
				$v['compName'] = $temp[0]['compName'];
			}

			// if($v['isJiagong']==0){
				//查找发入的仓库信息
				$sql="select y.kuweiName from cangku_ruku x 
					left join jichu_kuwei y on y.id=x.kuweiId
				 	where x.dbId='{$v['chukuId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['kuweiTo'] = $temp[0]['kuweiName'];
			// }
			
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
		$rowset[] = $heji;

		$filed = $filed ? $filed :array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
		);

		// 显示信息
		$arrFieldInfo = array(
			"chukuDate" => "发生日期",
			'kind'=>'类型',
			'kuweiName'=>'出库仓库',
			'kuweiTo'=>'发入仓库',
			'compName'=>'加工户',
			"supplierName" => '供应商',
			'clientName'=>'客户',
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			)
		+
		$filed
		+
		array(
			'dengji'=>'等级',
			"cnt" => '数量(Kg)',
			'memoView'=>'备注',
		);


		$smarty = &$this->_getView();
		$smarty->assign('title', '出库清单'); 
		// $smarty->assign('pk', $this->_modelDefault->primaryKey);
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar')));
		$smarty->display('TableList.tpl');
	}

	/**
	 * 加工费应付款过账审核弹出窗口
	 * Time：2014/07/08 09:32:14
	 * @author li
	*/
	function actionPopupOnGuozhang(){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'kuweiId'=>'',
			'clientId'=>'',
			'productId'=>'',
			'orderCode'=>'',
			'key'=>'',
			'type'=>'',
			'dengji'=>'',
		));
		// dump($serachArea);exit;
		$sql = "select 
		    y.*,
			y.id chukuId,
			z.compName as supplierName,
			a.kuweiName
			from cangku_chuku y			
			left join jichu_jiagonghu z on y.isJiagong=z.id		
			left join jichu_kuwei a on y.kuweiId=a.id
			where 1 and y.isGuozhang=0 and y.isJiagong=0";

		// $sql .= " and y.chukuDate >= '{$arr['dateFrom']}' and y.chukuDate<='{$arr['dateTo']}'";
		//$arr['productId']>0 && $sql .= " and x.productId='{$arr['productId']}'";
		$arr['clientId']>0 && $sql .= " and y.clientId='{$arr['clientId']}'";
		$arr['kuweiId']>0 && $sql .= " and y.kuweiId='{$arr['kuweiId']}'";
		// $arr['pihao']!='' && $sql .= " and x.pihao like '%{$arr['pihao']}%'";
		//$arr['orderCode']!='' && $sql .= " and c.orderCode like '%{$arr['orderCode']}%'";
// 		if($arr['key']!=''){
// 			//如果客户输入：60s 格子布，可以支持搜索多个模糊查询
// 			$keys = explode(' ',$arr['key']);
// 			foreach ($keys as & $_key) {
// 				$str="like '%{$_key}%'";
// 				$sql .= " and (x.pihao {$str} or x.color {$str} or b.pinzhong {$str} or b.proName {$str} or b.zhonglei {$str} or b.guige {$str})";
// 			}
// 		}
		//$arr['dengji']!='' && $sql .= " and x.dengji='{$arr['dengji']}'";
		$arr['type']!='' && $sql .= " and y.type='{$arr['type']}'";
		$sql .= " group by y.id order by chukuDate, chukuCode desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//dump($v);exit;
			//查找加工户
			if($v['clientId']>0){
				$sql="select compName from jichu_client where id='{$v['clientId']}'";
				$temp = $this->_subModel->findBySql($sql);
				$v['compName'] = $temp[0]['compName'];
			}
			//拼接描述信息
			$v['qitaMemo']=$v['supplierName'].' '.$v['type'].' '.$v['kind'].' '.$v['kuweiName'];
			$sql="select avg(danjia) danjia,sum(y.cnt) cnt,sum(y.money) money from cangku_chuku x
			left join cangku_chuku_son y on x.id=y.chukuId
			where x.id='{$v['id']}'";
			$temp = $this->_modelExample->findBySql($sql);
			//dump($temp);exit;
			$v['cnt']=round($temp[0]['cnt'],6);
			$v['cntM']=round($temp[0]['cntM'],6);
			$v['money']=$temp[0]['money'];
			$v['danjia']=$temp[0]['danjia'];
			//dump($v['danjia']);exit;
			if($v['danjia']==0){
				//当单价为空时，默认此加工户最近一次的单价
				$sql="select y.danjia,x.rukuDate from cangku_ruku x
						left join cangku_ruku_son y on x.id=y.rukuId
						where x.jiagonghuId='{$v['jiagonghuId']}' and y.danjia>0 order by x.rukuDate desc";
				$temp = $this->_modelExample->findBySql($sql);
				//dump($temp);exit;
				$v['danjia']=$temp[0]['danjia'];
				$v['money']=$v['danjia']*$v['cnt'];
			}
			//单价信息
			$v['danjia']=round($v['danjia'],6);
			$v['cnt']=round($v['cnt'],6);
			$v['money']=round($v['money'],6);
			//dump($v['danjia']);exit;
			$v['mingxi']="<a href='".url("Shengchan_Chuku",'LookMX',array(
					'id'=>$v['id'],				
					'width'=>'500',
					'TB_iframe'=>1
			))."' title='明细'  class='thickbox'>明细</a> ";
				
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
		$rowset[] = $heji;
		// 显示信息
		$arrFieldInfo = array(
			'mingxi'=>'查看',
			"chukuDate" => "发生日期",
			'kind'=>'类型',
			"cnt" => '数量(Kg)',
			"money" => '金额',
			'kuweiName'=>'仓库',
			'compName'=>'客户',
			//'orderCode'=>'订单号',
			'chukuCode' => array('text'=>'出库单号','width'=>120),
// 			'qitaMemo'=>array('text'=>'产品描述','width'=>260),
// 			'dengji'=>'等级',
// 			'danjia'=>'单价',
 			
// 			"cntM" => '数量(M)',
			'memo'=>'备注',
		);


		$smarty = &$this->_getView();
		$smarty->assign('title', '出库清单');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/commonNew.tpl');
	}

	/*
	 * by shirui
	 * 出库过账
	 */
	function actionPopupOnGuozhang2(){
		FLEA::loadClass('TMIS_Pager');
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
				'kuweiId'=>'',
				'clientId'=>'',
				'productId'=>'',
				'orderCode'=>'',
				'key'=>'',
				'type'=>'',
				'dengji'=>'',
		));
		// dump($serachArea);exit;
// 		$sql = "select
// 		    y.*,
// 			y.id chukuId,
// 			z.compName as supplierName,
// 			a.kuweiName
// 			from cangku_chuku y
// 			left join jichu_jiagonghu z on y.isJiagong=z.id
// 			left join jichu_kuwei a on y.kuweiId=a.id
// 			where 1 and y.isGuozhang=0 and y.isJiagong=0";
	
		$sql = "select		    
			x.*,
			y.chukuDate,
			y.kind,
			y.clientId,
			y.chukuCode,	
			z.compName as supplierName,
			a.kuweiName,
			b.proName,b.guige,b.pinzhong
			from cangku_chuku_son x
			left join cangku_chuku y on x.chukuId=y.id
			left join jichu_jiagonghu z on y.isJiagong=z.id
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_product b on x.productId=b.id
			where 1 and y.isGuozhang=0 and y.isJiagong=0";
		$arr['clientId']>0 && $sql .= " and y.clientId='{$arr['clientId']}'";
		$arr['kuweiId']>0 && $sql .= " and y.kuweiId='{$arr['kuweiId']}'";
		
		$arr['type']!='' && $sql .= " and y.type='{$arr['type']}'";
		$sql.=" and not exists(select id from caiwu_ar_guozhang where chuku2proId=x.id)";
		$sql .= " order by chukuDate, chukuCode desc";
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
		if (count($rowset) > 0) foreach($rowset as &$v) {

			//查找加工户
			if($v['clientId']>0){
				$sql="select compName from jichu_client where id='{$v['clientId']}'";
				$temp = $this->_subModel->findBySql($sql);
				$v['compName'] = $temp[0]['compName'];
			}
			//拼接描述信息
			$v['qitaMemo']=$v['supplierName'].' '.$v['type'].' '.$v['kind'].' '.$v['kuweiName'];
			$v['danjia']=round($v['danjia'],6);
			$v['cnt']=round($v['cnt'],6);
			$v['money']=round($v['money'],6);
			//dump($v['danjia']);exit;
// 			$v['mingxi']="<a href='".url("Shengchan_Chuku",'LookMX',array(
// 			'id'=>$v['id'],
// 			'width'=>'800',
// 			'TB_iframe'=>1
// 			))."' title='明细'  class='thickbox'>明细</a> ";
			//dump($v);exit;
			$id=$v['id'];
			$v['isChecked']="<input type='checkbox' id='isChecked[]' name='isChecked[]' value='{$id}'/>";
			$v['danjia']="<input type='text' id='danjia[]' name='danjia[]' value='{$v['danjia']}'/>";
			$v['zhekouMoney']="<input type='text' id='zhekouMoney[]' name='zhekouMoney[]' value=''/>";
			$v['cnt']="<input type='text' id='cnt[]' name='cnt[]' value='{$v['cnt']}' readonly='readonly'/>";
			$v['_money']="<input type='text' id='_money[]' name='_money[]' value='{$v['money']}'/>";
			$v['money']="<input type='text' id='money[]' name='money[]' value='{$v['money']}' readonly='readonly'/><input type='hidden' id='isLingyong[]' name='isLingyong[]' value='2' />";
			$v['money'].="<input type='hidden' id='id[]' name='id[]' value='{$v['id']}' readonly='readonly'/>";
			$v['code']="<input type='text'  style='width:100px'  id='Code[]' name='Code[]' value='{$v['chukuCode']}'  readonly='readonly'/>";
		}

		$rowset[] = $heji;
				
		$arrFieldInfo = array(
			"isChecked"=>"过账选择",
			//'mingxi'=>'查看',
			"chukuDate" => "发生日期",
			'code' => array('text'=>'出库单号','width'=>120),
			'kind'=>'类型',
			"cnt" => '数量(Kg)',
			"cntM" => '数量(M)',
			"danjia" => '单价',
			"money" => '金额',
			"zhekouMoney" =>'折扣金额',
			"_money" =>'入账金额',
			'kuweiName'=>'仓库',
			'compName'=>'客户',					
			'color'=>'颜色',
			'pinzhong'=>'品种',
			'guige'=>'规格',
			'dengji'=>'等级',
			'memoView'=>'备注',
		);
	
	
		$smarty = &$this->_getView();
		$smarty->assign('title', '出库清单');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$other_url="<input type='button' id='save2' name='save2' value='保存'/>";
		$smarty->assign('other_url', $other_url);
		$smarty->assign('sonTpl', 'Caiwu/Yf/GuozhangTpl.tpl');
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr))."<font color='green'>一次过账>10,速度变慢！</font>");

		$smarty->display('Tbllist.tpl');
	}
	/**
	 * 加工费应付款过账审核弹出窗口
	 * Time：2014/07/08 09:32:14
	 * @author li
	*/
	function actionPopupOnGuozhangJg(){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'isHaveGz'=>$_GET['isHaveGz'],
			'kuweiId'=>'',
			'jiagonghuId'=>'',
			'productId'=>'',
			'key'=>'',
			// 'color'=>'',
			'type'=>'',
			'dengji'=>'',
		));
		// dump($serachArea);exit;
		$sql = "select 
			y.chukuCode,
			y.jiagonghuId,
			y.clientId,
			y.chukuDate,
			y.memo as chukuMemo,
			y.kind,
			y.isJiagong,
			x.id,
			x.chukuId,
			x.pihao,
			x.dengji,
			x.productId,
			x.cnt,
			x.danjia,
			x.money,
			x.memoView,
			x.isHaveGz,
			b.pinzhong,
			b.zhonglei,
			b.proName,
			b.guige,
			x.color,
			b.kind as proKind,
			z.compName as supplierName,
			a.kuweiName
			from cangku_chuku y
			left join cangku_chuku_son x on y.id=x.chukuId
			left join jichu_product b on x.productId=b.id
			left join jichu_jiagonghu z on x.supplierId=z.id
			left join jichu_kuwei a on y.kuweiId=a.id
			where y.isCheck=1 and y.isGuozhang=0 and y.isJiagong=1";

		// $sql .= " and y.chukuDate >= '{$arr['dateFrom']}' and y.chukuDate<='{$arr['dateTo']}'";
		$arr['productId']>0 && $sql .= " and x.productId='{$arr['productId']}'";
		$arr['jiagonghuId']>0 && $sql .= " and y.jiagonghuId='{$arr['jiagonghuId']}'";
		$arr['kuweiId']>0 && $sql .= " and y.kuweiId='{$arr['kuweiId']}'";
		if ($arr['isHaveGz'] != '') $sql .= " and x.isHaveGz = '{$arr['isHaveGz']}'";
		else $sql.=" and x.isHaveGz = 0";
		if($arr['key']!=''){
			//如果客户输入：60s 格子布，可以支持搜索多个模糊查询
			$keys = explode(' ',$arr['key']);
			foreach ($keys as & $_key) {
				$str="like '%{$_key}%'";
				$sql .= " and (x.pihao {$str} or x.color {$str} or b.pinzhong {$str} or b.proName {$str} or b.zhonglei {$str} or b.guige {$str})";
			}
		}
		$arr['dengji']!='' && $sql .= " and x.dengji='{$arr['dengji']}'";
		$arr['type']!='' && $sql .= " and y.type='{$arr['type']}'";
		$sql .= " order by chukuDate desc, chukuCode desc";
		 dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
        dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//查找加工户
			if($v['jiagonghuId']>0){
				$sql="select compName from jichu_jiagonghu where id='{$v['jiagonghuId']}'";
				$temp = $this->_subModel->findBySql($sql);
				$v['compName'] = $temp[0]['compName'];
			}
			//拼接描述信息
			$v['qitaMemo']=$v['pinzhong'].' '.$v['proName'].' '.$v['guige'].' '.$v['color'].' '.$v['pihao'];
			//单价信息
			$v['danjia']=round($v['danjia'],6);
			$v['cnt']=round($v['cnt'],6);

			//不需要过账的支持手动隐藏
			if($v['isHaveGz']==0){
				$view="不需过账";
				$guozhang='2';
			}elseif($v['isHaveGz']==2){
				$view="需要过账";
				$guozhang='0';
			}else{
				$v['isHaveGz']="已过帐";
				$view='';
			}
			// dump($v);exit;
			if($view!=''){
				$v['isHaveGz']="<a href='".$this->_url('isHaveGz',array(
					'id'=>$v['id'],
					'isHaveGz'=>$guozhang,
					'fromAction'=>$_GET['action']
				))."'>{$view}</a>";
			}
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
		$rowset[] = $heji;
		// 显示信息
		$arrFieldInfo = array(
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			'kind'=>'类型',
			'kuweiName'=>'仓库',
			'compName'=>'加工户',
			// 'clientName'=>'客户',
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			'qitaMemo'=>array('text'=>'产品描述','width'=>260),
			'dengji'=>array('text'=>'等级','width'=>80),
			// 'danjia'=>'单价',
			"cnt" => array('text'=>'数量(Kg)','width'=>80),
			"isHaveGz" => '是否需要过账',
		);


		$smarty = &$this->_getView();
		$smarty->assign('title', '出库清单');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$tpl = 'Popup/commonNew.tpl';
		$arr['isHaveGz']==2 && $tpl="Tbllist.tpl";
		$smarty->display($tpl);
	}

	/**
	 * 标记是否需要过账
	 * Time：2014/08/19 14:34:23
	 * @author li
	*/
	function actionIsHaveGz(){
		$arr=array(
			'id'=>$_GET['id'],
			'isHaveGz'=>$_GET['isHaveGz'],
		);
		$_GET['isHaveGz']=='2' && $isHaveGz='0';
		$_GET['isHaveGz']=='0' && $isHaveGz='2';
		$this->_subModel->update($arr);
		js_alert(null,'',$this->_url($_GET['fromAction'],array('isHaveGz'=>$isHaveGz)));
	}

	/**
	 * 损耗明细信息(验收明细)
	 * Time：2014/07/28 14:39:43
	 * @author li
	*/
	function actionSunhaoView($filed){
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$arr = TMIS_Pager::getParamArray(array(
			'touliaoId'=>'',
			'planGxId'=>'',
			'plan2proId'=>'',
			'jiagonghuId'=>'',
			'color'=>'',
			'ganghao'=>'',
			'pihao'=>'',
			'rukuId'=>'',
			'productId'=>'',
			'tlGanghao'=>'',
			'type'=>'',
			'kind'=>'',
			'no_edit'=>'',
		));
		// dump($serachArea);exit;
		$sql = "select 
			y.chukuCode,
			y.jiagonghuId,
			y.chukuDate,
			y.memo as chukuMemo,
			y.kind,
			x.id,
			x.chukuId,
			x.pihao,
			x.dengji,
			x.productId,
			x.cnt,
			x.memoView,
			b.proCode,
			b.pinzhong,
			b.zhonglei,
			b.proName,
			b.guige,
			x.color,
			x.ganghao,
			x.tlGanghao,
			b.kind as proKind,
			z.compName,
			a.kuweiName
			from cangku_chuku y
			left join cangku_chuku_son x on y.id=x.chukuId
			left join jichu_kuwei a on y.kuweiId=a.id
			left join jichu_product b on x.productId=b.id
			left join jichu_jiagonghu z on y.jiagonghuId=z.id
			left join shengchan_plan2product_gongxu g on g.id=x.planGxId
			where 1";
		$arr['type']!='' && $sql.=" and y.type='{$arr['type']}'";
		$arr['kind']!='' && $sql.=" and y.kind='{$arr['kind']}'";
		$arr['touliaoId']>0 && $sql.=" and g.touliaoId='{$arr['touliaoId']}'";
		$arr['planGxId']>0 && $sql.=" and x.planGxId='{$arr['planGxId']}'";
		$arr['rukuId']!='' && $sql.=" and y.rukuId in({$arr['rukuId']})";
		$arr['plan2proId']>0 && $sql.=" and x.plan2proId='{$arr['plan2proId']}'";
		$arr['color']!='' && $sql.=" and x.color='{$arr['color']}'";
		$arr['ganghao']!='' && $sql.=" and x.ganghao='{$arr['ganghao']}'";
		$arr['pihao']!='' && $sql.=" and x.pihao='{$arr['pihao']}'";
		// $arr['rukuId']!='' && $sql.=" and y.rukuId='{$arr['rukuId']}'";
		$arr['productId']!='' && $sql.=" and x.productId='{$arr['productId']}'";
		$arr['tlGanghao']!='' && $sql.=" and x.tlGanghao='{$arr['tlGanghao']}'";
		$sql.=" and y.jiagonghuId='{$arr['jiagonghuId']}'";
		$sql .= " order by chukuDate desc, chukuCode desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach($rowset as &$v) {
			
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
		$rowset[] = $heji;
		// 显示信息
		$filed = $filed ? $filed :array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
		);
		// 左边信息
		$arrFieldInfo = array(
			"chukuDate" => "发生日期",
			'kind'=>'入库类型',
			'compName'=>'加工户',
			'kuweiName'=>'库位',
			'chukuCode' => array('text'=>'入库单号','width'=>120),
			)
		+
		$filed
		+
		array(
			
			'dengji'=>'等级',
			"cnt" => '数量(Kg)',
		); 

		$smarty = &$this->_getView();
		$smarty->assign('title', '验收明细'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	/**
	 * 获取单价信息：财务过账时候单价为0的情况需要自动判断单价
	 * Time：2014/08/19 10:57:19
	 * @author li
	 * @param GET:ruku2proId入库明细的id
	 * @return json
	*/
	function actionGetDanjiaByLs(){
		$chuku2ProId = (int)$_GET['chuku2ProId'];
		//查找该记录的信息
		$chuku2Info = $this->_subModel->find($chuku2ProId);

		//查找之前类似的信息是否存在单价
		$sql="select x.danjia from cangku_chuku_son x
		left join cangku_chuku y on x.chukuId=y.id
		where 
		x.productId='{$chuku2Info['productId']}'
		and x.color='{$chuku2Info['color']}' 
		and x.dengji='{$chuku2Info['dengji']}' 
		and y.isJiagong='{$chuku2Info['Ck']['isJiagong']}'
		and y.kind='{$chuku2Info['Ck']['kind']}'
		and y.type='{$chuku2Info['Ck']['type']}'
		and y.isGuozhang=0 and x.id<>'{$chuku2ProId}'";
		//加工则判断加工户，否则判断供应商
		if($chuku2Info['Ck']['isJiagong']==1){
			$sql.=" and y.jiagonghuId='{$chuku2Info['Ck']['jiagonghuId']}'";
		}else{
			$sql.=" and y.supplierId='{$chuku2Info['Ck']['supplierId']}'";
		}
		$sql.=" order by y.chukuDate desc,x.id desc limit 0,1";
		// echo $sql;
		$temp=$this->_subModel->findBySql($sql);
		$temp=$temp[0];
		$temp['danjia']=round($temp['danjia'],6);

		echo json_encode($temp);
	}

	/**
	 * ajax 
	 * 获取库存信息
	 * 用于选择批号和对应的数量信息
	 * Time：2014/09/29 11:07:25
	 * @author li
	 * @param POST
	 * @return JSON
	*/
	function actionGetKucunByAjax(){
		$p = $_POST;
		$sql="select sum(x.cnt) as cnt , sum(x.cntJian) as cntJian,
			x.pihao,x.dengji,y.compName,z.kuweiName,x.color,x.supplierId,x.kuweiId
			from cangku_kucun x
			left join jichu_jiagonghu y on y.id = x.supplierId
			left join jichu_kuwei z on z.id = x.kuweiId
			where 1 and (rukuId>0 or (chukuId>0 and isCheck=1))";

		$p['type'] !='' && $sql.=" and x.type='纱'";
		$p['color'] !='' && $sql.=" and x.color='{$p['color']}'";
		$p['supplierId'] >0 && $sql.=" and x.supplierId='{$p['supplierId']}'";
		$p['kuweiId'] >0 && $sql.=" and x.kuweiId='{$p['kuweiId']}'";
		$p['productId'] >0 && $sql.=" and x.productId='{$p['productId']}'";
		$sql.=" group by productId,supplierId,kuweiId,pihao,color,dengji having sum(x.cnt)>0";
		// echo $sql;
		$arr = $this->_modelExample->findBySql($sql);
		foreach ($arr as $key => & $v) {
			$v['jsonData'] = json_encode($v);
		}
		// dump($arr);
		echo json_encode(array('data'=>$arr,'success'=>count($arr)>0));
	}

	/**
	 * 补丁
	 * 销售出库时，单价，金额丢失，这里需要重新计算
	 * Time：2014/09/29 13:27:28
	*/
	function actionBuildingXs(){
		$sql="select id,cnt,cntM,ord2proId from cangku_chuku_son where ord2proId<>0 and danjia=0";
		$res = $this->_modelExample->findBySql($sql);

		foreach ($res as $key => & $v) {
			$sql="select danjia,unit from trade_order2product where id='{$v['ord2proId']}' ";
			// echo $sql;exit;
			$temp = $this->_modelExample->findBySql($sql);
			$t=$temp[0];

			if($t['unit']=='M'){
				$money = $t['danjia']*$v['cntM'];
			}else{
				$money = $t['danjia']*$v['cnt'];
			}
			$sql="update cangku_chuku_son set danjia='{$t['danjia']}',money='{$money}' where id='{$v['id']}'";
			$this->_modelExample->execute($sql);
		}

		echo "补丁完成";
	}

	/**
	 * 布仓库出入库明细报表
	 * Time：2014/10/22 14:25:39
	 * @author li
	*/
	function actionReportViewRC(){
		$this->authCheck('9-12');
		FLEA::loadClass("TMIS_Pager");
		$_search = array(
			"dateFrom" => date('Y-m-01'), 
			"dateTo" => date('Y-m-d'),
			'jiagonghuId'=>'',
			'supplierId'=>'',
			'kuweiId'=>'',
			'pinzhong'=>'',
			'shazhi'=>'',
			'guige'=>'',
			'benchangganghao'=>'',
			'ganghao'=>'',
			// 'kind'=>'初始化',
			// 'type'=>'纱',
		);
		$arr = &TMIS_Pager::getParamArray($_search);

		$sql="select 
		x.rukuId,
		x.chukuId,
		if(x.rukuId<>0,x.cnt,0) as cntRk,if(x.rukuId<>0,x.cntJian,0) as cntJianRk,
		if(x.chukuId<>0 and x.isCheck=1,x.cnt*-1,0) as cntCk,if(x.chukuId<>0 and x.isCheck=1,x.cntJian*-1,0) as cntJianCk,
		x.color,
		x.pihao,
		x.ganghao,
		x.dengji,
		x.kind,
		x.type,
		x.dateFasheng,
		x.kuweiId,
		x.productId,
		y.pinzhong,
		y.proName,
		y.guige,
		z.kuweiName,
		s.compName as supplierName
		from cangku_kucun x
		left join jichu_product y on x.productId=y.id
		left join jichu_kuwei z on x.kuweiId=z.id
		left join jichu_jiagonghu s on s.id=x.supplierId
		where 1";
		if($arr['dateFrom']!='')$sql.=" and x.dateFasheng >= '{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$sql.=" and x.dateFasheng <= '{$arr['dateTo']}'";
		if($arr['supplierId']!=''){
			$str="select id from cangku_ruku_son where supplierId='{$arr['supplierId']}'";
			$_temp = $this->_subModel->findBySql($str);
			$rukuId=join(',',array_col_values($_temp,'id'));
			$rukuId=='' && $rukuId="null";

			$str="select id from cangku_chuku_son where supplierId='{$arr['supplierId']}'";
			$_temp = $this->_subModel->findBySql($str);
			$chukuId=join(',',array_col_values($_temp,'id'));
			$chukuId=='' && $chukuId="null";
			
			$sql.=" and (x.rukuId in ({$rukuId}) or x.chukuId in ({$chukuId}))";
		}
		if($arr['jiagonghuId']!=''){
			$str="select x.id from cangku_ruku_son x
			left join cangku_ruku y on y.id=x.rukuId
			where y.jiagonghuId='{$arr['jiagonghuId']}'";
			$_temp = $this->_subModel->findBySql($str);
			$rukuId=join(',',array_col_values($_temp,'id'));
			$rukuId=='' && $rukuId="null";

			$str="select x.id from cangku_chuku_son x
			left join cangku_chuku y on y.id=x.chukuId
			where y.jiagonghuId='{$arr['jiagonghuId']}'";
			$_temp = $this->_subModel->findBySql($str);
			$chukuId=join(',',array_col_values($_temp,'id'));
			$chukuId=='' && $chukuId="null";
			
			$sql.=" and (x.rukuId in ({$rukuId}) or x.chukuId in ({$chukuId}))";
		}
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['supplierId']!='')$sql.=" and x.supplierId = '{$arr['supplierId']}'";
		if($arr['key']!='')$sql.=" and (x.type like '%{$arr['key']}%' or x.kind like '%{$arr['key']}%')";
		if($arr['pinzhong']!='')$sql.=" and y.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['shazhi']!='')$sql.=" and y.proName like '%{$arr['shazhi']}%'";
		if($arr['benchangganghao']!='')$sql.=" and x.ganghao like '%{$arr['benchangganghao']}%'";
		if($arr['ganghao']!='')$sql.=" and x.pihao like '%{$arr['ganghao']}%'";
		if($arr['guige']!='')$sql.=" and y.guige like '%{$arr['guige']}%'";
		if($arr['kind']!='')$sql.=" and x.kind like '%{$arr['kind']}%'";
		if($arr['type']!='')$sql.=" and x.type like '%{$arr['type']}%'";

		// $sql.=" group by x.dateFasheng,x.productId,x.pihao,x.ganghao,x.color,x.type,x.kuweiId";
		$sql.=" order by x.dateFasheng,x.productId,x.ganghao,x.type";

		// dump($sql);exit;
		if($_GET['export']==1){
			// set_time_limit(0);
			$rowset = $this->_subModel->findBySql($sql);
		}else{
			$pager = &new TMIS_Pager($sql);
			$rowset = $pager->findAll();
		}
		

		foreach ($rowset as $key => & $v) {
			//查找当前库存情况
			$sql="select sum(cnt) as cnt,sum(cntJian) as cntJian from cangku_kucun where 1
				and dateFasheng <= '{$v['dateFasheng']}'
				and productId = '{$v['productId']}'
				and kuweiId = '{$v['kuweiId']}'
				and pihao = '{$v['pihao']}'
				and ganghao = '{$v['ganghao']}'
				and type = '{$v['type']}'
				and color = '{$v['color']}'
			";
			$temp = $this->_modelExample->findBySql($sql);
			$v['cntKucun'] = $temp[0]['cnt'];
			$v['cntJian'] = $temp[0]['cntJian'];

			//查找当前库存情况
			$sql="select sum(cnt) as cnt,sum(cntJian) as cntJian from cangku_kucun where 1
				and dateFasheng < '{$v['dateFasheng']}'
				and productId = '{$v['productId']}'
				and kuweiId = '{$v['kuweiId']}'
				and pihao = '{$v['pihao']}'
				and ganghao = '{$v['ganghao']}'
				and type = '{$v['type']}'
				and color = '{$v['color']}'
			";
			$temp = $this->_modelExample->findBySql($sql);
			$v['cntQc'] = $temp[0]['cnt'];
			$v['cntJianQc'] = $temp[0]['cntJian'];

			if($v['rukuId']>0){
				$str="select z.compName,y.creater,y.rukuCode as code,x.rukuId from cangku_ruku_son x
				left join cangku_ruku y on y.id=x.rukuId
				left join jichu_jiagonghu z on z.id=y.jiagonghuId
				where x.id='{$v['rukuId']}'";
				$temp = $this->_modelExample->findBySql($str);
				$v['jghName']=$temp[0]['compName'];
				$v['creater']=$temp[0]['creater'];
				$v['code']=$temp[0]['code'];
				$v['_rukuId']=$temp[0]['rukuId'];

			}elseif($v['chukuId']>0){
				$str="select z.compName,y.creater,y.chukuCode as code,x.chukuId from cangku_chuku_son x
				left join cangku_chuku y on y.id=x.chukuId
				left join jichu_jiagonghu z on z.id=y.jiagonghuId
				where x.id='{$v['chukuId']}'";
				$temp = $this->_modelExample->findBySql($str);
				$v['jghName']=$temp[0]['compName'];
				$v['creater']=$temp[0]['creater'];
				$v['code']=$temp[0]['code'];
				$v['_chukuId']=$temp[0]['chukuId'];
			}
			// dump($v);exit;

			$v['cntQc'] = $v['cntQc']==0 ? '' : round($v['cntQc'],2);
			$v['cntJianQc'] = $v['cntJianQc']==0 ? '' : round($v['cntJianQc'],2);
			$v['cntRk'] = $v['cntRk']==0 ? '' : round($v['cntRk'],2);
			$v['cntJianRk'] = $v['cntJianRk']==0 ? '' : round($v['cntJianRk'],2);
			$v['cntCk'] = $v['cntCk']==0 ? '' : round($v['cntCk'],2);
			$v['cntJianCk'] = $v['cntJianCk']==0 ? '' : round($v['cntJianCk'],2);
			$v['cntKucun'] = $v['cntKucun']==0 ? '' : round($v['cntKucun'],2);
			$v['cntJian'] = $v['cntJian']==0 ? '' : round($v['cntJian'],2);

			/*if($_GET['export']!=1){
				//获取对应的controller
				$_arr=$this->_getViewController(array(
					'rukuId'=>$v['_rukuId'],
					'chukuId'=>$v['_chukuId'],
				));
				//超链接
				if($_arr['controller']!=''){
					$v['code']="<a href='".url($_arr['controller'],'Edit',array(
						'id'=>$_arr['id'],
					))."'>{$v['code']}</a>";
				}
			}*/			
		}
		
		$fieldInfo=array(
			'dateFasheng'=>'发生日期',
			'code'=>'单号',
			'type'=>array('text'=>'物料类型','width'=>'80'),
			'kind'=>'出入类型',
			'pinzhong'=>'品种',
			'proName'=>'纱支',
			'guige'=>'规格',
			'ganghao'=>'本厂缸号',
			'pihao'=>'缸号',
			'kuweiName'=>'库位名称',
			'jghName'=>'加工户',
			'supplierName'=>'供应商',
			'cntQc'=>'期初(Kg)',
			'cntJianQc'=>'期初件数',
			'cntRk'=>'入库(Kg)',
			'cntJianRk'=>'入库件数',
			'cntCk'=>'出库(Kg)',
			'cntJianCk'=>'出库件数',
			'cntKucun'=>'当日库存(Kg)',
			'cntJian'=>'库存件数',
			'memoView'=>'备注',
			'creater'=>'操作人',
		);

		$smarty = &$this->_getView();
		$smarty->assign('title', '收发存报表'); 
		$smarty->assign('arr_field_info', $fieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		//处理导出
		$smarty->assign('fn_export',$this->_url($_GET['action'],array('export'=>1)+$arr));
		if($_GET['export']==1){
			$this->_exportList(array('fileName'=>$title),$smarty);
		}

		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	//按照类别自动获取类别
	//用于显示修改界面的信息
	//暂时停用
	function _getViewController($arr){
		// dump($arr);exit;
		//查找该id对应的信息
		if($arr['rukuId']>0){
			//查找入库信息
			$sql="select type,kind,dbId,id from cangku_ruku where id='{$arr['rukuId']}'";
			$_temp = $this->_modelExample->findBySql($sql);
		
			//如果存在dbId，表示是领用出库生成的数据，需要获取出库对应的信息
			if($_temp[0]['dbId']>0){
				$sql="select type,kind,id from cangku_chuku where id='{$_temp[0]['dbId']}'";
				$_temp = $this->_modelExample->findBySql($sql);
			}
		}elseif($arr['chukuId']>0){
			$sql="select type,kind,rukuId,id from cangku_chuku where id='{$arr['chukuId']}'";
			$_temp = $this->_modelExample->findBySql($sql);

			//如果存在rukuId表示为领用数据，需要查找其验收数据
			if($_temp[0]['rukuId']>0){
				$sql="select type,kind,id from cangku_ruku where id='{$_temp[0]['rukuId']}'";
				$_temp = $this->_modelExample->findBySql($sql);
			}
		}


		$t=$_temp[0];
		$key = $t['type'].','.$t['kind'];
		// dump($_temp);exit;
		//controller类的库，这里是自己动手汇总过来的，如果有类别增加，这里也要有调整
		$_key = array(
			'纱,初始化'=>'Shengchan_Cangku_Init',
			'纱,采购入库'=>'Shengchan_Cangku_Cgrk',
			'纱,坯纱染色发料'=>'Shengchan_Cangku_Llck',
			'纱,色纱验收'=>'Shengchan_Cangku_Scrk',
			'纱,织布发料'=>'Shengchan_Cangku_LlckZb',
			'纱,销售出库'=>'Shengchan_Cangku_Xsck',
			'纱,其他出库'=>'Shengchan_Cangku_Qtck',
			// '纱,销售出库'=>'Shengchan_Cangku_Xsck',
			// '纱,销售出库'=>'Shengchan_Cangku_Xsck',
		);

		return array('controller'=>$_key[$key],'id'=>$t['id']);
	}

	/**
	 * 销售明细报表
	 * Time：2014/10/22 14:25:39
	 * @author li
	*/
	function actionReportViewXS(){
		$this->authCheck('9-13');
		FLEA::loadClass("TMIS_Pager");
		$_search = array(
			"dateFrom" => date('Y-m-01'), 
			"dateTo" => date('Y-m-d'),
			'clientId'=>'',
			'kuweiId'=>'',
			'orderCode'=>'',
			'pinzhong'=>'',
			'guige'=>'',
			'color'=>'',
			'dengji'=>'',
			'benchangganghao'=>'',
			'ganghao'=>'',
			'key'=>'',
			'chukuId'=>'',
			'ord2proId'=>'',
			'productId'=>'',
			'key'=>'',
		);
		$arr = &TMIS_Pager::getParamArray($_search);

		$sql="select 
			x.id,
			x.chukuId,
			x.productId,
			x.ganghao,
			x.pihao,
			x.color,
			x.memoView,
			x.cnt,
			x.cntM,
			x.cntJian,
			x.danjia,
			x.money,
			x.dengji,
			y.chukuCode,
			y.clientId,
			y.chukuDate,
			y.kuweiId,
			y.people,
			y.phone,
			y.addressCk,
			y.type,
			y.kind,
			y.creater,
			z.menfu,
			z.kezhong,
			z.cntYaohuo,
			z.unit,
			z.dateJiaohuo,
			a.orderCode,
			a.orderDate,
			b.compName,
			c.kuweiName,
			d.pinzhong,
			d.guige,
			e.employName
		from cangku_chuku_son x 
		inner join cangku_chuku y on x.chukuId=y.id
		left join trade_order2product z on z.id=x.ord2proId
		left join trade_order a on a.id=z.orderId
		left join jichu_client b on b.id=y.clientId
		left join jichu_kuwei c on c.id=y.kuweiId
		left join jichu_product d on d.id=x.productId
		left join jichu_employ e on e.id=a.traderId
		where 1 and y.kind like '%销售%'";

		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			$sql .= " and a.traderId in({$traderId})";
		}

		if($arr['dateFrom']!='')$sql.=" and y.chukuDate >= '{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$sql.=" and y.chukuDate <= '{$arr['dateTo']}'";
		if($arr['kuweiId']!='')$sql.=" and y.kuweiId = '{$arr['kuweiId']}'";
		if($arr['clientId']!='')$sql.=" and y.clientId = '{$arr['clientId']}'";
		if($arr['orderCode']!='')$sql.=" and a.orderCode like '%{$arr['orderCode']}%'";
		if($arr['pinzhong']!='')$sql.=" and d.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['guige']!='')$sql.=" and d.guige like '%{$arr['guige']}%'";
		if($arr['color']!='')$sql.=" and x.color like '%{$arr['color']}%'";
		if($arr['dengji']!='')$sql.=" and x.dengji like '%{$arr['dengji']}%'";
		if($arr['benchangganghao']!='')$sql.=" and x.ganghao like '%{$arr['benchangganghao']}%'";
		if($arr['ganghao']!='')$sql.=" and x.pihao like '%{$arr['ganghao']}%'";
		if($arr['key']!='')$sql.=" and (x.memoView like '%{$arr['key']}%'
									or y.people like '%{$arr['key']}%'
									or y.addressCk like '%{$arr['key']}%'
										)";
		if($arr['chukuId']!='')$sql.=" and y.id = '{$arr['chukuId']}'";
		if($arr['ord2proId']!='')$sql.=" and x.ord2proId = '{$arr['ord2proId']}'";
		if($arr['productId']!='')$sql.=" and x.productId = '{$arr['productId']}'";
		if($arr['type']!='')$sql.=" and y.type like '%{$arr['type']}%'";

		$sql.=" order by y.chukuDate desc,x.productId";

		// dump($sql);exit;
		if($_GET['export']==1){
			// set_time_limit(0);
			$rowset = $this->_subModel->findBySql($sql);
		}else{
			$pager = &new TMIS_Pager($sql);
			$rowset = $pager->findAll();
		}
		

		foreach ($rowset as $key => & $v) {
				// $cnt = $v['unit']=='M' ? $v['cntM'] : $v['cnt'];
				// $v['cntWc'] = $v['cntYaohuo']-$cnt;
		}

		$rowset[]=$this->getHeji($rowset,array('cnt','cntM','cntJian'),'chukuDate');
		
		$fieldInfo=array(
			'chukuDate'=>'出库日期',
			'chukuCode'=>'出库单号',
			'compName'=>'客户',
			'employName'=>'业务员',
			'orderCode'=>'订单号',
			'orderDate'=>'下单日期',
			'type'=>'布类型',
			'pinzhong'=>'品种',
			'guige'=>array('text'=>'规格','width'=>'120'),
			'color'=>'颜色',
			'menfu'=>'门幅(M)',
			'kezhong'=>'克重(g/m<sup>2</sup>)',
			'ganghao'=>'本厂缸号',
			'pihao'=>'缸号',
			'dengji'=>'等级',
			'cnt'=>'出库(Kg)',
			'cntM'=>'出库(M)',
			'cntJian'=>'出库件数',
			'kuweiName'=>'库位名称',
			'cntYaohuo'=>'要货数',
			'unit'=>'下单单位',
			// 'cntWc'=>'未出数量',
			'dateJiaohuo'=>'交货日期',
			'addressCk'=>'交货地址',
			'people'=>'联系人',
			'phone'=>'联系电话',
			'memoView'=>'备注',
			'creater'=>'操作人',
		);

		$smarty = &$this->_getView();
		$smarty->assign('title', '销售明细报表'); 
		$smarty->assign('arr_field_info', $fieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		//处理导出
		$smarty->assign('fn_export',$this->_url($_GET['action'],array('export'=>1)+$arr));
		if($_GET['export']==1){
			$this->_exportList(array('fileName'=>$title),$smarty);
		}

		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	/**
	 * 销售明细报表
	 * Time：2014/10/22 14:25:39
	 * @author li
	*/
	function actionReportHuizongXS(){
		$this->authCheck('9-14');
		FLEA::loadClass("TMIS_Pager");
		$_search = array(
			"dateFrom" => date('Y-m-01'), 
			"dateTo" => date('Y-m-d'),
			'clientId'=>'',
			'kuweiId'=>'',
			'orderCode'=>'',
			'pinzhong'=>'',
			'guige'=>'',
			'color'=>'',
			// 'benchangganghao'=>'',
			// 'ganghao'=>'',
			'key'=>'',
		);
		$arr = &TMIS_Pager::getParamArray($_search);

		$sql="select 
			x.id,
			x.chukuId,
			x.productId,
			x.ganghao,
			x.pihao,
			x.color,
			x.memoView,
			sum(x.cnt) as cnt,
			sum(x.cntM) as cntM,
			sum(x.cntJian) as cntJian,
			x.danjia,
			sum(x.money) as money,
			x.dengji,
			y.chukuCode,
			y.clientId,
			y.chukuDate,
			y.kuweiId,
			y.people,
			y.phone,
			y.addressCk,
			y.type,
			y.kind,
			y.creater,
			z.menfu,
			z.kezhong,
			z.cntYaohuo,
			z.unit,
			z.dateJiaohuo,
			a.orderCode,
			a.orderDate,
			b.compName,
			c.kuweiName,
			d.pinzhong,
			d.guige,
			e.employName
		from cangku_chuku_son x 
		inner join cangku_chuku y on x.chukuId=y.id
		left join trade_order2product z on z.id=x.ord2proId
		left join trade_order a on a.id=z.orderId
		left join jichu_client b on b.id=y.clientId
		left join jichu_kuwei c on c.id=y.kuweiId
		left join jichu_product d on d.id=x.productId
		left join jichu_employ e on e.id=a.traderId
		where 1 and y.kind like '%销售%'";

		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			$sql .= " and a.traderId in({$traderId})";
		}

		if($arr['dateFrom']!='')$sql.=" and y.chukuDate >= '{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$sql.=" and y.chukuDate <= '{$arr['dateTo']}'";
		if($arr['kuweiId']!='')$sql.=" and y.kuweiId = '{$arr['kuweiId']}'";
		if($arr['clientId']!='')$sql.=" and y.clientId = '{$arr['clientId']}'";
		if($arr['orderCode']!='')$sql.=" and a.orderCode like '%{$arr['orderCode']}%'";
		if($arr['pinzhong']!='')$sql.=" and d.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['guige']!='')$sql.=" and d.guige like '%{$arr['guige']}%'";
		if($arr['color']!='')$sql.=" and x.color like '%{$arr['color']}%'";
		if($arr['benchangganghao']!='')$sql.=" and x.ganghao like '%{$arr['benchangganghao']}%'";
		if($arr['ganghao']!='')$sql.=" and x.pihao like '%{$arr['ganghao']}%'";
		if($arr['key']!='')$sql.=" and (x.memoView like '%{$arr['key']}%'
									or y.people like '%{$arr['key']}%'
									or y.addressCk like '%{$arr['key']}%'
										)";
		if($arr['kind']!='')$sql.=" and y.kind like '%{$arr['kind']}%'";
		if($arr['type']!='')$sql.=" and y.type like '%{$arr['type']}%'";

		$sql.=" group by x.chukuId,x.productId,x.color,x.ord2proId,x.dengji";
		$sql.=" order by y.chukuDate desc,x.productId";

		// dump($sql);exit;
		if($_GET['export']==1){
			// set_time_limit(0);
			$rowset = $this->_subModel->findBySql($sql);
		}else{
			$pager = &new TMIS_Pager($sql);
			$rowset = $pager->findAll();
		}
		

		foreach ($rowset as $key => & $v) {
				$v['view']="<a href='".$this->_url('ReportViewXS',array(
					'chukuId'=>$v['chukuId'],
					'productId'=>$v['productId'],
					'color'=>$v['color'],
					'dengji'=>$v['dengji'],
					'ord2proId'=>$v['ord2proId'],
				))."' target='_blank'>跟踪</a>";
		}

		$rowset[]=$this->getHeji($rowset,array('cnt','cntM','cntJian'),'chukuDate');
		
		$fieldInfo=array(
			'chukuDate'=>'出库日期',
			'view'=>array('text'=>'跟踪明细','width'=>50),
			'chukuCode'=>'出库单号',
			'compName'=>'客户',
			'employName'=>'业务员',
			'orderCode'=>'订单号',
			'orderDate'=>'下单日期',
			'type'=>'布类型',
			'pinzhong'=>'品种',
			'guige'=>array('text'=>'规格','width'=>'120'),
			'color'=>'颜色',
			'menfu'=>'门幅(M)',
			'kezhong'=>'克重(g/m<sup>2</sup>)',
			'dengji'=>'等级',
			'cnt'=>'出库(Kg)',
			'cntM'=>'出库(M)',
			'cntJian'=>'出库件数',
			'kuweiName'=>'库位名称',
			'cntYaohuo'=>'要货数',
			'unit'=>'下单单位',
			// 'cntWc'=>'未出数量',
			'dateJiaohuo'=>'交货日期',
			'addressCk'=>'交货地址',
			'people'=>'联系人',
			'phone'=>'联系电话',
			'memoView'=>'备注',
			'creater'=>'操作人',
		);

		$smarty = &$this->_getView();
		$smarty->assign('title', '销售明细报表'); 
		$smarty->assign('arr_field_info', $fieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		//处理导出
		$smarty->assign('fn_export',$this->_url($_GET['action'],array('export'=>1)+$arr));
		if($_GET['export']==1){
			$this->_exportList(array('fileName'=>$title),$smarty);
		}

		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}
	
	
	/*
	 * by shirui
	* 显示出库明细
	*/
	function actionLookMX(){
		//dump($_GET);//exit;			
		//获得验收明细
		$sql = "SELECT x.chukuCode,x.id,x.jiagonghuId,x.chukuCode,y.*,y.id as chuku2ProId,
		z.proName,z.guige,z.pinzhong FROM cangku_chuku x
		left join cangku_chuku_son y on x.id=y.chukuId
		left join jichu_product z on y.productId=z.id
		WHERE x.id='{$_GET['id']}'";
		$rowset = $this->_modelExample->findBySql($sql);
		$heji = $this->getHeji($rowset, array('cnt','money'), 'chukuCode');
		foreach ($rowset as & $v){
			//dump($sql);exit;
// 			if($v['danjia']==0){
// 				//当单价为空时，默认此加工户最近一次的单价
// 				$sql="select y.danjia,x.rukuDate from cangku_ruku x
// 				left join cangku_ruku_son y on x.id=y.rukuId
// 				where x.jiagonghuId='{$v['jiagonghuId']}' and y.danjia>0 order by x.rukuDate desc";
// 				$temp = $this->_modelExample->findBySql($sql);
// 				//dump($temp);exit;
// 				$v['danjia']=$temp[0]['danjia'];
// 				$v['money']=$v['danjia']*$v['cnt'];
// 			}

			$v['danjia']=round($v['danjia'],2);
			$v['danjia'] = "<input type='text' name='danjia[]' value='{$v['danjia']}'>";
			$v['money'] = "<input type='text' name='money[]' value='{$v['money']}'>";
			$v['money'] .= "<input type='hidden' name='rkCnt[]' value='{$v['cnt']}'>";
			$v['money'] .= "<input type='hidden' name='id[]' value='{$v['chuku2ProId']}'>";
			$v['money'] .= "<input type='hidden' name='chuku2ProId[]' value='{$v['chuku2ProId']}'>";
		}
		
		
		$rowset[] = $heji;
		//dump($rowset);exit;
		$fieldInfo=array(
				//'dateFasheng'=>'发生日期',
				//'type'=>array('text'=>'布种类','width'=>'60'),
				'chukuCode'=>'出库编号',
				'cntJian'=>'库存件数',
				'cnt'=>'数量(Kg)',				
				'danjia'=>'单价',
				'money'=>'金额',
				'cntM'=>'数量（M）',
				'color'=>'颜色',
				'pinzhong'=>'品种',
				'ganghao'=>'缸号',							
				'dengji'=>'等级',
				'memoView'=>'备注',			
				//'cntJianRk'=>'入库件数',
				//'cntCk'=>'出库(Kg)',
				//'cntJianCk'=>'出库件数',
				// 'cntKucun'=>'库存(Kg)',
				
		);
		$tpl = "TableList.tpl";
		$smarty = & $this->_getView();
		$smarty->assign("title","开票记录");
		$smarty->assign('arr_field_info', $fieldInfo);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('sonTpl', 'Shengchan/Cangku/sonTpl.tpl');
		$smarty->display($tpl);

	}
	
	/*
	 * by shirui
	* 应收过账保存
	*/
	function actionJsonGuozhang(){
	
		$ids=explode(',', $_GET['str']);
		$zhekouMoney=explode(',', $_GET['str2']);
		$_money=explode(',', $_GET['str3']);
		//dump($ids);exit;
		$i=0;
		foreach ($ids as & $v){
			$sql = "select
			x.*,
			a.id ord2proId,
			a.orderId,
			y.chukuDate,
			y.clientId,
			y.chukuDate
			from  cangku_chuku_son x
			left join cangku_chuku y on y.id=x.chukuId
			left join trade_order2product a on x.ord2proId=a.id

			where x.id='{$v}'";
			//dump($v);
				
			$rowset=$this->_modelExample->findBySql($sql);
			
			if($rowset[0]['supplierId']==0){
			$rowset[0]['supplierId']=$rowset[0]['jiagonghuId'];
			}
			$rowset[0]['creater']=$_SESSION['REALNAME'];
			$rowset[0]['guozhangDate']=date('Y-m-d');
			//dump($rowset);exit;
			$sql="insert into caiwu_ar_guozhang(chukuDate,clientId,chuku2proId,productId,chukuId,guozhangDate,kind,cnt,danjia,_money,money,zhekouMoney,qitaMemo,memo,huilv,creater,orderId,ord2proId)
			values('{$rowset[0]['chukuDate']}','{$rowset[0]['clientId']}','{$rowset[0]['id']}','{$rowset[0]['productId']}','{$rowset[0]['chukuId']}','{$rowset[0]['guozhangDate']}','{$rowset[0]['kind']}','{$rowset[0]['cnt']}','{$rowset[0]['danjia']}','{$rowset[0]['money']}','{$_money[$i]}','{$zhekouMoney[$i]}',
			'{$rowset[0]['qitaMemo']}','{$rowset[0]['memoView']}',1,'{$rowset[0]['creater']}','{$rowset[0]['orderId']}','{$rowset[0]['ord2proId']}')";
			//dump($sql);exit;
			$re=$this->_modelExample->findBySql($sql);
			
			// $sql="update cangku_chuku set isGuozhang=1 where id='{$v}'";
			// $this->_modelExample->findBySql($sql);
			$i++;
		}
		echo json_encode(true);
		}
	
		
		/*
		 * by shirui
		* 获得明细修改后的money
		*/
		function actionGetMoney(){
			//dump($_GET);exit;
			$sql="select sum(money) money from cangku_chuku_son where chukuId='{$_GET['id']}'";
			$re=$this->_modelExample->findBySql($sql);
			$money=round($re[0]['money']-$_GET['zhekouMoney'],2);
			$sql="update caiwu_yf_guozhang set _money='{$re[0]['money']}',money='{$money}' where chukuId='{$_GET['id']}'";
			$this->_modelExample->findBySql($sql);
			
			$ret['money']=$re[0]['money'];
			$ret['money2']=$money;
			//dump($ret);exit;
			echo json_encode($ret);
		}
}
?>