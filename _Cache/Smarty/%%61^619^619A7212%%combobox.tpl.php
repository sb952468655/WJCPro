<?php /* Smarty version 2.6.10, created on 2014-11-24 11:17:08
         compiled from Main/combobox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/combobox.tpl', 2, false),array('function', 'webcontrol', 'Main/combobox.tpl', 4, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%61^619^619A7212%%combobox.tpl.inc'] = 'ae02b3733e00b0f435a8b1b2fe4dae5b'; ?>    <div class="form-group">
        <label for="<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])); ?>
" class="col-sm-3 control-label lableMain lableMain"><?php echo $this->_tpl_vars['item']['title']; ?>
:</label>
        <div class="col-sm-7">
        	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:ae02b3733e00b0f435a8b1b2fe4dae5b#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btCombobox','itemName' => ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])),'value' => $this->_tpl_vars['item']['value'],'disabled' => $this->_tpl_vars['item']['disabled'],'readonly' => $this->_tpl_vars['item']['readonly'],'options' => $this->_tpl_vars['item']['options']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:ae02b3733e00b0f435a8b1b2fe4dae5b#0}';}?>

        </div>
    </div>