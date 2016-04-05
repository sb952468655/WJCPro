<?php /* Smarty version 2.6.10, created on 2014-11-15 15:48:06
         compiled from Caiwu/Yf/CaigouTpl.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Caiwu/Yf/CaigouTpl.tpl', 7, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%5D^5D2^5D2D215B%%CaigouTpl.tpl.inc'] = '8216218dc784f1799991c8527e300f8f'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#7}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:8216218dc784f1799991c8527e300f8f#8}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisPopup.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:8216218dc784f1799991c8527e300f8f#8}';}?>

<?php echo '
<style type="text/css">
	.form-control{
		max-width: 120px;
	}
</style>
<script language="javascript">

$(function(){
    
       $(\'[name="danjia[]"]\').change(function(){    
	       var trs = $(this).parents(\'tr\');
	       var danjia=$(this).val();
		   var id=$(\'[name="id[]"]\',trs).val();
		   var cnt=$(\'[name="cnt[]"]\',trs).val();
		   var money1=$(\'[name="money[]"]\',trs).val();
		   var hmoney1=$(\'#hmoney\').val();
		   var money=danjia*cnt;
		   var hmoney=hmoney1-money1+money;
	       $(\'[name="money[]"]\',trs).val(money);
	       $(\'#hmoney\').val(hmoney);
	       var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
	       var param={id:id,money:money,danjia:danjia};
	       $.getJSON(url,param,function(json){
	       });
	    });

       $(\'#Submit\').click(function(){
       		window.close();
	    	window.parent.location.href=window.parent.location.href;
	    });
});
</script>
'; ?>

<body>
<div class="panel panel-info">
	<div class="panel-heading">
	  <h3 class="panel-title" style="text-align:left;">验收明细</h3>
	</div>
	<div class="panel-body" style="overflow:auto;max-height:320px;">
		<div class="table-responsive">
		  <table class="table table-hover">
		    <thead>
		    	<tr>
		    		<th>入库编号</th>
		    		<th>数量(Kg)</th>
		    		<th>单价</th>
		    		<th>金额</th>		    		
		    		<th>纱支</th>
		    		<th>规格</th>
		    		<th>颜色</th>
		    		<th>包数</th>
		    		<th>备注</th>
		    	</tr>
		    </thead>
		    <tbody>
		    <?php $_from = $this->_tpl_vars['ret']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
		    	<tr  style="text-align:left;">
		    		<td><?php echo $this->_tpl_vars['item']['rukuCode']; ?>
</td>
		    		<td><input type='text' class="form-control" id='cnt[]' name='cnt[]' value='<?php echo $this->_tpl_vars['item']['cnt']; ?>
' readonly/></td>
		    		<td><input type='text' class="form-control" id='danjia[]' name='danjia[]' value='<?php echo $this->_tpl_vars['item']['danjia']; ?>
' />
		    		<input type='hidden' style="width:50px;" id='id[]' name='id[]' value='<?php echo $this->_tpl_vars['item']['id']; ?>
' />
		    		</td>
		    		<td><input type='text' class="form-control" id='money[]' name='money[]' value='<?php echo $this->_tpl_vars['item']['money']; ?>
' readonly/></td>	    		
		    		<td><?php echo $this->_tpl_vars['item']['proName']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['guige']; ?>
</td>	
		    		<td><?php echo $this->_tpl_vars['item']['color']; ?>
</td>	    				    		   		
		    		<td><?php echo $this->_tpl_vars['item']['cntJian']; ?>
</td>		    				
		    		<td><?php echo $this->_tpl_vars['item']['memoView']; ?>
</td>
		    	</tr>
		    <?php endforeach; endif; unset($_from); ?> 
		     <tr style="text-align:left;">
		    		<td>合计</td>
		    		<td><?php echo $this->_tpl_vars['heji']['cnt']; ?>
</td>
		    		<td>&nbsp;</td>
		    		<td><input type='text' class="form-control" id='hmoney' name='hmoney' value='<?php echo $this->_tpl_vars['heji']['money']; ?>
' readonly/></td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    	</tr>
		    </tbody>
		  </table>
		</div>
	</div>
</div>
<div class="form-group">
  <div class="col-sm-offset-4 col-sm-4">
      <input class="btn btn-primary" type="button" id="Submit" name="Submit" value=" 确定 ">
  </div>
</div>

</body>
</html>