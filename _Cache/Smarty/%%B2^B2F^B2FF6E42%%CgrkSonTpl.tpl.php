<?php /* Smarty version 2.6.10, created on 2014-10-30 14:26:36
         compiled from Shengchan/Cangku/CgrkSonTpl.tpl */ ?>
<script language="javascript">
<?php echo '
$(function(){
	/*$(\'[name="plan2proId[]"]\').bind(\'onSel\',function(event,ret){
		
	});*/

	//选择采购计划时自动填充信息
	$(\'[name="cgPlanId"]\').bind(\'onSel\',function(event,ret){
		$(\'#supplierId\').val(ret.supplierId);
		onSelPlan(ret);
	});
});

function onSelPlan(ret) {
	//ajax取得订单信息
	var url=\'?Controller=Shengchan_Cangku_Plan&action=GetPlanInfo\';
	var psPlanId =$(\'#cgPlanId\').val();
	// alert(psPlanId);
	var param={\'psPlanId\':psPlanId,\'supplierId\':ret.supplierId};
	// dump(param);
	$.getJSON(url,param,function(json){
		if(!json.success) {
			alert(json.msg);
			return;
		}
		var pros = json.Products;
		if(pros.length==0) {
			alert(\'未发现采购计划单的产品信息!\');
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
			$(\'[name="zhonglei[]"]\',newTr).val(pros[i].Product.zhonglei);
			$(\'[name="proName[]"]\',newTr).val(pros[i].Product.proName);
			$(\'[name="guige[]"]\',newTr).val(pros[i].Product.guige);
			$(\'[name="color[]"]\',newTr).val(pros[i].color);
			$(\'[name="cntJian[]"]\',newTr).val(pros[i].cntJian);
			$(\'[name="cnt[]"]\',newTr).val(pros[i].cntKg);
			$(\'[name="danjia[]"]\',newTr).val(pros[i].danjia);
			$(\'[name="money[]"]\',newTr).val(pros[i].money);
			$(\'[name="memoView[]"]\',newTr).val(pros[i].memoView);
			parent.append(newTr);
		}
		
	});
}
'; ?>

</script>