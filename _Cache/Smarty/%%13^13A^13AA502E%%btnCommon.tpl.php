<?php /* Smarty version 2.6.10, created on 2015-12-24 16:54:39
         compiled from Main2Son/btnCommon.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/btnCommon.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/btnCommon.tpl', 5, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%13^13A^13AA502E%%btnCommon.tpl.inc'] = 'e38402a4c59952b64079ad729fb5e500'; ?><div class="col-xs-4">
    <div class="form-group">
        <label for="<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])); ?>
" class="col-sm-3 control-label lableMain"><?php echo $this->_tpl_vars['item']['title']; ?>
:</label>
        <div class="col-sm-9">
          <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e38402a4c59952b64079ad729fb5e500#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btBtnCommon','itemName' => ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])),'value' => $this->_tpl_vars['item']['value'],'disabled' => $this->_tpl_vars['item']['disabled'],'readonly' => $this->_tpl_vars['item']['readonly'],'text' => $this->_tpl_vars['item']['text'],'url' => $this->_tpl_vars['item']['url'],'textFld' => $this->_tpl_vars['item']['textFld'],'hiddenFld' => $this->_tpl_vars['item']['hiddenFld'],'dialogWidth' => $this->_tpl_vars['item']['dialogWidth']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e38402a4c59952b64079ad729fb5e500#0}';}?>

        </div>
    </div>
</div>