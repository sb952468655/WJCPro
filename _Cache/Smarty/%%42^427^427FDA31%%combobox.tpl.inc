<?php /* Smarty version 2.6.10, created on 2014-11-03 09:57:57
         compiled from Main2Son/combobox.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%42^427^427FDA31%%combobox.tpl.inc'] = 'cd905d6a41807b47585dbb8cba0dc2a3';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/combobox.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/combobox.tpl', 5, false),)), $this); ?>
<?php
function _smarty_tplfunc_cd905d6a41807b47585dbb8cba0dc2a3_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btCombobox','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'value' => $_smarty->_tpl_vars['item']['value'],'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly'],'options' => $_smarty->_tpl_vars['item']['options']), $_smarty);
}



?>
