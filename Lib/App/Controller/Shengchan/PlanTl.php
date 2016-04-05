<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Shengchan_PlanTl extends TMIS_Controller {

	function __construct(){
		$this->_modelExample = &FLEA::getSingleton('Model_Shengchan_PlanTl');
		$this->_modelGongxu = &FLEA::getSingleton('Model_Jichu_gongxu');
		// 定义模板中的主表字段
		$this->fldMain = array(
			'planCode' => array('title'=>'计划单号', "type"=>"text", 'readonly'=>true, 'value'=>'','readonly'=>true),
			'planDate' => array('title' => '计划日期', 'type' => 'text', 'value' => '','readonly'=>true),
			'proCode' => array('title' => '产品编号', 'type' => 'text', 'value' => '','readonly'=>true),
			'pinzhong' => array('title' => '品种', 'type' => 'text', 'value' =>'','readonly'=>true),
			'guige' => array('title' => '规格', 'type' => 'text', 'value' => '','readonly'=>true),
			'color' => array('title' => '颜色', 'type' => 'text', 'value' => '','readonly'=>true),
			'menfu' => array('title' => '门幅', 'type' => 'text', 'value' => '','readonly'=>true,'addonEnd'=>'M'),
			'kezhong' => array('title' => '克重', 'type' => 'text', 'value' => '','readonly'=>true,'addonEnd'=>'(g/m<sup>2</sup>)'),
			'cntShengchan' => array('title' => '计划数', 'type' => 'text', 'value' => '','readonly'=>true,'addonEnd'=>'Kg'),
			'plan2proId' => array('type' => 'hidden', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => '','name'=>'touliaoId'),
		); 
		
		$this->headSon = array(
			'_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
			'gongxuName' => array(
				'type' => 'btselect', 
				"title" => '工序', 
				'name' => 'gongxuName[]',
				'options'=>$this->_modelGongxu->getOptions(array('valueKey'=>'itemName'))
			),
			'jiagonghuId'=>array(
				'type' => 'btselect', 
				"title" => '加工户', 
				'name' => 'jiagonghuId[]',
				'model' => 'Model_Jichu_Jiagonghu',
				'condition'=>'isSupplier=0'
			),
			'cnt' => array('title' => '数量', 'type' => 'bttext', 'value' =>'','name'=>'cnt[]'),
			'dateFrom' => array('type' => 'btCalendarInTbl', "title" => '开始日期', 'name' => 'dateFrom[]'),
			'dateTo' => array('type' => 'btCalendarInTbl', "title" => '截止日期', 'name' => 'dateTo[]'),
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
		);

		$this->qitaSon = array(
			'_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
			'productId' => array('type' => 'btproductpopup', "title" => '纱支选择', 'name' => 'productId[]'),
		    'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
		    'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
		    'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
		    'supplierId'=>array(
		    	'type' => 'btselect', 
		    	"title" => '供应商', 
		    	'name' => 'supplierId[]',
		    	'model' => 'Model_Jichu_Jiagonghu',
		    	'condition'=>'isSupplier=1',
		    	'inTable'=>true
	    	),
		    'chengfenPer'=>array('type'=>'bttext',"title"=>'比列(%)','name'=>'chengfenPer[]'),
		    'sunhao'=>array('type'=>'bttext',"title"=>'损耗(%)','name'=>'sunhao[]'),
		    'cntKg'=>array('type'=>'bttext',"title"=>'计划投料(Kg)','name'=>'cntKg[]'),
		    'memoView'=>array('type'=>'bttext',"title"=>'备注','name'=>'memoView[]'),
		    'id'=>array('type'=>'bthidden','name'=>'qtid[]'),
		);

		// 表单元素的验证规则定义
		$this->rules = array(

		);
	}

	//例出所有的生产计划，准备录入工序
	function actionList4Gongxu() {
		$this->authCheck('2-3');
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			// 'isShezhi'=>0,
			'planCode' => '',
			'pinzhong' => '',
			'guige' => '',
			'color' => '',
		)); 
		//已设置：工序和投料明细里都有plan2proId，否则为未设置 by wujinbin 2014-8-12
		// 取shengchan_plan2product_gongxu 表中的plan2proId数据
		$sql="select distinct plan2proId from shengchan_plan_touliao2product ";
		$temp=$this->_modelExample->findBySql($sql);
		$_temp=array_col_values($temp,'plan2proId');
	
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
		$arr['pinzhong'] != '' && $sql .= " and z.pinzhong like '%{$arr['pinzhong']}%'";
		$arr['guige'] != '' && $sql .= " and z.pinzhong like '%{$arr['guige']}%'";
		$arr['color'] != '' && $sql .= " and y.color like '%{$arr['color']}%'";
		//通过in()来判断
		$sql.=" and y.id not in({$plan2proId})";
		// if($arr['isShezhi']==1)$sql.=" and y.id in({$plan2proId})";
		// elseif($arr['isShezhi']==0)$sql.=" and y.id not in({$plan2proId})";
		
		$sql.= " order by id desc";
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 

		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = "<a href='".$this->_url('Add',array('id'=>$v['id']))."'>设置</a>";

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
			$smarty->assign('other_url', "<a href='javascript:SetPlanByMore()' id='thisUrl' url='".$this->_url('Add')."'>统一设置计划</a>");
			$smarty->assign('sonTpl', "Shengchan/Plan/SetTouliaoTpl.tpl");
		}
		
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	}

	function actionRight(){
		$this->authCheck('2-4');
		FLEA::loadClass('TMIS_Pager');

        ///构造搜索区域的搜索类型
        $arr=TMIS_Pager::getParamArray(array(
        	'commonCode'=>'',
			'pinzhong'=>'',
			'guige'=>'',
			'color'=>'',
			'menfu'=>'',
			'kezhong'=>'',
    	));
       
		$str = "select x.*,b.planCode,b.planDate,a.pinzhong,a.guige,a.pinzhong,a.proCode,z.color,z.menfu,z.kezhong,b.overDate,b.overDateReal,group_concat(z.color) as color
			from shengchan_plan_touliao x
			left join shengchan_plan_touliao2product y on y.touliaoId=x.id
			left join shengchan_plan2product z on z.id=y.plan2proId
			left join jichu_product a on a.id=z.productId
			left join shengchan_plan b on b.id=z.planId
			where 1";
		
        if($arr['commonCode'] != '') $str .=" and x.touliaoCode like '%{$arr['commonCode']}%'";
        if($arr['pinzhong'] != '') $str .=" and a.pinzhong like '%{$arr['pinzhong']}%'";
        if($arr['guige'] != '') $str .=" and a.guige like '%{$arr['guige']}%'";
        if($arr['color'] != '') $str .=" and z.color like '%{$arr['color']}%'";
        if($arr['menfu'] != '') $str .=" and z.menfu like '%{$arr['menfu']}%'";
        if($arr['kezhong'] != '') $str .=" and z.kezhong like '%{$arr['kezhong']}%'";

		$str .= " group by x.id order by x.touliaoDate desc,x.touliaoCode desc";

        $pager = & new TMIS_Pager($str);
		$rowset = $pager->findAll();

		foreach($rowset as & $v) {
			$v['_edit'] = $this->getEditHtml($v['id']) .' ' .$this->getRemoveHtml($v['id']);

			$v['overDateReal'] == '0000-00-00' && $v['overDateReal']='';
		}
 
		$smarty = & $this->_getView();
		//左侧信息
		$arrFieldInfo = array(
			"_edit"=>array('text'=>'操作'),
			"touliaoDate" =>array('text'=>'设置日期','width'=>90),
			"touliaoCode" =>array('text'=>'投料编号','width'=>90),
		    'creater'=>'制单人',
			'planCode'=>'计划单号',
			'planDate'=>'计划日期',
			"overDate" => "计划完成时间",
			'overDateReal' => '实际完成时间',
			'pinzhong'=>'品种',
			'guige'=>array('text'=>'规格','width'=>120),
			'color'=>array('text'=>'颜色','width'=>100),
			'menfu'=>array('text'=>'门幅(M)','width'=>90),
			'kezhong'=>array('text'=>'克重(g/m<sup>2</sup>)','width'=>90),
		);

		$smarty->assign('title','订单查询');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	function actionSave(){
		// dump($_POST);exit;
		$p = $_POST;

		//如果投料id存在，查询投料信息
		if($p['touliaoId']>0){
			// $this->_modelExample->clearLinks();
			$temp = $this->_modelExample->find($p['touliaoId']);
			$row = array(
				'id'=>$temp['id'],
				'touliaoCode'=>$temp['touliaoCode'],
				'touliaoDate'=>$temp['touliaoDate'],
				'creater'=>$_SESSION['REALNAME'].'',
			);
		}else{
			$row = array(
				'touliaoCode'=>$this->_getNewCode('TL','shengchan_plan_touliao','touliaoCode'),
				'touliaoDate'=>date('Y-m-d'),
				'creater'=>$_SESSION['REALNAME'].'',
			);
		}
		// dump($row);exit;
		//判断是否需要拆分（当选择多个计划明细的时候，系统需要自动拆分）
		$plan2proId = explode(',',$p['plan2proId']);
		
		$rowset = array();
		$rowtouliao = array();

		foreach($p['gongxuName'] as $k=>& $v) {
			if(empty($v) || empty($p['cnt'][$k]))continue;
			$rowset[] = array(
				'id'=>$p['id'][$k],
				'gongxuName'=>$p['gongxuName'][$k],
				'orderLine'=>$k,
				'dateFrom'=>$p['dateFrom'][$k],
				'dateTo'=>$p['dateTo'][$k],
				'jiagonghuId'=>$p['jiagonghuId'][$k],
				'cnt'=>$p['cnt'][$k],
			);
		}
		
		/**
		* 处理投料信息，进行保存
		*/
		
		foreach($p['productId'] as $k=>& $v) {
			if(empty($v) || empty($p['cntKg'][$k]))continue;
			$rowtouliao[] = array(
				'id'=>$p['qtid'][$k],
				'productId'=>$p['productId'][$k],
				'orderLine'=>$k,
				'color'=>$p['color'][$k],
				'sunhao'=>$p['sunhao'][$k],
				'cntKg'=>$p['cntKg'][$k]+0,
				'chengfenPer'=>$p['chengfenPer'][$k],
				'supplierId'=>$p['supplierId'][$k]+0,
				'memoView'=>$p['memoView'][$k],
			);
		}

		$row['Plan2Gongxu'] = $rowset;
		$row['Plan2Touliao'] = $rowtouliao;
		$row['plan2proId'] = $plan2proId;
		// dump($row);exit;
		$m=$this->_modelExample->save($row);
		
		if(!$m) {
			js_alert('保存失败!',null,$this->_url('right'));
			exit;
		}
		js_alert(null,'window.parent.showMsg("保存成功!")',$this->_url('right'));
	}

	function actionAdd() {
		$this->authCheck('2-3');

		$plan2Product = &FLEA::getSingleton('Model_Shengchan_Plan2Product');
		$id=explode(',',$_GET['id']);
		$row = $plan2Product->find(array('id'=>$id[0]));

		//如果$id是多个，需要计算合计
		if(count($id)>1){
			$sql="select sum(cntShengchan) as cntShengchan,group_concat(color) as color from shengchan_plan2product where id in ({$_GET['id']})";
			$temp = $plan2Product->findBySql($sql);
			$row['cntShengchan'] = $temp[0]['cntShengchan'];
			$row['color'] = $temp[0]['color'];
		}

		$row['planCode'] = $row['Plan']['planCode'];
		$row['planDate'] = $row['Plan']['planDate'];
		$row['proCode'] = $row['Product']['proCode'];
		$row['guige'] = $row['Product']['guige'];
		$row['pinzhong'] = $row['Product']['pinzhong'];
		$row['plan2proId'] = $_GET['id'];

		// dump($row);exit;
		foreach ($this->fldMain as $k => &$v) {
			$name=$v['name']!='' ? $v['name'] : $k;
			$v['value'] = $row[$name]?$row[$name]:$v['value']; 
		}

		// dump($this->fldMain);exit;
		// 从表区域信息描述
		$smarty = &$this->_getView();
		$areaMain = array('title' => '投料计划基本信息', 'fld' => $this->fldMain); 
		$smarty->assign('areaMain', $areaMain);
		// 从表信息字段,默认5行
		for($i = 0;$i < 3;$i++) {
			$rowsSon[] = array();
		}


		$smarty->assign("otherInfoTpl",'Main2Son/OtherInfoTpl.tpl');

		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules); 
		$smarty->assign('sonTitle', '工序计划设置');
		$smarty->assign('RemoveByAjax', 'RemoveGxByAjax');

		//投料计划信息
		$_cnt = $row['cntShengchan'];
		$sql="select * from jichu_product_chengfen where proId='{$row['productId']}'";
		$dataTouliao = $plan2Product->findBySql($sql);
		// dump($dataTouliao);exit;
		foreach ($dataTouliao as $key => & $v) {
			$r=array();
			//查找纱支信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$shazhi = $plan2Product->findBySql($sql);
			$shazhi = $shazhi[0];
			$v['zhonglei']=$shazhi['zhonglei'];
			$v['proName']=$shazhi['proName'];
			$v['guige']=$shazhi['guige'];

			$r=array(
					'productId'=>array('value'=>$v['productId']),
					'zhonglei'=>array('value'=>$v['zhonglei']),
					'proName'=>array('value'=>$v['proName']),
					'guige'=>array('value'=>$v['guige']),
					'color'=>array('value'=>$v['color']),
					'chengfenPer'=>array('value'=>$v['chengfenPer']),
					'cntKg'=>array('value'=>$v['chengfenPer']/100*$_cnt),
				);

			$row4sSon[]=$r;
		}
		while (count($row4sSon)<3) {
			$row4sSon[]=array();
		}

		$smarty->assign('qitaSon',$this->qitaSon);
		$smarty->assign('otherInfo','投料计划设置');
	    $smarty->assign('row4sSon',$row4sSon);
	   

	    //投料计划信息
	     $sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/sonTpl.tpl'
		);
	    $smarty->assign("sonTpl",$sonTpl);
	    
		$smarty->display('Main2Son/T1.tpl');
	}

	function actionEdit(){
		$this->authCheck('2-3');
		$rows = $this->_modelExample->find($_GET['id']);
		// dump($rows);exit;
		$plan2Product = &FLEA::getSingleton('Model_Shengchan_Plan2Product');
		$id=array_col_values($rows['plan2proId'],'id');
		// dump($id);exit;
		$row = $plan2Product->find(array('id'=>$id[0]));

		//如果$id是多个，需要计算合计
		if(count($id)>1){
			$row['cntShengchan'] = array_sum(array_col_values($rows['plan2proId'],'cntShengchan'));
			$row['color'] = join(',',array_col_values($rows['plan2proId'],'color'));
		}

		$row['planCode'] = $row['Plan']['planCode'];
		$row['planDate'] = $row['Plan']['planDate'];
		$row['proCode'] = $row['Product']['proCode'];
		$row['guige'] = $row['Product']['guige'];
		$row['pinzhong'] = $row['Product']['pinzhong'];
		$row['touliaoId'] = $rows['id'];
		$row['plan2proId'] = join(',',$id);

		// dump($row);exit;
		foreach ($this->fldMain as $k => &$v) {
			$name=$v['name']!='' ? $v['name'] : $k;
			$v['value'] = $row[$name]?$row[$name]:$v['value']; 
		}
		// dump($this->fldMain);exit;
		// 从表区域信息描述
		$smarty = &$this->_getView();
		$areaMain = array('title' => '投料计划基本信息', 'fld' => $this->fldMain); 
		$smarty->assign('areaMain', $areaMain);
		// 从表信息字段,默认5行

		foreach($rows['Plan2Gongxu'] as &$v) {
			$temp = array();
			foreach($this->headSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$rowsSon[] = $temp;
		}

		while (count($rowsSon)<3) {
			$rowsSon[]=array();
		}

		$smarty->assign("otherInfoTpl",'Main2Son/OtherInfoTpl.tpl');

		$smarty->assign('headSon', $this->headSon);
		$smarty->assign('rowsSon', $rowsSon);
		$smarty->assign('rules', $this->rules); 
		$smarty->assign('sonTitle', '工序计划设置');
		$smarty->assign('RemoveByAjax', 'RemoveGxByAjax');

		//投料计划信息
		$_cnt = $row['cntShengchan'];

		foreach($rows['Plan2Touliao'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
		}

		foreach($rows['Plan2Touliao'] as &$v) {
			$temp = array();
			foreach($this->qitaSon as $kk => &$vv) {
				$temp[$kk] = array('value' => $v[$kk]);
			}
			$row4sSon[] = $temp;
		}

		while (count($row4sSon)<3) {
			$row4sSon[]=array();
		}

		$smarty->assign('qitaSon',$this->qitaSon);
		$smarty->assign('otherInfo','投料计划设置');
	    $smarty->assign('row4sSon',$row4sSon);
	   

	    //投料计划信息
	     $sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			'Shengchan/sonTpl.tpl'
		);
	    $smarty->assign("sonTpl",$sonTpl);
	    
		$smarty->display('Main2Son/T1.tpl');
	
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

	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 * 弹出投料计划信息供选择
	 */
	function actionPopup() {
		FLEA::loadClass('TMIS_Pager');

        ///构造搜索区域的搜索类型
        $arr=TMIS_Pager::getParamArray(array(
			'pinzhong'=>'',
			'guige'=>'',
			'menfu'=>'',
			'kezhong'=>'',
    	));
       
		$str = "select x.*,a.pinzhong,a.guige,a.pinzhong,a.proCode,z.color,z.menfu,z.kezhong,group_concat(z.color) as color
			from shengchan_plan_touliao x
			left join shengchan_plan_touliao2product y on y.touliaoId=x.id
			left join shengchan_plan2product z on z.id=y.plan2proId
			left join jichu_product a on a.id=z.productId
			where 1";
		
        if($arr['pinzhong'] != '') $str .=" and a.pinzhong like '%{$arr['pinzhong']}%'";
        if($arr['guige'] != '') $str .=" and a.guige like '%{$arr['guige']}%'";
        if($arr['menfu'] != '') $str .=" and z.menfu like '%{$arr['menfu']}%'";
        if($arr['kezhong'] != '') $str .=" and z.kezhong like '%{$arr['kezhong']}%'";

		$str .= " group by x.id order by x.touliaoDate desc,x.touliaoCode desc";

        $pager = & new TMIS_Pager($str);
		$rowset = $pager->findAll();

		foreach($rowset as & $v) {
			//查找对应的纱支信息，组成一个字符串显示
			/*$sql="select x.cntKg,z.compName,y.proName,y.guige,x.color
			from shengchan_plan2product_touliao x
			left join jichu_product y on x.productId=y.id
			left join jichu_jiagonghu z on z.id=x.supplierId
			where x.touliaoId='{$v['id']}'";

			$_temp = $this->_modelExample->findBySql($sql);
			$temp=array();
			foreach ($_temp as $key => & $t) {
				$temp[] = $t['compName'].':<font color="green">'.$t['proName'].' '.$t['guige'].' '.$t['color'].'</font>:'.$t['cntKg'];
			}
			$v['shazhi']=join('<br>',$temp);*/
		}
 
		$smarty = & $this->_getView();
		//左侧信息
		$arrFieldInfo = array(
			"touliaoDate" =>array('text'=>'设置日期','width'=>90),
			"touliaoCode" =>array('text'=>'投料编号','width'=>90),
			'pinzhong'=>'品种',
			'guige'=>array('text'=>'规格','width'=>120),
			'color'=>array('text'=>'颜色','width'=>100),
			'menfu'=>array('text'=>'门幅(M)','width'=>90),
			'kezhong'=>array('text'=>'克重(g/m<sup>2</sup>)','width'=>90),
			// 'shazhi'=>array('text'=>'纱支信息','width'=>250),
			'creater'=>'制单人',
		);

		$smarty->assign('title','订单查询');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 * 弹出投料计划信息供选择
	 */
	function actionPopupShazhi() {
		FLEA::loadClass('TMIS_Pager');

        ///构造搜索区域的搜索类型
        $arr=TMIS_Pager::getParamArray(array(
			'supplierId'=>'',
			'isShezhi'=>0,
			'shazhi'=>'',
			'guige'=>'',
			'color'=>'',
    	));
       
		$str = "select x.*,a.proName,a.guige,a.proCode,y.touliaoCode,y.touliaoDate,y.creater,z.compName
			from shengchan_plan2product_touliao x
			left join shengchan_plan_touliao y on x.touliaoId=y.id
			left join jichu_product a on a.id=x.productId
			left join jichu_jiagonghu z on z.id=x.supplierId
			where 1";
		
        if($arr['supplierId'] != '') $str .=" and x.supplierId = '{$arr['supplierId']}'";
        if($arr['isShezhi'] == 0) $str .=" and x.psPlan2proId = 0";
        else $str .=" and x.psPlan2proId <> 0";
        if($arr['shazhi'] != '') $str .=" and a.proName like '%{$arr['shazhi']}%'";
        if($arr['guige'] != '') $str .=" and a.guige like '%{$arr['guige']}%'";
        if($arr['color'] != '') $str .=" and x.color like '%{$arr['color']}%'";
        // if($arr['menfu'] != '') $str .=" and z.menfu like '%{$arr['menfu']}%'";
        // if($arr['kezhong'] != '') $str .=" and z.kezhong like '%{$arr['kezhong']}%'";

		$str .= " order by y.touliaoDate desc,y.touliaoCode desc,x.id";

        $pager = & new TMIS_Pager($str);
		$rowset = $pager->findAll();

		foreach($rowset as & $v) {
			//查找布的信息，生产计划信息，订单信息
			$str="select group_concat(plan2proId) as plan2proId,plan2proId as plan2proId2 from shengchan_plan_touliao2product where touliaoId='{$v['touliaoId']}'";
			$res = $this->_modelExample->findBySql($str);

			if($res[0]['plan2proId']!=''){
				$str="select y.pinzhong,y.guige,group_concat(x.color) as color
				from shengchan_plan2product x
				left join jichu_product y on x.productId=y.id
				where x.id in({$res[0]['plan2proId']})";
				$result = $this->_modelExample->findBySql($str);
			}

			$v['pinzhong'] = $result[0]['pinzhong'];
			$v['guige2'] = $result[0]['guige'];
			$v['color2'] = $result[0]['color'];


			//查找订单号
			$sql="select z.orderCode,y.planCode from shengchan_plan2product x
			left join shengchan_plan y on x.planId=y.id
			left join trade_order z on z.id=y.orderId
			where 1 and x.id='{$res[0]['plan2proId2']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['orderCode'] = $temp[0]['orderCode'];
			$v['planCode'] = $temp[0]['planCode'];
		}
 
		$smarty = & $this->_getView();
		//左侧信息
		$arrFieldInfo = array(
			"touliaoDate" =>array('text'=>'设置日期','width'=>90),
			"orderCode" =>array('text'=>'订单编号','width'=>90),
			// "planCode" =>array('text'=>'计划编号','width'=>90),
			"touliaoCode" =>array('text'=>'投料编号','width'=>90),
			'compName'=>'供应商',
			'proName'=>'纱支',
			'guige'=>array('text'=>'纱支规格','width'=>120),
			'color'=>array('text'=>'纱支颜色','width'=>100),
			'cntKg'=>'投料数(Kg)',
			'pinzhong'=>'品种',
			'guige2'=>array('text'=>'规格','width'=>120),
			'color2'=>array('text'=>'颜色','width'=>100),
			'creater'=>'制单人',
		);

		$smarty->assign('title','订单查询');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/MultSel.tpl');
	}

	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 * 弹出投料计划信息供选择
	 */
	function actionPopupView() {
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'kind'=>'',
			// 'isOver'=>0,
			'supplierId'=>'',
			'orderCode'=>'',
			'planCode'=>'',
			'shazhi'=>'',
			'guige'=>'',
			'pinzhong'=>'',
			'gongxuKey'=>'',
			'shaKind'=>'',
			'_type'=>'',
		));

		//查找符合前工序发料的信息
		//该工序计划需要有 “纱线染色”
		//该纱的类别应该是 “棉纱”
		if($arr['_type'] == '前工序发料'){
			$sql="select touliaoId from shengchan_plan2product_gongxu where gongxuName = '{$arr['gongxuKey']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$touliaoId = join(',',array_col_values($temp,'touliaoId'));
			if($touliaoId!='')$where = " and y.id in ({$touliaoId})";
			else $where = " and 0";
		}

		$sql = "select x.*,b.pinzhong,b.guige,c.proName,c.guige as guigeDesc,c.proCode,e.compName,y.touliaoCode,y.touliaoDate,x.id as planTlId,d.planCode,f.orderCode
		from shengchan_plan2product_touliao x
		inner join shengchan_plan_touliao y on x.touliaoId=y.id
		left join (select plan2proId,touliaoId from shengchan_plan_touliao2product group by touliaoId) z on z.touliaoId=y.id
		left join shengchan_plan2product a on a.id=z.plan2proId
		left join jichu_product b on a.productId=b.id
		left join jichu_product c on c.id=x.productId
		left join jichu_jiagonghu e on e.id=x.supplierId
		left join shengchan_plan d on d.id=a.planId
		left join trade_order f on f.id=d.orderId
		where 1";

		$arr['orderCode'] != '' && $sql .= " and f.orderCode like '%{$arr['orderCode']}%'";
		$arr['planCode'] != '' && $sql .= " and d.planCode like '%{$arr['planCode']}%'";
		$arr['pinzhong'] != '' && $sql .= " and b.pinzhong like '%{$arr['pinzhong']}%'";
		$arr['guige'] != '' && $sql .= " and (b.guige like '%{$arr['guige']}%' or c.guige like '%{$arr['guige']}%')";
		$arr['zhishu'] != '' && $sql .= " and c.proName like '%{$arr['zhishu']}%'";
		$arr['supplierId']>0 && $sql.=" and x.supplierId='{$arr['supplierId']}'";
		if($arr['isOver']==0){
			$sql.=" and d.isOver=0";
		}elseif($arr['isOver']==1){
			$sql.=" and d.isOver=1";
		}
		if($arr['_type']=='前工序发料' && $arr['shaKind']!='')$sql .= " and c.kind='{$arr['shaKind']}'";
		$sql.=$where;
		$sql .= " order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		foreach($rowset as &$v) {
			$v['cntKg'] = round($v['cntKg'],2);
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			'orderCode'=>'订单编号',
			'planCode'=>'计划单号',
			"touliaoCode" => '投料计划', 
			// "touliaoDate" => '投料日期', 
			"proName" => '纱支', 
			"guigeDesc" => '纱支规格', 
			"color" => '颜色',
			"pinzhong" => '品种',
			"guige" => '规格',
			'compName'=>'供应商',
			"cntKg" => '计划投料', 
		); 
		

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 * 弹出工序信息供选择
	 */
	function actionPopupGx() {
		FLEA::loadClass('TMIS_Pager'); 
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'isOver'=>'0',
			'jiagonghuId'=>'',
			'orderCode' => '',
			'planCode' => '',
			'gongxuName' => '',
			'pinzhong' => '',
			'guige' => '',
			'kind'=>'',
			'ColType'=>'',
		));

		$sql="select x.*,b.pinzhong,b.guige,b.proCode,e.compName,y.touliaoCode,y.touliaoDate,x.id as plangxId,a.productId,d.planCode,f.orderCode,x.touliaoId
		from shengchan_plan2product_gongxu x
		inner join shengchan_plan_touliao y on x.touliaoId=y.id
		left join (select plan2proId,touliaoId,group_concat(plan2proId) as plan2proId2 from shengchan_plan_touliao2product group by touliaoId) z on z.touliaoId=y.id
		left join shengchan_plan2product a on a.id=z.plan2proId
		left join jichu_product b on a.productId=b.id
		left join jichu_jiagonghu e on e.id=x.jiagonghuId
		left join shengchan_plan d on d.id=a.planId
		left join trade_order f on f.id=d.orderId
		where 1";

		$arr['orderCode'] != '' && $sql .= " and f.orderCode like '%{$arr['orderCode']}%'";
		$arr['planCode'] != '' && $sql .= " and d.planCode like '%{$arr['planCode']}%'";
		$arr['pinzhong'] != '' && $sql .= " and b.pinzhong like '%{$arr['pinzhong']}%'";
		$arr['guige'] != '' && $sql .= " and b.guige like '%{$arr['guige']}%'";
		$arr['gongxuName'] != '' && $sql .= " and x.gongxuName like '%{$arr['gongxuName']}%'";
		$arr['jiagonghuId'] >0 && $sql .= " and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['isOver']==0){
			$sql.=" and exists(select id from shengchan_plan2product tt where tt.isViewOver=0 and id in(z.plan2proId2))";
		}elseif($arr['isOver']==1){
			$sql.=" and not exists(select id from shengchan_plan2product tt where tt.isViewOver=0 and id in(z.plan2proId2))";
		}
		$sql .= " order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		foreach($rowset as &$v) {
			$v['cnt'] = round($v['cnt'],2);

			//查找品种的颜色信息
			$sql="select group_concat(y.color) as color from shengchan_plan_touliao2product x 
			left join shengchan_plan2product y on x.plan2proId=y.id
			where x.touliaoId='{$v['touliaoId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$v['color'] = $temp[0]['color'];

			//查找验收数量
			if($arr['ColType']!=''){
				$sql="select sum(y.cnt) as cnt from cangku_ruku x 
				left join cangku_ruku_son y on x.id=y.rukuId
				where x.kind='{$arr['ColType']}' and y.planGxId='{$v['plangxId']}' and jiagonghuId='{$v['jiagonghuId']}' and productId='{$v['productId']}'";
				// dump($sql);exit;
				$temp = $this->_modelExample->findBysql($sql);
				$v['colType'] = $temp[0]['cnt'] == 0 ? '' : round($temp[0]['cnt'],2);
			}
		} 
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			'orderCode'=>'订单编号',
			'planCode'=>'计划单号',
			'touliaoCode'=>'投料编号',
			'compName'=>'加工户',
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色', 
			'gongxuName'=>'工序名称',
			"cnt" => '计划数量', 
		);

		$arr['ColType']!="" && $arrFieldInfo['colType']=$arr['ColType']."数量";
		

		$smarty->assign('title', '计划查询');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 弹出选择,选择计划时用,在生产领用和生产入库时一般都需要用到
	 * 弹出工序信息供选择
	 */
	function actionPopupGxView() {
		FLEA::loadClass('TMIS_Pager'); 
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
			'isOver'=>0,
			'jiagonghuId'=>'',
			'orderCode' => '',
			'planCode' => '',
			'gongxuName' => '',
			'pinzhong' => '',
			'guige' => '',
			'kind'=>'',
			'ColType'=>'',
		));

		$sql="select x.*,b.pinzhong,b.guige,b.proCode,e.compName,y.touliaoCode,y.touliaoDate,x.id as plangxId,a.color,a.productId,a.cntShengchan,z.plan2proId,d.planCode,f.orderCode
		from shengchan_plan2product_gongxu x
		inner join shengchan_plan_touliao y on x.touliaoId=y.id
		left join shengchan_plan_touliao2product z on z.touliaoId=y.id
		left join shengchan_plan2product a on a.id=z.plan2proId
		left join jichu_product b on a.productId=b.id
		left join jichu_jiagonghu e on e.id=x.jiagonghuId
		left join shengchan_plan d on d.id=a.planId
		left join trade_order f on f.id=d.orderId
		where 1";

		$arr['orderCode'] != '' && $sql .= " and f.orderCode like '%{$arr['orderCode']}%'";
		$arr['planCode'] != '' && $sql .= " and d.planCode like '%{$arr['planCode']}%'";
		$arr['pinzhong'] != '' && $sql .= " and b.pinzhong like '%{$arr['pinzhong']}%'";
		$arr['guige'] != '' && $sql .= " and b.guige like '%{$arr['guige']}%'";
		$arr['gongxuName'] != '' && $sql .= " and x.gongxuName like '%{$arr['gongxuName']}%'";
		$arr['jiagonghuId'] >0 && $sql .= " and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['isOver']==0){
			$sql.=" and a.isViewOver=0";
		}elseif($arr['isOver']==1){
			$sql.=" and a.isViewOver=1";
		}
		$sql .= " order by x.id desc";
		// echo $sql;exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll(); 
		foreach($rowset as &$v) {
			$v['cnt'] = round($v['cnt'],2);

			//查找该投料计划中所有的生产计划明细的计划生产数量
			$sql="select sum(x.cntShengchan) as cnt from shengchan_plan2product x
				left join shengchan_plan_touliao2product y on y.plan2proId=x.id
				where y.touliaoId='{$v['touliaoId']}'";
			$res = $this->_modelExample->findBySql($sql);
			// $v['cntShengchanAll'] = $res[0]['cnt'];
			$bilie = $v['cntShengchan']/$res[0]['cnt'];
			$v['cnt'] = round($v['cnt']*$bilie,2);

			//查找验收数量
			if($arr['ColType']!=''){
				$sql="select sum(y.cnt) as cnt from cangku_ruku x 
				left join cangku_ruku_son y on x.id=y.rukuId
				where x.kind='{$arr['ColType']}' and y.planGxId='{$v['plangxId']}' and jiagonghuId='{$v['jiagonghuId']}' and productId='{$v['productId']}'";
				// dump($sql);exit;
				$temp = $this->_modelExample->findBysql($sql);
				$v['colType'] = $temp[0]['cnt'] == 0 ? '' : round($temp[0]['cnt'],2);
			}
		} 

		// dump($rowset);exit;
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			'orderCode'=>'订单编号',
			'planCode'=>'计划单号',
			'touliaoCode'=>'投料编号',
			'compName'=>'加工户',
			"proCode" => '产品编号', 
			"pinzhong" => '品种', 
			"guige" => '规格', 
			"color" => '颜色', 
			'gongxuName'=>'工序名称',
			"cnt" => '计划数量', 
			// "cntShengchan" => 'cntShengchan', 
			// "cntShengchanAll" => 'cntShengchanAll', 
		); 
		$arr['ColType']!="" && $arrFieldInfo['colType']=$arr['ColType']."数量";
		

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
	 * 通过ajax获取投料计划的详细信息，
	 * Time：2014/10/10 09:54:08
	 * @author li
	 * @param GET
	 * @return JSON
	*/
	function actionGetTouliaoByAjax(){
		$id = $_GET['touliaoId'].'';
		if($id=='')$id="null";
		//查找投料计划信息
		$str="select 
			sum(cntKg) as cntKg,
			group_concat(id) as id,
			productId,
			color,
			memoView,
			supplierId
		from shengchan_plan2product_touliao 
		where 1 and id in({$id})
		group by productId,color,supplierId";

		$row = $this->_modelExample->findBySql($str);
		// echo $str;
		foreach($row as & $vv){
			$str="select * from jichu_product where id='{$vv['productId']}'";
			$temp = $this->_modelExample->findBySql($str);
			$vv['Product']=$temp[0];
		}
		echo json_encode(array('success'=>count($row)>0,'Touliao'=>$row,'msg'=>'未发现生产计划的投料信息!'));
	}

	//老数据处理的补丁
	function actionBuilding(){
		//查找所有已设置的计划明细id信息
		$sql="select plan2proId from shengchan_plan2product_gongxu where touliaoId=0
			union select plan2proId as kind from shengchan_plan2product_touliao where touliaoId=0";
		$res = $this->_modelExample->findBySql($sql);
		$res = array_col_values($res,'plan2proId');
		$res = array_unique($res);
		// dump($res);exit;
		foreach ($res as $key => & $v) {
			$temp = array(
				'touliaoCode'=>$this->_getNewCode('TL','shengchan_plan_touliao','touliaoCode'),
				'touliaoDate'=>date('Y-m-d'),
				'plan2proId'=>array($v)
			);

			$id=$this->_modelExample->save($temp);
			$sql="update shengchan_plan2product_gongxu set touliaoId='{$id}' where plan2proId='{$v}'";
			mysql_query($sql);

			$sql="update shengchan_plan2product_touliao set touliaoId='{$id}' where plan2proId='{$v}'";
			mysql_query($sql);
		}

		$sql="
			ALTER TABLE `shengchan_plan2product_gongxu`
			DROP COLUMN `plan2proId`,
			MODIFY COLUMN `touliaoId`  int(10) NOT NULL COMMENT '投料Id' AFTER `id`;
			ALTER TABLE `shengchan_plan2product_touliao`
			DROP COLUMN `plan2proId`,
			MODIFY COLUMN `touliaoId`  int(10) NOT NULL COMMENT '投料Id' AFTER `id`;
			";
		mysql_query($sql);

		echo '补丁完成';
	}
}

?>