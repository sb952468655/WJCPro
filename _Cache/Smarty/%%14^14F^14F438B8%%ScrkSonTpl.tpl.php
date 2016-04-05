<?php /* Smarty version 2.6.10, created on 2014-10-30 14:30:04
         compiled from Shengchan/Cangku/ScrkSonTpl.tpl */ ?>
<script language="javascript">
<?php echo '
$(function(){
	//仓库信息
	$(\'[name="kuweiIdLl"],[name="kuweiIdYs"]\').bind(\'onSel\',function(event,ret){
	});

	//绑定事件：弹出窗口打开指定url之前处理url
	$(\'[name="kuweiIdLl"],[name="kuweiIdYs"]\').bind(\'beforeOpen\',function(event,url){
		var jiagonghuId=$(\'#jiagonghuId\').val();
		if(jiagonghuId>0)url+="&jiagonghuId="+jiagonghuId;
		return url;
	});

	//选择产品
	$(\'[name="productId[]"]\').bind(\'onSel\',function(event,ret){
		var tr = $(this).parents(\'.trRow\');
		$(\'[name="zhonglei[]"]\',tr).val(ret.zhonglei);
		$(\'[name="proName[]"]\',tr).val(ret.proName);
		$(\'[name="guige[]"]\',tr).val(ret.guige);
		$(\'[name="color[]"]\',tr).val(ret.color);
		$(\'[name="pinzhong[]"]\',tr).val(ret.pinzhong);
		$(\'[name="pihao[]"]\',tr).val(ret.pihao);
		$(\'[name="supplierId[]"]\',tr).val(ret.supplierId);
		$(\'[name="ganghao[]"]\',tr).val(ret.ganghao);
		// dump(ret);
		if(ret.kucun==1){
			$(\'[name="cnt[]"]\',tr).val(ret.cnt);
			$(\'[name="cnt[]"]\',tr).attr(\'max\',ret.cnt);
			$(\'[name="cntJian[]"]\',tr).val(ret.cntJian);
		}
		
		$(\'[name="dengji[]"]\',tr).val(ret.dengji);

		$(\'[name="cnt[]"]\',tr).change();
	});

	//绑定事件：弹出窗口打开指定url之前处理url
	$(\'[name="productId[]"]\').bind(\'beforeOpen\',function(event,url){
		var tr = $(this).parents(\'.trRow\');
		var kuweiId=0;
		if($(\'[name="id[]"]\',tr).length>0)kuweiId=$(\'#kuweiIdLl\').val();
		else if($(\'[name="id[]"]\',tr))kuweiId=$(\'#kuweiIdYs\').val();
		if(kuweiId>0)url+="&kuweiId="+kuweiId;

		var color=$(\'[name="color[]"]\',tr).val()||\'\';
		if(color!=\'\')url+="&color="+color;

		var key=$(\'[name="pinzhong[]"]\',tr).val()||\'\';
		if(key==\'\'){
			key=$(\'[name="proName[]"]\',tr).val()||\'\';
		}

		if(key!=\'\')url+="&key="+key;

		return url;
	});
});

'; ?>

</script>