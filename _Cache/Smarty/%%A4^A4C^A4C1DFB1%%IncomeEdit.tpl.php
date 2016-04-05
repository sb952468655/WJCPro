<?php /* Smarty version 2.6.10, created on 2014-11-12 14:47:41
         compiled from Caiwu/Xianjin/IncomeEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Caiwu/Xianjin/IncomeEdit.tpl', 7, false),array('function', 'url', 'Caiwu/Xianjin/IncomeEdit.tpl', 46, false),array('modifier', 'default', 'Caiwu/Xianjin/IncomeEdit.tpl', 60, false),array('modifier', 'date_format', 'Caiwu/Xianjin/IncomeEdit.tpl', 60, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%A4^A4C^A4C1DFB1%%IncomeEdit.tpl.inc'] = '0d8d91d8b15e03662e6bb37b878f959d'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#7}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#8}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisPopup.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#8}';}?>


<?php echo '
<script language="javascript">

$(function(){   
       
      $(\'#form1\').validate({
		rules:{		
			\'dakuanfang\':\'required\',
			\'money\':\'required\'
		},
		submitHandler : function(form){
			$(\'#Submit\').attr(\'disabled\',true);
			form.submit();
		}
	});
});

$(function(){
	ret2cab();	   
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
		  <form name="form1" id="form1" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#9}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#9}';}?>
" method="post" >
          <input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['aRow']['id']; ?>
" />

			<table>
			  <tr>
			    <th>流水号：</th>
			    <td><input name="incomeCode" style="width:140px;" type="text" id="incomeCode" value="<?php echo $this->_tpl_vars['aRow']['incomeCode']; ?>
" readonly="readonly"/></td>
			  </tr>
			  <tr>
			     <th>打款方：</th>
			    <td><input name="dakuanfang" style="width:140px;" type="text" id="dakuanfang" value="<?php echo $this->_tpl_vars['aRow']['dakuanfang']; ?>
"></td>
			  </tr>
			  <tr>
			    <th>收款日期：</th>
			    <td><input name="incomeDate" style="width:140px;" readonly type="text" id="incomeDate"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['aRow']['incomeDate'])) ? $this->_run_mod_handler('default', true, $_tmp, time()) : smarty_modifier_default($_tmp, time())))) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" size="15" onClick="calendar()"></td>
			  </tr>
			  <tr>
			    <th>打款方式：</th>
			    <td><select width=80 name="zhifuWay" style="width:140px;" id="zhifuWay">   
						<option value="现金" <?php if ($this->_tpl_vars['aRow']['incomeWay'] == '现金'): ?> selected="selected" <?php endif; ?>>现金</option>
						<option value="支票" <?php if ($this->_tpl_vars['aRow']['incomeWay'] == '支票'): ?> selected="selected" <?php endif; ?>>支票</option>
						<option value="电汇" <?php if ($this->_tpl_vars['aRow']['incomeWay'] == '电汇'): ?> selected="selected" <?php endif; ?>>电汇</option>
						<option value="承兑" <?php if ($this->_tpl_vars['aRow']['incomeWay'] == '承兑'): ?> selected="selected" <?php endif; ?>>承兑</option>
						<option value="其它" <?php if ($this->_tpl_vars['aRow']['incomeWay'] == '其它'): ?> selected="selected" <?php endif; ?>>其它</option>
			    </select></td>
			  </tr>
			   <tr>
			    <th>银行帐户：</th>
			    <td>
					<select name="bankId" style="width:140px;" id="bankId" check='^0$' warning='请选择银行帐户!'>              
			    		<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:0d8d91d8b15e03662e6bb37b878f959d#10}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'TmisOptions','model' => 'Caiwu_Bank','selected' => $this->_tpl_vars['aRow']['bankId']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:0d8d91d8b15e03662e6bb37b878f959d#10}';}?>

			    	</select></td>
			  </tr>
			  <tr>
			    <th>收款金额：</th>
			    <td><input name="money" style="width:140px;" type="text" id="money" value="<?php echo $this->_tpl_vars['aRow']['money']; ?>
" /></td>
			  </tr>
			  <tr>
			    <th>备注：</th>
			    <td><input name="memo" type="text" id="memo" value="<?php echo $this->_tpl_vars['aRow']['memo']; ?>
" /></td>
			    </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><input type="submit" id="Submit" name="Submit" value='保存' class="button">
					<?php if ($_GET['fromAction'] != ''): ?><input type="button" id="Back" name="Back" value='返回' onClick="javascript:window.history.go(-1);" class="button"><?php endif; ?>
			      <input name="fromAction" type="hidden" id="fromAction" value="<?php echo $_GET['fromAction']; ?>
" /></td>
			  </tr>
			</table>
			</form>
		</div>
	</div>
</div>


</body>
</html>