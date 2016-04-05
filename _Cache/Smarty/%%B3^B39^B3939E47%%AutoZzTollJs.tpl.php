<?php /* Smarty version 2.6.10, created on 2014-11-04 09:50:39
         compiled from Shengchan/Cangku/AutoZzTollJs.tpl */ ?>
<script language="javascript">
<?php echo '

/**
 * 给投料按钮加载单机事件
*/
$(function(){
	//自动投料
	$(\'[name="autoZhizao[]"]\').click(function(){
		var obj = this;
		$(obj).attr(\'disabled\',true);
		$(\'#touliaoAuto\').attr(\'disabled\',true);
		//获取当前的plan2proId,productId,cnt
		var tr = $(this).parents(\'.trRow\');
		var color = $(\'[name="color[]"]\',tr).val();
		var planGxId = $(\'[name="planGxId[]"]\',tr).val()||0;
		var _g = $(\'[name="planGxId[]"]\',tr).parents(\'.input-group\');
		var touliaoCode = $(\'[name="textBox"]\',_g).val();
		var cnt = $(\'[name="cnt[]"]\',tr).val()||0;
		var productId = $(\'[name="productId[]"]\',tr).val()||0;

		//如果plan2proId，productId都不存在，则不能触发
		if(productId==0){
			alert("请先选择产品信息!");
			$(obj).attr(\'disabled\',false);
			$(\'#touliaoAuto\').attr(\'disabled\',false);
			return false;
		}

		//通过ajax获取投料的信息，并自动计算理论投料数量
		var url = "?controller=Shengchan_plan&action=GetTouliaoInfoByAjax";
		var param = {\'productId\':productId,\'planGxId\':planGxId,\'color\':color};

		$.getJSON(url,param,function(json){
			//有投料信息，自动填充投料信息
			if(json.success){
				//判断是否空行够，否则需要添加新行
				_autoAddRow(json.rowLen);

				//填充数据
				var _proInput = $(\'.trRow\',\'#table_main\').find(\'[name="productId[]"][value=""]\');
				for(var i=0;json.data[i];i++){
					// debugger;
					var data = json.data[i];
					//获取所在行
					var tr = $(_proInput).eq(i).parents(\'.trRow\');
					// $(\'[name="plan2proId[]"]\',tr).val(data.plan2proId);
					$(\'[name="planGxId[]"]\',tr).val(planGxId);
					var g = $(\'[name="planGxId[]"]\',tr).parents(\'.input-group\');
					$(\'[name="textBox"]\',g).val(touliaoCode);
					$(\'[name="productId[]"]\',tr).val(data.productId);
					var g = $(\'[name="productId[]"]\',tr).parents(\'.input-group\');
					$(\'[name="textBox"]\',g).val(data.Product.proCode);
					$(\'[name="zhonglei[]"]\',tr).val(data.Product.zhonglei);
					$(\'[name="proName[]"]\',tr).val(data.Product.proName);
					$(\'[name="supplierId[]"]\',tr).val(data.supplierId);
					$(\'[name="guige[]"]\',tr).val(data.Product.guige);
					$(\'[name="color[]"]\',tr).val(data.color);
					$(\'[name="dengji[]"]\',tr).val(\'一等品\');

					var _cnt=(cnt*data.chengfenPer/100*(1+data.sunhao/100)).toFixed(2);
					$(\'[name="cnt[]"]\',tr).val(_cnt);
				}
			}
		});

		setTimeout(function(){
	        $(obj).attr(\'disabled\',false);
	        $(\'#touliaoAuto\').attr(\'disabled\',false);
	      }, 1000);
	});


	/**
	 * 全部一起投料事件
	*/
	$(\'#touliaoAuto\').click(function(){
		var obj = this;
		//按钮禁止使用
		$(obj).attr(\'disabled\',true);
		$(\'[name="autoZhizao[]"]\').attr(\'disabled\',true);
		//需要操作的表id
		var _tblId=\'#table_main\';

		//判断是否已经存在选择的产品信息
		var hasTl = $(\'.trRow\',_tblId).find(\'[name="productId[]"][value!=""]\');

		//删除所有的投料记录
		if(hasTl.length>0 && confirm("是否删除已录入的投料记录?")){
			_autoAddRow(1);
			$(hasTl).parents(\'.trRow\').remove();
		}

		//开始查找对应的多条信息
		var _arr =[];
		$(\'.trRow\').each(function(){
			var planGxId = $(\'[name="planGxId[]"]\',this).val()||0;
			var productId = $(\'[name="productId[]"]\',this).val()||0;
			var cnt = $(\'[name="cnt[]"]\',this).val()||0;

			if(planGxId!=0 || productId!=0){
				_arr.push({\'planGxId\':planGxId,\'productId\':productId,\'cnt\':cnt});
			}
		});

		var url = "?controller=Shengchan_plan&action=GetTouliaoInfoAllByAjax";

		$.getJSON(url,{\'param\':_arr},function(json){
			//有投料信息，自动填充投料信息
			if(json.success){
				//判断是否空行够，否则需要添加新行
				_autoAddRow(json.rowLen);

				//填充数据
				var _proInput = $(\'.trRow\',\'#table_main\').find(\'[name="productId[]"][value=""]\');
				for(var i=0;json.data[i];i++){
					// debugger;
					var data = json.data[i];
					//获取所在行
					var tr = $(_proInput).eq(i).parents(\'.trRow\');
					// $(\'[name="plan2proId[]"]\',tr).val(data.plan2proId);
					$(\'[name="planGxId[]"]\',tr).val(data.planGxId);
					var g = $(\'[name="planGxId[]"]\',tr).parents(\'.input-group\');
					$(\'[name="textBox"]\',g).val(data.touliaoCode);
					$(\'[name="productId[]"]\',tr).val(data.productId);
					var g = $(\'[name="productId[]"]\',tr).parents(\'.input-group\');
					$(\'[name="textBox"]\',g).val(data.Product.proCode);
					$(\'[name="zhonglei[]"]\',tr).val(data.Product.zhonglei);
					$(\'[name="proName[]"]\',tr).val(data.Product.proName);
					$(\'[name="supplierId[]"]\',tr).val(data.supplierId);
					$(\'[name="guige[]"]\',tr).val(data.Product.guige);
					$(\'[name="color[]"]\',tr).val(data.color);
					$(\'[name="dengji[]"]\',tr).val(\'一等品\');
					$(\'[name="cnt[]"]\',tr).val(data.cntTl);
				}
			}
		});

		// dump(_arr);

		//按钮可以使用
		setTimeout(function(){
	        $(obj).attr(\'disabled\',false);
	        $(\'[name="autoZhizao[]"]\').attr(\'disabled\',false);
	      }, 1000);
	});
});

/**
 * 判断是否有空行
*/
function _autoAddRow(cnt){
	//查找空行的数量
	var trs = $(\'.trRow\',\'#table_main\');
	var length = $(trs).find(\'[name="productId[]"][value=""]\').length;

	//如果cnt(需要的空行数) > 实际的空行数
	if(cnt > length){
		//复制行数
		var len = trs.length;
		var trTpl = trs.eq(len-1).clone(true);
		var parent = trs.eq(0).parent();
		$(\'input,select\',trTpl).val(\'\');

		for(var i=length;i<cnt;i++){
			var newTr = trTpl.clone(true);
			parent.append(newTr);
		}
	}

}
'; ?>

</script>