<?php /* Smarty version 2.6.10, created on 2014-10-30 13:50:56
         compiled from Main2Son/clientpopup.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%F6^F69^F6946F00%%clientpopup.tpl.inc'] = 'c73b719936d6354c50998b02dbbe7144';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main2Son/clientpopup.tpl', 3, false),array('function', 'webcontrol', 'Main2Son/clientpopup.tpl', 5, false),)), $this); ?>
<?php
function _smarty_tplfunc_c73b719936d6354c50998b02dbbe7144_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btclientpopup','value' => $_smarty->_tpl_vars['item']['value'],'clientName' => $_smarty->_tpl_vars['item']['clientName'],'itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key']))), $_smarty);
}



?>
