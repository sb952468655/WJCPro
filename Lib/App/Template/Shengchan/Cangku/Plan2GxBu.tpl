<script language="javascript">
{literal}
$(function(){
	/**
	* 生产计划选择后绑定的onSel方法，必须存在
	*/
	$('[name="planGxId[]"]').bind('onSel',function(event,ret){
		var tr = $(this).parents('.trRow');
		$('[name="plan2proId[]"]',tr).val(ret.plan2proId);
		$(this).attr('search',ret.pinzhong);
		
		//同步选择产品信息
		$('[name="productId[]"]',tr).val(ret.productId);
		var p = $('[name="productId[]"]',tr).parents('.input-group');
		$('[name="textBox"]',p).val(ret.proCode);
		$('[name="proCode"]',tr).val(ret.proCode);
		$('[name="pinzhong[]"]',tr).val(ret.pinzhong);
		$('[name="guige[]"]',tr).val(ret.guige);
		$('[name="color[]"]',tr).val(ret.color);
		
	});

	//绑定事件：弹出窗口打开指定url之前处理url
	$('[name="planGxId[]"]').bind('beforeOpen',function(event,url){
		var jiagonghuId=$('#jiagonghuId').val()||0;
		if(!jiagonghuId>0){
			jiagonghuId=$('#kuweiIdfrom').attr('search')||'';
		}
		if(jiagonghuId>0)url+="&jiagonghuId="+jiagonghuId;
		return url;
	});
});

{/literal}
</script>