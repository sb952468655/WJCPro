<?php /* Smarty version 2.6.10, created on 2014-10-30 14:21:19
         compiled from Main2Son/popup.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%46^46D^46D06EA8%%popup.tpl.inc'] = 'b6e305d739b76f8814f7014bce8f858a';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/popup.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/popup.tpl', 5, false),)), $this); ?>
<?php
function _smarty_tplfunc_b6e305d739b76f8814f7014bce8f858a_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btPopup','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'value' => $_smarty->_tpl_vars['item']['value'],'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly'],'text' => $_smarty->_tpl_vars['item']['text'],'url' => $_smarty->_tpl_vars['item']['url'],'textFld' => $_smarty->_tpl_vars['item']['textFld'],'hiddenFld' => $_smarty->_tpl_vars['item']['hiddenFld'],'dialogWidth' => $_smarty->_tpl_vars['item']['dialogWidth']), $_smarty);
}



?>
