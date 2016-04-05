<?php /* Smarty version 2.6.10, created on 2014-10-30 14:27:34
         compiled from Shengchan/Cangku/plan2TlSelTpl.tpl */ ?>
<script language="javascript">
<?php echo '
$(function(){
	$(\'[name="planTlId[]"]\').bind(\'onSel\',function(event,ret){
		var tr = $(this).parents(\'.trRow\');
		$(\'[name="touliaoId[]"]\',tr).val(ret.touliaoId);
		$(\'[name="color[]"]\',tr).val(ret.color);
		$(\'[name="productId[]"]\',tr).val(ret.productId);
		$(\'[name="proName[]"]\',tr).val(ret.proName);
		$(\'[name="guige[]"]\',tr).val(ret.guigeDesc);
		var g = $(\'[name="productId[]"]\',tr).parents(\'.input-group\');
		$(\'[name="textBox"]\',g).val(ret.proCode);
		//添加种类信息到search以便于搜索时候使用
		var search = ret.Product.proName || \'\';
		$(this).attr(\'search\',search);
		$(\'[name="supplierId[]"]\',tr).val(ret.supplierId);

		//查找领料表中已经领料的数量
		/*var tlId=$(this).val();
		if(tlId>0){
			$.getJSON("?controller=Shengchan_Cangku_Llck&action=GettlHave",{\'tlId\':tlId},function(json){
				// 显示的数量为:未投料数量=计划数量-已投料数量
				ret.cntKg=ret.cntKg-json.cnt;
				$(\'[name="cnt[]"]\',tr).val(ret.cntKg);
			})
		}

		// $(\'[name="cnt[]"]\',tr).val(ret.cntKg);
		$(\'[name="cnt[]"]\',tr).change();*/
	});
});

'; ?>

</script>