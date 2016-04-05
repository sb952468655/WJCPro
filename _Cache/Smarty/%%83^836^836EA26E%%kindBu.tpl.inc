<?php /* Smarty version 2.6.10, created on 2014-10-30 13:51:31
         compiled from Search/kindBu.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%83^836^836EA26E%%kindBu.tpl.inc'] = 'd59c0ab70ebb984884cdcb43bf11ad37';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/kindBu.tpl', 2, false),)), $this); ?>
<?php
function _smarty_tplfunc_d59c0ab70ebb984884cdcb43bf11ad37_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'jichu_product','selected' => $_smarty->_tpl_vars['arr_condition']['kindBu'],'emptyText' => '布分类','valueKey' => 'kind','valueField' => 'kind','condition' => 'type=1'), $_smarty);
}



?>
