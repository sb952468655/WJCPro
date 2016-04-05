<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jifen_Comp extends Tmis_Controller {
    var $_modelExample;
    var $_modUplogExp;
    var $_modUpUserLogExp;
    var $_modUser;
    var $title = "企业身份管理";
    var $_tplEdit='Jifen/SeshaEdit.tpl';
    function Controller_Jifen_Comp() {
	$this->_modelExample = & FLEA::getSingleton('Model_Jifen_Comp');
	$this->_modUser = & FLEA::getSingleton('Model_Jifen_User');
	$this->_modUplogExp = & FLEA::getSingleton('Model_Jifen_UpLogByComp');
	$this->_modUpUserLogExp = & FLEA::getSingleton('Model_Jifen_UpLogByuser');
	$this->_modUpError = & FLEA::getSingleton('Model_Jifen_UpError');
    }

    function actionSave() {
    //dump($_GET);exit;
	if($_GET['success']==0) {
	    js_alert('公司编号或公司全称不完全匹配，请联系管理员',null,$this->_url($_GET['fromAction']));
	}else {
	    $str="SELECT * FROM jifen_comp where 1";
	    $re=mysql_fetch_assoc(mysql_query($str));
	    if(!$re) {
		$_GET['remoteJingyan']=$_GET['initJingyan']+0;
		$_GET['jingyan']=$_GET['initJingyan']+0;
	    }else {
		$_GET['remoteJingyan']=$re['remoteJingyan']-$re['initJingyan']+$_GET['initJingyan'];
		$_GET['jingyan']=$re['jingyan']-$re['initJingyan']+$_GET['initJingyan'];
	    }
	    $id = $this->_modelExample->save($_GET);
	    js_alert('保存成功',null,$this->_url('InitComp'));
	}
    }

    function actionInitComp() {
	$sql="SELECT * FROM `jifen_comp` where 1";
	$rows=mysql_fetch_assoc(mysql_query($sql));
	$sys=$this->getSysSet();
	$url= $sys['localNetPath'];
	$tpl = 'Jifen/InitCompEdit.tpl';

	//网络设置
	$rowItem=array();
	$sql="select * from sys_set where 1 order by id";
	$rowset = $this->_modelExample->findBySql($sql);
	if(count($rowset)>0) {
	    foreach($rowset as $v) {
		$rowItem[$v['item']]= $v['value'];
	    }
	}

	$smarty = & $this->_getView();
	$smarty->assign('sys',$sys['NetPath']);
	$smarty->assign('url',$url);
	$smarty->assign('aRow',$rows);
	$smarty->assign('rowset',$rowset);
	$smarty->assign('row',$rowItem);
	$smarty->display($tpl);
    }

    //积分上传
    function actionUpJifen() {
	$_GET['fromAction']="UpJifenComp";
	$title="企业积分上传";
	$sys=$this->getSysSet();
	$str="SELECT * FROM `jifen_comp` where 1";
	$rows=mysql_fetch_assoc(mysql_query($str));
	$url = $sys['localNetPath'];//本地地址
	$tpl = 'Jifen/UpJifenEdit.tpl';
	$smarty = & $this->_getView();
	$smarty->assign('aRow',$rows);
	$smarty->assign('sys',$sys['NetPath']);
	$smarty->assign('url',$url);
	$smarty->assign('title',$title);
	$smarty->display($tpl);
    }

    //
    function actionUpJifenComp($ret) {
    //dump($ret);exit;
	if($ret['success']==1) {
	    $str="SELECT * FROM jifen_comp where compCode='{$ret['compCode']}'";
	    $re=mysql_fetch_assoc(mysql_query($str));

	    //新增一条上传日志
	    $sql1="INSERT INTO jifen_up_log (jifen,shishiPeo,upLogDate) VALUES ('{$ret['jifen_comp']}','{$ret['shishiPeo']}','{$ret['upDate']}')";
	    $id=$this->_modelExample->execute($sql1);
	    if(!$id) {
		return "地址：本地；原因：企业经验值上传日志添加出错；";
	    }else {
		return true;
	    }

	}else {
	//return "公司积分上传失败";
	}
    }

    function _post($url, $post = null) {
	$context = array();
	if (is_array($post)) {
	    ksort($post);
	    $context['http'] = array(
		'timeout'=>25,
		'method' => 'POST',
		'content' => http_build_query($post, '', '&'),
	    );
	}
	return file_get_contents($url, false, stream_context_create($context));
    }
    //用于输出encode字符串给主界面的积分信息
    function GetEncode($encode='',$success=true) {
	echo json_encode(array('success'=>$success,'msg'=>$encode));exit;
    }

    function GetJifen() {
    //查询积分信息
	$mm=& FLEA::getSingleton('Controller_Main');
	$jingyanStr=$mm->GetJingyan();
	$jinyan=$jingyanStr['jingyan'];
	$compJy=$jingyanStr['compJy'];
	$msg=$jingyanStr['msg'];
	$dj=$jingyanStr['dj'];
	$userMsg=$jingyanStr['userMsg'];
	$str_xiaoxia = "<img src='Resource/Image/huiyi_icon.gif'>&nbsp;{$_SESSION['REALNAME']}&nbsp;&nbsp;&nbsp;&nbsp;";
	$str_xiaoxia .="经验:{$jinyan}({$userMsg})&nbsp;&nbsp;&nbsp;&nbsp;企业经验：{$compJy}&nbsp;({$msg})&nbsp;";
	echo json_encode(array('success'=>true,'msg'=>$str_xiaoxia));exit;
    }

    //员工积分上传
    function actionUpJifenByUser() {
    //检查是否第一次登陆，否上传积分
	$eqLogin =& FLEA::getSingleton('Model_Login');
	//更新用户的最后登录时间和登陆日期的登录次数
	$re=$eqLogin->changeLoginTime($_SESSION['USERID']);
	$r1=$eqLogin->changeUser(array('userId'=>$_SESSION['USERID'],'userName'=>$_SESSION['USERNAME']));
	if(!$r1) {
	    $this->GetJifen();
	}
	$sys=$this->getSysSet();
	//本地上传地址
	$url= $sys['localNetPath'];
	//检查是否配置地址，没有配置则记录错误
	if($url=='' || $sys['NetPath']=='') {
	    $message="积分网路没有配置，请联系管理员";
	    $this->GetEncode($message,true);
	}
	//用户积分信息
	$str="SELECT userCode,realName,id,shenfenzheng,jifen,jingyan,remoteJifen,remoteJingyan,passwd FROM `jifen_user` where 1 AND userCode!='admin' and userCode='{$_SESSION['USERNAME']}'";
	$rows=$this->_modelExample->findBySql($str);

	//公司积分信息
	$str="SELECT remoteJingyan,jingyan,compCode FROM `jifen_comp` where 1";
	$row_com=mysql_fetch_assoc(mysql_query($str));
	$data = array(
	    'localUrl'=>str_replace(PHP_EOL, '',$sys['localNetPath']),
	    'shishiPeo'=>$_SESSION[''],
	    'LANG'=>$_SESSION['LANG'],
	    'SN'=>$_SESSION['SN'],
	    'USERID'=>$_SESSION['USERID'],
	    'REALNAME'=>$_SESSION['REALNAME'],
	    'USERNAME'=>$_SESSION['USERNAME'],
	    'upDate'=>date('Y-m-d'),
	    //公司信息
	    'compCode'=>$row_com['compCode'],
	    'jy'=>$row_com['jingyan'],
	    'jifen_comp'=>$row_com['remoteJingyan'],
	    //用户信息
	    'userCode'=>array_col_values($rows,'userCode'),
	    'realName'=>array_col_values($rows,'realName'),
	    'id'=>array_col_values($rows,'id'),
	    'shenfenzheng'=>array_col_values($rows,'shenfenzheng'),
	    'jifen'=>array_col_values($rows,'remoteJifen'),
	    'jingyan'=>array_col_values($rows,'remoteJingyan'),
	    'passwd'=>array_col_values($rows,'passwd')
	);
	
	$remoteUrl=str_replace(PHP_EOL, '',$sys['NetPath'].'?controller=Jifen_User&action=UpJifen');
	//上传本地的积分，并取得远程的排名，公司和用户的经验积分等数据	
	$json= $this->_post($remoteUrl, $data);
	//dump($json);exit;
	if($json==false) {
	    $error='错误：连接超时；原因：网路配置可能有误';
	    $errSql="INSERT INTO jifen_up_error (`userName`,`error`) VALUES ('{$_SESSION['REALNAME']}','{$error}')";
	    mysql_query($errSql);
	    $this->GetEncode('网络连接超时',true);

	}
	
	$json=substr($json,strpos($json,'{'));
	$ret = json_decode($json,true);//服务器上返回的排名经验，用户等信息
	
	//修改本地服务器上的排名，经验，积分等信息
	$this->actionUpUserJifen($ret);
	//返回一个json字串，用来改变main.tpl右下角的积分信息
	$this->GetJifen();
 
    }
    /**
  * 测试远程服务器连接是否正常
  *
 */
 function actionTestPost() {
 	$sys=$this->getSysSet();
 	$remoteUrl=str_replace(PHP_EOL, '',$sys['NetPath'].'?controller=Jifen_User&action=UpJifen');
 	$str="SELECT remoteJingyan,jingyan,compCode FROM `jifen_comp` where 1";
	$row_com=mysql_fetch_assoc(mysql_query($str));

	//用户积分信息
	$str="SELECT userCode,realName,id,shenfenzheng,jifen,jingyan,remoteJifen,remoteJingyan,passwd 
	FROM `jifen_user` 
	where 1 limit 0,1";
	$rows=$this->_modelExample->findBySql($str);

 	$data = array(
	    'localUrl'=>str_replace(PHP_EOL, '',$sys['localNetPath']),
	    //'shishiPeo'=>$_SESSION[''],
	    'LANG'=>$_SESSION['LANG'],
	    'SN'=>$_SESSION['SN'],
	    'USERID'=>$_SESSION['USERID'],
	    'REALNAME'=>$_SESSION['REALNAME'],
	    'USERNAME'=>$_SESSION['USERNAME'],
	    'upDate'=>date('Y-m-d'),
	    //公司信息
	    'compCode'=>$row_com['compCode'],
	    'jy'=>$row_com['jingyan'],
	    'jifen_comp'=>$row_com['remoteJingyan'],
	    //用户信息
	    'userCode'=>array_col_values($rows,'userCode'),
	    'realName'=>array_col_values($rows,'realName'),
	    'id'=>array_col_values($rows,'id'),
	    'shenfenzheng'=>array_col_values($rows,'shenfenzheng'),
	    'jifen'=>array_col_values($rows,'remoteJifen'),
	    'jingyan'=>array_col_values($rows,'remoteJingyan'),
	    'passwd'=>array_col_values($rows,'passwd')
	);

	dump("地址:".$remoteUrl);
	echo "上传参数为:";
	dump($data);

	$json= $this->_post($remoteUrl, $data);
	echo "返回结果为:";
	dump($json);
 }

    //清空本地用户的积分和经验，并将取回的数据保存在本地数据库中
    function actionUpUserJifen($ret) {
	//dump($ret);exit;
	$error=$ret['error'];
	//处理公司积分上传问题
	if($ret) {
	    $rr=$this->actionUpJifenComp($ret['compInfo']);
	    if(!$rr)$error.=$rr;
	    //如果session丢失
	    if(!$_SESSION['REALNAME']) {
		$_SESSION['SN'] = $ret['session_val']['SN'];
		$_SESSION['LANG'] = $ret['session_val']['LANG'];
		$_SESSION['USERID'] = $ret['session_val']['USERID'];
		$_SESSION['REALNAME'] = $ret['session_val']['REALNAME'];
		$_SESSION['USERNAME'] = $ret['session_val']['USERNAME'];
	    }
	}
	if($ret['success']==1) {
	//dump($ret['userInfo']);exit;
	    for($i=0;$i<count($ret['userInfo']);$i++) {
		//得到每个用户的情况,得到当前积分

		$logArr[]=array(
		    'userId'=>$ret['userInfo'][$i]['id'],
		    'jifen'=>$ret['userInfo'][$i]['jifen'],
		    'shishiPeo'=>$ret['compInfo']['shishiPeo'],
		    'upLogDate'=>date('Y-m-d')
		);

	    }

	    $mUser=& FLEA::getSingleton('Model_Jifen_User');
	    $mUserByLog= & FLEA::getSingleton('Model_Jifen_UpLogByuser');

	    if($rows) {
		__TRY();
		$flag=$mUser->saveRowset($rows);
		$mUserByLog->saveRowset($logArr);
		$ex = __CATCH();
		if (__IS_EXCEPTION($ex)) {
		//$error.="地址：本地；原因：用户积分更新失败；";
		}
		if(!$flag) {
		    $error.="地址：本地；原因：用户积分更新失败；";
		}
	    }else {
		$error.="";
	    }
	}else {
	    $error.="";
	}
	//积分更新成功后 保存下载的积分排行信息
	$arr=array(
	    'userRank'=>$ret['userRank'],
	    'compRank'=>$ret['compRank'],
	);
	$this->actionSaveDownJifen($arr);
	if($error!='') {
	    $errSql="INSERT INTO jifen_up_error (`userName`,`error`) VALUES ('{$_SESSION['REALNAME']}','{$error}')";
	    mysql_query($errSql);
	}
    //redirect(url('Main'));
    }

    //企业上传日志
    function actionCompLogForList() {
	$title = '企业上传日志列表';
	$tpl = 'TblList.tpl';
	$this->authCheck();
	FLEA::loadClass('TMIS_Pager');
	$arr = TMIS_Pager::getParamArray(array(
	    'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')-1)),
	    'dateTo'=>date('Y-m-d')
	));
	if($arr['dateFrom']!='') $condition[]=array('upLogDate',$arr['dateFrom'],'>=');
	if($arr['dateTo']!='') $condition[]=array('upLogDate',$arr['dateTo'],'<=');
	$pager =& new TMIS_Pager($this->_modUplogExp,$condition,'id desc');
	$rowset =$pager->findAll();
	$rowset[]=$this->getHeji($rowset, array('jifen'), 'upLogDate');
	$smarty = & $this->_getView();
	$smarty->assign('title', $title);
	$smarty->assign('arr_field_info',array(
	    'upLogDate'=>'上传日期',
	    "jifen" =>"上传积分",
	    "shishiPeo" =>"上传者"
	));

	$smarty->assign('arr_field_value',$rowset);
	$smarty->assign('arr_condition', $arr);
	$smarty->assign('add_display', 'none');
	$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
	$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
	$smarty->display($tpl);
    }

    //用户上传日志
    function actionUserLogForList() {
	$title = '用户上传日志列表';
	$tpl = 'TblList.tpl';
	$this->authCheck();
	FLEA::loadClass('TMIS_Pager');
	$arr = TMIS_Pager::getParamArray(array(
	    'dateFrom'=>date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')-1)),
	    'dateTo'=>date('Y-m-d'),
	    'jifenUserId'=>''
	));
	if($arr['dateFrom']!='') $condition[]=array('upLogDate',$arr['dateFrom'],'>=');
	if($arr['dateTo']!='') $condition[]=array('upLogDate',$arr['dateTo'],'<=');
	if($arr['jifenUserId']!='') $condition[]=array('userId',$arr['jifenUserId'],'=');
	$pager =& new TMIS_Pager($this->_modUpUserLogExp,$condition,'id desc');
	$rowset =$pager->findAll();
	$rowset[]=$this->getHeji($rowset, array('jifen'), 'User.realName');
	$smarty = & $this->_getView();
	$smarty->assign('title', $title);
	$smarty->assign('arr_field_info',array(
	    "User.realName" =>"用户名",
	    "User.shenfenzheng" =>"身份证号",
	    "jifen" =>"上传积分",
	    'upLogDate'=>'上传日期',
	    //"shishiPeo" =>"上传者"
	));

	$smarty->assign('arr_field_value',$rowset);
	$smarty->assign('arr_condition', $arr);
	$smarty->assign('add_display', 'none');
	$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
	$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
	$smarty->display($tpl);
    }

    //下载企业积分排名
    function actionDownJifen() {
	$title = "下载企业积分排名";
	//企业排行榜
	$str="SELECT * FROM jifen_comp_rank where 1 ORDER BY jinyan DESC";
	$rows=$this->_modelExample->findBySql($str);
	$sys=$this->getSysSet();
	$url= $sys['localNetPath'];
	$tpl="Jifen/DownJifen.tpl";
	$cnt=count($rows);

	$smarty = & $this->_getView();
	$smarty->assign('title', $title);
	if($cnt>0)
	    $smarty->assign('aRow',$rows);
	$smarty->assign('cnt',$cnt);
	$smarty->assign('sys',$sys['NetPath']);
	$smarty->assign('url',$url);
	$smarty->display($tpl);
    }
    //保存积分信息
    function actionSaveDownJifen($arr) {
    //dump($arr);exit;
	$comp = & FLEA::getSingleton('Model_Jifen_CompRank');
	for ($i=0;$i<count($arr['compRank']);$i++) {
	    $mComp=$comp->find(array('compId'=>$arr['compRank'][$i]['id']));
	    //dump($mComp);exit;
	    $id=$mComp?$mComp['id']:'';
	    $rowset[]=array(
		'id'=>$id,
		'compId'=>$arr['compRank'][$i]['id'],
		'compCode'=>$arr['compRank'][$i]['compCode'],
		'compName'=>$arr['compRank'][$i]['compName'],
		'compFullName'=>$arr['compRank'][$i]['compFullName'],
		'jinyan'=>$arr['compRank'][$i]['jingyan'],
		'creater'=>$_SESSION['REALNAME']==''?"实施人员":$_SESSION['REALNAME'],
	    );
	}
	//dump($rowset);exit;
	if($rowset) {
	    __TRY();
	    $id=$comp->saveRowset($rowset);
	    $ex = __CATCH();
	    if (__IS_EXCEPTION($ex)) {
		$error.="地址：本地；原因：公司排行信息保存出错；";
	    }else {
		if(!$id) $error.="地址：本地；原因：公司排行信息保存失败；";
	    }
	}
	//保存用户的下载情况
	$user = & FLEA::getSingleton('Model_Jifen_UserRank');
	for ($i=0;$i<count($arr['userRank']);$i++) {
	    $mUser=$user->find(array('compId'=>$arr['userRank'][$i]['compId'],'userCode'=>$arr['userRank'][$i]['userCode']));
	    //dump($arr['userRank']);exit;
	    $id=$mUser?$mUser['id']:'';
	    $Arr[]=array(
		'id'=>$id,
		'userCode'=>$arr['userRank'][$i]['userCode'],
		'userName'=>$arr['userRank'][$i]['realName'],
		'compId'=>$arr['userRank'][$i]['compId'],
		'compName'=>$arr['userRank'][$i]['compName'],
		'jinyan'=>$arr['userRank'][$i]['remoteJingyan']
	    );
	}
	//dump($Arr);exit;
	if($Arr) {
	    __TRY();
	    $id2=$user->saveRowset($Arr);
	    $ex = __CATCH();
	    if (__IS_EXCEPTION($ex)) {
		$error.="地址：本地；原因：用户排行信息保存出错；";
	    }else {
		if(!$id2) $error.="地址：本地；原因：用户排行信息保存失败；";
	    }
	}
    //redirect(url('Main'));
    //js_alert('下载成功!',null,$this->_url('downJifen'));
    }

    //通过ajax取得排名前十的公司信息
    function actionGetTopByAjax() {
    //公司前5的排名
	if($_GET['flag']==1) {
	    $str="SELECT * FROM jifen_comp_rank ORDER BY jinyan DESC LIMIT 0,5";
	    $row = $this->_modelExample->findBySql($str);
	    if($row) {
		echo json_encode(array(
		'success'=>true,
		'cnt'=>count($row),
		'rowset'=>$row
		));exit;
	    }else {
		echo json_encode(array('success'=>false,));
	    }
	}else if($_GET['flag']==2) {
	//用户排名前5
	    $str="SELECT * FROM jifen_user_rank ORDER BY jinyan DESC LIMIT 0,5";
	    $row1 = $this->_modelExample->findBySql($str);
	    if($row1) {
		echo json_encode(array(
		'success'=>true,
		'cnt'=>count($row1),
		'rows'=>$row1
		));exit;
	    }else {
		echo json_encode(array('success'=>false,));
	    }
	}else if($_GET['flag']==3){
	    $str="SELECT * FROM jifen_user ORDER BY jingyan DESC LIMIT 0,3";
	    $row = $this->_modelExample->findBySql($str);
	    if($row) {
		echo json_encode(array(
		'success'=>true,
		'cnt'=>count($row),
		'rowset'=>$row
		));exit;
	    }else {
		echo json_encode(array('success'=>false,));
	    }
	}
	exit;
    }

    function actionErrorLogForList() {
	$title = '上传错误日志列表';
	$tpl = 'TblList.tpl';
	$this->authCheck();
	FLEA::loadClass('TMIS_Pager');
	$arr = TMIS_Pager::getParamArray(array(
	    'dateFrom'=>date('Y-m-01'),
	    'dateTo'=>date('Y-m-d'),
	));
	$dd=explode('-',$arr['dateTo']);
	//dump($dd);exit;
	if($arr['dateFrom']!='') $condition[]=array('dt',$arr['dateFrom'],'>=');
	if($arr['dateTo']!='') $condition[]=array('dt',date('Y-m-d',mktime(0,0,0,$dd[1],$dd[2]+1,$dd[0])),'<=');
	$pager =& new TMIS_Pager($this->_modUpError,$condition,'id desc');
	$rowset =$pager->findAll();
	$smarty = & $this->_getView();
	$smarty->assign('title', $title);
	$smarty->assign('arr_field_info',array(
	    "userName" =>"用户名",
	    "error" =>"错误描述",
	    'dt'=>'上传日期',
	));

	$smarty->assign('arr_field_value',$rowset);
	$smarty->assign('arr_condition', $arr);
	$smarty->assign('add_display', 'none');
	$smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar','thickbox')));
	$smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
	$smarty->display($tpl);
    }

    //将网站积分同步到本地系统中
    function actionTongbu() {
	$title = "网站积分同步";
	//企业排行榜
	//$str="SELECT * FROM jifen_user where 1  AND userCode!='admin' ORDER BY remoteJifen DESC";
	//$rows=$this->_modelExample->findBySql($str);
	$sys=$this->getSysSet();
	if(!$sys['NetPath']) js_alert('您需要先设置上传路径，才可进行同步!');
	$url= $sys['localNetPath'];
	//dump($url);exit;
	$rowset=array();
	//先取得本地公司信息
	$str1="SELECT * FROM jifen_comp WHERE 1";
	$re=mysql_fetch_assoc(mysql_query($str1));


	$tpl="Jifen/Tongbu.tpl";
	$smarty = & $this->_getView();
	$smarty->assign('title', $title);
	//$smarty->assign('aRow',$rows);
	$smarty->assign('compCode',$re['compCode']);
	$smarty->assign('sys',$sys['NetPath']);
	$smarty->assign('url',$url);
	$smarty->display($tpl);
    }

    //保存同步信息
    function actionSaveTongbu() {
	//dump($_POST);exit;
	if($_POST) {
	    for($i=0;$i<count($_POST['userCode']);$i++) {
		$str="SELECT * FROM jifen_user where userCode='{$_POST['userCode'][$i]}' AND realName='{$_POST['realName'][$i]}'";
		$re=mysql_fetch_assoc(mysql_query($str));
		if($re)
		$rows[]=array(
		    'id'=>$re['id'],
		    'jifen'=>$_POST['jifen'][$i],
		    'remoteJifen'=>$_POST['remoteJifen'][$i],
		    'jingyan'=>$_POST['jingyan'][$i],
		    'remoteJingyan'=>$_POST['remoteJingyan'][$i]
		);
	    }
	    //dump($rows);exit;
	    if($rows) $this->_modUser->saveRowset($rows);
	    $str="UPDATE jifen_comp SET remoteJingyan='{$_POST['jingyan1']}',jingyan='{$_POST['jingyan1']}' WHERE compCode='{$_POST['compCode']}'";
	    $this->_modelExample->execute($str);
	    js_alert('同步成功!',null,$this->_url('Tongbu'));
	}
    }

    function actionResetLogin() {
	$sql= "update acm_userdb set loginCnt=0";
	mysql_query($sql) or die(mysql_error());
	js_alert("重置成功",'window.history.go(-1)');
    }
}
?>