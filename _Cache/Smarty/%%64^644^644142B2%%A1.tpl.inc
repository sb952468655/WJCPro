<?php /* Smarty version 2.6.10, created on 2014-11-03 09:39:42
         compiled from Main/A1.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%64^644^644142B2%%A1.tpl.inc'] = 'c342333f8965d7a131ec6cab8fa84c02';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'url', 'Main/A1.tpl', 34, false),array('modifier', 'default', 'Main/A1.tpl', 34, false),array('modifier', 'cat', 'Main/A1.tpl', 42, false),array('modifier', 'is_string', 'Main/A1.tpl', 68, false),)), $this); ?>
<?php
function _smarty_tplfunc_c342333f8965d7a131ec6cab8fa84c02_0(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => ((is_array($_tmp=@$_smarty->_tpl_vars['form']['action'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, 'save') : smarty_modifier_default($_tmp, 'save'))), $_smarty);
}



?>
