{literal}
<script language="javascript">
$(function(){
	//因为需要使用ret作为毁掉函数的参数，所以需要使用bind,
	//选择订单后，明细栏中显示订单明细情况
	$('[name="orderId"]').bind('onSel',function(event,ret){
		//先删除id='' && 数量=''的行，
		var trs = $('.trRow');
		var len = trs.length; 
		var tpl = trs.eq(0).clone(true);
		var pNode = trs.parent();
		$('#clientName').val(ret.compName);
		$('#clientId').val(ret.clientId);
		// debugger;
		for(var i=0;trs[i];i++) {
			if($('[name="id[]"]',trs[i]).val()!='') continue;
			if($('[name="cnt[]"]',trs[i]).val()!='') continue;
			trs.eq(i).remove();
		}

		//插入订单明细的情况
		var url='?controller=trade_order&action=GetOrderInfoAndChuku';
		var param={'orderId':this.value};
		// debugger;
		$.post(url,param,function(ret){
			debugger;
			if(!ret.success) {
				alert('服务器端错误');
				return;
			}
			var json = ret.order.Products;
			if(!json) {
				alert('未发现数据集');
				return;
			}
			for(var i=0;json[i];i++) {
				var nt = tpl.clone(true); 
				$('input,select',nt).val(''); 

				//为控件赋值
				var g = $('[name="productId[]"]',nt).parents('.input-group');
				$('[name="textBox"]',g).val(json[i].Product.proCode);
				$('[name="proCode[]"]',nt).val(json[i].Product.proCode);
				$('[name="pinzhong[]"]',nt).val(json[i].Product.pinzhong);
				$('[name="guige[]"]',nt).val(json[i].Product.guige);
				$('[name="color[]"]',nt).val(json[i].color);
				$('[name="menfu[]"]',nt).val(json[i].menfu);
				$('[name="kezhong[]"]',nt).val(json[i].kezhong);
				$('[name="productId[]"]',nt).val(json[i].productId);
				$('[name="ord2proId[]"]',nt).val(json[i].id);
				$('[name="danjia[]"]',nt).val(json[i].danjia);
				$('[name="cntYaohuo[]"]',nt).val(json[i].cntYaohuo+json[i].unit);
				$('[name="unit[]"]',nt).val(json[i].unit);
				$('[name="cntHaveck[]"]',nt).val(json[i].cntHaveck);
				$('[name="dengji[]"]',nt).val('一等品');
				pNode.append(nt);
			}
			tpl = null;
			return;
		},'json');	
	});
});
</script>
{/literal}