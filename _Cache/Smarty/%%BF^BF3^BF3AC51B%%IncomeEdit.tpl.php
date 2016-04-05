<?php /* Smarty version 2.6.10, created on 2014-12-03 02:39:55
         compiled from Caiwu/Ys/IncomeEdit.tpl */ ?>
<?php echo '
<script language="javascript">
$(function(){

	//过账选中应收款信息后的触发事件
	$(\'[name="_edit2[]"]\').change(function(){	
		var tr=$(this).parents(\'.trRow\');
		var check = $(\'[name="_edit2[]"]\',tr).attr(\'checked\');		
		if(check){
			$(\'[name="incomeOver2[]"]\',tr).attr(\'checked\',true);
		}else{
			$(\'[name="incomeOver2[]"]\',tr).attr(\'checked\',false);
		}

	});
 //相同单号选中
	$(\'[name="_edit2[]"]\').click(function(){
		//alert(123);
		if(this.checked){		 
			 var trs = $(this).parents(\'tr\');
			 var Code=$(\'[name="Code[]"]\',trs).val();
			 //alert(Code);
			 $(\'[name="Code[]"]\').each(function(){		 
			 if($(this).val()==Code){				
				 var trs2 = $(this).parents(\'tr\');
				 $(\'[name="_edit2[]"]\',trs2).attr("checked", "checked");
				 $(\'[name="incomeOver2[]"]\',trs2).attr("checked", "checked");					 
				}		
				});
			};
	});




	//添加单机事件
	$(\'#btnSel\',\'#table_main\').click(function(){
      _Insert(\'#table_main\');
    });

	$(\'#btnSel\',\'#table_main\').bind(\'beforeInsert\',function(event,param){
		param[\'clientId\']=$(\'#clientId\').val();
		return param;
	});

	//加载应收款信息
	$(\'#btnSel\',\'#table_main\').bind(\'afterClick\',function(event,data){
		var tblId = \'#\'+$(this).parents(\'table\').attr(\'id\');

		var trs = $(\'.trRow\',tblId);
		var len = trs.length;
		var trTpl = trs.eq(len-1).clone(true);
		var parent = trs.eq(0).parent();

		$(\'input,select\',trTpl).val(\'\');
		$(\'span\',trTpl).html(\'\');

		$(\'.trRow\',\'#table_main\').remove();

		for(var i=0;data[i];i++){
			var t=data[i];
			var newTr = trTpl.clone(true);
			$(\'[name="fapiaoDate[]"]\',newTr).html(t.fapiaoDate);
			$(\'[name="fapiaoCode[]"]\',newTr).html(t.fapiaoCode);
			$(\'[name="_money[]"]\',newTr).html(t.money);
			$(\'[name="huilv[]"]\',newTr).html(t.huilv);
			$(\'[name="bizhong[]"]\',newTr).html(t.bizhong);
			$(\'[name="money[]"]\',newTr).val((t.money-t.ysmoney).toFixed(2));
			$(\'[name="ysmoney[]"]\',newTr).html(t.ysmoney);
			$(\'[name="fapiaoId[]"]\',newTr).val(t.id);
			$(\'[name="incomeOver[]"]\',newTr).attr(\'value\',i);
			$(\'[name="_edit[]"]\',newTr).attr(\'value\',i);

			parent.append(newTr);
		}
	});
	
	$(\'#btnSel\',\'#table_else\').bind(\'beforeInsert\',function(event,param){
		param[\'clientId\']=$(\'#clientId\').val();
		return param;
	});
	
	$(\'#btnSel\',\'#table_else\').click(function(){
      _Insert(\'#table_else\');
    });
    //核销加载
	$(\'#btnSel\',\'#table_else\').bind(\'afterClick\',function(event,data){
		var tblId = \'#\'+$(this).parents(\'table\').attr(\'id\');

		var trs = $(\'.trRow\',tblId);
		var len = trs.length;
		var trTpl = trs.eq(len-1).clone(true);
		var parent = trs.eq(0).parent();

		$(\'input,select\',trTpl).val(\'\');
		$(\'span\',trTpl).html(\'\');

		$(\'.trRow\',\'#table_else\').remove();

		for(var i=0;data[i];i++){
			var t=data[i];
			var newTr = trTpl.clone(true);
			$(\'[name="chukuDate[]"]\',newTr).html(t.chukuDate);
			$(\'[name="Code[]"]\',newTr).html(t.Code);
			$(\'[name="orderCode[]"]\',newTr).html(t.orderCode);
			$(\'[name="qitaMemo[]"]\',newTr).html(t.qitaMemo);
			$(\'[name="pinzhong[]"]\',newTr).html(t.pinzhong);
			$(\'[name="guige[]"]\',newTr).html(t.guige);
			$(\'[name="dengji[]"]\',newTr).html(t.dengji);
			$(\'[name="color[]"]\',newTr).html(t.color);
			$(\'[name="cnt[]"]\',newTr).html(t.cnt+t.unit);
			$(\'[name="danjia[]"]\',newTr).html(t.danjia);
			$(\'[name="gmoney[]"]\',newTr).val(t.money);
			$(\'[name="huilv[]"]\',newTr).html(t.huilv);
			//$(\'[name="money[]"]\',newTr).val(t.money-t.ykmoney);
			$(\'[name="ykmoney[]"]\',newTr).html(t.ykmoney);
			$(\'[name="guozhangId[]"]\',newTr).val(t.id);
			$(\'[name="orderId[]"]\',newTr).val(t.orderId);
			$(\'[name="ord2proId[]"]\',newTr).val(t.ord2proId);
			//$(\'[name="fapiaoOver[]"]\',newTr).attr(\'value\',i);
			$(\'[name="incomeOver2[]"]\',newTr).attr(\'value\',i);
			$(\'[name="_edit2[]"]\',newTr).attr(\'value\',i);

			parent.append(newTr);
		}
		
	
		
	});
	
	

	//选中应收款信息后的触发事件
	$(\'[name="_edit[]"],[name="money[]"]\').change(function(){
		var tr=$(this).parents(\'.trRow\');
		var check = $(\'[name="_edit[]"]\',tr).attr(\'checked\');
		var money=parseFloat($(\'[name="money[]"]\',tr).val())||0;
		var ysmoney=parseFloat($(\'[name="ysmoney[]"]\',tr).html())||0;
		var _money=parseFloat($(\'[name="_money[]"]\',tr).html())||0;
		var rate = money/(_money-ysmoney);
		if(check && rate>0.98){
			$(\'[name="incomeOver[]"]\',tr).attr(\'checked\',true);
		}else{
			$(\'[name="incomeOver[]"]\',tr).attr(\'checked\',false);
		}

		$(\'#skmoney\').val(getHejiKp());
	});

	
});

/**
 * 获取金额合计
 * Time：2014/08/05 16:38:28
 * @author li
*/
function getHejiKp(){
	var heji =0;
	$(\'[name="money[]"]\').each(function(){
		var tr=$(this).parents(\'.trRow\');
		var check = $(\'[name="_edit[]"]\',tr).attr(\'checked\');
		var money=parseFloat($(\'[name="money[]"]\',tr).val())||0;

		if(check){
			heji+=money;
		}
	});
	return heji;
}
</script>
'; ?>