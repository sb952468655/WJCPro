<?php
FLEA::loadClass('Tmis_Controller');
class Controller_Caiwu_Ys_Guozhang extends Tmis_Controller {
	var $_tplEdit = 'Caiwu/Ys/GuozhangEdit.tpl';
    function __construct() {
        $this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Ys_Guozhang');
        $this->_modelChukuProduct = & FLEA::getSingleton('Model_Shengchan_Cangku_Chuku2Product');
        
        //搭建过账界面
        $this->fldMain = array(
			'guozhangDate' => array('title' => '过账日期', "type" => "calendar", 'value' => date('Y-m-d')),
			// 'btnRukuYuanliao' => array('title' => '选择入库', 'type' => 'BtnRukuYuanliao', 'value' => ''),
			/*'chuku2proId' => array('title' => '选择出库', 'type' => 'popup', 'value' => '','name'=>'chuku2proId','text'=>'选择出库',
				'url'=>url('Shengchan_Chuku','PopupOnGuozhang'),
				'jsTpl'=>'Caiwu/Ys/jsGuozhang.tpl',//需要载入的模板文件，这个文件中不需要使用{literal},因为是通过file_get_content获得的
				'onSelFunc'=>'onSelChuku',//选中后需要执行的回调函数名,需要在jsTpl中书写
				'textFld'=>'chukuCode',//显示在text中的字段
				'hiddenFld'=>'id',//显示在hidden控件中的字段
				'dialogWidth'=>950,
			),*/
			'clientId' => array('title' => '客户名称', 'type' => 'clientpopup', 'clientName' => ''),
			// 'proName' => array('title' => '品名', 'type' => 'text', 'value' => '','readonly'=>true),
			// 'guige' => array('title' => '规格', 'type' => 'text', 'value' => '','readonly'=>true),
			// 'qitaMemo' => array('title' => '描述', 'type' => 'text', 'value' => '','readonly'=>true),
			// 'kuweiName' => array('title' => '库位', 'type' => 'text', 'value' => '','readonly'=>true),
			'chukuDate' => array('title' => '出库日期', 'type' => 'text', 'value' => '','readonly'=>true),
			'cnt' => array('title' => '数量', 'type' => 'text', 'value' => '','readonly'=>true,'addonEnd'=>'kg'),
			//'cntM' => array('title' => '数量', 'type' => 'text', 'value' => '','readonly'=>true,'addonEnd'=>'M'),
			// 'unit' => array('title' => '单位', 'type' => 'text', 'value' => '','readonly'=>true),
			//'danjia' => array('title' => '单价', 'type' => 'text', 'value' => '','readonly'=>true),
			'_money' => array('title' => '金额', 'type' => 'text', 'value' => '','addonEnd'=>''),
			'zhekouMoney' => array('title' => '折扣金额', 'type' => 'text', 'value' => ''),
			'money' => array('title' => '入账金额', 'type' => 'text', 'value' => ''),
			'bizhong' => array('title' => '币种', 'type' => 'select', 'value' => 'RMB', 'options' => array(
					array('text' => 'RMB', 'value' => 'RMB'),
					array('text' => 'USD', 'value' => 'USD'),
					)),
			'huilv' => array('title' => '汇率', 'type' => 'text', 'value' => '1'),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
			'kind' => array('type' => 'hidden', 'value' => ''),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'chukuId' => array('type' => 'hidden', 'value' => ''),
			'orderId' => array('type' => 'hidden', 'value' => ''),
			'ord2proId' => array('type' => 'hidden', 'value' => ''),
		);

		// 表单元素的验证规则定义
		$this->rules = array(
			'guozhangDate' => 'required',
			'clientId' => 'required',
			'money' => 'required number'
		);
    }

    function actionRight() {
		// $this->authCheck('4-2-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			//'orderCode'=>'',
			'proName'=>'',
			'guigeDesc'=>'',
			'orderId'=>'',
			'no_edit'=>'',
			'no_time'=>'',
		));
		$sql="SELECT x.*,z.compName,b.chukuCode,c.proName,c.guige,c.color,c.pinzhong,d.ganghao,d.dengji
			from caiwu_ar_guozhang x 
			left join trade_order y on x.orderId=y.id
			left join trade_order2product a on a.id=x.ord2proId
			left join cangku_chuku b on b.id=x.chukuId
			left join jichu_client z on z.id=x.clientId
			left join jichu_product c on x.productId=c.id
			left join cangku_chuku_son d on d.id=x.chuku2proId
			-- left join jichu_kuwei c on c.id=x.kuweiId
			where 1";
		if($arr['orderId']>0){
			$arr['dateFrom']='';
			$arr['dateTo']='';
			$sql.=" and x.orderId='{$arr['orderId']}'";
		}
		if($arr['no_time']!=''){
			$arr['dateFrom']='';
			$arr['dateTo']='';
		}

		if($arr['dateFrom']!='')$sql.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId='{$arr['clientId']}'";
		if($arr['orderCode']!='')$sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['product']!='')$sql.=" and a.product like '%{$arr['product']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		if ($arr['guigeDesc'] != '')$sql.=" and b.guige like '%{$arr['guigeDesc']}%'";
		if ($arr['proName'] != '') $sql.=" and b.proName like '%{$arr['proName']}%'";
		$sql.=" and x.kind!='其它' order by x.id asc";
		// dump($sql);exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		foreach($rowset as & $v) {
			$v['_edit']= "<a href='".$this->_url('Edit',array(
				'id'=>$v['id']
			))."' title='过账编辑'>修改</a>". '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);

			//核销的情况下不能修改删除
			if($v['moneyYishou']>0 || $v['moneyFapiao']>0)$v['_edit']="<span title='已核销，禁止操作'>修改&nbsp;&nbsp;删除</span>";

			$v['money']=round($v['money'],3);
            $v['cnt']=round($v['cnt'],3);
            $v['danjia']=round($v['danji'],3);
			//折合人民币
			$v['moneyRmb']=round($v['money']*$v['huilv'],3);
             //dump($v['money']);dump($v['huilv']);dump($v['moneyRmb']);exit;
			//是否开票完成
			if($v['fapiaoOver']==0){
				$v['fapiaoOver']='';
			}else{
				$v['fapiaoOver']='是';
			}
		}
		$rowset[] = $this->getHeji($rowset, array('cnt','money','moneyRmb'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
			"_edit"=>'操作',
			"compName"=>'客户',
			"guozhangDate"=>'日期',
			"chukuCode"=>'出库编号',
			// "product"=>$this->getManuCodeName(),
			
			 
			//"qitaMemo"=>array('text'=>'描述','width'=>160),
			// 'kuweiName'=>'库位',
			"cnt"=>array('text'=>'数量','width'=>70),
			//"danjia"=>array('text'=>'单价','width'=>70),
			"_money"=>array('text'=>'发生金额','width'=>90),
			"zhekouMoney"=>array('text'=>'折扣金额','width'=>90),
			"money"=>array('text'=>'应收金额','width'=>90),
// 			"bizhong"=>array('text'=>'币种','width'=>70),
// 			"huilv"=>array('text'=>'汇率','width'=>70),
			"pinzhong"=>array('text'=>'品种','width'=>100),
			"guige"=>'规格',
			"color"=>'颜色',
			//"ganghao"=>'缸号',
			"dengji"=>'等级',
			'fapiaoOver'=>array('text'=>'开票完成','width'=>70),
			"memo"=>"备注",
			"creater"=>"制单人",
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrField);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display($tpl);
	}

	//已收款查询，对账单中编辑的信息
	function actionRightYis() {
		// $this->authCheck('4-2-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			// 'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			// 'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			'orderCode'=>'',
			'product'=>'',
			'guige'=>'',
			'orderId'=>'',
			'no_edit'=>'',
		));
		$sql="select x.*,z.compName,y.orderCode from caiwu_ar_guozhang x 
			left join trade_order y on x.orderId=y.id
			left join trade_order2product a on a.id=x.ord2proId
			left join jichu_client z on z.id=x.clientId
			where 1";
		if($arr['orderId']>0){
			$arr['dateFrom']='';
			$arr['dateTo']='';
			$sql.=" and x.orderId='{$arr['orderId']}'";
		}
		if($arr['dateFrom']!='')$sql.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId='{$arr['clientId']}'";
		if($arr['orderCode']!='')$sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['product']!='')$sql.=" and a.product like '%{$arr['product']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		$sql.=" order by x.id asc";
		// dump($sql);exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		foreach($rowset as & $v) {
			// $v['_edit']= $this->getEditHtml(array(
			// 	'id'=>$v['id'],
			// 	'fromAction'=>$_GET['action']
			// 	)) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);

			// $v['money']=round($v['money'],2);

			//折合人民币
			$v['moneyRmb']=round($v['money']*$v['huilv'],2);
			$v['moneyRmb2']=round($v['moneyYishou']*$v['huilv'],2);
		}
		$rowset[] = $this->getHeji($rowset, array('moneyRmb2','money','moneyRmb'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
			// "_edit"=>'操作',
			"compName"=>'客户',
			"guozhangDate"=>'日期',
			"orderCode"=>'生产编号',
			"product"=>$this->getManuCodeName(),
			"guige"=>'规格',
			// "unit"=>array('text'=>'单位','width'=>70),
			// "cnt"=>array('text'=>'数量','width'=>70),
			// "danjia"=>array('text'=>'单价','width'=>70),
			// "money"=>array('text'=>'应收金额','width'=>70),
			'moneyRmb'=>'金额(RMB)',
			'moneyRmb2'=>'已收金额(RMB)',
			// "bizhong"=>array('text'=>'币种','width'=>70),
			// "huilv"=>array('text'=>'汇率','width'=>70),
			"memo"=>"备注",
			// "creater"=>"制单人",
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrField);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display($tpl);
	}

	

	function actionSave(){
		 // dump($_POST);exit;
		 if($_POST['huilv']==null)$_POST['huilv']=1;
		 if($_POST['chuku2proId']==null)$_POST['chuku2proId']=' ';
		 if($_POST['chukuDate']==null)$_POST['chukuDate']='0000-00-00';
		 if($_POST['cnt']==null)$_POST['cnt']=0;
		 if($_POST['bizhong']==null)$_POST['bizhong']='RMB';
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$arr[$k] = $_POST[$name];
		}
		// dump($arr);exit;
		$id=$this->_modelExample->save($arr);

		$from=$_POST['fromAction']!='' ? $_POST['fromAction'] : 'add';
		js_alert(null,'window.parent.showMsg("操作成功");',$this->_url($from));
	}

	
	
	//应付款报表
	function actionReport(){
		//$this->authCheck('4-2-7');
		$tpl = $_GET['print']?'Print.tpl':'TblList.tpl';
		FLEA::loadclass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
		));
		//得到期初发生
		//应付款表中查找,日期为期初日期
		//按照加工商汇总
		$sql="select sum(money*huilv) as fsMoney,clientId from caiwu_ar_guozhang where guozhangDate < '{$arr['dateFrom']}'";
		if($arr['clientId']!=''){
			$sql.=" and clientId='{$arr['clientId']}'";
		}
		$sql.=" group by clientId order by clientId";
		$rowset = $this->_modelExample->findBySql($sql);
		foreach($rowset as & $v){
			//期初金额
			$row[$v['clientId']]['initMoney']=round(($v['fsMoney']+0),3);//期初余额
			$row[$v['clientId']]['initIn']=round(($v['fsMoney']+0),3);
		}
		//得到起始日期前的收款金额
		//从付款表中查找
		//按照加工商汇总
		$sqlIncome = "SELECT sum(money*huilv) as shouKuanMoney,clientId FROM `caiwu_ar_income` where  shouhuiDate < '{$arr['dateFrom']}'";
		if($arr['clientId']!=''){
			$sqlIncome.=" and clientId='{$arr['clientId']}'";
		}
		$sqlIncome.=" group by clientId order by clientId";
		$rowset = $this->_modelExample->findBySql($sqlIncome);
		foreach($rowset as & $v){
			//期初金额
			$row[$v['clientId']]['initMoney']=round(($row[$v['clientId']]['initMoney']-$v['shouKuanMoney']+0),3);//期初余额=期初发生-期初已付款
			$row[$v['clientId']]['initOut']=round($v['shouKuanMoney'],3);
		}
		
		//得到本期的已收款
		//付款表中查找
		//按照客户汇总
		$str="SELECT sum(money*huilv) as moneySk,clientId from caiwu_ar_income where 1 ";
		if($arr['dateFrom']!=''){
			$str.=" and shouhuiDate>='{$arr['dateFrom']}' and shouhuiDate<='{$arr['dateTo']}'";
		}
		if($arr['clientId']!=''){
			$str.=" and clientId='{$arr['clientId']}'";
		}
		$str.=" group by clientId order by clientId";
		//echo $str;exit;
		$fukuan=$this->_modelExample->findBySql($str);
		foreach($fukuan as & $v1){
			$row[$v1['clientId']]['moneySk']=round(($v1['moneySk']+0),3);
		}

		//得到本期发生
		//应付款表中查找
		//按照客户汇总
		$sql="select sum(money*huilv) as fsMoney,clientId from caiwu_ar_guozhang where 1";
		if($arr['dateFrom']!=''){
			$sql.=" and guozhangDate>='{$arr['dateFrom']}' and guozhangDate<='{$arr['dateTo']}'";
		}
		if($arr['clientId']!=''){
			$sql.=" and clientId='{$arr['clientId']}'";
		}
		$sql.=" group by clientId order by clientId";
		$rowset = $this->_modelExample->findBySql($sql);
		foreach($rowset as & $v2){
			$row[$v2['clientId']]['fsMoney']=round(($v2['fsMoney']+0),3);
		}

		//得到本期发票
		$str1="SELECT sum(money*huilv) as faPiaoMoney,clientId FROM `caiwu_ar_fapiao` where 1";
		if($arr['dateFrom']!=''){
			$str1.=" and fapiaoDate>='{$arr['dateFrom']}' and fapiaoDate<='{$arr['dateTo']}'";
		}
		if($arr['clientId']!=''){
			$str1.=" and clientId='{$arr['clientId']}'";
		}
		$str1.=" group by clientId order by clientId";
		$fukuan=$this->_modelExample->findBySql($str1);
		foreach ($fukuan as $v2){
			$row[$v2['clientId']]['faPiaoMoney']=round(($v2['faPiaoMoney']+0),3);
		}
		//dump($row);exit;
		$mClient=& FLEA::getSingleton('Model_jichu_client');
		if(count($row)>0){
			foreach($row as $key => & $v){
				$c=$mClient->find(array('id'=>$key));
				$v['clientId']=$key;
				$v['compName']=$c['compName'];
				
				$v['weishouMoney']=round(($v['initMoney']+$v['fsMoney']-$v['moneySk']),3);
			}
		}
		
		$heji=$this->getHeji($row,array('initMoney','moneySk','faPiaoMoney','weishouMoney','fsMoney'),'compName');
		foreach($row as $key=>& $v){
			$v['moneySk']="<a href='".url('caiwu_ys_Income','right',array(
						'clientId'=>$v['clientId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='收款明细'>".$v['moneySk']."</a>";
			$v['faPiaoMoney']="<a href='".url('caiwu_ys_fapiao','right',array(
						'clientId'=>$v['clientId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='开票明细'>".$v['faPiaoMoney']."</a>";
			$v['fsMoney']="<a href='".url('caiwu_ys_guozhang','right',array(
						'clientId'=>$v['clientId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='应收明细'>".$v['fsMoney']."</a>";

			//查看对账单
			$v['duizhang']="<a href='".$this->_url('Duizhang',array(
					'dateFrom'=>$arr['dateFrom'],
					'dateTo'=>$arr['dateTo'],
					'clientId'=>$v['clientId'],
					'no_edit'=>1,
			))."' target='_blank'>明细</a>";
			$v['duizhang'].="   <a href='".$this->_url('Duizhang2',array(
					'dateFrom'=>$arr['dateFrom'],
					'dateTo'=>$arr['dateTo'],
					'clientId'=>$v['clientId'],
					'no_edit'=>1,
			))."' target='_blank'>汇总</a>";

		}
		$row[]=$heji;
		// dump($row);exit;
		
		$arrFiled=array(
			'compName'=>array('text'=>"客户",'width'=>'200'),
			"initMoney" =>"期初余额",
			"fsMoney" =>"本期发生",
			"moneySk" =>"本期收款",
			"weishouMoney" =>"本期未收款",
			"faPiaoMoney" =>"本期开票",
			'duizhang'=>'对账单',
		);
		if($_GET['print']){
			unset($arrFiled['duizhang']);
		}
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrFiled);
		$smarty->assign('arr_condition',$arr);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_value',$row);
		$smarty->assign('heji',$heji);
		$smarty->assign('print_href',$this->_url($_GET['action'],array(
			'print'=>1
		)));
		$smarty->assign('title','应收款报表');
		if($_GET['print']) {
			//设置账期显示
			$smarty->assign('arr_main_value',array(
				'账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo'],
				'注'=>'金额已折合人民币',
			));
		}
		$smarty->assign('page_info',"<font color='green'>金额已折合人民币</font>");
		$smarty->display($tpl);
	}

	//明细对账单
	function actionDuizhang(){
		// dump($_GET);exit;
		$arr=$_GET;
		if(empty($arr['clientId'])){
			echo "缺少客户信息";exit;
		}
		//查找对账单客户
		$mClient=& FLEA::getSingleton('Model_jichu_client');
		$jgh=$mClient->find($arr['clientId']);
		// 对账单设计格式
		//查找期初欠款的情况
		//期初发生
		$sql="select sum(money) as money from caiwu_ar_guozhang where guozhangDate < '{$arr['dateFrom']}' and clientId='{$arr['clientId']}'";
		$res1=mysql_fetch_assoc(mysql_query($sql));
		//期初付款
		$sql="select sum(money) as money from caiwu_ar_income where shouhuiDate < '{$arr['dateFrom']}' and clientId='{$arr['clientId']}'";
		$res2=mysql_fetch_assoc(mysql_query($sql));
		$row['money']=$res1['money']-$res2['money'];
		$row['date']="<b>期初余额</b>";

		//本期应付款对账信息
		//查找应付款信息
		$sql="select x.*,y.orderCode,z.cntYaohuo,y.clientOrder,z.unit as unitYaohuo,
			a.pinzhong,a.proName,a.color,a.guige
			from caiwu_ar_guozhang x
			left join trade_order y on x.orderId=y.id
			left join trade_order2product z on z.id=x.ord2proId
			left join jichu_product a on x.productId=a.id	
			where 1";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.guozhangDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.guozhangDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by guozhangDate";
		$rows = $this->_modelExample->findBySql($sql);
		
		//查找已收款信息
		$sql="select x.money*x.huilv as shouhuimoney,x.shouhuiDate as guozhangDate,x.memo from caiwu_ar_income x where 1 ";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.shouhuiDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.shouhuiDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by shouhuiDate";
		$rows2 = $this->_modelExample->findBySql($sql);
		//合并应收款与已收款明细信息
		$rows=array_merge($rows,$rows2);
		//按照日期排序
		$rows=array_column_sort($rows,'guozhangDate',SORT_ASC);
		// dump($sql);exit;
		//处理数据
		foreach($rows as  & $v){
			$v['shoukuanMoney']=$v['shouhuimoney']==0?'':round($v['shouhuimoney'],2);
			$v['money']=$v['money']==0?'':round($v['money'],2);
			$v['moneyRmb']=$v['money']==0?'':round($v['money']*$v['huilv'],2);			
			if(!empty($v['cntYaohuo']))$v['cntYaohuo']=round($v['cntYaohuo'],2).$v['unitYaohuo'];
			if(!empty($v['cnt']))$v['cnt']=round($v['cnt'],2).$v['unit'];		
		}
		//合并数组
		$rowset=array_merge(array($row),$rows);
		// else $rowset=$rows;
		$ret[0]=$rowset[0];
		$ret[0]['date']	=$ret[0]['guozhangDate'];
		$i=0;
	

		foreach ($rows as & $v){
			$v['date']=$v['guozhangDate'];
			
			$ret[$i]=$v;
				$i++;
		}
		//dump($rows);exit;
		//获得时间内开票金额
		$sql="select x.fapiaoDate,x.money from caiwu_ar_fapiao x
					where 1";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.fapiaoDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.fapiaoDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by fapiaoDate";
		$fapiao = $this->_modelExample->findBySql($sql);
		foreach ($fapiao as & $v){
			if($v['money']>0){
				$i++;
				$ret[$i]['date']=$v['fapiaoDate'];
				$ret[$i]['fapiaoMoney']=$v['money'];
			}
		}
		
		//获得时间内付款金额
		$sql="select x.incomeDate,x.money from caiwu_income x
					where 1";
		
		if($arr['dateFrom']!=''){
			$sql.=" and x.incomeDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.incomeDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by incomeDate";
		$fukuan = $this->_modelExample->findBySql($sql);
		//dump($sql);exit;
		foreach ($fukuan as & $v){
			if($v['money']>0){
				$i++;
				$ret[$i]['date']=$v['incomeDate'];
				$ret[$i]['shoukuanMoney']=$v['money'];
			}
		}
		$ret=array_column_sort($ret,'date');
		$ret2=array_merge(array($row),$ret);
		$heji = $this->getHeji($ret, array('cnt','money','fapiaoMoney','shoukuanMoney'), 'date');
		$heji['Ymoney']=$heji['money']-$heji['shoukuanMoney'];
		$ret[]=$heji;
 		//dump($ret);exit;
		$arr_field_info=array(
			'date'=>'日期',
			//'orderCode'=>'订单编号',
			//'clientOrder'=>'客户合同号',
			// 'proName'=>'品名',
			 'pinzhong'=>'品种',
			 'guige'=>'规格',
			 //'color'=>'颜色',
			//'chukuDate'=>'出库日期',
			//'cntYaohuo'=>'要货数',
			'cnt'=>'数量',
			//'bizhong'=>'币种',
			//'danjia'=>'单价',
			'money'=>'应收款',
			'fapiaoMoney'=>'已开票',
			'shoukuanMoney'=>'已收款',
			'Ymoney'=>'余额',
			'memo'=>'备注',
		);
		$smarty=& $this->_getView();
		$smarty->assign('title',"{$jgh['compName']}对账单");
		$smarty->assign('arr_main_value',array('账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo']));
		$smarty->assign('arr_condition',$arr);
		if($_GET['no_edit']!=1){
			$smarty->assign('sonTpl',"caiwu/ys/sonTpl.tpl");
		}
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$ret);
		$smarty->display('printOld.tpl');
	}

	//汇总对账单
	function actionDuizhang2(){
		// dump($_GET);exit;
		$arr=$_GET;
		if(empty($arr['clientId'])){
			echo "缺少客户信息";exit;
		}
		//查找对账单客户
		$mClient=& FLEA::getSingleton('Model_jichu_client');
		$jgh=$mClient->find($arr['clientId']);
		// 对账单设计格式
		//查找期初欠款的情况
		//期初发生
		$sql="select sum(money) as money from caiwu_ar_guozhang where guozhangDate < '{$arr['dateFrom']}' and clientId='{$arr['clientId']}'";
		$res1=mysql_fetch_assoc(mysql_query($sql));
		//期初付款
		$sql="select sum(money) as money from caiwu_ar_income where shouhuiDate < '{$arr['dateFrom']}' and clientId='{$arr['clientId']}'";
		$res2=mysql_fetch_assoc(mysql_query($sql));
		$row['money']=$res1['money']-$res2['money'];
		$row['date']="<b>期初余额</b>";
	
		//本期应付款对账信息
		//查找应付款信息
		$sql="select x.guozhangDate,sum(x.cnt) cnt,sum(x.money) money,y.orderCode,z.cntYaohuo,y.clientOrder,z.unit as unitYaohuo
			from caiwu_ar_guozhang x
			left join trade_order y on x.orderId=y.id
			left join trade_order2product z on z.id=x.ord2proId
			where 1";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.guozhangDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.guozhangDate <= '{$arr['dateTo']}'";
		}
		$sql.=" group by x.guozhangDate order by guozhangDate";
		$rows = $this->_modelExample->findBySql($sql);
	
		//查找已收款信息
		$sql="select sum(x.money*x.huilv) as shouhuimoney,x.shouhuiDate as guozhangDate,x.memo from caiwu_ar_income x where 1 ";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.shouhuiDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.shouhuiDate <= '{$arr['dateTo']}'";
		}
		$sql.=" group by x.shouhuiDate order by shouhuiDate";
		$rows2 = $this->_modelExample->findBySql($sql);
		//合并应收款与已收款明细信息
		$rows=array_merge($rows,$rows2);
		//按照日期排序
		$rows=array_column_sort($rows,'guozhangDate',SORT_ASC);
		// dump($sql);exit;
		//处理数据
		foreach($rows as  & $v){
			$v['shoukuanMoney']=$v['shouhuimoney']==0?'':round($v['shouhuimoney'],2);
			$v['money']=$v['money']==0?'':round($v['money'],2);
			$v['moneyRmb']=$v['money']==0?'':round($v['money']*$v['huilv'],2);
			if(!empty($v['cntYaohuo']))$v['cntYaohuo']=round($v['cntYaohuo'],2).$v['unitYaohuo'];
			if(!empty($v['cnt']))$v['cnt']=round($v['cnt'],2).$v['unit'];
		}
		//合并数组
		$rowset=array_merge(array($row),$rows);
		// else $rowset=$rows;
		$ret[0]=$rowset[0];
		$ret[0]['date']	=$ret[0]['guozhangDate'];
		$i=0;
	
	
		foreach ($rows as & $v){
			$v['date']=$v['guozhangDate'];
				
			$ret[$i]=$v;
			$i++;
		}
		//dump($rows);exit;
		//获得时间内开票金额
		$sql="select x.fapiaoDate,sum(x.money) money from caiwu_ar_fapiao x
					where 1";
		if($arr['clientId']!=''){
			$sql.=" and x.clientId='{$arr['clientId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.fapiaoDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.fapiaoDate <= '{$arr['dateTo']}'";
		}
		$sql.=" group by x.fapiaoDate order by fapiaoDate";
		$fapiao = $this->_modelExample->findBySql($sql);
		foreach ($fapiao as & $v){
			if($v['money']>0){
				$i++;
				$ret[$i]['date']=$v['fapiaoDate'];
				$ret[$i]['fapiaoMoney']=$v['money'];
			}
		}
	
		//获得时间内付款金额
		$sql="select x.incomeDate,sum(x.money) money from caiwu_income x
					where 1";
	
		if($arr['dateFrom']!=''){
			$sql.=" and x.incomeDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.incomeDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by incomeDate";
		$fukuan = $this->_modelExample->findBySql($sql);
		//dump($sql);exit;
		foreach ($fukuan as & $v){
			if($v['money']>0){
				$i++;
				$ret[$i]['date']=$v['incomeDate'];
				$ret[$i]['shoukuanMoney']=$v['money'];
			}
		}
		$ret=array_column_sort($ret,'date');
		$ret2=array_merge(array($row),$ret);
		$heji = $this->getHeji($ret, array('cnt','money','fapiaoMoney','shoukuanMoney'), 'date');
		$heji['Ymoney']=$heji['money']-$heji['shoukuanMoney'];
		$ret[]=$heji;
		//dump($ret);exit;
		$arr_field_info=array(
				'date'=>'日期',
				//'orderCode'=>'订单编号',
				//'clientOrder'=>'客户合同号',
				// 'proName'=>'品名',
				//'pinzhong'=>'品种',
				//'guige'=>'规格',
				//'color'=>'颜色',
				//'chukuDate'=>'出库日期',
				//'cntYaohuo'=>'要货数',
				'cnt'=>'数量',
				//'bizhong'=>'币种',
				//'danjia'=>'单价',
				'money'=>'应收款',
				'fapiaoMoney'=>'已开票',
				'shoukuanMoney'=>'已收款',
				'Ymoney'=>'余额',
				'memo'=>'备注',
		);
		$smarty=& $this->_getView();
		$smarty->assign('title',"{$jgh['compName']}对账单");
		$smarty->assign('arr_main_value',array('账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo']));
		$smarty->assign('arr_condition',$arr);
		if($_GET['no_edit']!=1){
			$smarty->assign('sonTpl',"caiwu/ys/sonTpl.tpl");
		}
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$ret);
		$smarty->display('printOld.tpl');
	}
	
	
	//删除
	function actionRemove(){
		//去掉入库信息中的guozhangid
		$gzModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Chuku2Product');
		$arr=$this->_modelExample->find($_GET['id']);
		//dump($arr);exit;
		$guozhang=array(
			'danjia'=>$arr['danjia'],
			'money'=>$arr['_money'],
			'isHaveGz'=>1,
			'id'=>$arr['chuku2proId']
		);

		parent::actionRemove();
	}

	function actionAdd() {
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('sonTpl', 'caiwu/ys/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}

	function actionEdit() {
		$row = $this->_modelExample->find(array('id' => $_GET['id']));

		$row['danjia']=round($row['danjia'],3);
		$row['cnt']=round($row['cnt'],3);
		$row['cntM']=round($row['cntM'],3);
		$row['money']=round($row['money'],3);
		$row['huilv']=round($row['huilv'],3);
		
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row); 
		//处理出库单号
		$mChuku = & FLEA::getSingleton('Model_Shengchan_Cangku_Chuku');
		$chuku = $mChuku->find(array('id'=>$row['chukuId']));
		// $this->fldMain['chuku2proId']['text'] = $chuku['chukuCode'];
		$this->fldMain['clientId']['clientName']=$row['Client']['compName'];
		$this->fldMain['_money']['addonEnd']='<a href="javascript:;" src="'.url('Shengchan_Chuku','LookMX',array(
			'width'=>860,
			'id'=>$row['chukuId']
			)).'" class="dialog">明细</a>';

		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('aRow', $row);
		$smarty->assign('sonTpl', 'caiwu/yf/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}
	

	/**
	 * 获取过账信息，没有标记开票完成的均查找
	 * Time：2014/08/05 14:19:56
	 * @author li
	 * @param GET
	 * @return JSON
	*/
	function actionGetYingshou(){
		$clientId = (int)$_GET['clientId'];
		//查找过账信息
		$sql="select x.chukuDate,x.money,x.huilv,x.cnt,x.unit,
		x.danjia,x.id,x.orderId,x.ord2proId,x.qitaMemo,z.color,
		z.dengji,a.proName,a.guige,a.pinzhong,b.orderCode,c.chukuCode Code from caiwu_ar_guozhang x
		left join jichu_product y on x.productId=y.id
		left join cangku_chuku_son z on x.chuku2proId=z.id
		left join jichu_product a on z.productId=a.id
		left join trade_order b on b.id=x.orderId
		left join cangku_chuku c on c.id=x.chukuId
		where x.clientId='{$clientId}' and x.fapiaoOver=0 order by x.chukuDate,x.guozhangDate";
		$guozhang = $this->_modelExample->findBySql($sql);
		//dump($sql);exit;
		foreach ($guozhang as & $v) {
			$v['danjia']=round($v['danjia'],6);
			$v['money']=round($v['money'],6);
			$v['cnt']=round($v['cnt'],6);
			$v['huilv']=round($v['huilv'],6);

			//查找已开票信息
			$sql="select sum(money) as money from caiwu_ar_fapiao2guozhang where guozhangId='{$v['id']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$v['ykmoney'] = round($_temp[0]['money'],3)+0;
		}

		$success=true;
		if(!$clientId>0){
			$success=false;
			$msg="请选择客户信息";
		}elseif(count($guozhang)==0){
			$success=false;
			$msg="该客户不存在需要开发票的应收项";
		}

		echo json_encode(array(
			'success'=>$success,
			'msg'=>$msg,
			'data'=>$guozhang
		));exit;
	}

	
	/**
	 * 获取过账信息
	 * @author shirui
	 * @param GET
	 * @return JSON
	 */
	function actionGetYingshou2(){
		$clientId = (int)$_GET['clientId'];
		//查找过账信息
		$sql="select x.chukuDate,x.money,x.huilv,x.cnt,x.unit,x.incomeOver,
		x.danjia,x.id,x.orderId,x.ord2proId,x.qitaMemo,z.color,
		z.dengji,a.proName,a.guige,a.pinzhong,b.orderCode,c.chukuCode Code from caiwu_ar_guozhang x
		left join jichu_product y on x.productId=y.id
		left join cangku_chuku_son z on x.chuku2proId=z.id
		left join jichu_product a on z.productId=a.id
		left join trade_order b on b.id=x.orderId
		left join cangku_chuku c on c.id=x.chukuId
		where x.clientId='{$clientId}' and x.incomeOver=0  order by x.chukuDate,x.guozhangDate";
		$guozhang = $this->_modelExample->findBySql($sql);
		//dump($sql);exit;
		foreach ($guozhang as & $v) {
		$v['danjia']=round($v['danjia'],6);
		$v['money']=round($v['money'],6);
		$v['cnt']=round($v['cnt'],6);
		$v['huilv']=round($v['huilv'],6);
	
			//查找已开票信息
		$sql="select sum(money) as money from caiwu_ar_fapiao2guozhang where guozhangId='{$v['id']}'";
		$_temp = $this->_modelExample->findBySql($sql);
		$v['ykmoney'] = round($_temp[0]['money'],3)+0;
		}
	
		$success=true;
		if(!$clientId>0){
		$success=false;
		$msg="请选择客户信息";
		}elseif(count($guozhang)==0){
		$success=false;
		$msg="该客户不存在需要开核销的应收项";
		}
	
		echo json_encode(array(
		'success'=>$success,
		'msg'=>$msg,
			'data'=>$guozhang
		));exit;
		}
	
	
	/**
	 * 改变发票是否完成的状态，ajax
	 * Time：2014/08/05 20:26:33
	 * @author li
	 * @param get
	 * @return json
	*/
	function actionSetFapiaoOver(){
		$guozhangId=(int)$_GET['guozhangId'];
		$fapiaoOver=(int)$_GET['fapiaoOver'];
		$sql="update caiwu_ar_guozhang set fapiaoOver='{$fapiaoOver}' where id='{$guozhangId}'";
		$temp=$this->_modelExample->execute($sql);
		echo json_encode(array('success'=>$temp));
	}
	
	/*
	 * by shirui
	* 其他过账
	*/
	function actionOtherGuozhang(){
		$this->authCheck();
		//搭建过账界面
		$fldMain = array(
			'guozhangDate' => array('title' => '过账日期', "type" => "calendar", 'value' => date('Y-m-d')),
			
			'clientId' => array('title' => '客户名称', 'type' => 'clientpopup', 'clientName' => ''),
			'qitaMemo' => array('title' => '过账原因', 'type' => 'text', 'value' => ''),
			'money' => array('title' => '应收金额', 'type' => 'text', 'value' => ''),
			'bizhong' => array('title' => '币种', 'type' => 'select', 'value' => 'RMB', 'options' => array(
					array('text' => 'RMB', 'value' => 'RMB'),
					array('text' => 'USD', 'value' => 'USD'),
					)),
			'huilv' => array('title' => '汇率', 'type' => 'text', 'value' => '1'),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
			'kind' => array('type' => 'hidden', 'value' => '其它'),
			// 'productId' => array('type' => 'hidden', 'value' => ''),
			// 'chukuId' => array('type' => 'hidden', 'value' => ''),
			// 'orderId' => array('type' => 'hidden', 'value' => ''),
			// 'ord2proId' => array('type' => 'hidden', 'value' => ''),
		);
		
		if($_GET['id']>0){
			$row = $this->_modelExample->find(array('id' => $_GET['id']));

			$row['danjia']=round($row['danjia'],3);
			$row['money']=round($row['money'],3);
			$row['huilv']=round($row['huilv'],3);
			$fldMain = $this->getValueFromRow($fldMain, $row); 
		}
		
		if($_GET['fromAction']=='')$_GET['fromAction']=$_GET['action'];
		
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('form', array('action'=>'SaveOther'));
		$smarty->assign('sonTpl', 'caiwu/ys/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}

	function actionSaveOther(){
		// dump($_POST);exit;
		$arr=array(
			'id'=>$_POST['id'],
			'guozhangDate'=>$_POST['guozhangDate'],
			'clientId'=>$_POST['clientId'],
			'qitaMemo'=>$_POST['qitaMemo'],
			// 'rukuDate'=>$_POST['rukuDate'],
			'money'=>$_POST['money'],
			'bizhong'=>$_POST['bizhong'],
			'huilv'=>$_POST['huilv'],
			'memo'=>$_POST['memo'],
			'creater'=>$_POST['creater'],
			'kind'=>$_POST['kind'],
		);

		$this->_modelExample->save($arr);

		$from=$_POST['fromAction']!='' ? $_POST['fromAction'] : 'OtherGuozhang';
		js_alert(null,'window.parent.showMsg("操作成功");',$this->_url($from));
	}
	
	/*
	 * by shirui
	* 查询其它过账
	*/
	function actionRight2() {
		// $this->authCheck('4-2-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'clientId'=>'',
			'no_edit'=>'',
			'no_time'=>'',
		));
		$sql="SELECT x.*,z.compName
			from caiwu_ar_guozhang x 
			left join jichu_client z on z.id=x.clientId
			where 1";
		
		if($arr['no_time']!=''){
			$arr['dateFrom']='';
			$arr['dateTo']='';
		}

		if($arr['dateFrom']!='')$sql.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
		if($arr['clientId']!='')$sql.=" and x.clientId='{$arr['clientId']}'";
		
		$sql.=" and x.kind='其它' order by x.id asc";
		// dump($sql);exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		foreach($rowset as & $v) {
			$v['_edit']= "<a href='".$this->_url('OtherGuozhang',array(
				'id'=>$v['id'],
				'fromAction'=>$_GET['action'],
			))."' title='过账编辑'>修改</a>". '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);

			//核销的情况下不能修改删除
			if($v['moneyYishou']>0 || $v['moneyFapiao']>0)$v['_edit']="<span title='已核销，禁止操作'>修改&nbsp;&nbsp;删除</span>";

			$v['money']=round($v['money'],3);
            $v['cnt']=round($v['cnt'],3);
            $v['danjia']=round($v['danji'],3);
			//折合人民币
			$v['moneyRmb']=round($v['money']*$v['huilv'],3);
             //dump($v['money']);dump($v['huilv']);dump($v['moneyRmb']);exit;
			//是否开票完成
			if($v['fapiaoOver']==0){
				$v['fapiaoOver']='';
			}else{
				$v['fapiaoOver']='是';
			}
		}
		$rowset[] = $this->getHeji($rowset, array('cnt','money','moneyRmb'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
			"_edit"=>'操作',
			"compName"=>array('text'=>'客户','width'=>160),
			"guozhangDate"=>'日期',
			"money"=>array('text'=>'应收金额','width'=>100),
			'moneyRmb'=>'金额(RMB)',
			"bizhong"=>array('text'=>'币种','width'=>100),
			"huilv"=>array('text'=>'汇率','width'=>100),
			"memo"=>"备注",
			"creater"=>"制单人",
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrField);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display', 'none');
		$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
		$smarty->display($tpl);
	}
}
?>