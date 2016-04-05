<?php /* Smarty version 2.6.10, created on 2014-11-03 10:29:46
         compiled from Main/clientpopup.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%7A^7A2^7A21B78C%%clientpopup.tpl.inc'] = 'bbc213a71423b4f1fa9c3db387f8e2f8';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/clientpopup.tpl', 2, false),array('function', 'webcontrol', 'Main/clientpopup.tpl', 4, false),)), $this); ?>
<?php
function _smarty_tplfunc_bbc213a71423b4f1fa9c3db387f8e2f8_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btclientpopup','value' => $_smarty->_tpl_vars['item']['value'],'clientName' => $_smarty->_tpl_vars['item']['clientName'],'itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key']))), $_smarty);
}



?>
