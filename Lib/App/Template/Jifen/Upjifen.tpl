<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
{webcontrol type='LoadJsCss' src="Resource/Css/EditCommon.css"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/Common.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/Calendar/WdatePicker.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.validate.js"}
{webcontrol type='LoadJsCss' src="Resource/Css/validate.css"}
{webcontrol type='LoadJsCss' src="Resource/Css/main1.css"}
{literal}
<script language="javascript">
$(function(){
	$('#form1').submit();
});

function getJy(){
	var jy=document.getElementById('jy').value;
	var jf=document.getElementById('jifen').value;
	if(jf=='' ||jf==0) return false;
	if(parseInt(jf)>parseInt(jy)){
		alert('本次上传经验值不能大于有效经验值');	
		document.getElementById('jifen').value='';
		document.getElementById('jifen').focus();
		return false;
	}
	return true;
}
</script>
<style type="text/css">
    html, body {
        font:normal 12px Arial;
        margin:0;
        padding:0;
        border:0 none;
        overflow:hidden;
        height:100%;
    }
    p {
        /*margin:5px;*/
    }
	#loading-mask {
		background-color:white;
		height:100%;
		left:0;
		position:absolute;
		top:0;
		width:100%;
		z-index:20000;
		background-color:#FFFFFF
	}
    </style>
{/literal}
</head>
<body >

<form name="form1" id="form1" action="{$sys}?controller=Jifen_User&action=UpJifen" method="post">
<!-- 公司经验值 -->
<table>
<tr>
	<td class="title">&nbsp;</td>
	<td>
	  <input type="hidden" id="jy" name="jy" value="{$aRow_com.remoteJingyan}">
    </td>
</tr>
<tr>
	<td class="title">&nbsp;</td>
    <td><input name="upDate" type="hidden" id="upDate" value="{$aRow_com.upDate|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"/>
    <input type="hidden" id="compCode" name="compCode" value="{$aRow_com.compCode}"/>
    </td>
</tr>
<tr>
    <td class="title">&nbsp;</td>
    <td><input name="jifen_comp" type="hidden" id="jifen_comp" value="{$aRow_com.remoteJingyan}"/></td>
</tr>
</table>
<!-- 公司经验值 end-->
<table id="tableList" style="width:100%; text-align:center">
<!--
 <tr style="background-color:#D4E2F4; font-size:12px; height:25px;">
  <td>用户编号</td>
  <td>姓名</td>
  <td>身份证号</td>
  <td>总积分</td>
  <td>总经验值</td>
  <td>有效积分值</td>
  <td>有效经验值</td>
  <td>本次上传积分值</td>
  <td>本次上传经验值</td>
</tr>
-->
{foreach from=$aRow item=item}
<tr>
  <td><input id="userCode[]" name="userCode[]" type="hidden" value="{$item.userCode}"/></td>
  <td><input id="realName[]" name="realName[]" type="hidden" value="{$item.realName}"/>
  		<input id="passwd[]" name="passwd[]" type="hidden" value="{$item.passwd}"/>
        <input id="id[]" name="id[]" type="hidden" value="{$item.id}"/>
  </td>
  <td><input id="shenfenzheng[]" name="shenfenzheng[]" type="hidden" value="{$item.shenfenzheng}"/></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td><input type="hidden" id="jifen[]" name="jifen[]" value="{$item.jifen}"></td>
  <td><input type="hidden" id="jingyan[]" name="jingyan[]" value="{$item.jingyan}"></td>
</tr>
{/foreach}
</table>
<br>
<table id="buttonTable">
	<tr>
		<td><input type="submit" id="btnSave" name="btnSave" value='保存' style="display:none;">
            <input type="hidden" id="netPath" name="netPath" value="{$sys}"/>
            <input type="hidden" id="shishiPeo" name="shishiPeo" value=""/>
            <input type="hidden" id="url" name="url" value="{$url}"/>
            <input type="hidden" id="fromController" name="fromController" value="{$smarty.get.controller}"/>
            <input type="hidden" id="fromAction" name="fromAction" value="{$smarty.get.fromAction}"/>
            <!--传递session 以防session丢失-->
            <input type="hidden" id="LANG" name="LANG" value="{$smarty.session.LANG}"/>
            <input type="hidden" id="SN" name="SN" value="{$smarty.session.SN}"/>
            <input type="hidden" id="USERID" name="USERID" value="{$smarty.session.USERID}"/>
            <input type="hidden" id="REALNAME" name="REALNAME" value="{$smarty.session.REALNAME}"/>
            <input type="hidden" id="USERNAME" name="USERNAME" value="{$smarty.session.USERNAME}"/>
        </td>
	</tr>
</table>
</form>
</body>
</html>
