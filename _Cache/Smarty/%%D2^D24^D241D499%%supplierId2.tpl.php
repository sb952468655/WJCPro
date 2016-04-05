<?php /* Smarty version 2.6.10, created on 2014-10-30 16:18:19
         compiled from Search/supplierId2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/supplierId2.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%D2^D24^D241D499%%supplierId2.tpl.inc'] = '6b4daf5357e385fee71cebaf3dec486d'; ?><select name="supplierId2" id="supplierId2">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:6b4daf5357e385fee71cebaf3dec486d#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'jichu_jiagonghu','selected' => $this->_tpl_vars['arr_condition']['supplierId2'],'emptyText' => '选择对象'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:6b4daf5357e385fee71cebaf3dec486d#0}';}?>

</select>