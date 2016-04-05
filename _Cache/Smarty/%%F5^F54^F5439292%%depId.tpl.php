<?php /* Smarty version 2.6.10, created on 2016-03-21 16:11:07
         compiled from Search/depId.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/depId.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%F5^F54^F5439292%%depId.tpl.inc'] = 'aaccb78d77b4d8b1732273b54bf712fd'; ?><select name="depId" id="depId">
    		<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaccb78d77b4d8b1732273b54bf712fd#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'TmisOptions','model' => 'Jichu_Department','selected' => $this->_tpl_vars['arr_condition']['depId'],'emptyText' => '选择部门'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaccb78d77b4d8b1732273b54bf712fd#0}';}?>

            </select>