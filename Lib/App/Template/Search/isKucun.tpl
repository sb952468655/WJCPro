<select name="isKucun" id="isKucun">
				<option value='0' {if $arr_condition.isKucun == '0'} selected="selected" {/if}>全部信息</option>
				<option value='1' {if $arr_condition.isKucun == '1'} selected="selected" {/if}>非零库存</option>
            </select>