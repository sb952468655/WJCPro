<?php /* Smarty version 2.6.10, created on 2014-11-21 14:16:22
         compiled from Trade/PrintXiangdao.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Trade/PrintXiangdao.tpl', 5, false),array('function', 'url', 'Trade/PrintXiangdao.tpl', 24, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%75^75D^75D82783%%PrintXiangdao.tpl.inc'] = '05be9975aa8b22c28f56c9fcc613d811'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:05be9975aa8b22c28f56c9fcc613d811#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:05be9975aa8b22c28f56c9fcc613d811#0}';}?>

<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php echo '
<script language="javascript">
$(function(){
	$(\'a\').click(function(){
		//当点击url 之后,向导界面自动关闭
		//if(!window.opener) window.parent.tb_remove();
	});
});
</script>
<style type="text/css">
a { color:#00C; text-decoration:none}
table tr td { height:30px; text-align:left;}
</style>
'; ?>

</head>

<body>
<form id="form1" name="form1" method="post" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:05be9975aa8b22c28f56c9fcc613d811#1}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'PrintXiangdao'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:05be9975aa8b22c28f56c9fcc613d811#1}';}?>
" target="_blank">
  <table border="0" cellpadding="1" cellspacing="1" align="center">
  <?php $_from = $this->_tpl_vars['url']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr>
      <td><li><?php echo $this->_tpl_vars['item']; ?>
</li></td>
    </tr>
   <?php endforeach; endif; unset($_from); ?>
    <tr>
      <td><label>
        <input type="button" name="button" id="button" value="  取 消  " onclick='if(!window.opener) window.parent.tb_remove()'/>
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>