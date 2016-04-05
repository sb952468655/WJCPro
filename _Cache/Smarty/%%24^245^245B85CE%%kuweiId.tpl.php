<?php /* Smarty version 2.6.10, created on 2014-10-30 14:26:30
         compiled from Search/kuweiId.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/kuweiId.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%24^245^245B85CE%%kuweiId.tpl.inc'] = 'ea439aa017a3972e75ef2ae4477ab70e'; ?><select name="kuweiId" id="kuweiId">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:ea439aa017a3972e75ef2ae4477ab70e#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'jichu_kuwei','selected' => $this->_tpl_vars['arr_condition']['kuweiId'],'emptyText' => '选择仓库'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:ea439aa017a3972e75ef2ae4477ab70e#0}';}?>

</select>