<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Caiwu_Ys_Income extends Tmis_Controller {
	var $_modelExample;
	var $title = "收款登记";
	var $_tplEdit='Caiwu/Ys/IncomeEdit.tpl';
	function __construct() {
		$this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Ys_Income');
		$this->_modelFapiao = & FLEA::getSingleton('Model_Caiwu_Ys_InCome2fapiao');
		// dump($this->_modelExample->typeOptions());exit;
		$this->fldMain = array(
        	'shouhuiCode' => array('type' => 'text', 'value' => '','title'=>'收汇单号'),
			'shouhuiDate' => array('title' => '收款日期', "type" => "calendar", 'value' => date('Y-m-d')),
			'clientId' => array('title' => '客户名称', 'type' => 'clientpopup', 'clientName' => ''),
			'headId'=>array('title'=>'公司抬头','type'=>'select','value'=>'','model'=>'Model_jichu_head'),
			'type' => array('title' => '收款方式', 'type' => 'combobox', 'value' => '','options'=>$this->_modelExample->typeOptions()),
			'money' => array('title' => '收款金额', 'type' => 'text', 'value' => '','name'=>'skmoney'),
			'bankId' => array('title' => '银行账号', 'type' => 'select', 'value' => '', 'model' =>'Model_Caiwu_bank'),
			'bizhong' => array('title' => '币种', 'type' => 'select', 'value' => 'RMB', 'options' => array(
					array('text' => 'RMB', 'value' => 'RMB'),
					array('text' => 'USD', 'value' => 'USD'),
					),'name'=>'skbizhong'),
			'huilv' => array('title' => '汇率', 'type' => 'text', 'value' => '1'),
			//'zmoney' => array('type' => 'btspan', "title" => '过账金额', 'name' => '_money[]','readonly'=>true),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => '','name'=>'incomeId'),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME'],'title'=>'制单人','readonly'=>true),
		);

		$this->headSon = array(
			'_edit' => array('type' => 'btCheckbox', "title" => '应收款', 'name' => '_edit[]'),
			'fapiaoDate' => array('type' =>'btspan',"title" =>'开票日期','name'=>'fapiaoDate[]','readonly'=>true),
			'fapiaoCode' => array('type' => 'btspan', "title" =>'发票单号', 'name'=>'fapiaoCode[]','readonly'=>true),
			'head' => array('type' => 'btspan', "title" =>'发票抬头', 'name'=>'head[]','readonly'=>true),
			'_money' => array('type' => 'btspan', "title" => '票面金额', 'name' => '_money[]','readonly'=>true),
			'ysmoney' => array('type' => 'btspan', "title" => '已收款', 'name' => 'ysmoney[]','readonly'=>true),
			'bizhong' => array('type' => 'btspan', "title" => '开票币种', 'name' => 'bizhong[]','readonly'=>true),
			'huilv' => array('type' => 'btspan', "title" => '汇率', 'name' => 'huilv[]','readonly'=>true),
			'money' => array('type' => 'bttext', "title" => '收款金额', 'name' => 'money[]','colmd'=>1),
			// 'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]','colmd'=>1),
			'incomeOver' => array('type' => 'btCheckbox', "title" => '收款完成', 'name' => 'incomeOver[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'fapiaoId' => array('type' => 'bthidden', 'name' => 'fapiaoId[]'),
		);

		$this->qitaSon = array(
			'_edit2' => array('type' => 'btCheckbox', "title" => '应收款', 'name' => '_edit2[]'),
			'chukuDate' => array('type' =>'btspan',"title" =>'出库日期','name'=>'chukuDate[]','readonly'=>true),
			'Code' => array('type' => 'btspan', "title" =>'单号', 'name'=>'Code[]','readonly'=>true),
				
			//'orderCode' => array('type' => 'btspan', "title" =>'订单号', 'name'=>'orderCode[]','readonly'=>true),
			//'qitaMemo' => array('type' => 'btspan', "title" =>'产品信息', 'name' => 'qitaMemo[]','readonly'=>true),
			'pinzhong' => array('type' => 'btspan', "title" =>'品种', 'name' => 'pinzhong[]','readonly'=>true),
			'guige' => array('type' => 'btspan', "title" =>'规格', 'name' => 'guige[]','readonly'=>true),
			'dengji' => array('type' => 'btspan', "title" =>'等级', 'name' => 'dengji[]','readonly'=>true),
			'color' => array('type' => 'btspan', "title" =>'颜色', 'name' => 'color[]','readonly'=>true),
			'cnt' => array('type' => 'btspan', "title" => '数量', 'name' => 'cnt[]','readonly'=>true),
			'danjia' => array('type' => 'btspan', "title" => '单价', 'name' => 'danjia[]','readonly'=>true),
			'gmoney' => array('type' => 'bttext', "title" => '收款金额', 'name' => 'gmoney[]','colmd'=>1),
			//'ykmoney' => array('type' => 'btspan', "title" => '已开票', 'name' => 'ykmoney[]','readonly'=>true),
			'huilv' => array('type' => 'btspan', "title" => '汇率', 'name' => 'huilv[]','readonly'=>true),
			//'money' => array('type' => 'bttext', "title" => '开票金额', 'name' => 'money[]','colmd'=>1),
			// 'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]','colmd'=>1),
			'incomeOver2' => array('type' => 'btCheckbox', "title" => '收款完成', 'name' => 'incomeOver2[]'),
			'id2' => array('type' => 'bthidden', 'name' => 'id2[]'),
			'guozhangId' => array('type' => 'bthidden', 'name' => 'guozhangId[]'),
			'orderId' => array('type' => 'bthidden', 'name' => 'orderId[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),

		);
		
		
		// 表单元素的验证规则定义
		$this->rules = array(
			'shouhuiCode' => 'required',
			'shouhuiDate' => 'required',
			'clientId' => 'required',
			'money' => 'required number'
		);
	}

	function actionRight() {
		// $this->authCheck('5-2-6');
		FLEA::loadclass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m'),date('d')-30,date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			'key'=>'',
			'no_edit'=>'',
		));
		$sql="select x.*,a.compName,z.itemName,y.head headname from caiwu_ar_income x
			left join jichu_client a on a.id=x.clientId
				left join jichu_head y on x.head=y.id
			left join caiwu_bank z on z.id=x.bankId
			where 1";
		if($arr['clientId']!='')$sql.=" and x.clientId='{$arr['clientId']}'";
		if($arr['dateFrom']!=''){
			$sql.=" and x.shouhuiDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.shouhuiDate <='{$arr['dateTo']}'";
		}
		if($arr['key']!=''){
			$sql.=" and x.shouhuiCode like '%{$arr['key']}%'";
		}
		$sql.=" order by x.id desc";
		$page=& new TMIS_Pager($sql);
		$rowset=$page->findAll();
		//dump($rowset);exit;
		if(count($rowset)>0)foreach($rowset as & $v) {
				$v['_edit'].=$this->getEditHtml($v['id']).'&nbsp;&nbsp;'.$this->getRemoveHtml($v['id']);
				$v['money']=round($v['money'],3);
				//折合人民币
				$v['moneyRmb']=round($v['money']*$v['huilv'],3);

				//查找稽核信息
				$v['Fapiao'] = $this->_modelFapiao->findAll(array('fapiaoId'=>$v['id']));
				foreach ($v['Fapiao'] as $key => & $c) {
					$c['fapiaoDate'] = $c['Fapiao']['fapiaoDate'];
					$c['fapiaoCode'] = $c['Fapiao']['fapiaoCode'];
					$c['_money'] = $c['Fapiao']['money'];
					$c['huilv'] = $c['Fapiao']['huilv'];
					$c['bizhong'] = $c['Fapiao']['bizhong'];
				}
		}

		$rowset[] = $this->getHeji($rowset, array('money','moneyRmb'), $_GET['no_edit']==1?'shouhuiCode':'_edit');
		
		$arr_field_info=array(
			'_edit'=>'操作',
			'shouhuiCode'=>array('text'=>'收汇单号','width'=>120),
			'shouhuiDate'=>'收款日期',
			'compName'=>'客户',
			'headname'=>'公司抬头',
			'money'=>'金额',
			'moneyRmb'=>'金额(RMB)',
			'bizhong'=>'币种',
			'huilv'=>'汇率',
			'type'=>'收款方式',
			'itemName'=>'银行账号',
			'memo'=>'备注',
		);
		
		$arr_field_info2=array(
			'fapiaoDate'=>array('text'=>'日期','width'=>100),
			'fapiaoCode'=>'单号',
			'_money'=>'发生金额',
			'bizhong'=>'币种',
			'huilv'=>'汇率',
			'money'=>'金额',
			'memo'=>'备注',
		);

		$smarty=& $this->_getView();
		$smarty->assign('sub_field',"Fapiao");
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_info2',$arr_field_info2);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('page_info',$page->getNavBar($this->_url($_GET['action'],$arr)).$note);
		$smarty->display('TblListMore.tpl');
	}

	function actionSave() {
		//dump($_POST);exit;
		$arr=array();
		foreach($this->fldMain as $key=>&$v) {
			$name = $v['name']?$v['name']:$key;
			$arr[$key] = $_POST[$name];
		}
		$arr['huilv']=empty($arr['huilv'])?1:$arr['huilv'];

		//过账明细数据
		$pros=array();
		foreach ($_POST['_edit'] as & $v) {
			if(empty($_POST['money'][$v])) continue;
			$temp = array();
			foreach($this->headSon as $k=>&$vv) {
				$temp[$k] = $_POST[$k][$v];
			}
			$pros[]=$temp;
		}

		//获取完成的应收记录，更新状态
		$_ys=array();//标记已完成
		foreach ($_POST['incomeOver'] as & $v) {
			$_ys[]=$_POST['fapiaoId'][$v];
		}

		//获取未完成的记录，有可能是取消完成的记录
		$noOver = array_diff($_POST['fapiaoId'], $_ys);
		$overStr=join(',',$_ys);
		if($noOver[0]!=null)$noStr=join(',',$noOver);
		 //dump($overStr);exit;//
		// dump($noStr);exit;
		

		//所有需要删除的稽核记录：存在id,但是没有选中
		$ids=array_filter($_POST['id']);
		$clear=array_diff($ids,array_col_values($pros,'id'));
		// dump($clear);exit;

		$arr['Fapiao']=$pros;
		
		//==========================
		//过账明细数据
		$pros2=array();
		foreach ($_POST['_edit2'] as & $v) {
			if(empty($_POST['gmoney'][$v])) continue;
			$temp = array();
			foreach($this->qitaSon as $k=>&$vv) {
				$temp[$k] = $_POST[$k][$v];
			}
			$pros2[]=$temp;
		}
		
		//获取完成的应收记录，更新状态
		$_ys=array();//标记已完成
		foreach ($_POST['incomeOver2'] as & $v) {
			if($_POST['guozhangId'][$v]!=null)$_ys[]=$_POST['guozhangId'][$v];
		}
		
		//获取未完成的记录，有可能是取消完成的记录
		$noOver2 = array_diff($_POST['guozhangId'], $_ys);
		$overStr2=join(',',$_ys);
		//dump($_ys);exit;
		if($noOver2[0]!=null)$noStr2=join(',',$noOver2);
		// dump($overStr);dump($noStr);exit;
		
		//dump(array_col_values($pros2,'id2'));exit;
		//所有需要删除的稽核记录：存在id,但是没有选中
		
		// dump($clear2);exit;
		foreach ($pros2 as & $v){
			$v['id']=$v['id2'];
			$v['incomeOver']=$v['incomeOver2'];
			$v['money']=$v['gmoney'];
		}
		$ids2=array_filter($_POST['id2']);
		$clear2=array_diff($ids2,array_col_values($pros2,'id2'));
		//dump($clear2);exit;
		$arr['Guozhang']=$pros2;
		
		
		
		
		$arr['head']=$_POST['headId'];
		// dump($arr);exit;

		//保存收款纪录
		$id=$this->_modelExample->save($arr);

		//保存后处理的动作
		if($id){
			//删除需要取消的关联发票信息
			$remove=join(',',$clear);
			if($remove!=''){
				$sql="delete from caiwu_ar_income2fapiao where id in($remove)";
				$this->_modelExample->execute($sql);
			}

			//改变是否收款完成的状态信息
			if($overStr!=''){
				$sql="update caiwu_ar_fapiao set incomeOver=1 where id in({$overStr})";
				$this->_modelExample->execute($sql);
			}
			if($noStr!=''){
				$sql="update caiwu_ar_fapiao set incomeOver=0 where id in({$noStr})";
				$this->_modelExample->execute($sql);
			}
			
			//删除需要取消的关联过账信息
			$remove=join(',',$clear2);
			
			if($remove!=''){
				$sql="delete from caiwu_ar_income2guozhang where id in($remove)";
				$this->_modelExample->execute($sql);
			}
			
			//改变是否收款完成的状态信息
			if($overStr2!=''){
				$sql="update caiwu_ar_guozhang set incomeOver=1 where id in({$overStr2})";
				$this->_modelExample->execute($sql);
			}
			if($noStr2!=''){
				$sql="update caiwu_ar_guozhang set incomeOver=0 where id in({$noStr2})";
				$this->_modelExample->execute($sql);
			}
		}

		//界面跳转
		js_alert(null,'window.parent.showMsg("操作成功");',$this->_url($_POST['fromAction']==''?'add':$_POST['fromAction']));

	}

	function actionAdd() {
		$areaMain = array('title' => '收款基本信息', 'fld' => $this->fldMain); 

		while (count($rowsSon)<5) {
			$rowsSon[]=array();
		}
		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('sonTpl',array(
				"Caiwu/Ys/Insert.tpl",
				"Caiwu/Ys/IncomeEdit.tpl",
			));
		$smarty->assign('firstColumn', array(
			'head'=>array('title'=>'开票列表','type'=>'btBtnSel','url'=>url('Caiwu_Ys_Fapiao','GetFapiaoByClientId'))
		));
		//dump($this->qitaSon);exit;
		while (count($rowsSon2)<5) {
			$rowsSon2[]=array();
		}
		
		$smarty->assign('rowsSon2', $rowsSon2);
		$smarty->assign('guoInfoTpl','Caiwu/Ys/GuoMingxi.tpl');
		$smarty->assign('qitaSon',$this->qitaSon);
		$smarty->assign('otherInfo','过账明细');
		$smarty->assign('firstColumn2', array(
				'head'=>array('title'=>'应收款','type'=>'btBtnSel','url'=>url('Caiwu_Ys_Guozhang','GetYingshou2'))
		));
		$smarty->assign('title', '收款信息编辑');
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		$row['money']=round($row['money'],3);
		$row['huilv']=round($row['huilv'],4);
		// dump($row);exit;
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row); 
		$this->fldMain['clientId']['clientName']=$row['Client']['compName'];

		/*
		* 稽核明细处理
		*/
		//查找本次稽核的记录
		$pros=array();
		!$row['Fapiao'] && $row['Fapiao']=array();
		foreach($row['Fapiao'] as & $v){
			//查找过账信息，订单信息，其他信息
			$sql="select x.fapiaoDate,x.fapiaoCode,x.money as _money,x.huilv,x.bizhong,x.incomeOver from caiwu_ar_fapiao x
			where x.id='{$v['fapiaoId']}' order by x.fapiaoDate,id asc";
			$temp=$this->_modelExample->findBySql($sql);
			$temp=$temp[0];
			$v+=$temp;
		}
		// dump($row['Guozhang']);exit;

		//查找还没有稽核的记录
		$fapiaoId=join(',',array_col_values($row['Fapiao'],'fapiaoId'));
		$fapiaoId!='' && $inStr=" and x.id not in ($fapiaoId)";
		$clientId = $row['clientId'];
		$sql="select x.fapiaoDate,x.fapiaoCode,x.money as _money,x.huilv,x.bizhong,x.id as fapiaoId from caiwu_ar_fapiao x
		where x.clientId='{$clientId}' and x.incomeOver=0 {$inStr} order by x.fapiaoDate,id asc";
		// dump($sql);exit;
		$fapiao = $this->_modelExample->findBySql($sql);
		// dump($fapiao);exit;

		//两条记录合并在一起，按照日期排序
		$row['Fapiao']=array_merge($row['Fapiao'],$fapiao);
		// dump($row);exit;
		$row['Fapiao']=array_column_sort($row['Fapiao'],'fapiaoDate',SORT_ASC);
		foreach ($row['Fapiao'] as $key => & $v) {

			$v['_money']=round($v['_money'],6);
			$v['money']=round($v['money'],6);
			$v['huilv']=round($v['huilv'],6);

			//查找已开票信息
			$sql="select sum(money) as money from caiwu_ar_income2fapiao where fapiaoId='{$v['fapiaoId']}' and id<>'{$v['id']}'";
			// dump($sql);
			$_temp = $this->_modelExample->findBySql($sql);
			$v['ysmoney'] = round($_temp[0]['money'],3)+0;

			//未稽核的记录，默认显示的金额
			if(empty($v['id']))$v['money']=$v['_money']-$v['ysmoney'];
		}
		
		//查找所有的未完成的过账记录
		

		$rowsSon = array();
		foreach($row['Fapiao'] as $key => & $v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			// dump($temp);
			if($v['id']>0)$temp['_edit']['checked']=true;
			if($v['incomeOver']==1)$temp['incomeOver']['checked']=true;

			$temp['_edit']['value']=$key;
			$temp['incomeOver']['value']=$key;

			$rowsSon[] = $temp;
		}
		
		//====================================================================
		$pros2=array();
		!$row['Guozhang'] && $row['Guozhang']=array();
		foreach($row['Guozhang'] as & $v){
			
			$sql="select x.chukuDate,x.money gmoney,x.huilv,x.cnt,x.unit,x.incomeOver,
			x.danjia,x.id,x.orderId,x.ord2proId,x.qitaMemo,z.color,
			z.dengji,a.proName,a.guige,a.pinzhong,b.orderCode,c.chukuCode Code from caiwu_ar_guozhang x
			left join jichu_product y on x.productId=y.id
			left join cangku_chuku_son z on x.chuku2proId=z.id
			left join jichu_product a on z.productId=a.id
			left join trade_order b on b.id=x.orderId
			left join cangku_chuku c on c.id=x.chukuId
			where x.id='{$v['guozhangId']}' order by x.guozhangDate,id asc";
			$temp=$this->_modelExample->findBySql($sql);
			
			$temp=$temp[0];
			
			if(!$temp)continue;
			$v+=$temp;
			
		}
		
			$guozhangId=join(',',array_col_values($row['Guozhang'],'guozhangId'));
			$guozhangId!='' && $inStr=" and x.id not in ($guozhangId)";
			$clientId = $row['clientId'];
			$sql="select x.chukuDate,x.money gmoney,x.huilv,x.cnt,x.unit,x.incomeOver,
			x.danjia,x.id guozhangId,x.orderId,x.ord2proId,x.qitaMemo,z.color,
			z.dengji,a.proName,a.guige,a.pinzhong,b.orderCode,c.chukuCode Code from caiwu_ar_guozhang x
			left join jichu_product y on x.productId=y.id
			left join cangku_chuku_son z on x.chuku2proId=z.id
			left join jichu_product a on z.productId=a.id
			left join trade_order b on b.id=x.orderId
			left join cangku_chuku c on c.id=x.chukuId
			where x.clientId='{$clientId}'   and x.incomeOver=0 {$inStr}  order by x.chukuDate,x.guozhangDate,x.id asc";
			// dump($sql);exit;
			$guozhang = $this->_modelExample->findBySql($sql);
	

			$row['Guozhang']=array_merge($row['Guozhang'],$guozhang);
			//dump($row['Guozhang']);exit;
			$row['Guozhang']=array_column_sort($row['Guozhang'],'guozhangDate',SORT_ASC);
			foreach ($row['Guozhang'] as $key => & $v) {

			$v['_money']=round($v['_money'],6);
			$v['money']=round($v['money'],6);
			$v['huilv']=round($v['huilv'],6);


			$sql="select sum(money) as money from caiwu_ar_income2guozhang where guozhangId='{$v['guozhangId']}' and id<>'{$v['id']}'";
			// dump($sql);
			$_temp = $this->_modelExample->findBySql($sql);
			$v['ysmoney'] = round($_temp[0]['money'],3)+0;

            $v['id2']=$v['id'];
			if(empty($v['id']))$v['money']=$v['_money']-$v['ysmoney'];
			}


			
			$rowsSon2 = array();
			foreach($row['Guozhang'] as $key => & $v) {
			
			$temp = array();
			foreach($this->qitaSon as $kk => &$vv) {
			$temp[$kk] = array('value' => $v[$kk]);
			}
			 
			if($v['id2']>0)$temp['_edit2']['checked']=true;
			$v['incomeOver2']=$v['incomeOver'];
			if($v['incomeOver2']==1)$temp['incomeOver2']['checked']=true;

			$temp['_edit2']['value']=$key;
			$temp['incomeOver2']['value']=$key;
			$rowsSon2[] = $temp;
			}
		
		
		
// 		dump($row['Guozhang']);//exit;
// 		$rowsSon2 = array();
// 		foreach($row['Guozhang'] as  & $v) {
// 			//dump($v);
// 			$sql="select x.chukuDate,x.money,x.huilv,x.cnt,x.unit,x.incomeOver,
// 			x.danjia,x.id,x.orderId,x.ord2proId,x.qitaMemo,z.color,
// 			z.dengji,a.proName,a.guige,a.pinzhong,b.orderCode,c.chukuCode Code from caiwu_ar_guozhang x
// 			left join jichu_product y on x.productId=y.id
// 			left join cangku_chuku_son z on x.chuku2proId=z.id
// 			left join jichu_product a on z.productId=a.id
// 			left join trade_order b on b.id=x.orderId
// 			left join cangku_chuku c on c.id=x.chukuId
// 			where x.clientId='{$clientId}'   order by x.chukuDate,x.guozhangDate";
// 			$guozhang = $this->_modelExample->findBySql($sql);
// 			//dump($guozhang);//exit;
// 			foreach ($guozhang as & $vv){
// 				if($vv['id']==$v['guozhangId'])$vv['id2']=$v['incomeId'];
// 				if($v['id']>0)$v['_edit2']['checked']=true;
// 			}
// 			$v['chukuDate']=$guozhang[0]['chukuDate'];
// 			$v['gmoney']=$guozhang[0]['money'];
// 			$v['huilv']=$guozhang[0]['huilv'];
// 			$v['incomeOver2']=$guozhang[0]['incomeOver'];
// 			//dump($guozhang[0]['incomeOver']);
// 			$v['color']=$guozhang[0]['color'];
// 			$v['danjia']=$guozhang[0]['danjia'];
// 			$v['dengji']=$guozhang[0]['dengji'];
// 			$v['proName']=$guozhang[0]['proName'];
// 			$v['guige']=$guozhang[0]['guige'];
// 			$v['pinzhong']=$guozhang[0]['pinzhong'];
// 			$v['Code']=$guozhang[0]['Code'];
// 			$v['orderCode']=$guozhang[0]['orderCode'];
			
// 		}
		//dump($guozhang);exit;
// 		foreach($guozhang as $key => & $v) {
// 			$temp = array();
// 			foreach($this->qitaSon as $kk => &$vv) {
// 				$temp[$kk] = array('value' => $v[$kk]);
// 			}
// 			 dump($v);//exit;
// 			if($v['id2']>0)$temp['_edit2']['checked']=true;
// 			if($v['incomeOver2']==1)$temp['incomeOver2']['checked']=true;
// 		    //dump($temp['incomeOver2']);
// 			//$temp['_edit2']['value']=$key;
// 			$temp['incomeOver']['value']=$key;
		
// 			$rowsSon2[] = $temp;
// 		}
		//dump($rowsSon2);exit;
		//补齐5行
		$cnt = count($rowsSon);
		if($cnt<=0)for($i=5;$i>$cnt;$i--) {
			$rowsSon[] = array();
		}
		$cnt2 = count($rowsSon2);
		if($cnt2<=0)for($i=5;$i>$cnt2;$i--) {
			$rowsSon2[] = array();
		}

		$areaMain = array('title' => '收款基本信息', 'fld' => $this->fldMain); 
		// dump($rowsSon);exit;
		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rowsSon2', $rowsSon2);
		$smarty->assign('guoInfoTpl','Caiwu/Ys/GuoMingxi.tpl');
		$smarty->assign('qitaSon',$this->qitaSon);
		$smarty->assign('otherInfo','过账明细');
		$smarty->assign('rules', $this->rules); 
		$smarty->assign('sonTpl',array(
				"Caiwu/Ys/Insert.tpl",
				"Caiwu/Ys/IncomeEdit.tpl",

			));
		$smarty->assign('title', '收款信息编辑');
		$smarty->display('Main2Son/T1.tpl');
	}

	/**
	 * 删除功能，删除的同时需要更新关联过账记录的状态
	 * Time：2014/08/05 19:02:40
	 * @author li
	*/
	function actionRemove(){
		$this->authCheck();
		//查找需要更新状态的过账记录
		$sql="select group_concat(fapiaoId) as fapiaoId from caiwu_ar_income2fapiao where incomeId='{$_GET['id']}'";
		$temp=$this->_modelExample->findBySql($sql);
		//更新状态
		if($temp[0]['fapiaoId']!=''){
			$sql="update caiwu_ar_fapiao set incomeOver=0 where id in ({$temp[0]['fapiaoId']})";
			$this->_modelExample->execute($sql);
		}
		//查找需要更新状态的过账记录
		$sql="select group_concat(guozhangId) as guozhangId from caiwu_ar_income2guozhang where incomeId='{$_GET['id']}'";
		$temp=$this->_modelExample->findBySql($sql);
		//更新状态
		if($temp[0]['guozhangId']!=''){
			$sql="update caiwu_ar_guozhang set incomeOver=0 where id in ({$temp[0]['guozhangId']})";
			$this->_modelExample->execute($sql);
		}
		
		parent::actionRemove();
	}
	
	
	/*
	 * by shirui 
	 * 
	 * 为了获得发票相关的过账信息
	 */
	
	function actionGetguozhang(){
		//dump($_GET);exit;
		$sql="select x.*,c.fapiaoCode,z.pinzhong,z.proName,z.color,
				z.guige,a.chukuCode Code,b.dengji
		 		from caiwu_ar_guozhang x
				left join caiwu_ar_fapiao2guozhang y on x.id=y.guozhangId 
				left join jichu_product z on x.productId=z.id
				left join cangku_chuku a on z.id=x.chukuId
				left join cangku_chuku_son b on b.id=x.chuku2proId
				left join caiwu_ar_fapiao c on c.id=y.fapiaoId
				where y.fapiaoId='{$_GET['id']}'";
		
		$rowset=$this->_modelExample->findBySql($sql);
		//dump($rowset);exit;
		echo  json_encode($rowset);
	}
}
?>