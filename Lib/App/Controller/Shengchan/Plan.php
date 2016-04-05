<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_Plan extends Tmis_Controller {
	// /构造函数
	function Controller_Shengchan_Plan() {
		// $this->_modelDefault = &FLEA::getSingleton('Model_Shengchan_Plan');
		$this->_modelExample = &FLEA::getSingleton('Model_Shengchan_Plan');
		$this->_modelPro = &FLEA::getSingleton('Model_Shengchan_Plan2Product');
		// 定义模板中的主表字段
		$this->fldMain = array(
			'planCode' => array('title' => '计划单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('JH','shengchan_plan','planCode')),
			// 'planCode' => array('title' => '订单日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'planDate' => array('title' => '计划日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'overDate' => array('title' => '计划完成日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			//相关订单的选择
			// 'orderId'=>array('title' => '相关订单', 'type' => 'orderpopup','value'=>''),
			'orderId' => array(
				'title' => '相关订单', 
				"type" => "Popup",
				'url'=>url('trade_order','popupPlan'),
				'textFld'=>'orderCode',
				'hiddenFld'=>'orderId',
				'dialogWidth'=>880
			),
			'isOver' => array('title' => '是否完成', 'type' => 'select', 'value' =>0,'options'=>array(
				array('text'=>'否','value'=>0),
				array('text'=>'是','value'=>1),
			)),
			'overDateReal' => array('title' => '实际完成日期', 'type' => 'calendar', 'value' => ''),
			
			// 定义了name以后，就不会以memo作为input的id了
			'planMemo'=>array('title'=>'生产备注','type'=>'textarea','disabled'=>true,'name'=>'planMemo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'planId'),
			'orderKind' => array('type' => 'hidden', 'value' => '成布'),
			); 
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'menfu'=>array('type'=>'bttext',"title"=>'门幅(M)','name'=>'menfu[]'),
			'kezhong'=>array('type'=>'bttext',"title"=>'克重(g/m<sup>2</sup>)','name'=>'kezhong[]'),
			'cntYaohuo'=>array('type'=>'bttext',"title"=>'要货数','name'=>'cntYaohuo[]','readonly'=>true),
			'cntShengchan' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cntShengchan[]'),
			'pibuCnt' => array('type' => 'bttext', "title" => '坯布数(Kg)', 'name' => 'pibuCnt[]'),
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'), 
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			// 'orderId' => array('type' => 'bthidden', 'name' => 'orderId[]'),
		); 
		// 表单元素的验证规则定义
		$this->rules = array(
			'orderCode' => 'required',
			'planDate' => 'required',
			'overDate' => 'required',
			'planCode' => 'required'
		);
	} 

	function actionRight() {
		//权限判断
		$this->authCheck('2-5');
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'clientId' => '',
			// 'traderId' => '',
			'planCode' => '',
			'pinzhong'=>'',
			'guige'=>'',
			'color'=>'',
		)); 
		$sql="select x.*,y.orderCode,y.traderId,y.clientId,y.orderDate 
			from shengchan_plan x
			left join trade_order y on y.id=x.orderId
			left join shengchan_plan2product z on x.id=z.planId
			left join jichu_product a on a.id=z.productId
			where 1";
		if($arr['planCode']!='')$sql.=" and x.planCode like '%{$arr['planCode']}%'";
		if($arr['pinzhong']!='')$sql.=" and a.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		if($arr['color']!='')$sql.=" and z.color like '%{$arr['color']}%'";
		if($arr['clientId']!='')$sql.=" and y.clientId like '%{$arr['clientId']}%'";
		if($arr['traderId']!='')$sql.=" and y.traderId like '%{$arr['traderId']}%'";
		$sql.=" group by x.id order by x.planDate desc,x.id desc";

		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		

		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']) ./* ' ' . "<a href='".$this->_url('print',array(
				'planId'=>$v['id']
			))."' target='_blank'>打印</a>". */' ' .$this->getRemoveHtml($v['id']);

			//客户信息
			$sql="select compName from jichu_client where id='{$v['clientId']}'";
			$temp = $this->_modelPro->findBySql($sql);
			$v['compName'] = $temp[0]['compName'];

	
			$v['Products']=$this->_modelPro->findAll(array('planId'=>$v['id']));

			//显示明细数据
			foreach($v['Products'] as & $vv){
				//查询产品信息
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_modelPro->findBySql($sql);
				$vv['proCode']=$temp[0]['proCode'];
				$vv['pinzhong']=$temp[0]['pinzhong'];
				// $vv['proName']=$temp[0]['proName'];
				$vv['guige']=$temp[0]['guige'];
				// $vv['color']=$temp[0]['color'];

				//查看工序明旭信息
				$sql="select group_concat(touliaoId) as touliaoId from shengchan_plan_touliao2product where plan2proId='{$vv['id']}'";
				$temp = $this->_modelPro->findBySql($sql);
				$touliaoId = $temp[0]['touliaoId'];
				$touliaoId=$touliaoId==''?'null':$touliaoId;
				//查找是否已设置工序信息
				$sql="select count(*) as cnt from shengchan_plan2product_gongxu where touliaoId in({$touliaoId})";
				$temp = $this->_modelPro->findBySql($sql);
				//如果存在查看否则提醒未设置工序信息
				if($temp[0]['cnt']>0){
					$vv['view']="<a href='".$this->_url('ViewGongxu',array(
						'touliaoId'=>$touliaoId,
						'baseWindow'=>'parent',
						'TB_iframe'=>1,
					))."' title='工序明细' class='thickbox'>查看</a>";
				}else{
					$vv['view']="<span title='未设置工序信息'>查看</span>";
				}

				
				//查看成分比例信息，各个成分对应的数量信息
				//查看是否已设置成分比例
				$sql="select count(*) as cnt from shengchan_plan2product_touliao where touliaoId in({$touliaoId})";
				$temp = $this->_modelPro->findBySql($sql);
				if($temp[0]['cnt']>0){
					$vv['perCf']="<a href='".$this->_url('ViewPer',array(
						'touliaoId'=>$touliaoId,
						'baseWindow'=>'parent',
						'width'=>'1000',
						'TB_iframe'=>1,
					))."' title='投料计划' class='thickbox'>投料计划</a>";
				}else{
					$vv['perCf']="<span title='未设置投料计划信息'>投料计划</span>";
				}

				//计算明细数量合计，显示在主信息中
				$v['cntShengchan']+=$vv['cntShengchan'];
				$v['pibuCnt']+=$vv['pibuCnt'];
			}

			//查找订单交期
			$sql="select dateJiaohuo from trade_order2product where orderId='{$v['orderId']}' limit 0,1";
			$res = $this->_modelExample->findBySql($sql);
			$v['dateJiaohuo'] = "<font color='green'>".$res[0]['dateJiaohuo']."</font>";
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => '操作',
			'orderCode'=>'订单号',
			'compName'=>'客户',
			"planDate" => "计划日期",
			'planCode' => '计划单号',
			"dateJiaohuo" => "交货日期",
			"overDate" => "计划完成时间",
			'overDateReal' => '实际完成时间',
			"cntShengchan" => '计划数量(Kg)',
			"pibuCnt" => '坯布数(Kg)',
			"planMemo" => array('text'=>'生产备注','width'=>200), 
		); 
		
		$arrField=array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			// "proName" => '纱支', 
			'guige'=>array('text'=>'规格','width'=>150),
			'color'=>array('text'=>'颜色','width'=>200),
			"menfu" => '门幅(M)',
			"kezhong" => '克重(g/m<sup>2</sup>)', 
			"cntShengchan" => '计划数量(Kg)',
			"pibuCnt" => '坯布数(Kg)',
			'view'=>array('text'=>'工序明细','width'=>80),
			'perCf'=>array('text'=>'投料计划','width'=>80),
			'memo'=>'备注',
		);

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_info2', $arrField);
		$smarty->assign('sub_field', 'Products');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar'))); 
		// $smarty->display('TableList.tpl');
		$smarty->display('TblListMore.tpl');
	}

	function actionAdd() {
		$this->authCheck('2-1');
		// 从表区域信息描述
		$smarty = &$this->_getView();
		$areaMain = array('title' => '生产计划基本信息', 'fld' => $this->fldMain); 
		$smarty->assign('areaMain', $areaMain);
		// 从表信息字段,默认5行
		for($i = 0;$i < 5;$i++) {
			$rowsSon[] = array();
		} 
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules); 
		$sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/jsPlanEdit.tpl'
		);
		$smarty->assign('sonTpl', $sonTpl);
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit() {
		$this->authCheck('2-1');
		//dump($_GET['id']);exit;
		$arr = $this->_modelExample->find(array('id' => $_GET['id'])); 
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value']; 
		}

		//设置rukuId的值
		$this->fldMain['id']['value'] = $arr['id'];
        
        //获取流转单号
        $sql="select * from trade_order where id='{$arr['orderId']}'";
        $res=$this->_modelExample->findBySql($sql);
		$this->fldMain['orderId']['text'] = $res[0]['orderCode'];

		//处理时间完成时间
		if($this->fldMain['overDateReal']['value']=='0000-00-00')$this->fldMain['overDateReal']['value']='';
		// //加载库位信息的值
		$areaMain = array('title' => '入库基本信息', 'fld' => $this->fldMain); 

		// 入库明细处理
		$rowsSon = array();
		///
		$arr['Products']=array_column_sort($arr['Products'],'id');
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];

			//查找要货数量
			$sql="select cntYaohuo,unit from trade_order2product where id='{$v['ord2proId']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			// dump($sql);exit;
			$v['cntYaohuo'] = round($_temp[0]['cntYaohuo'],2).$_temp[0]['unit'];
		}
		///
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


		// dump($areaMain);exit;

		$smarty = &$this->_getView();
		$smarty->assign('areaMain', $areaMain);
		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('fromAction', $_GET['fromAction']);
		$smarty->assign('rules', $this->rules);
		$sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/jsPlanEdit.tpl'
		);
		$smarty->assign('sonTpl', $sonTpl); 
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionSave(){
		//有效性验证,没有明细信息禁止保存
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
		// $row['id']=$row['planId'];
		$row['kind']=$row['orderKind'];
		// dump($row);exit;
		if(!$this->_modelExample->save($row)) {
			js_alert('保存失败','window.history.go(-1)');
			exit;
		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	//例出所有的生产计划，准备录入工序
	function actionList4Gongxu() {
		$this->authCheck('2-3');
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'isShezhi'=>0,
			'planCode' => '',
			'key' => '',
		)); 
		//已设置：工序和投料明细里都有plan2proId，否则为未设置 by wujinbin 2014-8-12
		// 取shengchan_plan2product_gongxu 表中的plan2proId数据
		$sql="select distinct plan2proId from shengchan_plan2product_gongxu ";
		$temp=$this->_modelExample->findBySql($sql);
		$temp=array_col_values($temp,'plan2proId');
	
		// 取shengchan_plan2product_touliao 表中的plan2proId数据
		$sql="select distinct plan2proId from shengchan_plan2product_touliao  ";
		$temp2=$this->_modelExample->findBySql($sql);
		$temp2=array_col_values($temp2,'plan2proId');

		//处理同时存在两个表中的id
		// $_temp=array_intersect($temp, $temp2);
		$_temp=array_unique(array_merge($temp, $temp2));
		// dump($_temp);dump($temp2);exit;
		//组成字符串，用于in查询
		$plan2proId = join(',',$_temp);
		$plan2proId=='' && $plan2proId="''";

		$sql = "select 
		x.planDate,x.planCode,x.overDate,x.overDateReal,x.planMemo,x.kind,
		y.*,
		z.proCode,z.proName,z.guige,z.pinzhong
		from shengchan_plan x
		left join shengchan_plan2product y on x.id=y.planId
		left join jichu_product z on y.productId=z.id
		where 1";

		$arr['planCode'] != '' && $sql .= " and x.planCode like '%{$arr['planCode']}%'";
		$arr['key'] != '' && $sql .= " and (z.pinzhong like '%{$arr['key']}%' or z.guige like '%{$arr['key']}%')";
		//通过in()来判断
		if($arr['isShezhi']==1)$sql.=" and y.id in({$plan2proId})";
		elseif($arr['isShezhi']==0)$sql.=" and y.id not in({$plan2proId})";
		
		$sql.= " order by id desc";
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 

		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = "<a href='".$this->_url('SetGongxu',array('id'=>$v['id']))."'>设置</a>";

			$arr['isShezhi']==0 && $v['_edit'] .="&nbsp;&nbsp;<input type='checkbox' name='plan2ProId[]' value='{$v['id']}' productId='".($v['productId'].','.$v['planId'])."'>";
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作','width'=>80),
			// 'kind'=>'计划类型',
			"planDate" => "日期",
			'planCode' => '计划单号',
			"planDate" => "开单日期",
			"overDate" => "计划完成时间",
			'overDateReal' => '实际完成时间',
			"planMemo" => '生产备注', 
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			// "productId" => '品种', 
			"guige" => '规格', 
			"color" => '颜色', 
			"cntShengchan" => '计划生产数量', 
		); 
		

		$smarty->assign('title', '生产工序设置');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		if($arr['isShezhi']==0){
			$smarty->assign('other_url', "<a href='javascript:SetPlanByMore()' id='thisUrl' url='".$this->_url('SetGongxu')."'>统一设置计划</a>");
			$smarty->assign('sonTpl', "Shengchan/Plan/SetTouliaoTpl.tpl");
		}
		
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	}

	function actionPrint() {
		$this->fldMain = array(
			'planCode' => array('title' => '计划单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode('JH','shengchan_plan','planCode')),
			// 'planCode' => array('title' => '订单日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'planDate' => array('title' => '计划日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'overDate' => array('title' => '计划完成日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'isOver' => array('title' => '是否完成', 'type' => 'select', 'value' =>0,'options'=>array(
				array('text'=>'否','value'=>0),
				array('text'=>'是','value'=>1),
			)),
			//相关订单的选择
			'orderId'=>array('title' => '相关订单', 'type' => 'orderpopup','value'=>''),
			// 定义了name以后，就不会以memo作为input的id了
			'planMemo'=>array('title'=>'生产备注','type'=>'textarea','disabled'=>true,'name'=>'planMemo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'planId'),
			); 
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnRemove', "title" => '+5行', 'name' => '_edit[]'),
			'productId' => array('type' => 'btproductpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'proName' => array('type' => 'bttext', "title" => '品名', 'name' => 'proName[]', 'readonly' => true),
			'guige' => array('type' => 'bttext', "title" => '规格', 'name' => 'guige[]', 'readonly' => true),
			// 'unit' => array('type' => 'bttext', "title" => '单位', 'name' => 'unit[]', 'readonly' => true),
			'cntShengchan' => array('type' => 'bttext', "title" => '数量', 'name' => 'cntShengchan[]'),
			// 'danjia' => array('type' => 'bttext', "title" => '单价', 'name' => 'danjia[]'),
			// 'money' => array('type' => 'bttext', "title" => '金额(元)', 'name' => 'money[]', 'readonly' => true),
			'memo' => array('type' => 'bttext', "title" => '备注', 'name' => 'memo[]'), 
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			// 'orderId' => array('type' => 'bthidden', 'name' => 'orderId[]'),
		); 
		// $m = & $this->_modelSon;
		// $rowset = $m->find($_GET['id']); s
		$row = $this->_modelExample->find(array('id'=>$_GET['planId']));
		// dump($row);
		foreach($row['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			// dump($v);dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
		} 
		//补齐5行
		$cnt = count($row['Products']);
		for($i=5;$i>$cnt;$i--) {
			$row['Products'][] = array();
		}
		// dump($row);exit;
		$main = array(
			'单号'=>$row['planCode'],
			'计划日期'=>$row['planDate'],
			'计划完成时间'=>$row['overDate'],
			// '相关订单'=>$row['Order']['orderCode'],
			// '送货单号'=>$row['songhuoCode'],
			// '单号'=>,
			// '单号'=>,
			// '单号'=>,
		);
		$smarty = &$this->_getView();
		$smarty->assign("arr_main_value", $main);
		$smarty->assign("arr_field_info", array(
			// "_edit" => '操作',
			// "rukuDate" => "入库日期",
			// 'rukuCode' => array("text"=>'入库单号','width'=>150),
			// "kind" => "类别",
			// 'kuwei' => '库位',
			// 'proKind' => '种类',
			'proCode' => '产品编码',
			'proName' => '品名',
			'guige' => '规格',
			'cntShengchan'=>'计划生产',
			// 'color' => '颜色',
			'memo' => '备注', 
			// 'danjia' => '单价', 
			// 'money' => '金额', 
			// // "compName" => "供应商",
			// // 'songhuoCode' => '送货单号',
			// 'memo' => '备注'
		));
		$smarty->assign("arr_field_value", $row['Products']);
		$smarty->display('Print.tpl');
	}

	function actionSetGongxu() {
		$this->authCheck('2-3');
		$id=explode(',',$_GET['id']);
		$row = $this->_modelPro->find(array('id'=>$id[0]));

		//如果$id是多个，需要计算合计
		if(count($id)>1){
			$sql="select sum(cntShengchan) as cntShengchan,group_concat(color) as color from shengchan_plan2product where id in ({$_GET['id']})";
			$temp = $this->_modelPro->findBySql($sql);
			$row['cntShengchan'] = $temp[0]['cntShengchan'];
			$row['color'] = $temp[0]['color'];
		}
		// dump($row);exit;
		/**
		* 设置工序信息
		* 
		*/
		//得到工序明细
		$sql  = "select * from shengchan_plan2product_gongxu where plan2proId='{$_GET['id']}' order by orderLine";
		$gx = $this->_modelExample->findBySql($sql);
		// dump($gx);exit;
		if($row['Plan']['kind']=='成布'){
			$temp_arr=array('pinzhong' => array('title' => '品种', 'type' => 'text', 'value' =>$row['Product']['pinzhong'],'readonly'=>true));
		}else{
			$temp_arr=array(
				'zhonglei' => array('title' => '成分', 'type' => 'text', 'value' =>$row['Product']['zhonglei'],'readonly'=>true),
			'proName' => array('title' => '纱支', 'type' => 'text', 'value' =>$row['Product']['proName'],'readonly'=>true));
		}
		//主信息
		$fMain = array(
			'planCode' => array(
				'title'=>'计划单号', "type"=>"text", 'readonly'=>true, 'value'=>$row['Plan']['planCode'],'readonly'=>true),
				'planDate' => array('title' => '计划日期', 'type' => 'text', 'value' => $row['Plan']['planDate'],'readonly'=>true),
				'proCode' => array('title' => '产品编号', 'type' => 'text', 'value' => $row['Product']['proCode'],'readonly'=>true),
				)+$temp_arr+array(
				'guige' => array('title' => '规格', 'type' => 'text', 'value' => $row['Product']['guige'],'readonly'=>true),
				'color' => array('title' => '颜色', 'type' => 'text', 'value' => $row['color'],'readonly'=>true),
				'menfu' => array('title' => '门幅', 'type' => 'text', 'value' => $row['menfu'],'readonly'=>true,'addonEnd'=>'M'),
				'kezhong' => array('title' => '克重', 'type' => 'text', 'value' => $row['kezhong'],'readonly'=>true,'addonEnd'=>'(g/m<sup>2</sup>)'),
				'cntShengchan' => array('title' => '计划数', 'type' => 'text', 'value' => $row['cntShengchan'],'readonly'=>true,'addonEnd'=>'Kg'),
				'plan2proId' => array('type' => 'hidden', 'value' => $_GET['id']),
		); 
		//明细信息
		$gongxu = &FLEA::getSingleton('Model_Jichu_gongxu');
		$jgh = &FLEA::getSingleton('Model_Jichu_jiagonghu');
		$fSon = array(
			'_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
			// '_edit' => array('type' => 'btCheckbox', "title" => '选择', 'name' => 'sel[]'),
			'gongxuName' => array('type' => 'btselect', "title" => '工序', 'name' => 'gongxuName[]','options'=>$gongxu->getOptions(array('valueKey'=>'itemName'))),
			// 'jitaiId'=>array('type' => 'btselect', "title" => '机台号', 'name' => 'jitaiId[]','model'=>'Model_Jichu_jitai'),
			'jiagonghuId'=>array('type' => 'btselect', "title" => '加工户', 'name' => 'jiagonghuId[]','model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=0'),
			'cnt' => array('title' => '数量', 'type' => 'bttext', 'value' =>'','name'=>'cnt[]'),
			'dateFrom' => array('type' => 'btCalendarInTbl', "title" => '开始日期', 'name' => 'dateFrom[]'),
			'dateTo' => array('type' => 'btCalendarInTbl', "title" => '截止日期', 'name' => 'dateTo[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			// 'gongxuId' => array('type' => 'bthidden', 'name' => 'gongxuId[]'),
			// 'chk' => array('type' => 'bthidden', 'name' => 'chk[]'),//选中后关联修改值，为了提交时能得到哪些被选中了
		); 

		//设置明细信息，如果已设置工序，则显示工序信息，否则显示所有工序项提供选择
		$r = array();
		if($gx){
			// dump($gx);exit;
			foreach($gx as &$vv) {
				$temp=array();
				$temp['id']['value'] = $vv['id'];
				$temp['gongxuName']['value'] = $vv['gongxuName'];
				$temp['cnt']['value'] = $vv['cnt'];
				$temp['dateFrom']['value'] = $vv['dateFrom'];
				$temp['dateTo']['value'] = $vv['dateTo'];
				$temp['jiagonghuId']['value'] = $vv['jiagonghuId'];

				$r[] = $temp;
			}			
		}else{
			//取得工序信息
			$sql = "select *,itemName as gongxuName from jichu_gongxu where 1";
			$rowset = $this->_modelPro->findBySql($sql);

			//获取产品信息
			$sql="select * from jichu_product_gongxu where proId='{$row['productId']}'";
			$proGx = $this->_modelPro->findBySql($sql);
			// dump($proGx);exit;
			
			foreach($rowset as $k=>& $v) {
				$temp = array(
					'_edit'=>array('value'=>$k,'title'=>''),//注意这里的value,在提交时可以用来判断哪些被选择了
					// 'gongxuId'=>array('value'=>$v['id']),
					'id'=>array('value'=>''),
					'gongxuName'=>array('value'=>$proGx[$k]['gongxuName']),
					'dateFrom'=>array('value'=>date('Y-m-d')),
					'dateTo'=>array('value'=>''),
					'jiagonghuId'=>array('value'=>''),
					// 'jitaiId'=>array('value'=>''),
				);

				$r[] = $temp;
			}
		}
		// dump($r);exit;

		/**
		* 设置投料计划信息
		*/
		//查询默认需要显示的投料信息
		$isYishe = false;
		if($row['Plan2Touliao']){
			$dataTouliao=$row['Plan2Touliao'];
			$isYishe = true;
		}else{
			$sql="select * from jichu_product_chengfen where proId='{$row['productId']}'";
			$dataTouliao = $this->_modelPro->findBySql($sql);
		}
		// dump($dataTouliao);exit;
		$touliao = $this->_setTouliao($dataTouliao , $isYishe ,$row['cntShengchan']);
		$qitaSon = $touliao['qitaSon'];
		$row4sSon = $touliao['row4sSon'];

		/**
		* 引入模板
		*/
		$smarty = &$this->_getView();
		$areaMain = array('title' => '产品基本信息', 'fld' => $fMain); 
		$smarty->assign('areaMain', $areaMain);
		
		$smarty->assign('headSon', $fSon);
		$smarty->assign('rowsSon', $r);
		$smarty->assign('action_save', 'saveGongxu');
		$smarty->assign('RemoveByAjax', 'RemoveGxByAjax'); 
		$smarty->assign('qitaSon',$qitaSon);
		$smarty->assign('otherInfo','投料计划设置');
	    $smarty->assign('row4sSon',$row4sSon);
	    // $smarty->assign('tbl_other_width','110%');
	    $smarty->assign("otherInfoTpl",'Main2Son/OtherInfoTpl.tpl');
	    $sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/sonTpl.tpl'
		);
	    $smarty->assign("sonTpl",$sonTpl);
		$smarty->display('Main2Son/T1.tpl');
		
	}

	/**
	* 设置投料计划需要显示的界面信息
	*/
	function _setTouliao($data , $isYishe=false ,$cnt=0){
		$jgh = &FLEA::getSingleton('Model_Jichu_jiagonghu');
		$qitaSon = array(
			'_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
			'productId' => array('type' => 'btproductpopup', "title" => '纱支选择', 'name' => 'productId[]'),
			// 'zhonglei'=>array('type'=>'bttext',"title"=>'成分','name'=>'zhonglei[]','readonly'=>true),
		    'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
		    'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
		    'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
		    'supplierId'=>array('type' => 'btselect', "title" => '供应商', 'name' => 'supplierId[]','model' => 'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1','inTable'=>true),
		    'chengfenPer'=>array('type'=>'bttext',"title"=>'比列(%)','name'=>'chengfenPer[]'),
		    'sunhao'=>array('type'=>'bttext',"title"=>'损耗(%)','name'=>'sunhao[]'),
		    'cntKg'=>array('type'=>'bttext',"title"=>'计划投料(Kg)','name'=>'cntKg[]'),
		    'memoView'=>array('type'=>'bttext',"title"=>'备注','name'=>'memoView[]'),
		    'id'=>array('type'=>'bthidden','name'=>'qtid[]'),
		);

		//处理数据
		foreach ($data as $key => & $v) {
			$r=array();
			//查找纱支信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$shazhi = $this->_modelExample->findBySql($sql);
			$shazhi = $shazhi[0];
			$v['zhonglei']=$shazhi['zhonglei'];
			$v['proName']=$shazhi['proName'];
			$v['guige']=$shazhi['guige'];
			// $v['color']=$shazhi['color'];

			if(!$isYishe){
				$r=array(
					'productId'=>array('value'=>$v['productId']),
					'zhonglei'=>array('value'=>$shazhi['zhonglei']),
					'proName'=>array('value'=>$shazhi['proName']),
					'guige'=>array('value'=>$shazhi['guige']),
					'color'=>array('value'=>$v['color']),
					'chengfenPer'=>array('value'=>$v['chengfenPer']),
					'cntKg'=>array('value'=>$v['chengfenPer']/100*$cnt),
				);
			}else{
				foreach($qitaSon as $kk => &$vv) {
			        $r[$kk] = array('value' => $v[$kk]);
			     }
			}

			$row4sSon[]=$r;
		}

		while (count($qitaSon)<5) {
			$qitaSon[]=array();
		}
		while (count($row4sSon)<5) {
			$row4sSon[]=array();
		}
		return array('qitaSon'=>$qitaSon,'row4sSon'=>$row4sSon);
	}

	/**
	* 保存工序与投料计划
	*/
	function actionSaveGongxu() {
		// dump($_POST);exit;
		//先删除之前保存的所有的工序,再重新生成工序记录
		$p = $_POST;

		//判断是否需要拆分（当选择多个计划明细的时候，系统需要自动拆分）
		$plan2proId = explode(',',$p['plan2proId']);
		
		$rowset = array();
		$rowtouliao = array();
		foreach ($plan2proId as $key2pro => $v2pro) {
			//查找该计划明细的计划生产数量
			$sql="select cntShengchan from shengchan_plan2product where id='{$v2pro}'";
			$temp = $this->_modelPro->findBySql($sql);
			$bilie = $temp[0]['cntShengchan']/$p['cntShengchan'];


			foreach($p['gongxuName'] as $k=>& $v) {
				if(empty($v) || empty($p['cnt'][$k]))continue;
				$rowset[] = array(
					'id'=>$p['id'][$k],
					'plan2proId'=>$v2pro,
					'gongxuName'=>$p['gongxuName'][$k],
					'orderLine'=>$k,
					'dateFrom'=>$p['dateFrom'][$k],
					'dateTo'=>$p['dateTo'][$k],
					// 'jitaiId'=>$p['jitaiId'][$k],
					'jiagonghuId'=>$p['jiagonghuId'][$k],
					'cnt'=>$p['cnt'][$k]*$bilie,
				);
			}
			
			/**
			* 处理投料信息，进行保存
			*/
			
			foreach($p['productId'] as $k=>& $v) {
				if(empty($v) || empty($p['cntKg'][$k]))continue;
				$rowtouliao[] = array(
					'id'=>$p['qtid'][$k],
					'plan2proId'=>$v2pro,
					'productId'=>$p['productId'][$k],
					'orderLine'=>$k,
					'color'=>$p['color'][$k],
					'sunhao'=>$p['sunhao'][$k],
					'cntKg'=>$p['cntKg'][$k]*$bilie,
					'chengfenPer'=>$p['chengfenPer'][$k],
					'supplierId'=>$p['supplierId'][$k],
					'memoView'=>$p['memoView'][$k],
				);
			}
		}
		// dump($rowset);
		// dump($rowtouliao);exit;
		$m = & FLEA::getSingleton('Model_Shengchan_Plan2Gongxu');
		$mm = & FLEA::getSingleton('Model_Shengchan_Plan2Touliao');
		$m->saveRowset($rowset);
		$mm->saveRowset($rowtouliao);
		if(!$m) {
			js_alert('保存失败!',null,$this->_url('List4gongxu'));
			exit;
		}
		js_alert(null,'window.parent.showMsg("保存成功!")',$this->_url('List4gongxu'));
	}

	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 */
	function actionPopup() {
		// $this->authCheck('1-2');
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'orderCode' => '',
			'planCode' => '',
			'kind'=>'',
		)); 
		$sql = "select 
		y.*,
		x.planCode,x.planDate,
		a.pinzhong,a.proCode,a.guige,z.orderCode
		from shengchan_plan x
		inner join shengchan_plan2product y on x.id=y.planId
		left join trade_order z on x.orderId=z.id
		left join jichu_product a on y.productId=a.id
		where 1";
		$arr['orderCode'] != '' && $sql .= " and z.orderCode like '%{$arr['orderCode']}%'";
		$arr['planCode'] != '' && $sql .= " and x.planCode like '%{$arr['planCode']}%'";
		// $arr['kind'] != '' && $sql .= " and x.kind='{$arr['kind']}'";
		$sql .= " order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		/*if (count($rowset) > 0) foreach($rowset as &$v) {
			
		} */
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			'planCode' => '计划单号',
			"planDate" => "开单日期",
			"orderCode" => "订单编号",
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色', 
			"cntShengchan" => '计划生产数量', 
		); 
		

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar'))); 
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 * 弹出工序信息供选择
	 */
	function actionPopupGx() {
		// $this->authCheck('1-2');
		FLEA::loadClass('TMIS_Pager'); 
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'jiagonghuId'=>'',
			'orderCode' => '',
			'planCode' => '',
			'gongxuName' => '',
			'key' => '',
			'kind'=>'',
		)); 
		$sql = "select 
		y.*,
		x.planCode,x.planDate,
		a.pinzhong,a.proCode,a.guige,z.orderCode,b.gongxuName,b.cnt,b.id as plangxId,e.compName
		from shengchan_plan x
		inner join shengchan_plan2product y on x.id=y.planId
		left join trade_order z on x.orderId=z.id
		left join jichu_product a on y.productId=a.id
		inner join shengchan_plan2product_gongxu b on b.plan2proId=y.id
		left join jichu_jiagonghu e on e.id = b.jiagonghuId
		where 1";

		$arr['orderCode'] != '' && $sql .= " and z.orderCode like '%{$arr['orderCode']}%'";
		$arr['planCode'] != '' && $sql .= " and x.planCode like '%{$arr['planCode']}%'";
		$arr['key'] != '' && $sql .= " and (a.pinzhong like '%{$arr['key']}%' or a.guige like '%{$arr['key']}%' or y.color like '%{$arr['key']}%')";
		$arr['gongxuName'] != '' && $sql .= " and b.gongxuName like '%{$arr['gongxuName']}%'";
		$arr['jiagonghuId'] >0 && $sql .= " and b.jiagonghuId = '{$arr['jiagonghuId']}'";
		// $arr['kind'] != '' && $sql .= " and x.kind='{$arr['kind']}'";
		$sql .= " order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['codeAndGx'] = $v['planCode'];//.','.$v['gongxuName'];
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			// 'id'=>'id',
			// 'plangxId'=>'plangxId',
			'planCode' => '计划单号',
			"planDate" => "开单日期",
			"orderCode" => "订单编号",
			'compName'=>'加工户',
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色', 
			'gongxuName'=>'工序名称',
			"cnt" => '计划数量', 
		); 
		

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar'))); 
		$smarty->display('Popup/CommonNew.tpl');
	}


	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 * 弹出投料计划信息供选择
	 */
	function actionPopupTl() {
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'orderCode' => '',
			'planCode' => '',
			'kind'=>'',
			'key'=>'',
			'gongxuKey'=>'',
			'shaKind'=>'',
			'_type'=>'',
		));

		//查找符合前工序发料的信息
		//该工序计划需要有 “纱线染色”
		//该纱的类别应该是 “棉纱”
		if($arr['_type'] == '前工序发料'){
			$sql="select plan2proId from shengchan_plan2product_gongxu where gongxuName = '{$arr['gongxuKey']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$plan2proId = join(',',array_col_values($temp,'plan2proId'));
			if($plan2proId!='')$where = " and y.id in ({$plan2proId})";
			else $where = " and 0";
		}

		$sql = "select 
		y.id,y.planId,x.planCode,x.planDate,z.orderCode,b.cntKg,b.id as planTlId,b.productId,a.compName,b.supplierId,b.color,b.plan2proId,y.productId as proId
		from shengchan_plan x
		inner join shengchan_plan2product y on x.id=y.planId
		left join trade_order z on x.orderId=z.id
		inner join shengchan_plan2product_touliao b on b.plan2proId=y.id
		left join jichu_jiagonghu a on a.id=b.supplierId
		left join jichu_product c on c.id=y.productId
		where 1";

		$arr['orderCode'] != '' && $sql .= " and z.orderCode like '%{$arr['orderCode']}%'";
		$arr['planCode'] != '' && $sql .= " and x.planCode like '%{$arr['planCode']}%'";
		$arr['key'] != '' && $sql .= " and (c.pinzhong like '%{$arr['key']}%' or c.guige like '%{$arr['key']}%')";
		if($arr['_type']=='前工序发料' && $arr['shaKind']!='')$sql .= " and c.kind='{$arr['shaKind']}'";
		$sql.=$where;
		$sql .= " order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		if (count($rowset) > 0) foreach($rowset as &$v) {
			//查找纱的基本信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['Product']=$temp[0];

			//查找最终生产布的基本信息
			$sql="select * from jichu_product where id='{$v['proId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['_Product']=$temp[0];
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			// 'id'=>'id',
			'planCode' => '计划单号',
			"planDate" => "开单日期",
			"orderCode" => "订单编号",
			// "Product.proCode" => '产品编号', 
			// "Product.zhonglei" => '成分', 
			"Product.proName" => '纱支', 
			// "guige" => '规格', 
			"color" => '颜色',
			"_Product.pinzhong" => '品种',
			"_Product.guige" => '规格',
			'compName'=>'供应商',
			"cntKg" => '计划投料', 
		); 
		

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		// $smarty->assign('arr_js_css', $this->makeArrayJsCss(array('grid', 'calendar'))); 
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	* 根据明细数据得到投料信息
	*/
	function actionGetTouliaoByAjax(){
		$id = (int)$_GET['plan2proId']+0;
		//查找投料计划信息
		$str="select x.* from shengchan_plan2product_touliao x where 1 and x.plan2proId='{$id}'";
		$row = $this->_modelPro->findBySql($str);
		foreach($row as & $vv){
			$str="select * from jichu_product where id='{$vv['productId']}'";
			$temp = $this->_modelPro->findBySql($str);
			$vv['Product']=$temp[0];
		}
		echo json_encode(array('success'=>count($row)>0,'Touliao'=>$row,'msg'=>'未发现生产计划的投料信息!'));
	}

	//修改界面中ajax删除 
	function actionRemoveByAjax() {
		$id=$_POST['id'];
		$r = $this->_modelPro->removeByPkv($id);
		if(!$r) {
			// js_alert('删除失败');
			echo json_encode(array('success'=>false,'msg'=>'删除失败'));
			exit;
		}
		echo json_encode(array('success'=>true));
		// js_alert(null,'window.parent.showMsg("操作成功")')
	}

	//修改界面中ajax删除 
	function actionRemoveGxByAjax() {
		$id=$_POST['id'];
		$mm = & FLEA::getSingleton('Model_Shengchan_Plan2Gongxu');
		$r = $mm->removeByPkv($id);
		if(!$r) {
			echo json_encode(array('success'=>false,'msg'=>'删除失败'));
			exit;
		}
		echo json_encode(array('success'=>true));
	}

	//修改界面中ajax删除 
	function actionRemoveQitaByAjax() {
		$id=$_POST['id'];
		$mm = & FLEA::getSingleton('Model_Shengchan_Plan2Touliao');
		$r = $mm->removeByPkv($id);
		if(!$r) {
			echo json_encode(array('success'=>false,'msg'=>'删除失败'));
			exit;
		}
		echo json_encode(array('success'=>true));
	}

	//删除
	function actionRemove(){
		$this->authCheck('2-5');
		parent::actionRemove();
	}

	/**
	* 查看工序明细信息
	*/
	function actionViewGongxu(){
		$m = &FLEA::getSingleton('Model_Shengchan_Plan2Gongxu');
		$m->clearLinks();
		$condition['in()']=array('touliaoId'=>explode(',', $_GET['touliaoId']));
		$rowset = $m->findAll($condition);
		//dump($rowset);exit;
		foreach ($rowset as $key => &$v) {
			//查找加工户信息
			//dump($v);exit;
			$sql="select compName from jichu_jiagonghu where id='{$v['jiagonghuId']}'";
			$jgh = $m->findBySql($sql);
			$v['compName'] = $jgh[0]['compName'];
			$v['_edit']="<a href='".$this->_url("PrintJihuadan",array(
				"id"=>$v['id'],
				))."' target='_blank'>打印</a>";;
		}

		$arrFieldInfo=array(
			"gongxuName" => '工序',
			"compName" => '加工户', 
			"cnt" => '数量',
			"dateFrom" => '开始日期',
			"dateTo" => '结束日期',
			"_edit"=>'操作'	
		);
		$smarty= & $this->_getView();
		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->display('TblList.tpl');
	}

	/**
	 * 打印生产计划单
	 * @author shirui
	 */
	function actionPrintJihuadan(){
		$id=$_GET['id'];
		//dump($id);exit;
		
		//取得生产计划单的公共部分
		$sql="select y.gongxuName,a.orderCode,b.compName,c.planCode,x.planId,c.planMemo
		from shengchan_plan2product_gongxu y
		left join (select touliaoId,plan2proId from shengchan_plan_touliao2product group by touliaoId) f on f.touliaoId=y.touliaoId
		left join shengchan_plan2product x on x.id=f.plan2proId
		left join jichu_jiagonghu b on b.id=y.jiagonghuId
		left join shengchan_plan c on c.id=x.planId
		left join trade_order a on a.id=c.orderId
		where y.id='{$id}'";
		$row=$this->_modelExample->findBySql($sql);
		// dump($row);exit;
		$rt=array();
		foreach ($row as & $v){
			$rt['gongxuName']=$v['gongxuName'];
			$rt['orderCode']=$v['orderCode'];
			$rt['compName']=$v['compName'];
			$rt['planCode']=$v['planCode'];
			$rt['planId']=$v['planId'];
			$rt['planMemo']=$v['planMemo'];
		}
		//dump($rt);exit;
		
		
		//取得生产计划单的具体明细
		$sql="select z.proCode,z.pinzhong,
		x.color,x.menfu,x.kezhong,y.cntYaohuo,x.cntShengchan,x.pibuCnt,x.memo,'Kg' as unit ,y.dateJiaohuo
		from shengchan_plan2product x
		left join trade_order2product y on y.id=x.ord2proId
		left join jichu_product z on x.productId=z.id
		where x.planId='{$rt['planId']}'";
		$ret=$this->_modelExample->findBySql($sql);
		//dump($ret);exit;
		
		//传递数据
		$smarty= & $this->_getView();
		$smarty->assign('title', '明细打印');
		$smarty->assign('rt', $rt);
		$smarty->assign('ret', $ret);
		$smarty->display('Shengchan/shengchan.tpl');	
		
	}
	
	
	
	/**
	* 查看投料计划明细信息
	*/
	function actionViewPer(){
		$m = &FLEA::getSingleton('Model_Shengchan_Plan2Touliao');
		$m->clearLinks();
		$condition['in()']=array('touliaoId'=>explode(',', $_GET['touliaoId']));
		$rowset = $m->findAll($condition);
		// dump($condition);exit;
		foreach ($rowset as $key => &$v) {
			//查找加工户信息
			$sql="select compName from jichu_jiagonghu where id='{$v['supplierId']}'";
			$jgh = $m->findBySql($sql);
			$v['compName'] = $jgh[0]['compName'];

			//查找纱支信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$shazhi = $this->_modelExample->findBySql($sql);
			$shazhi = $shazhi[0];
			$v['kind']=$shazhi['kind'];
			$v['proCode']=$shazhi['proCode'];
			$v['zhonglei']=$shazhi['zhonglei'];
			$v['proName']=$shazhi['proName'];
			$v['guige']=$shazhi['guige'];
			// $v['color']=$shazhi['color'];
		}

		$arrFieldInfo=array(
			'kind'=>'种类',
			"proCode" =>"产品编码",
		    // "zhonglei" =>"成分",
		    "proName" =>"纱支",
		    "guige" =>"规格",
		    "color" => "颜色",
			"compName" => '供应商', 
			"chengfenPer" => '比例(%)',
			"sunhao" => '损耗(%)',
			"cntKg" => '计划数(Kg)',
			"memoView" => '备注',
		);
		$smarty= & $this->_getView();
		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->display('TblList.tpl');
	}

	/**
	 * 获取某个计划的投料计划信息，如果没有投料计划，则获取基础档案中默认的投料计划信息
	 * Time：2014/08/15 13:41:58
	 * @author li
	 * @param GET['plan2proId'] int (生产计划明细表id)
	 * @param GET['productId'] int (产品档案id)
	 * @return JSON:投料计划信息 Array
	*/
	function actionGetTouliaoInfoByAjax(){
		//传递过来的参数信息
		$planGxId = (int)$_GET['planGxId'];
		$productId = (int)$_GET['productId'];
		// $color = $_GET['color'];

		//查找工序信息
		$sql="select touliaoId from shengchan_plan2product_gongxu where id='{$planGxId}'";
		$__t = $this->_modelPro->findBySql($sql);
		//如果生产计划中存在投料计划，则优先取投料计划中的信息
		$sql="select x.*,y.touliaoCode from shengchan_plan2product_touliao x
		left join shengchan_plan_touliao y on x.touliaoId=y.id 
		where x.touliaoId='{$__t[0]['touliaoId']}'";
		$touliao = $this->_modelPro->findBySql($sql);
		//生产计划中不存在投料计划，取产品档案中的投料计划
		if(!count($touliao)>0){
			$sql="select *,0 as sunhao from jichu_product_chengfen where proId = '{$productId}'";
			$touliao = $this->_modelPro->findBySql($sql);
		}

		//处理获取到的投料比列信息
		foreach ($touliao as $k => & $v) {
			//查找投料信息纱的基本信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['Product']=$temp[0];
		}

		//传递json
		echo json_encode(array(
				'success'=>count($touliao)>0,
				'data'=>$touliao,
				'rowLen'=>count($touliao)
			));
		exit;
	}

	/**
	 * 获取多个计划的投料计划信息，如果没有投料计划，则获取基础档案中默认的投料计划信息
	 * Time：2014/08/15 13:41:58
	 * @author li
	 * @param GET['plan2proId'] int (生产计划明细表id)
	 * @param GET['productId'] int (产品档案id)
	 * @return JSON:投料计划信息 Array
	*/
	function actionGetTouliaoInfoAllByAjax(){
		//传递过来的参数信息
		// dump($_GET);exit;
		$get = $_GET['param'];
		$temp=array();
		//把工序id,productId完全相同的汇总一起
		foreach ($get as $key => & $g) {
			$temp[$g['productId'].','.$g['planGxId']]['productId'] = $g['productId'];
			$temp[$g['productId'].','.$g['planGxId']]['planGxId'] = $g['planGxId'];
			$temp[$g['productId'].','.$g['planGxId']]['cnt'] += $g['cnt'];
		}

		$get=$temp;

		$_touliaoInfo = array();
		foreach ($get as $key => & $g) {
			//查找工序信息
			$sql="select touliaoId from shengchan_plan2product_gongxu where id='{$g['planGxId']}'";
			$__t = $this->_modelPro->findBySql($sql);

			//如果生产计划中存在投料计划，则优先取投料计划中的信息
			$sql="select x.*,y.touliaoCode from shengchan_plan2product_touliao x
			left join shengchan_plan_touliao y on x.touliaoId=y.id 
			where x.touliaoId='{$__t[0]['touliaoId']}'";
			$touliao = $this->_modelPro->findBySql($sql);
			//生产计划中不存在投料计划，取产品档案中的投料计划
			if(!count($touliao)>0){
				$sql="select * from jichu_product_chengfen where proId = '{$g['productId']}'";
				$touliao = $this->_modelPro->findBySql($sql);
			}

			foreach ($touliao as & $v) {
				$v['planGxId'] = $g['planGxId'];
				$_k = $v['planGxId'].','.$v['productId'].','.$v['color'].','.$v['supplierId'];

				$cnt = round($g['cnt']*$v['chengfenPer']/100*(1+$v['sunhao']/100),2);
				$v['cntTl'] = $cnt;

				if(isset($_touliaoInfo[$_k])){
					$_touliaoInfo[$_k]['cntTl']+=$v['cntTl'];
				}else{
					$_touliaoInfo[$_k] = $v;
				}
			}

		}

		//处理获取到的投料比列信息
		$_temp=array();
		foreach ($_touliaoInfo as $k => & $v) {
			//查找投料信息纱的基本信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['Product']=$temp[0];
			$_temp[]=$v;
		}
		$_touliaoInfo=$_temp;

		//传递json
		echo json_encode(array(
				'success'=>count($_touliaoInfo)>0,
				'data'=>$_touliaoInfo,
				'rowLen'=>count($_touliaoInfo)
			));
		exit;
	}
	
	/**
	 * 订单跟踪报表中需要获取生产计划中的信息
	 * Time：2014/08/28 13:43:04
	 * @author li
	 * @param GET
	 * @return JSON
	*/
	function actionGetInfoByPlan2proId(){
		$plan2proId=(int)$_GET['plan2proId'];

		//查找对应的工序明细id
		$sql="select group_concat(x.id) as gongxuId from shengchan_plan2product_gongxu x
			left join shengchan_plan_touliao2product y on x.touliaoId=y.touliaoId
			where 1 and y.plan2proId = '{$plan2proId}'";

		$temp = $this->_modelExample->findBySql($sql);
		$gongxuId = $temp[0]['gongxuId'];
		if($gongxuId=='')$gongxuId='null';

		/*
		* 查找工序进度，损耗信息
		*/
		//查询所有的验收记录，领料记录
		$sql="select z.type as YsType,z.kind as ysKind,sum(x.cnt) as cntYs,z.jiagonghuId,x.planGxId,y.compName,x.plan2proId
			from cangku_ruku_son x
			left join cangku_ruku z on z.id=x.rukuId
		 	left join jichu_jiagonghu y on y.id=z.jiagonghuId
		 	where x.planGxId in({$gongxuId}) and z.isJiagong=1
		 	group by z.jiagonghuId,x.planGxId";
		// dump($sql);exit;
		$res = $this->_modelPro->findBySql($sql);
		
		//查找所有的领料记录
		$sql="select z.type,z.kind,sum(x.cnt) as cntTl,z.jiagonghuId,x.planGxId,y.compName,x.plan2proId
			from cangku_chuku_son x
			left join cangku_chuku z on z.id=x.chukuId
		 	left join jichu_jiagonghu y on y.id=z.jiagonghuId
		 	where x.planGxId in({$gongxuId}) and z.isJiagong=1
		 	group by z.jiagonghuId,x.planGxId";
		$res2 = $this->_modelPro->findBySql($sql);

		//处理数据
		$res=array_merge($res,$res2);
		// dump($res);exit;
		$gxInfo=array();
		foreach ($res as & $v) {
			//加载数据
			$key = $v['planGxId'].','.$v['jiagonghuId'];
			$gxInfo[$key]['cntYs'] += $v['cntYs'];
			$gxInfo[$key]['cntTl'] += $v['cntTl'];
			$gxInfo[$key]['compName'] = $v['compName'].'';
			$gxInfo[$key]['planGxId'] = $v['planGxId'];
			$gxInfo[$key]['jiagonghuId'] = $v['jiagonghuId'];
			$gxInfo[$key]['kind'] = $v['kind'];
			$gxInfo[$key]['type'] = $v['type'];
			$gxInfo[$key]['ysKind'] = $v['ysKind'];
			$gxInfo[$key]['YsType'] = $v['YsType'];
		}

		//计算损耗信息
		foreach ($gxInfo as & $v) {
			$v['cntYs'] = round($v['cntYs'],2);
			$v['cntTl'] = round($v['cntTl'],2);
			$v['sunhao']=round(($v['cntTl']-$v['cntYs'])/$v['cntTl'],4)*100;

			//查找工序信息
			$sql="select * from shengchan_plan2product_gongxu where id='{$v['planGxId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$t=$temp[0];
			$v['gongxuName']=$t['gongxuName'].'';
			

			$v['cntYs'] = "<a href='".$this->_url('ListYsView',array(
				'plan2proId'=>$v['plan2proId'],
				'planGxId'=>$v['planGxId'],
				'jiagonghuId'=>$v['jiagonghuId'],
				'no_edit'=>1,
			))."' class='openDialog' width='90%' title='验收明细'>{$v['cntYs']}</a>";

			$v['cntTl'] = "<a href='".$this->_url('ListTlView',array(
				'planGxId'=>$v['planGxId'],
				'plan2proId'=>$v['plan2proId'],
				'jiagonghuId'=>$v['jiagonghuId'],
				'no_edit'=>1,
			))."' class='openDialog' width='90%' title='投料明细'>{$v['cntTl']}</a>";

		}
		sort($gxInfo);//重新组织键值，数字类型的键值
		$gxInfo=array_column_sort($gxInfo,'planGxId');


		/*
		* 查找投料信息，纱的投料情况
		*/

		//投料计划需要投料的信息
		$model = & FLEA::getSingleton('Model_Shengchan_Plan2Touliao');
		$sql="select x.* from shengchan_plan2product_touliao x
			left join shengchan_plan_touliao2product y on x.touliaoId=y.touliaoId
			where 1 and y.plan2proId = '{$plan2proId}'";

		$tlPlan = $model->findBySql($sql);

		//实际投料的信息
		$sql="select sum(x.cnt) as cnt,x.productId,x.color,y.type,y.kind
			from cangku_chuku_son x
			left join cangku_chuku y on x.chukuId=y.id
			where y.type='纱' and y.kind='织布领料' and x.planGxId in ({$gongxuId})
			group by x.productId,x.color";
		$tlHave = $this->_modelExample->findBySql($sql);

		// dump($tlPlan);dump($sql);
		$allInfo=array_merge($tlPlan,$tlHave);
		// dump($allInfo);
		foreach ($allInfo as & $v) {
			$key = $v['productId'].','.$v['color'];

			$tlInfo[$key]['color']=$v['color'];
			$tlInfo[$key]['productId']=$v['productId'];
			$tlInfo[$key]['tlId']=$v['id'];
			$tlInfo[$key]['type']=$v['type'];
			$tlInfo[$key]['kind']=$v['kind'];
			$tlInfo[$key]['sunhao']=round($v['sunhao'],2);
			$tlInfo[$key]['cntKg'] += round($v['cntKg'],2);
			$tlInfo[$key]['cnt'] += round($v['cnt'],2);
		}

		foreach ($tlInfo as & $v) {
			//查找工序信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$t=$temp[0];
			$v['proCode']=$t['proCode'].'';
			$v['proName']=$t['proName'].'';
			$v['guige']=$t['guige'].'';

			$v['cnt2']=$v['cnt'];

			$v['cnt'] = "<a href='".$this->_url('ListTlView',array(
				'plan2proId'=>$plan2proId,
				'planGxId'=>$gongxuId,
				'productId'=>$v['productId'],
				'color'=>$v['color'],
				'type'=>$v['type'],
				'kind'=>$v['kind'],
				'no_edit'=>1,
			))."' class='openDialog' width='90%' title='投料明细'>{$v['cnt']}</a>";
		}
		sort($tlInfo);//重新组织键值，数字类型的键值
		$tlInfo=array_column_sort($tlInfo,'tlId');
		if(count($tlInfo)>0){
			$heji=$this->getHeji($tlInfo,array('cnt2','cntKg'),'proCode');
			$heji['cnt']=$heji['cnt2'];
			$heji['proCode'].='';
			$heji['proName'].='';
			$heji['guige'].='';
			$heji['color'].='';
			$tlInfo[]=$heji;
		}
		
		// dump($gxInfo);exit;
		echo json_encode(array(
				'gxInfo'=>$gxInfo,
				'tlInfo'=>$tlInfo,
			));
	}

	/**
	 * 查找生产跟踪，工序投料验收信息明细
	 * 投料信息明细信息列表
	 * Time：2014/08/29 14:59:43
	 * @author li
	*/
	function actionListTlView(){
		FLEA::loadClass('TMIS_Pager');
		$arr = $_GET;
		$sql="select x.*,y.chukuCode,y.chukuDate,y.kind,y.type,z.kuweiName,a.pinzhong,a.guige,a.proName,a.proCode,b.compName
		from cangku_chuku_son x
		left join cangku_chuku y on y.id = x.chukuId
		left join jichu_kuwei z on z.id=y.kuweiId
		left join jichu_product a on a.id=x.productId
		left join jichu_jiagonghu b on b.id=y.jiagonghuId
		where 1";

		if($arr['planGxId']>0)$sql.=" and x.planGxId in ({$arr['planGxId']})";
		// if($arr['plan2proId']>0)$sql.=" and x.plan2proId='{$arr['plan2proId']}'";
		if($arr['jiagonghuId']>0)$sql.=" and y.jiagonghuId='{$arr['jiagonghuId']}'";
		if($arr['productId']>0)$sql.=" and x.productId='{$arr['productId']}'";
		if($arr['color']!='')$sql.=" and x.color='{$arr['color']}'";
		if($arr['type']!='')$sql.=" and y.type='{$arr['type']}'";
		if($arr['kind']!='')$sql.=" and y.kind='{$arr['kind']}'";
		$sql.=" order by y.chukuDate asc,y.chukuCode";
		// dump($sql);exit;
		$pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach ($rowset as & $v) {
			$v['cnt']=round($v['cnt'],2);
		}

		$heji = $this->getHeji($rowset,array('cnt'),'_edit');
		$rowset[] = $heji;

		$arrFieldInfo = array(
			"chukuDate" => "发生日期",
			'kind'=>'类型',
			'compName'=>'加工户',
			'kuweiName'=>'库位',
			'chukuCode' => array('text'=>'单号','width'=>120),
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"proName" => '纱支',
			"guige" => '规格', 
			"color" => '颜色',
			'dengji'=>'等级',
			"cnt" => '数量(Kg)',
		);

		if($arr['type']=='纱')unset($arrFieldInfo['pinzhong']);

		$smarty = &$this->_getView();
		$smarty->assign('title', '投料明细'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}


	/**
	 * 查找生产跟踪，工序投料验收信息明细
	 * 投料信息明细信息列表
	 * Time：2014/08/29 14:59:43
	 * @author li
	*/
	function actionListYsView(){
		FLEA::loadClass('TMIS_Pager');
		$arr = $_GET;
		$sql="select x.*,y.rukuCode,y.rukuDate,y.kind,y.type,z.kuweiName,a.pinzhong,a.guige,a.proName,a.proCode,b.compName
		from cangku_ruku_son x
		left join cangku_ruku y on y.id = x.rukuId
		left join jichu_kuwei z on z.id=y.kuweiId
		left join jichu_product a on a.id=x.productId
		left join jichu_jiagonghu b on b.id=y.jiagonghuId
		where 1";

		if($arr['planGxId']>0)$sql.=" and x.planGxId='{$arr['planGxId']}'";
		if($arr['plan2proId']>0)$sql.=" and x.plan2proId='{$arr['plan2proId']}'";
		if($arr['jiagonghuId']>0)$sql.=" and y.jiagonghuId='{$arr['jiagonghuId']}'";
		$sql.=" order by y.rukuDate asc,y.rukuCode";

		$pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach ($rowset as & $v) {
			$v['cnt']=round($v['cnt'],2);
		}

		$heji = $this->getHeji($rowset,array('cnt'),'_edit');
		$rowset[] = $heji;

		$arrFieldInfo = array(
			"rukuDate" => "发生日期",
			'kind'=>'类型',
			'compName'=>'加工户',
			'kuweiName'=>'库位',
			'rukuCode' => array('text'=>'单号','width'=>120),
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"proName" => '纱支',
			"guige" => '规格', 
			"color" => '颜色',
			'dengji'=>'等级',
			"cnt" => '数量(Kg)',
		);
		$smarty = &$this->_getView();
		$smarty->assign('title', '投料明细'); 
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	
}

?>