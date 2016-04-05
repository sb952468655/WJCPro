<?php /* Smarty version 2.6.10, created on 2015-12-24 16:54:39
         compiled from Main2Son/btnCommon.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%13^13A^13AA502E%%btnCommon.tpl.inc'] = 'e38402a4c59952b64079ad729fb5e500';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/btnCommon.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/btnCommon.tpl', 5, false),)), $this); ?>
<?php
function _smarty_tplfunc_e38402a4c59952b64079ad729fb5e500_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btBtnCommon','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'value' => $_smarty->_tpl_vars['item']['value'],'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly'],'text' => $_smarty->_tpl_vars['item']['text'],'url' => $_smarty->_tpl_vars['item']['url'],'textFld' => $_smarty->_tpl_vars['item']['textFld'],'hiddenFld' => $_smarty->_tpl_vars['item']['hiddenFld'],'dialogWidth' => $_smarty->_tpl_vars['item']['dialogWidth']), $_smarty);
}



?>
