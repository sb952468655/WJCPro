<select name="isHaveGz" id="isHaveGz">
				<option value='0' {if $arr_condition.isHaveGz == '0'} selected="selected" {/if}>需要过账</option>
				<option value='2' {if $arr_condition.isHaveGz == '2'} selected="selected" {/if}>不需要过账</option>
</select>