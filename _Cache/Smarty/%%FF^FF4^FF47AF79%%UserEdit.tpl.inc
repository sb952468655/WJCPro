<?php /* Smarty version 2.6.10, created on 2016-03-31 17:55:59
         compiled from Acm/UserEdit.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%FF^FF4^FF47AF79%%UserEdit.tpl.inc'] = '71ab049620db2e5124e0c7c45cc29571';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Acm/UserEdit.tpl', 5, false),array('function', 'url', 'Acm/UserEdit.tpl', 51, false),)), $this); ?>
<?php
function _smarty_tplfunc_71ab049620db2e5124e0c7c45cc29571_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $_smarty);
}


function _smarty_tplfunc_71ab049620db2e5124e0c7c45cc29571_1(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $_smarty);
}


function _smarty_tplfunc_71ab049620db2e5124e0c7c45cc29571_2(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/EditCommon.css"), $_smarty);
}


function _smarty_tplfunc_71ab049620db2e5124e0c7c45cc29571_3(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/validate.css"), $_smarty);
}


function _smarty_tplfunc_71ab049620db2e5124e0c7c45cc29571_4(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'save'), $_smarty);
}



?>
