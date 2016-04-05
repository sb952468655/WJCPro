<?php /* Smarty version 2.6.10, created on 2014-11-03 09:58:16
         compiled from Main/file.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%A1^A1B^A1BD9D2E%%file.tpl.inc'] = 'eda59b6c5d606238c47bae2b41dbb363';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/file.tpl', 2, false),array('function', 'webcontrol', 'Main/file.tpl', 4, false),)), $this); ?>
<?php
function _smarty_tplfunc_eda59b6c5d606238c47bae2b41dbb363_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'btfile','itemName' => ((is_array($_tmp=@$_smarty->_tpl_vars['item']['name'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, @$_smarty->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$_smarty->_tpl_vars['key'])),'disabled' => $_smarty->_tpl_vars['item']['disabled'],'readonly' => $_smarty->_tpl_vars['item']['readonly'],'addonPre' => $_smarty->_tpl_vars['item']['addonPre'],'addonEnd' => $_smarty->_tpl_vars['item']['addonEnd']), $_smarty);
}



?>
