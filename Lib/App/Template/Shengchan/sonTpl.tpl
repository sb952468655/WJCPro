<script language="javascript">
{literal}
	$(function(){
		$('[name="chengfenPer[]"],[name="sunhao[]"]').live('change',function(){
			var pos=$('[name="'+this.name+'"]').index(this);
			var chengfenPer = parseFloat($('[name="chengfenPer[]"]').eq(pos).val())||0;
			var sunhao = parseFloat($('[name="sunhao[]"]').eq(pos).val())||0;
			var cntSc = parseFloat($('#cntShengchan').val())||0;
			var cntKg = (cntSc*chengfenPer/100*(1+sunhao/100)).toFixed(2);
			$('[name="cntKg[]"]').eq(pos).val(cntKg);
		});
	});
{/literal}
</script>