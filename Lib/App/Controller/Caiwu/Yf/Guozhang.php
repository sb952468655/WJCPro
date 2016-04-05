<?php
FLEA::loadClass('Tmis_Controller');
class Controller_Caiwu_Yf_Guozhang extends Tmis_Controller {

    function __construct() {
        $this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Yf_Guozhang');
        $this->_modelRuku2Pro = & FLEA::getSingleton('Model_Shengchan_Cangku_Ruku2Product');

        //搭建过账界面
        $this->fldMain = array(
			'guozhangDate' => array('title' => '过账日期', "type" => "calendar", 'value' => date('Y-m-d')),
			/*'ruku2ProId' => array(
				'title' => '选择入库', 
				'type' => 'popup', 
				'name'=>'ruku2ProId',
				'text'=>'选择入库',
				'url'=>url('Shengchan_Ruku','PopupOnGuozhang'),//弹出地址,回调函数在sonTpl中进行定义,
				'textFld'=>'rukuCode',//显示在text中的字段
				'hiddenFld'=>'id',//显示在hidden控件中的字段
				'dialogWidth'=>950,
			),*/
			'supplierId' => array('title' => '供应商', 'type' => 'select', 'value' => '','model'=>'Model_Jichu_Jiagonghu','condition'=>'isSupplier=1'),
			// 'qitaMemo' => array('title' => '描述', 'type' => 'text', 'value' => '','readonly'=>true),
			'rukuDate' => array('title' => '发生日期', 'type' => 'text', 'value' => '','readonly'=>true),
			'cnt' => array('title' => '数量', 'type' => 'text', 'value' => '','readonly'=>true),
			'danjia' => array('title' => '单价', 'type' => 'text', 'value' => ''),
			'_money' => array('title' => '金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
			'zhekouMoney' => array('title' => '折扣金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
			'money' => array('title' => '入账金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
			'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
			'id' => array('type' => 'hidden', 'value' => ''),
			'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
			'kind' => array('type' => 'hidden', 'value' => ''),
			'productId' => array('type' => 'hidden', 'value' => ''),
			'rukuId' => array('type' => 'hidden', 'value' => ''),
			'isJiagong' => array('type' => 'hidden', 'value' => ''),
		);

		// 表单元素的验证规则定义
		$this->rules = array(
			'guozhangDate' => 'required',
			'supplierId' => 'required',
			'money' => 'required number',
			'zhekouMoney' => 'number'
		);
    }

	function actionRight() {
		// $this->authCheck('4-1-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'supplierId2'=>'',
			'no_edit'=>'',
		));
		$sql="select x.*,y.pinzhong,y.proName,y.color,y.guige,z.compName from caiwu_yf_guozhang x 
			left join jichu_product y on x.productId=y.id
			left join jichu_jiagonghu z on z.id=x.supplierId
			where 1";
		if($arr['orderId']>0){
			$arr['dateFrom']='';
			$arr['dateTo']='';
			$sql.=" and x.orderId='{$arr['orderId']}'";
		}
		if($arr['dateFrom']!='')$sql.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
		if($arr['supplierId2']!='')$sql.=" and x.supplierId='{$arr['supplierId2']}'";
		if($arr['compName']!='')$sql.=" and z.compName like '%{$arr['compName']}%'";
		if($arr['orderCode']!='')$sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['product']!='')$sql.=" and a.product like '%{$arr['product']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		$sql.=" and x.kind!='其它' order by x.id asc";
		// dump($sql);exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
        //dump($rowset);exit;
		foreach($rowset as & $v) {
			if($v['isJiagong']==1){
				$v['_edit']= "<a href='".url('Caiwu_Yf_GuozhangJg','Edit',array(
					'id'=>$v['id'],
					'fromController'=>'Caiwu_Yf_GuozhangJg',
					'fromAction'=>$_GET['action'],
				))."' title='过账编辑'>修改</a>";
			}else{
				$v['_edit']= "<a href='".$this->_url('Edit',array(
					'id'=>$v['id'],
					'fromController'=>'Caiwu_Yf_Guozhang',
					'fromAction'=>$_GET['action'],
				))."' title='过账编辑'>修改</a>";
			}
			
			$v['_edit'] .= '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
			//核销的情况下不能修改删除
			if($v['yifukuan']>0 || $v['yishouPiao']>0)$v['_edit']="<span title='已核销，禁止操作'>修改&nbsp;&nbsp;删除</span>";
            
            $v['cnt']=round($v['cnt'],3);
            $v['danjia']=round($v['danjia'],3);
            $v['money']=round($v['money'],3);
            $v['zhekouMoney']=round($v['zhekouMoney'],3);
            $v['_money']=round($v['_money'],3);
		}
		$rowset[] = $this->getHeji($rowset, array('cnt','money'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
			"_edit"=>'操作',
			"compName"=>'应付对象',
			"guozhangDate"=>'过账日期',
			// "kind"=>'类别',
			// "rukuNum"=>'入库编号',
			"rukuDate"=>'发生日期',
			"proName"=>'品名',
			"guige"=>'规格',
			"color"=>'颜色',
			//"pinzhong"=>'品种',
			//"qitaMemo"=>array('text'=>'描述','width'=>160),
			// "unit"=>array('text'=>'单位','width'=>70),
			"cnt"=>array('text'=>'数量','width'=>90),
			//"danjia"=>array('text'=>'单价','width'=>70),
			"_money"=>array('text'=>'发生金额','width'=>90),
			"zhekouMoney"=>array('text'=>'折扣金额','width'=>90),
			"money"=>array('text'=>'应付金额','width'=>90),
			// "huilv"=>array('text'=>'汇率','width'=>70),
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

	function actionRightYif() {
		// $this->authCheck('4-1-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			// 'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			// 'dateTo'=>date('Y-m-d'),
			'supplierId'=>'',
			'orderCode'=>'',
			'product'=>'',
			'guige'=>'',
			'orderId'=>'',
			'no_edit'=>'',
		));
		$sql="select x.*,z.compName,y.orderCode from caiwu_yf_guozhang x 
			left join trade_order y on x.orderId=y.id
			left join trade_order2product a on a.id=x.ord2proId
			left join jichu_jiagonghu z on z.id=x.supplierId
			where 1";

		if($arr['orderId']>0){
			$arr['dateFrom']='';
			$arr['dateTo']='';
			$sql.=" and x.orderId='{$arr['orderId']}'";
		}
		if($arr['dateFrom']!='')$sql.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
		if($arr['supplierId']!='')$sql.=" and x.supplierId='{$arr['supplierId']}'";
		if($arr['orderCode']!='')$sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['product']!='')$sql.=" and a.product like '%{$arr['product']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		$sql.=" order by x.id asc";
		// dump($sql);exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		
		$rowset[] = $this->getHeji($rowset, array('yifukuan','money'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
			// "_edit"=>'操作',
			"compName"=>'加工供应商',
			"guozhangDate"=>'日期',
			"kind"=>'类别',
			"orderCode"=>'生产编号',
			"product"=>$this->getManuCodeName(),
			"guige"=>'规格',
			// "unit"=>array('text'=>'单位','width'=>70),
			// "cnt"=>array('text'=>'数量','width'=>70),
			// "danjia"=>array('text'=>'单价','width'=>70),
			"zhekouMoney"=>array('text'=>'折扣金额','width'=>70),
			"money"=>array('text'=>'应付金额','width'=>70),
			"yifukuan"=>array('text'=>'已付款','width'=>70),
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
		
		foreach($this->fldMain as $k=>&$vv) {
			$name = $vv['name']?$vv['name']:$k;
			$arr[$k] = $_POST[$name];
		}
		

		$this->_modelExample->save($arr);

		$from=$_POST['fromAction']!='' ? $_POST['fromAction'] : 'add';
		js_alert(null,'window.parent.showMsg("操作成功");',$this->_url($from));
	}

	
	//应付款报表
	function actionReport(){
		// $this->authCheck('4-1-7');
		$tpl = $_GET['print']?'Print.tpl':'TblList.tpl';
		FLEA::loadclass('TMIS_Pager');
		$arr=TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-01'),
			'dateTo'=>date('Y-m-d'),
			'supplierId2'=>'',
		));
		//得到期初发生
		//应付款表中查找,日期为期初日期
		//按照加工商汇总
		$sql="select sum(money) as fsMoney,supplierId from caiwu_yf_guozhang where guozhangDate < '{$arr['dateFrom']}'";
		if($arr['supplierId2']!=''){
			$sql.=" and supplierId='{$arr['supplierId2']}'";
		}
		$sql.=" group by supplierId order by supplierId";
		$rowset = $this->_modelExample->findBySql($sql);
		
		foreach($rowset as & $v){
			//期初金额
			$row[$v['supplierId']]['initMoney']=round(($v['fsMoney']+0),3);//期初余额
			$row[$v['supplierId']]['initIn']=round(($v['fsMoney']+0),3);
		}
		//得到起始日期前的收款金额
		//从付款表中查找
		//按照加工商汇总
		$sqlIncome = "SELECT sum(x.money) as FukuMoney,supplierId FROM `caiwu_yf_fukuan` x 
		
		where  x.fukuanDate < '{$arr['dateFrom']}'";
		if($arr['supplierId2']!=''){
			$sqlIncome.=" and x.supplierId='{$arr['supplierId2']}'";
		}
		$sqlIncome.=" group by x.supplierId order by x.supplierId";
		$rowset = $this->_modelExample->findBySql($sqlIncome);
		
		foreach($rowset as & $v){
			//期初金额
			$row[$v['supplierId']]['initMoney']=round(($row[$v['supplierId']]['initMoney']-$v['FukuMoney']+0),3);//期初余额=期初发生-期初已付款
			$row[$v['supplierId']]['initOut']=round($v['FukuMoney'],3);
		}
		
		//得到本期的已付款
		//付款表中查找
		//按照加工户汇总
		$str="SELECT sum(x.money) as moneyfukuan,x.supplierId from caiwu_yf_fukuan x				
				where 1 ";
		if($arr['dateFrom']!=''){
			$str.=" and x.fukuanDate>='{$arr['dateFrom']}' and x.fukuanDate<='{$arr['dateTo']}'";
		}
		if($arr['supplierId2']!=''){
			$str.=" and supplierId='{$arr['supplierId2']}'";
		}
		$str.=" group by x.supplierId order by x.supplierId";
		//echo $str;exit;
		$fukuan=$this->_modelExample->findBySql($str);
		
		foreach($fukuan as & $v1){
			$row[$v1['supplierId']]['fukuanMoney']=round(($v1['moneyfukuan']+0),3);
		}
		//dump($str);exit;
		//得到本期发生
		//应付款表中查找
		//按照加工户汇总
		$sql="select sum(money) as fsMoney,supplierId from caiwu_yf_guozhang where 1";
		if($arr['dateFrom']!=''){
			$sql.=" and guozhangDate>='{$arr['dateFrom']}' and guozhangDate<='{$arr['dateTo']}'";
		}
		if($arr['supplierId2']!=''){
			$sql.=" and supplierId='{$arr['supplierId2']}'";
		}
		$sql.=" group by supplierId order by supplierId";
		$rowset = $this->_modelExample->findBySql($sql);
		
		foreach($rowset as & $v2){
			$row[$v2['supplierId']]['fsMoney']=round(($v2['fsMoney']+0),3);
			//$row[$v2['supplierId']]['isY']=$v2['isY'];
		}

		//得到本期发票
		$str1="SELECT sum(x.money) as faPiaoMoney,x.supplierId FROM `caiwu_yf_fapiao` x 				
				where 1";
		if($arr['dateFrom']!=''){
			$str1.=" and x.fapiaoDate>='{$arr['dateFrom']}' and x.fapiaoDate<='{$arr['dateTo']}'";
		}
		if($arr['supplierId2']!=''){
			$str1.=" and x.supplierId='{$arr['supplierId2']}'";
		}
		$str1.=" group by x.supplierId order by x.supplierId";
		$fukuan=$this->_modelExample->findBySql($str1);
		//dump($row);exit;
		foreach ($fukuan as $v2){
			$row[$v2['supplierId']]['faPiaoMoney']=round(($v2['faPiaoMoney']+0),3);
		}
		
		$m=& FLEA::getSingleton('Model_Jichu_Jiagonghu');
		if(count($row)>0){
			foreach($row as $key => & $v){
				$c=$m->find(array('id'=>$key));
				$v['supplierId']=$key;
				$v['compName']=$c['compName'];
				
				$v['weifuMoney']=round(($v['initMoney']+$v['fsMoney']-$v['fukuanMoney']),3);
			}
		}
		
		$heji=$this->getHeji($row,array('initMoney','fukuanMoney','faPiaoMoney','weifuMoney','fsMoney'),'compName');
		foreach($row as $key=>& $v){
			$v['fukuanMoney']="<a href='".url('caiwu_Yf_Fukuan','right',array(
						'supplierId2'=>$v['supplierId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='付款明细'>".$v['fukuanMoney']."</a>";
			$v['faPiaoMoney']="<a href='".url('caiwu_Yf_Fapiao','right',array(
						'supplierId2'=>$v['supplierId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='收票明细'>".$v['faPiaoMoney']."</a>";
			$v['fsMoney']="<a href='".url('caiwu_Yf_Guozhang','right',array(
						'supplierId2'=>$v['supplierId'],
						'dateFrom'=>$arr['dateFrom'],
						'dateTo'=>$arr['dateTo'],
						'width'=>'700',
						'no_edit'=>1,
						'TB_iframe'=>1,))."' class='thickbox' title='应付明细'>".$v['fsMoney']."</a>";

			//查看对账单
			
    		$v['duizhang']="<a href='".$this->_url('Duizhang',array(
					'dateFrom'=>$arr['dateFrom'],
					'dateTo'=>$arr['dateTo'],
					'supplierId'=>$v['supplierId'],
		            //'isY'=>$v['isY'],
					'no_edit'=>1,
			))."' target='_blank'>明细</a>";
    		
    		$v['duizhang'].="   <a href='".$this->_url('Duizhang2',array(
    				'dateFrom'=>$arr['dateFrom'],
    				'dateTo'=>$arr['dateTo'],
    				'supplierId'=>$v['supplierId'],
    				//'isY'=>$v['isY'],
    				'no_edit'=>1,
    		))."' target='_blank'>汇总</a>";
    				
			
		}
		$row[]=$heji;

		$arrFiled=array(
			'compName'=>"对象名称",
			"initMoney" =>"期初余额",
			"fsMoney" =>"本期发生",
			"fukuanMoney" =>"本期付款",
			"weifuMoney" =>"本期结余",
			"faPiaoMoney" =>"本期收票",
			'duizhang'=>'对账单',
			// 'hexiao'=>'核销',
		);
		//dump($row);exit;
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
		$smarty->assign('title','应付款报表');
		if($_GET['print']) {
			//设置账期显示
			$smarty->assign('arr_main_value',array(
				'账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo']
			));
		}
		$smarty->display($tpl);
	}

	//明细对账单
	function actionDuizhang(){
		//dump($_GET);exit;
		$arr=$_GET;
		if(empty($arr['supplierId'])){
			echo "缺少供应加工商信息";exit;
		}
		//查找对账单加工户
		$mClient=& FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$jgh=$mClient->find($arr['supplierId']);
		// 对账单设计格式
		//查找期初欠款的情况
		//期初发生
		$sql="select isJiagong,sum(money) as money from caiwu_yf_guozhang where guozhangDate < '{$arr['dateFrom']}' and supplierId='{$arr['supplierId']}'";
		$res1=mysql_fetch_assoc(mysql_query($sql));
		//期初付款
		$sql="select sum(money) as money from caiwu_yf_fukuan where fukuanDate < '{$arr['dateFrom']}' and supplierId='{$arr['supplierId']}'";
		$res2=mysql_fetch_assoc(mysql_query($sql));
		$row['money']=$res1['money']-$res2['money'];
		$row['date']="<b>期初余额</b>";

		//本期应付款对账信息
		//查找应付款信息
		$sql="select x.*,y.pinzhong,y.proName,y.color,y.guige from caiwu_yf_guozhang x	
				left join jichu_product y on x.productId=y.id			
			where 1";
		if($arr['supplierId']!=''){
			$sql.=" and x.supplierId='{$arr['supplierId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.guozhangDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.guozhangDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by rukuDate";
		$rows = $this->_modelExample->findBySql($sql);
		//dump($rows);exit;
		
		//处理数据
		foreach($rows as  & $v){
			$v['money']=$v['money']==0?'':round($v['money'],2);
			$v['zhekouMoney']=$v['zhekouMoney']==0?'':round($v['zhekouMoney'],2);
			$v['cnt']=$v['cnt']==0?'':round($v['cnt'],2);
			$v['danjia']=$v['danjia']==0?'':round($v['danjia'],2);
		}
		
		$ret=null;
		$i=0;
		//判断是否为供应商
		$sql="select x.* from jichu_jiagonghu x where x.id='{$_GET['supplierId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$isSupplier=$r[0]['isSupplier'];
		if($isSupplier==0){//采购过账
			//dump($rows);exit;
			foreach ($rows as & $v){
				$v['date']=$v['guozhangDate'];	
				$ret[$i]=$v;
				$i++;			
			}				
			$arr_field_info=array(
 					'date'=>'日期',		
                    'kind'=>'发生工序',
					'cnt'=>'总数量',
					'proName'=>'品名',
					'guige'=>'规格',
					'color'=>'颜色',
					'money'=>'应付金额',
					'fapiaoMoney'=>'收票金额',
					'fukuanMoney'=>'已付款',
					'memo'=>'备注',
			);			
		}else{//加工过账
			foreach ($rows as & $v){
				if($v['rukuId']>0){
					 if($v['isLingyong']==1){//领用过账
					 	//dump($v);exit;
					 	$sql="select * from jichu_product where id='{$v['productId']}'";
					 	$temp = $this->_modelExample->findBySql($sql);
					 	//dump($temp);exit;
					 }else{//验收过账
					 	$sql="select x.pihao,sum(x.cntJian) cntJian,y.proName,y.guige,y.color from cangku_ruku_son x
					 	left join jichu_product y on y.id=x.productId where x.rukuId='{$v['rukuId']}'";
					 	$temp = $this->_modelExample->findBySql($sql);				 	
					 }
					 $v['proName']=$temp[0]['proName'];
					 $v['guige']=$temp[0]['guige'];
					 $v['color']=$temp[0]['color'];
					 $v['cntJian']=$temp[0]['cntJian'];
					 $v['pihao']=$temp[0]['pihao'];					
				}
				$v['date']=$v['guozhangDate'];
				$ret[$i]=$v;
				$i++;
			}
						
			$arr_field_info=array(
 					'date'=>'日期',
					'proName'=>'纱支',
					'guige'=>'规格',
					'color'=>'颜色',
					'pihao'=>'批号',
					'cntJian'=>'包数',
					'cnt'=>'数量',
					'danjia'=>'单价',
					'money'=>'应付金额',
					'fapiaoMoney'=>'已收票',
					'fukuanMoney'=>'已付金额',
					'memo'=>'备注',
			);
		}
		//获得时间内开票金额
		$sql="select x.fapiaoDate,x.money from caiwu_yf_fapiao x
					where 1";
		if($arr['supplierId']!=''){
			$sql.=" and x.supplierId='{$arr['supplierId']}'";
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
		$sql="select x.fukuanDate,x.money from caiwu_yf_fukuan x
					where 1";
		if($arr['supplierId']!=''){
			$sql.=" and x.supplierId='{$arr['supplierId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.fukuanDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.fukuanDate <= '{$arr['dateTo']}'";
		}
		$sql.=" order by fukuanDate";
		$fukuan = $this->_modelExample->findBySql($sql);
		//dump($sql);exit;
		foreach ($fukuan as & $v){
			if($v['money']>0){
				$i++;
				$ret[$i]['date']=$v['fukuanDate'];
				$ret[$i]['fukuanMoney']=$v['money'];
			}
		}
		
		$ret=array_column_sort($ret,'date');
		$ret2=array_merge(array($row),$ret);
		$heji = $this->getHeji($ret, array('cnt','money','fapiaoMoney','fukuanMoney'), 'date');
		//dump($heji);exit;
		$ret2[]=$heji;//dump($ret);exit;
		$smarty=& $this->_getView();
		$smarty->assign('title',"{$jgh['compName']}对账单");
		$smarty->assign('arr_main_value',array('账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo']));
		$smarty->assign('arr_condition',$arr);
		if($_GET['no_edit']!=1){
			$smarty->assign('sonTpl',"caiwu/yf/sonTpl.tpl");
		}
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$ret2);
		$smarty->display('printOld.tpl');
	}

	
	//汇总对账单
	function actionDuizhang2(){
		//dump($_GET);exit;
		$arr=$_GET;
		if(empty($arr['supplierId'])){
			echo "缺少供应加工商信息";exit;
		}
		//查找对账单加工户
		$mClient=& FLEA::getSingleton('Model_Jichu_Jiagonghu');
		$jgh=$mClient->find($arr['supplierId']);
		// 对账单设计格式
		//查找期初欠款的情况
		//期初发生
		$sql="select isJiagong,sum(money) as money from caiwu_yf_guozhang where guozhangDate < '{$arr['dateFrom']}' and supplierId='{$arr['supplierId']}'";
		$res1=mysql_fetch_assoc(mysql_query($sql));
		//期初付款
		$sql="select sum(money) as money from caiwu_yf_fukuan where fukuanDate < '{$arr['dateFrom']}' and supplierId='{$arr['supplierId']}'";
		$res2=mysql_fetch_assoc(mysql_query($sql));
		$row['money']=$res1['money']-$res2['money'];
		$row['date']="<b>期初余额</b>";
	
		//本期应付款对账信息
		//查找应付款信息
		$sql="select x.guozhangDate,sum(x.cnt) cnt,sum(x.money) money,sum(x.zhekouMoney) zhekouMoney,x.kind from caiwu_yf_guozhang x
			where 1";
		if($arr['supplierId']!=''){
			$sql.=" and x.supplierId='{$arr['supplierId']}'";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and x.guozhangDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and x.guozhangDate <= '{$arr['dateTo']}'";
		}
		$sql.=" group by x.guozhangDate order by rukuDate";
		$rows = $this->_modelExample->findBySql($sql);
		//dump($rows);exit;
	
		//处理数据
		foreach($rows as  & $v){
			$v['money']=$v['money']==0?'':round($v['money'],2);
			$v['zhekouMoney']=$v['zhekouMoney']==0?'':round($v['zhekouMoney'],2);
			$v['cnt']=$v['cnt']==0?'':round($v['cnt'],2);
			$v['danjia']=$v['danjia']==0?'':round($v['danjia'],2);
		}
		//dump($rows);exit;
		$ret=null;
		$i=0;
		//判断是否为供应商
		$sql="select x.* from jichu_jiagonghu x where x.id='{$_GET['supplierId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$isSupplier=$r[0]['isSupplier'];
		if($isSupplier==0){//采购过账
			//dump($rowset);exit;
			foreach ($rows as & $v){
				$v['date']=$v['guozhangDate'];
				$ret[$i]=$v;
				$i++;
			}
			$arr_field_info=array(
					'date'=>'日期',
					'kind'=>'发生工序',
					'cnt'=>'总数量',
					'money'=>'应付金额',
					'fapiaoMoney'=>'收票金额',
					'fukuanMoney'=>'已付款',
					'memo'=>'备注',
			);
		}else{//加工过账
			foreach ($rows as & $v){
// 				if($v['rukuId']>0){
// 					if($v['isLingyong']==1){//领用过账
// 						$sql="select x.pihao,sum(x.cntJian) cntJian,y.proName,y.guige,y.color from cangku_chuku_son x
// 						left join cangku_chuku z on z.id=x.chukuId
// 						left join jichu_product y on y.id=x.productId where z.rukuId='{$v['rukuId']}' group by z.rukuId";
// 						$temp = $this->_modelExample->findBySql($sql);
	
// 					}else{//验收过账
// 					$sql="select x.pihao,sum(x.cntJian) cntJian,y.proName,y.guige,y.color from cangku_ruku_son x
// 					left join jichu_product y on y.id=x.productId where x.rukuId='{$v['rukuId']}' group by x.rukuId";
// 					$temp = $this->_modelExample->findBySql($sql);
// 					}
// 					$v['proName']=$temp[0]['proName'];
// 						 $v['guige']=$temp[0]['guige'];
// 						 		$v['color']=$temp[0]['color'];
// 						 				$v['cntJian']=$temp[0]['cntJian'];
// 						 				$v['pihao']=$temp[0]['pihao'];
// 				}
				$v['date']=$v['guozhangDate'];
				$ret[$i]=$v;
				$i++;
			}
	
			$arr_field_info=array(
			'date'=>'日期',
			'cnt'=>'数量',
			//'danjia'=>'单价',
			'money'=>'应付金额',
			'fapiaoMoney'=>'已收票',
			'fukuanMoney'=>'已付金额',
			'memo'=>'备注',
			);
		}
		//获得时间内开票金额
		$sql="select x.fapiaoDate,sum(x.money) money from caiwu_yf_fapiao x
		where 1";
		if($arr['supplierId']!=''){
			$sql.=" and x.supplierId='{$arr['supplierId']}'";
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
		$sql="select x.fukuanDate,sum(x.money) money from caiwu_yf_fukuan x
				where 1";
		if($arr['supplierId']!=''){
			$sql.=" and x.supplierId='{$arr['supplierId']}'";
		}
			if($arr['dateFrom']!=''){
					$sql.=" and x.fukuanDate >= '{$arr['dateFrom']}'";
			}
			if($arr['dateTo']!=''){
			$sql.=" and x.fukuanDate <= '{$arr['dateTo']}'";
		}
			$sql.=" group by x.fukuanDate  order by fukuanDate";
		$fukuan = $this->_modelExample->findBySql($sql);
			//dump($sql);exit;
			foreach ($fukuan as & $v){
			if($v['money']>0){
				$i++;
				$ret[$i]['date']=$v['fukuanDate'];
				$ret[$i]['fukuanMoney']=$v['money'];
			}
		}
	
		$ret=array_column_sort($ret,'date');
		$ret2=array_merge(array($row),$ret);
		$heji = $this->getHeji($ret, array('cnt','money','fapiaoMoney','fukuanMoney'), 'date');
				//dump($heji);exit;
		$ret2[]=$heji;//dump($ret);exit;
		$smarty=& $this->_getView();
		$smarty->assign('title',"{$jgh['compName']}对账单");
		$smarty->assign('arr_main_value',array('账期'=>$arr['dateFrom'] . ' 至 ' . $arr['dateTo']));
		$smarty->assign('arr_condition',$arr);
		if($_GET['no_edit']!=1){
			$smarty->assign('sonTpl',"caiwu/yf/sonTpl.tpl");
		}
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$ret2);
		$smarty->display('printOld.tpl');
	}
	
	
	//删除
	function actionRemove(){
		//去掉入库信息中的guozhangid
		/*$arr=$this->_modelExample->find($_GET['id']);
		if($arr['isJiagong']==1 && $arr['isLingyong']==1){//加工过账
			$gzModel = & FLEA::getSingleton('Model_Shengchan_Cangku_Chuku2Product');
		}else{//采购过账
			$gzModel = &FLEA::getSingleton('Model_Shengchan_Cangku_Ruku2Product');
		}
		$guozhang=array(
			'isHaveGz'=>0,
			'id'=>$arr['ruku2ProId']
		);
		$gzModel->update($guozhang);
*/
		parent::actionRemove();
	}

	function actionAdd() {
		$this->authCheck();
		$smarty = &$this->_getView();
		// dump($this->fldMain);exit;
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('sonTpl', 'caiwu/yf/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}

	function actionEdit() {
		//dump($_GET);exit;
		$this->authCheck();
		$row = $this->_modelExample->find(array('id' => $_GET['id']));
		//dump($row);exit;
//         $sql="select * from jichu_jiagonghu where id='{$row['supplierId']}'";
//         $temp=$this->_modelExample->findBySql($sql);
        
//         if($temp[0]['feeBase']==0){
//         	$row['Lcnt']=$row['cnt'];
//         	$row['cnt']=null;
//         }
		$this->fldMain = $this->getValueFromRow($this->fldMain, $row);

		$sql="select * from cangku_ruku where id='{$row['rukuId']}'";
		$temp = $this->_modelExample->findBySql($sql);
		$t = $temp[0];
		$JGtype=2;
		if($row['isJiagong']>0)$JGtype=1;

// 		$this->fldMain['_money']['addonEnd']='<a href="javascript:;" src="'.url('Shengchan_ruku','LookMX',array(
// 			'width'=>860,
// 			'id'=>$row['rukuId'],
// 			'JGtype'=>$JGtype,
// 			'type'=>$t['type'],
// 			)).'" class="dialog">明细</a>';
		

		//dump( $this->fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $this->fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('aRow', $row);
		$smarty->assign('sonTpl', 'caiwu/yf/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}

	/**
	 * 获取应付款信息
	 * 用于应付款开票登记的稽核列表信息
	 * Time：2014/08/25 17:14:39
	 * @author li
	 * @param GET
	 * @return JSON
	*/
	function actionGetYingfu(){
		$supplierId = (int)$_GET['supplierId'];
		//查找过账信息
		$sql="select a.chukuCode,b.rukuCode,x.guozhangDate,x.money,x.cnt,x.danjia,x.id,x.qitaMemo,x.isJiagong,x.isLingyong,y.compName,z.proName,z.guige,z.color from caiwu_yf_guozhang x 
		left join jichu_jiagonghu y on x.supplierId=y.id
		left join jichu_product z on x.productId=z.id 
		left join cangku_chuku a on a.rukuId=x.rukuId
		left join cangku_ruku b on b.id=x.rukuId
		where x.supplierId='{$supplierId}' and x.fapiaoOver=0 order by x.rukuDate,x.guozhangDate";
		// echo $sql;
		$guozhang = $this->_modelExample->findBySql($sql);

		foreach ($guozhang as & $v) {
			//dump($v);exit;
			$v['Code']=$v['rukuCode'];
			if($v['isJiagong']==1&&$v['isLingyong']==0)$v['Code']=$v['chukuCode'];
			
			$v['danjia']=round($v['danjia'],6);
			$v['money']=round($v['money'],6);
			$v['cnt']=round($v['cnt'],6);

			//查找已开票信息
			$sql="select sum(money) as money from caiwu_yf_fapiao2guozhang where guozhangId='{$v['id']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$v['ykmoney'] = round($_temp[0]['money'],3)+0;

			//查找订单信息，生产计划信息
			$sql="select y.ord2proId,y.planId,z.orderId,z.planCode,a.orderCode,x.plan2proId from cangku_ruku_son x 
			left join shengchan_plan2product y on x.plan2proId=y.id 
			left join shengchan_plan z on z.id=y.planId 
			left join trade_order a on a.id=z.orderId 
			where x.id='{$v['ruku2ProId']}'";
			// echo $sql;
			$temp = $this->_modelExample->findBySql($sql);
			$t = $temp[0];
			$v['ord2proId'] = $t['ord2proId'];
			$v['planId'] = $t['planId'];
			$v['plan2proId'] = $t['plan2proId'];
			$v['orderId'] = $t['orderId'];
			$v['planCode'] = $t['planCode'];
			$v['orderCode'] = $t['orderCode'];
		}
        //dump($guozhang);exit;
		$success=true;
		if(!$supplierId>0){
			$success=false;
			$msg="请选择收票对象";
		}elseif(count($guozhang)==0){
			$success=false;
			$msg="该对象不存在需要收发票的应付纪录";
		}

		echo json_encode(array(
			'success'=>$success,
			'msg'=>$msg,
			'data'=>$guozhang
		));exit;
	}

	/**
	 * 外协加工对账单:isJiagong=1
	 * 外协厂的对账单，本厂没有
	 * 按照本厂缸号汇总
	 * 染色，后整理的对账单
	 * 加工对账单，采购没有
	 * Time：2014/09/12 10:33:15
	 * @author li
	*/
	function actionDuizhangList(){
		$title = '外协厂加工对账单';
		$tpl = 'TblList.tpl';		
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
			'dateTo'=>date('Y-m-d'),
			'supplierId2'=>'',
			'no_edit'=>'',
		));

// 		//搜索条件
// 		$_where = '';
// 		if($arr['dateFrom']!='')$_where.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
// 		if($arr['supplierId2']!='')$_where.=" and x.supplierId='{$arr['supplierId2']}'";
		
// 		//查找符合的类别
// 		$ysKind = "'染色布',".$this->getHzlKind(true);
// 		//查找验收记录
// 		$sqlYs="select x.rukuId,x.ruku2ProId,x.rukuDate,x.id,x.isLingyong,x.isJiagong,x.danjia,sum(x.money) as money,z.compName,a.ganghao,a.pihao,b.pinzhong,b.guige,a.color,0 as cnt,0 as cntJian,sum(a.cnt) as cnt2,sum(a.cntJian) as cntJian2,0 as linkId
// 			from caiwu_yf_guozhang x
// 			inner join cangku_ruku y on y.id=x.rukuId
// 			inner join cangku_ruku_son a on a.id=x.ruku2ProId
// 			left join jichu_jiagonghu z on z.id=x.supplierId
// 			left join jichu_product b on b.id=a.productId
// 			where 1 and z.isSelf=0 and x.isJiagong=1 and x.isLingyong=0 and a.ganghao<>'' and y.type in({$ysKind}) {$_where}
// 			group by a.ganghao,y.id";
// 		// dump($sqlYs);exit;


// 		$llKind = "'坯布','染色布',".$this->getHzlKind(true);
// 		//查找领料记录
// 		$sqlLl="select x.rukuId,x.ruku2ProId,x.rukuDate,x.id,x.isLingyong,x.isJiagong,x.danjia,sum(x.money) as money,z.compName,a.ganghao,a.pihao,b.pinzhong,b.guige,a.color,sum(a.cnt) as cnt,sum(a.cntJian) as cntJian,0 as cnt2,0 as cntJian2,y.rukuId as linkId
// 			from caiwu_yf_guozhang x
// 			inner join cangku_chuku y on y.id=x.rukuId
// 			inner join cangku_chuku_son a on a.id=x.ruku2ProId
// 			left join jichu_jiagonghu z on z.id=x.supplierId
// 			left join jichu_product b on b.id=a.productId
// 			where 1 and z.isSelf=0 and x.isJiagong=1 and x.isLingyong=1 and a.ganghao<>'' and y.type in({$llKind}) {$_where}
// 			group by a.ganghao,y.id";
		
// 		$sql="{$sqlYs}
// 		 union 
// 		 {$sqlLl} order by rukuDate ,id asc";
		 //dump($sql);exit;
		$sql="select x.rukuId,x.rukuDate,y.compName,a.pinzhong,a.guige,a.color from caiwu_yf_guozhang x
				left join jichu_jiagonghu y on x.supplierId=y.id
				left join cangku_ruku_son z on x.rukuId=z.rukuId
				left join jichu_product a on a.id=z.productId
				where 1";
		if($arr['supplierId2']!='')$sql.=" and x.supplierId='{$arr['supplierId2']}'";
		
		$sql.=" and x.isJiagong=1 and x.rukuId>0 group by x.rukuId";
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();
        //dump($sql);exit;
		foreach($rowset as & $v) {
			//如果是领料，则查找验收对应数量信息
			//如果是验收，则查找领料对应的数量信息
// 			if($v['isLingyong']==0){
// 				$sql="select sum(y.cntJian) as cntJian,sum(y.cnt) as cnt,group_concat(y.pihao) as pihao
// 				from cangku_chuku x
// 				left join cangku_chuku_son y on x.id=y.chukuId
// 				left join jichu
// 				where x.rukuId='{$v['rukuId']}' and y.ganghao='{$v['ganghao']}'";
// 				$_temp = $this->_modelExample->findBySql($sql);
// 				$v['cntJian'] = $_temp[0]['cntJian'];
// 				$v['cnt'] = $_temp[0]['cnt'];
				
// 			}else{
// 				$sql="select sum(y.cntJian) as cntJian,sum(y.cnt) as cnt,group_concat(y.pihao) as pihao
// 				from cangku_ruku x
// 				left join cangku_ruku_son y on x.id=y.rukuId
// 				where x.id='{$v['linkId']}' and y.ganghao='{$v['ganghao']}'";
// 				$_temp = $this->_modelExample->findBySql($sql);
// 				$v['cntJian2'] = $_temp[0]['cntJian'];
// 				$v['cnt2'] = $_temp[0]['cnt'];
// 				$v['pihao'] = $_temp[0]['pihao'];
// 			}

			

// 			$v['money'] = round($v['money'],3);
// 			$v['danjia'] = round($v['danjia'],3);
// 			$v['cnt'] = round($v['cnt'],3);
// 			$v['cntJian'] = round($v['cntJian'],3);
// 			$v['cnt2'] = round($v['cnt2'],3);
// 			$v['cntJian2'] = round($v['cntJian2'],3);

// 			$v['sunhao'] = (($v['cnt']-$v['cnt2'])/$v['cnt']*100).' %';

			//dump($v);exit;
			
			//获得验收明细
			$sql = "SELECT y.danjia,sum(y.money) money,sum(y.cnt) cnt2,y.cntJian cntJian2,y.ganghao FROM cangku_ruku x
			left join cangku_ruku_son y on x.id=y.rukuId
			WHERE x.id='{$v['rukuId']}'  group by x.id";
			$rowset1 = $this->_modelExample->findBySql($sql);
			//dump($sql);exit;
			$v['cnt2']=$rowset1[0]['cnt2'];
			$v['cntJian2']=$rowset1[0]['cntJian2'];
			$v['ganghao']=$rowset1[0]['ganghao'];
			$v['danjia']=$rowset1[0]['danjia'];
			$v['money']=$rowset1[0]['money'];
			//获得领用明细
			$sql = "SELECT y.danjia,sum(y.money) money,sum(y.cnt) cnt,y.pihao,y.ganghao,y.cntJian  FROM cangku_chuku x
			left join cangku_chuku_son y on x.id=y.chukuId
			WHERE x.rukuId='{$v['rukuId']}' group by x.rukuId";
			$rowset2 = $this->_modelExample->findBySql($sql);
			if(!$rowset2[0]['ganghao'])$v['ganghao']=$rowset2[0]['ganghao'];
			$v['pihao']=$rowset2[0]['pihao'];
			$v['cnt']=$rowset2[0]['cnt'];
			$v['cntJian']=$rowset2[0]['cntJian'];
			if($rowset2[0]['danjia']>0)$v['danjia']=$rowset2[0]['danjia'];
			if($rowset2[0]['money']>0)$v['money']=$rowset2[0]['money'];
			
			
			
			$v['money'] = round($v['money'],3);
			$v['danjia'] = round($v['danjia'],3);
			$v['cnt'] = round($v['cnt'],3);
			$v['cntJian'] = round($v['cntJian'],3);
			$v['cnt2'] = round($v['cnt2'],3);
			$v['cntJian2'] = round($v['cntJian2'],3);
			$v['sunhao'] = round((($v['cnt']-$v['cnt2'])/$v['cnt']*100),2).' %';
			
		}
		$rowset[] = $this->getHeji($rowset, array('cnt','cntJian','cnt2','cntJian2','money'), 'rukuDate');
		 //dump($rowset);exit;
		$arrField = array(
			"rukuDate"=>'发生日期',
			"compName"=>'外协厂',
			"pinzhong"=>array('text'=>'品种','width'=>100),
			"guige"=>array('text'=>'规格','width'=>150),
			"color"=>array('text'=>'颜色','width'=>100),
			"cntJian"=>array('text'=>'领料件数','width'=>80),
			"cnt"=>array('text'=>'重量','width'=>100),
			"ganghao"=>"本厂缸号",
			"pihao"=>"缸号",
			"cntJian2"=>array('text'=>'验收件数','width'=>80),
			"cnt2"=>array('text'=>'重量','width'=>100),
			"sunhao"=>array('text'=>'损耗','width'=>80),
			"danjia"=>array('text'=>'单价','width'=>80),
			"money"=>array('text'=>'金额','width'=>80),
		);

		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',$arrField);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('add_display', 'none');
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display($tpl);
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
				'supplierId' => array('title' => '应付对象', 'type' => 'select', 'value' => '','model'=>'Model_Jichu_Jiagonghu'),
				'qitaMemo' => array('title' => '过账原因', 'type' => 'text', 'value' => ''),
				'rukuDate' => array('title' => '发生日期', 'type' => 'calendar', 'value' => date('Y-m-d'),'readonly'=>true),
				'money' => array('title' => '入账金额', 'type' => 'text', 'value' => '','addonEnd'=>'元'),
				'memo' => array('title' => '备注', 'type' => 'textarea', 'value' => ''),
				'id' => array('type' => 'hidden', 'value' => ''),
				'creater' => array('type' => 'hidden', 'value' => $_SESSION['REALNAME']),
				'kind' => array('type' => 'hidden', 'value' => '其它'),
		);

		if($_GET['id']>0){
			$row = $this->_modelExample->find(array('id' => $_GET['id']));

			$row['danjia']=round($row['danjia'],3);
			$row['money']=round($row['money'],3);
			$row['huilv']=round($row['huilv'],3);
			$fldMain = $this->getValueFromRow($fldMain, $row); 
		}
		
		if($_GET['fromAction']=='')$_GET['fromAction']=$_GET['action'];
		
		// dump($fldMain);exit;
		$smarty = &$this->_getView();
		$smarty->assign('fldMain', $fldMain);
		$smarty->assign('rules', $this->rules);
		$smarty->assign('title', '过账信息编辑');
		$smarty->assign('form', array('action'=>'SaveOther'));
		$smarty->assign('sonTpl', 'caiwu/yf/sonTpl.tpl');
		$smarty->display('Main/A1.tpl');
	}

	function actionSaveOther(){
		$arr=array(
			'id'=>$_POST['id'],
			'guozhangDate'=>$_POST['guozhangDate'],
			'supplierId'=>$_POST['supplierId'],
			'qitaMemo'=>$_POST['qitaMemo'],
			'rukuDate'=>$_POST['rukuDate'],
			'money'=>$_POST['money'],
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
		// $this->authCheck('4-1-2');
		$title = '应付款查询';
		$tpl = 'TblList.tpl';
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
				'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m')-1,date('d'),date('Y'))),
				'dateTo'=>date('Y-m-d'),
				'supplierId2'=>'',
				'no_edit'=>'',
		));
		$sql="select x.*,z.compName from caiwu_yf_guozhang x
			left join jichu_jiagonghu z on z.id=x.supplierId
			where 1 ";
		if($arr['orderId']>0){
			$arr['dateFrom']='';
			$arr['dateTo']='';
			$sql.=" and x.orderId='{$arr['orderId']}'";
		}
		if($arr['dateFrom']!='')$sql.=" and x.guozhangDate >='{$arr['dateFrom']}' and x.guozhangDate<='{$arr['dateTo']}'";
		if($arr['supplierId2']!='')$sql.=" and x.supplierId='{$arr['supplierId2']}'";
		if($arr['compName']!='')$sql.=" and z.compName like '%{$arr['compName']}%'";
		if($arr['orderCode']!='')$sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['product']!='')$sql.=" and a.product like '%{$arr['product']}%'";
		if($arr['guige']!='')$sql.=" and a.guige like '%{$arr['guige']}%'";
		$sql.=" and x.kind='其它' order by x.id asc";
		// dump($sql);exit;
		$pager =& new TMIS_Pager($sql);
		$rowset =$pager->findAll();
		//dump($rowset);exit;
		foreach($rowset as & $v) {
			$v['_edit']= "<a href='".$this->_url('OtherGuozhang',array(
						'id'=>$v['id'],
						'fromAction'=>$_GET['action'],
				))."' title='过账编辑'>修改</a>";
				
			$v['_edit'] .= '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
			//核销的情况下不能修改删除
			if($v['yifukuan']>0 || $v['yishouPiao']>0)$v['_edit']="<span title='已核销，禁止操作'>修改&nbsp;&nbsp;删除</span>";
	
			$v['cnt']=round($v['cnt'],3);
			$v['danjia']=round($v['danjia'],3);
			$v['money']=round($v['money'],3);
			$v['zhekouMoney']=round($v['zhekouMoney'],3);
			$v['_money']=round($v['_money'],3);
		}
		$rowset[] = $this->getHeji($rowset, array('cnt','money'), $_GET['no_edit']==1?'compName':'_edit');
		// dump($rowset);exit;
		$arrField = array(
				"_edit"=>'操作',
				"compName"=>array('text'=>'应付对象','width'=>160),
				"guozhangDate"=>'过账日期',
				"qitaMemo"=>array('text'=>'过账原因','width'=>100),
				// "_money"=>array('text'=>'金额','width'=>100),
				// "zhekouMoney"=>array('text'=>'折扣金额','width'=>100),
				"money"=>array('text'=>'应付金额','width'=>100),
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