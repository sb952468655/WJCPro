<?php /* Smarty version 2.6.10, created on 2014-10-30 13:51:14
         compiled from _Search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', '_Search.tpl', 11, false),array('modifier', 'default', '_Search.tpl', 24, false),array('function', 'url', '_Search.tpl', 22, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%FC^FCA^FCAC0DF5%%_Search.tpl.inc'] = 'cfd0ff1195d9d6bf45ef253733396a88'; ?><div id=searchGuide  class='x-hide-display'>
	<form name="FormSearch" id='FormSearch' method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
        <div id="search_height">
        <a href="#" id="search_img"><img src="Resource/Image/search.png" ext:qtip="搜索"></a>
        </div>
        <div id="search_input_div">
		<?php $_from = $this->_tpl_vars['arr_condition']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
			<?php $this->assign('f', ((is_array($_tmp=((is_array($_tmp="Lib/App/Template/Search/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key'])))) ? $this->_run_mod_handler('cat', true, $_tmp, ".tpl") : smarty_modifier_cat($_tmp, ".tpl"))); ?>
			<?php if (file_exists ( $this->_tpl_vars['f'] )): ?>
			<tt><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=((is_array($_tmp="Search/")) ? $this->_run_mod_handler('cat', true, $_tmp, $this->_tpl_vars['key']) : smarty_modifier_cat($_tmp, $this->_tpl_vars['key'])))) ? $this->_run_mod_handler('cat', true, $_tmp, ".tpl") : smarty_modifier_cat($_tmp, ".tpl")), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></tt>
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<tt><input type="submit" name="Submit" value="搜索" class="button_search"/></tt>
        </div>
		</td>
		<?php if ($_GET['no_edit'] != 1): ?>
		<td id="edit" align="right" style="padding-right:10px;">
			<?php if ($this->_tpl_vars['add_display'] != 'none'): ?>
			<a class="button_href" href="<?php if ($this->_tpl_vars['add_url'] == ''):  if ($this->caching && !$this->_cache_including) { echo '{nocache:cfd0ff1195d9d6bf45ef253733396a88#0}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'add','fromAction' => $_GET['action']), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cfd0ff1195d9d6bf45ef253733396a88#0}';}?>

			<?php else:  echo $this->_tpl_vars['add_url']; ?>

			<?php endif; ?>"><?php echo ((is_array($_tmp=@$this->_tpl_vars['add_text'])) ? $this->_run_mod_handler('default', true, $_tmp, '新增') : smarty_modifier_default($_tmp, '新增')); ?>
</a>
			<?php endif; ?>
            <?php if ($this->_tpl_vars['other_url'] != ''):  echo $this->_tpl_vars['other_url'];  endif; ?>
			<?php if ($this->_tpl_vars['list_display'] == 'list' || $this->_tpl_vars['list_url'] != ''): ?>
			<a class="button_href" href="<?php if ($this->_tpl_vars['list_url'] == ''):  if ($this->caching && !$this->_cache_including) { echo '{nocache:cfd0ff1195d9d6bf45ef253733396a88#1}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => 'list'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cfd0ff1195d9d6bf45ef253733396a88#1}';}?>

			<?php else:  echo $this->_tpl_vars['list_url']; ?>

			<?php endif; ?>"><?php echo ((is_array($_tmp=@$this->_tpl_vars['list_text'])) ? $this->_run_mod_handler('default', true, $_tmp, '查询') : smarty_modifier_default($_tmp, '查询')); ?>
</a>
			<?php endif; ?>
		</td>
		<?php endif; ?>
      </tr>
    </table>
	</form>
</div>