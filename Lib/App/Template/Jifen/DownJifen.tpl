<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{webcontrol type='LoadJsCss' src="Resource/Css/EditCommon.css"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/Common.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/Calendar/WdatePicker.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.validate.js"}
{webcontrol type='LoadJsCss' src="Resource/Css/validate.css"}
{literal}
<script language="javascript">
$(function(){

});


</script>
{/literal}
</head>
<body>
<form name="form1" id="form1" action="{$sys}?controller=Jifen_Comp&action=DownJifen" method="post">
{if $cnt>0}
<table id="tableList" style="width:100%; text-align:center">
 <tr style="background-color:#D4E2F4; font-size:12px; height:25px;">
  <td>公司编号</td>
  <td>公司简称</td>
  <td>经验值</td>
  <td>操作人员</td>
 
</tr>
{foreach from=$aRow item=item}
<tr>
  <td>{$item.compCode}</td>
  <td>{$item.compName}</td>
  <td>{$item.jinyan}</td>
  <td>{$item.creater}</td>
 
</tr>
{/foreach}
</table>
{/if}
<table id="buttonTable">
	<tr>
		<td><input type="submit" id="btnSave" name="btnSave" value='更新排名'>
       	  <input type="hidden" id="netPath" name="netPath" value="{$sys}"/>
            <input type="hidden" id="url" name="url" value="{$url}"/>
            <input type="hidden" id="fromController" name="fromController" value="{$smarty.get.controller}"/>
            <input type="hidden" id="fromAction" name="fromAction" value="{$smarty.get.action}"/>
        </td>
	</tr>
</table>
</form>
</body>
</html>
