<?php /* Smarty version 2.6.10, created on 2014-11-05 20:12:34
         compiled from Print.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%22^228^2282AE22%%Print.tpl.inc'] = 'cbc1b88ea1bac01d23c2179a187a0403';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Print.tpl', 6, false),array('function', 'math', 'Print.tpl', 93, false),array('modifier', 'count', 'Print.tpl', 16, false),array('modifier', 'json_encode', 'Print.tpl', 57, false),array('modifier', 'default', 'Print.tpl', 92, false),array('modifier', 'is_string', 'Print.tpl', 145, false),array('modifier', 'explode', 'Print.tpl', 155, false),array('modifier', 'date_format', 'Print.tpl', 184, false),)), $this); ?>
<?php
function _smarty_tplfunc_cbc1b88ea1bac01d23c2179a187a0403_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Print/LodopFuncs.js"), $_smarty);
}


function _smarty_tplfunc_cbc1b88ea1bac01d23c2179a187a0403_1(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'GetAppInf','varName' => 'compName'), $_smarty);
}



?>
