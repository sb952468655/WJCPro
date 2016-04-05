<?php /* Smarty version 2.6.10, created on 2014-11-03 09:39:43
         compiled from Main/textarea.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%5B^5BD^5BD707DB%%textarea.tpl.inc'] = '3f54ccc9d6f6a410ec3641546313f609';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/textarea.tpl', 2, false),array('function', 'webcontrol', 'Main/textarea.tpl', 4, false),)), $this); ?>
<?php
function _smarty_tplfunc_3f54ccc9d6f6a410ec3641546313f609_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'bttextarea','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'value' => $_smarty->_tpl_vars['item']['value'],'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly']), $_smarty);
}



?>
