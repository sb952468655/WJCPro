<select name="isSelect" id="isSelect">
	<option value=0 {if $arr_condition.isSelect == 0} selected="selected" {/if}>未选过</option>
	<option value=1 {if $arr_condition.isSelect == 1} selected="selected" {/if}>已选过</option>
</select>