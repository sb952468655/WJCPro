<?php /* Smarty version 2.6.10, created on 2014-10-28 13:13:06
         compiled from Search/traderId.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/traderId.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%91^91F^91F65C8E%%traderId.tpl.inc'] = 'c25014d2cad3223fae6f2bd974817ec9'; ?><select name="traderId" id="traderId">
    		<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:c25014d2cad3223fae6f2bd974817ec9#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Traderoptions','model' => 'Jichu_Employ','selected' => $this->_tpl_vars['arr_condition']['traderId'],'emptyText' => '选择业务员'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:c25014d2cad3223fae6f2bd974817ec9#0}';}?>

 </select>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'GetClientByTraderIdJson.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>