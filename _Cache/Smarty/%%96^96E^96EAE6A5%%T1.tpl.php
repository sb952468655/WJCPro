<?php /* Smarty version 2.6.10, created on 2014-11-27 17:01:50
         compiled from Main2Son/T1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'Main2Son/T1.tpl', 42, false),array('function', 'webcontrol', 'Main2Son/T1.tpl', 74, false),array('modifier', 'default', 'Main2Son/T1.tpl', 42, false),array('modifier', 'cat', 'Main2Son/T1.tpl', 50, false),array('modifier', 'is_string', 'Main2Son/T1.tpl', 149, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%96^96E^96EAE6A5%%T1.tpl.inc'] = '781453d784dc12c590616b1a11f03538'; ?><html>
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
.trRow input{
  min-width: 75px;
}
.form-horizontal{
  overflow: hidden;
}
</style>
'; ?>

<body>
<form name="form1" id="form1" class="form-horizontal" action="<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:781453d784dc12c590616b1a11f03538#0}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => ((is_array($_tmp=@$this->_tpl_vars['action_save'])) ? $this->_run_mod_handler('default', true, $_tmp, 'save') : smarty_modifier_default($_tmp, 'save'))), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:781453d784dc12c590616b1a11f03538#0}';}?>
" method="post">

<!-- 主表字段登记区域 -->
<div class="panel panel-info">
  <div class="panel-heading"><h3 class="panel-title" style="text-align:left;"><?php echo $this->_tpl_vars['areaMain']['title']; ?>
</h3></div>
  <div class="panel-body">
    <div class="row">
      <?php $_from = $this->_tpl_vars['areaMain']['fld']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp="Main2Son/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['item']['type']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['item']['type'])))) ? $this->_run_mod_handler('cat', true, $_tmp, ".tpl") : smarty_modifier_cat($_tmp, ".tpl")), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endforeach; endif; unset($_from); ?>
    </div>       
  </div>
</div>

<div class="panel panel-info">
<div class="panel-heading">
  <h3 class="panel-title" style="text-align:left;"><?php echo ((is_array($_tmp=@$this->_tpl_vars['sonTitle'])) ? $this->_run_mod_handler('default', true, $_tmp, '明细信息') : smarty_modifier_default($_tmp, '明细信息')); ?>
</h3>
</div>
<div class="panel-body" style="overflow:auto;max-height:320px;">
  <div class="table-responsive" style="margin-top:-15px;">
  <table class="table table-condensed table-striped" id='table_main'>
    <thead>
      <tr>
        <?php $this->assign('i', 0); ?>
        <?php $_from = $this->_tpl_vars['headSon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
        <?php if ($this->_tpl_vars['item']['type'] != 'bthidden'): ?>
                    <?php if ($this->_tpl_vars['i'] == 1): ?>
                        <?php if ($this->_tpl_vars['firstColumn']['head']): ?>
              <?php if ($this->_tpl_vars['firstColumn']['head']['type']): ?>
                <th><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:781453d784dc12c590616b1a11f03538#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => $this->_tpl_vars['firstColumn']['head']['type'],'title' => $this->_tpl_vars['firstColumn']['head']['title'],'url' => $this->_tpl_vars['firstColumn']['head']['url']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:781453d784dc12c590616b1a11f03538#1}';}?>
</th>
              <?php else: ?>
                <th style='white-space:nowrap;'><?php echo $this->_tpl_vars['firstColumn']['head']['title']; ?>
</th>
              <?php endif; ?>
            <?php elseif ($this->_tpl_vars['item']['type'] == 'btBtnRemove'): ?>              <th><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:781453d784dc12c590616b1a11f03538#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btBtnAdd'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:781453d784dc12c590616b1a11f03538#2}';}?>
</th>
            <?php else: ?>
              <th style='white-space:nowrap;'><?php echo $this->_tpl_vars['item']['title']; ?>
</th>
            <?php endif; ?>
          <?php else: ?>
              <th style='white-space:nowrap;' <?php if ($this->_tpl_vars['item']['colmd'] > 0): ?>class="col-md-<?php echo $this->_tpl_vars['item']['colmd']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['item']['title']; ?>
</th>
          <?php endif; ?>  
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </tr>   
    </thead>
    <tbody>
      <?php $_from = $this->_tpl_vars['rowsSon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
      <tr class='trRow'>
        <?php $_from = $this->_tpl_vars['headSon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <?php if ($this->_tpl_vars['item']['type'] != 'bthidden'): ?>
          <td><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:781453d784dc12c590616b1a11f03538#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => $this->_tpl_vars['item']['type'],'value' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['value'],'kind' => $this->_tpl_vars['item']['kind'],'itemName' => $this->_tpl_vars['item']['name'],'readonly' => $this->_tpl_vars['item']['readonly'],'disabled' => $this->_tpl_vars['item']['disabled'],'model' => $this->_tpl_vars['item']['model'],'options' => $this->_tpl_vars['item']['options'],'checked' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['checked'],'url' => $this->_tpl_vars['item']['url'],'textFld' => $this->_tpl_vars['item']['textFld'],'hiddenFld' => $this->_tpl_vars['item']['hiddenFld'],'text' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['text'],'inTable' => $this->_tpl_vars['item']['inTable'],'condition' => $this->_tpl_vars['item']['condition'],'dialogWidth' => $this->_tpl_vars['item']['dialogWidth'],'width' => $this->_tpl_vars['item']['width'],'style' => $this->_tpl_vars['item']['style']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:781453d784dc12c590616b1a11f03538#3}';}?>
</td>
          <?php else: ?>
            <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:781453d784dc12c590616b1a11f03538#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => $this->_tpl_vars['item']['type'],'value' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['value'],'itemName' => $this->_tpl_vars['item']['name'],'readonly' => $this->_tpl_vars['item']['readonly'],'disabled' => $this->_tpl_vars['item']['disabled']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:781453d784dc12c590616b1a11f03538#4}';}?>

          <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
      </tr>  
      <?php endforeach; endif; unset($_from); ?>    
    </tbody>
  </table>
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
<?php if ($this->_tpl_vars['guoInfoTpl'] != ''): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['guoInfoTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<div class="form-group">
  <div class="col-sm-offset-4 col-sm-8">
      <input class="btn btn-primary" type="submit" id="Submit" name="Submit" value=" 保 存 " onclick="$('#submitValue').val('保存')">
            <?php echo $this->_tpl_vars['other_button']; ?>

      <input class="btn btn-default" type="reset" id="Reset" name="Reset" value=" 重 置 ">
      <input type='hidden' name='submitValue' id='submitValue' value=''/>
      <input type='hidden' name='fromController' id='fromController' value='<?php echo ((is_array($_tmp=@$this->_tpl_vars['fromController'])) ? $this->_run_mod_handler('default', true, $_tmp, @$_GET['controller']) : smarty_modifier_default($_tmp, @$_GET['controller'])); ?>
'/>
      <input type='hidden' name='fromAction' id='fromAction' value='<?php echo ((is_array($_tmp=@$this->_tpl_vars['fromAction'])) ? $this->_run_mod_handler('default', true, $_tmp, @$_GET['action']) : smarty_modifier_default($_tmp, @$_GET['action'])); ?>
'/>
  </div>
</div>
<div style="clear:both;"></div>
</form>
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