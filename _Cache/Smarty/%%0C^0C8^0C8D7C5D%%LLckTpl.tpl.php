<?php /* Smarty version 2.6.10, created on 2014-10-30 14:27:34
         compiled from Shengchan/Cangku/LLckTpl.tpl */ ?>
<script language="javascript">
<?php echo '
$(function(){
	$(\'[name="kuweiIdfrom"],[name="kuweiIdTo"]\').bind(\'onSel\',function(event,ret){
		$(this).attr(\'search\',ret.jiagonghuId);
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
		$(\'[name="ganghao[]"]\',tr).val(ret.ganghao);
		$(\'[name="cnt[]"]\',tr).val(ret.cnt);
		$(\'[name="cntJian[]"]\',tr).val(ret.cntJian);
		$(\'[name="dengji[]"]\',tr).val(ret.dengji);

		$(\'[name="cnt[]"]\',tr).change();
	});

	//绑定事件：弹出窗口打开指定url之前处理url
	$(\'[name="productId[]"]\').bind(\'beforeOpen\',function(event,url){
		var tr = $(this).parents(\'.trRow\');

		var kuweiId=$(\'#kuweiIdfrom\').val();
		var color=$(\'[name="color[]"]\',tr).val();
		var type=$(\'[name="type"]\').val()||\'\';
		var key=$(\'[name="planTlId[]"]\',tr).attr(\'search\')||\'\';
		if(key==\'\')key=$(\'[name="planGxId[]"]\',tr).attr(\'search\')||\'\';

		if(kuweiId>0)url+="&kuweiId="+kuweiId;
		if(key!=\'\')url+="&key="+key;
		if(color!=\'\')url+="&color="+color;
		if(type!=\'\')url+="&typeHzl="+type;
		return url;
	});

	/*
	* 高级功能
	*/
	$(\'#highLever\').click(function(){
		var url = $(this).attr(\'url\');

		//打开窗口前置空原来的返回值
		window.returnValue=null;
		var dialogWidth = 700;

		//打开模式窗口
	    var ret = window.showModalDialog(url,window,\'dialogWidth:\'+dialogWidth);
	    if(!ret) ret=window.returnValue;
	    if(!ret) return;

	    //如果存在返回值，则处理返回值
	    //仓库信息自动填充
	    $(\'#kuweiIdfrom\').val(ret.kuweiId);
	    var g = $(\'#kuweiIdfrom\').parents(\'.input-group\');
	   	$(\'[name="textBox"]\',g).val(ret.kuweiName);

	   	//如果是后整理，则需要自动填充布类型
	   	if(ret.isHzl==1){
	   		 $(\'#type\').val(ret.type);
	   	}

	   	//领料明细信息
	   	var pros = ret.Products;
	   	if(!pros.length>0){
	   		alert(\'没有验收明细信息\');
	   		return false;
	   	}

	   	//获取入库id
	   	$(\'#hide_highLever\').val(ret.id);

	   	var trs = $(\'.trRow\');
		var len = trs.length;
		var trTpl = trs.eq(len-1).clone(true);
		var parent = trs.eq(0).parent();
		
		$(\'input,select\',trTpl).val(\'\');
		for(var i=0;trs[i];i++) {
			var id = $(\'[name="id[]"]\',trs[i]);
			if(id.val()!=\'\') continue;
			trs.eq(i).remove();
		}
		
		//将选中订单的明细形成新行插入
		for(var i=0;pros[i];i++) {
			var newTr = trTpl.clone(true);
			var g = $(\'[name="productId[]"]\',newTr).parents(\'.input-group\');
			$(\'[name="textBox"]\',g).val(pros[i].proCode);
			$(\'[name="productId[]"]\',newTr).val(pros[i].productId);
			$(\'[name="pinzhong[]"]\',newTr).val(pros[i].pinzhong);
			$(\'[name="guige[]"]\',newTr).val(pros[i].guige);
			$(\'[name="color[]"]\',newTr).val(pros[i].color);
			$(\'[name="ganghao[]"]\',newTr).val(pros[i].ganghao);
			$(\'[name="pihao[]"]\',newTr).val(pros[i].pihao);
			$(\'[name="cnt[]"]\',newTr).val(pros[i].cnt);
			$(\'[name="cntJian[]"]\',newTr).val(pros[i].cntJian);
			$(\'[name="planGxId[]"]\',newTr).val(pros[i].planGxId);
			$(\'[name="plan2proId[]"]\',newTr).val(pros[i].plan2proId);
			$(\'[name="dengji[]"]\',newTr).val(pros[i].dengji);
			var g = $(\'[name="planGxId[]"]\',newTr).parents(\'.input-group\');
			$(\'[name="textBox"]\',g).val(pros[i].touliaoCode);

			parent.append(newTr);
		}
	});
});
'; ?>

</script>