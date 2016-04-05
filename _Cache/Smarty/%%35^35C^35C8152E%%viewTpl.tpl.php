<?php /* Smarty version 2.6.10, created on 2014-11-15 15:52:08
         compiled from Caiwu/Yf/viewTpl.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Caiwu/Yf/viewTpl.tpl', 7, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%35^35C^35C8152E%%viewTpl.tpl.inc'] = 'cc109056a4a18bd246e7969a780ab09a'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#7}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cc109056a4a18bd246e7969a780ab09a#8}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisPopup.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cc109056a4a18bd246e7969a780ab09a#8}';}?>


<?php echo '
<style type="text/css">
	.form-control{
		max-width: 120px;
	}
</style>
<script language="javascript">

$(function(){   
       
       $(\'[name="danjia1[]"]\').change(function(){    
       var trs = $(this).parents(\'tr\');
       var danjia=$(this).val();
	   var id=$(\'[name="id1[]"]\',trs).val();
	   var cnt=$(\'[name="cnt1[]"]\',trs).val();
	   var money1=$(\'[name="money1[]"]\',trs).val();
	   var hmoney1=$(\'#hmoney1\').val();
	   var money=danjia*cnt;
	   var hmoney=hmoney1-money1+money;
       $(\'[name="money1[]"]\',trs).val(money);
       $(\'#hmoney1\').val(hmoney);
       var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
       var param={id:id,money:money.toFixed(2),danjia:danjia};
       $.getJSON(url,param,function(json){
       
       });
       // window.parent.location.href=window.parent.location.href;
       
    });
    $(\'[name="danjia2[]"]\').change(function(){    
       var trs = $(this).parents(\'tr\');
       var danjia=$(this).val();
       
	   var id=$(\'[name="id2[]"]\',trs).val();
	   var cnt=$(\'[name="cnt2[]"]\',trs).val();
	   var money1=$(\'[name="money2[]"]\',trs).val();
	   var hmoney1=$(\'#hmoney2\').val();
	   var money=danjia*cnt;
	   var hmoney=hmoney1-money1+money;
       $(\'[name="money2[]"]\',trs).val(money);
       $(\'#hmoney2\').val(hmoney);
       var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
       var param={id2:id,money:money.toFixed(2),danjia:danjia};
     
       $.getJSON(url,param,function(json){
       
       });
       // window.parent.location.href=window.parent.location.href;
       
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
		    		<th>等级</th> 
		    		<th>品种</th> 
		    		<th>缸号</th>   		
		    		<th>件数</th>		    		
		    		<th>备注</th>
		    	</tr>
		    </thead>
		    <tbody>
		    <?php $_from = $this->_tpl_vars['ret1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
		    	<tr>
		    		<td><?php echo $this->_tpl_vars['item']['rukuCode']; ?>
</td>
		    		<td><input type='text' class="form-control" id='cnt1[]' name='cnt1[]' value='<?php echo $this->_tpl_vars['item']['cnt']; ?>
' readonly/></td>
		    		<td><input type='text' class="form-control" id='danjia1[]' name='danjia1[]' value='<?php echo $this->_tpl_vars['item']['danjia']; ?>
' />
		    		<input type='hidden' class="form-control" id='id1[]' name='id1[]' value='<?php echo $this->_tpl_vars['item']['id']; ?>
' /></td>
		    		<td><input type='text' class="form-control" id='money1[]' name='money1[]' value='<?php echo $this->_tpl_vars['item']['money']; ?>
' readonly/></td>
		    		<td><?php echo $this->_tpl_vars['item']['proName']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['guige']; ?>
</td>	
		    		<td><?php echo $this->_tpl_vars['item']['color']; ?>
</td>		    		
		    		<td><?php echo $this->_tpl_vars['item']['dengji']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['pinzhong']; ?>
</td>    				    		
		    		<td><?php echo $this->_tpl_vars['item']['ganghao']; ?>
</td>	    		
		    		<td><?php echo $this->_tpl_vars['item']['cntJian']; ?>
</td>	    
		    		<td><?php echo $this->_tpl_vars['item']['memoView']; ?>
</td>
		    	</tr>
		    <?php endforeach; endif; unset($_from); ?> 
		     <tr>
		    		<td>合计</td>
		    		<td><?php echo $this->_tpl_vars['heji1']['cnt']; ?>
</td>
		    		<td>&nbsp;</td>
		    		<td><input type='text' class="form-control" id='hmoney1' name='hmoney1' value='<?php echo $this->_tpl_vars['heji1']['money']; ?>
' readonly/></td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
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

<div class="panel panel-info">
	<div class="panel-heading">
	  <h3 class="panel-title" style="text-align:left;">领用明细</h3>
	</div>
	<div class="panel-body" style="overflow:auto;max-height:320px;">
		<div class="table-responsive">
		  <table class="table table-condensed table-striped">
		    <thead>
		    	<tr>
		    		<th>出库编号</th>
		    		<th>数量(Kg)</th>
		    		<th>单价</th>
		    		<th>金额</th>
		    		<th>纱支</th>
		    		<th>规格</th>
		    		<th>颜色</th>
		    		<th>等级</th> 
		    		<th>批号</th>
		    		<th>缸号</th>	    		
		    		<th>件数</th>		    		
		    		<th>备注</th>
		    	</tr>
		    </thead>
		    <tbody>
		    	<?php $_from = $this->_tpl_vars['ret2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>    
		    	<tr>
		    		<td><?php echo $this->_tpl_vars['item']['chukuCode']; ?>
</td>
		    		<td><input type='text' class="form-control" id='cnt2[]' name='cnt2[]' value='<?php echo $this->_tpl_vars['item']['cnt']; ?>
' readonly/></td>
		    		<td><input type='text' class="form-control" id='danjia2[]' name='danjia2[]' value='<?php echo $this->_tpl_vars['item']['danjia']; ?>
' />
		    		<input type='hidden' class="form-control" id='id2[]' name='id2[]' value='<?php echo $this->_tpl_vars['item']['id']; ?>
' /></td>
		    		<td><input type='text' class="form-control" id='money2[]' name='money2[]' value='<?php echo $this->_tpl_vars['item']['money']; ?>
' readonly/></td>
		    		<td><?php echo $this->_tpl_vars['item']['proName']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['guige']; ?>
</td>	
		    		<td><?php echo $this->_tpl_vars['item']['color']; ?>
</td>		    		
		    		<td><?php echo $this->_tpl_vars['item']['dengji']; ?>
</td>
		    		<td><?php echo $this->_tpl_vars['item']['pihao']; ?>
</td>	    				    		
		    		<td><?php echo $this->_tpl_vars['item']['ganghao']; ?>
</td>	    		
		    		<td><?php echo $this->_tpl_vars['item']['cntJian']; ?>
</td> 
		    		<td><?php echo $this->_tpl_vars['item']['memoView']; ?>
</td>
		    	</tr>
		    <?php endforeach; endif; unset($_from); ?> 
		    <tr>
		    		<td>合计</td>
		    		<td><?php echo $this->_tpl_vars['heji2']['cnt']; ?>
</td>
		    		<td>&nbsp;</td>
		    		<td><input type='text' class="form-control" id='hmoney2' name='hmoney2' value='<?php echo $this->_tpl_vars['heji2']['money']; ?>
' readonly/></td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
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