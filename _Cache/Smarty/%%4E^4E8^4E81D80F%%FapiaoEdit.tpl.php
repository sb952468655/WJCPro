<?php /* Smarty version 2.6.10, created on 2014-11-28 16:01:23
         compiled from Caiwu/Yf/FapiaoEdit.tpl */ ?>
<?php echo '
<script language="javascript">
$(function(){
   
   //相同单号选中
	$(\'[name="_edit[]"]\').click(function(){
	//alert(123);
		if(this.checked){		 
			 var trs = $(this).parents(\'tr\');
			 var Code=$(\'[name="Code[]"]\',trs).val();
			 //alert(Code);
			 $(\'[name="Code[]"]\').each(function(){		 
			 if($(this).val()==Code){				
				 var trs2 = $(this).parents(\'tr\');
				 $(\'[name="_edit[]"]\',trs2).attr("checked", "checked");					 
				}		
			});
		};
	});



	//添加单机事件
	$(\'#btnSel\',\'#table_main\').click(function(){
      _Insert(\'#table_main\');
    });

	$(\'#btnSel\',\'#table_main\').bind(\'beforeInsert\',function(event,param){
		param[\'supplierId\']=$(\'#supplierId\').val();
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

		$(\'.trRow\').remove();

		for(var i=0;data[i];i++){
			var t=data[i];
			var newTr = trTpl.clone(true);
			$(\'[name="guozhangDate[]"]\',newTr).html(t.guozhangDate);
			$(\'[name="orderCode[]"]\',newTr).html(t.orderCode);
			$(\'[name="planCode[]"]\',newTr).html(t.planCode);
			$(\'[name="Code[]"]\',newTr).html(t.Code);
			$(\'[name="proName[]"]\',newTr).text(t.proName);
			$(\'[name="guige[]"]\',newTr).text(t.guige);
			$(\'[name="color[]"]\',newTr).text(t.color);
			
			//alert($(\'[name="proName[]"]\',newTr).val());
			//alert(t.money);
			$(\'[name="qitaMemo[]"]\',newTr).html(t.qitaMemo);
			$(\'[name="danjia[]"]\',newTr).html(t.danjia);
			$(\'[name="cnt[]"]\',newTr).html(t.cnt);
			$(\'[name="_money[]"]\',newTr).html(t.money);
			$(\'[name="money[]"]\',newTr).val((t.money-t.ykmoney).toFixed(2));
			$(\'[name="ykmoney[]"]\',newTr).html(t.ykmoney);
			$(\'[name="guozhangId[]"]\',newTr).val(t.id);
			$(\'[name="orderId[]"]\',newTr).val(t.orderId);
			$(\'[name="ord2proId[]"]\',newTr).val(t.ord2proId);
			$(\'[name="planId[]"]\',newTr).val(t.planId);
			$(\'[name="plan2proId[]"]\',newTr).val(t.plan2proId);
			$(\'[name="fapiaoOver[]"]\',newTr).attr(\'value\',i);
			$(\'[name="_edit[]"]\',newTr).attr(\'value\',i);

			parent.append(newTr);
			//debugger;
		}
	});



	//选中应收款信息后的触发事件
	$(\'[name="_edit[]"],[name="money[]"]\').change(function(){
		var tr=$(this).parents(\'.trRow\');
		var check = $(\'[name="_edit[]"]\',tr).attr(\'checked\');
		var money=parseFloat($(\'[name="money[]"]\',tr).val())||0;
		var ykmoney=parseFloat($(\'[name="ykmoney[]"]\',tr).html())||0;
		var _money=parseFloat($(\'[name="_money[]"]\',tr).html())||0;
		var rate = money/(_money-ykmoney);
		if(check && rate>0.98){
			$(\'[name="fapiaoOver[]"]\',tr).attr(\'checked\',true);
		}else{
			$(\'[name="fapiaoOver[]"]\',tr).attr(\'checked\',false);
		}

		$(\'#fpMoney\').val(getHejiKp());
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