<?php /* Smarty version 2.6.10, created on 2014-10-30 13:51:14
         compiled from _Search.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%FC^FCA^FCAC0DF5%%_Search.tpl.inc'] = 'cfd0ff1195d9d6bf45ef253733396a88';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', '_Search.tpl', 11, false),array('modifier', 'default', '_Search.tpl', 24, false),array('function', 'url', '_Search.tpl', 22, false),)), $this); ?>
<?php
function _smarty_tplfunc_cfd0ff1195d9d6bf45ef253733396a88_0(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'add','fromAction' => $_GET['action']), $_smarty);
}


function _smarty_tplfunc_cfd0ff1195d9d6bf45ef253733396a88_1(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'list'), $_smarty);
}



?>
