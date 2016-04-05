<?php /* Smarty version 2.6.10, created on 2014-10-30 14:23:09
         compiled from Search/supplierId.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/supplierId.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%48^48B^48B2CE66%%supplierId.tpl.inc'] = '38776232ff5fa1ccd789eb0c8dd5ed37'; ?><select name="supplierId" id="supplierId">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:38776232ff5fa1ccd789eb0c8dd5ed37#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'jichu_jiagonghu','selected' => $this->_tpl_vars['arr_condition']['supplierId'],'emptyText' => '选择供应商','condition' => 'isSupplier=1'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:38776232ff5fa1ccd789eb0c8dd5ed37#0}';}?>

</select>