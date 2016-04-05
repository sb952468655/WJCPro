<?php /* Smarty version 2.6.10, created on 2014-11-12 16:58:01
         compiled from Main/A.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%3C^3CB^3CBC77B7%%A.tpl.inc'] = 'd04ce75d1d3cccd2755f578a86a91b6c';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Main/A.tpl', 8, false),array('function', 'url', 'Main/A.tpl', 35, false),array('modifier', 'default', 'Main/A.tpl', 35, false),array('modifier', 'cat', 'Main/A.tpl', 43, false),array('modifier', 'json_encode', 'Main/A.tpl', 70, false),)), $this); ?>
<?php
function _smarty_tplfunc_d04ce75d1d3cccd2755f578a86a91b6c_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $_smarty);
}


function _smarty_tplfunc_d04ce75d1d3cccd2755f578a86a91b6c_1(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $_smarty);
}


function _smarty_tplfunc_d04ce75d1d3cccd2755f578a86a91b6c_2(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css"), $_smarty);
}


function _smarty_tplfunc_d04ce75d1d3cccd2755f578a86a91b6c_3(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => ((is_array($_tmp=@$_smarty->_tpl_vars['form']['action'])) ? $_smarty->_run_mod_handler('default', true, $_tmp, 'save') : smarty_modifier_default($_tmp, 'save'))), $_smarty);
}



?>
