<select name="typeHzl" id="typeHzl">
	<option value=''>后整理类别</option>
	<option value='印花' {if $arr_condition.typeHzl == '印花'} selected="selected" {/if}>印花</option>
	<option value='水洗' {if $arr_condition.typeHzl == '水洗'} selected="selected" {/if}>水洗</option>
	<option value='定型' {if $arr_condition.typeHzl == '定型'} selected="selected" {/if}>定型</option>
</select>