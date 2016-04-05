<?php /* Smarty version 2.6.10, created on 2015-11-25 15:32:56
         compiled from Shengchan/CpckJs.tpl */ ?>
<script language="javascript">
<?php echo '
	$(function(){
		$(\'[name="kuweiId"]\').bind(\'onSel\',function(){
			
		});

		$(\'#kuweiId\').bind(\'beforeOpen\',function(event,url){
			var jiagonghuId=$(\'#jiagonghuId\').val()||0;
			if(jiagonghuId>0)url+="&jiagonghuId="+jiagonghuId;
			// alert(url);
			return url;
		});

	


	$(\'[name="ord2proId[]"]\').bind(\'beforeOpen\',function(event,url){
		var tr = $(this).parents(\'.trRow\');
		var clientId=$(\'#clientId\').val();

		if(clientId!=\'\')url+="&clientId="+clientId;
		return url;
	});

	$(\'[name="ord2proId[]"]\').bind(\'onSel\',function(event,ret){
		var nt = $(this).parents(\'.trRow\');
		//为控件赋值
		var g = $(\'[name="productId[]"]\',nt).parents(\'.input-group\');
		$(\'[name="textBox"]\',g).val(ret.proCode);
		$(\'[name="proCode[]"]\',nt).val(ret.proCode);
		$(\'[name="pinzhong[]"]\',nt).val(ret.pinzhong);
		$(\'[name="guige[]"]\',nt).val(ret.guige);
		$(\'[name="color[]"]\',nt).val(ret.color);
		$(\'[name="menfu[]"]\',nt).val(ret.menfu);
		$(\'[name="kezhong[]"]\',nt).val(ret.kezhong);
		$(\'[name="productId[]"]\',nt).val(ret.productId);
		$(\'[name="ord2proId[]"]\',nt).val(ret.id);
		$(\'[name="danjia[]"]\',nt).val(ret.danjia);
		$(\'[name="cntYaohuo[]"]\',nt).val(ret.cntYaohuo+ret.unit);
		$(\'[name="unit[]"]\',nt).val(ret.unit);
		$(\'[name="cntHaveck[]"]\',nt).val(ret.cntYf);
		$(\'[name="dengji[]"]\',nt).val(\'一等品\');
		$(\'[name="memoView[]"]\',nt).val(ret.memo);
	});


	//选择产品
	$(\'[name="productId[]"]\').bind(\'onSel\',function(event,ret){
		var tr = $(this).parents(\'.trRow\');
		$(\'[name="pinzhong[]"]\',tr).val(ret.pinzhong);
		$(\'[name="guige[]"]\',tr).val(ret.guige);
		$(\'[name="color[]"]\',tr).val(ret.color);
		$(\'[name="ganghao[]"]\',tr).val(ret.ganghao);
		$(\'[name="pihao[]"]\',tr).val(ret.pihao);
		$(\'[name="cnt[]"]\',tr).val(ret.cnt);
		$(\'[name="cntJian[]"]\',tr).val(ret.cntJian);
		$(\'[name="dengji[]"]\',tr).val(ret.dengji);

		$(\'[name="cnt[]"]\',tr).change();
	});
	//绑定事件：弹出窗口打开指定url之前处理url
	$(\'[name="productId[]"]\').bind(\'beforeOpen\',function(event,url){
		var tr = $(this).parents(\'.trRow\');
		var kuweiId=$(\'#kuweiId\').val();
		var color=$(\'[name="color[]"]\',tr).val();
		var type=$(\'[name="type"]\').val()||\'\';
		var productId=$(\'[name="productId[]"]\',tr).val()||0;

		// if(productId==0){
		// 	alert(\'请先选择订单明细信息，产品信息不能为空!\');
		// 	return false;
		// }

		if(kuweiId>0)url+="&kuweiId="+kuweiId;
		if(color!=\'\')url+="&color="+color;
		if(type!=\'\')url+="&typeHzl="+type;
		if(productId!=\'\')url+="&productId="+productId;

		return url;
	});

	/*
	* kg数量change事件自动计算M数
	*/
	$(\'[name="cnt[]"]\').change(function(){
		var pos=$(\'[name="cnt[]"]\').index(this);
		var cnt = parseFloat($(this).val())||0;
		var menfu = parseFloat($(\'[name="menfu[]"]\').eq(pos).val())||0;
		var kezhong = parseFloat($(\'[name="kezhong[]"]\').eq(pos).val())||0;
		
		//数量换算：m=kg/（幅宽*克重/1000）
		var cntM = (menfu*kezhong) == 0 ? 0 : cnt/(menfu*kezhong/1000);
		cntM = cntM.toFixed(2);
		$(\'[name="cntM[]"]\').eq(pos).val(cntM);

		getMoney_1(this);
	});

	$(\'[name="cntM[]"]\').change(function(){
		getMoney_1(this);
	});

	//计算金额x信息
	function getMoney_1(obj){
		var pos=$(\'[name="\'+obj.name+\'"]\').index(obj);
		var cnt = parseFloat($(\'[name="cnt[]"]\').eq(pos).val())||0;
		var cntM = parseFloat($(\'[name="cntM[]"]\').eq(pos).val())||0;
		var danjia = parseFloat($(\'[name="danjia[]"]\').eq(pos).val())||0;
		//计算金额，需要考虑单位
		if($(\'[name="unit[]"]\').eq(pos).val()==\'M\'){
			$(\'[name="money[]"]\').eq(pos).val(cntM*danjia);
		}else{
			$(\'[name="money[]"]\').eq(pos).val(cnt*danjia);
		}
	}

	$(\'[name="cntM[]"]\').change();

	/**
	 * 复制按钮
	*/
	$(\'[id="btnCopy"]\',\'#table_main\').click(function(){
		var tr = $(this).parents(\'.trRow\');
		var nt = tr.clone(true);
	    
	    //有些数据需要制空
	    $(\'[name="ganghao[]"]\',nt).val(\'\');
	    $(\'[name="cnt[]"]\',nt).val(\'\');
	    $(\'[name="pihao[]"]\',nt).val(\'\');
	    $(\'[name="cntJian[]"]\',nt).val(\'\');
	    $(\'[name="cntM[]"]\',nt).val(\'\');
	    // $(\'[name="danjia[]"]\',nt).val(\'\');
	    $(\'[name="money[]"]\',nt).val(\'\');
	    $(\'[name="memoView[]"]\',nt).val(\'\');
	    $(\'[name="id[]"]\',nt).val(\'\');
	    //拼接
	    tr.after(nt);
	});
});
'; ?>

</script>