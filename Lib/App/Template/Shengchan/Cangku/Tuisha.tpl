<script language="javascript">
{literal}
$(function(){
	//计算金额信息
	$('#danjia,#cnt').change(function(){
		var danjia=parseFloat($('#danjia').val())||0;
		var cnt=parseFloat($('#cnt').val())||0;
		var money=(danjia*cnt).toFixed(2);
		$('#money').val(money);
	});
});
{/literal}
</script>