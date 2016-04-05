<?php /* Smarty version 2.6.10, created on 2014-10-28 13:13:06
         compiled from Search/traderId.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%91^91F^91F65C8E%%traderId.tpl.inc'] = 'c25014d2cad3223fae6f2bd974817ec9';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/traderId.tpl', 2, false),)), $this); ?>
<?php
function _smarty_tplfunc_c25014d2cad3223fae6f2bd974817ec9_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Traderoptions','model' => 'Jichu_Employ','selected' => $_smarty->_tpl_vars['arr_condition']['traderId'],'emptyText' => '选择业务员'), $_smarty);
}



?>
