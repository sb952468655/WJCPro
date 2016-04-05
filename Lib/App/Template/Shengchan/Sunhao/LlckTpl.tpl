<script language="javascript">
{literal}
$(function(){
	/**
	* 生产计划选择后绑定的onSel方法，必须存在
	*/
	if($('[name="planGxId[]"]').length>0){
		$('[name="planGxId[]"]').bind('onSel',function(event,ret){
			var tr = $(this).parents('.trRow');
			$('[name="plan2proId[]"]',tr).val(ret.plan2proId);
			$('[name="gongxuName[]"]',tr).val(ret.gongxuName);
		});
	}
});
{/literal}
</script>