{literal}
<script language="javascript">
$(function(){

//获得相同单号选中
$('[name="isChecked[]"]').click(function(){

	if(this.checked){		 

		 var trs = $(this).parents('tr');
		 var Code=$('[name="Code[]"]',trs).val();
		 if($('[name="danjia[]"]',trs).val()==0)alert('单价为空，请填写单价！');
		 //alert(Code);
		 $('[name="Code[]"]').each(function(){		 
		 if($(this).val()==Code){				
			 var trs2 = $(this).parents('tr');
			 $('[name="isChecked[]"]',trs2).attr("checked", "checked");					 
			}		
		});
	};
});

//单价变动影响金额
$('[name="danjia[]"]').change(function(){
	 	//debugger;
	    var trs = $(this).parents('tr');
	    var cnt=$('[name="cnt[]"]',trs).val();
		var danjia=$(this).val();
		var isLingyong=$('[name="isLingyong[]"]',trs).val()	
		var money=danjia*cnt;
		var zhekouMoney=$('[name="zhekouMoney[]"]',trs).val();
		var money2=money-zhekouMoney;
		$('[name="_money[]"]',trs).val(money2);
		$('[name="money[]"]',trs).val(money);	
		
		
		var id=$('[name="id[]"]',trs).val();
		
		//alert(id);alert(cnt);alert(money);
		var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
	    var param={id:id,isLingyong:isLingyong,money:money,danjia:danjia};
	    $.getJSON(url,param,function(json){
	       });
	   
	});
//应付金额随折扣金额和金额的变动而变动
	$('[name="_money[]"]').change(function(){
	 	//debugger;
	    var trs = $(this).parents('tr');
	    var money=$('[name="money[]"]',trs).val();
		var money2=$(this).val();	
		var zhekouMoney=money-money2;			
		$('[name="zhekouMoney[]"]',trs).val(zhekouMoney);
	});	
	$('[name="zhekouMoney[]"]').change(function(){
	    
	    var trs = $(this).parents('tr');
	    var money=$('[name="money[]"]',trs).val();
	    var zhekouMoney=$(this).val();
		var money2=money-zhekouMoney;
		$('[name="_money[]"]',trs).val(money2);

	});
    //应付款过账保存
	$('#save').click(function(){
	//alert(123);
	var ids=[];
	var zhekouMoney=[];
	var money2=[];
	var isLingyong=[];
	$('[name="isChecked[]"]').each(function(){
		if(this.checked){
		 
		 ids.push($(this).val());
		 var trs = $(this).parents('tr');
		 zhekouMoney.push($('[name="zhekouMoney[]"]',trs).val());		 
		 money2.push($('[name="_money[]"]',trs).val());
		 isLingyong.push($('[name="isLingyong[]"]',trs).val());
		
		};
	});
	if(ids.length>10){
		alert('最大允许选中的个数是10条信息，否则数据保存较慢');
	}
	if(ids.length==0){
	    alert('请选择要过账的记录！');
	    return false;
	}
	var ruku2ProId=ids.join(',');
	var str1=isLingyong.join(',');
	var str2=zhekouMoney.join(',');
	var str3=money2.join(',');
	//alert(str);
	var url='?controller=Shengchan_Ruku&action=JsonGuozhang';
	var param={ruku2ProId:ruku2ProId,str1:str1,str2:str2,str3:str3};
	$.getJSON(url,param,function(json){	  
		 if(json==true){
		 alert('保存成功');
		 }
	 window.location.reload();
	 })
	 $('#save').attr("disabled","disabled");
	});
	
	//应收款的过账保存
	$('#save2').click(function(){
	//alert(123);
	var ids=[];
	var zhekouMoney=[];
	var money2=[];
	$('[name="isChecked[]"]').each(function(){
		if(this.checked){
		ids.push($(this).val());
		var trs = $(this).parents('tr');
		 zhekouMoney.push($('[name="zhekouMoney[]"]',trs).val());		 
		 money2.push($('[name="_money[]"]',trs).val());
		 }
	});
	if(ids.length>10){
		alert('最大允许选中的个数是10条信息，否则数据保存较慢');
	}
	if(ids.length==0){
	    alert('请选择要过账的记录！');
	    return false;
	}
	var str=ids.join(',');
	var str2=zhekouMoney.join(',');
	var str3=money2.join(',');
	//alert(str);
	var url='?controller=Shengchan_Chuku&action=JsonGuozhang';
	var param={str:str,str2:str2,str3:str3};
	$.getJSON(url,param,function(json){
	 
		 if(json==true){
		 alert('保存成功');
		 }
	 window.location.reload();
	 })
	  $('#save2').attr("disabled","disabled");
	});
	
	
	
	
	
});
</script>
{/literal}