<?php /* Smarty version 2.6.10, created on 2016-03-31 17:55:38
         compiled from Acm/RoleEdit.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%1B^1B8^1B871488%%RoleEdit.tpl.inc'] = 'd38943880bd60c3cdbd797dc8b3cddb9';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Acm/RoleEdit.tpl', 4, false),array('function', 'webcontrol', 'Acm/RoleEdit.tpl', 6, false),array('function', 'url', 'Acm/RoleEdit.tpl', 29, false),)), $this); ?>
<?php
function _smarty_tplfunc_d38943880bd60c3cdbd797dc8b3cddb9_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $_smarty);
}


function _smarty_tplfunc_d38943880bd60c3cdbd797dc8b3cddb9_1(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $_smarty);
}


function _smarty_tplfunc_d38943880bd60c3cdbd797dc8b3cddb9_2(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $_smarty);
}


function _smarty_tplfunc_d38943880bd60c3cdbd797dc8b3cddb9_3(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $_smarty);
}


function _smarty_tplfunc_d38943880bd60c3cdbd797dc8b3cddb9_4(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $_smarty);
}


function _smarty_tplfunc_d38943880bd60c3cdbd797dc8b3cddb9_5(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => 'Acm_Role','action' => 'right'), $_smarty);
}



?>
