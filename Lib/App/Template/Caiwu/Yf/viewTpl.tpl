<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.validate.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/Calendar/WdatePicker.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/common.js"}
{webcontrol type='LoadJsCss' src="Resource/Css/EditCommon.css"}
{webcontrol type='LoadJsCss' src="Resource/Css/validate.css"}
{webcontrol type='LoadJsCss' src="Resource/Script/ymPrompt/ymPrompt.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/ymPrompt/skin/bluebar/ymPrompt.css"}
{webcontrol type='LoadJsCss' src="Resource/Script/TmisPopup.js"}

{literal}
<style type="text/css">
	.form-control{
		max-width: 120px;
	}
</style>
<script language="javascript">

$(function(){   
       
       $('[name="danjia1[]"]').change(function(){    
       var trs = $(this).parents('tr');
       var danjia=$(this).val();
	   var id=$('[name="id1[]"]',trs).val();
	   var cnt=$('[name="cnt1[]"]',trs).val();
	   var money1=$('[name="money1[]"]',trs).val();
	   var hmoney1=$('#hmoney1').val();
	   var money=danjia*cnt;
	   var hmoney=hmoney1-money1+money;
       $('[name="money1[]"]',trs).val(money);
       $('#hmoney1').val(hmoney);
       var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
       var param={id:id,money:money.toFixed(2),danjia:danjia};
       $.getJSON(url,param,function(json){
       
       });
       // window.parent.location.href=window.parent.location.href;
       
    });
    $('[name="danjia2[]"]').change(function(){    
       var trs = $(this).parents('tr');
       var danjia=$(this).val();
       
	   var id=$('[name="id2[]"]',trs).val();
	   var cnt=$('[name="cnt2[]"]',trs).val();
	   var money1=$('[name="money2[]"]',trs).val();
	   var hmoney1=$('#hmoney2').val();
	   var money=danjia*cnt;
	   var hmoney=hmoney1-money1+money;
       $('[name="money2[]"]',trs).val(money);
       $('#hmoney2').val(hmoney);
       var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
       var param={id2:id,money:money.toFixed(2),danjia:danjia};
     
       $.getJSON(url,param,function(json){
       
       });
       // window.parent.location.href=window.parent.location.href;
       
    });

    $('#Submit').click(function(){
    	window.close();
    	window.parent.location.href=window.parent.location.href;
    });
});
</script>
{/literal}
<body>
<div class="panel panel-info">
	<div class="panel-heading">
	  <h3 class="panel-title" style="text-align:left;">验收明细</h3>
	</div>
	<div class="panel-body" style="overflow:auto;max-height:320px;">
		<div class="table-responsive">
		  <table class="table table-hover">
		    <thead>
		    	<tr>
		    		<th>入库编号</th>
		    		<th>数量(Kg)</th>
		    		<th>单价</th>
		    		<th>金额</th>
		    		<th>纱支</th>
		    		<th>规格</th>
		    		<th>颜色</th>
		    		<th>等级</th> 
		    		<th>品种</th> 
		    		<th>缸号</th>   		
		    		<th>件数</th>		    		
		    		<th>备注</th>
		    	</tr>
		    </thead>
		    <tbody>
		    {foreach from=$ret1 item=item}    
		    	<tr>
		    		<td>{$item.rukuCode}</td>
		    		<td><input type='text' class="form-control" id='cnt1[]' name='cnt1[]' value='{$item.cnt}' readonly/></td>
		    		<td><input type='text' class="form-control" id='danjia1[]' name='danjia1[]' value='{$item.danjia}' />
		    		<input type='hidden' class="form-control" id='id1[]' name='id1[]' value='{$item.id}' /></td>
		    		<td><input type='text' class="form-control" id='money1[]' name='money1[]' value='{$item.money}' readonly/></td>
		    		<td>{$item.proName}</td>
		    		<td>{$item.guige}</td>	
		    		<td>{$item.color}</td>		    		
		    		<td>{$item.dengji}</td>
		    		<td>{$item.pinzhong}</td>    				    		
		    		<td>{$item.ganghao}</td>	    		
		    		<td>{$item.cntJian}</td>	    
		    		<td>{$item.memoView}</td>
		    	</tr>
		    {/foreach} 
		     <tr>
		    		<td>合计</td>
		    		<td>{$heji1.cnt}</td>
		    		<td>&nbsp;</td>
		    		<td><input type='text' class="form-control" id='hmoney1' name='hmoney1' value='{$heji1.money}' readonly/></td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>

		    		
		    	</tr>
		    </tbody>
		  </table>
		</div>
	</div>
</div>

<div class="panel panel-info">
	<div class="panel-heading">
	  <h3 class="panel-title" style="text-align:left;">领用明细</h3>
	</div>
	<div class="panel-body" style="overflow:auto;max-height:320px;">
		<div class="table-responsive">
		  <table class="table table-condensed table-striped">
		    <thead>
		    	<tr>
		    		<th>出库编号</th>
		    		<th>数量(Kg)</th>
		    		<th>单价</th>
		    		<th>金额</th>
		    		<th>纱支</th>
		    		<th>规格</th>
		    		<th>颜色</th>
		    		<th>等级</th> 
		    		<th>批号</th>
		    		<th>缸号</th>	    		
		    		<th>件数</th>		    		
		    		<th>备注</th>
		    	</tr>
		    </thead>
		    <tbody>
		    	{foreach from=$ret2 item=item}    
		    	<tr>
		    		<td>{$item.chukuCode}</td>
		    		<td><input type='text' class="form-control" id='cnt2[]' name='cnt2[]' value='{$item.cnt}' readonly/></td>
		    		<td><input type='text' class="form-control" id='danjia2[]' name='danjia2[]' value='{$item.danjia}' />
		    		<input type='hidden' class="form-control" id='id2[]' name='id2[]' value='{$item.id}' /></td>
		    		<td><input type='text' class="form-control" id='money2[]' name='money2[]' value='{$item.money}' readonly/></td>
		    		<td>{$item.proName}</td>
		    		<td>{$item.guige}</td>	
		    		<td>{$item.color}</td>		    		
		    		<td>{$item.dengji}</td>
		    		<td>{$item.pihao}</td>	    				    		
		    		<td>{$item.ganghao}</td>	    		
		    		<td>{$item.cntJian}</td> 
		    		<td>{$item.memoView}</td>
		    	</tr>
		    {/foreach} 
		    <tr>
		    		<td>合计</td>
		    		<td>{$heji2.cnt}</td>
		    		<td>&nbsp;</td>
		    		<td><input type='text' class="form-control" id='hmoney2' name='hmoney2' value='{$heji2.money}' readonly/></td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    		<td>&nbsp;</td>
		    	</tr>
		    </tbody>
		  </table>
		</div>
	</div>
</div>
<div class="form-group">
  <div class="col-sm-offset-4 col-sm-4">
      <input class="btn btn-primary" type="button" id="Submit" name="Submit" value=" 确定 ">
  </div>
</div>

</body>
</html>