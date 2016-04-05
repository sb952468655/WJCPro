<?php /* Smarty version 2.6.10, created on 2014-10-30 14:29:58
         compiled from Search/kuweiIdTo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/kuweiIdTo.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%66^662^6627ED23%%kuweiIdTo.tpl.inc'] = 'bc5f6e69eefbc83d8d6a4bcc855f55ca'; ?><select name="kuweiIdTo" id="kuweiIdTo">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:bc5f6e69eefbc83d8d6a4bcc855f55ca#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'jichu_kuwei','selected' => $this->_tpl_vars['arr_condition']['kuweiIdTo'],'emptyText' => '选择发入仓库'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:bc5f6e69eefbc83d8d6a4bcc855f55ca#0}';}?>

</select>