<?php /* Smarty version 2.6.10, created on 2014-11-03 09:39:42
         compiled from Main/popup.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/popup.tpl', 2, false),array('function', 'webcontrol', 'Main/popup.tpl', 4, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%32^328^3281DF1C%%popup.tpl.inc'] = 'ab26530f7f82b978741ba8a677f5c6ab'; ?>    <div class="form-group">
        <label for="<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])); ?>
" class="col-sm-3 control-label lableMain"><?php echo $this->_tpl_vars['item']['title']; ?>
:</label>
        <div class="col-sm-7">
          <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:ab26530f7f82b978741ba8a677f5c6ab#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btPopup','itemName' => ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])),'value' => $this->_tpl_vars['item']['value'],'disabled' => $this->_tpl_vars['item']['disabled'],'readonly' => $this->_tpl_vars['item']['readonly'],'text' => $this->_tpl_vars['item']['text'],'url' => $this->_tpl_vars['item']['url'],'textFld' => $this->_tpl_vars['item']['textFld'],'hiddenFld' => $this->_tpl_vars['item']['hiddenFld'],'dialogWidth' => $this->_tpl_vars['item']['dialogWidth']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:ab26530f7f82b978741ba8a677f5c6ab#0}';}?>

        </div>
    </div>