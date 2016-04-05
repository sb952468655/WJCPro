<?php /* Smarty version 2.6.10, created on 2014-11-08 12:42:21
         compiled from Search/isShenhe.tpl */ ?>
<select name="isShenhe" id="isShenhe">
	<option value=0 <?php if ($this->_tpl_vars['arr_condition']['isShenhe'] == 0): ?> selected="selected" <?php endif; ?>>未审核</option>
	<option value=1 <?php if ($this->_tpl_vars['arr_condition']['isShenhe'] == 1): ?> selected="selected" <?php endif; ?>>已审核</option>
	<option value=2 <?php if ($this->_tpl_vars['arr_condition']['isShenhe'] == 2): ?> selected="selected" <?php endif; ?>>全部</option>
</select>