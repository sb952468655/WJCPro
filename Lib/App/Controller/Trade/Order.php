<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Trade_Order extends Tmis_Controller {
	var $title = "订单管理-登记";
	var $fldMain;
	var $headSon;
	var $rules;//表单元素的验证规则
	

//**************************************构造函数 begin********************************
	function Controller_Trade_Order() {
		$this->_modelExample = & FLEA::getSingleton('Model_Trade_Order');
		$this->_modelEmploy = & FLEA::getSingleton('Model_Jichu_Employ');

		//定义模板中的主表字段
		$this->fldMain = array(
	    ///*******2个一行******
			'headId'=>array('title'=>'公司抬头','type'=>'select','value'=>'','model'=>'Model_jichu_head'),
			'orderCode'=>array('title'=>'订单编号',"type"=>"text",'readonly'=>true,'value'=>'系统自动生成'),
			'orderDate'=>array('title'=>'订单日期','type'=>'calendar','value'=>date('Y-m-d')),
            
        ///*******2个一行******
            //'finalData'=>array('title'=>'最终交期','type'=>'calendar','value'=>date('Y-m-d')),
            // 'finalDate'=>array('title'=>'订单交期','type'=>'calendar','value'=>date('Y-m-d')),
            // *options为数组,必须有text和value属性
			'traderId'=>array('title'=>'业务负责','type'=>'select','value'=>'','options'=>$this->_modelEmploy->getSelect()),

        ///*******2个一行******
			//clientpopup需要显示客户名称,所以需要定义clientName属性,value属性作为clientId用
			'clientId'=>array('title'=>'客户名称','type'=>'clientpopup','clientName'=>''),
			'clientOrder'=>array('title'=>'客户单号','type'=>'text','value'=>''),
			
			// 'proKind'=>array('title'=>'产品类型','type'=>'select','value'=>'','options'=>array(
			// 	array('text'=>'成品','value'=>'0'),
			// 	array('text'=>'半成品','value'=>'1'),
			// )),
			
		///*******2个一行******	
			'xsType'=>array('title'=>'内/外销','type'=>'select','value'=>'','options'=>array(
				array('text'=>'内销','value'=>'内销'),
				array('text'=>'外销','value'=>'外销'),
			)),
            // 'pichang'=>array('title'=>'成品匹长','type'=>'text','value'=>'','addonEnd'=>'米'),
            
        ///*******2个一行******	
            'overflow'=>array('title'=>'溢短装','type'=>'text','value'=>'','addonPre'=>'±','addonEnd'=>'%'),
            'warpShrink'=>array('title'=>'经向缩率','type'=>'text','value'=>'','addonEnd'=>'%'),

        ///*******2个一行******	   
            'weftShrink'=>array('title'=>'纬向缩率','type'=>'text','value'=>'','addonEnd'=>'%'),
            'packing'=>array('title'=>'包装要求','type'=>'text','value'=>''),

        ///*******2个一行******
            'checking'=>array('title'=>'检验要求','type'=>'text','value'=>''),
            // 'moneyDayang'=>array('title'=>'打样收费','type'=>'text','value'=>''),
            'unit'=>array('title'=>'要货单位','type'=>'select','value'=>'','options'=>array(
            	array('text'=>'M','value'=>'M'),
            	//array('text'=>'Y','value'=>'Y'),
            	array('text'=>'Kg','value'=>'Kg'),
            )),
 
        ///*******2个一行******
            'bizhong'=>array('title'=>'交易币种','type'=>'select','value'=>'RMB','options'=>array(
				array('text'=>'RMB','value'=>'RMB'),
				array('text'=>'USD','value'=>'USD'),
			)),
            'huilv'=>array('title'=>'汇率','type'=>'text','value'=>'1'),
            'orderKind'=>array('title'=>'合同类型','type'=>'select','value'=>'','options'=>array(
				array('text'=>'大货','value'=>'0'),
				array('text'=>'大样','value'=>'1'),
			)),
			//定义了name以后，就不会以memo作为input的id了
			// 'memo'=>array('title'=>'订单备注','type'=>'textarea','disabled'=>true,'name'=>'orderMemo'),
			//下面为隐藏字段
			'orderId'=>array('type'=>'hidden','value'=>''),
			'kind'=>array('type'=>'hidden','value'=>'成布'),
		);

		///从表表头信息
		///type为控件类型,在自定义模板控件
		///title为表头
		///name为控件名
		///bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit'=>array('type'=>'btBtnCopy',"title"=>'+5行','name'=>'_edit[]'),
			'productId'=>array('type'=>'btchanpinpopup',"title"=>'产品选择','name'=>'productId[]'),
			'pinzhong'=>array('type'=>'bttext',"title"=>'品种','name'=>'pinzhong[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]','options'=>array(),'width'=>'130px'),
			'menfu'=>array('type'=>'bttext',"title"=>'门幅(M)','name'=>'menfu[]'),
			'kezhong'=>array('type'=>'bttext',"title"=>'克重(g/m<sup>2</sup>)','name'=>'kezhong[]'),
			'dateJiaohuo'=>array('title'=>'交期','type'=>'btCalendarInTbl','value'=>date('Y-m-d'),'name'=>'dateJiaohuo[]'),
			'cntYaohuo'=>array('type'=>'bttext',"title"=>'数量','name'=>'cntYaohuo[]'),
			'danjia'=>array('type'=>'bttext',"title"=>'单价','name'=>'danjia[]'),
			'money'=>array('type'=>'bttext',"title"=>'金额','name'=>'money[]','readonly'=>true),
			'memo'=>array('type'=>'bttext',"title"=>'备注','name'=>'memo[]'),
			//***************如何处理hidden?
			'id'=>array('type'=>'bthidden','name'=>'id[]'),
		);


		$this->qitaSon = array(
			'_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
			'feiyongName'=>array('type'=>'btCombobox',"title"=>'费用类别','name'=>'feiyongName[]','options'=>$this->_modelExample->getFeiyongOptions(),'width'=>'280'),
			'qtMoney'=>array('type'=>'bttext',"title"=>'金额','name'=>'qtMoney[]'),
			'qtmemo'=>array('type'=>'bttext',"title"=>'备注','name'=>'qtmemo[]'),
			'id'=>array('type'=>'bthidden','name'=>'qtid[]'),
		);


		//表单元素的验证规则定义
		$this->rules = array(
			'headId'=>'required',
			'unit'=>'required',
			'orderDate'=>'required',
			'clientId'=>'required',
			'traderId'=>'required',
			'orderKind'=>'required',
			// 'orderId'=>'required'
		);

		
		//其他备注
		$this->arr_memo=array(
			'memoTrade'=>array('title'=>'经营要求','type'=>'textarea','name'=>'memoTrade'),
			'memoYongjin'=>array('title'=>'佣金备注','type'=>'textarea','name'=>'memoYongjin'),
			'memoWaigou'=>array('title'=>'外购备注','type'=>'textarea','name'=>'memoWaigou'),
			
		);
		//合同条款
		$this->arr_item = array(
			'orderItem1'=>array('title'=>'第二 质量标准','type'=>'textarea','name'=>'orderItem1','value'=>'按客户确认的品质样和颜色样生产，不良率3%以内。不同缸号的面料不能混用。如果乙方对甲方的产品质量有异议，请在收货后15天内提出，乙方开裁视为合格。'),
			'orderItem2'=>array('title'=>'第三 包装标准','type'=>'textarea','name'=>'orderItem2','value'=>'塑料袋包装。特殊要求另行协商。'),
			'orderItem3'=>array('title'=>'第四 交货数量','type'=>'textarea','name'=>'orderItem3','value'=>'大货数量允许 ±3%。'),
			'orderItem4'=>array('title'=>'第五 交货方式','type'=>'textarea','name'=>'orderItem4','value'=>'由甲方送货到乙方指定国内地点， 费用由甲方负责，特殊情况另行协商。'),
			'orderItem5'=>array('title'=>'第六 交货时间','type'=>'textarea','name'=>'orderItem5','value'=>'自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。'),
			'orderItem6'=>array('title'=>'第七 结算方式','type'=>'textarea','name'=>'orderItem6','value'=>'电汇方式，预付合同总金额的30%作为定金，余款提货前结清，如分批交货的，定金在最后一批货款中结算，付清全款后，开具增值税发票。
电汇方式，预付定金30%，面料到厂后马上支付60%，剩余10%一个月以内付清后，开具增值税发票。
电汇方式，发货后一个月内付款。'),
			'orderItem7'=>array('title'=>'第八 争议解决','type'=>'textarea','name'=>'orderItem7','value'=>'本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；'),
		);
	}

	/**
	 * 订单明细查询
	 * Time：2014/09/30 15:36:35
	*/
	function actionListView(){
		$this->authCheck('1-2');
		FLEA::loadClass('TMIS_Pager');

        ///构造搜索区域的搜索类型
        $arr=TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'clientId' => '',
			'traderId' => '',
			'isCheck' => 0, 
			'orderCode' =>'',
			'pinzhong'=>'',
			'guige'=>'',
			'color'=>'',
			'menfu'=>'',
			'kezhong'=>'',
        	));
       
		$str = "select x.unit,
			y.orderDate,y.orderCode,y.clientOrder,y.bizhong,y.id as orderId,y.isCheck,y.id,y.orderKind,
			a.compName,b.employName,x.dateJiaohuo,x.color,x.menfu,x.kezhong,x.cntYaohuo,x.danjia,(x.cntYaohuo*x.danjia) as money
			,z.guige,z.pinzhong,x.memo
			from trade_order2product x
			inner join trade_order y on x.orderId=y.id
			left join jichu_client a on y.clientId=a.id
			left join jichu_employ b on y.traderId=b.id
			left join jichu_product z on z.id=x.productId
			where 1 ";
		
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			$str .= " and y.traderId in({$traderId})";
		}
		if($arr['dateFrom'] != '') {
			$str .=" and y.orderDate >= '{$arr['dateFrom']}' and y.orderDate <= '{$arr['dateTo']}'";
		}
        if($arr['isCheck'] <2)   $str .= " and y.isCheck = '{$arr['isCheck']}'";
        if($arr['orderCode'] != '') $str .=" and y.orderCode like '%{$arr['orderCode']}%'";
        if($arr['pinzhong'] != '') $str .=" and z.pinzhong like '%{$arr['pinzhong']}%'";
        if($arr['guige'] != '') $str .=" and z.guige like '%{$arr['guige']}%'";
        if($arr['color'] != '') $str .=" and x.color like '%{$arr['color']}%'";
        if($arr['menfu'] != '') $str .=" and x.menfu like '%{$arr['menfu']}%'";
        if($arr['kezhong'] != '') $str .=" and x.kezhong like '%{$arr['kezhong']}%'";
        if($arr['clientId'] != '') $str .= " and y.clientId = '{$arr['clientId']}'";
        if($arr['traderId'] != '') $str .= " and y.traderId = '{$arr['traderId']}'";
		$str .= " order by y.orderDate desc,y.orderCode desc";

        if($_GET['export']==1){
        	$rowset = $this->_modelExample->findBySql($str);
        }
        else{
        	$pager = & new TMIS_Pager($str);
			$rowset = $pager->findAll();
        }
       
        //dump($rowset);exit;

		$trade_order2product = & FLEA::getSingleton('Model_Trade_Order2Product');
		
		foreach($rowset as & $v) {
			//订单类型
			$v['orderKind'] = $v['orderKind']==0 ? '大货' : '大样';

			//数量信息
			$v['cntYaohuo'] = round($v['cntYaohuo'],2);
			$v['danjia'] = round($v['danjia'],2);
			$v['money'] = round($v['money'],2);

			if($_GET['export']!=1){
				$v['orderCode'] = "<b>{$v['orderCode']}</b>";
			}
		}

		#合计行
		$heji = $this->getHeji($rowset,array('cntYaohuo','money'),'orderDate');
		$_GET['export']==1 && $heji['orderDate']="合计";
		$rowset[] = $heji;
		
		//dump($rowset);exit;
 
		$smarty = & $this->_getView();
		//左侧信息
		$arrFieldInfo = array(
			// "_edit"=>array('text'=>'操作'),
			"orderDate" =>array('text'=>'下单日期','width'=>90),
			"dateJiaohuo" =>array('text'=>'交货日期','width'=>90),
		    'orderCode'=>'订单编号',			
			"compName" =>"客户名称",
			'employName'=>array('text'=>'业务员','width'=>70),
			"orderKind" =>array('text'=>'合同类型','width'=>70),
			'pinzhong'=>'品种',
			'guige'=>array('text'=>'规格','width'=>120),
			'color'=>array('text'=>'颜色','width'=>100),
			'menfu'=>array('text'=>'门幅(M)','width'=>70),
			'kezhong'=>array('text'=>'克重(g/m2)','width'=>90),
			"unit" =>array('text'=>'单位','width'=>50),
			"bizhong" =>array('text'=>'币种','width'=>50),
			"cntYaohuo" =>'数量',
			"danjia" =>'单价',
			"money" =>'金额',
			"memo" =>'产品备注'
		);

		$smarty->assign('title','订单查询');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);
		
		//处理导出
		$smarty->assign('fn_export',$this->_url($_GET['action'],array('export'=>1)+$arr));
		if($_GET['export']==1){
			$this->_exportList(array('fileName'=>$title),$smarty);
		}

		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}


	/**
	 * 订单查询
	 * Time：2014/09/30 15:36:35
	*/
	function actionRight(){
		$this->authCheck('1-2');
		FLEA::loadClass('TMIS_Pager');

        ///构造搜索区域的搜索类型
        $serachArea=TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'clientId' => '',
			'traderId' => '',
			'isCheck' => 0, 
			'orderCode' =>'',
			'pinzhong'=>'',
			'guige'=>'',
			'color'=>'',
			'menfu'=>'',
			'kezhong'=>'',
        	));
       
		$str = "select x.unit,
			y.orderDate,y.orderCode,y.clientOrder,y.bizhong,y.id as orderId,y.isCheck,y.id,y.orderKind,
			a.compName,b.employName
			from trade_order y
			left join trade_order2product x on x.orderId=y.id
			left join jichu_client a on y.clientId=a.id
			left join jichu_employ b on y.traderId=b.id
			left join jichu_product z on z.id=x.productId
			where 1 ";
		
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			$str .= " and y.traderId in({$traderId})";
		}
		if($serachArea['dateFrom'] != '') {
			$str .=" and y.orderDate >= '{$serachArea['dateFrom']}' and y.orderDate <= '{$serachArea['dateTo']}'";
		}
        if($serachArea['isCheck'] <2)   $str .= " and y.isCheck = '{$serachArea['isCheck']}'";
        if($serachArea['orderCode'] != '') $str .=" and y.orderCode like '%{$serachArea['orderCode']}%'";
        if($serachArea['pinzhong'] != '') $str .=" and z.pinzhong like '%{$serachArea['pinzhong']}%'";
        if($serachArea['guige'] != '') $str .=" and z.guige like '%{$serachArea['guige']}%'";
        if($serachArea['color'] != '') $str .=" and x.color like '%{$serachArea['color']}%'";
        if($serachArea['menfu'] != '') $str .=" and x.menfu like '%{$serachArea['menfu']}%'";
        if($serachArea['kezhong'] != '') $str .=" and x.kezhong like '%{$serachArea['kezhong']}%'";
        if($serachArea['clientId'] != '') $str .= " and y.clientId = '{$serachArea['clientId']}'";
        if($serachArea['traderId'] != '') $str .= " and y.traderId = '{$serachArea['traderId']}'";
		$str .= " group by x.orderId order by y.orderDate desc,substring(y.orderCode,3) desc";

        
        $pager = & new TMIS_Pager($str);
		$rowset = $pager->findAll();
        //dump($rowset);exit;

		$trade_order2product = & FLEA::getSingleton('Model_Trade_Order2Product');
		// $trade_order2product->clearLinks();
		if (count($rowset)>0) foreach($rowset as & $value) {
			//修改
			$edit="<a href='".$this->_url('Edit',array('id'=>$value['id']))."'>修改</a>";

			//删除
			$remove="<a href='".$this->_url('Remove',array('id'=>$value['id']))."'  onclick=\"return confirm('确认删除吗?')\" >删除</a>";

			//已审核禁止修改删除
			if($value['isCheck']==1){
				$edit="修改";
				$remove="删除";
			}

			//添加翻单操作
			$fandan="<a href='".$this->_url('Edit',array(
					'isFandan'=>1,
					'id'=>$value['id']
				))."'>翻单</a>";

			//是否审核
			$over=$value['isCheck']==1?0:1;
			$strOver=$value['isCheck']==1?'取消':'';
			$shenhe= "<a href='".$this->_url('setOver',array(
				'id'=>$value['id'],
				'isCheck'=>$over,
				'fromAction'=>$_GET['action']
				))."' onclick='return confirm(\"确认操作吗?\")' ext:qtip='设置订单为".$strOver."审核'>".$strOver."审核</a>";
			//打印
			// if($value['isCheck']==1){
				$print= "<a href='".$this->_url('PrintXiangDao',array(
					'id'=>$value['id'],
					'TB_iframe'=>1
				))."' class='thickbox' title='合同'>打印</a>";
			// }else{
			// 	$value['_edit'] .= " | <span ext:qtip='未审核，不能打印'>打印</span>";
			// }
			$value['_edit']=$edit." | ".$remove." | ".$fandan." | ".$print." | ".$shenhe;
			
          //在左侧中 显示 总数量 和 总金额 初始化  
          $value['cntTotal']=0;
          $value['moneyTotal']=0;

           $res= $trade_order2product ->findAll(array('orderId'=>$value['id']));
           foreach($res as & $item){
             //添加信息
           	 $item['cntYaohuo']=round($item['cntYaohuo'],2);
           	 $item['danjia']=round($item['danjia'],6);
             $item['pinzhong']=$item['Products']['pinzhong'];
             $item['guige']=$item['Products']['guige'];

             $item['money']=round($item['cntYaohuo']*$item['danjia'],2);
              //在左侧中 显示 总数量 和 总金额 累加
             $value['cntTotal']+= $item['cntYaohuo'];
             $value['moneyTotal']+= $item['money'];
             $value['unit'] = $item['unit'];

             $value['dateJiaohuo']=$item['dateJiaohuo'];

             //设置已完成，未完成
             if($item['isViewOver']==0){
             	$isViewOver=1;
             	$msg="已完成";
             	$style="";
             }else{
             	$isViewOver=0;
             	$msg="未完成";
             	$style="style='color:red'";
             }
             $item['_edit']="<a href='".$this->_url('SetViewOver',array(
             		'id'=>$item['id'],
             		'isViewOver'=>$isViewOver,
             		'fromAction'=>$_GET['action']
             	))."' {$style}>{$msg}</a>";
             unset($item['Order']);
           }
           $value['DetailProducts']=$res;
           //dump($res);exit;

           //合同类型
           $value['orderKind']=$value['orderKind']==0?'大货':'大样';

           //查找其他金额
           $sql="select sum(qtMoney) as money from trade_order_feiyong where orderId='{$value['id']}'";
           $temp = $this->_modelExample->findBySql($sql);
           $value['moneyQt'] = round($temp[0]['money'],2);

           $value['moneyAll'] = round($value['moneyQt'] + $value['moneyTotal'],2);

		}

		#合计行
		$heji = $this->getHeji($rowset,array('cntYaohuo','moneyTotal','moneyQt','moneyAll'),'_edit');
		$rowset[] = $heji;
		
		//dump($rowset);exit;
 
		$smarty = & $this->_getView();
		//左侧信息
		$arrFieldInfo = array(
			"_edit"=>array('text'=>'操作','width'=>260),
			"orderDate" =>"日期",
			"dateJiaohuo" =>"交货日期",
		    'orderCode'=>'订单编号',			
			"compName" =>"客户名称",
			'employName'=>array('text'=>'业务员','width'=>70),
			"cntTotal" =>array('text'=>'数量','width'=>70),
			"unit" =>array('text'=>'单位','width'=>70),
			"moneyTotal" =>array('text'=>'金额','width'=>70),
			"moneyQt" =>array('text'=>'其他金额','width'=>70),
			"moneyAll" =>array('text'=>'总金额','width'=>70),
			"bizhong" =>array('text'=>'币种','width'=>70),
			"orderKind" =>'合同类型',
			//"memo" =>'产品备注'
		);
        
        //左边点击后 右侧信息
		$arrField=array(
			'_edit'=>'操作',
			'pinzhong'=>'品种',
			'guige'=>array('text'=>'规格','width'=>150),
			'color'=>array('text'=>'颜色','width'=>200),
			'menfu'=>'门幅(M)',
			'kezhong'=>'克重(g/m<sup>2</sup>)',
			"cntYaohuo" =>'数量',
			"danjia" =>'单价',
			"money" =>'金额',
			"memo" =>'产品备注'
		);

		$smarty->assign('title','订单查询');
		$smarty->assign('pk', $this->_modelExample->primaryKey);
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('arr_field_info2',$arrField);
		$smarty->assign('sub_field','DetailProducts');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action']), $serachArea));
		$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('grid','calendar')));
		//$smarty->display('TableList.tpl');
		$smarty->display('TblListMore.tpl');
	}
//***********************************订单查询 end***********************************	


	function actionSetOver() {
		//如果controller是色纱订单，设置权限
		if($_GET['controller']=='Trade_OrderSha'){
			$this->authCheck('1-4-3');
		}else{
			$this->authCheck('1-2-3');
		}
		// dump($_GET);exit;
		$sql = "update trade_order set isCheck={$_GET['isCheck']},checkDate=now(),checkPeo='".($_SESSION['REALNAME'].'')."' where id='{$_GET['id']}'";
		// echo $sql;exit;
		//mysql_query($sql) or die(mysql_error());
		$this->_modelExample->execute($sql);
		// redirect($this->_url('ListForOver'));
		$msg=$_GET['isCheck']==1?"审核成功!":"取消审核成功!";
		js_alert(null,"window.parent.showMsg('{$msg}')",$this->_url($_GET['fromAction']));
	}

	//设置明细信息是否完成
	function actionSetViewOver() {
		$this->authCheck();
		// dump($_GET);exit;
		$sql = "update trade_order2product set isViewOver={$_GET['isViewOver']} where id='{$_GET['id']}'";
		$this->_modelExample->execute($sql);
		//如果订单明细完成，则在生产计划明细中对应的完成中标记完成，方便生产上按照是否完成搜索
		$sql="update shengchan_plan2product set isViewOver={$_GET['isViewOver']} where ord2proId='{$_GET['id']}'";
		$this->_modelExample->execute($sql);
		js_alert(null,"window.parent.showMsg('操作成功')",$this->_url($_GET['fromAction']));
	}


//***************************订单登记 begin*********************************
	///1.0 给控件填充信息
	///2.0 主从表界面的展示
    ///3.0 
	function actionAdd() {		
		if($_GET['controller']=='Trade_OrderSha'){
			$this->authCheck('1-3');
		}else{
			$this->authCheck('1-1');
		}
		//主表信息字段
		$fldMain=$this->fldMain;
		// *订单号的默认值的加载*
		//$fldMain['orderCode']['value'] = $this->_modelExample->getNewOrderCode();
	
		//dump($fldMain);exit;
		$headSon = $this->headSon;
		$qitaSon = $this->qitaSon;
		//从表信息字段,默认5行
		for($i=0;$i<5;$i++) {
			$rowsSon[] = array('dateJiaohuo'=>array('value'=>date('Y-m-d')));
			$row4sSon[] = array();
		}
			
        
		//主表区域信息描述
		$areaMain = array('title'=>'订单基本信息','fld'=>$fldMain);

		//从表区域信息描述
		$smarty = & $this->_getView();
		$smarty->assign('areaMain',$areaMain);
		$smarty->assign('headSon',$headSon);
		$smarty->assign('rowsSon',$rowsSon);
		$smarty->assign('qitaSon',$qitaSon);
		$smarty->assign('row4sSon',$row4sSon);
		$smarty->assign('rules',$this->rules);
		$smarty->assign('sonTpl',array(
				'Trade/ColorAuutoCompleteJs.tpl',
				'Trade/OrderEdit.tpl'
			));
		$smarty->assign("arr_memo",$this->arr_memo);
		$smarty->assign("arr_item",$this->arr_item);
		$smarty->assign("firstColumn",array('head'=>array('type'=>'btBtnAdd')));
		$smarty->assign("otherInfoTpl",'Trade/otherInfoTpl.tpl');
		$smarty->display('Main2Son/T1.tpl');
	}
//***************************订单登记 end*********************************



//***************************订单编辑 begin*********************************
	function actionEdit() {
		if($_GET['controller']=='Trade_OrderSha'){
			$this->authCheck('1-3');
		}else{
			$this->authCheck('1-1');
		}

		$arr=$this->_modelExample->find(array('id'=>$_GET['id']));
		$arr['unit']=$arr['Products'][0]['unit'];

		//翻单的情况，需要去掉所有的id
		if($_GET['isFandan']==1){
			$arr['orderCode'] = '系统自动生成';
			$arr['id']='';
			$this->array_values_empty($arr['Products'],array('id','orderId'));
			$this->array_values_empty($arr['Feiyong'],array('id','orderId'));
		}

       // dump($arr);exit;
		foreach ($this->fldMain as $k=>&$v) {
			$v['value'] = $arr[$k];
		}
		$this->fldMain['orderId']['value'] = $arr['id'];
		//$this->fldMain['orderId']['orderMemo'] = $arr['memo'];

		$this->fldMain['clientId']['clientName'] = $arr['Client']['compName'];
        // $this->fldMain['finalDate']['value'] = $arr['Products']['0']['dateJiaohuo'];
        //dump($this->fldMain);exit;

        $this->arr_memo = $this->getValueFromRow($this->arr_memo,$arr);
        $this->arr_item = $this->getValueFromRow($this->arr_item,$arr);
        
       		
		$areaMain = array('title'=>'订单基本信息','fld'=>$this->fldMain);

		//订单明细处理	
		//订单明细的产品信息处理
		//dump($arr['Products']);exit;
		foreach($arr['Products'] as & $v) {
			$sql = "select * from jichu_product where id='{$v['productId']}'";
			$_temp = $this->_modelExample->findBySql($sql);
			$v['proCode'] = $_temp[0]['proCode'];
			$v['pinzhong'] = $_temp[0]['pinzhong'];
			$v['guige'] = $_temp[0]['guige'];
			// $v['color'] = $_temp[0]['color'];
			$v['proName'] = $_temp[0]['proName'];
			$v['zhonglei'] = $_temp[0]['zhonglei'];
			$v['money'] = round($v['danjia']*$v['cntYaohuo'],2);
		}

		//dump($arr['Products']);exit;	
		foreach($arr['Products'] as & $v) {
			$temp = array();
			foreach($this->headSon as $kk=>&$vv) {
				$temp[$kk] = array('value'=>$v[$kk]);
			}
			$rowsSon[] = $temp;			
		}
		// dump($arr);exit;
		//默认1行信息
		while (count($arr['Feiyong'])<1) {
			$arr['Feiyong'][]=array();
		}
		//处理其他费用
		foreach($arr['Feiyong'] as & $v) {
			$temp = array();
			foreach($this->qitaSon as $kk=>&$vv) {
				$temp[$kk] = array('value'=>$v[$kk]);
			}
			$row4sSon[] = $temp;			
		}
		// dump($this->headSon);exit;

		$smarty = & $this->_getView();
		$smarty->assign('areaMain',$areaMain);
		$smarty->assign('headSon',$this->headSon);
		$smarty->assign('rowsSon',$rowsSon);
		$smarty->assign('qitaSon',$this->qitaSon);
		$smarty->assign('row4sSon',$row4sSon);
		$smarty->assign('rules',$this->rules);
		$smarty->assign("arr_memo",$this->arr_memo);
		$smarty->assign("arr_item",$this->arr_item);
		$smarty->assign('sonTpl',array(
				'Trade/ColorAuutoCompleteJs.tpl',
				'Trade/OrderEdit.tpl'
			));
		$smarty->assign("otherInfoTpl",'Trade/otherInfoTpl.tpl');
		$smarty->assign("firstColumn",array('head'=>array('type'=>'btBtnAdd')));
		$smarty->display('Main2Son/T1.tpl');
	}
//***************************订单编辑 end*********************************


	function actionRemove() {
		$this->authCheck('1-2-2');

		parent::actionRemove();
	}

	//编辑界面利用ajax删除
	function actionRemoveByAjax() {
		$m = & FLEA::getSingleton('Model_Trade_Order2Product');

		//查找该订单下的明细信息，如果明细信息只有1个，不允许删除
		$ord2pro = $m->find(array('id'=>$_POST['id']));
		$order2Pro = $m->findAll(array('orderId'=>$ord2pro['orderId']));

		if(count($order2Pro)<=1){
			echo json_encode(array('success'=>false,'msg'=>"亲，明细再删就没了!\r如果需要删除订单，请到订单查询中删除整个订单。"));
			exit;
		}

		$r = $m->removeByPkv($_POST['id']);
		if(!$r) {
			$arr = array('success'=>false,'msg'=>'删除失败');
			echo json_encode($arr);
			exit;
		}
		$arr = array('success'=>true);
		echo json_encode($arr);
		exit;
	}

	//编辑界面利用ajax删除
	function actionRemoveQitaByAjax() {
		$m = & FLEA::getSingleton('Model_Trade_OrderFeiyong');
		$r = $m->removeByPkv($_POST['id']);
		if(!$r) {
			$arr = array('success'=>false,'msg'=>'删除失败');
			echo json_encode($arr);
			exit;
		}
		$arr = array('success'=>true);
		echo json_encode($arr);
		exit;
	}


//********************************数据保存 begin********************************
	function actionSave() {
		// dump($_POST); exit;
		// ~~半成品与成品明细登记时 不允许成品和半成品同时存在 ，如果存在则禁止保存~~
        //dump($_POST); EXIT;
        if($_POST['orderId']>0){
			$oldOrder = $this->_modelExample->find($_POST['orderId']);
			// dump($oldOrder);exit;
		}
         //trade_order2product 表 的数组
         $trade_order2product=array();
         $ii=0;
         foreach ($_POST['productId'] as $key => $v) {
         	$ii++;
         	// 当没有记录 或者 没有输入数量时 跳出本次循环 防止多保存
         	if(empty($_POST['productId'][$key]) || empty($_POST['cntYaohuo'][$key])) continue;

         	//数量换算：m=kg/（幅宽*克重/1000）
         	if($_POST['unit']=='M'){
         		$cntKg=$_POST['cntYaohuo'][$key]*(round($_POST['menfu'][$key],6)*round($_POST['kezhong'][$key],6)/1000);
         		$cntM=$_POST['cntYaohuo'][$key];
         	}else if($_POST['unit']=='Kg'){
         		$cntM=$_POST['cntYaohuo'][$key]/(round($_POST['menfu'][$key],6)*round($_POST['kezhong'][$key],6)/1000);
         		$cntKg=$_POST['cntYaohuo'][$key];
         	}
         	 $trade_order2product[] = array(
                  'id'=>$_POST['id'][$key],
                  'numId'=>$ii,                   //主键id
                  'productId'=>$_POST['productId'][$key],       //产品id
                  'color'=>$_POST['color'][$key], 
                  'cntYaohuo'=>$_POST['cntYaohuo'][$key],       //要货数量
                  'cntM'=>$cntM+0,       //要货数量
                  'cntKg'=>$cntKg+0,       //要货数量
                  'unit'=> $_POST['unit'],                //单位 
                  'danjia'=>$_POST['danjia'][$key],             //单价
                  'menfu'=>$_POST['menfu'][$key].'',             //门幅
                  'kezhong'=>$_POST['kezhong'][$key].'',             //克重
                  'memo'=>$_POST['memo'][$key].'',                 //备注
                  'dateJiaohuo'=>$_POST['dateJiaohuo'][$key],           //交货日期 
         	 	);
         }

         //处理其他费用登记信息
         $qitaSon=array();
         foreach ($_POST['feiyongName'] as $k => & $v) {
         	if(empty($_POST['feiyongName'][$k]) || empty($_POST['qtMoney'][$k]))continue;
         	$qitaSon[]=array(
         		'id'=>$_POST['qtid'][$k],
         		'qtmemo'=>$_POST['qtmemo'][$k],
         		'qtMoney'=>$_POST['qtMoney'][$k],
         		'feiyongName'=>$_POST['feiyongName'][$k]
         	);
         }
         // dump($qitaSon);exit;
          //如果公司抬头改变，则订单编号改变
         if($oldOrder['headId']!=$_POST['headId'] && $_POST['orderId']>0){
         	$_POST['orderCode']=$this->_modelExample->getNewCode($_POST['headId']);
         }
         //处理订单编号信息
         $_POST['orderCode'] = $_POST['orderCode']=='系统自动生成'?'':$_POST['orderCode'];
         $_POST['orderCode'] = $_POST['orderCode']==''?$this->_modelExample->getNewCode($_POST['headId']):$_POST['orderCode'];

         //trade_order 表 的数组
         $trade_order = array(
            'id'=>$_POST['orderId'],                         //主键id
            'orderCode'=>$_POST['orderCode'],
            'headId'=>$_POST['headId'],
            'kind'=>$_POST['kind'],                //订单号
            'orderKind'=>$_POST['orderKind'],
            'orderDate'=>$_POST['orderDate'],                //签订日期
            //'finalDate'=>$_POST['finalDate'],                //最终交期
            'traderId'=>$_POST['traderId'],                  //业务员id
            'clientId'=>$_POST['clientId'],                  //客户id
            'clientOrder'=>$_POST['clientOrder'],            //客户合同号
            'huilv'=>$_POST['huilv']>0?$_POST['huilv']:1,            //汇率
            'xsType'=>$_POST['xsType'],                      //内外销
            // 'pichang'=>$_POST['pichang'],                    //匹长
            'overflow'=>$_POST['overflow'],                 //溢短装
            'warpShrink'=>$_POST['warpShrink'],              //经向缩率
            'weftShrink'=>$_POST['weftShrink'],              //纬向缩率
            'packing'=>$_POST['packing'],                    //包装要求
            'checking'=>$_POST['checking'],                  //检验要求
            'moneyDayang'=>$_POST['moneyDayang']+0,            // 打样收费
            'bizhong'=>$_POST['bizhong'],                   //币种
            'memo'=>$_POST['orderMemo'].'',                     //备注
            'memoTrade'=>$_POST['memoTrade'],                //经营要求
            'memoYongjin'=>$_POST['memoYongjin'],            //佣金备注
            'memoWaigou'=>$_POST['memoWaigou'],              //外购备注
            'orderItem1'=>$_POST['orderItem1'], //
            'orderItem2'=>$_POST['orderItem2'], //
            'orderItem3'=>$_POST['orderItem3'], //
            'orderItem4'=>$_POST['orderItem4'], //
            'orderItem5'=>$_POST['orderItem5'], //
            'orderItem6'=>$_POST['orderItem6'], //
            'orderItem7'=>$_POST['orderItem7'], //
     	);
       //表之间的关联
       $trade_order['Products']=$trade_order2product;
       $trade_order['Feiyong']=$qitaSon;
       //保存前处理数据
       $this->_beforUpdate($trade_order);
       //保存 并返回trade_order表的主键
       // dump($trade_order);exit;
       	if(count($trade_order2product)>0)$itemId=$this->_modelExample->save($trade_order);
       	else $mag="没有有效明细数据";
		if($itemId){
			 if($_POST['Submit'] == '保存并新增下一个'){
				  js_alert('','window.parent.showMsg("保存成功")',$this->_url('add'));
			 } else {
				  js_alert('','window.parent.showMsg("保存成功")',$this->_url('right'));
			 }
		}else die('保存失败!'.$mag);

	}
//********************************数据保存 end********************************

	/**
	* 客户下单汇总
	* 显示:客户，下单数量(M/Kg)，金额，可以查看明细信息
	* 
	*/
	function actionClientHuizong(){
		$this->authCheck('1-5');
		FLEA::loadClass('TMIS_Pager');
		 $arr=TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'clientId' => '',
			'traderId' => '',
			// 'isChart'=>'',
    	));

		$sql="select sum(x.cntM) as cntM,sum(x.cntKg) as cntKg,sum(x.cntYaohuo*x.danjia*y.huilv) as money,y.clientId,y.traderId,z.compName,b.employName from trade_order2product x 
		 	left join trade_order y on y.id=x.orderId
		 	left join jichu_client z on z.id=y.clientId
		 	left join jichu_employ b on b.id=y.traderId
		 	where 1";

		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			$str .= " and y.traderId in({$traderId})";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and y.orderDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and y.orderDate <= '{$arr['dateTo']}'";
		}
		if($arr['clientId']>0){
			$sql.=" and y.clientId='{$arr['clientId']}'";
		}
		if($arr['traderId']>0){
			$sql.=" and y.traderId='{$arr['traderId']}'";
		}
		$sql.=" group by y.clientId,y.traderId order by z.letters";

		//取数据信息
		$pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		//处理数据
		foreach($rowset as & $v){
			$v['cntKg']=round($v['cntKg'],2);
			$v['cntM']=round($v['cntM'],2);
			$v['money']=round($v['money'],6);
			$v['money2']=$v['money'];
			//显示明细信息
			$v['money']="<a href='".$this->_url('View',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'clientId'=>$v['clientId'],
				'traderId'=>$v['traderId'],
				'no_edit'=>1,
				'width'=>'900',
				'baseWindow'=>'parent',
				'TB_iframe'=>1
			))."' title='查看明细' class='thickbox'>{$v['money']}</a>";
		}

		//图形化界面显示
		if($_GET['isChart']==1) {//图形化显示
			$compName = array();
			$money = array();
			$cntM = array();
			$cntKg = array();
			$client = array();
			foreach($rowset as $key=>& $v) {
				if($v['money2']==0) continue;
				$compName[] = $v['compName'];
				$money[] = $v['money2'];
				$cntM[] = $v['cntM'];
				$cntKg[] = $v['cntKg'];

				$client[]=array(
					'name'=>$v['compName'],
					'value'=>$v['money2']
				);
			}
			$_arr = array(
				'client'=>$compName,
				'money'=>$money,
				'cntM'=>$cntM,
				'cntKg'=>$cntKg,
				'pieData'=>$client
			);
			// dump($_arr);exit;
			$smarty = & $this->_getView();
			$smarty->assign('json',json_encode($_arr));
			$smarty->display("Trade/Chart.tpl");
			exit;
		}

		$heji = $this->getHeji($rowset,array('cntKg','cntM','money2'),'compName');
		$heji['money']=$heji['money2'];
		$rowset[] = $heji;
		
		//左侧信息
		$arrFieldInfo = array(			
			"compName" =>array('text'=>'客户名称','width'=>220),
			'employName'=>array('text'=>'业务员','width'=>100),
			"cntM" =>array('text'=>'<a href="#" title="m和kg之间存在换算&#10;m=kg/（门幅*克重/1000）">数量(M)</a>','width'=>100),
			"cntKg" =>array('text'=>'数量(Kg)','width'=>100),
			"money" =>array('text'=>'金额(RMB)','width'=>100),
		);
       
		$smarty = & $this->_getView();
		$smarty->assign('title','订单汇总报表');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);

		//处理导出
		// $smarty->assign('fn_export',$this->_url($_GET['action'],array('export'=>1)+$arr));
		// if($_GET['export']==1){
		// 	$this->_exportList(array('fileName'=>'订单汇总报表'),$smarty);
		// }

		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'], $arr))."<a href='".$this->_url($_GET['action'],$arr+array('isChart'=>1))."'>&nbsp;&nbsp;图形化</a>");
		$smarty->display('TableList.tpl');
	}


	//订单明细数据
	function actionView(){
		// $this->authCheck('1-5');
		FLEA::loadClass('TMIS_Pager');
		 $arr=TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'clientId' => '',
			'traderId' => '',
			'no_edit'=>'',
    	));

		$sql="select x.*,x.cntYaohuo*x.danjia as money,y.clientId,y.traderId,y.orderDate,y.orderCode,y.bizhong,z.compName,b.employName,a.pinzhong,a.proName,a.guige,a.zhonglei from trade_order2product x 
		 	inner join trade_order y on y.id=x.orderId
		 	left join jichu_client z on z.id=y.clientId
		 	left join jichu_employ b on b.id=y.traderId
		 	left join jichu_product a on a.id=x.productId
		 	where 1";

		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			$sql .= " and y.traderId in({$traderId})";
		}
		if($arr['dateFrom']!=''){
			$sql.=" and y.orderDate >= '{$arr['dateFrom']}'";
		}
		if($arr['dateTo']!=''){
			$sql.=" and y.orderDate <= '{$arr['dateTo']}'";
		}
		if($arr['clientId']>0){
			$sql.=" and y.clientId='{$arr['clientId']}'";
		}
		if($arr['traderId']>0){
			$sql.=" and y.traderId='{$arr['traderId']}'";
		}
		$sql.=" order by x.orderId desc,x.numId";

		// dump($sql);exit;
		//取数据信息
		$pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		//处理数据
		foreach($rowset as & $v){
			$v['cntYaohuo']=round($v['cntYaohuo'],2);
			$v['cntKg']=round($v['cntKg'],2);
			$v['cntM']=round($v['cntM'],2);
			$v['money']=round($v['money'],6);
			
		}

		$heji = $this->getHeji($rowset,array('cntKg','cntM','money'),'orderDate');
		$rowset[] = $heji;
		
		//左侧信息
		$arrFieldInfo = array(
			"orderDate" =>"日期",
		    'orderCode'=>'订单编号',			
			"compName" =>"客户名称",
			"pinzhong" =>"品种",
			"guige" =>"规格",
			"color" =>"颜色",
			"menfu" =>"门幅(M)",
			"kezhong" =>"克重(g/m<sup>2</sup>)",
			"money" =>array('text'=>'金额','width'=>70),
			"bizhong" =>array('text'=>'币种','width'=>70),
			"cntM" =>array('text'=>'数量(M)','width'=>70),
			"cntKg" =>array('text'=>'数量(cntKg)','width'=>90),
			"money" =>array('text'=>'金额','width'=>70),
			"cntYaohuo" =>array('text'=>'要货数量','width'=>70),
			"unit" =>array('text'=>'单位','width'=>70),
		);
       
		$smarty = & $this->_getView();
		$smarty->assign('title','订单汇总报表');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TableList.tpl');
	}

	//如果修改了花型或者厂编有变动，需要对织轴表和过账表进行关联修改。
	//如果改了交期或者数量有变，生成通知。
	function _beforUpdate(&$order) {
		$orderId = $order['id'];
		if(!$orderId>0)return false;
		$oldOrder =$this->_modelExample->find($orderId);//查找原数据
		// dump($order);exit;
		//判断交期是否变动
		$jq=array();
		foreach($order['Products'] as $v) {
			if(empty($v['id'])) continue;
			$str="SELECT x.*,y.orderCode FROM `trade_order2product` x
			left join trade_order y on y.id=x.orderId
			 where x.id={$v['id']}";
			$_r=$this->_modelExample->findBySql($str);
			$oldPro = $_r[0];
			// dump($v);exit;
			//生成通知插入订单变动提醒
			if(date('Y-m-d')==substr($v['dt'],10)) continue;//如果是同一天修改的，跳过
			$temp = array();
			if($oldPro['dateJiaohuo']!=$v['dateJiaohuo']&&$oldPro['dateJiaohuo']!='0000-00-00') {
				$jq['product'] = "订单编号{$order['orderCode']}";
				$jq['value'] = "交期变为{$v['dateJiaohuo']}";
				$jq['text'] = "交期变化";
			}

			if($oldPro['cntKg']!=$v['cntKg']&&$oldPro['cntYaohuo']>0) {
				//查看是否产品明细信息修改数量，修改产品信息
				$sql="select concat(pinzhong,' ',zhonglei,' ',proName,' ',guige,' ',color) as guige from jichu_product where id='{$v['productId']}'";
				$temp_pro=$this->_modelExample->findBySql($sql);
				$pro=$temp_pro[0];

				$temp['product'] = "{$order['orderCode']}单({$pro['guige']})";
				$temp['value'] .= ($temp['value']?',':'')."要货变为{$v['cntYaohuo']}{$v['unit']}";
				$temp['text'] .= ($temp['value']?',':'')."要货数变化";
			}
			if($temp['product']) $tongzhi[] = $temp;
		}
		if($jq['product']) $tongzhi[] = $jq;

		if(count($tongzhi)>0) {
			$oa = & FLEA::getSingleton('Model_OaMessage');
			foreach($tongzhi as & $v1) {
				$_r=array(
					'kindName'=>'订单变动通知',
					'title'=>"{$v1['product']}"."{$v1['text']}",
					'content'=>"请各部门工作人员注意:产品{$v1['product']}"."{$v1['text']},"."{$v1['value']},请注意协调并互相通知！",
					'buildDate'=>date('Y-m-d'),
					'creater'=>$_SESSION['REALNAME']
				);
				// dump($_r);exit;
				$oa->save($_r);
			}
		}
	}

	//打印合同
	function actionPrint(){
		$this->authCheck();
		if(!$_GET['id']){
			echo '发生错误，请重新操作';exit;
		}
		//查找订单信息
		$order = $this->_modelExample->find($_GET['id']);
		// $money=0;
		foreach($order['Products'] as & $v){
			$v['cntYaohuo']=round($v['cntYaohuo'],2);

			$v['danjia']=$v['danjia']*$order['huilv'];
			$v['danjia']=round($v['danjia'],6);
			$v['money']=round($v['danjia']*$v['cntYaohuo'],2);

			// $money+=$v['money'];

			//获取产品信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$temp=$this->_modelExample->findBySql($sql);
			$v['pinzhong']=$temp[0]['pinzhong'];
			$v['guige']=$temp[0]['guige'];
			// $v['color']=$temp[0]['color'];
			$v['proName']=$temp[0]['proName'];
			$v['zhonglei']=$temp[0]['zhonglei'];
		}

		//处理其他费用，和明细数据一起打印
		foreach ($order['Feiyong'] as $key => & $v) {
			$order['Products'][]=array(
				'pinzhong'=>$v['feiyongName'],
				'zhonglei'=>$v['feiyongName'],
				'money'=>$v['qtMoney']
			);
		}
		//默认5行明细数据
		while (count($order['Products'])<5) {
			$order['Products'][]=array();
		}
		$heji=$this->getHeji($order['Products'],array('money','cntYaohuo'),$order['kind']=='成布'?'pinzhong':'zhonglei');
		$order['Products'][]=$heji;
		//设置金额大写
		$money=$heji['money'];
		FLEA::loadClass('TMIS_Common');
		$order['moneyUpper']=TMIS_Common::trans2rmb($money);
		//处理订单备注换行的问题
		for($i=1;$i<8;$i++){
			$order['orderItem'.$i]=htmlspecialchars($order['orderItem'.$i]);
			$order['orderItem'.$i]=str_replace(array("\r\n","\r","\n"), $_GET['export']==1?'&#10;':'<br/>', $order['orderItem'.$i]); 
		}
		
		// dump($order);exit;
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$order);
		$smarty->assign('title','合同打印');

		if($_GET['export']==1){
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/download");
			header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", $order['orderCode']).".xls");
			// header("Content-Disposition: attachment;filename=Job Order.xls");
			header("Content-Transfer-Encoding: binary");
			$smarty->display('Trade/HetongExport.tpl');
			exit;
		}
		$smarty->display('Trade/HetongPrint.tpl');
	}

	// ********************************订单弹出后台 begin******************** 
	// /从色坯纱管理中弹出订单，只能选择色纱和坯纱， 用isSePiSha=1来标示
	// /从成品管理中弹出订单，只能选择坯布和其他
	function actionPopup() {
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$serachArea = TMIS_Pager::getParamArray(array(
				'clientId' => '',
				'traderId' => '',
				'orderCode' => '',
				// 'key' => '',
				'pinzhong'=>'',
				'guige'=>'',
				));

		
         $str = "select
				x.orderCode,
				x.orderDate,
				x.clientId,
				x.isSetplan,
				x.traderId,
				x.clientOrder,
				x.memo as orderMemo,
				x.isCheck,
				x.id,
				x.id as orderId,
				x.bizhong,
				y.compName,
				group_concat(z.productId) as productId,
				m.employName
				from trade_order x
				inner join trade_order2product z on z.orderId=x.id
				left join jichu_client y on x.clientId = y.id
				left join jichu_employ m on m.id=x.traderId
				left join jichu_product n on n.id=z.productId
                where 1 and x.isCheck=1";

        $_GET['kind']!='' && $str .=" and x.kind='{$_GET['kind']}'";
               
        if($serachArea['orderCode'] != '') $str .=" and x.orderCode like '%{$serachArea['orderCode']}%'";
        if($serachArea['pinzhong'] != '') $str .=" and n.pinzhong like '%{$serachArea['pinzhong']}%'";
        if($serachArea['guige'] != '') $str .=" and n.guige like '%{$serachArea['guige']}%'";
        if($serachArea['clientId'] != '') $str .= " and x.clientId = '{$serachArea['clientId']}'";
        if($serachArea['traderId'] != '') $str .= " and x.traderId = '{$serachArea['traderId']}'";
		$str .= " group by x.id order by orderDate desc, substring(orderCode,3) desc";
		// dump($str);exit;
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll();

		if (count($rowset) > 0) foreach($rowset as $i => &$v) {
			$v['cnt'] -= $cnt;
			$v['danjia'] = round($v['danjia'], 2);
			$v['money'] = round($v['money'], 2);
			//查找要货数量
			$sql="select unit,sum(cntYaohuo) as cntYaohuo from trade_order2product where orderId='{$v['id']}'";
			$temp=$this->_modelExample->findBySql($sql);
			$v['cntYaohuo']=$temp[0]['cntYaohuo'];
			$v['unit']=$temp[0]['unit'];

			//查找产品信息
			$sql="select concat(pinzhong,' ',guige) as info from jichu_product where id in ({$v['productId']})";
			// echo $sql;exit;
			$temp=$this->_modelExample->findBySql($sql);
			$v['proInfo'] = "<a href='#' ext:qtip='".(join('<br>',array_col_values($temp,'info')))."'>".(join('，',array_col_values($temp,'info')))."</a>";

		}
		$arrFieldInfo = array(
			"orderCode" => "订单编号",
			"orderDate" => "日期",
			"compName" => "客户名称",
			'employName' => '业务员',
			'proInfo'=>array('text'=>'产品信息','width'=>200),
			'unit'=>'单位',
			"cntYaohuo" => '数量', 
		);

		$smarty = &$this->_getView();
		$smarty->assign('title', '选择客户');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'], $serachArea)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	function actionPopupPlan() {
		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$serachArea = TMIS_Pager::getParamArray(array(
				'isShezhi'=>'0',
				'clientId' => '',
				'traderId' => '',
				'orderCode' => '',
				// 'key' => '',
				'pinzhong'=>'',
				'guige'=>'',
				));
		
         $str = "select
				x.orderCode,
				x.orderDate,
				x.clientId,
				x.isSetplan,
				x.traderId,
				x.clientOrder,
				x.memo as orderMemo,
				x.isCheck,
				x.id,
				x.id as orderId,
				x.bizhong,
				y.compName,
				group_concat(z.productId) as productId,
				m.employName
				from trade_order x
				inner join trade_order2product z on z.orderId=x.id
				left join jichu_client y on x.clientId = y.id
				left join jichu_employ m on m.id=x.traderId
				left join jichu_product n on n.id=z.productId
                where 1 and x.isCheck=1";

        $_GET['kind']!='' && $str .=" and x.kind='{$_GET['kind']}'";
        //是否存在已设置搜索，有的话需要查找是否已设置计划信息
        if(isset($serachArea['isShezhi'])){
        	if($serachArea['isShezhi']==1){
	        	$str.=" and (x.isSetplan=1 or exists(select bb.id from shengchan_plan bb where bb.orderId=x.id))";
	        }else if($serachArea['isShezhi']==0){
	        	$str.=" and x.isSetplan=0 and not exists(select bb.id from shengchan_plan bb where bb.orderId=x.id)";
	        }
        }
        
        if($serachArea['orderCode'] != '') $str .=" and x.orderCode like '%{$serachArea['orderCode']}%'";
        if($serachArea['pinzhong'] != '') $str .=" and n.pinzhong like '%{$serachArea['pinzhong']}%'";
        if($serachArea['guige'] != '') $str .=" and n.guige like '%{$serachArea['guige']}%'";
        if($serachArea['clientId'] != '') $str .= " and x.clientId = '{$serachArea['clientId']}'";
        if($serachArea['traderId'] != '') $str .= " and x.traderId = '{$serachArea['traderId']}'";
		$str .= " group by x.id order by orderDate desc, substring(orderCode,3) desc";
		// dump($str);exit;
		$pager = &new TMIS_Pager($str);
		$rowset = $pager->findAll();

		if (count($rowset) > 0) foreach($rowset as $i => &$v) {
			$v['cnt'] -= $cnt;
			$v['danjia'] = round($v['danjia'], 2);
			$v['money'] = round($v['money'], 2);
			//查找要货数量
			$sql="select unit,sum(cntYaohuo) as cntYaohuo from trade_order2product where orderId='{$v['id']}'";
			$temp=$this->_modelExample->findBySql($sql);
			$v['cntYaohuo']=$temp[0]['cntYaohuo'];
			$v['unit']=$temp[0]['unit'];

			//查找产品信息
			$sql="select concat(pinzhong,' ',guige) as info from jichu_product where id in ({$v['productId']})";
			// echo $sql;exit;
			$temp=$this->_modelExample->findBySql($sql);
			$v['proInfo'] = "<a href='#' ext:qtip='".(join('<br>',array_col_values($temp,'info')))."'>".(join('，',array_col_values($temp,'info')))."</a>";

			if($v['isSetplan']==1 || $serachArea['isShezhi']==0){
				$msg=$v['isSetplan']==1 ? "未设置" : '已设置';
				$v['_edit']="<a href='".$this->_url('SetPlanOver',array(
					'orderId'=>$v['orderId'],
					'isSetplan'=>$v['isSetplan'],
					'fromAction'=>$_GET['action']
				))."'>{$msg}</a>";
			}
		}
		$arrFieldInfo = array(
			"orderCode" => "订单编号",
			"orderDate" => "日期",
			"compName" => "客户名称",
			'employName' => '业务员',
			'proInfo'=>array('text'=>'产品信息','width'=>200),
			'unit'=>'单位',
			"cntYaohuo" => '数量', 
			"_edit" => '操作', 
		);

		$smarty = &$this->_getView();
		$smarty->assign('title', '选择客户');
		$pk = $this->_modelExample->primaryKey;
		$smarty->assign('pk', $pk);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('arr_condition', $serachArea);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'], $serachArea)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	/**
	 * 设置订单不需要设置计划
	 * Time：2014/11/05 16:21:56
	 * @author li
	*/
	function actionSetPlanOver(){
		$isSetplan = $_GET['isSetplan']==0 ? 1: 0;
		$arr=array(
			'id'=>$_GET['orderId'],
			'isSetplan'=>$isSetplan,
		);

		$this->_modelExample->update($arr);
		js_alert('','',$this->_url($_GET['fromAction']));
	}

	/**
	 * 订单明细弹出窗口选择列表
	 * Time：2014/08/14 15:27:52
	 * @author li
	*/
	function actionPopupHuaxing(){
		//权限判断
		$this->authCheck();

		FLEA::loadClass('TMIS_Pager'); 
		// /构造搜索区域的搜索类型
		TMIS_Pager::clearCondition();
		$arr = TMIS_Pager::getParamArray(array(
				'clientId' => '',
				'orderCode' => '',
				'key' => '',
		));

		$sql="select x.*,y.orderCode,y.orderDate,z.proCode,z.pinzhong,z.guige,a.compName,y.clientId
			from trade_order2product x 
			inner join trade_order y on y.id=x.orderId
			left join jichu_product z on z.id=x.productId
			left join jichu_client a on a.id=y.clientId
			where 1";
		$arr['clientId']>0 && $sql.=" and y.clientId='{$arr['clientId']}'";
		$arr['orderCode']!='' && $sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		if($arr['key']!=''){
			$sql.=" and (x.color like '%{$arr['key']}%'
					  or z.proCode like  '%{$arr['key']}%'
					  or z.pinzhong like  '%{$arr['key']}%'
					  or z.guige like  '%{$arr['key']}%'
					  or x.memo like  '%{$arr['key']}%'
				)";
		}

		$sql.=" order by y.orderCode desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach($rowset as $i => &$v) {
			$v['cntYaohuo'] = round($v['cntYaohuo'], 2);
			$v['danjia'] = round($v['danjia'], 2);
			$v['money'] = round($v['money'], 2);

			//查找已出库数量
			$sql="select sum(x.cnt) as cnt,sum(x.cntM) as cntM 
			from cangku_chuku_son x
			left join cangku_chuku y on y.id=x.chukuId
			where y.isCheck=1 and x.ord2proId='{$v['id']}'";
			$res = $this->_modelExample->findBySql($sql);
			$v['cntYf'] = $v['unit'] == "M" ? $res[0]['cntM'] : $res[0]['cnt'];
			$v['cntYf'] = round($v['cntYf'],2);
			$v['cntWf'] = round($v['cntYaohuo']-$v['cntYf'],2);
		}

		$arrFieldInfo = array(
			"orderCode" => "订单编号",
			"orderDate" => "日期",
			"compName" => "客户名称",
			"proCode" => "产品编号",
			"pinzhong" => "品种",
			"guige" => "规格",
			"color" => "颜色",
			"menfu" => "门幅(M)",
			"kezhong" => "克重(g/m<sup>2</sup>)",
			'unit'=>'单位',
			"cntYaohuo" => '数量', 
			"cntYf" => '已发数量',
			"cntWf" => '未发数量',
			"memo" => '备注',
			);
		$smarty = &$this->_getView();
		$smarty->assign('title', '选择订单明细');
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('page_info', $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Popup/CommonNew.tpl');
	}

	// ********************************订单弹出后台 end********************

	//通过orderId获取订单明细信息
	function actionGetViewByOrderId(){
		$sql="select y.pinzhong,y.zhonglei,y.proCode,y.proName,y.guige,x.color,x.cntYaohuo as cnt ,x.unit from trade_order2product x
			left join jichu_product y on x.productId=y.id
			where 1 and orderId='{$_GET['orderId']}'";
		$rows=$this->_modelExample->findBySql($sql);
		echo json_encode(array('data'=>$rows));exit;
	}

	//打印向导
	function actionPrintXiangDao(){
		$tpl="Trade/PrintXiangdao.tpl";
		//定义需要打印的连接
		$url=array(
			'打印合同'=>"<a href='".$this->_url('Print',array('id'=>$_GET['id']))."' target='_blank' title='打印合同'>打印合同</a>",
			'导出合同(xls)'=>"<a href='".$this->_url('Print',array('id'=>$_GET['id'],'export'=>1))."' >导出合同(xls)</a>",
			
		);

		$smarty = & $this->_getView();
		$smarty->assign('url', $url);
		$smarty->display($tpl);
	}

	/**
	 * 选择订单后根据orderId取得订单信息
	 */
	function actionGetOrderInfo() {
		$orderId=$_REQUEST['orderId'];
		$order = $this->_modelExample->find(array('id'=>$orderId));
		$mp = & FLEA::getSingleton('Model_Jichu_Product');
		foreach($order['Products'] as & $v) {
			$v['cntYaohuo']=round($v['cntYaohuo'],2);
			$pro = $mp->find(array('id'=>$v['productId']));
			$v['Product'] = $pro;
		}

		$order['memoTrade'] != '' && $memo = "经营要求:".$order['memoTrade'];
		if($order['memoWaigou'] != ''){
			$memo!='' && $memo.="\n";
			$memo .= "外购备注:".$order['memoWaigou'];
		}
		$order['memo'] = $memo;
		// dump($order);exit;
		if($order) {
			echo json_encode(array('success'=>true,'order'=>$order));
			exit;
		}
		echo json_encode(array('success'=>false,'msg'=>'未发现匹配订单!'));
	}

	/**
	 * 选择订单后根据orderId取得订单信息
	 */
	function actionGetOrderInfoAndChuku() {
		$orderId=$_REQUEST['orderId'];
		$order = $this->_modelExample->find(array('id'=>$orderId));
		$mp = & FLEA::getSingleton('Model_Jichu_Product');
		foreach($order['Products'] as & $v) {
			$v['cntYaohuo']=round($v['cntYaohuo'],2);

			//已出库数量
			$sql="select sum(x.cnt) as cnt from cangku_chuku_son x
				left join cangku_chuku y on y.id=x.chukuId
				where x.ord2proId='{$v['id']}' and y.isCheck=1";
			$temp=$this->_modelExample->findBySql($sql);
			$v['cntHaveck']=round($temp[0]['cnt'],2);

			//产品信息
			$pro = $mp->find(array('id'=>$v['productId']));
			$v['Product'] = $pro;
		}
		// dump($order);exit;
		if($order) {
			echo json_encode(array('success'=>true,'order'=>$order));
			exit;
		}
		echo json_encode(array('success'=>false,'msg'=>'未发现匹配订单!'));
	}


	/**
	 * 报表中心
	 * 订单跟踪统计报表
	 * Time：2014/08/26 17:31:17
	 * @author li
	*/
	function actionTracing(){
		//权限
		// $this->authCheck('9-1');
		
		//搜索
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'clientId'=>'',
			'traderId'=>'',
			// 'isOver'=>0,
			'orderCode' => '',
			'planCode'=>'',
		));

		//sql语句
		$sql="select
			x.planCode,
			x.planDate,
			x.id as planId,
			y.id as orderId,
			y.orderCode,
			y.orderDate,
			y.clientId,
			z.compName,
			a.employName
			from trade_order y
			left join shengchan_plan x on y.id=x.orderId
			left join jichu_client z on z.id=y.clientId
			left join jichu_employ a on a.id=y.traderId
			where 1";

		//业务员只能看自己的订单
		$mUser = & FLEA::getSingleton('Model_Acm_User');
		$canSeeAllOrder = $mUser->canSeeAllOrder($_SESSION['USERID']);
		if(!$canSeeAllOrder) {
			//如果不能看所有订单，得到当前用户的关联业务员
			$traderId = $mUser->getTraderIdByUser($_SESSION['USERID']);
			$sql .= " and y.traderId in({$traderId})";
		}
		//搜索条件
		// if($arr['isOver']==0){
		// 	$sql.=" and (x.isOver='{$arr['isOver']}' or x.id is null)";
		// }else if($arr['isOver']==1){
		// 	$sql.=" and x.isOver='{$arr['isOver']}'";
		// }
		$arr['clientId']>0 && $sql.=" and y.clientId='{$arr['clientId']}'";
		$arr['traderId']>0 && $sql.=" and y.traderId='{$arr['traderId']}'";
		$arr['orderCode']!='' && $sql.=" and y.orderCode like '%{$arr['orderCode']}%'";
		$arr['planCode']!='' && $sql.=" and x.planCode like '%{$arr['planCode']}%'";
		

		// order by
		$sql.=" order by y.orderCode desc,x.planCode desc";
		// dump($sql);exit;
		$pager = &new TMIS_Pager($sql);

		//查找数据集
		if($_GET['data']==1){
			$rowset = $pager->findAll();

			FLEA::loadClass('TMIS_Common');//处理进度条
			$width=70;$height=15;$bgColor="#00FF00";

			foreach($rowset as & $v) {
				//查找要货数,支持查看明细
				$sql="select sum(cntYaohuo) as cntYaohuo,unit,dateJiaohuo,group_concat(id) as ord2proId from trade_order2product where orderId='{$v['orderId']}'";
				$temp = $this->_modelExample->findBySql($sql);
				$v['cntYaohuo'] = round($temp[0]['cntYaohuo'],2).' '.$temp[0]['unit'];
				$v['dateJiaohuo'] = "<span class='text-danger'>".$temp[0]['dateJiaohuo']."</span>";
				$v['ord2proId'] = $temp[0]['ord2proId'];
				$unitOrder = $temp[0]['unit'];
				$cntYaohuo = $temp[0]['cntYaohuo'];

				if($v['ord2proId']=='')$v['ord2proId']='null';
				//查找订单已出库的数量
				$sql="select sum(cnt) as cnt , sum(cntM) as cntM from cangku_chuku_son x 
				where x.ord2proId in ({$v['ord2proId']})";
				$temp = $this->_modelExample->findBySql($sql);
				if($unitOrder=='M'){
					$v['chukuCnt']=round($temp[0]['cntM'],2);
				}else{
					$v['chukuCnt']=round($temp[0]['cnt'],2);
				}

				//生成进度条
				//形成多个进度条
				$barPro=round($v['chukuCnt']/$cntYaohuo,4);//默认未开始
				
				//进度条
				$v['chukuCnt'] = TMIS_Common::progressBar($barPro,array(
						'direction'=>0,
						'width'=>$width,
						'height'=>$height,
						'title'=>"已出库：".$v['chukuCnt']." ".$unitOrder."<br>已出库比例：<span class='text-danger'>".($barPro*100)."%</sapn>",
						'url'=>$this->_url('ListXsView',array(
									'orderId'=>$v['orderId'],
									'no_edit'=>1,
								)),
						'dialogWidth'=>'80%',
						'class'=>'openDialog',
				));

				//没有计划信息
				if(!$v['planId']>0){
					$v['planCode'].='';
					$v['planDate'].='';
					$v['planId']=0;
					continue;
				}

				//查找计划明细信息
				$sql="select x.id as plan2proId,x.pibuCnt,x.cntShengchan,x.color,y.proCode,y.pinzhong,y.guige,x.productId
				from shengchan_plan2product x 
				left join jichu_product y on x.productId=y.id
				where x.planId='{$v['planId']}'";
				$plan2Info = $this->_modelExample->findBySql($sql);

				foreach ($plan2Info as $k => & $p) {
					$p['pibuCnt'] = round($p['pibuCnt'],2);
					$p['cntShengchan'] = round($p['cntShengchan'],2);
					$p['orderId']=$v['orderId'];
					$p['planId']=$v['planId'];

					$v['pibuCnt']+=$p['pibuCnt'];
					$v['cntShengchan']+=$p['cntShengchan'];
				}
				count($temp)>0 && $v['children']=$plan2Info;
				
			}

			//处理数据
			$this->_setData($rowset);

			// dump($rowset);exit;
			echo json_encode($rowset);exit;
			
		}

		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			array('header'=>'订单号','dataIndex'=>'orderCode','width'=>130),
			array('header'=>'客户名称','dataIndex'=>'compName','width'=>150),
			array('header'=>'业务员','dataIndex'=>'employName','width'=>70),
			array('header'=>'订单日期','dataIndex'=>'orderDate','width'=>80),
			array('header'=>'订单交期','dataIndex'=>'dateJiaohuo','width'=>80),
			array('header'=>'下单数量','dataIndex'=>'cntYaohuo','width'=>80),
			array('header'=>'计划单号','dataIndex'=>'planCode','width'=>90),
			array('header'=>'计划日期','dataIndex'=>'planDate','width'=>80),
			array('header'=>'产品编号','dataIndex'=>'proCode','width'=>80),
			array('header'=>'品种','dataIndex'=>'pinzhong','width'=>80),
			array('header'=>'规格','dataIndex'=>'guige','width'=>100),
			array('header'=>'颜色','dataIndex'=>'color','width'=>80),
			array('header'=>'计划生产(Kg)','dataIndex'=>'cntShengchan','width'=>90),
			// array('header'=>'计划投坯(Kg)','dataIndex'=>'pibuCnt','width'=>90),
			array('header'=>'已出库','dataIndex'=>'chukuCnt','width'=>80),
		);

		$smarty->assign('title', '生产计划跟踪统计');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('sonTpl', "Trade/sonTpl.tpl");
		$smarty->assign('sonViewTpl', "Trade/sonViewTpl.tpl");
		$smarty->assign('arr_field_value', $rowset);
		
		//处理需要传递的参数信息
		$get = array_merge($arr,array('data'=>1),$_GET);
		unset($get['controller']);
		unset($get['action']);
		$smarty->assign('dataUrl', $this->_url($_GET['action'],$get));
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('Trade/TradeTracing.tpl');
	}

	/**
	 * 处理数据是否需要打开
	 * Time：2014/08/27 17:03:57
	 * @author li
	*/
	function _setData(& $arr){
		foreach ($arr as & $v) {
			//是否为根目录
			if(!count($v['children'])>0){
				// dump($v);exit;
				$v['leaf']=true;
				$v['iconCls']="icon-empty";
			}
			else{
				// $v['expanded']=true;
				$this->_setData($v['children']);
			}
		}
	}

	/**
	 * 获取订单的出库信息
	 * Time：2014/08/29 13:52:27
	 * @author li
	 * @param get
	 * @return json
	*/
	function actionGetChukuInfoByOrderId(){
		$orderId = (int)$_GET['orderId'];

		//查找订单信息
		$model2pro = & FLEA::getSingleton('Model_Trade_Order2Product');
		$model2pro->clearLinks();
		$order2proInfo = $model2pro->findAll(array('orderId'=>$orderId));

		//查找出库的信息
		foreach ($order2proInfo as $key => & $v) {
			$sql="select sum(x.cnt) as cnt,sum(x.cntM) as cntM from cangku_chuku_son x
			where x.ord2proId='{$v['id']}'";
			$temp = $this->_modelExample->findBySql($sql);
			if($v['unit']=='M'){
				$v['chukuCnt'] = $temp[0]['cntM'];
			}else{
				$v['chukuCnt'] = $temp[0]['cnt'];
			}

			//查找基础信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$t=$temp[0];
			$v['proCode'] = $t['proCode'];
			$v['pinzhong'] = $t['pinzhong'];
			$v['guige'] = $t['guige'];

			$v['cntYaohuo'] = round($v['cntYaohuo'],2);
			$v['chukuCnt'] = round($v['chukuCnt'],2);
			$v['chukuCnt2'] = round($v['chukuCnt'],2);
			$v['rate']=round($v['chukuCnt']/$v['cntYaohuo']*100,2).'%';

			$v['chukuCnt'] = "<a href='".$this->_url('ListXsView',array(
				'ord2proId'=>$v['id'],
				'productId'=>$v['productId'],
				'color'=>$v['color'],
				'no_edit'=>1,
			))."' class='openDialog' width='90%' title='销售明细'>{$v['chukuCnt']}</a>";

		}
		//合计行
		if(count($order2proInfo)>0){
			$heji=$this->getHeji($order2proInfo,array('cntYaohuo','chukuCnt2'),'proCode');
			$heji['pinzhong'] = '';
			$heji['chukuCnt'] = $heji['chukuCnt2'];
			$heji['guige'] = '';
			$heji['color'] = '';
			$heji['unit'] = '';
			$heji['rate'] = round($heji['chukuCnt']/$heji['cntYaohuo']*100,2).'%';
			$order2proInfo[]=$heji;
		}
		
		echo json_encode(array('pros'=>$order2proInfo));
	}

	/**
	 * 销售出库明细列表：生产跟踪弹出明细
	 * Time：2014/08/29 16:35:02
	 * @author li
	*/
	function actionListXsView(){
		FLEA::loadClass('TMIS_Pager');
		$arr = $_GET;
		// dump($arr);exit;
		$sql="select x.*,y.chukuCode,y.chukuDate,y.kind,y.type,z.kuweiName,a.pinzhong,a.guige,a.proName,a.proCode
		from cangku_chuku_son x
		left join cangku_chuku y on y.id = x.chukuId
		left join jichu_kuwei z on z.id=y.kuweiId
		left join jichu_product a on a.id=x.productId
		where 1 and y.kind='销售出库'";

		if($arr['orderId']>0){
			$str="select id from trade_order2product where orderId='{$arr['orderId']}'";
			$temp = $this->_modelExample->findBySql($str);
			if(count($temp)>0){
				$arr['ord2proId'] = join(',',array_col_values($temp,'id'));
			}
			
		}
		// dump($temp);exit;
		if($arr['ord2proId']!='')$sql.=" and x.ord2proId in({$arr['ord2proId']})";
		else$sql.=" and 0";
		if($arr['productId']>0)$sql.=" and x.productId='{$arr['productId']}'";
		if($arr['color']!='')$sql.=" and x.color='{$arr['color']}'";
		$sql.=" order by y.chukuDate asc,y.chukuCode";
		// dump($sql);exit;
		$pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		foreach ($rowset as & $v) {
			$v['cnt']=round($v['cnt'],2);
			$v['cntM']=round($v['cntM'],2);
		}

		$heji = $this->getHeji($rowset,array('cnt','cntM'),'_edit');
		$rowset[] = $heji;

		$arrFieldInfo = array(
			"chukuDate" => "发生日期",
			'kind'=>'类型',
			'kuweiName'=>'库位',
			'chukuCode' => array('text'=>'单号','width'=>120),
			"proCode" => '产品编号', 
			"pinzhong" => '品种',
			"guige" => '规格', 
			"color" => '颜色',
			'dengji'=>'等级',
			"cnt" => '数量(Kg)',
			"cntM" => '数量(M)',
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

	//订单成本统计
	function actionchengbenReport(){
		//搜索
		FLEA::loadClass('TMIS_Pager');
		$arr = TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'clientId'=>'',
			'traderId'=>'',
			'orderCode' => '',
			// 'isOver'=>0,
		));
        $sql="select x.*,y.employName,z.compName from trade_order x 
              left join jichu_employ y on y.id=x.traderId
              left join jichu_client z on z.id=x.clientId
              where 1";
        if($arr['dateFrom']!=''){
        	$sql.=" and x.orderDate>='{$arr['dateFrom']}' and x.orderDate<='{$arr['dateTo']}'";
        }
        if($arr['clientId']!=''){
        	$sql.=" and x.clientId='{$arr['clientId']}'";
        }
        if($arr['traderId']!=''){
        	$sql.=" and x.traderId='{$arr['traderId']}'";
        }
        if($arr['orderCode']!=''){
        	$sql.=" and x.orderCode like '%{$arr['orderCode']}%'";
        }
        $sql.=" order by id desc";
        $pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();
		foreach ($rowset as & $v) {
			//获取订单明细的要货数
			$str="select sum(cntYaohuo) as cntYaohuo,round(sum(cntYaohuo*danjia),2) as moneyOrder,group_concat(id) as ord2proId from trade_order2product where orderId='{$v['id']}'";
			$res=$this->_modelExample->findBySql($str);
			$v['cntYaohuo']=$res[0]['cntYaohuo'];
			$v['moneyOrder']=$res[0]['moneyOrder'];
			$v['ord2proId']=$res[0]['ord2proId'];

			if($v['ord2proId']=='')$v['ord2proId']='null';

			//出货数量
			$str="select sum(x.cnt) as cntChuku from cangku_chuku_son x where x.ord2proId in({$v['ord2proId']})";
			$res=$this->_modelExample->findBySql($str);
			$v['cntChuku']=$res[0]['cntChuku'];
           
            //出库过账金额
            $str="select sum(money) as moneyChuku from caiwu_ar_guozhang where ord2proId in({$v['ord2proId']})";
            $res=$this->_modelExample->findBySql($str);
            $v['moneyChuku']=$res[0]['moneyChuku'];


            /*采购过账金额*/
            //查找该订单下所有的计划id,planId
			$sql="select group_concat(id) as planId from shengchan_plan where orderId='{$v['id']}'";
			$temp = $this->_modelExample->findBySql($sql);
			$planId = join(',',array_col_values($temp,'planId'));
			$planId=='' && $planId='null';

			if($planId!='null'){
				//查找所有生产计划的子信息Id
				$sql="select group_concat(id) as plan2proId from shengchan_plan2product where planId in ({$planId})";
				$temp = $this->_modelExample->findBySql($sql);
				$plan2proId = join(',',array_col_values($temp,'plan2proId'));
				$plan2proId=='' && $plan2proId='null';

				//查找所有的投料计划id，工序id
				$sql="select group_concat(x.touliaoId) as touliaoId ,group_concat(y.id) as planGxId 
				from shengchan_plan_touliao2product x 
				left join shengchan_plan2product_gongxu y on x.touliaoId = y.touliaoId
				where x.plan2proId in ({$plan2proId})";
				$temp = $this->_modelExample->findBySql($sql);
				$touliaoId = join(',',array_col_values($temp,'touliaoId'));
				$touliaoId=='' && $touliaoId='null';

				$planGxId = join(',',array_col_values($temp,'planGxId'));
				$planGxId=='' && $planGxId='null';
				// dump($sql);exit;

				//查找纱的成本信息
				$sql="select x.cnt,y.chukuDate,x.pihao,x.supplierId,x.productId from cangku_chuku_son x
				left join cangku_chuku y on y.id=x.chukuId
				where planGxId in ({$planGxId}) and y.type='纱' and y.kind = '织布领料'";
				$caigou = $this->_modelExample->findBySql($sql);
				
				foreach ($caigou as $key => & $v1) {
					//查找最靠近的坯纱单价信息
					$sql="select x.danjia from cangku_ruku_son x
					left join cangku_ruku y on y.id=x.rukuId
					where x.pihao='{$v1['pihao']}' and x.supplierId='{$v1['supplierId']}' and x.productId='{$v1['productId']}'
					and y.rukuDate <='{$v1['chukuDate']}'";
					$temp = $this->_modelExample->findBySql($sql);
					$v1['danjia'] = round($temp[0]['danjia'],6);
					$v['moneySha']+=$v1['cnt']*$temp[0]['danjia'];
				}
				$v['moneySha']==0 && $v['moneySha']='';
				
				//查找所有的入库子表的Id信息，用于关联到应付过账的信息
				$sql="select group_concat(id) as ruku2ProId from cangku_ruku_son where planGxId in ({$planGxId})";
				$temp = $this->_modelExample->findBySql($sql);
				$ruku2ProId = join(',',array_col_values($temp,'ruku2ProId'));
				$ruku2ProId=='' && $ruku2ProId='null';

				//加工成本
				$sql="select sum(money) as moneyJiagong from caiwu_yf_guozhang where isJiagong=1 and ruku2ProId in ({$ruku2ProId})";
				$temp = $this->_modelExample->findBySql($sql);
				$v['moneyJiagong']=$temp[0]['moneyJiagong'];

			}

			//计算利润
			$v['money']=$v['moneyChuku']-$v['moneySha']-$v['moneyJiagong'];

			$v['money'] = $v['money']==0?'':round($v['money'],3);
			$v['moneySha'] = $v['moneySha']==0?'':round($v['moneySha'],3);
			$v['moneyJiagong'] = $v['moneyJiagong']==0?'':round($v['moneyJiagong'],3);
			$v['moneyChuku'] = $v['moneyChuku']==0?'':round($v['moneyChuku'],3);

			//跟踪明细信息
			$v['orderCode']="<a href='".$this->_url('ViewLirun',array(
					'orderId'=>$v['id'],
			))."' target='_blank' ext:qtip='跟踪明细信息'>{$v['orderCode']}</a>";
		}
		//dump($rowset);exit;
		$smarty = &$this->_getView(); 
		// 左侧信息
		$arrFieldInfo = array(
			'orderCode'=>'订单号',
			"orderDate" => array('text'=>'下单日期','width'=>80),
			'compName'=>'客户名称',
			'employName'=>array('text'=>'业务员','width'=>70),
			'cntYaohuo'=>array('text'=>'要货数','width'=>80),
			'cntChuku'=>array('text'=>'出库数量','width'=>80),
			'moneyOrder'=>array('text'=>'订单金额','width'=>80),
			'moneyChuku'=>array('text'=>'出库应收款','width'=>80),
			'moneySha'=>array('text'=>"用纱成本",'width'=>80),
			'moneyJiagong'=>array('text'=>'加工成本','width'=>80),
			'money'=>array('text'=>"<span ext:qtip='利润=出库应收款-采购成本-加工成本'>利润</span>",'width'=>80),
		);

		$smarty->assign('title', '订单利润分析');
		$smarty->assign('arr_field_info', $arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value', $rowset);
		$smarty->assign("page_info", $pager->getNavBar($this->_url($_GET['action'], $arr)));
		$smarty->display('TblList.tpl');
	}

	function actionViewLirun(){
		//订单id
		$orderId = (int)$_GET['orderId'];

		//查找订单信息
		$order = $this->_modelExample->find($orderId);
		$ord2proId = join(',',array_col_values($order['Products'],'id'));
		$ord2proId == '' && $ord2proId='null';
		// dump($order);exit;
		foreach ($order['Products'] as & $v) {
			//获取产品信息
			$sql="select * from jichu_product where id='{$v['productId']}'";
			$res=$this->_modelExample->findBySql($sql);
			$v['proCode']=$res[0]['proCode'];
			if($res[0]['pinzhong']){
				$v['pinzhong']=$res[0]['pinzhong'];
			}else{
				$v['pinzhong']=$res[0]['proName'];
			}
			
			$v['guige']=$res[0]['guige'];
			$v['danjia']=round($v['danjia'],3);
			$v['money']=round($v['danjia']*$v['cntYaohuo'],3);
			$v['cntYaohuo']=round($v['cntYaohuo'],3);
		}
		$order['Products'][]=$this->getHeji($order['Products'],array('money','cntYaohuo'),'proCode');
	    
	    //查找出库信息
		$sql="select y.*,x.chukuDate,x.chukuCode from cangku_chuku x
			left join cangku_chuku_son y on y.chukuId=x.id
			where y.ord2proId in ({$ord2proId})";
		$chuku = $this->_modelExample->findBySql($sql);
		foreach ($chuku as & $vv) {
			//获取产品信息
			$sql="select * from jichu_product where id='{$vv['productId']}'";
			$res=$this->_modelExample->findBySql($sql);
			$vv['proCode']=$res[0]['proCode'];
			if($res[0]['pinzhong']){
				$vv['pinzhong']=$res[0]['pinzhong'];
			}else{
				$vv['pinzhong']=$res[0]['proName'];
			}
			
			$vv['guige']=$res[0]['guige'];
			$vv['danjia']=round($vv['danjia'],6);
			$vv['cnt']=round($vv['cnt'],3);
			//获取应付金额
			$sql="select * from caiwu_ar_guozhang where chuku2proId='{$vv['id']}'";
			$res=$this->_modelExample->findBySql($sql);
			$vv['money']=round($res[0]['money'],2);
		}
		$moneyCk=$this->getHeji($chuku,array('money','cnt'),'proCode');
		$chuku[]=$moneyCk;
	    
		/*采购信息*/
        //查找该订单下所有的计划id,planId
		$sql="select group_concat(id) as planId from shengchan_plan where orderId='{$orderId}'";
		$temp = $this->_modelExample->findBySql($sql);
		$planId = join(',',array_col_values($temp,'planId'));
		$planId=='' && $planId='null';
		//查找采购信息，加工信息
		if($planId!='null'){
			    //查找所有生产计划的子信息Id,用于关联到入库信息
				$sql="select group_concat(id) as plan2proId from shengchan_plan2product where planId in ({$planId})";
				$temp = $this->_modelExample->findBySql($sql);
				$plan2proId = join(',',array_col_values($temp,'plan2proId'));
				$plan2proId=='' && $plan2proId='null';

				//查找所有的投料计划id，工序id
				$sql="select group_concat(x.touliaoId) as touliaoId ,group_concat(y.id) as planGxId 
				from shengchan_plan_touliao2product x 
				left join shengchan_plan2product_gongxu y on x.touliaoId = y.touliaoId
				where x.plan2proId in ({$plan2proId})";
				$temp = $this->_modelExample->findBySql($sql);
				$touliaoId = join(',',array_col_values($temp,'touliaoId'));
				$touliaoId=='' && $touliaoId='null';

				$planGxId = join(',',array_col_values($temp,'planGxId'));
				$planGxId=='' && $planGxId='null';

				//查找所有的采购计划信息，用于关联到出库信息
				$sql="select group_concat(id) as cgPlanId from pisha_plan where touliaoId in ({$touliaoId})";
				$temp = $this->_modelExample->findBySql($sql);
				$cgPlanId = join(',',array_col_values($temp,'cgPlanId'));
				$cgPlanId=='' && $cgPlanId='null';



				//采购明细
				/*$sql="select x.*,y.rukuDate,y.kind,x.supplierId from cangku_ruku_son x 
				      left join cangku_ruku y on y.id=x.rukuId
				      where y.cgPlanId in ({$cgPlanId}) and y.isJiagong=0";
				$caigou = $this->_modelExample->findBySql($sql);
				foreach ($caigou as & $v1) {
					//获取产品信息
					$sql="select * from jichu_product where id='{$v1['productId']}'";
					$res=$this->_modelExample->findBySql($sql);
					$v1['proCode']=$res[0]['proCode'];
					if($res[0]['pinzhong']){
							$v1['pinzhong']=$res[0]['pinzhong'];
					}else{
							$v1['pinzhong']=$res[0]['proName'];
					}
					$v1['guige']=$res[0]['guige'];

					//获取供应商
					$sql="select * from jichu_jiagonghu where id='{$v1['supplierId']}'";
					$res=$this->_modelExample->findBySql($sql);
					$v1['compName']=$res[0]['compName'];

					//获取过账金额
					$sql="select * from caiwu_yf_guozhang where ruku2ProId='{$v1['id']}' and isJiagong=0";
					$res=$this->_modelExample->findBySql($sql);
					$v1['money']=round($res[0]['money'],2);

					$v1['danjia']=round($v1['danjia'],6);
					$v1['cnt']=round($v1['cnt'],2);
					if($v1['isHaveGz']==0){
						$v1['isOver']='未过账';
					}else{
						$v1['isOver']='过账';
					}
				}
				$moneyCg=$this->getHeji($caigou,array('money','cnt'),'proCode');
				$caigou[]=$moneyCg;*/

				//查找纱的成本信息
				$sql="select x.*,y.chukuDate,y.kind from cangku_chuku_son x
				left join cangku_chuku y on y.id=x.chukuId
				where planGxId in ({$planGxId}) and y.type='纱' and y.kind = '织布领料'";
				$caigou = $this->_modelExample->findBySql($sql);

				foreach ($caigou as $key => & $v1) {
					//查找最靠近的坯纱单价信息
					$sql="select x.danjia from cangku_ruku_son x
					left join cangku_ruku y on y.id=x.rukuId
					where x.pihao='{$v1['pihao']}' and x.supplierId='{$v1['supplierId']}' and x.productId='{$v1['productId']}'
					and y.rukuDate <='{$v1['chukuDate']}'";
					$temp = $this->_modelExample->findBySql($sql);
					$v1['danjia'] = round($temp[0]['danjia'],6);
					$v1['money']=round($v1['cnt']*$temp[0]['danjia'],3);
					$v1['money']==0 && $v1['money']='';

					//获取产品信息
					$sql="select * from jichu_product where id='{$v1['productId']}'";
					$res=$this->_modelExample->findBySql($sql);
					$v1['proCode']=$res[0]['proCode'];
					if($res[0]['pinzhong']){
							$v1['pinzhong']=$res[0]['pinzhong'];
					}else{
							$v1['pinzhong']=$res[0]['proName'];
					}
					$v1['guige']=$res[0]['guige'];

					//获取供应商
					$sql="select * from jichu_jiagonghu where id='{$v1['supplierId']}'";
					$res=$this->_modelExample->findBySql($sql);
					$v1['compName']=$res[0]['compName'];
				}

				$moneyCg=$this->getHeji($caigou,array('money','cnt'),'proCode');
				$caigou[]=$moneyCg;
				

				//加工明细
				$sql="select x.*,y.rukuDate,y.kind,x.supplierId,y.jiagonghuId from cangku_ruku_son x 
				      left join cangku_ruku y on y.id=x.rukuId
				      where x.planGxId in ({$planGxId}) and y.isJiagong=1";
				$jiagong = $this->_modelExample->findBySql($sql);
				foreach ($jiagong as & $v1) {
					//获取产品信息
					$sql="select * from jichu_product where id='{$v1['productId']}'";
					$res=$this->_modelExample->findBySql($sql);
					$v1['proCode']=$res[0]['proCode'];
					if($res[0]['pinzhong']){
							$v1['pinzhong']=$res[0]['pinzhong'];
					}else{
							$v1['pinzhong']=$res[0]['proName'];
					}
					$v1['guige']=$res[0]['guige'];

					//获取工序信息
					$sql="select * from shengchan_plan2product_gongxu where id='{$v1['planGxId']}'";
					$res=$this->_modelExample->findBySql($sql);
					$v1['gongxuName']=$res[0]['gongxuName'];
					$v1['genzongDate']=$res[0]['dateFrom'];
					$v1['overDate']=$res[0]['dateTo'];

					//获取加工户
					$sql="select * from jichu_jiagonghu where id='{$v1['jiagonghuId']}'";
					$res=$this->_modelExample->findBySql($sql);
					$v1['compName']=$res[0]['compName'];

					//获取过账金额
					$sql="select * from caiwu_yf_guozhang where ruku2ProId='{$v1['id']}' and isJiagong=1";
					$res=$this->_modelExample->findBySql($sql);
					$v1['money']=round($res[0]['money'],2);

					$v1['danjia']=round($v1['danjia'],6);
					$v1['cnt']=round($v1['cnt'],2);

					if($v1['isHaveGz']==0){
						$v1['isOver']='未过账';
					}else{
						$v1['isOver']='过账';
					}
				}
				$moneyJg=$this->getHeji($jiagong,array('money','cnt'),'proCode');
				$jiagong[]=$moneyJg;
				//成本，应收信息
				$order['yingshou']=$moneyCk['money'];
				$order['chengben']=$moneyJg['money']+$moneyCg['money'];
				$order['lirun']=$order['yingshou']-$order['chengben'];
		}

		$smarty = & $this->_getView();
		$smarty->assign('title', '订单利润分析明细');
		$smarty->assign('order', $order);
		$smarty->assign('chuku', $chuku);
		$smarty->assign('caigou', $caigou);
		$smarty->assign('jiagong', $jiagong);
		$smarty->display('Trade/LirunView.tpl');
	}
}
?>