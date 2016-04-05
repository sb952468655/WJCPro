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
<script language="javascript">

$(function(){   
       
      $('#form1').validate({
		rules:{		
			'dakuanfang':'required',
			'money':'required'
		},
		submitHandler : function(form){
			$('#Submit').attr('disabled',true);
			form.submit();
		}
	});
});

$(function(){
	ret2cab();	   
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
		  <form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" >
          <input name="id" type="hidden" id="id" value="{$aRow.id}" />

			<table>
			  <tr>
			    <th>流水号：</th>
			    <td><input name="incomeCode" style="width:140px;" type="text" id="incomeCode" value="{$aRow.incomeCode}" readonly="readonly"/></td>
			  </tr>
			  <tr>
			     <th>打款方：</th>
			    <td><input name="dakuanfang" style="width:140px;" type="text" id="dakuanfang" value="{$aRow.dakuanfang}"></td>
			  </tr>
			  <tr>
			    <th>收款日期：</th>
			    <td><input name="incomeDate" style="width:140px;" readonly type="text" id="incomeDate"  value="{$aRow.incomeDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
			  </tr>
			  <tr>
			    <th>打款方式：</th>
			    <td><select width=80 name="zhifuWay" style="width:140px;" id="zhifuWay">   
						<option value="现金" {if $aRow.incomeWay == '现金'} selected="selected" {/if}>现金</option>
						<option value="支票" {if $aRow.incomeWay == '支票'} selected="selected" {/if}>支票</option>
						<option value="电汇" {if $aRow.incomeWay == '电汇'} selected="selected" {/if}>电汇</option>
						<option value="承兑" {if $aRow.incomeWay == '承兑'} selected="selected" {/if}>承兑</option>
						<option value="其它" {if $aRow.incomeWay == '其它'} selected="selected" {/if}>其它</option>
			    </select></td>
			  </tr>
			   <tr>
			    <th>银行帐户：</th>
			    <td>
					<select name="bankId" style="width:140px;" id="bankId" check='^0$' warning='请选择银行帐户!'>              
			    		{webcontrol type='TmisOptions' model='Caiwu_Bank' selected=$aRow.bankId}
			    	</select></td>
			  </tr>
			  <tr>
			    <th>收款金额：</th>
			    <td><input name="money" style="width:140px;" type="text" id="money" value="{$aRow.money}" /></td>
			  </tr>
			  <tr>
			    <th>备注：</th>
			    <td><input name="memo" type="text" id="memo" value="{$aRow.memo}" /></td>
			    </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td><input type="submit" id="Submit" name="Submit" value='保存' class="button">
					{if $smarty.get.fromAction!=''}<input type="button" id="Back" name="Back" value='返回' onClick="javascript:window.history.go(-1);" class="button">{/if}
			      <input name="fromAction" type="hidden" id="fromAction" value="{$smarty.get.fromAction}" /></td>
			  </tr>
			</table>
			</form>
		</div>
	</div>
</div>


</body>
</html>