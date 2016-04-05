<script language="javascript">
{literal}

$(function(){
	$('[name="llCnt[]"]').click(function(){
		var that = this;
		// debugger;
		var url="?controller=shengchan_ruku&action=IsLLAjax";
		// alert(this.checked);
		var param = {'isTrue':that.checked ? '1' : '0','id':$(that).val()};
		$.getJSON(url,param,function(json){
			// alert(json.success);
		});
	});
});

{/literal}
</script>