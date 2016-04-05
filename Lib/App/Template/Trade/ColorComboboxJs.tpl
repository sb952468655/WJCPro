<script language="javascript">
{literal}
$(function(){
	var url="?controller=jichu_product&action=GetColorByAjax";
	//combobox控件点击的时候获取颜色信息
	$('.dropdown-toggle').live('click',function(){
		//获取控件的div
		var combobox = $(this).parents('.input-group');
		//控件中的输入框名字，判断是否为颜色，不是的不需要操作
		var input = $('input',combobox).attr('name');
		// alert(input);
		if(input=='color[]'){
			//产品id必须存在，否则不考虑
			var trs = $(this).parents('.trRow');
			var productId = $('[name="productId[]"]',trs).val();
			if(productId>0){
				$('.jeffCombobox',combobox).find('li').remove();
				//ajax获取颜色信息，并拼接
				$.getJSON(url,{'productId':productId},function(json){
					if(json.success){
						//拼接颜色信息
						$('.jeffCombobox',combobox).append(json.comboboxHtml);
					}
				});
			}
		}
	});
});
{/literal}
</script>