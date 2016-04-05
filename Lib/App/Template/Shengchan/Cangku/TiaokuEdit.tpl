<script language="javascript">
{literal}
$(function(){
	//计算调整库存数量
	$('#cntNow').change(function(){
		var cntKucun=parseFloat($('#cntKucun').val())||0;
		var cntNow=parseFloat($('#cntNow').val())||0;
		
		var cnt=(cntNow-cntKucun).toFixed(2);
		$('#cnt').val(cnt);
	});
});
{/literal}
</script>