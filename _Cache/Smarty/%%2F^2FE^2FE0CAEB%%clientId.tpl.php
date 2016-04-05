<?php /* Smarty version 2.6.10, created on 2014-10-28 13:13:06
         compiled from Search/clientId.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/clientId.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%2F^2FE^2FE0CAEB%%clientId.tpl.inc'] = '1eef134da9fde4eb50bf04844c8034bd'; ?><select name="clientId" id="clientId">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:1eef134da9fde4eb50bf04844c8034bd#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Clientoptions','selected' => $this->_tpl_vars['arr_condition']['clientId'],'isLimit' => '1'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:1eef134da9fde4eb50bf04844c8034bd#0}';}?>

</select>