{literal}
<script language="javascript">
$(function(){
	//应付金额随折扣金额和金额的变动而变动
	$('#_money,#zhekouMoney').change(function(){
		var _money = parseFloat($('#_money').val())||0;
		var zhekouMoney = parseFloat($('#zhekouMoney').val())||0;
		var money = (_money-zhekouMoney).toFixed(2);
		$('#money').val(money);
	});

	//单价的change事件
	$('#danjia').change(function(){
		var danjia = parseFloat($('#danjia').val())||0;
		var cnt = parseFloat($('#cnt').val())||0;
		var money = (danjia*cnt).toFixed(2);
		$('#_money').val(money);
		$('#money').val(money);
	});

	$('.dialog').click(function(){
		window.showModalDialog($(this).attr('src'),window,'dialogWidth:860');

		//查找该出库id对应的金额信息
		var id=0;
		if($('#chukuId').val()>0){
			id=$('#chukuId').val();
			var url="?controller=Shengchan_Chuku&action=GetMoney";
		}else{
			id=$('#rukuId').val();
			var url="?controller=Shengchan_Ruku&action=GetMoney";
		}
		//alert(id);
        var zhekouMoney=$('#zhekouMoney').val();
		$.getJSON(url,{id:id,zhekouMoney:zhekouMoney},function(json){
			$('#_money').val(json.money);			
			$('#money').val(json.money2);
		});
		
		return;
	});
});
</script>
{/literal}