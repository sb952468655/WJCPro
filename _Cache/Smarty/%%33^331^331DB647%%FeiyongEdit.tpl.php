<?php /* Smarty version 2.6.10, created on 2014-11-08 12:54:24
         compiled from Jichu/FeiyongEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'Jichu/FeiyongEdit.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%33^331^331DB647%%FeiyongEdit.tpl.inc'] = 'c1e8cf5ae6d6d7cde9f29555388b26a5'; ?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<link href="Resource/Css/EditCommon.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<?php echo '
<script language="javascript">
$(function(){
	$(\'#form1\').validate({
		rules:{		
			\'feiyongName\':\'required\'
		}
	});
});
</script>
'; ?>

</head>
<body>
<form name="form1" id="form1" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:c1e8cf5ae6d6d7cde9f29555388b26a5#0}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:c1e8cf5ae6d6d7cde9f29555388b26a5#0}';}?>
" method="post">
<input name="id" type="hidden" id="id" value="<?php echo $this->_tpl_vars['aRow']['id']; ?>
">
<table id="mainTable">
<td class="title">费用名称：</td>
<td><input name="feiyongName" type="text" id="feiyongName" value="<?php echo $this->_tpl_vars['aRow']['feiyongName']; ?>
"/><span class="bitian">*</span></td>
</tr>

</table>

<table id="buttonTable">
	<tr>
		<td>
		<!--<input type="submit" id="Submit" name="Submit" value='保存并新增下一个'>-->
		<input type="submit" id="Submit" name="Submit" value='保存'>
		<input type="button" id="Back" name="Back" value='返回' onClick="window.location.href='<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:c1e8cf5ae6d6d7cde9f29555388b26a5#1}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:c1e8cf5ae6d6d7cde9f29555388b26a5#1}';}?>
&action=right'">
		</td>
	</tr>
</table>
</form>
</body>
</html>