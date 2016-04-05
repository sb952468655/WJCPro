<?php /* Smarty version 2.6.10, created on 2014-11-24 11:17:08
         compiled from Main/radio.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'Main/radio.tpl', 2, false),)), $this); ?>
  <div class="form-group">
    <label for="<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])); ?>
" class="col-sm-3 control-label lableMain"><?php echo $this->_tpl_vars['item']['title']; ?>
:</label>
    <div class="col-sm-7">
	<?php $_from = $this->_tpl_vars['item']['radios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['rdi']):
?>
	<div class='radio'>
	<label>
	<input type="radio" name="<?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['key']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['key'])); ?>
" value="<?php echo $this->_tpl_vars['rdi']['value']; ?>
" <?php if ($this->_tpl_vars['rdi']['value'] == $this->_tpl_vars['item']['value']): ?> checked <?php endif; ?>>
	<?php echo $this->_tpl_vars['rdi']['title']; ?>

	</label>
	</div>
	<?php endforeach; endif; unset($_from); ?>
	</div>
  </div>