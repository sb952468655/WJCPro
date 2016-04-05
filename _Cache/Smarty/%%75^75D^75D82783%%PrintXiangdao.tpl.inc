<?php /* Smarty version 2.6.10, created on 2014-11-21 14:16:22
         compiled from Trade/PrintXiangdao.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%75^75D^75D82783%%PrintXiangdao.tpl.inc'] = '05be9975aa8b22c28f56c9fcc613d811';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Trade/PrintXiangdao.tpl', 5, false),array('function', 'url', 'Trade/PrintXiangdao.tpl', 24, false),)), $this); ?>
<?php
function _smarty_tplfunc_05be9975aa8b22c28f56c9fcc613d811_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $_smarty);
}


function _smarty_tplfunc_05be9975aa8b22c28f56c9fcc613d811_1(&$_smarty)
{
echo $_smarty->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'PrintXiangdao'), $_smarty);
}



?>
