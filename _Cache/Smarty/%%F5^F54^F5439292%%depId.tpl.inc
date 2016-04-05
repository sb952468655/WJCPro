<?php /* Smarty version 2.6.10, created on 2016-03-21 16:11:07
         compiled from Search/depId.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%F5^F54^F5439292%%depId.tpl.inc'] = 'aaccb78d77b4d8b1732273b54bf712fd';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/depId.tpl', 2, false),)), $this); ?>
<?php
function _smarty_tplfunc_aaccb78d77b4d8b1732273b54bf712fd_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'TmisOptions','model' => 'Jichu_Department','selected' => $_smarty->_tpl_vars['arr_condition']['depId'],'emptyText' => '选择部门'), $_smarty);
}



?>
