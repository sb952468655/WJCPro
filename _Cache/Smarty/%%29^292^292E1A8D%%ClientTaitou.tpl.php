<?php /* Smarty version 2.6.10, created on 2014-11-03 09:58:34
         compiled from Jichu/ClientTaitou.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Jichu/ClientTaitou.tpl', 6, false),array('function', 'url', 'Jichu/ClientTaitou.tpl', 53, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%29^292^292E1A8D%%ClientTaitou.tpl.inc'] = 'b218520cda9a1a86934a3d09579513c1'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#7}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#8}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisPopup.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#8}';}?>

<?php echo '
<script language="javascript">
function delRow(obj) {
	var _tbl = document.getElementById(\'listTable\');
	var pos =-1;
	var objs = document.getElementsByName(\'btnDel\');
	for(var i=0;objs[i];i++) {
		if(objs[i]==obj) {
			pos=i;break;
		}
	}
	if(pos==-1) return false;
	//debugger;
	var url = \'?controller=Jichu_Client&action=delTaitouAjax\';
		//debugger;
		var param={
			id:document.getElementsByName(\'id[]\')[pos].value				
		};
		$.getJSON(url,param,function(json){
			//debugger;
			if(!json.success) {
				alert(json.msg);
				return false;
			}	
			_tbl.deleteRow(pos+1);
		});	
}


</script>
<style>
body{ text-align:center; margin:5px 10px;}
.button{ height:24px; width:50px; padding:2px 8px 1px 8px;}
</style>
'; ?>


</head>
<body style="width:400px; height:300px;">
<form name="form1" id="form1" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:b218520cda9a1a86934a3d09579513c1#9}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'saveTaitou'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:b218520cda9a1a86934a3d09579513c1#9}';}?>
" method="post" onSubmit="return check();">
<table id="listTable" class="tableHaveBorder" align="center">
<tr class="th">
   
	    <td>抬头</td>
	    <td>备注</td>
	    <td>操作</td>
  </tr>
  
   <?php $_from = $this->_tpl_vars['aRow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<tr>
		
	  <td><input name="id[]" type="hidden" id="id[]" value="<?php echo $this->_tpl_vars['item']['id']; ?>
">
        <input name="taitou[]" type="text" id="taitou[]" size="20" value="<?php echo $this->_tpl_vars['item']['taitou']; ?>
">
       </td>
	  <td><textarea id="memo[]" name="memo[]" style="width:300px;"><?php echo $this->_tpl_vars['item']['memo']; ?>
</textarea></td>
		<td><input type="button" name="btnDel" id="btnDel" value="删除" size="10" onClick="delRow(this)" class="button"></td>		
		
        
	</tr>
    <?php endforeach; endif; unset($_from); ?>
  
 <tr>
		
	  <td><input type="text" id="taitou" name="taitou" size="20" /><input type="hidden" id="id" name="id" /></td>
	  <td><textarea id="memo" name="memo" style="width:300px;"></textarea></td>
		<td><input  id="Submit" name="Submit" value="提交" size="10" type="submit" class="button"/>
        </td>		
		
       
	</tr>
    
</table>
<div align="center"><input type="button" id="Back" name="Back" value='返回' class="button" onClick="window.parent.location.href=window.parent.location.href"></div>
<input type="hidden" id="clientId" name="clientId" value="<?php echo $_GET['clientId']; ?>
" />
<!--<input type="button" id="Back" name="Back" value="取消" javascript:window.parent.tb_remove() />-->
</form>
</body>
</html>