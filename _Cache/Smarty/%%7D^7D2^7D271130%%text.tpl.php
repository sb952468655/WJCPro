<?php /* Smarty version 2.6.10, created on 2014-10-30 13:50:56
         compiled from Main2Son/text.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/text.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/text.tpl', 5, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%7D^7D2^7D271130%%text.tpl.inc'] = '9b2b139d76e224c072ba29f699990c2e'; ?><div class="col-xs-4">
    <div class="form-group">
        <label for="<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])); ?>
" class="col-sm-3 control-label lableMain lableMain"><?php echo $this->_tpl_vars['item']['title']; ?>
:</label>
        <div class="col-sm-9">
        	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9b2b139d76e224c072ba29f699990c2e#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'bttext','itemName' => ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])),'value' => $this->_tpl_vars['item']['value'],'disabled' => $this->_tpl_vars['item']['disabled'],'readonly' => $this->_tpl_vars['item']['readonly'],'addonPre' => $this->_tpl_vars['item']['addonPre'],'addonEnd' => $this->_tpl_vars['item']['addonEnd']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9b2b139d76e224c072ba29f699990c2e#0}';}?>

        </div>
    </div>
</div>