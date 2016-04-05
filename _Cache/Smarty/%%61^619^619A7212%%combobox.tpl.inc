<?php /* Smarty version 2.6.10, created on 2014-11-24 11:17:08
         compiled from Main/combobox.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%61^619^619A7212%%combobox.tpl.inc'] = 'ae02b3733e00b0f435a8b1b2fe4dae5b';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/combobox.tpl', 2, false),array('function', 'webcontrol', 'Main/combobox.tpl', 4, false),)), $this); ?>
<?php
function _smarty_tplfunc_ae02b3733e00b0f435a8b1b2fe4dae5b_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btCombobox','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'value' => $_smarty->_tpl_vars['item']['value'],'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly'],'options' => $_smarty->_tpl_vars['item']['options']), $_smarty);
}



?>
