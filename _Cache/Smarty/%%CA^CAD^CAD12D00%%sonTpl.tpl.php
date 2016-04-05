<?php /* Smarty version 2.6.10, created on 2014-11-11 21:24:41
         compiled from Shengchan/Cangku/sonTpl.tpl */ ?>
<?php echo '
<script language="javascript">
$(function(){
    $(\'[name="danjia[]"]\').change(function(){    
       var trs = $(this).parents(\'tr\');
       var danjia = parseFloat($(\'[name="danjia[]"]\',trs).val())||0;
       var rkCnt = parseFloat($(\'[name="rkCnt[]"]\',trs).val())||0;
	   var id=$(\'[name="id[]"]\',trs).val();	
	   var chuku2ProId=$(\'[name="chuku2ProId[]"]\',trs).val();     
       $(\'[name="money[]"]\',trs).val((danjia*rkCnt).toFixed(2));
       var money = parseFloat($(\'[name="money[]"]\',trs).val())||0;
       
       var param={id:id,chuku2ProId:chuku2ProId,money:money,danjia:danjia};
       save_ajax(param);
    });
    
    $(\'[name="money[]"]\').change(function(){    
       var trs = $(this).parents(\'tr\');
       var money = parseFloat($(\'[name="money[]"]\',trs).val())||0;
       var rkCnt = parseFloat($(\'[name="rkCnt[]"]\',trs).val())||0;
	   var id=$(\'[name="id[]"]\',trs).val();
	   var chuku2ProId=$(\'[name="chuku2ProId[]"]\',trs).val();
       $(\'[name="danjia[]"]\',trs).val((money/rkCnt).toFixed(6));
       
       var danjia = parseFloat($(\'[name="danjia[]"]\',trs).val())||0;
       
       var param={id:id,chuku2ProId:chuku2ProId,money:money,danjia:danjia};
       save_ajax(param);
    });
});

function save_ajax(param){
	var url="?controller=Shengchan_Cangku_Cgrk&action=UpdateDanjiaOrMoney";
    $.getJSON(url,param,function(json){
       
    });
}
</script>
'; ?>