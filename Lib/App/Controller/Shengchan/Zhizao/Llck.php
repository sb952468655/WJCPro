<?php
FLEA::loadClass('Controller_Shengchan_Chuku');
class Controller_Shengchan_Zhizao_Llck extends Controller_Shengchan_Chuku {
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->rukuModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku');
		$this->ruku2Model = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku2Product');
		$this->_type = '坯布';
		$this->_kind="坯布染色发料";
		$this->_tuiKind="染色发料退回";
		$this->_head = "ZZFW";
		//出库主信息
		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode($this->_head,'cangku_chuku','chukuCode')),
			'chukuDate' => array('title' => '出库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
			// 'kuweiIdfrom' => array('title' => '发出仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			// 'kuweiIdTo' => array('title' => '发入仓库', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			'kuweiIdfrom' => array(
				'title' => '出料仓库', 
				"type" => "Popup",
				'url'=>url('Jichu_kuwei','popup'),
				'textFld'=>'kuweiName',
				'hiddenFld'=>'id',
			),
			'kuweiIdTo' => array(
				'title' => '入料仓库', 
				"type" => "Popup",
				'url'=>url('Jichu_kuwei','popup'),
				'textFld'=>'kuweiName',
				'hiddenFld'=>'id',
			),
			'departmentId'=> array('title' => '领用部门','type' => 'select', 'value' => '','model'=>'Model_jichu_department'),
			'peolingliao' => array('title' => '领用人', 'type' => 'text', 'value' => ''),
			'highLever' =>array(
				'type' => 'btnCommon',
				"title" => '高级功能',
				'textFld'=>'导入验收记录',
				'url'=>url('Shengchan_Zhizao_Scrk','GetScrkData',array('type'=>'all')),
				// 'dialogWidth'=>800
			),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注','type'=>'textarea','name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			'type' => array('type' => 'hidden', 'value' => $this->_type),
			'isJiagong' => array('type' => 'hidden', 'value' => '0'),
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
			'planGxId' => array(
				'title' => '投料计划', 
				"type" => "btPopup",
				'name' => 'planGxId[]',
				'url'=>url('Shengchan_PlanTl','popupGx'),
				'textFld'=>'touliaoCode',
				'hiddenFld'=>'plangxId',
				'inTable'=>true,
				'dialogWidth'=>860
			),
			'productId' => array(
				'title' => '产品选择', 
				"type" => "btPopup",
				'name' => 'productId[]',
				'url'=>url('jichu_chanpin','PopupZhizao'),
				'textFld'=>'proCode',
				'hiddenFld'=>'productId',
				'inTable'=>true,
				'dialogWidth'=>900
			),
			// 'productId' => array('type' => 'btchanpinpopup', "title" => '产品选择', 'name' => 'productId[]'),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]'),
			'ganghao'=>array('type'=>'bttext',"title"=>'本厂缸号','name'=>'ganghao[]'),
			// 'menfu'=>array('type'=>'bttext',"title"=>'门幅(M)','name'=>'menfu[]'),
			// 'kezhong'=>array('type'=>'bttext',"title"=>'克重(g/m<sup>2</sup>)','name'=>'kezhong[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)', 'name' => 'cnt[]'),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			// 'plan2proId' => array('type' => 'bthidden', 'name' => 'plan2proId[]'),
		);
		
		// 表单元素的验证规则定义
		$this->rules = array(
			'kuweiIdfrom' => 'required',
			'kuweiIdTo' => 'required'
		);

		$this->sonTpl=array(
			'Trade/ColorAuutoCompleteJs.tpl',
			"Shengchan/Cangku/plan2GxBu.tpl",
			"Shengchan/Cangku/LLckTpl.tpl"
		);

		$this->_rightCheck='3-2-1-4';
		$this->_addCheck='3-2-1-3';

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
			'ganghao' => '',
			'key' => '',
		));
		
		$sql="select x.* from cangku_chuku x 
		inner join cangku_chuku_son y on x.id=y.chukuId
		left join jichu_product z on z.id=y.productId
		where 1";
		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['ganghao']!='')$sql.=" and y.ganghao like '%{$arr['ganghao']}%'";
		if($arr['key']!='')$sql.=" and (z.guige like '%{$arr['key']}%' or z.pinzhong like '%{$arr['key']}%')";
		if($arr['isCheck']<2)$sql.=" and x.isCheck = '{$arr['isCheck']}'";
		if($arr['jiagonghuId']!='')$sql.=" and x.jiagonghuId = '{$arr['jiagonghuId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		$sql.=" group by x.id order by x.chukuDate desc,x.id desc";

		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		// dump($rowset);exit;
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);

			//退回的操作
			if($v['kind']==$this->_tuiKind){
				$v['_edit']="<a href='".$this->_url('TuiEdit',array(
							'id'=>$v['id'],
							'fromAction'=>$_GET['action']
						))."'>修改</a>";
			}

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

			//查找明细数据
			$v['Products'] = $this->_subModel->findAll(array('chukuId'=>$v['id']));

			//显示明细数据
			foreach($v['Products'] as & $vv){
				//查找产品明细信息
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$vv['proCode']=$temp[0]['proCode'];
				$vv['pinzhong']=$temp[0]['pinzhong'];
				// $vv['zhonglei']=$temp[0]['zhonglei'];
				$vv['guige']=$temp[0]['guige'];


				//查找退回数量信息
				$sql="select sum(cnt) as cnt from cangku_chuku_son where return4id='{$vv['id']}'";
				$result=$this->_subModel->findBySql($sql);
				$vv['tuiCnt']=abs($result[0]['cnt']);

				/**
				 * 销售退回操作添加
				*/
				if($v['kind']==$this->_tuiKind){
					$vv['_edit']="<span ext:qtip='{$v['kind']}数据，禁止退回'>退回</span>";
				}else{
					$vv['_edit']="<a href='".$this->_url('TuiAdd',array(
							'return4id'=>$vv['id'],
							'fromAction'=>$_GET['action']
						))."' ext:qtip='客户退货'>退回</a>";
				}

				//处理显示的退纱信息
				if($vv['return4id']>0){
					$temp=$this->_subModel->find($vv['return4id']);
					$v['kind']="<a href='#' style='color:red' ext:qtip='从{$temp['Ck']['chukuCode']}单退回'>{$v['kind']}</a>";
				}


				//计算合计，显示在上面的信息中
				$v['cnt']+=$vv['cnt'];
				$v['tuiCnt']+=$vv['tuiCnt'];
			}
			
			//查找库位信息
			if($v['kuweiId']){
				$sql="select kuweiName from jichu_kuwei where id='{$v['kuweiId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['kuweiName'] = $temp[0]['kuweiName'];
			}

			//查找加工户信息
			if($v['departmentId']){
				$sql="select * from jichu_department where id='{$v['departmentId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Department'] = $temp[0];
			}


			//查找发入的仓库信息
			$sql="select y.kuweiName from cangku_ruku x 
				left join jichu_kuwei y on y.id=x.kuweiId
			 	where x.dbId='{$v['id']}'";
			$temp=$this->_modelExample->findBySql($sql);
			$v['kuweiTo'] = $temp[0]['kuweiName'];
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','tuiCnt'),'_edit');
		
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo =array(
			"_edit" => array('text'=>'操作','width'=>170),
			'kind'=>'类型',
			'kuweiName'=>'发出仓库',
			'kuweiTo'=>'发入仓库',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			'tuiCnt'=>'退回数量',
			// 'Department.depName'=>array('text'=>'部门名称','width'=>80),
			// 'peolingliao'=>array('text'=>'领料人','width'=>70),
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=array(
			"_edit" => array('text'=>'操作','width'=>40),
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => array('text'=>'规格','width'=>150), 
			"color" => '颜色',
			// "menfu" => array('text'=>'门幅(M)','width'=>80),
			// "kezhong" => '克重(g/m<sup>2</sup>)',
			"ganghao" => '本厂缸号',
			'dengji'=>'等级', 
			'cntJian'=>'件数',
			'cnt'=>'数量(Kg)',
			'tuiCnt'=>'退回数量',
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
	 * 明细查询
	 * Time：2014/10/13 17:21:10
	 * @author li
	*/
	function actionListView(){
		$this->authCheck('3-2-1-40');
		$ishaveCheck = $this->authCheck('3-100-1',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'isCheck'=>'2',
			'kuweiId'=>'',
			'kuweiIdTo'=>'',
			'pinzhong' => '',
			'guige' => '',
			'color' => '',
			'ganghao' => '',
			// 'key' => '',
		)); 

		$sql="select x.*,b.kuweiName,
			z.proCode,z.pinzhong,z.guige,
			y.ganghao,y.color,y.dengji,y.cnt,y.cntJian,y.memoView,y.id as chuku2ProId,y.return4id,
			c.kuweiId as kuweiIdTo
			from cangku_chuku x 
			inner join cangku_chuku_son y on x.id=y.chukuId
			left join jichu_product z on z.id=y.productId
			left join jichu_kuwei b on b.id=x.kuweiId
			left join cangku_ruku c on c.dbId = x.id
			where 1";

		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.type='{$this->_type}'";

		if($arr['dateFrom']!='')$sql.=" and x.chukuDate >= '{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$sql.=" and x.chukuDate <= '{$arr['dateTo']}'";
		if($arr['ganghao']!='')$sql.=" and y.ganghao like '%{$arr['ganghao']}%'";
		if($arr['pinzhong']!='')$sql.=" and z.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['guige']!='')$sql.=" and z.guige like '%{$arr['guige']}%'";
		if($arr['color']!='')$sql.=" and y.color like '%{$arr['color']}%'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['kuweiIdTo']!='')$sql.=" and c.kuweiId = '{$arr['kuweiIdTo']}'";
		if($arr['isCheck']<2)$sql.=" and x.isCheck = '{$arr['isCheck']}'";

		$sql.=" order by x.chukuDate desc,x.id desc,y.id";

		//查找计划
		if($_GET['export']==1){
			$rowset = $this->_modelExample->findBySql($sql);
		}else{
			$pager = &new TMIS_Pager($sql);
			$rowset = $pager->findAll();
		}

		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);
			//退回的操作
			if($v['kind']==$this->_tuiKind){
				$v['_edit']="<a href='".$this->_url('TuiEdit',array(
							'id'=>$v['id'],
							'fromAction'=>$_GET['action']
						))."'>修改</a>";
			}
			//删除操作
			$v['_edit'] .= ' ' .$this->getRemoveHtml(array('id'=>$v['id'],'msg'=>'确认删除'.$v['chukuCode'].'整单信息吗？'));

			//打印
			if($v['isCheck']==1){
				$v['_edit'] = "<span title='已审核，禁止操作'>修改  删除</span>";
				$v['_edit'].="&nbsp;<a href='".$this->_url('print',array(
					'id'=>$v['id']
					))."' target='_blank'>打印</a>";
			}else{
				$v['_edit'].="&nbsp;<span ext:qtip='未审核，不能打印'>打印</span>";
			}

			/**
			 * 销售退回操作添加
			*/
			if($v['kind']==$this->_tuiKind){
				$v['_edit'].="&nbsp;<span ext:qtip='{$v['kind']}数据，禁止退回'>退回</span>";
			}else{
				$v['_edit'].="&nbsp;<a href='".$this->_url('TuiAdd',array(
						'return4id'=>$v['chuku2ProId'],
						'fromAction'=>$_GET['action']
					))."' ext:qtip='退回操作'>退回</a>";
			}

			//审核，有权限的才显示
			if($ishaveCheck){
				$msg='';
				$isCheck=0;
				if($v['isCheck']==0){
					$isCheck=1;
					$msg='审核';
				}else{
					$isCheck=0;
					$msg="<font color='green'>取消</font>";
				}
				$v['_edit'].="&nbsp;<a href='".$this->_url('shenhe',array(
					'id'=>$v['id'],
					'isCheck'=>$isCheck,
					'fromAction'=>$_GET['action']
					))."' title='审核操作'>{$msg}</a>";
			}


			$v['cnt'] =round($v['cnt'],2);

			//查找发入的仓库信息
			if($v['kuweiIdTo']){
				$sql="select kuweiName from jichu_kuwei where id='{$v['kuweiIdTo']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['kuweiNameTo'] = $temp[0]['kuweiName'];
			}

			//处理显示的退纱信息
			if($v['return4id']>0 && $_GET['export']!=1){
				$temp=$this->_subModel->find($v['return4id']);
				$v['kind']="<a href='#' style='color:red' ext:qtip='从{$temp['Ck']['chukuCode']}单退回'>{$v['kind']}</a>";
			}
		} 
		$heji=$this->getHeji($rowset,array('cnt','cntJian'),'_edit');

		$_GET['export']==1 && $heji['kind']="合计";
		$rowset[]=$heji;

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作'),
			'kind'=>array('text'=>'类型','width'=>100),
			'chukuCode' => array('text'=>'发料单号','width'=>110),
			'kuweiName'=>'发出仓库',
			'kuweiNameTo'=>'发入仓库',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			"proCode" => array('text'=>'产品编号','width'=>80), 
			"pinzhong" => '品种',
			"guige" => array('text'=>'规格','width'=>120), 
			"color" => '颜色',
			"ganghao" => array('text'=>'本厂缸号','width'=>100), 
			'dengji'=>array('text'=>'等级','width'=>60),
			'cntJian'=>array('text'=>'包数','width'=>60),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			"memoView" => array('text'=>'备注','width'=>100), 
		);

		$title=$this->_kind."列表";
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);

		//处理导出
		$smarty->assign('fn_export',$this->_url($_GET['action'],array('export'=>1)+$arr));
		if($_GET['export']==1){
			$this->_exportList(array('fileName'=>$title),$smarty);
		}

		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');

	}

	/**
	* 删除：需要同时删除两条数据，因为调拨会产生两条数据，所以需要同步进行
	*/
	function actionRemove(){
		//查找需要删除的信息
		$dbInfo = $this->rukuModel->find(array('dbId'=>$_GET['id']));
		
		$dbInfo['id']>0 && $this->rukuModel->removeByPkv($dbInfo['id']);
		$_GET['id']>0 && $this->_modelExample->removeByPkv($_GET['id']);

		$from = $_GET['fromAction']?$_GET['fromAction']:'right';
		js_alert(null,"window.parent.showMsg('成功删除')",$this->_url($from));
	}

	/**
	*通过ajax删除子表信息
	*/
	function actionRemoveByAjax(){
		$id=$_REQUEST['id'];
		$m = $this->_subModel;
		$sec = $this->ruku2Model ->find(array('diaoboId'=>$id));
		if($m->removeByPkv($id)) {
			$this->ruku2Model->removeByPkv($sec['id']);
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
		$arr = $this->_modelExample->find(array('id' => $_GET['id']));

		//查找调入的数据
		$dbInfo = $this->rukuModel->find(array('dbId'=>$arr['id']));
		
		foreach ($this->fldMain as $k => &$v) {
			$v['value'] = $arr[$k]?$arr[$k]:$v['value'];
		}
		$this->fldMain['kuweiIdfrom']['value']=$arr['kuweiId'];
		$this->fldMain['kuweiIdTo']['value']=$dbInfo['kuweiId'];

		//查找库位信息，赋值给仓库选择框
		$sql="select kuweiName from jichu_kuwei where id='{$arr['kuweiId']}'";
		$temp=$this->_subModel->findBySql($sql);
		$this->fldMain['kuweiIdfrom']['text']=$temp[0]['kuweiName'];
		
		//查找库位信息，赋值给仓库选择框
		$sql="select kuweiName from jichu_kuwei where id='{$dbInfo['kuweiId']}'";
		$temp=$this->_subModel->findBySql($sql);
		$this->fldMain['kuweiIdTo']['text']=$temp[0]['kuweiName'];

		// //加载库位信息的值
		$areaMain = array('title' => '调拨出库基本信息', 'fld' => $this->fldMain);

		// 入库明细处理
		$rowsSon = array();
		foreach($arr['Products'] as &$v) {
			//产品信息
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];

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
			$sql = "select * from jichu_product where id='{$v['productId']['value']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$v['productId']['text']=$_temp[0]['proCode'];
			
			if(!$v['planGxId']['value'])continue;
			// dump($v);exit;
			$sql="select y.touliaoCode from shengchan_plan2product_gongxu x 
					left join shengchan_plan_touliao y on x.touliaoId=y.id
					where x.id='{$v['planGxId']['value']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$v['planGxId'] && $v['planGxId']['text']=$_temp[0]['touliaoCode'];
			
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
		$arr = $this->_modelExample->find(array('id'=>$_GET['id']));
		$dbInfo = $this->rukuModel->find(array('dbId'=>$arr['id']));
		if($arr['isCheck']==0){
			echo "未审核，不能打印";exit;
		}
		
		$kuweifrom=$arr['Kuwei']['kuweiName'];
		$kuweiTo=$dbInfo['Kuwei']['kuweiName'];
		// dump($row);exit;
		foreach($arr['Products'] as &$v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			// dump($v);dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['proName'] = $_temp[0]['proName'];
			$v['guige'] = $_temp[0]['guige'];

			$v['cnt']=abs($v['cnt']);
			
		} 
		$arr['Products'][] = $this->getHeji($arr['Products'],array('cnt','cntCi','money'),'compName') ;
		//补齐5行
		$cnt = count($arr['Products']);
		for($i=5;$i>$cnt;$i--) {
			$arr['Products'][] = array();
		}
		// dump($arr);exit;
		$main = array(
			'出库单号'=>$arr['chukuCode'],
			'发出仓库'=>$kuweifrom,
			'发入仓库'=>$kuweiTo,
			'发外日期'=>$arr['chukuDate'],
		);
		$smarty = &$this->_getView();
		$smarty->assign("title", $this->_kind.'单');
		$smarty->assign("arr_main_value", $main);
		$smarty->assign("arr_field_info", array(
			// 'compName'=>'供应商',
			'proCode' => '产品编码',
			'pinzhong' => '品种',
			'guige' => '规格',
			'color' => '颜色',
			'ganghao'=>'本厂缸号',
			'cntJian' => '件数',
			'cnt' => '数量(Kg)',
			'dengji' => '等级', 
			'memoView' => '备注'
		));
		/**
		* 打印界面加载公章信息
		*/
		// if($arr['isCheck']==1){
		// 	$smarty->assign("gongzhang", '1');
		// }
		$smarty->assign("arr_field_value", $arr['Products']);
		$smarty->display('Print.tpl');
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
			//通过kg计算m数
			$temp['cntM']=$temp['cnt']/(round($temp['menfu'],6)*round($temp['kezhong'],6)/1000);
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
			$temp=$this->rukuModel->find(array('dbId'=>$info['id']));

			//如果存在则需要先删除原来的子表信息，重新插入
			if($temp['id']>0){
				//删除原来的调入子表信息，重新插入
				$this->ruku2Model->removeByPkvs(array_col_values($temp['Products'],'id'));
			}

			//组织调出的信息，用于插入调入信息
			$row_in=$info;
			//处理主表信息
			$row_in['kuweiId']=$_POST['kuweiIdTo']+0;
			$row_in['dbId']=$dbId;
			$row_in['id']='';
			$row_in['id']=$temp['id'];
			$row_in['rukuDate']=$row_in['chukuDate'];
			$row_in['rukuCode'] .= $row_in['chukuCode'].'调';
			//加工户信息应该为负数记录
			foreach($row_in['Products'] as & $v){
				//处理关联的调拨id
				$v['diaoboId']=$v['id'];
				$v['id']='';
				$v['memoView'].="调入数据";
			}
			// dump($row_in);exit;
			$this->rukuModel->save($row_in);


			//选择的验收记录的出库次数+1
			$sql="update cangku_ruku set llCnt=llCnt+1 where id='{$_POST['hide_highLever']}'";
			$this->rukuModel->execute($sql);
		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	/**
	 * 客户退货登记界面
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionTuiAdd(){
		//查找需要退回的数据
		$parent = $this->_subModel->find($_GET['return4id']);

		//查找调入数据
		$dbInfo = $this->ruku2Model->find(array('diaoboId'=>$parent['id']));
		// dump($dbInfo);exit;
		//库位信息
		$_kuwei = & FLEA::getSingleton('Model_Jichu_Kuwei');
		$kuwei = $_kuwei->find($parent['Ck']['kuweiId']);
		//调入数据的仓库
		$kuweiTo = $_kuwei->find($dbInfo['Rk']['kuweiId']);


		//整理主要信息
		$data=array(
			'kuweifrom'=> $kuwei['kuweiName'],
			'kuweiTo'=> $kuweiTo['kuweiName'],
			'kuweiId'=>$parent['Ck']['kuweiId'],
			'kuweiIdTo'=>$kuweiTo['id'],
			'ganghao'=>$parent['ganghao'],
			'color'=>$parent['color'],
			// 'menfu'=>$parent['menfu'],
			// 'kezhong'=>$parent['kezhong'],
			'dengjiParent'=>$parent['dengji'],
			'dengji'=>$parent['dengji'],
			'cntParent'=>round($parent['cnt'],2),
			'return4id'=>$parent['id'],
			'productId'=>$parent['productId'],
			'memo'=>$this->_tuiKind,
		);
		// dump($data);exit;
		//查找产品信息
		$sql = "select * from jichu_product where id='{$parent['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		$data['guige'] = $_temp[0]['guige'];
		// $data['color'] = $_temp[0]['color'];

		//加载界面信息
		$arr = $this->setTsFldMain($data);

		//把需要初始值的信息加载初始值
		foreach($data as $key => & $v){
			$arr['fldMain'][$key]['value']=$v;
		}
		// dump($arr);exit;
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$arr['fldMain']);
	    $smarty->assign('title',$this->_tuiKind.'信息编辑');
	    $smarty->assign('rules',$arr['rules']);
	    if($_GET['fromAction']!=''){
	    	$smarty->assign('other_button',"<input class='btn btn-default' type='button' name='back' value='返 回' onclick=\"window.location.href='".$this->_url($_GET['fromAction'])."'\">");
	    }
	    $smarty->assign('form',array('action'=>'SaveTui'));
	    $smarty->assign('sonTpl','Shengchan/Cangku/tuiKuEdit.tpl');
	    $smarty->display('Main/A1.tpl');
	}

	/**
	 * 客户退货修改界面
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionTuiEdit(){
		$row = $this->_modelExample->find($_GET['id']);
		// dump($row);exit;
		//整理主要信息
		$pro=$row['Products'][0];
		//查找原始入库信息
		$parent = $this->_subModel->find($pro['return4id']);
		$par_main = $parent['Ck'];
		$dbInfo = $this->rukuModel->find(array('dbId'=>$par_main['id']));
		// dump($dbInfo);exit;

		$data=array(
			'id'=>$pro['id'],
			'cnt'=>$pro['cnt'],
			'cntJian'=>$pro['cntJian'],
			'memo'=>$pro['memoView'],
			'ganghao'=>$pro['ganghao'],
			'color'=>$pro['color'],
			// 'menfu'=>$pro['menfu'],
			// 'kezhong'=>$pro['kezhong'],
			'dengji'=>$pro['dengji'],
			'dengjiParent'=>$parent['dengji'],
			'productId'=>$pro['productId'],
			'return4id'=>$pro['return4id'],
			'chukuId'=>$pro['chukuId'],
			'kuweifrom'=> $row['Kuwei']['kuweiName'],
			'kuweiTo'=> $dbInfo['Kuwei']['kuweiName'],
			'chukuDate'=>$row['chukuDate'],
			'kuweiId'=>$row['kuweiId'],
			'kuweiIdTo'=>$dbInfo['Kuwei']['id'],
			'cntParent'=>round($parent['cnt'],2),
		);
		
		//查找产品信息
		$sql = "select * from jichu_product where id='{$pro['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		$data['guige'] = $_temp[0]['guige'];
		// $data['color'] = $_temp[0]['color'];

		//加载界面信息
		$arr = $this->setTsFldMain($data);
		//把需要初始值的信息加载初始值
		foreach($data as $key => & $v){
			$arr['fldMain'][$key]['value']=$v;
		}

		// dump($arr);exit;
		$smarty = & $this->_getView();
	    $smarty->assign('fldMain',$arr['fldMain']);
	    $smarty->assign('title',$this->_tuiKind.'信息编辑');
	    $smarty->assign('rules',$arr['rules']);
	    if($_GET['fromAction']!=''){
	    	$smarty->assign('other_button',"<input class='btn btn-default' type='button' name='back' value='返 回' onclick=\"window.location.href='".$this->_url($_GET['fromAction'])."'\">");
	    }
	    $smarty->assign('form',array('action'=>'SaveTui'));
	    $smarty->assign('sonTpl','Shengchan/Cangku/tuiKuEdit.tpl');
	    $smarty->display('Main/A1.tpl');
	}

	/**
	 * 客户退货操作，需要显示的界面信息
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function setTsFldMain(){
		$tsFldMain = array(
			'id'=>array('title'=>'','type'=>'hidden','value'=>''),
			'chukuId'=>array('title'=>'','type'=>'hidden','value'=>''),
			'chukuCode'=>array('title'=>'退回单号','type'=>'text','value'=>$this->_getNewCode($this->_head,'cangku_chuku','chukuCode'),'readonly'=>true),
			'kuweifrom' => array('title' => '发出仓库', 'type' => 'text','readonly'=>true),
			'kuweiTo' => array('title' => '发入仓库', 'type' => 'text','readonly'=>true),
			'proCode'=>array('type'=>'text',"title"=>'产品编码','readonly'=>true),
			'pinzhong'=>array('type'=>'text',"title"=>'品种','readonly'=>true),
			'guige'=>array('type'=>'text',"title"=>'规格','readonly'=>true),
			'color'=>array('type'=>'text',"title"=>'颜色','readonly'=>true),
			// 'menfu'=>array('type'=>'text',"title"=>'门幅','readonly'=>true,'addonEnd'=>'&nbsp;&nbsp;&nbsp;M&nbsp;&nbsp;&nbsp;'),
			// 'kezhong'=>array('type'=>'text',"title"=>'克重','readonly'=>true,'addonEnd'=>'g/m<sup>2</sup>'),
			'ganghao'=>array('type'=>'text',"title"=>'本厂缸号','readonly'=>true),
			'dengjiParent'=>array('type'=>'text',"title"=>'领用等级','readonly'=>true),
			'cntParent' => array('type' => 'text', "title" => '领用数量', 'name' => 'cntParent','readonly'=>true,'addonEnd'=>'Kg'),
			// 'danjia' => array('type' => 'text', "title" => '加工单价','readonly'=>true),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()), 
			'cntJian' => array('type' => 'text', "title" => '退回件数'),
			'cnt' => array('type' => 'text', "title" => '退回数量','addonEnd'=>'Kg'),
			// 'money' => array('type' => 'text', "title" => '加工费'),
			'chukuDate' => array('title' => '退回日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'memo' => array('type' => 'textarea', "title" => '备注'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '1'),
			// 'isJiagong' => array('type' => 'hidden', 'value' => '1'),
			'kind' => array('type' => 'hidden', 'value' => $this->_tuiKind),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'return4id' => array('type' => 'hidden', 'value' => ''),
			'kuweiId' => array('type' => 'hidden', 'value' =>''),
			'kuweiIdTo' => array('type' => 'hidden', 'value' =>'')
		);
	
		$rules = array(
			'cnt'=>'number'
		);
		// dump($tsFldMain);exit;
		return array('fldMain'=>$tsFldMain,'rules'=>$rules);
	}

	/**
	 * 客户退货操作，保存方法
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionSaveTui(){
		// dump($_POST);exit;
		if(empty($_POST['cnt'])){
			echo "数量不能为空……";exit;
		}

		//查询之前设置的单价
		$sql="select planGxId from cangku_chuku_son where id='{$_POST['return4id']}'";
		$parentCkInfo = $this->_subModel->findBySql($sql);
		$parentCkInfo = $parentCkInfo[0];
		//处理主要保存的信息
		$row=array(
			'id'=>$_POST['chukuId'],
			'chukuCode'=>$_POST['chukuCode'],
			'chukuDate'=>$_POST['chukuDate'],
			'isGuozhang'=>$_POST['isGuozhang'],
			'kuweiId'=>$_POST['kuweiId'],
			'memo'=>$this->_tuiKind,
			'kind'=>$_POST['kind'],
			'type'=>$this->_type,
			'creater'=>$_SESSION['REALNAME'].'',
		);
		//子表保存信息
		$son[]=array(
			'id'=>$_POST['id'],
			'productId'=>$_POST['productId'],
			'ganghao'=>$_POST['ganghao'],
			// 'menfu'=>$_POST['menfu'],
			// 'kezhong'=>$_POST['kezhong'],
			'color'=>$_POST['color'],
			'cntJian'=>abs($_POST['cntJian'])*-1,
			'cnt'=>abs($_POST['cnt'])*-1,
			'dengji'=>$_POST['dengji'],
			'memoView'=>$_POST['memo'],
			'return4id'=>$_POST['return4id'],
			// 'plan2proId'=>$parentCkInfo['plan2proId'],
			'planGxId'=>$parentCkInfo['planGxId'],
		);

		$row['Products']=$son;
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
			// dump($info);exit;
			//查找是否存在调入的信息
			$temp=$this->rukuModel->find(array('dbId'=>$info['id']));

			//如果存在则需要先删除原来的子表信息，重新插入
			if($temp['id']>0){
				//删除原来的调入子表信息，重新插入
				$this->ruku2Model->removeByPkvs(array_col_values($temp['Products'],'id'));
			}

			//查找原来的入库信息，正常发外的入库记录
			$dbI = $this->ruku2Model->find(array('diaoboId'=>$_POST['return4id']));
			//组织调出的信息，用于插入调入信息
			$row_in=$info;
			//处理主表信息
			$row_in['kuweiId']=$_POST['kuweiIdTo']+0;
			$row_in['dbId']=$dbId;
			$row_in['id']='';
			$row_in['id']=$temp['id'];
			$row_in['rukuDate']=$row_in['chukuDate'];
			$row_in['rukuCode'] .= $row_in['chukuCode'].'调';
			//加工户信息应该为负数记录
			foreach($row_in['Products'] as & $v){
				//处理关联的调拨id
				$v['return4id']=$dbI['id'];
				$v['diaoboId']=$v['id'];
				$v['id']='';
				$v['memoView'].="调入数据";
			}
			// dump($row_in);exit;
			$this->rukuModel->save($row_in);

		}
		//跳转
		js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
		exit;
	}

	/**
	 * 损耗统计报表入库明细
	 * Time：2014/07/28 16:09:52
	 * @author li
	*/
	function actionSunhaoView(){
		$this->authCheck();
		$filed=array(
			"proCode" => '产品编号', 
			// "zhonglei" => '成分', 
			"proName" => '纱支',
			"guige" => '规格', 
			"color" => '颜色',
			'pihao'=>'批号',
		);
		parent::actionSunhaoView($filed);
	}

	/**
	 * 库存统计报表
	 * Time：2014/07/28 16:09:52
	 * @author li
	*/
	function actionReport(){
		$this->authCheck('3-2-1-8');
		//汇总字段
		$this->strGroup="kuweiId,productId,ganghao,color";

		$this->_search = array(
			"dateFrom" => date('Y-m-01'), 
			"dateTo" => date('Y-m-d'),
			'kuweiId'=>'',
			'ganghao'=>'',
			'color'=>'',
			'key'=>'',
			'from'=>'',
			'sortBy'=>'',
			'sort'=>'',
		);

		//显示的菜单项
		$filed=array(
			"proCode" => '产品编号',
			"pinzhong" => array('text'=>'品种'),
			"guige" => '规格', 
			"color" => '颜色',
			'ganghao'=>array('text'=>'本厂缸号','sort'=>true),
		);

		parent::actionReport($filed);
	}

	/**
	 * 库存统计弹出窗口，提供登记界面选择产品使用
	 * Time：2014/07/28 16:09:52
	 * @author li
	*/
	function actionPopupReport(){
		$this->authCheck();
		//显示0库存的信息
		$filed['field']=array(
			"proCode" => '产品编号',
			"pinzhong" => '品种',
			"guige" => '规格', 
		);

		//显示库存时候的信息
		$filed['fieldKucun']=array(
			"color" => '颜色',
			'ganghao'=>'本厂缸号',
			'dengji'=>'等级',
		);

		$filed['search']=array(
			'kuweiId'=>'',
			'ganghao'=>'',
			'color'=>'',
			'key'=>'',
			'productType'=>'1'
		);

		$this->strGroup="kuweiId,productId,ganghao,color,dengji";

		// dump($filed);exit;
		parent::actionPopupReport($filed);
	}

	/**
	 * 收发存报表中点击出库数量弹出窗口
	 */
	function actionPopup($filed) {
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' => $_GET['dateFrom'],
			'dateTo' => $_GET['dateTo'],
			'kuweiId'=>$_GET['kuweiId'],
			'productId'=>$_GET['productId'],
			'ganghao'=>$_GET['ganghao'],
			'color'=>$_GET['color'],
			'type'=>$_GET['type'],
			'dengji'=>$_GET['dengji'],
		));
		// dump($serachArea);exit;
		$sql = "select 
			y.chukuCode,
			y.jiagonghuId,
			y.clientId,
			y.chukuDate,
			y.memo as chukuMemo,
			y.kind,
			x.id,
			x.chukuId,
			x.ganghao,
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

		$arr['dateFrom']!='' && $sql .= " and y.chukuDate >= '{$arr['dateFrom']}' and y.chukuDate<='{$arr['dateTo']}'";
		$arr['productId']!='' && $sql .= " and x.productId='{$arr['productId']}'";
		$arr['kuweiId'] > 0 && $sql .= " and y.kuweiId='{$arr['kuweiId']}'";
		$arr['ganghao']!='' && $sql .= " and x.ganghao='{$arr['ganghao']}'";
		$arr['color']!='' && $sql .= " and x.color='{$arr['color']}'";
		$arr['dengji']!='' && $sql .= " and x.dengji='{$arr['dengji']}'";
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

			//查找发入的仓库信息
			$sql="select y.kuweiName from cangku_ruku x 
				left join jichu_kuwei y on y.id=x.kuweiId
			 	where x.dbId='{$v['id']}'";
			$temp=$this->_modelExample->findBySql($sql);
			$v['kuweiTo'] = $temp[0]['kuweiName'];
		} 
		// 合计行
		$heji = $this->getHeji($rowset, array('cnt'), 'chukuDate');
		$rowset[] = $heji;

		$filed = $filed ? $filed :array(
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
			"ganghao" => '本厂缸号',
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
	
}

?>