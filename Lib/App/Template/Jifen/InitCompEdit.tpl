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
	$('#form1').validate({
		rules:{		
			'compCode':'required',
			'compName':'required',
			'remoteJingyan':'required'
		}
    ,submitHandler : function(form){
      $('#Submit').attr('disabled',true);
      form.submit();
    }
	});
});
</script>
{/literal}
</head>
<body>
<table border="0" align="left" >
<tr>
<td width="60%" >
<fieldset>
<legend>①积分系统的网站路径</legend>
<form id="form2" name="form2" method="post" action="{url controller='Acm_SetParamters' action='save'}">
  <table width="100%" border="0" align="left" cellpadding="1" cellspacing="1" height="171px;">
   
  <tr>
    	<td  nowrap="nowrap">上传路径：
    	  <input type="hidden" id="itemName[]" name="itemName[]" value="积分系统网站路径">
	</label></td>
        <td align="left"><textarea name="value[]" id="value[]" style="width:300px">{$row.NetPath}</textarea>          <input type="hidden" id="item[]" name="item[]" value="NetPath">
          <br>
          如：http://www.4006690297.com/sezhi_jifen/index.php<br></td>
    </tr>
     <tr>
    	<td nowrap="nowrap">本地路径：
    	  <input type="hidden" id="itemName[]" name="itemName[]" value="本地系统网站路径">
	</label></td>
        <td align="left"><textarea name="value[]" id="value[]" style="width:300px">{$row.localNetPath}</textarea>          <input type="hidden" id="item[]" name="item[]" value="localNetPath">
          <br>如：http://192.168.1.177/sezhi/index.php</td>
    </tr>
   
 <tr>
     <td></td>
     <td></td>
 </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="确认网站路径" style="height:25px; width:120px;"/>
       
      </label></td>
    </tr>
  </table>
</form>
</fieldset>
</td>
<td width="40%" >
<fieldset>
<legend>②企业信息初始化</legend>
<form name="form1" id="form1" action="{$sys}?controller=Jifen_Comp&action=getCompCode" method="post">
<input name="id" type="hidden" id="id" value="{$aRow.id}" />
<table id="mainTable" height="140px;">
<tr>
  <td class="title">公司编号：</td>
  <td><input name="compCode" type="text" id="compCode" value="{$aRow.compCode}"/><span class="bitian">*</span></td>
  <td rowspan="4" align="right"><p>&nbsp;&nbsp;提示：公司编号</p><p>和公司简称必须和</p><p>网站上的保持一致</p></td>
</tr>
<tr>
	<td class="title">公司简称：</td>
	<td><input name="compName" type="text" id="compName" value="{$aRow.compName}"/><span class="bitian">*</span></td>
	</tr>
<tr>
<tr>
	<td class="title">公司全称：</td>
	<td><input name="compFullName" type="text" id="compFullName" value="{$aRow.compFullName}"/><span class="bitian">*</span></td>
	</tr>
    <!--
<tr>
<td class="title">初始经验值：</td>
<td><input name="initJingyan" type="text" id="initJingyan" value="{$aRow.initJingyan}"/><span class="bitian">*</span></td>
</tr>
-->


</table>

<table id="buttonTable" width="80%">
<tr>
		<td align="center">
		<input type="submit" id="Submit" name="Submit" value='确认企业信息' style="height:25px; width:120px;">
        <input type="hidden" id="netPath" name="netPath" value="{$sys}"/>
        <input type="hidden" id="url" name="url" value="{$url}"/>
        <input type="hidden" id="fromController" name="fromController" value="{$smarty.get.controller}"/>
        <input type="hidden" id="fromAction" name="fromAction" value="{$smarty.get.action}"/>
        </td>
	</tr>
</table>
</form>
</fieldset>
</td>

</tr>
</table>
</body>
</html>
