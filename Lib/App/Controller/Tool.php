<?php
/*
 * 实施人员用的后台配置程序，
 * 可进行动态密码卡的设置，
 * 可进行功能权限的定义。
 * 可查看db_change
 */
FLEA::loadClass('TMIS_Controller');
class Controller_Tool extends Tmis_Controller {
    var $m;
    function Controller_Tool() {
	$this->m= & FLEA::getSingleton('Model_Jichu_Client');
    //echo 1;exit;
    }
    function actionIndex() {
		if($_SESSION['SN']==1||$_GET['_debug']==1){
			$smarty = & $this->_getView();
			$smarty->display('Tool/Index.tpl');
		}else{
			js_alert('没有通过动态密码卡验证，禁止操作',null,url('Login','Index'));
		}
	}

    //利用ajax获得工具栏的操作目录
    function actionGetToolMenu() {
		$menu = array(
			// array('text'=>'开关管理','leaf'=>true,'src'=>'?controller=Tool&action=Kaiguan'),
			array('text'=>'动态密码卡管理','expanded'=> false,'leaf'=>true,'src'=>'?controller=Tool&action=dongtai'),
			array('text'=>'设置弹窗信息','expanded'=> false,'leaf'=>true,'src'=>'?controller=Tool&action=setTanchuang'),
			// array('text'=>'数据补丁，首字母','expanded'=> false,'leaf'=>true,'src'=>'?controller=Tool&action=building'),
			// array('text'=>'织布验收损耗补丁','expanded'=> false,'leaf'=>true,'src'=>'?controller=Shengchan_Zhizao_Scrk&action=BuildingYanshou'),
			array('text'=>'采购计划多选投料计划补丁','expanded'=> false,'leaf'=>true,'src'=>'?controller=Shengchan_Cangku_Plan&action=Building'),
			
		);
		echo json_encode($menu);
    }

    /**
    	* @author li
    	* @return null
    	*/
    function actionBuilding(){
    	FLEA::loadClass('TMIS_Common');
    	$m = FLEA::getSingleton('Model_Jichu_Client');
    	///客户的首字母自动填充
    	$sql="select id,compName from yixiang_client where 1";
    	$res=$m->findBySql($sql);
    	foreach($res as & $v){
    		$letters=strtoupper(TMIS_Common::getPinyin($v['compName']));
    		$sql="update yixiang_client set letters='{$letters}' where id='{$v['id']}'";
    		$m->execute($sql);
    	}

    	///员工档案的首字母
    	$sql="select id,compName from jichu_jiagonghu where 1";
    	$res=$m->findBySql($sql);
    	foreach($res as & $v){
    		$letters=strtoupper(TMIS_Common::getPinyin($v['compName']));
    		$sql="update jichu_jiagonghu set letters='{$letters}' where id='{$v['id']}'";
    		$m->execute($sql);
    	}
    	///加工户的首字母
    	$sql="select id,employName from jichu_employ where 1";
    	$res=$m->findBySql($sql);
    	foreach($res as & $v){
    		$letters=strtoupper(TMIS_Common::getPinyin($v['employName']));
    		$sql="update jichu_employ set letters='{$letters}' where id='{$v['id']}'";
    		$m->execute($sql);
    	}
    	echo '补丁完成';exit;
    }

    //开关设置
    function actionKaiguan() {
    	if(count($_POST)>0) {
    		$ret = array();
    		$m = FLEA::getSingleton('Model_Acm_SetParamters');
    		foreach($_POST as $k=>&$v) {
    			if($k=='Submit') continue;
    			//找到相关的记录，取得相对应的id
    			$sql = "select id from sys_set where item='{$k}'";
    			$_rows = $this->m->findBySql($sql);
    			$ret[] = array(
    				'id'=>$_rows[0]['id'],
    				'item'=>$k,
    				'value'=>$v
    			);
    		}
    		$m->saveRowset($ret);
    		js_alert(null,"window.parent.showMsg('保存成功')",$this->_url('kaiguan'));
    	}
    	FLEA::loadClass('TMIS_Common');
    	$row = TMIS_Common::getSysSet();
    	// dump($row);
    	$smarty = & $this->_getView();  
    	$smarty->assign('aRow',$row);  	
    	$smarty->display('Tool/Kaiguan.tpl');
    }

    //管理动态密码卡
    function actionDongtai() {
		$sql = "select * from acm_sninfo";
		$rowset = $this->m->findBySql($sql);
		$rowset[] = array();
		$smarty = & $this->_getView();
		$smarty->assign('rowset',$rowset);
		$smarty->display('Tool/Dongtai.tpl');
    }
    function actionSaveDongtai() {
		$m = & FLEA::getSingleton('Model_Acm_Sninfo');
		if($m->save($_POST)) {
			js_alert(null,'window.parent.showMsg("保存成功")',$this->_url('dongtai'));
		}
    }

	/*
    function actionMenu1() {
		include('Config/menu.php');
		//dump($_sysMenu);
		foreach($_sysMenu as & $v) {
		//dump($v);
		//$v['_edit'] = "<a href='".$this->_url('_edit',array('all' => $v))."'>打印</a>";
			$v['_edit'] = "<a href='".$this->_edit()."'>打印</a>";
		}
		//echo("<a href='".$this->_url('_edit')."'></a>打印");
		//$this->_edit($_sysMenu);
		$arr_field_info = array(
			'text' => "名称",
			'_edit' => "操作"
		);
		$smarty = & $this->_getView();
		$smarty -> assign('arr_field_info',$arr_field_info);
		$smarty -> assign('arr_field_value',$_sysMenu);
		$smarty -> display('TblList.tpl');
    }
    function _edit($arr) {
		dump($arr);//exit;
		$smarty=& $this->_getView();
		$smarty->assign('row',$_sysMenu);
		//		$smarty->assign('cnt1',$cnt1);
		//		$smarty->assign('cnt2',$cnt2);
		//		$smarty->assign('num',$kk);
		//		$smarty->assign('name',$name);
		//		$smarty->assign('arrPos',$arrPos);
		//		$smarty->assign('xiaoji',$xiaoji);
		//		header("Pragma: public");
		//		header("Expires: 0");
		//		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		//		header("Content-Type: application/force-download");
		//		header("Content-Type: application/download");
		//		header("Content-Disposition: attachment;filename=test.xls");
		//		header("Content-Transfer-Encoding: binary");
		//		$smarty=$smarty->display('Tool/MenuView.tpl');
    }
	*/

	//导出菜单目录
    function actionExport() {
		echo("<a href='".$this->_url('View')."'>导出</a>");
    }
    function actionView() {
		include('Config/menu.php');
		$smarty = & $this->_getView();
		$smarty -> assign('row',$_sysMenu);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=test.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty -> display('Tool/MenuView.tpl');
    }

	//设置弹窗内容，如果这里设置了，登录成功后，会弹出一个对话框，强制用户观看。
	function actionSetTanchuang() {
		//$this->authCheck('8');
		$sql = "select * from sys_pop";
		$row = mysql_fetch_assoc(mysql_query($sql));
		$tpl = 'Tool/PopEdit.tpl';
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$row);
		$smarty->display($tpl);
	}
	function actionSavePop() {
		$m = & FLEA::getSingleton('Model_Sys_Pop');
		$id = $m->save($_POST);
		js_alert('保存成功,提交的信息将会在用户登录的第一时间弹出显示，客户必须关闭弹窗才可继续操作！','',$this->_url('SetTanchuang'));
	}
	//利用ajax取得弹窗的内容
	function actionGetPopByAjax() {
		$d = date('Y-m-d');
		$sql = "select * from sys_pop where dateFrom<='{$d}' and dateTo>='{$d}'";
		//dump($sql);exit;
		$row = mysql_fetch_assoc(mysql_query($sql));
		if(!$row) {
			$arr = array(
				'success'=>false
			);
		} else {
			$arr = array(
				'success'=>true,
				'data'=>$row
			);
		}
		echo json_encode($arr);
	}

	/*****************数据清理***************************/
	function actionDataClean(){
		$tpl = 'Tool/DataCleanEdit.tpl';
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$row);
		$smarty->display($tpl);
	}
	function actionSaveClean(){
		if($_POST['btnSave']=='清除订单数据'){
			$this->cleanOrder();
		}
		else if($_POST['btnSave']=='清除工艺数据'){
			$this->cleanGongyi();
		}
		else if($_POST['btnSave']=='清除染纱计划'){
			$this->cleanRanshaPlan();
		}
		else if($_POST['btnSave']=='清除坯纱数据'){
			$this->cleanPiSha();
		}
		else if($_POST['btnSave']=='清除生产数据'){
			$this->cleanShengchan();
		}
		else if($_POST['btnSave']=='清除财务数据'){
			$this->cleanCaiwu();
		}
		else if($_POST['btnSave']=='清除基础资料'){
			$this->cleanJichu();
		}
		else if($_POST['btnSave']=='全部清空'){
			$this->cleanOrder();
			$this->cleanGongyi();
			$this->cleanRanshaPlan();
			$this->cleanPiSha();
			$this->cleanShengchan();
			$this->cleanCaiwu();
			$this->cleanJichu();
		}
		js_alert('操作成功','',$this->_url('DataClean'));
	}

	//清除订单数据
	function cleanOrder(){
		$str="TRUNCATE TABLE trade_order";
		$this->m->execute($str);
		$str="TRUNCATE TABLE trade_order2product";
		$this->m->execute($str);
	}
	//清除工艺数据
	function cleanGongyi(){
		$str="TRUNCATE TABLE gongyi_fenpei_sha";
		$this->m->execute($str);
		$str="TRUNCATE TABLE gongyi_ransha_actualcnt";
		$this->m->execute($str);
		$str="TRUNCATE TABLE gongyi_ransha_fenpei";
		$this->m->execute($str);
		$str="TRUNCATE TABLE gongyi_ransha_percnt";
		$this->m->execute($str);
		$str="TRUNCATE TABLE gongyi_ransha_xunhuan";
		$this->m->execute($str);
		$str="TRUNCATE TABLE gongyi_wenban";
		$this->m->execute($str);
	}
	//清除染纱计划
	function cleanRanshaPlan(){
		$str="TRUNCATE TABLE gongyi_ransha_plan";
		$this->m->execute($str);
		$str="TRUNCATE TABLE gongyi_ransha_plan_init";
		$this->m->execute($str);
		$str="TRUNCATE TABLE gongyi_ransha_plan_real";
		$this->m->execute($str);
	}
	//清除坯纱数据
	function cleanPiSha(){
		$str="TRUNCATE TABLE pisha_cgrk";
		$this->m->execute($str);
		$str="TRUNCATE TABLE pisha_cgrk2ranchang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE pisha_kucun";
		$this->m->execute($str);

		$str="TRUNCATE TABLE pisha_kucun_init";
		$this->m->execute($str);
		$str="TRUNCATE TABLE pisha_llck";
		$this->m->execute($str);
		$str="TRUNCATE TABLE pisha_plan_llck";
		$this->m->execute($str);
		//因为坯纱是自动过账，所以删除坯纱的同时将过账信息和坯纱应付给删除
		$str="TRUNCATE TABLE caiwu_pisha_guozhang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_pisha_yingfu";
		$this->m->execute($str);
	}
	//清除生产数据
	function cleanShengchan(){
		$str="TRUNCATE TABLE chengpin_chanliang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE chengpin_cpck";
		$this->m->execute($str);
		$str="TRUNCATE TABLE chengpin_cprk";
		$this->m->execute($str);
		$str="TRUNCATE TABLE chengpin_madan";
		$this->m->execute($str);
		$str="TRUNCATE TABLE chengpin_madan_son";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jifen_comp";
		$this->m->execute($str);

		$str="TRUNCATE TABLE jifen_comp_rank";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jifen_upbyuser_log";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jifen_up_error";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jifen_up_log";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jifen_user";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jifen_user_rank";
		$this->m->execute($str);
		$str="TRUNCATE TABLE juantong_chuku";
		$this->m->execute($str);
		$str="TRUNCATE TABLE juantong_ruku";
		$this->m->execute($str);
		$str="TRUNCATE TABLE chengpin_cprk";
		$this->m->execute($str);
		$str="TRUNCATE TABLE juantong_yihaopin";
		$this->m->execute($str);
		$str="TRUNCATE TABLE mail_db";
		$this->m->execute($str);
		$str="TRUNCATE TABLE oa_message";
		$this->m->execute($str);
		$str="TRUNCATE TABLE pibu_duiwai";
		$this->m->execute($str);
		$str="TRUNCATE TABLE pibu_income";
		$this->m->execute($str);
		$str="TRUNCATE TABLE ranchang_kaohe";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sample_caiyang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sample_db";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sesha_chuku";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sesha_income";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sesha_ruku";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sesha_songjiang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sesha_waigou";
		$this->m->execute($str);
		$str="TRUNCATE TABLE sesha_weisha";
		$this->m->execute($str);
		$str="TRUNCATE TABLE trade_chuanyang";
		$this->m->execute($str);

		$str="TRUNCATE TABLE trade_order_plan";
		$this->m->execute($str);
		$str="TRUNCATE TABLE trade_testdata";
		$this->m->execute($str);
		$str="TRUNCATE TABLE waijiagong_kaohe";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhengli_fwzl";
		$this->m->execute($str);

		$str="TRUNCATE TABLE zhengli_zlhs";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhizao_chanliang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhizao_chuanzong";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhizao_kaohe";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhizao_zhizhou";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhizhou";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhizhou_danjia";
		$this->m->execute($str);
		$str="TRUNCATE TABLE zhizhou_son";
		$this->m->execute($str);
	}
	//财务
	function cleanCaiwu(){
		$str="TRUNCATE TABLE trade_order_chengben";
		$this->m->execute($str);
		$str="TRUNCATE TABLE trade_order_chengben_son";
		$this->m->execute($str);

		$str="TRUNCATE TABLE caiwu_ar_fapiao";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_ar_fapiao2guozhang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_ar_guozhang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_ar_income";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_ar_income2fapiao";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_bank";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_chengben";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_chuandai";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_chuandai2fapiao";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_chuandai_fapiao";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_huoyun_yf";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_income";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_kebie";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_payment";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_pibu_guozhang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_pisha_fapiao";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_pisha_fapiao2guozhang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_pisha_fukuan";
		$this->m->execute($str);
		$str="TRUNCATE TABLE caiwu_xianjin";
		$this->m->execute($str);
	}
	//清楚基础资料
	function cleanJichu(){
		$str="TRUNCATE TABLE jichu_chengben_item";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_chuanzonggong";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_client";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_client_taitou";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_dangchegong";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_department";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_employ";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_feiyong";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_huoyun";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_jiagonghu";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_jiangchang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_ranchang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_sample";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_sesha";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_supplier";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_zhenglichang";
		$this->m->execute($str);
		$str="TRUNCATE TABLE jichu_zhiji";
		$this->m->execute($str);
		$str="TRUNCATE TABLE acm_func2role";
		$this->m->execute($str);
		$str="TRUNCATE TABLE acm_funcdb";
		$this->m->execute($str);

		$str="TRUNCATE TABLE acm_roledb";
		$this->m->execute($str);
		$str="TRUNCATE TABLE acm_sninfo";
		$this->m->execute($str);
		$str="TRUNCATE TABLE acm_user2message";
		$this->m->execute($str);
		$str="TRUNCATE TABLE acm_user2role";
		$this->m->execute($str);
		$str="DELETE FROM acm_userdb where 1 AND userName!='admin'";
		$this->m->execute($str);
	}

	//为了整理坯纱规格，有时需要将某个guigeId下的采购等记录并到另外一个guigeId下
	function actionGuigeMove() {
		if($_POST) {
			$sql = "select * from jichu_pisha_guige where id='{$_POST['guigeId1']}'";
			$re = mysql_fetch_assoc(mysql_query($sql));
			$guigeDesc = $re['wareName'].' '.$re['guige'];
			//dump($guigeDesc);
			//dump($_POST);exit;
			$sql="update `gongyi_ransha_plan_real` set guigeId='{$_POST['guigeId1']}',guigeDesc='{$guigeDesc}' where guigeId='{$_POST['guigeId0']}'";
			mysql_query($sql) or die(mysql_error());

			$sql="update `pisha_cgrk` set guigeId='{$_POST['guigeId1']}',guigeDesc='{$guigeDesc}' where guigeId='{$_POST['guigeId0']}'";
			mysql_query($sql) or die(mysql_error());

			$sql="update `pisha_cgrk2ranchang` set guigeId='{$_POST['guigeId1']}',guigeDesc='{$guigeDesc}' where guigeId='{$_POST['guigeId0']}'";
			mysql_query($sql) or die(mysql_error());

			$sql="update `pisha_kucun` set guigeId='{$_POST['guigeId1']}',guigeDesc='{$guigeDesc}' where guigeId='{$_POST['guigeId0']}'";
			mysql_query($sql) or die(mysql_error());

			$sql="update `pisha_kucun_init` set guigeId='{$_POST['guigeId1']}',guigeDesc='{$guigeDesc}' where guigeId='{$_POST['guigeId0']}'";
			mysql_query($sql) or die(mysql_error());

			$sql="update `pisha_llck` set guigeId='{$_POST['guigeId1']}',guigeDesc='{$guigeDesc}' where guigeId='{$_POST['guigeId0']}'";
			mysql_query($sql) or die(mysql_error());

			echo "成功";
			exit;
		}
		$smarty= $this->_getView();
		$smarty->display('Tool/GuigeMove.tpl');
	}

	/****************************读取excel文件********************************************/
	function actionReadExcel() {
		$filePath='a.xls';
		$arr = $this->_readExcel($filePath);
		//以下为数据处理过程
		//$ret = array();
		foreach($arr as $k=> & $v) {
			if($k==0) continue;
			$row = array(
				'proCode'=>$v[1].'',
				'proName'=>$v[2].'',
				'unit'=>'只',
				'priceRetail'=>$v[4].'',
				'barCode'=>$v[6]
			);
			//dump($row);exit;
			$sql = "insert into jxc_jianzhong.jichu_product(
				proCode,
				proName,
				unit,
				priceRetail,
				barCode
			) values(
				'{$row['proCode']}',
				'{$row['proName']}',
				'{$row['unit']}',
				'{$row['priceRetail']}',
				'{$row['barCode']}'
			)";
			mysql_query($sql) or die(mysql_error());
		}
		// dump($ret[0]);exit;
		
		//dump($arr[1]);dump($ret);exit;
		// $m = & FLEA::getSingleton('Model_Jichu_Client');
		// $m->createRowset($ret);
		echo "成功!";
	}
	//读取某个excel文件的某个sheet数据，
	function _readExcel($filePath,$sheetIndex=0) {
		set_time_limit(0);
		include "Lib/PhpExcel/PHPExcel.php";

		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings = array('memoryCacheSize'=>'16MB');
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

		$PHPExcel = new PHPExcel();
		//如果是2007,需要$PHPReader = new PHPExcel_Reader_Excel2007();
		$PHPReader = new PHPExcel_Reader_Excel5();
		if(!$PHPReader->canRead($filePath)){
			echo 'no Excel';
			return ;
		}
		$PHPExcel = $PHPReader->load($filePath);
		/**读取excel文件中的第一个工作表*/
		$currentSheet = $PHPExcel->getSheet($sheetIndex);
		/**取得共有多少列,若不使用此静态方法，获得的$col是文件列的最大的英文大写字母*/
		$allColumn = PHPExcel_Cell::columnIndexFromString($currentSheet->getHighestColumn());

		/**取得一共有多少行*/
		$allRow = $currentSheet->getHighestRow();
		//输出
		$ret = array();
		for($currow=1;$currow<=$allRow;$currow++){
		  $_row=array();
		  for($curcol=0;$curcol<$allColumn;$curcol++){
			   $result=$currentSheet->getCellByColumnAndRow($curcol,$currow)->getValue();
			   $_row[] = $result;
		  }
		  $ret[] = $_row;
		}
		return $ret;
	}
}
?>