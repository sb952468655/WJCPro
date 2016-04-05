<?php /* Smarty version 2.6.10, created on 2014-10-30 14:15:50
         compiled from Search/isCheck.tpl */ ?>
<select name="isCheck" id="isCheck">
	<option value=2 <?php if ($this->_tpl_vars['arr_condition']['isCheck'] == 2): ?> selected="selected" <?php endif; ?>>选择审核</option>
	<option value=0 <?php if ($this->_tpl_vars['arr_condition']['isCheck'] == 0): ?> selected="selected" <?php endif; ?>>未审核</option>
	<option value=1 <?php if ($this->_tpl_vars['arr_condition']['isCheck'] == 1): ?> selected="selected" <?php endif; ?>>已审核</option>
</select>