<?php /* Smarty version 2.6.10, created on 2014-10-30 14:20:51
         compiled from Search/kindSha.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%DD^DD0^DD03B3E3%%kindSha.tpl.inc'] = 'fef8d6e1b9fe66b8e051f82dc1b801d6';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/kindSha.tpl', 2, false),)), $this); ?>
<?php
function _smarty_tplfunc_fef8d6e1b9fe66b8e051f82dc1b801d6_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'jichu_product','selected' => $_smarty->_tpl_vars['arr_condition']['kindSha'],'emptyText' => '纱分类','valueKey' => 'kind','valueField' => 'kind','condition' => 'type=0'), $_smarty);
}



?>
