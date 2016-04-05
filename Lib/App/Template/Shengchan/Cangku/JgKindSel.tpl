{literal}
<script language="javascript">
$(function(){
	//加工类别改变后触发的事件
	$('#type').change(function(){
		$('#kind').val($(this).val()+'验收');
	});

	$('#ylType').change(function(){
		var ylType = $('#ylType').val();
		var url="";
		if(ylType==''){
			url="?controller=jichu_chanpin&action=Popup";
		}else if(ylType=='坯布'){
			url="?controller=jichu_chanpin&action=PopupZhizao";
		}else if(ylType=='染色布'){
			url="?controller=jichu_chanpin&action=PopupRanbu";
		}else{
			url="?controller=jichu_chanpin&action=PopupHzl&typeHzl="+ylType;
		}

		$('[name="productId[]"]','#table_main').each(function(){
			var g = $(this).parents('.input-group');
			$('[name="btnPop"]',g).attr('url',url);
		});
	});
});
</script>
{/literal}