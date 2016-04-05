<?php /* Smarty version 2.6.10, created on 2014-11-03 09:58:34
         compiled from Jichu/ClientTaitou.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%29^292^292E1A8D%%ClientTaitou.tpl.inc'] = 'b218520cda9a1a86934a3d09579513c1';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Jichu/ClientTaitou.tpl', 6, false),array('function', 'url', 'Jichu/ClientTaitou.tpl', 53, false),)), $this); ?>
<?php
function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_1(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_2(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_3(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_4(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_5(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_6(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_7(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_8(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisPopup.js"), $_smarty);
}


function _smarty_tplfunc_b218520cda9a1a86934a3d09579513c1_9(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'saveTaitou'), $_smarty);
}



?>
