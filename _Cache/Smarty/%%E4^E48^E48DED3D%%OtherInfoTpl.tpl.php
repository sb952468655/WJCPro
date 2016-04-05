<?php /* Smarty version 2.6.10, created on 2014-10-30 14:20:17
         compiled from Main2Son/OtherInfoTpl.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/OtherInfoTpl.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/OtherInfoTpl.tpl', 12, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%E4^E48^E48DED3D%%OtherInfoTpl.tpl.inc'] = '64c3879de5dbfc2dbb4044a9fe6ce637'; ?><!--其他费用信息-->
<div class="panel panel-info">
  <div class="panel-heading"><h3 class="panel-title" style="text-align:left;"><?php echo ((is_array($_tmp=@$this->_tpl_vars['otherInfo'])) ? $this->_run_mod_handler('default', true, $_tmp, '其他信息编辑') : smarty_modifier_default($_tmp, '其他信息编辑')); ?>
</h3></div>
  <div class="panel-body" style="overflow:auto;max-height:320px;">
    <div class="table-responsive" style="margin-top:-15px;">
      <table class="table table-condensed table-striped" id='table_else'>
        <thead>
          <tr>
            <?php $_from = $this->_tpl_vars['qitaSon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <?php if ($this->_tpl_vars['item']['type'] != 'bthidden'): ?>
              <?php if ($this->_tpl_vars['item']['type'] == 'btBtnRemove' || $this->_tpl_vars['item']['type'] == 'btBtnCopy'): ?>
                <th><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:64c3879de5dbfc2dbb4044a9fe6ce637#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btBtnAdd'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:64c3879de5dbfc2dbb4044a9fe6ce637#0}';}?>
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
              <td><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:64c3879de5dbfc2dbb4044a9fe6ce637#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => $this->_tpl_vars['item']['type'],'value' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['value'],'kind' => $this->_tpl_vars['item']['kind'],'itemName' => $this->_tpl_vars['item']['name'],'readonly' => $this->_tpl_vars['item']['readonly'],'disabled' => $this->_tpl_vars['item']['disabled'],'model' => $this->_tpl_vars['item']['model'],'options' => $this->_tpl_vars['item']['options'],'checked' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['checked'],'url' => $this->_tpl_vars['item']['url'],'textFld' => $this->_tpl_vars['item']['textFld'],'hiddenFld' => $this->_tpl_vars['item']['hiddenFld'],'text' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['text'],'inTable' => $this->_tpl_vars['item']['inTable'],'condition' => $this->_tpl_vars['item']['condition'],'dialogWidth' => $this->_tpl_vars['item']['dialogWidth'],'width' => $this->_tpl_vars['item']['width'],'style' => $this->_tpl_vars['item']['style']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:64c3879de5dbfc2dbb4044a9fe6ce637#1}';}?>
</td>
              <?php else: ?>
                <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:64c3879de5dbfc2dbb4044a9fe6ce637#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => $this->_tpl_vars['item']['type'],'value' => $this->_tpl_vars['item1'][$this->_tpl_vars['key']]['value'],'itemName' => $this->_tpl_vars['item']['name'],'readonly' => $this->_tpl_vars['item']['readonly'],'disabled' => $this->_tpl_vars['item']['disabled']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:64c3879de5dbfc2dbb4044a9fe6ce637#2}';}?>

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