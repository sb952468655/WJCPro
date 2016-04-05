<?php /* Smarty version 2.6.10, created on 2016-03-31 17:55:59
         compiled from Acm/UserEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Acm/UserEdit.tpl', 5, false),array('function', 'url', 'Acm/UserEdit.tpl', 51, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%FF^FF4^FF47AF79%%UserEdit.tpl.inc'] = '71ab049620db2e5124e0c7c45cc29571'; ?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:71ab049620db2e5124e0c7c45cc29571#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:71ab049620db2e5124e0c7c45cc29571#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:71ab049620db2e5124e0c7c45cc29571#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:71ab049620db2e5124e0c7c45cc29571#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:71ab049620db2e5124e0c7c45cc29571#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:71ab049620db2e5124e0c7c45cc29571#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:71ab049620db2e5124e0c7c45cc29571#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:71ab049620db2e5124e0c7c45cc29571#3}';}?>


<?php echo '
<script language="javascript">
$(function(){
	$.validator.addMethod("checkPass", function(value, element) {
		var o = document.getElementById(\'passwd\');	
		if(o.value!=value || value==\'\')
		return false;
		return true;
	}, "密码不匹配!");
	
	$(\'#form1\').validate({
		rules:{
			userName:"required",
			realName:"required",
			passwd:"required",
			PasswdConfirm:"checkPass"
		},
		submitHandler : function(form){
			$(\'[name="Submit"]\').attr(\'disabled\',true);
			form.submit();
		}
	});
	//ret2cab();
});
</script>
<style type="text/css">
#divMain{width:100%; border:0px #D4E2F4 solid; overflow:auto; height:305px;}
#divLeft{width:47%; border:1px #D4E2F4 solid; float:left; overflow:auto;height:300px;}
#divRight{width:47%; border:1px #D4E2F4 solid; float:right;overflow:auto;height:300px;}
#tblLeft{ width:100%;}
#tblLeft tr td{border:0px; border-bottom:1px #D4E2F4 dotted; padding-left:20px;}
#tblLeft tr td input{border:0px;}
#tblRight{ width:100%;}
#tblRight tr td{border:0px; border-bottom:1px #D4E2F4 dotted; padding-left:20px;}
#tblRight tr td input{border:0px;}
</style>
'; ?>


</head>

<body>
<form name="form1" id="form1" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:71ab049620db2e5124e0c7c45cc29571#4}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:71ab049620db2e5124e0c7c45cc29571#4}';}?>
" method="post">
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['aUser']['id']; ?>
" />
<input name="from" type="hidden" id="from" value="right" />
<fieldset>
<legend>基本信息</legend>
<table id="mainTable">
  <tr>
    <td align="right" class="tdTitle">用户名：</td>
    <td><input name="userName" type="text" id="userName" value="<?php echo $this->_tpl_vars['aUser']['userName']; ?>
"/></td>
    <td align="right" class="tdTitle">真实姓名：</td>
    <td><input name="realName" type="text" id="realName" value="<?php echo $this->_tpl_vars['aUser']['realName']; ?>
"/></td>
    <td align="right" class="tdTitle">身份证号：</td>
    <td><input name="shenfenzheng" type="text" id="shenfenzheng" value="<?php echo $this->_tpl_vars['aUser']['shenfenzheng']; ?>
"/></td>
    </tr>
  <tr>
    <td align="right" class="tdTitle">登陆密码：</td>
    <td><input name="passwd" type="password" id="passwd" value="<?php echo $this->_tpl_vars['aUser']['passwd']; ?>
"/></td>
    <td align="right" class="tdTitle">密码确认：</td>
    <td><input name="PasswdConfirm" type="password" id="PasswdConfirm" value="<?php echo $this->_tpl_vars['aUser']['passwd']; ?>
" check="^\S+$" warning="重复密码不能为空！"/></td>
    </tr>
 </table>
 </fieldset>
 <fieldset>
<legend>指定信息</legend>
<div id="divMain">
<div id='divLeft'>
<table id="tblLeft">
<tr>
<td align="center" style="background-color:#D4E2F4; font-size:12px; height:22px;">选择角色</td>
</tr>
<?php $_from = $this->_tpl_vars['aUser']['Role']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr>
	<td><input type="checkbox" name="roles[]" id="ckb<?php echo $this->_tpl_vars['item']['id']; ?>
" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['item']['isChecked'] == 1): ?>checked<?php endif; ?>>
    <label for="ckb<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['roleName']; ?>
</label></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</div>
<div id="divRight">
<table id="tblRight">
<tr>
<td align="center" style="background-color:#D4E2F4; font-size:12px; height:22px;">选择业务员
<font color="#999999">（指定业务员后，可看到该业务员的所有订单）</font></td>
</tr>
<?php $_from = $this->_tpl_vars['aUser']['Trader']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<tr>
	<td><input type="checkbox" name="traders[]" id="trader<?php echo $this->_tpl_vars['item']['id']; ?>
" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['item']['isChecked'] == 1): ?>checked<?php endif; ?>>
    <label for="trader<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['employName']; ?>
</label></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
</div>
</div>
</fieldset>
<table id="buttonTable">
<tr>
    	<td><input type="submit" id="Submit" name="Submit" value='保存并新增下一个' class="button"></td>
    	<td><input type="submit" id="Submit" name="Submit" value='保存' class="button"></td>
        <td><input type="button" id="Back" name="Back" value='返回' onClick="javascript:window.history.go(-1);" class="button"></td>
    </tr>
</table>
</form>
</body>
</html>