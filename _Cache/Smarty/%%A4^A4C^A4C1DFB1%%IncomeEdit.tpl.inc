<?php /* Smarty version 2.6.10, created on 2014-11-12 14:47:41
         compiled from Caiwu/Xianjin/IncomeEdit.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%A4^A4C^A4C1DFB1%%IncomeEdit.tpl.inc'] = '0d8d91d8b15e03662e6bb37b878f959d';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Caiwu/Xianjin/IncomeEdit.tpl', 7, false),array('function', 'url', 'Caiwu/Xianjin/IncomeEdit.tpl', 46, false),array('modifier', 'default', 'Caiwu/Xianjin/IncomeEdit.tpl', 60, false),array('modifier', 'date_format', 'Caiwu/Xianjin/IncomeEdit.tpl', 60, false),)), $this); ?>
<?php
function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_1(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_2(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_3(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_4(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_5(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_6(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_7(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_8(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisPopup.js"), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_9(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $_smarty);
}


function _smarty_tplfunc_0d8d91d8b15e03662e6bb37b878f959d_10(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'TmisOptions','model' => 'Caiwu_Bank','selected' => $_smarty->_tpl_vars['aRow']['bankId']), $_smarty);
}



?>
