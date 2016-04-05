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
		var url="?controller=Shengchan_CangkuBu_CkWithMadan&action=ViewMadan";
		var trRow = $(this).parents(".trRow");
		var ruku2proId = $('[name="ruku2proId[]"]',trRow).val();
		var chuku2proId = $('[name="id[]"]',trRow).val();
		url+="&ruku2proId="+ruku2proId;
		url+="&chuku2proId="+chuku2proId;
		if(!ruku2proId>0){
			alert('无法查找到对应的码单信息，请刷新后重新操作');return;
		}
		//弹出窗口，设置宽度高度
		var width = screen.width;
		var height = screen.height;
		width = width>1300?1300:width;
		height = height>640?640:height;
		//获取码单选择信息
		var madan = $('[name="Madan[]"]',trRow).val();
		window.returnValue=null;
		var ret = window.showModalDialog(url,{data:$.toJSON(madan)},'dialogWidth:'+width+'px;dialogHeight:'+height+'px;');

	    if(!ret) ret=window.returnValue;
	    if(!ret) return;
		if(ret.ok!=1)return false;
		// dump(ret);
		$('[name="cntJian[]"]',trRow).val(ret.cntJian);
		$('[name="cnt[]"]',trRow).val(ret.cnt);
		$('[name="cntM[]"]',trRow).val(ret.cntM);
		$('[name="Madan[]"]',trRow).val(ret.data);
	});

	//选择订单的时候需要处理的数据
	$('#orderId').bind('onSel',function(event,ret){
		$('#ord2proId').val(ret.id);
		$('#proCode').val(ret.proCode);
		$('#pinzhong').val(ret.pinzhong);
		$('#guige').val(ret.guige);
		$('#color').val(ret.color);
		$('#menfu').val(ret.menfu);
		$('#kezhong').val(ret.kezhong);
		$('#cntYaohuo').val(ret.cntYaohuo+ret.unit);
		$('#unit').val(ret.unit);
		$('#clientId').val(ret.clientId);
		$('#danjia').val(ret.danjia);
		$('#clientName').val(ret.compName);
		$('#productId').val(ret.productId);
	});

	//绑定验收记录选择前的事件处理
	$('[name="ruku2proId[]"]').bind('onSel',function(event,ret){
		var tr = $(this).parents('.trRow');
		// dump(ret);
		// $('[name="productId[]"]',tr).val(ret.productId);
		// $('[name="proCode[]"]',tr).val(ret.proCode);
		// $('[name="pinzhong[]"]',tr).val(ret.pinzhong);
		// $('[name="guige[]"]',tr).val(ret.guige);
		// $('[name="color[]"]',tr).val(ret.color);
		$('[name="ganghao[]"]',tr).val(ret.ganghao);
		$('[name="shahao[]"]',tr).val(ret.shahao);
		$('[name="chehao[]"]',tr).val(ret.chehao);
		$('[name="rukuDate[]"]',tr).val(ret.rukuDate);
		$('[name="pihao[]"]',tr).val(ret.pihao);
		$('[name="dengji[]"]',tr).val(ret.dengji);
	});
	//绑定验收记录选择前的事件处理
	$('[name="ruku2proId[]"]').bind('beforeOpen',function(event,url){
		var kuweiId=$('#kuweiId').val()||0;
		var productId=$('#productId').val()||0;
		var color=$('#color').val()||'';
		var type=$('#type').val()||'';
		if(productId==0){
			alert('请先选择订单信息');return false;
		}
		if(kuweiId==0){
			alert('请先选择库位信息');return false;
		}

		if(kuweiId>0)url+="&kuweiId2="+kuweiId;
		if(productId>0)url+="&productId="+productId;
		if(color!='')url+="&color2="+color;
		if(type!='')url+="&type="+type;
		return url;
	});
});
{/literal}
</script>