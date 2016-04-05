<?php /* Smarty version 2.6.10, created on 2014-11-03 09:57:57
         compiled from Main2Son/combobox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/combobox.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/combobox.tpl', 5, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%42^427^427FDA31%%combobox.tpl.inc'] = 'cd905d6a41807b47585dbb8cba0dc2a3'; ?><div class="col-xs-4">
    <div class="form-group">
        <label for="<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])); ?>
" class="col-sm-3 control-label lableMain lableMain"><?php echo $this->_tpl_vars['item']['title']; ?>
:</label>
        <div class="col-sm-9">
        	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cd905d6a41807b47585dbb8cba0dc2a3#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btCombobox','itemName' => ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])),'value' => $this->_tpl_vars['item']['value'],'disabled' => $this->_tpl_vars['item']['disabled'],'readonly' => $this->_tpl_vars['item']['readonly'],'options' => $this->_tpl_vars['item']['options']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cd905d6a41807b47585dbb8cba0dc2a3#0}';}?>

        </div>
    </div>
</div>