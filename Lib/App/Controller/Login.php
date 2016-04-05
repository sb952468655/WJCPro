<?php
class Controller_Login extends FLEA_Controller_Action {
	function Controller_Login() {
	}
	function actionIndex() {
		$ui =& FLEA::initWebControls();
		$smarty = & $this->_getView();
		$smarty->display('Login.tpl');
	}
	function actionLogout() {
		session_destroy();
		redirect(url("Index"));
	}

	function actionLogoutToIndex() {
		session_destroy();
		$ui =& FLEA::initWebControls();
		header("Location:Index.php");
	}
	function actionLogin() {
		do {
			$p=$_POST?$_POST:$_GET;
			if(!isset($p['username'])) break;
            /*验证用户名和密码是否正确*/
			$eqLogin =& FLEA::getSingleton('Model_Login');
			$user = $eqLogin->findByUsername($p['username']);
			if (!$user) {
				$msg = "无效用户名";
				js_alert($msg,null,$this->_url('login'));
				exit;
				//break;
			}
			$userId = $user[id];
			$realName = $user[realName];
			$_SESSION['SN'] = false;
			$_SESSION['isTool']=0;
			if($p['password']!=$user['passwd']) {
				$msg = "无效密码";
				js_alert($msg,null,$this->_url('login'));
				exit;
			}
			if($p['sn']) {
				if($p['username']!='admin') {
					$result = $eqLogin->checkSn($userId, $p['sn']);
					if(!$result){
						$msg = "动态密码错误!";
						js_alert($msg,null,$this->_url('login'));
						exit;
					}
				} else {////如果登录的用户名我admin并且sn不为空，则验证sn是否正确
					$str="SELECT * FROM acm_sninfo where 1";
					$row=$eqLogin->findBySql($str);
					$bSn = false;
					foreach($row as & $v){
						if($v['sn'] == $user['sn']) {
							$result = $eqLogin->checkSn($userId, $p['sn']);
							if($result) {
								$bSn=true;
								$_SESSION['SN'] = true;
								$_SESSION['isTool']=1;
								break;
							}
						}
					}
					if(!$bSn) {
						$msg = "动态密码错误,或者没有在工具箱中定义序列号!";
						js_alert($msg,null,$this->_url('login'));
						exit;
					}
				}
			}

            /*登录成功，通过 RBAC 保存用户信息和角色*/
			$_SESSION['LANG'] = $p['language'];
			$_SESSION['USERID'] = $userId;
			$_SESSION['REALNAME'] = $realName;
			$_SESSION['USERNAME'] = $p['username'];
			$_SESSION['PHP_SELF'] = $_SERVER['PHP_SELF'];
			//更新用户的最后登录时间和登陆日期的登录次数
			redirect(url('Main'));
		}  while (false);
		// 登录发生错误，再次显示登录界面
		//$ui =& FLEA::initWebControls();
		$smarty = & $this->_getView();
		$smarty->display('Login.tpl');
	}

	//动态密码卡同步
	function actionTongbu() {
		if($_POST) {
			//dump($_POST);
			$m=FLEA::getSingleton('Model_Acm_User');
			//根据用户名获得sn号
//			$sql = "select * from acm_sninfo where sn='{$_POST['sn']}'";
//			$_r = $m->findBySql($sql);
			$sn = $_POST['sn'];
			//dump($sn);exit;
			//if($sn=='') die('未发现用户纪录');

			//动态令牌SN号对应的字符串
			$sql = "select * from  acm_userdb where sn='{$sn}'";
			$_r = $m->findBySql($sql);
			$str = $_r[0]['sninfo'];
			if(count($_r)==0) die('未发现动态密码卡登记信息');

			$b=new COM("SeaMoonDLL.ClassKeys");//调用Com组件
			//dump($b);
			//dump($_POST);dump($str);exit;
			//调用同步接口，第一个参数为动态令牌SN号对应的字符串，第二个参数为动态密码
			//dump($_POST);exit;
			$c=$b->ITSecurity_SN_syn($_POST['initCode'],$_POST['dPwd'],0,"0");
			//dump($str);dump($_POST);exit;
			if (strlen($c)>3){
				echo "同步成功";
				//此时你需要把$c的值更新到你的数据库，下次调用时取出此字符串作为参数
				$sql = "update acm_userdb set snInfo='".trim($c)."' where sn='{$sn}'";
				$m->execute($sql);
				echo "同步成功!";
			}elseif($c=="-2"){
				echo "系统内部错误";
			}else{
				echo "同步失败";
			}
			echo $c;
			exit;
			//exit;
		}

		echo '<br>动态密码卡时间同步接口<br>
0)<font color="red">同步前：您需要从技术部获得初始注册码,然后开始同步</font>
	<br>函数原型：String  ITSecurity_SN_syn(SNInfo, password,usestime,cardclock)<br>
1）	SNInfo：动态密码卡的SN信息字符串，需要根据用户名从用户表中查出该用户的SN号码，然后从SN信息表中，根据SN号码，查出该SN号码对应的SN信息字符串；<br>
2）	Password：动态密码卡上显示的密码;<br>
3）	Usestime: 卡的使用次数。只有用SecureCard（卡片式动态密码卡），才有这个参数，用其他小卡时，填入0即可；<br>
4）	cardclock：卡的时钟。只有用SecureCard（卡片式动态密码卡），才有这个参数，用其他小卡时，填入字符串“0”即可；<br>
5）	返回值：<br>
A）	时间同步成功时，返回值的是新的SN信息字符串，这时返回的字符串长度大于3。特别说明：密码验证通过时，需要用返回的这个字符串替换《SN信息表》的原字符串。
返回值等于“-2”时，表示“动态加密字符串有错”；
返回值等于“0”时，表示“动态密码错误”
';
		echo '<form name="login" id="login" method="post" action="?controller=Login&action=Tongbu">
						<table>
							<tr>
								<td>初始sn<span style="font-weight:bold">:</span></td>
								<td align="left"><input type="text" name="sn" id="sn" value="" style="width:100px;" tabindex="2"/></td>
							</tr>
							<tr>
								<td>初始字符串<span style="font-weight:bold">:</span></td>
								<td align="left"><input type="text" name="initCode" id="initCode" value="" style="width:100px;" tabindex="2"/></td>
							</tr>
							<tr>
								<td>动态密码<span style="font-weight:bold">:</span></td>
								<td align="left"><input type="text" name="dPwd" id="dPwd" value="" style="width:100px;" tabindex="2"/></td>
							</tr>

							<tr style="height:50px;">
								<td colspan="3"><input name="login" type="submit" class="button" value=" 开始同步 " </td>
							</tr>
						</table>
					</form>';
		exit;
	}

    /**显示验证码*/
	function actionImgCode() {
		$imgcode =& FLEA::getSingleton('FLEA_Helper_ImgCode');
		$imgcode->image();
	}
}


?>