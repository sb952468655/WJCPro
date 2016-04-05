<?php /* Smarty version 2.6.10, created on 2014-11-03 09:39:42
         compiled from Main/calendar.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%67^678^678F1396%%calendar.tpl.inc'] = '1b1a4753f7e623f9fbb6bd6cf19a80dd';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/calendar.tpl', 2, false),array('function', 'webcontrol', 'Main/calendar.tpl', 4, false),)), $this); ?>
<?php
function _smarty_tplfunc_1b1a4753f7e623f9fbb6bd6cf19a80dd_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btcalendar','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'value' => $_smarty->_tpl_vars['item']['value'],'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly']), $_smarty);
}



?>
