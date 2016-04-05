<?php /* Smarty version 2.6.10, created on 2014-11-03 16:53:40
         compiled from Search/isRuku.tpl */ ?>
﻿<select name="isRuku" id="isRuku">
				<option value='0' <?php if ($this->_tpl_vars['arr_condition']['isRuku'] == '0'): ?> selected="selected" <?php endif; ?>>入库</option>
				<option value='1' <?php if ($this->_tpl_vars['arr_condition']['isChuku'] == '1'): ?> selected="selected" <?php endif; ?>>出库</option>
</select>