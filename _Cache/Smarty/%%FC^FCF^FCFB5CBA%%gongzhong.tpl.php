<?php /* Smarty version 2.6.10, created on 2016-03-21 16:11:07
         compiled from Search/gongzhong.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Search/gongzhong.tpl', 2, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%FC^FCF^FCFB5CBA%%gongzhong.tpl.inc'] = 'ebd5abe3ff5a48c3a24121d6a27d2879'; ?><select name="gongzhong" id="gongzhong">
	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:ebd5abe3ff5a48c3a24121d6a27d2879#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'Tmisoptions','model' => 'Jichu_Gongzhong','emptyText' => '选择工种','selected' => $this->_tpl_vars['arr_condition']['gongzhong'],'valueKey' => 'itemName'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:ebd5abe3ff5a48c3a24121d6a27d2879#0}';}?>

</select>