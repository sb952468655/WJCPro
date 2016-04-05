<?php /* Smarty version 2.6.10, created on 2014-10-30 13:50:56
         compiled from Trade/otherInfoTpl.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Trade/otherInfoTpl.tpl', 12, false),array('modifier', 'cat', 'Trade/otherInfoTpl.tpl', 44, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%9B^9BC^9BC03935%%otherInfoTpl.tpl.inc'] = '38c9a64310ec90fda6192e69386e7b26'; ?><!--其他费用信息-->
<div class="panel panel-info">
  <div class="panel-heading"><h3 class="panel-title" style="text-align:left;">其他费用登记</h3></div>
  <div class="panel-body" style="overflow:auto;max-height:320px;">
  <div class="table-responsive" style="margin-top:-15px;">
    <table class="table table-condensed table-striped" id='table_else'>
      <thead>
        <tr>
          <?php $_from = $this->_tpl_vars['qitaSon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <?php if ($this->_tpl_vars['item']['type'] != 'bthidden'): ?>
            <?php if ($this->_tpl_vars['item']['type'] == 'btBtnRemove'): ?>
              <th><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:38c9a64310ec90fda6192e69386e7b26#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btBtnAdd'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:38c9a64310ec90fda6192e69386e7b26#0}';}?>
</th>
            <?php else: ?>
            <th style='white-space:nowrap;'><?php echo $this->_tpl_vars['item']['title']; ?>
</th>
            <?php endif; ?>
          <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>
        </tr>   
      </thead>
      <tbody>
        <?php $_from = $this->_tpl_vars['row4sSon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
        <tr class='trRow'>
          <?php $_from = $this->_tpl_vars['qitaSon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <?php if ($this->_tpl_vars['item']['type'] != 'bthidden'): ?>
            <td><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:38c9a64310ec90fda6192e69386e7b26#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => $this->_tpl_vars['item']['type'],'value' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['value'],'kind' => $this->_tpl_vars['item']['kind'],'itemName' => $this->_tpl_vars['item']['name'],'readonly' => $this->_tpl_vars['item']['readonly'],'disabled' => $this->_tpl_vars['item']['disabled'],'width' => $this->_tpl_vars['item']['width'],'options' => $this->_tpl_vars['item']['options']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:38c9a64310ec90fda6192e69386e7b26#1}';}?>
</td>
            <?php else: ?>
              <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:38c9a64310ec90fda6192e69386e7b26#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => $this->_tpl_vars['item']['type'],'value' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['value'],'itemName' => $this->_tpl_vars['item']['name'],'readonly' => $this->_tpl_vars['item']['readonly'],'disabled' => $this->_tpl_vars['item']['disabled']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:38c9a64310ec90fda6192e69386e7b26#2}';}?>

            <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?>
        </tr>  
        <?php endforeach; endif; unset($_from); ?>    
      </tbody>
    </table>
    </div>
  </div>
  </div>
</div>
<!-- 其他备注信息 -->
<div class="panel panel-info">
  <div class="panel-heading"><h3 class="panel-title" style="text-align:left;">合同备注</h3></div>
  <div class="panel-body">
    <div class="row">      
      <?php $_from = $this->_tpl_vars['arr_memo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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
<!-- 合同条款信息 -->
<div class="panel panel-info">
  <div class="panel-heading"><h3 class="panel-title" style="text-align:left;">合同条款</h3></div>
  <div class="panel-body">
    <div class="row">      
      <?php $_from = $this->_tpl_vars['arr_item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
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