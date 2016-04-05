<?php
FLEA::loadClass('Controller_Shengchan_Chuku');
class Controller_Shengchan_Hzl_Cpck extends Controller_Shengchan_Chuku {
	var $fldMain;
	var $headSon;
	var $rules; //表单元素的验证规则
	// /构造函数
	function __construct() {
		parent::__construct();
		$this->_type = '后整理';
		$this->_kind="销售出库";
		$this->_tuiKind="销售退回";
		$this->_head="HZLXS";
		//出库主信息
		$this->fldMain = array(
			'chukuCode' => array('title' => '出库单号', "type" => "text", 'readonly' => true, 'value' => $this->_getNewCode($this->_head,'cangku_chuku','chukuCode')),
			'chukuDate' => array('title' => '出库日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'kind' => array('type' => 'text', 'value' => $this->_kind, 'readonly' => true,'title'=>'出库类型'),
			/*'orderId' => array(
				'title' => '相关订单', 
				'type' => 'popup', 
				'value' => '',
				'name'=>'orderId',
				'text'=>'',
				'url'=>url('Trade_Order','Popup'),
				//'jsTpl'=>'Cangku/Chengpin/jsRuku.tpl',//需要载入的模板文件，这个文件中不需要使用{literal},因为是通过file_get_content获得的
				'onSelFunc'=>'onSel',//选中后需要执行的回调函数名,需要在jsTpl中书写
				'textFld'=>'orderCode',//显示在text中的字段
				'hiddenFld'=>'orderId',//显示在hidden控件中的字段
			),*/
			'clientId'=>array('title'=>'客户名称','type'=>'clientpopup','clientName'=>''),
			// 'clientName'=>array('title' => '客户选择', 'type' =>'text', 'readonly' => true),
			'kuweiId' => array(
				'title' => '仓库名称', 
				"type" => "Popup",
				'url'=>url('Jichu_kuwei','popup'),
				'textFld'=>'kuweiName',
				'hiddenFld'=>'id',
			),
			// 'kuweiId' => array('title' => '仓库名称', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			'type' => array('title' => '布种类', 'type' => 'select', 'options' => $this->getHzlKind()),
			'people' => array('title' => '联系人', 'type' => 'text', 'value' => ''),
			'phone' => array('title' => '联系电话', 'type' => 'text', 'value' => ''),
			'addressCk' => array('title' => '发货地址', 'type' => 'textarea', 'value' => ''),
			// 'departmentId'=> array('title' => '领用部门','type' => 'select', 'value' => '','model'=>'Model_jichu_department'),
			// 'peolingliao' => array('title' => '领用人', 'type' => 'text', 'value' => ''),
			// 定义了name以后，就不会以memo作为input的id了
			'memo'=>array('title'=>'备注说明','type'=>'textarea','disabled'=>true,'name'=>'memo'),
			// 下面为隐藏字段
			'id' => array('type' => 'hidden', 'value' => '','name'=>'chukuId'),
			// 'clientId' => array('type' => 'hidden', 'value' => ''),
			// 'type' => array('type' => 'hidden', 'value' => $this->_type),
			'hzl' => array('type' => 'hidden', 'value' => 1),
			'isCheck' => array('type' => 'hidden', 'name' => 'isCheck','value'=>1),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
		);
		// /从表表头信息
		// /type为控件类型,在自定义模板控件
		// /title为表头
		// /name为控件名
		// /bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit' => array('type' => 'btBtnCopy', "title" => '操作', 'name' => '_edit[]'),
			'ord2proId' => array(
				'title' => '订单品种', 
				"type" => "btPopup",
				'name' => 'ord2proId[]',
				'url'=>url('trade_order','PopupHuaxing'),
				'textFld'=>'orderCode',
				'hiddenFld'=>'ord2proId',
				'inTable'=>true,
				'dialogWidth'=>900
			),
			'productId' => array(
				'title' => '产品选择', 
				"type" => "btPopup",
				'name' => 'productId[]',
				'url'=>url('jichu_chanpin','PopupHzl'),
				'textFld'=>'proCode',
				'hiddenFld'=>'productId',
				'inTable'=>true,
				'dialogWidth'=>900
			),
			// 'proCode' => array('type' => 'bttext', "title" => '产品编码','name' =>'proCode[]','readonly'=>true),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'花色','name'=>'color[]','readonly'=>true),
			'menfu'=>array('type'=>'bttext',"title"=>'门幅(M)','name'=>'menfu[]','readonly'=>true),
			'kezhong'=>array('type'=>'bttext',"title"=>'克重(g/m<sup>2</sup>)','name'=>'kezhong[]','readonly'=>true),
			'cntYaohuo'=>array('type'=>'bttext',"title"=>'要货数','name'=>'cntYaohuo[]','readonly'=>true),
			'pihao'=>array('type'=>'bttext',"title"=>'缸号','name'=>'pihao[]'),
			'dengji' => array('type' => 'btSelect', "title" => '等级', 'name' => 'dengji[]','options'=>$this->setDengji(),'inTable'=>true), 
			'cntJian' => array('type' => 'bttext', "title" => '件数', 'name' => 'cntJian[]'),
			'cnt' => array('type' => 'bttext', "title" => '数量(Kg)<span style="color:red;">*</span>', 'name' => 'cnt[]'),
			'cntM' => array('type' => 'bttext', "title" => '数量(M)', 'name' => 'cntM[]'),
			'danjia' => array('type' => 'bthidden', 'name' => 'danjia[]', "title" => '单价'),
			'money' => array('type' => 'bthidden', 'name' => 'money[]', "title" => '金额'),
			'memoView' => array('type' => 'bttext', "title" => '备注', 'name' => 'memoView[]'),
			// ***************如何处理hidden?
			'id' => array('type' => 'bthidden', 'name' => 'id[]'),
			'unit' => array('type' => 'bthidden', 'name' => 'unit[]'),
			// 'ord2proId' => array('type' => 'bthidden', 'name' => 'ord2proId[]'),
			// 'productId' => array('type' => 'bthidden', 'name' => 'productId[]'),
		);
		// 表单元素的验证规则定义
		$this->rules = array(
			'orderId' => 'required',
			'clientId' => 'required',
			'kuweiId' => 'required',
			'type'=>'required'
		);

		$this->sonTpl=array(
			// "Shengchan/Cangku/jsRuku.tpl",
			'Shengchan/CpckJs.tpl'
		);
		//编辑界面的权限id
		$this->_addCheck = '3-2-3-6';
		$this->_rightCheck = '3-2-3-7';
		$this->_removeCheck = '3-2-3-6';
	}

	function actionShenheList(){
		//权限判断
		$this->authCheck('3-2-3-50');
		$ishaveCheck = true;//$this->authCheck('3-100-1',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'isCheck'=>2,
			'kuweiId'=>'',
			'clientId'=>'',
			'ganghao' => '',
			// 'orderCode'=>'',
			'key'=>'',
		)); 
		
		$arr = TMIS_Pager::getParamArray(array(
			'isCheck'=>2,
			'kuweiId'=>'',
			'clientId'=>'',
			'ganghao' => '',
			'key'=>'',
		)); 

		$sql="select x.* from cangku_chuku x
		inner join cangku_chuku_son y on x.id=y.chukuId
		left join jichu_product z on z.id=y.productId
		left join trade_order2product b on b.id=y.ord2proId
		left join trade_order a on b.orderId=a.id
		where 1";
		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.hzl='1'";

		if($arr['ganghao']!='')$sql.=" and y.pihao like '%{$arr['ganghao']}%'";
		if($arr['key']!='')$sql.=" and (z.guige like '%{$arr['key']}%' or z.pinzhong like '%{$arr['key']}%')";
		if($arr['isCheck']<2)$sql.=" and x.isCheck = '{$arr['isCheck']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId = '{$arr['clientId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['orderCode']!=''){
			$sql.=" and a.orderCode like '%{$arr['orderCode']}%'";
		}

		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			if($traderId!='null')$sql .= " and a.traderId in({$traderId})";
		}

		$sql.=" group by x.id order by x.chukuDate desc,x.id desc";
		// echo $sql;exit;
		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		if (count($rowset) > 0) foreach($rowset as &$v) {
			
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
				$v['_edit'].="<a href='".$this->_url('shenhe',array(
					'id'=>$v['id'],
					'isCheck'=>$isCheck,
					'fromAction'=>$_GET['action'],
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
				$vv['proName']=$temp[0]['proName'];
				$vv['zhonglei']=$temp[0]['zhonglei'];
				$vv['guige']=$temp[0]['guige'];
				// $vv['color']=$temp[0]['color'];

				$vv['danjia']=round($vv['danjia'],6);
				$vv['money']=round($vv['money'],6);
				$vv['cnt']=round($vv['cnt'],6);

				//查找订单号
				$sql="select y.orderCode from trade_order2product x
				left join trade_order y on x.orderId=y.id
				where x.id='{$vv['ord2proId']}'";
				$res = $this->_modelExample->findBySql($sql);
				$vv['orderCode'] = $res[0]['orderCode'];


				//计算合计，显示在上面的信息中
				$v['cnt']+=$vv['cnt'];
				$v['cntM']+=$vv['cntM'];
				$v['cntJian']+=$vv['cntJian'];
				$v['tuiCnt']+=$vv['tuiCnt'];
				$v['money']+=$vv['money'];
				$vv['money']=round($vv['money'],2);
			}

			$chuku2proId=join(',',array_col_values($v['Products'],'id'));
			if($chuku2proId!=''){
				//查找是否有码单
				$sql="select id from cangku_madan where chuku2proId in({$chuku2proId}) limit 0,1";
				$res=$this->_modelExample->findBySql($sql);
				if($res[0]['id']>0){
					$v['madan']="<a href='".url('Shengchan_Madan','export',array(
						'chukuId'=>$v['id']
					))."'>导出</a>";
				}
			}

			//查找客户信息
			$sql="select compName from jichu_client where id='{$v['clientId']}'";
			$ccli = $this->_modelExample->findBySql($sql);
			$v['clientName'] = $ccli[0]['compName'];

			//查找库位信息
			if($v['kuweiId']){
				$sql="select * from jichu_kuwei where id='{$v['kuweiId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Kuwei'] = $temp[0];
			}

		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','tuiCnt','money','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作','width'=>120),
			'madan'=>array('text'=>'码单','width'=>50),
			'kind'=>'类型',
			'clientName'=>'客户',
			'Kuwei.kuweiName'=>'仓库',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			// 'peolingliao'=>array('text'=>'领料人','width'=>70),
			'cntJian'=>'件数',
			'cntM'=>'数量(M)',
			'cnt'=>'数量(Kg)',
			'tuiCnt'=>'退回数量(Kg)',
			// "money" => array('text'=>'金额','width'=>70),
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=array(
			'orderCode'=>'订单号',
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '花色',
			// "menfu" => array('text'=>'门幅(M)','width'=>80),
			// "kezhong" => '克重(g/m<sup>2</sup>)',
			"pihao" => '缸号',
			'dengji'=>array('text'=>'等级','width'=>80), 
			'cntJian'=>array('text'=>'件数','width'=>80),
			'cntM'=>array('text'=>'数量(M)','width'=>80),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			'tuiCnt'=>array('text'=>'退回数量(Kg)','width'=>100),
			"danjia" => array('text'=>'单价','width'=>70),
			"money" => array('text'=>'金额','width'=>70),
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
		$this->authCheck('3-2-3-49');
		$isdanjiaCheck = $this->authCheck('3-2-3-49-4',true);
		FLEA::loadClass('TMIS_Pager'); 
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'isCheck'=>'2',
			'kuweiId'=>'',
			'clientId'=>'',
			'pinzhong' => '',
			'guige' => '',
			'color' => '',
			'ganghao' => '',
			'key' => '',
		)); 

		$sql="select x.*,b.kuweiName,
			z.proCode,z.pinzhong,z.guige,
			y.pihao,y.color,y.dengji,y.cnt,y.cntM,y.cntJian,y.memoView,y.id as chuku2ProId,y.return4id,c.compName as clientName,y.danjia,y.money
			from cangku_chuku x 
			inner join cangku_chuku_son y on x.id=y.chukuId
			left join jichu_product z on z.id=y.productId
			left join jichu_kuwei b on b.id=x.kuweiId
			left join jichu_client c on c.id=x.clientId
			where 1";

		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.hzl='1'";

		if($arr['dateFrom']!='')$sql.=" and x.chukuDate >= '{$arr['dateFrom']}'";
		if($arr['dateTo']!='')$sql.=" and x.chukuDate <= '{$arr['dateTo']}'";
		if($arr['ganghao']!='')$sql.=" and y.pihao like '%{$arr['ganghao']}%'";
		if($arr['pinzhong']!='')$sql.=" and z.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['guige']!='')$sql.=" and z.guige like '%{$arr['guige']}%'";
		if($arr['color']!='')$sql.=" and y.color like '%{$arr['color']}%'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId = '{$arr['clientId']}'";
		if($arr['isCheck']<2)$sql.=" and x.isCheck = '{$arr['isCheck']}'";
		if($arr['key']!='')$sql.=" and (y.memoView like '%{$arr['key']}%' 
									or x.people like '%{$arr['key']}%' 
									or x.addressCk like '%{$arr['key']}%')";

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
			// if($v['kind']==$this->_tuiKind){
			// 	$v['_edit']="<a href='".$this->_url('TuiEdit',array(
			// 				'id'=>$v['id'],
			// 				'fromAction'=>$_GET['action']
			// 			))."'>修改</a>";
			// }
			//删除操作
			$v['_edit'] .= ' ' .$this->getRemoveHtml(array('id'=>$v['id'],'msg'=>'确认删除'.$v['chukuCode'].'整单信息吗？'));

			//打印
			$sql="select count(*) as cnt from caiwu_ar_guozhang where chukuId='{$v['chukuId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			if($temp[0]['cnt']>0){
				$v['_edit'] = "<span title='已审核，禁止操作'>修改  删除</span>";
				
			}

			$v['_edit'].="&nbsp;<a href='".$this->_url('print',array(
					'id'=>$v['id']
					))."' target='_blank'>打印</a>";

			/**
			 * 销售退回操作添加
			*/
			// if($v['kind']==$this->_tuiKind){
			// 	$v['_edit'].="&nbsp;<span ext:qtip='{$v['kind']}数据，禁止退回'>退回</span>";
			// }else{
			// 	$v['_edit'].="&nbsp;<a href='".$this->_url('TuiAdd',array(
			// 			'return4id'=>$v['chuku2ProId'],
			// 			'fromAction'=>$_GET['action']
			// 		))."' ext:qtip='退回操作'>退回</a>";
			// }

			//查找是否有码单
			$sql="select id from cangku_madan where chuku2proId ='{$v['chuku2ProId']}' limit 0,1";
			$res=$this->_modelExample->findBySql($sql);
			if($res[0]['id']>0){
				$v['_edit'].="&nbsp;<a href='".url('Shengchan_Madan','export',array(
					'chukuId'=>$v['chukuId']
				))."'>导出</a>";
			}

			$v['cnt'] =round($v['cnt'],2);
			$v['cntM'] =round($v['cntM'],2);
			$v['danjia'] =round($v['danjia'],6);
			$v['money'] =round($v['money'],2);

			//处理显示的退纱信息
			// if($v['return4id']>0 && $_GET['export']!=1){
			// 	$temp=$this->_subModel->find($v['return4id']);
			// 	$v['kind']="<a href='#' style='color:red' ext:qtip='从{$temp['Ck']['chukuCode']}单退回'>{$v['kind']}</a>";
			// }
		} 
		$heji=$this->getHeji($rowset,array('cnt','cntJian','cntM','money'),'_edit');

		$_GET['export']==1 && $heji['kind']="合计";
		$rowset[]=$heji;

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作'),
			'kind'=>array('text'=>'类型','width'=>100),
			'chukuCode' => array('text'=>'发料单号','width'=>110),
			'kuweiName'=>'发出仓库',
			'clientName'=>'客户名称',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			"proCode" => array('text'=>'产品编号','width'=>80), 
			"pinzhong" => '品种',
			"guige" => array('text'=>'规格','width'=>120), 
			"color" => '花色',
			"pihao" => array('text'=>'缸号','width'=>100), 
			'dengji'=>array('text'=>'等级','width'=>60),
			'cntJian'=>array('text'=>'件数','width'=>60),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			'cntM'=>array('text'=>'数量(M)','width'=>80),
			'danjia'=>array('text'=>'单价','width'=>80),
			'money'=>array('text'=>'金额','width'=>80),
			"people" => array('text'=>'联系人','width'=>80),
			"phone" => array('text'=>'联系电话','width'=>80),
			"addressCk" => array('text'=>'发货地址','width'=>100),
			"memoView" => array('text'=>'备注','width'=>100), 
		);

		if(!$isdanjiaCheck){
			unset($arrFieldInfo['danjia']);
			unset($arrFieldInfo['money']);
		}

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
			'clientId'=>'',
			'ganghao' => '',
			'pinzhong'=>'',
			'guige'=>'',
			'key'=>'',
		)); 

		$sql="select x.* from cangku_chuku x
		inner join cangku_chuku_son y on x.id=y.chukuId
		left join jichu_product z on z.id=y.productId
		where 1";
		$sql.=" and (x.kind='{$this->_kind}' or x.kind='{$this->_tuiKind}')";
		$sql.=" and x.hzl='1'";

		if($arr['ganghao']!='')$sql.=" and y.pihao like '%{$arr['ganghao']}%'";
		if($arr['pinzhong']!='')$sql.=" and z.pinzhong like '%{$arr['pinzhong']}%'";
		if($arr['guige']!='')$sql.=" and z.guige like '%{$arr['guige']}%'";
		if($arr['key']!='')$sql.=" and (x.memo like '%{$arr['key']}%' 
									or y.memoView like '%{$arr['key']}%' 
									or x.people like '%{$arr['key']}%' 
									or x.addressCk like '%{$arr['key']}%')";
		if($arr['isCheck']<2)$sql.=" and x.isCheck = '{$arr['isCheck']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId = '{$arr['clientId']}'";
		if($arr['kuweiId']!='')$sql.=" and x.kuweiId = '{$arr['kuweiId']}'";
		if($arr['orderCode']!=''){
			$sql.=" and a.orderCode like '%{$arr['orderCode']}%'";
		}

		/*$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			if($traderId!='null')$sql .= " and a.traderId in({$traderId})";
		}*/

		$sql.=" group by x.id order by x.chukuDate desc,x.id desc";
		// echo $sql;exit;
		//查找计划
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		if (count($rowset) > 0) foreach($rowset as &$v) {
			$v['_edit'] = $this->getEditHtml($v['id']);
			//退回的操作
			// if($v['kind']==$this->_tuiKind){
			// 	$v['_edit']="<a href='".$this->_url('TuiEdit',array(
			// 				'id'=>$v['id'],
			// 				'fromAction'=>$_GET['action']
			// 			))."'>修改</a>";
			// }
			//删除操作
			$v['_edit'] .= '&nbsp;' .$this->getRemoveHtml($v['id']);
			//打印
			//查找是否已经过账
			$sql="select count(*) as cnt from caiwu_ar_guozhang where chukuId='{$v['chukuId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			if($temp[0]['cnt']>0){
				$v['_edit'] = "<span title='已审核，禁止操作'>修改  删除</span>";
				
			}


			$v['_edit'].="&nbsp;<a href='".$this->_url('print',array(
					'id'=>$v['id']
					))."' target='_blank'>打印</a>";
			
			
			//查找明细数据
			$v['Products'] = $this->_subModel->findAll(array('chukuId'=>$v['id']));
			//显示明细数据
			foreach($v['Products'] as & $vv){
				//查找产品明细信息
				$sql="select * from jichu_product where id='{$vv['productId']}'";
				$temp=$this->_subModel->findBySql($sql);
				$vv['proCode']=$temp[0]['proCode'];
				$vv['pinzhong']=$temp[0]['pinzhong'];
				$vv['guige']=$temp[0]['guige'];

				$vv['danjia']=round($vv['danjia'],6);


				//查找订单号
				$sql="select y.orderCode from trade_order2product x
				left join trade_order y on x.orderId=y.id
				where x.id='{$vv['ord2proId']}'";
				$res = $this->_modelExample->findBySql($sql);
				$vv['orderCode'] = $res[0]['orderCode'];

				//计算合计，显示在上面的信息中
				$v['cnt']+=$vv['cnt'];
				$v['cntM']+=$vv['cntM'];
				$v['cntJian']+=$vv['cntJian'];
				// $v['tuiCnt']+=$vv['tuiCnt'];
				$v['money']+=$vv['money'];
				$vv['money']=round($vv['money'],2);
			}

			$chuku2proId=join(',',array_col_values($v['Products'],'id'));
			if($chuku2proId!=''){
				//查找是否有码单
				$sql="select id from cangku_madan where chuku2proId in({$chuku2proId}) limit 0,1";
				$res=$this->_modelExample->findBySql($sql);
				if($res[0]['id']>0){
					$v['madan']="<a href='".url('Shengchan_Madan','export',array(
						'chukuId'=>$v['id']
					))."'>导出</a>";
				}
			}

			//查找客户信息
			$sql="select compName from jichu_client where id='{$v['clientId']}'";
			$ccli = $this->_modelExample->findBySql($sql);
			$v['clientName'] = $ccli[0]['compName'];

			//查找库位信息
			if($v['kuweiId']){
				$sql="select * from jichu_kuwei where id='{$v['kuweiId']}'";
				$temp=$this->_modelExample->findBySql($sql);
				$v['Kuwei'] = $temp[0];
			}
		} 
		$rowset[]=$this->getHeji($rowset,array('cnt','tuiCnt','money','cntJian'),'_edit');

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			"_edit" => array('text'=>'操作','width'=>120),
			'madan'=>array('text'=>'码单','width'=>50),
			'kind'=>'类型',
			'clientName'=>'客户',
			'Kuwei.kuweiName'=>'仓库',
			"chukuDate" => array('text'=>'发生日期','width'=>80),
			'chukuCode' => array('text'=>'出库单号','width'=>120),
			// 'peolingliao'=>array('text'=>'领料人','width'=>70),
			'cntJian'=>'件数',
			'cntM'=>'数量(M)',
			'cnt'=>'数量(Kg)',
			"people" => array('text'=>'联系人','width'=>80),
			"phone" => array('text'=>'联系电话','width'=>80),
			"addressCk" => array('text'=>'发货地址','width'=>100),
			"memo" => array('text'=>'备注','width'=>200), 
		); 
		
		$arrField=array(
			'orderCode'=>'订单号',
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '花色',
			// "menfu" => array('text'=>'门幅(M)','width'=>80),
			// "kezhong" => '克重(g/m<sup>2</sup>)',
			"pihao" => '缸号',
			'dengji'=>array('text'=>'等级','width'=>80), 
			'cntJian'=>array('text'=>'件数','width'=>80),
			'cntM'=>array('text'=>'数量(M)','width'=>80),
			'cnt'=>array('text'=>'数量(Kg)','width'=>80),
			// 'tuiCnt'=>array('text'=>'退回数量(Kg)','width'=>100),
			// "danjia" => array('text'=>'单价','width'=>70),
			// "money" => array('text'=>'金额','width'=>70),
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

	//修改时要显示订单号
	function _beforeDisplayEdit(&$smarty) {
		$rowsSon = & $smarty->_tpl_vars['rowsSon'];
		$areaMain = & $smarty->_tpl_vars['areaMain'];
		// dump($smarty->_tpl_vars);dump($areaMain);exit;
		
		//查找客户信息
		// $sql="select compName from jichu_client where id='{$_rows[0]['clientId']}'";
		// $_rows = $this->_modelExample->findBySql($sql);
		// $areaMain['fld']['clientName']['value'] = $_rows[0]['compName'];

		//明细信息中添加订单中的信息
		foreach ($rowsSon as $key => & $v) {
			//查找对应的要货数与已出库信息
			$sql="select x.cntYaohuo,x.unit,x.danjia,x.menfu,x.kezhong,y.orderCode
			from trade_order2product x
			left join trade_order y on x.orderId=y.id
			where x.id='{$v['ord2proId']['value']}'";
			$temp=$this->_subModel->findBySql($sql);
			$v['cntYaohuo']['value']=round($temp[0]['cntYaohuo'],2).$temp[0]['unit'];
			$v['unit']['value']=$temp[0]['unit'];
			// $v['danjia']['value']=$temp[0]['danjia'];
			$v['menfu']['value'] = $temp[0]['menfu'];
			$v['kezhong']['value'] = $temp[0]['kezhong'];

			$v['ord2proId']['text'] = $temp[0]['orderCode'];

			//查找已出库信息,不包括本次的出库数量
			$sql="select sum(x.cnt) as cnt from cangku_chuku_son x
				left join cangku_chuku y on y.id=x.chukuId
				where x.ord2proId='{$v['ord2proId']['value']}' and y.isCheck=1 and x.id<>'{$v['id']['value']}'";
			// dump($sql);exit;
			$temp=$this->_modelExample->findBySql($sql);
			$v['cntHaveck']['value']=round($temp[0]['cnt'],2);
		}
	}

	/**
	 * 打印
	 */
	function actionPrint() {
		$m = & $this->_subModel;
		$rowset = $m->find($_GET['id']); 
		$row = $this->_modelExample->find(array('id'=>$_GET['id']));
		// if($row['isCheck']==0){
		// 	echo "未审核，不能打印";exit;
		// }
		$sql="select compName from jichu_client where id='{$row['clientId']}'";
		$ccli = $this->_modelExample->findBySql($sql);
		$row['clientName'] = $ccli[0]['compName'];
			
		// dump($row);exit;
		foreach($row['Products'] as &$v) {
			$v['cnt']=round($v['cnt'],2);
			$v['cntM']=round($v['cntM'],2);

			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
			// dump($v);dump($_temp);exit;
			$v['proCode'] = $_temp[0]['proCode'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];

			//查找订单
			$sql="select z.head,y.orderCode from trade_order2product x 
			left join trade_order y on y.id=x.orderId
			left join jichu_head z on z.id=y.headId
			where x.id='{$v['ord2proId']}'";

			$res = $this->_modelExample->findBySql($sql);
			$head[] = $res[0]['head'];
			$orderCode[] = $res[0]['orderCode'];
		}
		$head = join('、',array_unique(array_filter($head)));
		$orderCode = join('、',array_unique(array_filter($orderCode)));

		$row['Products'][] = $this->getHeji($row['Products'],array('cnt','cntJian','cntM'),'pinzhong') ;
		//补齐5行
		$cnt = count($row['Products']);
		for($i=5;$i>$cnt;$i--) {
			$row['Products'][] = array();
		}

		//查找订单信息
		if($row['orderId']>0){
			$_orderModle = & FLEA::getSingleton('Model_Trade_Order');
			$_order = $_orderModle->find($row['orderId']);
		}
		// dump($row);exit;
		$main = array(
			'出库单号'=>$row['chukuCode'],
			'出库日期'=>$row['chukuDate'],
			'客户'=>$row['clientName'],
			'送货地址'=>$row['addressCk'],
			'联系电话'=>$row['phone'],
			'联系人'=>$row['people'],
			'公司抬头'=>$head,
			'订单号'=>$orderCode,
		);

		$aRow=array(
			'checkPeople'=>$row['checkPeople'],
		);

		$smarty = &$this->_getView();
		$smarty->assign("title", $this->_kind.'单');
		$smarty->assign("CompName", $main['公司抬头']);
		$smarty->assign("arr_main_value", $main);
		$smarty->assign("arr_field_info", array(
			// 'proCode' => '产品编码',
			'pinzhong' => '品种',
			// 'guige' => '规格',
			'menfu' => '门幅(M)',
			'kezhong' => '克重(g/m2)',
			'color' => '颜色',
			'pihao'=>'缸号',
			// 'dengji'=>'等级',
			'cntJian' => '件数',
			'cnt' => '数量(Kg)',
			'cntM' => '米数',
			'memoView' => '备注',
			// "money" => array('text'=>'金额','width'=>70),
		));
		if($row['isCheck']==1){
			// $smarty->assign("gongzhang", '1');
		}
		$smarty->assign("arr_field_value", $row['Products']);
		$smarty->assign("aRow", $aRow);
		$smarty->display('Print.tpl');
	}

	/**
	 * 客户退货登记界面
	 * Time：2014/06/12 17:16:29
	 * @author li
	*/
	function actionTuiAdd(){
		$this->authCheck($this->_addCheck);
		//查找需要退回的数据
		$parent = $this->_subModel->find($_GET['return4id']);
		// dump($parent);exit;
		//库位信息
		$_kuwei = & FLEA::getSingleton('Model_Jichu_Kuwei');
		$kuwei = $_kuwei->find($parent['Ck']['kuweiId']);

		//供应商信息
		// $_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		// $supplier = $_supplier->find($parent['supplierId']);

		//客户信息
		$_client = & FLEA::getSingleton('Model_Jichu_Client');
		$client = $_client->find($parent['Ck']['clientId']);
		// dump($client);exit;
		//整理主要信息
		$data=array(
			'clientName'=>$client['compName'],
			// 'compName'=>$supplier['compName'],
			// 'kuweiName'=> $kuwei['kuweiName'],
			// 'supplierId'=>$parent['supplierId'],
			'kuweiId'=>$parent['Ck']['kuweiId'],
			'clientId'=>$parent['Ck']['clientId'],
			'color'=>$parent['color'],
			// 'menfu'=>$parent['menfu'],
			// 'kezhong'=>$parent['kezhong'],
			'pihao'=>$parent['pihao'],
			'dengjiParent'=>$parent['dengji'],
			'dengji'=>$parent['dengji'],
			'cntJianParent'=>round($parent['cntJian'],2),
			'cntParent'=>round($parent['cnt'],2),
			'cntMParent'=>round($parent['cntM'],2),
			'return4id'=>$parent['id'],
			'productId'=>$parent['productId'],
			'memo'=>$this->_tuiKind,
			'danjia'=>round($parent['danjia'],6),
		);
		// dump($data);exit;
		//查找产品信息
		$sql = "select * from jichu_product where id='{$parent['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		// $data['proName'] = $_temp[0]['proName'];
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
		$this->authCheck($this->_addCheck);
		$row = $this->_modelExample->find($_GET['id']);
		// dump($row);exit;
		//整理主要信息
		$pro=$row['Products'][0];
		//查找原始入库信息
		$parent = $this->_subModel->find($pro['return4id']);
		$par_main = $parent['Ck'];

		// //供应商信息
		// $_supplier = & FLEA::getSingleton('Model_Jichu_Jiagonghu');
		// $supplier = $_supplier->find($pro['supplierId']);

		//客户信息
		$_client = & FLEA::getSingleton('Model_Jichu_Client');
		$client = $_client->find($row['clientId']);

		$data=array(
			'id'=>$pro['id'],
			'cntJian'=>$pro['cntJian'],
			'cnt'=>$pro['cnt'],
			'cntM'=>$pro['cntM'],
			'money'=>$pro['money'],
			'memo'=>$pro['memoView'],
			'pihao'=>$pro['pihao'],
			'color'=>$pro['color'],
			// 'menfu'=>$pro['menfu'],
			// 'kezhong'=>$pro['kezhong'],
			'dengji'=>$pro['dengji'],
			'dengjiParent'=>$parent['dengji'],
			'productId'=>$pro['productId'],
			'return4id'=>$pro['return4id'],
			'chukuId'=>$pro['chukuId'],
			// 'compName'=> $supplier['compName'],
			// 'kuweiName'=> $row['Kuwei']['kuweiName'],
			'clientName'=>$client['compName'],
			'chukuDate'=>$row['chukuDate'],
			// 'supplierId'=>$pro['supplierId'],
			'kuweiId'=>$row['kuweiId'],
			'clientId'=>$row['clientId'],
			'cntJianParent'=>round($parent['cntJian'],2),
			'cntParent'=>round($parent['cnt'],2),
			'cntMParent'=>round($parent['cntM'],2),
			'danjia'=>round($parent['danjia'],6),
		);
		
		//查找产品信息
		$sql = "select * from jichu_product where id='{$pro['productId']}'";
		$_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
		$data['proCode'] = $_temp[0]['proCode'];
		$data['pinzhong'] = $_temp[0]['pinzhong'];
		// $data['proName'] = $_temp[0]['proName'];
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
			'clientName' => array('title' => '客户名称', 'type' => 'text','readonly'=>true),
			// 'kuweiName' => array('title' => '仓库名称', 'type' => 'text','readonly'=>true),
			// 'compName' => array('title' => '供应商', 'type' => 'text','readonly'=>true),
			'proCode'=>array('type'=>'text',"title"=>'产品编码','readonly'=>true),
			'pinzhong'=>array('type'=>'text',"title"=>'品种','readonly'=>true),
			// 'proName'=>array('type'=>'text',"title"=>'纱支','readonly'=>true),
			'guige'=>array('type'=>'text',"title"=>'规格','readonly'=>true),
			'color'=>array('type'=>'text',"title"=>'花色','readonly'=>true),
			// 'menfu'=>array('type'=>'text',"title"=>'门幅','readonly'=>true),
			// 'kezhong'=>array('type'=>'text',"title"=>'克重','readonly'=>true),
			'pihao'=>array('type'=>'text',"title"=>'缸号','readonly'=>true),
			'dengjiParent'=>array('type'=>'text',"title"=>'销售等级','readonly'=>true),
			'cntJianParent' => array('type' => 'text', "title" => '销售件数', 'name' => 'cntJianParent','readonly'=>true),
			'cntParent' => array('type' => 'text', "title" => '销售数量', 'name' => 'cntParent','readonly'=>true,'addonEnd'=>'Kg'),
			'cntMParent' => array('type' => 'text', "title" => '销售数量', 'name' => 'cntMParent','readonly'=>true,'addonEnd'=>'M'),
			'danjia' => array('type' => 'text', "title" => '单价','readonly'=>true),
			'kuweiId' => array('title' => '仓库名称', 'type' => 'select', 'model' => 'Model_Jichu_Kuwei'),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()),
			'cntJian' => array('type' => 'text', "title" => '退回件数'),
			'cnt' => array('type' => 'text', "title" => '退回数量','addonEnd'=>'Kg'),
			'cntM' => array('type' => 'text', "title" => '退回数量','addonEnd'=>'M'),
			'dengji' => array('type' => 'select', "title" => '退回等级', 'name' => 'dengji','options'=>$this->setDengji()),

			'money' => array('type' => 'text', "title" => '金额'),
			'chukuDate' => array('title' => '退回日期', 'type' => 'calendar', 'value' => date('Y-m-d')),
			'memo' => array('type' => 'textarea', "title" => '备注'),
			// 'gongxuName' => array('type' => 'hidden', 'value' => '本厂'),
			'isGuozhang' => array('type' => 'hidden', 'value' => '0'),
			'kind' => array('type' => 'hidden', 'value' => $this->_tuiKind),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'return4id' => array('type' => 'hidden', 'value' => ''),
			// 'supplierId' => array('type' => 'hidden', 'value' =>''),
			'clientId' => array('type' => 'hidden', 'value' =>''),
			// 'kuweiId' => array('type' => 'hidden', 'value' =>'')
		);
	
		$rules = array(
			'cntJian'=>'number',
			'cnt'=>'number',
			'cntM'=>'number'
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
		$parent=$this->_subModel->find($_POST['return4id']);
		// dump($parent);exit;
		//处理主要保存的信息
		$row=array(
			'id'=>$_POST['chukuId'],
			'chukuCode'=>$_POST['chukuCode'],
			'chukuDate'=>$_POST['chukuDate'],
			'isGuozhang'=>$_POST['isGuozhang'],
			'kind'=>$_POST['kind'],
			'clientId'=>$_POST['clientId'],
			'orderId'=>$_POST['orderId'],
			'kuweiId'=>$_POST['kuweiId'],
			'memo'=>$this->_tuiKind,
			'kind'=>$_POST['kind'],
			'type'=>$parent['Ck']['type'],
			'hzl'=>1,
			'creater'=>$_SESSION['REALNAME'].'',
			'kind'=>$_POST['kind'],
			'orderId'=>$parent['Ck']['orderId'],
		);
		//子表保存信息
		$son[]=array(
			'id'=>$_POST['id'],
			'productId'=>$_POST['productId'],
			'color'=>$_POST['color'],
			'pihao'=>$_POST['pihao'],
			// 'menfu'=>$_POST['menfu'],
			// 'kezhong'=>$_POST['kezhong'],
			'dengji'=>$_POST['dengji'],
			'cntJian'=>abs($_POST['cntJian'])*-1,
			'cnt'=>abs($_POST['cnt'])*-1,
			'cntM'=>abs($_POST['cntM'])*-1,
			'danjia'=>$_POST['danjia']+0,
			'money'=>abs($_POST['money'])*-1,
			'memoView'=>$_POST['memo'],
			'return4id'=>$_POST['return4id'],
			'ord2proId'=>$parent['ord2proId'],
		);

		$row['Products']=$son;
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
	 * 码单出库
	 * Time：2014/06/30 09:23:31
	 * @author li
	*/
	function actionEdit(){
		$_GET['id']=(int)$_GET['id'];
		//查找出库信息
		$rows = $this->_modelExample->find($_GET['id']);
		//获取出库子表id，用于查找是否存在码单关联信息
		$chuku2proId=join(',',array_col_values($rows['Products'],'id'));
		if($chuku2proId!=''){
			//查找是否有码单
			$sql="select id from cangku_madan where chuku2proId in({$chuku2proId}) limit 0,1";
			$res=$this->_modelExample->findBySql($sql);
			if($res[0]['id']>0){
				$madanCk=&FLEA::getSingleton('Controller_Shengchan_Hzl_CkWithMadan');
				// dump($madanCk);exit;
				$_GET['controller']="Shengchan_Hzl_CkWithMadan";
				$madanCk->actionEdit();exit;
			}
		}

		if($rows['kind']==$this->_tuiKind){
			$this->_SetTuiHtml();
		}

		parent::actionEdit();
	}

	/**
	 * 退回登记的方法，客户退回可能只知道品种，数量信息，其他信息不清楚
	 * Time：2014/10/21 16:14:43
	 * @author li
	*/
	function actionAddTui(){
		$this->_SetTuiHtml();
		// dump($this->fldMain);exit;
		parent::actionAdd();
	}

	//保存之前，需要把数量变成负数
	function actionSave(){
		if($_POST['kind']==$this->_tuiKind){
			foreach ($_POST['cnt'] as $key => &$v) {
				$v = abs($v)*-1;
				$_POST['cntM'][$key] = abs($_POST['cntM'][$key])*-1;
				$_POST['cntJian'][$key] = abs($_POST['cntJian'][$key])*-1;
				$_POST['money'][$key] = abs($_POST['money'][$key])*-1;
			}
		}
		parent::actionSave();
	}

	/**
	 * 设置退回的界面，和正常出库有去别
	 * Time：2014/10/21 16:30:09
	 * @author li
	*/
	function _SetTuiHtml(){
		//出库类型显示退回的信息
		$this->fldMain['kind']['value']=$this->_tuiKind;

		//明细中需要显示金额，单价
		$this->headSon['danjia']['type'] = 'bttext';
		$this->headSon['money']['type'] = 'bttext';
	}

	//删除
	function actionRemove(){
		$this->authCheck($this->_removeCheck);

		parent::actionRemove();
	}
}
?>