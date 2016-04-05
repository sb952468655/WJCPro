<?php
FLEA::loadClass('Controller_Trade_Order');
class Controller_Trade_OrderSha extends Controller_Trade_Order {

//**************************************构造函数 begin********************************
	function Controller_Trade_OrderSha() {
		//定义模板中的主表字段
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
            'finalDate'=>array('title'=>'订单交期','type'=>'calendar','value'=>date('Y-m-d')),
            // *options为数组,必须有text和value属性
			'traderId'=>array('title'=>'业务负责','type'=>'select','value'=>'','options'=>$this->_modelEmploy->getSelect()),

        ///*******2个一行******
			//clientpopup需要显示客户名称,所以需要定义clientName属性,value属性作为clientId用
			'clientId'=>array('title'=>'客户名称','type'=>'clientpopup','clientName'=>''),
			'clientOrder'=>array('title'=>'客户单号','type'=>'text','value'=>''),
			
						
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
            'unit'=>array('title'=>'要货单位','type'=>'select','value'=>'Kg','options'=>array(
            	// array('text'=>'M','value'=>'M'),
            	//array('text'=>'Y','value'=>'Y'),
            	array('text'=>'Kg','value'=>'Kg'),
            )),
 
        ///*******2个一行******
            'bizhong'=>array('title'=>'交易币种','type'=>'select','value'=>'RMB','options'=>array(
				array('text'=>'RMB','value'=>'RMB'),
				array('text'=>'USD','value'=>'USD'),
			)),
            'huilv'=>array('title'=>'汇率','type'=>'text','value'=>'1'),

			//定义了name以后，就不会以memo作为input的id了
			// 'memo'=>array('title'=>'订单备注','type'=>'textarea','disabled'=>true,'name'=>'orderMemo'),
			//下面为隐藏字段
			'orderId'=>array('type'=>'hidden','value'=>''),
			'kind'=>array('type'=>'hidden','value'=>'色纱'),
		);

		///从表表头信息
		///type为控件类型,在自定义模板控件
		///title为表头
		///name为控件名
		///bt开头的type都在webcontrolsExt中写的,如果有新的控件，也需要增加
		$this->headSon = array(
			'_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
			'productId'=>array('type'=>'btproductpopup',"title"=>'产品选择','name'=>'productId[]'),
			// 'zhonglei'=>array('type'=>'bttext',"title"=>'成分','name'=>'zhonglei[]','readonly'=>true),
			'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
			'guige'=>array('type'=>'bttext',"title"=>'规格','name'=>'guige[]','readonly'=>true),
			'color'=>array('type'=>'bttext',"title"=>'颜色','name'=>'color[]','readonly'=>true),
			'cntYaohuo'=>array('type'=>'bttext',"title"=>'数量','name'=>'cntYaohuo[]'),
			'danjia'=>array('type'=>'bttext',"title"=>'单价','name'=>'danjia[]'),
			'money'=>array('type'=>'bttext',"title"=>'金额','name'=>'money[]','readonly'=>true),
			'memo'=>array('type'=>'bttext',"title"=>'备注','name'=>'memo[]'),
			//***************如何处理hidden?
			'id'=>array('type'=>'bthidden','name'=>'id[]'),
		);

		//表单元素的验证规则定义
		$this->rules = array(
			'headId'=>'required',
			'orderCode'=>'required',
			'orderDate'=>'required',
			'clientId'=>'required',
			'traderId'=>'required',
			'unit'=>'required'
		);

		//其他备注
		$this->arr_memo=array(
			'memoTrade'=>array('title'=>'经营要求','type'=>'textarea','disabled'=>true,'name'=>'memoTrade'),
			'memoYongjin'=>array('title'=>'佣金备注','type'=>'textarea','disabled'=>true,'name'=>'memoYongjin'),
			'memoWaigou'=>array('title'=>'外购备注','type'=>'textarea','disabled'=>true,'name'=>'memoWaigou'),
			
		);
		$str='1.颜色按客户指定的合理缸差范围进行生产，色牢度干摩擦4级，湿摩擦浅色3-4级，深色2.5-3级，达到环保要求。对色光源：D65（自然光）
2.缩水经纬3%—4%，弹性、手感好，克重达标。
3.强度好：顶破强力300N以上。
4.布面不准有色迹、污点、色花。废边在1.5cm以内。
5.按照FR标准执行。
6.工艺损耗6%-7%。
7.定型染色疵点不超过1%
';
		//合同条款
		$this->arr_item = array(
			'orderItem1'=>array('title'=>'第二 质量标准','type'=>'textarea','disabled'=>true,'name'=>'orderItem1','value'=>$str),
			'orderItem2'=>array('title'=>'第三 包装标准','type'=>'textarea','disabled'=>true,'name'=>'orderItem2','value'=>'塑料薄膜包装。特殊要求另行协商。'),
			'orderItem3'=>array('title'=>'第四 交货数量','type'=>'textarea','disabled'=>true,'name'=>'orderItem3','value'=>'大货数量允许 ±3%。'),
			'orderItem4'=>array('title'=>'第五 交货方式','type'=>'textarea','disabled'=>true,'name'=>'orderItem4','value'=>'由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。'),
			'orderItem5'=>array('title'=>'第六 交货时间','type'=>'textarea','disabled'=>true,'name'=>'orderItem5','value'=>'自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。'),
			'orderItem6'=>array('title'=>'第七 结算方式','type'=>'textarea','disabled'=>true,'name'=>'orderItem6','value'=>'预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。'),
			'orderItem7'=>array('title'=>'第八 争议解决','type'=>'textarea','disabled'=>true,'name'=>'orderItem7','value'=>'本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；'),
		);

	}
//******************************构造函数 end******************************************

	
//***************************** 订单查询 begin*************************************
	function actionRight(){
		$this->authCheck('1-4');
		FLEA::loadClass('TMIS_Pager');

         ///构造搜索区域的搜索类型
        $serachArea=TMIS_Pager::getParamArray(array(
			'dateFrom' =>date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y"))),
			'dateTo' => date("Y-m-d"),
			'clientId' => '',
			'traderId' => '',
			'isCheck' => 0, 
			'orderCode' =>'',
			// 'zhonglei'=>'',
			'guige'=>'',
			'color'=>'',
        	));
       
		$str = "select x.unit,
			y.orderDate,y.orderCode,y.clientOrder,y.bizhong,y.id as orderId,y.isCheck,y.id,
			a.compName,b.employName
			from trade_order2product x
			left join trade_order y on x.orderId=y.id
			left join jichu_client a on y.clientId=a.id
			left join jichu_employ b on y.traderId=b.id
			left join jichu_product z on z.id=x.productId
			where 1 and y.kind='色纱'";
		
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
        if($serachArea['zhonglei'] != '') $str .=" and z.zhonglei like '%{$serachArea['zhonglei']}%'";
        if($serachArea['guige'] != '') $str .=" and z.guige like '%{$serachArea['guige']}%'";  
        if($serachArea['color'] != '') $str .=" and z.color like '%{$serachArea['color']}%'";        
        if($serachArea['clientId'] != '') $str .= " and y.clientId = '{$serachArea['clientId']}'";
        if($serachArea['traderId'] != '') $str .= " and y.traderId = '{$serachArea['traderId']}'";
		$str .= " group by x.orderId order by y.orderDate desc, substring(y.orderCode,3) desc";


        $pager = & new TMIS_Pager($str);
		$rowset = $pager->findAll();
        //dump($rowset);exit;

		$trade_order2product = & FLEA::getSingleton('Model_Trade_Order2Product');
		// $trade_order2product->clearLinks();
		if (count($rowset)>0) foreach($rowset as & $value) {
			$value['_edit'].="<a href='".$this->_url('Edit',array('id'=>$value['id']))."'>修改</a>";
			$value['_edit'].=" | <a href='".$this->_url('Remove',array('id'=>$value['id']))."'  onclick=\"return confirm('确认删除吗?')\" >删除</a>";

			//是否审核
			$over=$value['isCheck']==1?0:1;
			$strOver=$value['isCheck']==1?'取消':'';
			$value['_edit'] .= " | <a href='".$this->_url('setOver',array(
				'id'=>$value['id'],
				'isCheck'=>$over,
				'fromAction'=>$_GET['action']
				))."' onclick='return confirm(\"确认操作吗?\")' ext:qtip='设置订单为".$strOver."审核'>".$strOver."审核</a>";

			//打印
			//打印
			if($value['isCheck']==1){
				$value['_edit'] .= " | <a href='".$this->_url('Print',array(
					'id'=>$value['id'],
				))."' target='_blank' ext:qtip='打印合同'>打印</a>";
			}else{
				$value['_edit'] .= " | <span ext:qtip='未审核，不能打印'>打印</span>";
			}
        	//在左侧中 显示 总数量 和 总金额 初始化  
          	$value['cntTotal']=0;
          	$value['moneyTotal']=0;

           	$res= $trade_order2product ->findAll(array('orderId'=>$value['id']));
           	foreach($res as & $item){
	             //添加信息
	           	 $item['cntYaohuo']=round($item['cntYaohuo'],2);
	           	 $item['danjia']=round($item['danjia'],6);
	           	 $item['zhonglei']=$item['Products']['zhonglei'];
	             $item['proName']=$item['Products']['proName'];
	             $item['guige']=$item['Products']['guige'];
	             $item['color']=$item['Products']['color'];
	             $item['money']=round($item['cntYaohuo']*$item['danjia'],2);
	              //在左侧中 显示 总数量 和 总金额 累加
	             $value['cntTotal']+= $item['cntYaohuo'];
	             $value['moneyTotal']+= $item['money'];
	             $value['unit'] = $item['unit'];
	             unset($item['Order']);
           }
           $value['DetailProducts']=$res;
           //dump($res);exit;
		}

		#合计行
		$heji = $this->getHeji($rowset,array('cntYaohuo','moneyTotal'),'_edit');
		$rowset[] = $heji;
		
		//dump($rowset);exit;
 
		$smarty = & $this->_getView();
		//左侧信息
		$arrFieldInfo = array(
			"_edit"=>'操作',
			"orderDate" =>"日期",
		    'orderCode'=>'订单编号',			
			"compName" =>"客户名称",
			'employName'=>array('text'=>'业务员','width'=>70),
			"cntTotal" =>array('text'=>'数量','width'=>70),
			"unit" =>array('text'=>'单位','width'=>70),
			"moneyTotal" =>array('text'=>'金额','width'=>70),
			"bizhong" =>array('text'=>'币种','width'=>70),
			//"orderMemo" =>'订单备注',
			//"memo" =>'产品备注'
		);
        
        //左边点击后 右侧信息
		$arrField=array(
			// 'zhonglei'=>'成分',
			'proName'=>'纱支',
			'guige'=>'规格',
			'color'=>'颜色',
			"cntYaohuo" =>'数量',
			"danjia" =>'单价',
			"money" =>'金额',
			//"memo" =>'产品备注'
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

	function actionSave() {
		// ~~dump($_POST); EXIT;~~
		// ~~半成品与成品明细登记时 不允许成品和半成品同时存在 ，如果存在则禁止保存~~
        //dump($_POST); EXIT;
         //trade_order2product 表 的数组
		//查找原来的订单信息是否改变
		if($_POST['orderId']>0){
			$oldOrder = $this->_modelExample->find($_POST['orderId']);
			// dump($oldOrder);exit;
		}

		////////////////////////////
         $trade_order2product=array();
         $ii=0;
         foreach ($_POST['productId'] as $key => $v) {
         	$ii++;
         	// 当没有记录 或者 没有输入数量时 跳出本次循环 防止多保存
         	if(empty($_POST['productId'][$key]) || empty($_POST['cntYaohuo'][$key])) continue;
         	if($_POST['unit']=='Kg')$cntKg=$_POST['cntYaohuo'][$key];
         	 $trade_order2product[] = array(
                  'id'=>$_POST['id'][$key],
                  'numId'=>$ii,                   //主键id
                  'productId'=>$_POST['productId'][$key],       //产品id
                  'cntYaohuo'=>$_POST['cntYaohuo'][$key],       //要货数量
                  'cntKg'=>$cntKg,      
                  'unit'=> $_POST['unit'],                //单位 
                  'danjia'=>$_POST['danjia'][$key],             //单价
                  'memo'=>$_POST['memo'][$key].'',                 //备注
                  'dateJiaohuo'=>$_POST['finalDate'],           //交货日期 
         	 	);
         }

          //处理订单编号
       
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
       //保存 并返回trade_order表的主键

       //保存前处理数据
       $this->_beforUpdate($trade_order);
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
    	));

		$sql="select sum(x.cntKg) as cntKg,sum(x.cntYaohuo*x.danjia) as money,y.clientId,y.traderId,z.compName,b.employName from trade_order2product x 
		 	left join trade_order y on y.id=x.orderId
		 	left join jichu_client z on z.id=y.clientId
		 	left join jichu_employ b on b.id=y.traderId
		 	where 1 and y.kind='色纱'";

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
		$sql.=" group by y.clientId order by z.letters";

		//取数据信息
		$pager = & new TMIS_Pager($sql);
		$rowset = $pager->findAll();

		//处理数据
		foreach($rowset as & $v){
			$v['cntKg']=round($v['cntKg'],2);
			$v['money']=round($v['money'],6);
			$v['money2']=$v['money'];
			//显示明细信息
			$v['money']="<a href='".$this->_url('View',array(
				'dateFrom'=>$arr['dateFrom'],
				'dateTo'=>$arr['dateTo'],
				'clientId'=>$v['clientId'],
				'no_edit'=>1,
				'width'=>'900',
				'baseWindow'=>'parent',
				'TB_iframe'=>1
			))."' title='查看明细' class='thickbox'>{$v['money']}</a>";
		}

		$heji = $this->getHeji($rowset,array('cntKg','money2'),'compName');
		$heji['money']=$heji['money2'];
		$rowset[] = $heji;
		
		//左侧信息
		$arrFieldInfo = array(			
			"compName" =>array('text'=>'客户名称','width'=>170),
			'employName'=>array('text'=>'业务员','width'=>100),
			"cntKg" =>array('text'=>'数量(Kg)','width'=>100),
			"money" =>array('text'=>'金额','width'=>100),
		);
       
		$smarty = & $this->_getView();
		$smarty->assign('title','订单汇总报表');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action']), $serachArea));
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
    	));

		$sql="select x.*,x.cntYaohuo*x.danjia as money,y.clientId,y.traderId,y.orderDate,y.orderCode,y.bizhong,z.compName,b.employName,a.pinzhong,a.proName,a.guige,a.color,a.zhonglei from trade_order2product x 
		 	left join trade_order y on y.id=x.orderId
		 	left join jichu_client z on z.id=y.clientId
		 	left join jichu_employ b on b.id=y.traderId
		 	left join jichu_product a on a.id=x.productId
		 	where 1 and y.kind='色纱'";

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
		$sql.=" order by x.orderId desc,x.numId";

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

		$heji = $this->getHeji($rowset,array('cntKg','money'),'orderDate');
		$rowset[] = $heji;
		
		//左侧信息
		$arrFieldInfo = array(
			"orderDate" =>"日期",
		    'orderCode'=>'订单编号',			
			"compName" =>"客户名称",
			// "zhonglei" =>"成分",
			"proName" =>"支数",
			"guige" =>"规格",
			"color" =>"颜色",
			"money" =>array('text'=>'金额','width'=>70),
			"bizhong" =>array('text'=>'币种','width'=>70),
			"cntKg" =>array('text'=>'数量(cntKg)','width'=>90),
			"money" =>array('text'=>'金额','width'=>70),
			// "cntYaohuo" =>array('text'=>'要货数量','width'=>70),
			// "unit" =>array('text'=>'单位','width'=>70),
		);
       
		$smarty = & $this->_getView();
		$smarty->assign('title','订单汇总报表');
		$smarty->assign('arr_field_info',$arrFieldInfo);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->assign('arr_field_value',$rowset);
		$smarty->assign("page_info",$pager->getNavBar($this->_url($_GET['action']), $serachArea));
		$smarty->display('TableList.tpl');
	}
}
?>