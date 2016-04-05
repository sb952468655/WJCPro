<script language="javascript">
{literal}
$(function(){
	/**
	* 生产计划选择受绑定的事件，必须存在
	*/
	if($('[name="plan2proId[]"]').length>0){
		$('[name="plan2proId[]"]').bind('onSel',function(event,ret){});
	}

	/**
	* 如果存在单价，则计算金额信息
	*/
	if($('[name="danjia[]"]').length>0){
	    $('[name="cnt[]"],[name="cntCi[]"],[name="danjia[]"]').change(function(){
	        var tr = $(this).parents(".trRow");
	        var danjia = parseFloat($('[name="danjia[]"]',tr).val())||0;
	        var cnt = parseFloat($('[name="cnt[]"]',tr).val())||0;
	        var cntCi = parseFloat($('[name="cntCi[]"]',tr).val())||0;
	        $('[name="money[]"]',tr).val((danjia*(cnt+cntCi)).toFixed(2));
	        return;
	    });
	}
});
{/literal}
</script>