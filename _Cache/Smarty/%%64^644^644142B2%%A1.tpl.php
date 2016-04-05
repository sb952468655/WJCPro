<?php /* Smarty version 2.6.10, created on 2014-11-03 09:39:42
         compiled from Main/A1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'Main/A1.tpl', 34, false),array('modifier', 'default', 'Main/A1.tpl', 34, false),array('modifier', 'cat', 'Main/A1.tpl', 42, false),array('modifier', 'is_string', 'Main/A1.tpl', 68, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%64^644^644142B2%%A1.tpl.inc'] = 'c342333f8965d7a131ec6cab8fa84c02'; ?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
<?php echo '
<style type="text/css">

body{margin-left:5px; margin-top:5px; margin-right: 8px;}
.btns { position:absolute; right:16px; top:1px; height:28px;}
.relative { position:relative;}
.frbtn {position:absolute; top:1px; right:0px; height:28px;z-index:1000;}
.pd5{ padding-left:5px;}
#heji { padding-left:20px; height:20px; line-height:20px; margin-bottom:5px;}
label.error {
  color: #FF0000;
  font-style: normal;
	position:absolute;
	right:-50px;
	top:5px;
}
.lableMain {
  padding-left: 2px !important;
  padding-right: 2px !important;
}
</style>
'; ?>

<body>
<div class='container'>
  <form name="form1" id="form1" class="form-horizontal" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:c342333f8965d7a131ec6cab8fa84c02#0}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => ((is_array($_tmp=@$this->_tpl_vars['form']['action'])) ? $this->_run_mod_handler('default', true, $_tmp, 'save') : smarty_modifier_default($_tmp, 'save'))), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:c342333f8965d7a131ec6cab8fa84c02#0}';}?>
" method="post" <?php if ($this->_tpl_vars['form']['upload'] == true): ?>enctype="multipart/form-data"<?php endif; ?>>

  <!-- 主表字段登记区域 -->
  <div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title" style="text-align:left;"><?php echo $this->_tpl_vars['title']; ?>
</h3></div>
    <div class="panel-body">
      <div class="row">
        <?php $_from = $this->_tpl_vars['fldMain']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp="Main/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['item']['type']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['item']['type'])))) ? $this->_run_mod_handler('cat', true, $_tmp, ".tpl") : smarty_modifier_cat($_tmp, ".tpl")), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endforeach; endif; unset($_from); ?>
      </div>
    </div>
  </div>

  <?php if ($this->_tpl_vars['otherInfoTpl'] != ''): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['otherInfoTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <input class="btn btn-primary" type="submit" id="Submit" name="Submit" value=" 保 存 ">
				<?php echo $this->_tpl_vars['other_button']; ?>

        <input class="btn btn-default" type="reset" id="Reset" name="Reset" value=" 重 置 ">
    </div>
  </div>
  <div style="clear:both;"></div>
  <input type='hidden' name='fromAction' value='<?php echo ((is_array($_tmp=@$_GET['fromAction'])) ? $this->_run_mod_handler('default', true, $_tmp, 'right') : smarty_modifier_default($_tmp, 'right')); ?>
' />
  <input type='hidden' name='fromController' value='<?php echo ((is_array($_tmp=@$this->_tpl_vars['fromController'])) ? $this->_run_mod_handler('default', true, $_tmp, @$_GET['controller']) : smarty_modifier_default($_tmp, @$_GET['controller'])); ?>
' />
  </form>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Main2Son/_jsCommon.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if ($this->_tpl_vars['sonTpl']): ?>
  <?php if (is_string($this->_tpl_vars['sonTpl']) == 1): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sonTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php else: ?>
    <?php $_from = $this->_tpl_vars['sonTpl']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['js_item']):
?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['js_item'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endforeach; endif; unset($_from); ?>
  <?php endif; ?>
<?php endif; ?>
</body>
</html>