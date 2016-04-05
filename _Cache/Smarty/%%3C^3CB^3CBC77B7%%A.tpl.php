<?php /* Smarty version 2.6.10, created on 2014-11-12 16:58:01
         compiled from Main/A.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Main/A.tpl', 8, false),array('function', 'url', 'Main/A.tpl', 35, false),array('modifier', 'default', 'Main/A.tpl', 35, false),array('modifier', 'cat', 'Main/A.tpl', 43, false),array('modifier', 'json_encode', 'Main/A.tpl', 70, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%3C^3CB^3CBC77B7%%A.tpl.inc'] = 'd04ce75d1d3cccd2755f578a86a91b6c'; ?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d04ce75d1d3cccd2755f578a86a91b6c#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d04ce75d1d3cccd2755f578a86a91b6c#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d04ce75d1d3cccd2755f578a86a91b6c#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d04ce75d1d3cccd2755f578a86a91b6c#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d04ce75d1d3cccd2755f578a86a91b6c#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d04ce75d1d3cccd2755f578a86a91b6c#2}';}?>

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
  <form name="form1" id="form1" class="form-horizontal" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:d04ce75d1d3cccd2755f578a86a91b6c#3}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => ((is_array($_tmp=@$this->_tpl_vars['form']['action'])) ? $this->_run_mod_handler('default', true, $_tmp, 'save') : smarty_modifier_default($_tmp, 'save'))), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:d04ce75d1d3cccd2755f578a86a91b6c#3}';}?>
" method="post" <?php if ($this->_tpl_vars['form']['up'] == true): ?>enctype="multipart/form-data"<?php endif; ?>>

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
        <input class="btn btn-primary" type="submit" id="Submit" name="Submit" value="保 存">
        <?php if ($this->_tpl_vars['btn']['SaveAdd'] != 'hidden'): ?>
        <input class="btn btn-default" type="submit" id="Submit" name="Submit" value="保存并新增"><?php endif; ?>
        <?php if ($this->_tpl_vars['btn']['Reset'] != 'hidden'): ?><input class="btn btn-default" type="reset" id="Reset" name="Reset" value=" 重 置 "><?php endif; ?>
    </div>
  </div>
  <div style="clear:both;"></div>
  <input type='hidden' name='fromAction' value='<?php echo ((is_array($_tmp=@$_GET['fromAction'])) ? $this->_run_mod_handler('default', true, $_tmp, 'right') : smarty_modifier_default($_tmp, 'right')); ?>
' />
  </form>
</div>
<script language="javascript" src="Resource/bootstrap/bootstrap3.0.3/js/jquery.min.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<script src="Resource/bootstrap/bootstrap3.0.3/js/bootstrap.js"></script>
<script src="Resource/bootstrap/bootstrap3.0.3/js/jeffCombobox.js"></script>

<script language="javascript"> 
var _rules = <?php echo json_encode($this->_tpl_vars['rules']); ?>
;
<?php echo '
$(function(){ 
  //表单验证
  //表单验证应该被封装起来。
  var rules = $.extend({},_rules);
  $(\'#form1\').validate({
    rules:rules,
    submitHandler : function(form){
      var r=true;
      if(typeof(beforeSubmit)=="function") {
        r = beforeSubmit();
      }
      if(!r) return;
      if($(\'[name="Submit"]\').attr(\'submits\')!=\'submiting\'){
        $(\'[name="Submit"]\').attr(\'submits\',\'submiting\');
        form.submit();
      }
    }
    // ,debug:true
    ,onfocusout:false
    ,onclick:false
    ,onkeyup:false
  });

  '; ?>

  <?php if ($this->_tpl_vars['jsPatch']):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['jsPatch'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
  <?php echo '
});
</script>
'; ?>

</body>
</html>