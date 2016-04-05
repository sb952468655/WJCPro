{webcontrol type='LoadJsCss' src="Resource/Script/jquery.json.js"}
<script language="javascript">
{literal}
$(function(){
	/**
	* 码单按钮单机事件
	* 打开码单出库界面
	*/
	$('[name="btnMadan"]').live('click',function(){
		//url地址
		var url="?controller=Shengchan_Ruku&action=ViewMadan";
		var trRow = $(this).parents(".trRow");
		//弹出窗口，设置宽度高度
		var width = screen.width;
		var height = screen.height;
		width = width>1200?1200:width;
		height = height>640?640:height;
		//获取码单选择信息
		var madan = $('[name="Madan[]"]',trRow).val();
		window.returnValue=null;
		var ret = window.showModalDialog(url,{data:madan},'dialogWidth:'+width+'px;dialogHeight:'+height+'px;');

	    if(!ret){
	    	ret=window.returnValue;
	    }
	    if(!ret) return;
		if(ret.ok!=1)return false;
		// dump(ret);
		$('[name="cntJian[]"]',trRow).val(ret.cntJian);
		$('[name="cnt[]"]',trRow).val(ret.cnt);
		$('[name="Madan[]"]',trRow).val(ret.data);
		$('[name="cnt[]"]',trRow).change();
	});
});
{/literal}
</script>