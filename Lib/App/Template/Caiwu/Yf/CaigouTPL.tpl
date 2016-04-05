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
    
       $('[name="danjia[]"]').change(function(){    
	       var trs = $(this).parents('tr');
	       var danjia=$(this).val();
		   var id=$('[name="id[]"]',trs).val();
		   var cnt=$('[name="cnt[]"]',trs).val();
		   var money1=$('[name="money[]"]',trs).val();
		   var hmoney1=$('#hmoney').val();
		   var money=danjia*cnt;
		   var hmoney=hmoney1-money1+money;
	       $('[name="money[]"]',trs).val(money);
	       $('#hmoney').val(hmoney);
	       var url="?controller=Shengchan_Ruku&action=UpdateDanjia";
	       var param={id:id,money:money,danjia:danjia};
	       $.getJSON(url,param,function(json){
	       });
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
		    		<th>包数</th>
		    		<th>备注</th>
		    	</tr>
		    </thead>
		    <tbody>
		    {foreach from=$ret item=item}    
		    	<tr  style="text-align:left;">
		    		<td>{$item.rukuCode}</td>
		    		<td><input type='text' class="form-control" id='cnt[]' name='cnt[]' value='{$item.cnt}' readonly/></td>
		    		<td><input type='text' class="form-control" id='danjia[]' name='danjia[]' value='{$item.danjia}' />
		    		<input type='hidden' style="width:50px;" id='id[]' name='id[]' value='{$item.id}' />
		    		</td>
		    		<td><input type='text' class="form-control" id='money[]' name='money[]' value='{$item.money}' readonly/></td>	    		
		    		<td>{$item.proName}</td>
		    		<td>{$item.guige}</td>	
		    		<td>{$item.color}</td>	    				    		   		
		    		<td>{$item.cntJian}</td>		    				
		    		<td>{$item.memoView}</td>
		    	</tr>
		    {/foreach} 
		     <tr style="text-align:left;">
		    		<td>合计</td>
		    		<td>{$heji.cnt}</td>
		    		<td>&nbsp;</td>
		    		<td><input type='text' class="form-control" id='hmoney' name='hmoney' value='{$heji.money}' readonly/></td>
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