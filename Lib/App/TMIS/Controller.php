<?php
class TMIS_Controller extends FLEA_Controller_Action {
/**
*代表模块代码的变量
*默认为0,表示不需要进行权限判断
 */
	var $funcId=0;
	var $_modelExample;
	//显示左右分割的iframe框架
	function actionIndex() {
		$smarty = & $this->_getView();
		$smarty->assign('arr_left_list', $this->arrLeftHref);
		//$smarty->assign('title', $this->rightCaption);
		$smarty->assign('caption', $this->leftCaption);
		$smarty->assign('controller', $this->_controllerName);
		$smarty->assign('action', 'right');
		$smarty->display('MainContent.tpl');
	}

	#根据主键删除,并返回到action=right
	function actionRemove() {
		$from = $_GET['fromAction']?$_GET['fromAction']:$_GET['from'];
		if ($this->_modelExample->removeByPkv($_GET['id'])) {
			if($from=='') redirect($this->_url("right"));
			else js_alert(null,"window.parent.showMsg('成功删除')",$this->_url($from));
		}
		else js_alert('出错，不允许删除!',$this->_url($from));

	}
	//利用ajax删除订单明细，在订单编辑界面中使用,需要定义subModel
	function actionRemoveByAjax() {
		$id=$_REQUEST['id'];
		$m = $this->_subModel;
		if($m->removeByPkv($id)) {
			echo json_encode(array('success'=>true));
			exit;
		}
	}

	//新增
	function actionAdd() {
		$this->_edit(array());
	}
	//修改
	function actionEdit() {
		$aRow=$this->_modelExample->find($_GET[id]);
		// dump($aRow);exit;
		$this->_edit($aRow);
	}

	function _edit($arr) {
		$smarty = & $this->_getView();
		$smarty->assign('aRow',$arr);
		$smarty->display($this->_tplEdit);
	}
	//保存
	function actionSave() {
		$id = $this->_modelExample->save($_POST);
		redirect($this->_url($_POST['Submit']=='保存并新增下一个' ? 'add':"Right"));
	}

	//调用通用的编辑模板进行编辑
	function actionCommonEdit() {
		if($_POST['modelName']) {
			$m = & FLEA::getSingleton($_GET['modelName']);
		} else $m= $this->_modelExample;

		$arrF = $this->_editField();
		$aRow=$m->find($_GET[id]);
		$tpl = '_edit.tpl';
		$smarty = & $this->_getView();
		$smarty->assign('field',$arrF);
		$smarty->assign('aRow',$aRow);
		$smarty->display($tpl);
	}
	//修改保存
	function actionCommonSave() {
		if($_POST['modelName']) {
			$m = & FLEA::getSingleton($_GET['modelName']);
		} else $m= $this->_modelExample;
		$m->update($_POST);
		js_alert(null,'window.parent?(window.parent.location.href=window.parent.location.href):(window.location.href="'.$this->_url('right').'")');
	}
	/**
	 *get the arr data from $pager(TMIS_pager),  and conver to the json data which can be used in extjs datgrid
	 */
	function getJsonDataOfExt(& $pager) {
		$rowset = $pager->findAll();
		return '{"totalCount": ' . $pager->totalCount . ',"rows": ' . json_encode($rowset) . '}';
	}

	/**
	 *根据纪录总数和纪录数组构造Ext中的records数据格式
	 */
	function buildExtRecords($cnt,& $arr) {
		return '{"totalCount": ' . $cnt . ',"rows": ' . json_encode($arr) . '}';
	}

	function authCheck($funcId = 0,$isReturn=false) {
		$warning = "<div align=center style='font-size:12px; color=#cc0000'><img src='Resource/Image/warning.gif' style='vertical-align:middle;'>&nbsp&nbsp您没有登录或没有当前模块访问权限!</img></div>";
		if ($funcId === 0) {//检查是否登录
			if($_SESSION['USERID']>0) return true;
			if ($isReturn) return false;
			$_SESSION['TARGETURL'] = $_SERVER[REQUEST_URI];
			if ($isReturn) return false;
			redirect(url('Login','logout'));
			exit;
		}

		//处理$funcId>0的情况
		if(empty($_SESSION['USERID'])) {//没有登录,显示登录界面
		//保存当前地址到session
			$_SESSION['TARGETURL'] = $_SERVER[REQUEST_URI];
			if ($isReturn) return false;
			redirect(url('Login','logout'));
			exit;
		}

		$mUser = FLEA::getSingleton('Model_Acm_User');
		$user = $mUser->find($_SESSION[USERID]);//dump($user);exit;
		if($user[userName]=='admin') {//管理员直接跳过
			return true;
		}

        /*$mFunc = FLEA::getSingleton('Model_Acm_Func');
        if ($funcId == -1) {//从Acm_FuncDb中搜索controller和action匹配的记录
            $sql = "select count(*) cnt,id from acm_funcdb where LOWER(controller)='".strtolower($_GET['controller'])."' and LOWER(action)='".strtolower($_GET['action'])."'";
            $r = mysql_fetch_assoc(mysql_query($sql));
            if($r['cnt']==0) {
                if(!$isReturn) die('没有定义该功能模块！请在模块定义中定义该功能！点击自动增加 [增加]');
                return false;
            }
            $funcId=$r['id'];
        }*/
        
		$userRoles = $mUser->getRoles($_SESSION[USERID]);
		if(count($userRoles)==0) {
			if (!$isReturn) die($warning);
			return false;
		}
		$roles = join(',',array_col_values($userRoles,'id'));
		//各个组是否享有对当前节点的访问权限
		$sql = "select count(*) cnt from acm_func2role where (menuId like '{$funcId}-%' or menuId='{$funcId}') and roleId in({$roles})";
		$_r = $mUser->findBySql($sql);
		if($_r[0]['cnt']==0) {
			if (!$isReturn) die($warning);
			return false;
		}
		return true;
	}

	//显示登陆界面
	function showLogin() {
		$smarty = & $this->_getView();
		$smarty->assign("aProduct",$Arr);
		$pk=$this->_modelExample->primaryKey;
		$primary_key=(isset($_GET[$pk])?$pk:"");
		$smarty->assign("pk",$primary_key);
		$smarty->display('JiChu/ProductEdit.tpl');
	}

	//根据传入的js_func数组,得到需要载入的js文件和css文件列表
	function makeArrayJsCss($js_func=null) {
		$arrCss = array(
			'Main.css',
			'page.css'
		);
		$arrJs = array(
			'jquery.js',
			'jquery.query.js',//可以取得url中的get参数
			'Common.js'
		);
		if(is_string($js_func)) $arr_js_func[] = $js_func;
		else $arr_js_func = & $js_func;
		if (is_array($arr_js_func)) foreach($arr_js_func as & $v) {
				if ($v=='tip') {
					$arrJs[] = 'tip.js';
				}
				if ($v=='calendar') {
					$arrJs[] = 'calendar.js';
				}
				if ($v=='grid') {
					$arrJs[] = 'TmisGrid.js';
				}
				if ($v=='suggest') {
					$arrJs[] = 'TmisSuggest.js';
				}
				if ($v=='thickbox') {
				//$arrJs[] = 'thickbox/thickbox-compressed.js';
					$arrJs[] = 'thickbox/thickbox.js';
					//$arrJs[] = 'jquery.form.js';
					$arrCss[] = 'thickbox.css';
				}
				if ($v=='noRight') {
					$arrJs[] = 'NoRight.js';
				}
			}
		//dump($arrJs);
		return array(
		jsFile=>$arrJs,
		cssFile=>$arrCss
		);
	}

	//可编辑的grid进行修改动作中，控件失去焦点时通过ajax调用.
	//传入id,fieldName,value3个值
	//返回json数据对象{success:true,msg:'成功'}
	//注意$this->_modelExample必须为相应的model.
	function actionAjaxEdit() {
		$row['id'] = $_GET['id'];
		$row[$_GET['fieldName']] = $_GET['value'];
		if ($this->_modelExample->update($row)) {
			$arr = array('success'=>true,'msg'=>'成功!');
		//echo "{'success':true,'msg':'成功!'}";
		} else {
			$arr = array('success'=>false,'msg'=>'出错!');
		//echo "{'success':false,'msg':'出错!'}";
		}
		echo json_encode($arr);
		exit;
	}

	//将普通显示的字段以可编辑的形式显示出来
	function makeEditable(& $arr,$fieldName) {
		$title = $arr[$fieldName]=='' ? '无' : $arr[$fieldName] ;
		$arr[$fieldName] = '<span onclick="gridEdit(this,\''.$fieldName.'\','.$arr[id].')" title="点击修改" onmouseover="this.style.cssText = \'background: #278296;\'" onmouseout="this.style.cssText = \'background:#efefef\'" style="background:#efefef">'.$title.'</span>';
	}

	function getEditHtml($pkv,$action='Edit') {
        if(!is_array($pkv)) return "<a href='".$this->_url($action,array(id=>$pkv,'fromAction'=>$_GET['action']))."'>修改</a>";
		if(!$pkv['fromAction']) $pkv['fromAction']= $_GET['action'];
        return "<a href='".$this->_url($action,$pkv)."'>修改</a>";
    }

    //返回"删除"操作按钮
    function getRemoveHtml($pkv,$action='Remove') {
        if(!is_array($pkv)) return "<a href='".$this->_url($action,array(
			'id'=>$pkv,
			'from'=>$_GET['action'],
			'fromAction'=>$_GET['action']
		))."' onclick='return confirm(\"您确认要删除吗?\")'>删除</a>";
		if(!$pkv['text']) $pkv['text']='删除';
		if(!$pkv['msg']) $pkv['msg']='您确认要删除吗';
		if(!$pkv['fromAction']) $pkv['fromAction']=$_GET['action'];
        return "<a href='".$this->_url($action,$pkv)."' onclick='return confirm(\"{$pkv['msg']}?\")'>{$pkv['text']}</a>";
    }

	#清空搜索条件
	function clearCondition() {
		FLEA::loadClass('TMIS_Pager');
		TMIS_Pager::clearCondition();
	}


	#对rowset的某几个字段进行合计,
	#firstField表示需要显示为"合计"字样的字段
	#返回合计行的数据
	function getHeji(&$rowset,$arrField,$firstField='') {
		$str = "\$newRow[\"" . join('"]["',explode('.',$firstField)) . '"]="<b>合计</b>";';
		eval($str);
		foreach($rowset as & $v) {
			foreach($arrField as & $f) {
				$newRow[$f] += $v[$f];
				$newRow[$f] = $newRow[$f];
			}
		}
		$newRow['_bgColor']='#F2F4F6';
		$newRow['mark']='heji';
		return $newRow;
	}


	//根据配置文件中的khqcxs变量判断是否优先显示客户助记码
	//key可以是clientId或者compName
	function changeClient($key) {
		$kg = & FLEA::getAppInf('khqcxs');
		$m = & FLEA::getSingleton('Model_Jichu_Client');
		if(is_numeric($key)) {//如果是clientId
			$client = $m->find(array('id'=>$key));
		} else {
			$client = $m->find(array('compName'=>$key));
		//dump($client);exit;
		}
		if($kg) return $client['compName'];
		if($client['zhujiCode']=='') return $client['compName'];
		//echo $client['zhujiCode'];exit;
		return $client['zhujiCode'];
	}

	//取得系统配置数组
	function getSysSet() {
		FLEA::loadClass('TMIS_Common');
		return TMIS_Common::getSysSet();
	}

	//根据流转单号跳转到生产跟踪
	/*function getOrderTrace($orderCode,$orderId,$ord2proId) {
		if($orderId!='' && $ord2proId!='') {
			$str="SELECT numId FROM trade_order2product WHERE orderId='{$orderId}' and id='{$ord2proId}'";
			$re=mysql_fetch_assoc(mysql_query($str));
			$code=$orderCode;//.'-'.$re['numId'];
			$orderCode="<a href='javascript:void(0)' name='".url('Trade_Order','TraceByHuaxing',array(
				'orderId'=>$orderId,
				'ord2proId'=>$ord2proId
				))."' class='orderTrace' ext:qtip='点击显示订单跟踪明细' style='color:#000000;font-weight:bold;'>{$code}</a>";
			return $orderCode;
		}
		if($orderCode!='' && $orderId!='') {
			$orderCode="<a href='javascript:void(0)' name='".url('Trade_Order','TraceByHuaxing',array(
				'orderId'=>$orderId))."' class='orderTrace'  ext:qtip='点击显示订单跟踪明细' style='color:#000000;font-weight:bold;'>{$orderCode}</a>";
			//tooltip='点击显示订单跟踪明细',必须要求qtip2
			//ext:qtip='点击显示订单跟踪明细',必须要求执行 Ext.QuickTips.init();函数
			return $orderCode;
		}
	}*/


	//根据前缀，自动从表中产生$head.yymmddxxx的流水号
	function _getNewCode($head,$tblName,$fieldName) {
		$m = & FLEA::getSingleton('Model_Acm_User');
		$sql = "select {$fieldName} from {$tblName} where {$fieldName} like '{$head}_________' order by {$fieldName} desc limit 0,1";

		$_r = $m->findBySql($sql);
		$row = $_r[0];

		$init = $head .date('ymd').'001';
		if(empty($row[$fieldName])) return $init;
		if($init>$row[$fieldName]) return $init;

		//自增1
		$max = substr($row[$fieldName],-3);
		$pre = substr($row[$fieldName],0,-3);
		return $pre .substr(1001+$max,1);
	}

	function _autoCode($head,$next,$tblName,$fieldName){
		$m = & FLEA::getSingleton('Model_Acm_User');
		$sql = "select {$fieldName} from {$tblName} where {$fieldName} like '{$head}{$next}____' order by {$fieldName} desc limit 0,1";

		$_r = $m->findBySql($sql);
		$row = $_r[0];

		$init = $head.$next.'0001';
		if(empty($row[$fieldName])) return $init;
		if($init>$row[$fieldName]) return $init;
		// dump($init);exit;
		//自增1
		$max = substr($row[$fieldName],-4);
		$pre = substr($row[$fieldName],0,-4);
		return $pre .substr(10001+$max,1);
	}


	//显示产品：不能厂名字不能，纺织行业为花型颜色，
	function getManuCodeName() {
		$sys=$this->getSysSet();
		return $sys['Product_Memo']==''?'产品描述':$sys['Product_Memo'];
	}

	//使用通用编辑模板进行修改前，需要用数据库中的记录覆盖表中的value字段
	//返回的标签中增加了value属性
	function getValueFromRow($fldMain,$row) {
		foreach($fldMain as $key=>&$v) {
			$v['value'] = $row[$key];
		}
		return $fldMain;
	}

	/*********************************************************************\
	*  Copyright (c) 1998-2013, TH. All Rights Reserved.
	*  Author :li
	*  FName  :Controller.php
	*  Time   :2014/05/13 17:00:30
	*  Remark :用于有效性验证，验证重复问题
	\*********************************************************************/
	function actionRepeat(){
		if($_GET['field']=='' || $_GET['fieldValue']==''){
			exit;
		}
		//查找是否存在
		$con=array();
		$con[]=array($_GET['field'],$_GET['fieldValue'],'=');
		if($_GET['id']>0)$con[]=array('id',$_GET['id'],'<>');
		$temp=$this->_modelExample->findAll($con);
		// dump($temp);
		$success = count($temp)>0?false:true;

		echo json_encode(array('success'=>$success));
	}

	/**
	 * 后整理的类型，暂时写死在系统中
	 * Time：2014/07/29 18:12:37
	 * @author li
	 * @param Array
	 * @return Array
	*/
	function getHzlKind($isStr=false){
		if($isStr){
			return "'印花','水洗','定型'";
		}else{
			return array(
				array('text'=>'印花','value'=>'印花'),
				array('text'=>'水洗','value'=>'水洗'),
				array('text'=>'定型','value'=>'定型'),
			);
		}
	}

	/**
   * ps ：清空某些字段的value值
   * 对二维数组进行操作
   * Time：2014/09/15 09:53:25
   * @author li
   * @param $arr二维数组
   * @param $keys,数组,也支持字符串的形式
  */
  function array_values_empty(& $arr , $keys){
	    foreach ($arr as $k => & $v) {
	    	//字符串的形式
	    	if(is_string($keys)){
	    		if(isset($v[$keys])){
			      		$v[$keys]='';
		      	}
	    	}elseif(is_array($keys)){
	    		//数组的形式
	    		foreach ($keys as $key => & $c) {
			      	if(isset($v[$c])){
			      		$v[$c]='';
			      	}
			    }
	    	}
	    }
  }

  /**
   * 导出操作
   * Time：2014/09/28 16:25:51
   * @author li
  */
  function _export($arr){
  		$arr['fileName']=='' &&  $arr['fileName']=date('y-m-d').$SESSION['REALNAME'];
  		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", $arr['fileName'].".xls"));
		header("Content-Disposition: attachment;filename=List HL.xls");
		header("Content-Transfer-Encoding: binary");
  }

  /**
   * 导出明细列表
   * Time：2014/09/28 16:34:25
   * @author li
  */
  function _exportList($arr,& $smarty){
  	$this->_export($arr);
  	// dump($smarty);exit;
  	$field = & $smarty->_tpl_vars['arr_field_info'];
  	// dump($field);exit;
  	//键值为下面这些的，输出类型默认未数字类型
  	$col = array('cnt','cntJian','cntM','cntYaohuo','danjia','money','tuiCnt','rkCnt');
  	foreach ($col as & $v) {
  		if(array_key_exists($v, $field)){
	  		if(is_array($field[$v])){
	  			$field[$v]['type']="Number";
	  		}else{
	  			$field[$v] = array(
	  					'text'=>$field[$v],
	  					'type'=>'Number'
	  			);
	  		}
	  	}
  	}
  	// dump($field);
  	// dump($smarty->_tpl_vars['arr_field_info']);
  	$smarty->display('Export2Excel.tpl');
  	exit;
  }

  /**
   * 引用图片
  */
  function _imageIco($arr){
  	if($arr['src']=='')return '';

  	return "<img src='{$arr['src']}' title='{$arr['title']}' width='{$arr['width']}' height='{$arr['height']}'>";
  }

  function _editIco(){
  	return $this->_imageIco(array('src'=>'Resource/Image/Edit.gif'));
  }

  function _removeIco(){
  	return $this->_imageIco(array('src'=>'Resource/Image/Del.gif'));
  }
}
?>
