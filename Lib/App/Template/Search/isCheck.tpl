<select name="isCheck" id="isCheck">
	<option value=2 {if $arr_condition.isCheck == 2} selected="selected" {/if}>选择审核</option>
	<option value=0 {if $arr_condition.isCheck == 0} selected="selected" {/if}>未审核</option>
	<option value=1 {if $arr_condition.isCheck == 1} selected="selected" {/if}>已审核</option>
</select>