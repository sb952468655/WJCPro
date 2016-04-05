<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Main extends Tmis_Controller {
	var $_modelExample;
	var $_modelAcmOa;
	function Controller_Main() {
		$this->_modelExample = & FLEA::getSingleton('Model_OaMessage');
		$this->_modelAcmOa = & FLEA::getSingleton('Model_Acm_User2message');
	}
	function actionIndex() {
		//dump($_SESSION['REALNAME']);exit;
		if (!$_SESSION['REALNAME']) {
			redirect(url("Login"));	exit;
		}
		
		//判断企业为★用户
		//dump($_SESSION);exit;
		//判断企业为★用户
		$jinyan=0;$msg="";
		$dj=0;
		$jingyanStr=$this->GetJingyan();
		//dump($jingyanStr);exit;
		$jinyan=$jingyanStr['jingyan'];
		$msg=$jingyanStr['msg'];
		$dj=$jingyanStr['dj'];
		$userMsg=$jingyanStr['userMsg'];
		//如果$_SESSION【’SN】为1，显示工具箱链接，没有则不显示
		//dump($_SESSION['SN']);exit;
		if($_SESSION['SN']){
			$tool="<a href='".url('tool','Index')."' target='_blank' title='打开工具箱' style='color:white;text-decoration: underline;'>工具箱</a>". '&nbsp;&nbsp;';
		}else{
			$tool="";
		}

		
		$smarty = & $this->_getView();
		$smarty->assign('menu_json',json_encode($tree));
		$smarty->assign('action',$action);
//		$smarty->assign('dj',$dj);
//		$smarty->assign('userJy',$userJy);
//		$smarty->assign('userMsg',$userMsg);
		$smarty->assign('tool',$tool);
		$smarty->display('Main.tpl');
	}

	function actionGetMenu() {
		$f = & FLEA::getAppInf('menu');
		include $f;
		$m= & FLEA::getSingleton('Model_Acm_Func');
		$menu = array('children'=>$_sysMenu);
		foreach($_sysMenu as & $v) {
			$m->changeVisible($v,array('userName'=>$_SESSION['USERNAME']));
		}
		
		$mC = & FLEA::getSingleton('TMIS_Controller');
		$sys = $mC->getSysSet();
		foreach($_sysMenu as & $v) {
			$m->changeVisibleBySys($v,$sys);
		}
		// dump($_sysMenu);exit;
		echo json_encode($_sysMenu);
	}

	function actionWelcome() {
		$smarty = & $this->_getView();
		//报表中心
		$f = & FLEA::getAppInf('menu');
		include $f;
		$m= & FLEA::getSingleton('Model_Acm_Func');
		$baoBiao=array();
		foreach($_sysMenu as & $v) {
			if($v['text']=='报表中心') {
				$res=$m->changeVisible($v,array('userName'=>$_SESSION['USERNAME']));
				$baoBiao=$v['hidden'] == 1 ? array() : $v['children'];
			}
		}
		
		//没有权限的不显示
		$baoBiao2 = array();
		foreach ($baoBiao as $key => & $v) {
			if(!$v['hidden'])$baoBiao2[] = $v;
		}

		$smarty->assign('baobiao',$baoBiao2);


		//得到最近的10条生产通知
		$str="SELECT * FROM `oa_message` where kindName<>'订单变动通知' order by id desc limit 0,10";
		$tongzhi=$this->_modelExample->findBySql($str);
		if(count($tongzhi)>0) {
			foreach($tongzhi as & $v) {
				$title=$v['title'];
				if(strlen($v['title'])>20) {
					$content=$this->changToHtml($title);
					$title=$this->cSubstr($content,0,20)."......";
				}
				//dump($title);exit;
				$v['title'] = "<a href='javascript:void(0)' class='tongzhi' title='查看通知' id='{$v['id']}'>{$title}</a>";
				if($v['buildDate']>=$dateFrom&&$v['buildDate']<=$dateTo){
					$v['title'].="<img src='Resource/Image/new.gif' width='28' height='11' />";
				}
			}
		}
		$smarty->assign('tongzhi_xingzheng',$tongzhi);

		//订单变动通知
		$str="SELECT * FROM `oa_message` where kindName='订单变动通知' order by id desc limit 0,10";
		$dingdan=$this->_modelExample->findBySql($str);
		if(count($dingdan)>0) {
			foreach($dingdan as & $v1) {
				$v1['title'] = "<a href='javascript:void(0)' class='tongzhi' title='查看通知' id='{$v1['id']}'>{$v1['title']}</a>";
				if($v1['buildDate']>=$dateFrom&&$v1['buildDate']<=$dateTo){
					$v1['title'].="<img src='Resource/Image/new.gif' width='28' height='11' />";
				}
			}
		}
		$smarty->assign('tongzhi_biandong',$dingdan);

		//近7天需要交货预警
		$dateFrom = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
		$dateTo = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+7,date('Y')));
		$sql="SELECT x.*,y.orderCode,z.pinzhong,z.guige FROM `trade_order2product` x
		left join trade_order y on x.orderId=y.id
		left join jichu_product z on z.id=x.productId
		where x.dateJiaohuo>='{$dateFrom}' and x.dateJiaohuo <= '{$dateTo}'
		group by x.orderid order by dateJiaohuo";
		//echo $sql;exit;
		$order=$this->_modelExample->findBySql($sql);
		if(count($order)>0) {
			foreach($order as & $v) {
				$temp=round((strtotime($v['dateJiaohuo'])-strtotime($dateFrom))/86400);
				$v['orderCode']="{$v['orderCode']}【{$v['pinzhong']},{$v['guige']},{$v['color']}】,{$v['dateJiaohuo']}交货，距今{$temp}天";
			}
		}
		$smarty->assign('tongzhi_jiaohuo',$order);

		//已逾期订单
		$sql="SELECT x.*,y.orderCode,z.pinzhong,z.guige FROM `trade_order2product` x 
		left join trade_order y on x.orderId=y.id
		left join jichu_product z on z.id=x.productId
		where x.dateJiaohuo<='{$dateFrom}' and y.isOver=0
		and not exists(SELECT id FROM `cangku_chuku` where orderId=x.orderId)
		group by x.orderId order by x.dateJiaohuo desc";
		//echo $sql;exit;
		$row=$this->_modelExample->findBySql($sql);
		if(count($row)>0) {
			foreach($row as & $v) {
				$temp=abs(round((strtotime($v['dateJiaohuo'])-strtotime($dateFrom))/86400));
				$v['orderCode']="{$v['orderCode']}【{$v['proName']},{$v['guige']},{$v['color']}】,{$v['dateJiaohuo']}交货，已逾期{$temp}天";
			}
		}
		$smarty->assign('tongzhi_yuqi',$row);

		$smarty->display('Welcome.tpl');
	}

	function actionTzViewDetails() {
	//dump($_GET);exit;
		$row=$this->_modelExample->findAll(array('id'=>$_GET['id']));
		if($_SESSION['USERID']!='') {
			if($row[0]['kindName']!='订单变动通知') {
				$sql="SELECT count(*) as cnt,kind,id FROM `acm_user2message` where messageId='{$_GET['id']}' and userId='{$_SESSION['USERID']}'";
				$rr=mysql_fetch_assoc(mysql_query($sql));
				
				if($rr['cnt']==0) {
					$arr=array(
						'userId'=>$_SESSION['USERID'],
						'messageId'=>$_GET['id'],
						'kind'=>0,
					);
				}else if($rr['kind']==1){
					$arr=array(
						'id'=>$rr['id'],
						'kind'=>0,
					);
				}
				
				if($arr && $_SESSION['USERID']!='')$this->_modelAcmOa->save($arr);
			}
		}
		$smarty = & $this->_getView();
		$smarty->assign('title','查看通知');
		$smarty->assign("row", $row[0]);
		$smarty->display('OaViewDetails.tpl');
	}
	//处理弹出窗口后下次不在弹出消息的问题
	function actionTzViewDetailsByAjax(){
		if($_SESSION['USERID']=='')exit;
		$userId=$_SESSION['USERID'];
		$sql="SELECT x.* FROM `oa_message` x 
		left join oa_message_class y on y.className=x.kindName
		where y.isWindow=0
		and not exists(select * from acm_user2message z where z.messageId=x.id and z.userId='{$userId}')";
		$rr=$this->_modelExample->findBySql($sql);
		foreach($rr as & $v){
			// if($v['kindName']=='行政通知') {
					$arr[]=array(
						'userId'=>$_SESSION['USERID'],
						'messageId'=>$v['id'],
						'kind'=>1,
					);
			// }
		}
		if($arr)$this->_modelAcmOa->saveRowset($arr);
		echo json_encode(array('success'=>true));exit;
	}

	function changToHtml($val) {//将特殊字元转成 HTML 格式
		$val=htmlspecialchars($val);
		$val= str_replace("\011", ' &nbsp;&nbsp;&nbsp;', str_replace('  ', ' &nbsp;', $val));
		$val= ereg_replace("((\015\012)|(\015)|(\012))", '<br />', $val);
		return $val;
	}
	function cSubstr($str,$start,$len) {//截取中文字符串
		$temp = "<span title='".$str."'>".mb_substr($str,$start,$len,'utf-8')."</span>";
		return $temp;
	}

	//
	function actionGetTongzhiByAjax() {
		$userId=$_SESSION['USERID'];
		$sql="SELECT x.*,count(*) as cnt FROM `oa_message`  x
		left join oa_message_class y on y.className=x.kindName
		where y.isWindow=0
		and not exists(select * from acm_user2message z where z.messageId=x.id and z.userId='{$userId}')";
		$rr=$this->_modelExample->findBySql($sql);
		//dump($rr);exit;
		//if($rr[0]['cnt']>0){
		echo json_encode($rr[0]);
		exit;
	//}

	}

	//
	function actionGetMailByAjax() {
		$userId=$_SESSION['USERID'];
		$sql="SELECT count(*) as cnt FROM mail_db where accepterId='{$userId}' and timeRead='0000-00-00 00:00:00'";
		//dump($sql);exit;
		$rr=$this->_modelExample->findBySql($sql);
		echo json_encode($rr[0]);
		exit;
	}

	function GetJingyan(){
		//判断企业为★用户
		//dump($_SESSION);exit;
		//判断企业为★用户
		$jinyan=0;$msg="";
		$dj=0;
		$str="SELECT * FROM jifen_comp where 1";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re){
			$jinyan=$re['initJingyan']+$re['jingyan'];
		}


		if($jinyan<501){
			$msg='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
		}
		if($jinyan>500 && $jinyan<8001){
			$msg='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">'.'<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
		}
		if($jinyan>8000 && $jinyan<40001){
			$msg='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">'.'<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
			$msg.='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
		}
		if($jinyan>40000 && $jinyan<4000001){
			$msg='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">'.'<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
			$msg.='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">'.'<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
		}
		if($jinyan>4000000){
			$msg='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">'.'<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
			$msg.='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">'.'<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
			$msg.='<img src="Resource/Image/star_level1.gif" width="16" height="16" style="vertical-align:middle">';
		}
		//判断用户的级别
		$userJy=0;$userMsg="";
		$sql="SELECT * FROM jifen_user where 1 and remoteUserId = '{$_SESSION['USERID']}'";
		$rr=mysql_fetch_assoc(mysql_query($sql));
		if($rr){
			$userJy=$rr['remoteJingyan'];
		}
		if($userJy<501){
			$userMsg='<img src="Resource/Image/user-1.gif" width="16" height="16" title="普通用户" style="vertical-align:middle">';
			$dj=floor($userJy/50);
		}
		if($userJy>500 && $userJy<5501){
			$userMsg='<img src="Resource/Image/user-2.gif" width="16" height="16" title="白银用户" style="vertical-align:middle">';
			$dj=floor(($userJy-500)/500)+10;
		}
		if($userJy>5500 && $userJy<15501){
			$userMsg='<img src="Resource/Image/user-3.gif" width="16" height="16" title="黄金用户" style="vertical-align:middle">';
			$dj=floor(($userJy-5500)/1000)+20;
		}
		if($userJy>15500 && $userJy<35501){
			$userMsg='<img src="Resource/Image/user-4.gif" width="16" height="16" title="蓝钻用户" style="vertical-align:middle">';
			$dj=floor(($userJy-15500)/2000)+30;
		}
		if($userJy>35500){
			$userMsg="金钻";
		}


		$msg = '<a href="Help/jifenHelp.html?width=800&height=420&TB_iframe=1" class="thickbox" title="经验值计算规则及排名">'.$msg.'</a>';
		$dj = '<a href="Help/jifenHelp.html?width=800&height=420&TB_iframe=1" class="thickbox" title="经验值计算规则及排名">'.$dj.'</a>';
		//$userJy = '<a href="Help/jifenHelp.html" target="_blank" title="获取积分帮助">'.$userJy.'</a>';
		$userMsg = '<a href="Help/jifenHelp.html?width=800&height=420&TB_iframe=1" class="thickbox" title="经验值计算规则及排名">'.$userMsg.'</a>';
		//dump();exit;
		return array(
		    'msg'=>$msg,
		    'dj'=>$dj,
		    'compJy'=>$jinyan,
		    'jingyan'=>$userJy,
		    'userMsg'=>$userMsg
		);
	}
	function actionTest1() {
		//unset($_SESSION['SEARCH']);
		foreach($_SESSION['SEARCH'] as $key=>& $v) {
				//unset($_SESSION['SEARCH'][$key]['toDel']);

			}
		dump($_SESSION);exit;
	}
	function actionTest() {
		$title = '色纱回收列表';
		///////////////////////////////模板文件
		$tpl = 'TblList.tpl';
		///////////////////////////////模块定义
		FLEA::loadClass('TMIS_Pager');

		$arr = TMIS_Pager::getParamArray(array(
			'days'=>'',
			'years'=>''
			//'orderCode'=>'',
			//'orderId'=>'',
			//'zhishu'=>'',
			//'colorSha'=>'',
			//'ranchangId'=>''
			//'huaxing'=>''
		));
		if($arr['orderCode']!='') {
			$condition[]=array('Order.orderCode',"%{$arr['orderCode']}%",'like');
		}
		if($arr['orderId']!='') {
			$condition[]=array('orderId',$arr['orderId'],'=');
		}
		if($arr['zhishu']!='') $condition[]=array('zhishu',"%{$arr['zhishu']}%",'like');
		if($arr['colorSha']!='') $condition[]=array('colorSha',"%{$arr['colorSha']}%",'like');
		if($arr['ranchangId']!='') $condition[]=array('ranchangId',$arr['ranchangId']);
		//dump($condition);
		$m = & FLEA::getSingleton('Model_Shengchan_Sesha_Income');
		$pager =& new TMIS_Pager($m,$condition,'id desc');
		$rowset =$pager->findAll();
		//dump($rowset);exit;
		if(count($rowset)>0) {
			foreach ($rowset as & $v) {

				$v['_edit'] = "<a href='".$this->_url('HuishouShow',array(
					'orderId'=>$v['orderId'],
					'ranchangId'=>$v['ranchangId'],
					'no_edit'=>1,
					'keepThis'=>'true',
					'width'=>700,
					'baseWindow'=>'parent',
					'TB_iframe'=>1
					))."' class='thickbox' ext:qtip='<table border=1><tr><td>aaa</td><td>bbbb</td></tr><tr><td>aaa</td><td>bbbb</td></tr></table>'>实收统计</a>";
				$v['_edit'] .= '&nbsp;'.$this->getEditHtml(array('hsCode'=>$v['hsCode'],
					'fromAction'=>$_GET['action']));
				//$v['_edit'] = "<a href='".$this->_url('CommonEdit',array('id'=>$v['id'],'TB_iframe'=>1))."' title='修改' class='thickbox'>修改</a>";
				$v['_edit'] .='&nbsp;'.$this->getRemoveHtml($v['id']);
				$v['Order']['orderCode']=$this->getOrderTrace(($v['Order']['orderCode']), $v['orderId']);
			}
		}
		if($_GET['no_edit']==1) {
			$rowset[] = $this->getHeji($rowset, array('cntKg','jingzhong'),'incomeDate');
		}
		else {
			$rowset[] = $this->getHeji($rowset, array('cntKg','jingzhong'),'_edit');
		}

		foreach($rowset as & $v) {
			$v['cntKg'] = "<strong>{$v['cntKg']}</strong>";
			$v['jingzhong'] = "<strong>{$v['jingzhong']}</strong>";
		}
		//dump($rowset);exit;
		$caiwu = & FLEA::getAppInf('hasCaiwu');
		$arr_field_info=array(
			'_edit'=>'操作',
			"incomeDate" =>array('text'=>'收纱日期','width'=>100),
			"initCode" =>"染单号阿斯顿发的散发水电费",
			"hsCode" =>"回收单号",
			"Ranchang.compName" =>"染厂",
			"Order.orderCode" =>"流转单号",
			"zhishu" =>"支数",
			"colorSha" =>"颜色",
			"cntKg" =>"投料数(kg)",
			"jingzhong" =>"净重(kg)",
			//"cntJian" =>"件数",
			//"vatNum" =>"缸号",
		);


		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('add_display','none');
		$smarty->assign('arr_field_info',$arr_field_info);

		//$smarty->assign('left_width','600');
		$smarty->assign('arr_field_value',$rowset);
		//dump($rowset);exit;
		if($_GET['no_edit']!=1) {
			$smarty->assign('arr_condition', $arr);
			$smarty->assign('add_url', $this->_url('ListOrderForAdd'));
			$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr))."<font color='red'>测试文字</font>");
			$smarty->assign('print_href', 'adfads');
			$smarty->assign('fn_export', true);
		}
		//$smarty->display($tpl);
        $smarty->display('TblList.tpl');
	}

	//根据id取得通知内容，返回为json
	function actionGetContentByAjax() {
		$row=$this->_modelExample->findAll(array('id'=>$_GET['id']));
		if($_SESSION['USERID']!='') {
			if($row[0]['kindName']=='行政通知') {
				$sql="SELECT count(*) as cnt FROM `acm_user2message` where messageId='{$_GET['id']}' and userId='{$_SESSION['USERID']}'";
				$rr=mysql_fetch_assoc(mysql_query($sql));
				if($rr['cnt']==0) {
					$arr=array(
						'userId'=>$_SESSION['USERID'],
						'messageId'=>$_GET['id'],
					);
					if($arr && $arr['userId']!='')
						$this->_modelAcmOa->save($arr);
				//$dbo=&FLEA::getDBO(false);dump($dbo->log);exit;
				}
			}
		}
		$row=$this->_modelExample->find(array('id'=>$_GET['id']));
		echo json_encode($row);exit;
	}

}
?>