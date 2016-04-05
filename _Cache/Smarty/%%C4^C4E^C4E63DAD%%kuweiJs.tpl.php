<?php /* Smarty version 2.6.10, created on 2014-10-30 14:25:35
         compiled from Shengchan/kuweiJs.tpl */ ?>
<script language="javascript">
<?php echo '
	$(function(){
		$(\'[name="kuweiId"]\').bind(\'onSel\',function(){
			
		});

		$(\'#kuweiId\').bind(\'beforeOpen\',function(event,url){
			var jiagonghuId=$(\'#jiagonghuId\').val()||0;
			if(jiagonghuId>0)url+="&jiagonghuId="+jiagonghuId;
			// alert(url);
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
			$(\'[name="cnt[]"]\',tr).val(ret.cnt);
			$(\'[name="cntJian[]"]\',tr).val(ret.cntJian);
			$(\'[name="dengji[]"]\',tr).val(ret.dengji);

			$(\'[name="cnt[]"]\',tr).change();
		});

		//绑定事件：弹出窗口打开指定url之前处理url
		$(\'[name="productId[]"]\').bind(\'beforeOpen\',function(event,url){
			var tr = $(this).parents(\'.trRow\');
			var kuweiId=$(\'#kuweiId\').val();
			if(kuweiId>0)url+="&kuweiId="+kuweiId;
			return url;
		});
	});
'; ?>

</script>