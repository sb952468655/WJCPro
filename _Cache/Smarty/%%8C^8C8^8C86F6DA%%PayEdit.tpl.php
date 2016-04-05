<?php /* Smarty version 2.6.10, created on 2014-11-08 12:54:47
         compiled from Caiwu/Xianjin/PayEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'Caiwu/Xianjin/PayEdit.tpl', 37, false),array('function', 'webcontrol', 'Caiwu/Xianjin/PayEdit.tpl', 53, false),array('modifier', 'default', 'Caiwu/Xianjin/PayEdit.tpl', 48, false),array('modifier', 'date_format', 'Caiwu/Xianjin/PayEdit.tpl', 48, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%8C^8C8^8C86F6DA%%PayEdit.tpl.inc'] = '43a637376511664ce14684ccd3b6cc44'; ?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" type="text/javascript" src="Resource/Script/Calendar/WdatePicker.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<script language="javascript">
<?php echo '
$(function(){
	$(\'#form1\').validate({
		rules:{		
			\'itemId\':\'required\',
			//\'bankId\':\'required\',
			\'shoukuanfang\':\'required\',
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
'; ?>

</script>
<link href="Resource/Css/Edit.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form name="form1" id="form1" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:43a637376511664ce14684ccd3b6cc44#0}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:43a637376511664ce14684ccd3b6cc44#0}';}?>
" method="post" >

<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['aRow']['id']; ?>
" />

<table width="400px">
  <tr>
    <td height="33">流水号：</td>
    <td><input name="payCode" type="text" id="payCode" value="<?php echo $this->_tpl_vars['aRow']['payCode']; ?>
" readonly="readonly"/></td>
  </tr>
  <tr>
    <td height="33">往来日期：</td>
    <td><input name="comeDate" readonly type="text" id="comeDate"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['aRow']['comeDate'])) ? $this->_run_mod_handler('default', true, $_tmp, time()) : smarty_modifier_default($_tmp, time())))) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" size="15" onClick="calendar()"></td>
  </tr>
  <tr>
    <td>付款科目：</td>
    <td><select name="itemId" id="itemId">                    
    		<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:43a637376511664ce14684ccd3b6cc44#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'TmisOptions','model' => 'jichu_feiyong','selected' => $this->_tpl_vars['aRow']['itemId']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:43a637376511664ce14684ccd3b6cc44#1}';}?>
    	
    </select></td>
  </tr>
  <tr>
    <td>收款方：</td>
    <td><input name="shoukuanfang" type="text" id="shoukuanfang" value="<?php echo $this->_tpl_vars['aRow']['shoukuanfang']; ?>
"></td>
  </tr>
  <tr>
    <td height="33">凭证号：</td>
    <td><input name="pingzhengCode" type="text" id="pingzhengCode" value="<?php echo $this->_tpl_vars['aRow']['pingzhengCode']; ?>
" /></td>
  </tr>
  <tr>
    <td height="33">付款日期：</td>
    <td><input name="payDate" readonly type="text" id="payDate"  value="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['aRow']['payDate'])) ? $this->_run_mod_handler('default', true, $_tmp, time()) : smarty_modifier_default($_tmp, time())))) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" size="15" onClick="calendar()"></td>
  </tr>
  <tr>
    <td height="33">支付方式：</td>
    <td><select name="zhifuWay" id="zhifuWay">   
			<option value="现金" <?php if ($this->_tpl_vars['aRow']['payWay'] == '现金'): ?> selected="selected" <?php endif; ?>>现金</option>
			<option value="支票" <?php if ($this->_tpl_vars['aRow']['payWay'] == '支票'): ?> selected="selected" <?php endif; ?>>支票</option>
			<option value="电汇" <?php if ($this->_tpl_vars['aRow']['payWay'] == '电汇'): ?> selected="selected" <?php endif; ?>>电汇</option>
			<option value="承兑" <?php if ($this->_tpl_vars['aRow']['payWay'] == '承兑'): ?> selected="selected" <?php endif; ?>>承兑</option>
			<option value="其它" <?php if ($this->_tpl_vars['aRow']['payWay'] == '其它'): ?> selected="selected" <?php endif; ?>>其它</option>
    </select></td>
  </tr>
   <tr>
    <td height="33">银行帐户：</td>
    <td>
		<select name="bankId" id="bankId">              
    		<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:43a637376511664ce14684ccd3b6cc44#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'TmisOptions','model' => 'Caiwu_Bank','selected' => $this->_tpl_vars['aRow']['bankId']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:43a637376511664ce14684ccd3b6cc44#2}';}?>

    	</select></td>
  </tr>
  <tr>
    <td height="34">付款金额：</td>
    <td><input name="money" type="text" id="money" value="<?php echo $this->_tpl_vars['aRow']['money']; ?>
" /></td>
  </tr>
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="<?php echo $this->_tpl_vars['aRow']['memo']; ?>
" /></td>
    </tr>
  <tr>
    <td height="35">&nbsp;</td>
    <td><input type="submit" id="Submit" name="Submit" value='保存' class="button">
    <?php if ($_GET['fromAction'] != ''): ?><input type="button" id="Back" name="Back" value='返回' onClick="javascript:window.history.go(-1);" class="button"><?php endif; ?>
      <input name="fromAction" type="hidden" id="fromAction" value="<?php echo $_GET['fromAction']; ?>
" /></td>
  </tr>
</table>
</form>
</body>
</html>