<?php /* Smarty version 2.6.10, created on 2014-10-30 14:16:46
         compiled from Shengchan/jsPlanEdit.tpl */ ?>
<script language="javascript">
<?php echo '
$(function(){
	$(\'#orderId\').bind(\'onSel\',function(event,ret){
		onSelOrder(this,ret);
	});
});
function onSelOrder(obj,ret) {
	//ajax取得订单信息
	var url=\'?Controller=Trade_Order&action=GetOrderInfo\';
	var orderId =$(\'#orderId\',$(obj).parents(\'.input-group\')).val();
	// alert(orderId);
	var param={\'orderId\':orderId};
	$.getJSON(url,param,function(json){
		if(!json.success) {
			alert(json.msg);
			return;
		}

		$(\'#planMemo\').val(json.order.memo);
		var pros = json.order.Products;
		if(pros.length==0) {
			alert(\'未发现订单的产品信息!\');
			return;
		}
		// alert(\'选择订单后，先删除所有空行,然后将订单明细的信息作为新航插入,注意，请在Shengchan/jsPlanEdit.tpl中编写\');
		//判断下面表格中的id[]，如果为空删除，否则保留(主要是为了考虑修改时，不能把已保存过的明细直接删除)
		var trs = $(\'.trRow\');
		var len = trs.length;
		var trTpl = trs.eq(len-1).clone(true);
		var parent = trs.eq(0).parent();
		
		$(\'input,select\',trTpl).val(\'\');
		for(var i=0;trs[i];i++) {
			var id = $(\'[name="id[]"]\',trs[i]);
			if(id.val()!=\'\') continue;
			trs.eq(i).remove();
		}
		
		//将选中订单的明细形成新行插入
		for(var i=0;pros[i];i++) {
			var newTr = trTpl.clone(true);
			// debugger;
			$(\'#proCode\',newTr).val(pros[i].Product.proCode);
			$(\'[name="productId[]"]\',newTr).val(pros[i].Product.id);
			$(\'[name="pinzhong[]"]\',newTr).val(pros[i].Product.pinzhong);
			$(\'[name="guige[]"]\',newTr).val(pros[i].Product.guige);
			$(\'[name="color[]"]\',newTr).val(pros[i].color);
			$(\'[name="menfu[]"]\',newTr).val(pros[i].menfu);
			$(\'[name="kezhong[]"]\',newTr).val(pros[i].kezhong);
			$(\'[name="cntYaohuo[]"]\',newTr).val(pros[i].cntYaohuo+pros[i].unit);
			$(\'[name="cntShengchan[]"]\',newTr).val(pros[i].cntKg);
			$(\'[name="ord2proId[]"]\',newTr).val(pros[i].id);

			//加载自动控件给颜色输入框
			// autoComplete(newTr);

			parent.append(newTr);
		}
		
	});
}
'; ?>

</script>