<?php /* Smarty version 2.6.10, created on 2014-10-30 14:25:49
         compiled from Search/jiagonghuId.tpl */

$this->_cache_serials['Lib/App/../../_Cache/Smarty\%%66^661^6616116C%%jiagonghuId.tpl.inc'] = 'eb7dfc9621f632b2420f507843c5312d';

?><?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/jiagonghuId.tpl', 2, false),)), $this); ?>
<?php
function _smarty_tplfunc_eb7dfc9621f632b2420f507843c5312d_0(&$_smarty)
{
echo $_smarty->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'jichu_jiagonghu','selected' => $_smarty->_tpl_vars['arr_condition']['jiagonghuId'],'emptyText' => '选择加工户','condition' => 'isSupplier=0'), $_smarty);
}



?>
