<?php /* Smarty version 2.6.10, created on 2014-11-03 10:29:46
         compiled from Main/clientpopup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/clientpopup.tpl', 2, false),array('function', 'webcontrol', 'Main/clientpopup.tpl', 4, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%7A^7A2^7A21B78C%%clientpopup.tpl.inc'] = 'bbc213a71423b4f1fa9c3db387f8e2f8'; ?> <div class="form-group">
        <label for="clientName"  class="col-sm-3 control-label lableMain"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, "客户名称") : smarty_modifier_default($_tmp, "客户名称")); ?>
:</label>
        <div class="col-sm-7">
          <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:bbc213a71423b4f1fa9c3db387f8e2f8#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btclientpopup','value' => $this->_tpl_vars['item']['value'],'clientName' => $this->_tpl_vars['item']['clientName'],'itemName' => ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key']))), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:bbc213a71423b4f1fa9c3db387f8e2f8#0}';}?>

        </div>
 </div>