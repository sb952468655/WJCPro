<select name="isRuku" id="isRuku">
				<option value='0' {if $arr_condition.isRuku == '0'} selected="selected" {/if}>入库</option>
				<option value='1' {if $arr_condition.isChuku == '1'} selected="selected" {/if}>出库</option>
</select>