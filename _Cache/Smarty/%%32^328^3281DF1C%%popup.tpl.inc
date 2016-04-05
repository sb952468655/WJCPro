<?php /* Smarty version 2.6.10, created on 2014-11-03 09:39:42
         compiled from Main/popup.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%32^328^3281DF1C%%popup.tpl.inc'] = 'ab26530f7f82b978741ba8a677f5c6ab';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/popup.tpl', 2, false),array('function', 'webcontrol', 'Main/popup.tpl', 4, false),)), $this); ?>
<?php
function _smarty_tplfunc_ab26530f7f82b978741ba8a677f5c6ab_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btPopup','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'value' => $_smarty->_tpl_vars['item']['value'],'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly'],'text' => $_smarty->_tpl_vars['item']['text'],'url' => $_smarty->_tpl_vars['item']['url'],'textFld' => $_smarty->_tpl_vars['item']['textFld'],'hiddenFld' => $_smarty->_tpl_vars['item']['hiddenFld'],'dialogWidth' => $_smarty->_tpl_vars['item']['dialogWidth']), $_smarty);
}



?>
