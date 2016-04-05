{literal}
<script language="javascript">
$(function(){
	$('#_money,#zhekouMoney').change(function(){
		var _money = parseFloat($('#_money').val())||0;
		var zhekouMoney = parseFloat($('#zhekouMoney').val())||0;
		var money = (_money-zhekouMoney).toFixed(2);
		$('#money').val(money);
	});
	// debugger;

	$('[name="chuku2proId"]').bind('onSel',function(event,ret){
		// debugger;
		// alert(1);
		$('#qitaMemo').val(ret.qitaMemo);

		$('#clientName').val(ret.compName);
		$('#clientId').val(ret.clientId);

		$('#chukuDate').val(ret.chukuDate);
		$('#cnt').val(ret.cnt);
		$('#cntM').val(ret.cntM);
		$('#danjia').val(ret.danjia);
		$('#money').val(ret.money);
		$('#bizhong').val(ret.bizhong);
		$('#huilv').val(ret.huilv);
		$('#productId').val(ret.productId);
		$('#chukuId').val(ret.chukuId);//主表订单Id
		$('#orderId').val(ret.orderId);//主表订单Id
		$('#ord2proId').val(ret.ord2proId);//主表订单Id
		$('#kind').val(ret.kind);
		$('#_money').change();
	});
});
</script>
{/literal}