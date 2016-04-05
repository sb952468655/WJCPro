<?php /* Smarty version 2.6.10, created on 2014-11-11 16:43:57
         compiled from Caiwu/Yf/sonTpl.tpl */ ?>
<?php echo '
<script language="javascript">
$(function(){
    $(\'#save\').click(function(){
    //alert(123);
    for(var i=0;i<25;i++){
      if($(\'[name="isGuozhang"]\',i).val()==1)alert($(\'[name="isGuozhang"]\',i).text);
    }
    });
	//应付金额随折扣金额和金额的变动而变动
	$(\'#_money,#zhekouMoney\').change(function(){
		var _money = parseFloat($(\'#_money\').val())||0;
		var zhekouMoney = parseFloat($(\'#zhekouMoney\').val())||0;
		var money = (_money-zhekouMoney).toFixed(2);
		$(\'#money\').val(money);
	});

	//单价的change事件
	$(\'#danjia\').change(function(){
		var danjia = parseFloat($(\'#danjia\').val())||0;
		var cnt = parseFloat($(\'#cnt\').val())||0;
		var money = (danjia*cnt).toFixed(2);
		$(\'#_money\').val(money);
		$(\'#money\').val(money);
	});

	//对控件的回调函数进行定义
	//ret为选中对象
	//为控件绑定一个自定义的事件,注意参数的写法
	$(\'[name="ruku2ProId"]\').bind(\'onSel\',function(event,ret){
		//如果单价为0，获取单价信息
		if(ret.danjia==0){
			var url="?controller=shengchan_ruku&action=getDanjiaByLs";
			var param={"ruku2ProId":ret.id};

			$.getJSON(url,param,function(json){
				$(\'#danjia\').val(json.danjia);//产品ID
				$(\'#danjia\').change();
			});
		}else{
			$(\'#danjia\').val(ret.danjia);//产品ID
		}
		//填充信息
		$(\'#qitaMemo\').val(ret.qitaMemo);//颜色
		$(\'#rukuId\').val(ret.rukuId);//主表订单Id
		// $(\'#ruku2ProId\').val(ret.ruku2ProId);//产品ID
		$(\'#supplierId\').val(ret.supplierId);//产品ID
		$(\'#productId\').val(ret.productId);//产品ID
		$(\'#rukuDate\').val(ret.rukuDate);//产品ID
		$(\'#cnt\').val(ret.cnt);//产品ID
		$(\'#Lcnt\').val(ret.Lcnt);//产品ID
		$(\'#id\').val(ret.rid);
		$(\'#_money\').val(ret.money);//产品ID
		// $(\'#kuweiName\').val(ret.kuweiName);//产品ID
		$(\'#kind\').val(ret.kind);//产品ID
		$(\'#isJiagong\').val(ret.isJiagong);//产品ID
		$(\'#isLingyong\').val(\'0\');//产品ID
		$(\'#chuku2ProId\').val(\'\');
		var group = $(\'#chuku2ProId\').parents(\'.input-group\');
		$(\'[name="textBox"]\',group).val(\'领料出库\');
		$(\'#_money\').change();
	});

	$(\'[name="chuku2ProId"]\').bind(\'onSel\',function(event,ret){
		//如果单价为0，获取单价信息
		if(ret.danjia==0){
			var url="?controller=shengchan_chuku&action=getDanjiaByLs";
			var param={"chuku2ProId":ret.id};

			$.getJSON(url,param,function(json){
				$(\'#danjia\').val(json.danjia);//产品ID
				$(\'#danjia\').change();
			});
		}else{
			$(\'#danjia\').val(ret.danjia);//产品ID
		}
		$(\'#qitaMemo\').val(ret.qitaMemo);//颜色
		$(\'#rukuId\').val(ret.chukuId);//主表订单Id
		// $(\'#ruku2ProId\').val(ret.ruku2ProId);//产品ID
		$(\'#supplierId\').val(ret.jiagonghuId);//产品ID
		$(\'#productId\').val(ret.productId);//产品ID
		$(\'#rukuDate\').val(ret.chukuDate);//产品ID
		$(\'#cnt\').val(ret.cnt);//产品ID
		// $(\'#danjia\').val(ret.danjia);//产品ID
		$(\'#_money\').val(ret.money);//产品ID
		// $(\'#kuweiName\').val(ret.kuweiName);//产品ID
		$(\'#kind\').val(ret.kind);//产品ID
		$(\'#isJiagong\').val(ret.isJiagong);//产品ID
		$(\'#isLingyong\').val(\'1\');//产品ID
		$(\'#ruku2ProId\').val(\'\');
		var group = $(\'#ruku2ProId\').parents(\'.input-group\');
		$(\'[name="textBox"]\',group).val(\'回收入库\');
		$(\'#_money\').change();
	});
});
</script>
'; ?>