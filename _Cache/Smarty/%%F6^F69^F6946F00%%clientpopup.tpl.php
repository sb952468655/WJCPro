<?php /* Smarty version 2.6.10, created on 2014-10-30 13:50:56
         compiled from Main2Son/clientpopup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/clientpopup.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/clientpopup.tpl', 5, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%F6^F69^F6946F00%%clientpopup.tpl.inc'] = 'c73b719936d6354c50998b02dbbe7144'; ?><div class="col-xs-4">
    <div class="form-group">
        <label for="clientName"  class="col-sm-3 control-label lableMain"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, "客户名称") : smarty_modifier_default($_tmp, "客户名称")); ?>
:</label>
        <div class="col-sm-9">
          <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:c73b719936d6354c50998b02dbbe7144#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btclientpopup','value' => $this->_tpl_vars['item']['value'],'clientName' => $this->_tpl_vars['item']['clientName'],'itemName' => ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key']))), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:c73b719936d6354c50998b02dbbe7144#0}';}?>

        </div>
    </div>
</div>