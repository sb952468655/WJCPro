<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/Common.js"></script>
<script language="javascript" src="Resource/Script/TmisMenu.js"></script>
<script language="javascript" type="text/javascript" src="Resource/Script/Calendar/WdatePicker.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<script language="javascript">
{literal}
$(function(){
	$('#form1').validate({
		rules:{		
			'itemId':'required',
			//'bankId':'required',
			'shoukuanfang':'required',
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
{/literal}
</script>
<link href="Resource/Css/Edit.css" rel="stylesheet" type="text/css" />

</head>

<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post" >

<input name="id" type="hidden" id="id" value="{$aRow.id}" />

<table width="400px">
  <tr>
    <td height="33">流水号：</td>
    <td><input name="payCode" type="text" id="payCode" value="{$aRow.payCode}" readonly="readonly"/></td>
  </tr>
  <tr>
    <td height="33">往来日期：</td>
    <td><input name="comeDate" readonly type="text" id="comeDate"  value="{$aRow.comeDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
  </tr>
  <tr>
    <td>付款科目：</td>
    <td><select name="itemId" id="itemId">                    
    		{webcontrol type='TmisOptions' model='jichu_feiyong' selected=$aRow.itemId}    	
    </select></td>
  </tr>
  <tr>
    <td>收款方：</td>
    <td><input name="shoukuanfang" type="text" id="shoukuanfang" value="{$aRow.shoukuanfang}"></td>
  </tr>
  <tr>
    <td height="33">凭证号：</td>
    <td><input name="pingzhengCode" type="text" id="pingzhengCode" value="{$aRow.pingzhengCode}" /></td>
  </tr>
  <tr>
    <td height="33">付款日期：</td>
    <td><input name="payDate" readonly type="text" id="payDate"  value="{$aRow.payDate|default:$smarty.now|date_format:'%Y-%m-%d'}" size="15" onClick="calendar()"></td>
  </tr>
  <tr>
    <td height="33">支付方式：</td>
    <td><select name="zhifuWay" id="zhifuWay">   
			<option value="现金" {if $aRow.payWay == '现金'} selected="selected" {/if}>现金</option>
			<option value="支票" {if $aRow.payWay == '支票'} selected="selected" {/if}>支票</option>
			<option value="电汇" {if $aRow.payWay == '电汇'} selected="selected" {/if}>电汇</option>
			<option value="承兑" {if $aRow.payWay == '承兑'} selected="selected" {/if}>承兑</option>
			<option value="其它" {if $aRow.payWay == '其它'} selected="selected" {/if}>其它</option>
    </select></td>
  </tr>
   <tr>
    <td height="33">银行帐户：</td>
    <td>
		<select name="bankId" id="bankId">              
    		{webcontrol type='TmisOptions' model='Caiwu_Bank' selected=$aRow.bankId}
    	</select></td>
  </tr>
  <tr>
    <td height="34">付款金额：</td>
    <td><input name="money" type="text" id="money" value="{$aRow.money}" /></td>
  </tr>
  <tr>
    <td height="35">备注：</td>
    <td><input name="memo" type="text" id="memo" value="{$aRow.memo}" /></td>
    </tr>
  <tr>
    <td height="35">&nbsp;</td>
    <td><input type="submit" id="Submit" name="Submit" value='保存' class="button">
    {if $smarty.get.fromAction!=''}<input type="button" id="Back" name="Back" value='返回' onClick="javascript:window.history.go(-1);" class="button">{/if}
      <input name="fromAction" type="hidden" id="fromAction" value="{$smarty.get.fromAction}" /></td>
  </tr>
</table>
</form>
</body>
</html>
