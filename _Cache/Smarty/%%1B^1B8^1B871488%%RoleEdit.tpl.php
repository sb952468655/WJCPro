<?php /* Smarty version 2.6.10, created on 2016-03-31 17:55:38
         compiled from Acm/RoleEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Acm/RoleEdit.tpl', 4, false),array('function', 'webcontrol', 'Acm/RoleEdit.tpl', 6, false),array('function', 'url', 'Acm/RoleEdit.tpl', 29, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%1B^1B8^1B871488%%RoleEdit.tpl.inc'] = 'd38943880bd60c3cdbd797dc8b3cddb9'; ?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['title'])) ? $this->_run_mod_handler('default', true, $_tmp, "角色信息编辑") : smarty_modifier_default($_tmp, "角色信息编辑")); ?>
</title>
<script language="javascript" src="Script/CheckForm.js"></script>
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d38943880bd60c3cdbd797dc8b3cddb9#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d38943880bd60c3cdbd797dc8b3cddb9#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d38943880bd60c3cdbd797dc8b3cddb9#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d38943880bd60c3cdbd797dc8b3cddb9#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d38943880bd60c3cdbd797dc8b3cddb9#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d38943880bd60c3cdbd797dc8b3cddb9#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d38943880bd60c3cdbd797dc8b3cddb9#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d38943880bd60c3cdbd797dc8b3cddb9#3}';}?>

<?php echo '
<script language="javascript">
$(function(){
	$(\'#form1\').validate({
		rules:{
			roleName:"required"
		}
		,submitHandler : function(form){
			$(\'[name="Submit"]\').attr(\'disabled\',true);
			form.submit();
		}
	});
	
	//ret2cab();
});
</script>
'; ?>

</head>
<body>
<form name="form1" id="form1" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d38943880bd60c3cdbd797dc8b3cddb9#4}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d38943880bd60c3cdbd797dc8b3cddb9#4}';}?>
" method="post">
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['aRole']['id']; ?>
" />
<input name="fromAction" type="hidden" id="fromAction" value="<?php echo $_GET['fromAction']; ?>
" />
<table id="mainTable">
  <tr>
    <td class="title">角色名称：</td>
    <td><input name="roleName" type="text" id="roleName" value="<?php echo $this->_tpl_vars['aRole']['roleName']; ?>
" check="^\S+$" warning="部门名称不能为空！"/></td>
    </tr>
</table>
<table id="buttonTable">
	<tr>
    	<td><input type="submit" id="Submit" name="Submit" value='保存并新增下一个'></td>
    	<td><input type="submit" id="Submit" name="Submit" value='保存'></td>
        <td><input type="button" id="Back" name="Back" value='返回' onClick="javascript:window.location.href='<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d38943880bd60c3cdbd797dc8b3cddb9#5}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => 'Acm_Role','action' => 'right'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d38943880bd60c3cdbd797dc8b3cddb9#5}';}?>
'"></td>    
    </tr>
</table>
</form>
</body>
</html>
