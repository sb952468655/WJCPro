<?php /* Smarty version 2.6.10, created on 2014-11-13 20:15:15
         compiled from Caiwu/Yf/FukuanEdit.tpl */ ?>
<?php echo '
<script language="javascript">
$(function(){
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
			$(\'[name="fapiaoDate[]"]\',newTr).html(t.fapiaoDate);
			$(\'[name="fapiaoCode[]"]\',newTr).html(t.fapiaoCode);
			$(\'[name="head[]"]\',newTr).html(t.headname);
			$(\'[name="_money[]"]\',newTr).html(t.money);
			$(\'[name="money[]"]\',newTr).val((t.money-t.ysmoney).toFixed(2));
			$(\'[name="ysmoney[]"]\',newTr).html(t.ysmoney);
			$(\'[name="fapiaoId[]"]\',newTr).val(t.id);
			$(\'[name="fukuanOver[]"]\',newTr).attr(\'value\',i);
			$(\'[name="_edit[]"]\',newTr).attr(\'value\',i);

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
			$(\'[name="fukuanOver[]"]\',tr).attr(\'checked\',true);
		}else{
			$(\'[name="fukuanOver[]"]\',tr).attr(\'checked\',false);
		}

		$(\'#fkMoney\').val(getHejiKp());
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