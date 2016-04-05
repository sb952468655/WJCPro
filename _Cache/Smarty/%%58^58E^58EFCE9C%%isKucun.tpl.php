<?php /* Smarty version 2.6.10, created on 2014-10-30 14:29:15
         compiled from Search/isKucun.tpl */ ?>
<select name="isKucun" id="isKucun">
				<option value='0' <?php if ($this->_tpl_vars['arr_condition']['isKucun'] == '0'): ?> selected="selected" <?php endif; ?>>全部信息</option>
				<option value='1' <?php if ($this->_tpl_vars['arr_condition']['isKucun'] == '1'): ?> selected="selected" <?php endif; ?>>非零库存</option>
            </select>