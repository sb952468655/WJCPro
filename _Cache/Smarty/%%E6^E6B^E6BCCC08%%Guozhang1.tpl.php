<?php /* Smarty version 2.6.10, created on 2014-11-11 16:24:25
         compiled from Caiwu/Yf/Guozhang1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Caiwu/Yf/Guozhang1.tpl', 7, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%E6^E6B^E6BCCC08%%Guozhang1.tpl.inc'] = 'f622a67e669af4a36181df2c7631c72b'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#7}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:f622a67e669af4a36181df2c7631c72b#8}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisPopup.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:f622a67e669af4a36181df2c7631c72b#8}';}?>


<?php echo '
<script language="javascript">

$(function(){   
   $(\'#save\').click(function(){
    //alert(123);
       
       
       var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
       var param={id:id,money:money.toFixed(2),danjia:danjia};
       $.getJSON(url,param,function(json){
       
       });
   });
     
});
</script>
'; ?>

<body>
<div class="panel panel-info">
	<div class="panel-heading">
	  <h3 class="panel-title" style="text-align:left;">采购过账</h3>
	</div>
	<div class="panel-body" style="overflow:auto;">
		<div class="table-responsive">
		  <table class="table table-hover">
		    <thead>
		    	<tr>
		    		<th>过账选择</th>
		    		<th>查看</th>
		    		<th>发生日期</th>
		    		<th>入库类型</th>	    		
		    		<th>数量(Kg)</th>
		    		<th>金额</th> 
		    		<th>供应商</th>
		    		<th>库位</th>
		    		<th>入库单号</th>		    		
		    		<th>备注</th>
		    	</tr>
		    </thead>
		    <tbody>
		    <?php $_from = $this->_tpl_vars['ret']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
		    	<tr style="text-align:left;">
		    		<td><input type='checkbox' id='isGuozhang[]' name='isGuozhang[]'  <?php if (checked): ?>value=1<?php endif; ?> /></td>
		    		<td><?php echo $this->_tpl_vars['item']['mingxi']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['rukuDate']; ?>

		    		<input type='hidden' style="width:50px;" id='id1[]' name='id1[]' value='<?php echo $this->_tpl_vars['item']['id']; ?>
' /></td>
		    		<td><?php echo $this->_tpl_vars['item']['kind']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['cnt']; ?>
</td>		    		
		    		<td><?php echo $this->_tpl_vars['item']['money']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['supplierName']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['kuweiName']; ?>
</td>		    				    		
		    		<td><?php echo $this->_tpl_vars['item']['rukuCode']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['rukuMemo']; ?>
</td>		    		
		    	</tr>
		    <?php endforeach; endif; unset($_from); ?> 
		    <!-- <tr>
		    		<td>合计</td>
		    		
		    		<td>&nbsp;</td>
		    		
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td><?php echo $this->_tpl_vars['heji']['cnt']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['heji']['money']; ?>
</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>   		
		    	</tr>-->
		    	<tr>
		    	<td colspan='10' algin='right'><input type='button' id='save' name='save' value='保存'/>
		    	&nbsp;&nbsp;&nbsp;
		    	<input type='reset' id='save' name='save' value='重置'/></td>
		    	</tr>
		    </tbody>
		  </table>
		</div>
	</div>
</div>


</body>
</html>