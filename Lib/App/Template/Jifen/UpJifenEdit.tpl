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
	/*$('#btnSave').click(function(){										 
								 debugger;
	 	var jifen=document.getElementById('jifen');
		var compCode=document.getElementById('compCode');
		var upDate=document.getElementById('upDate');
		var shishiPeo=document.getElementById('shishiPeo');
		if(jifen.value=='' || shishiPeo.value==''){
			alert('请填写有效积分和实施人的姓名');
			return false;
		}
		
		
		var url = $('#netPath').val()+'?controller=Jifen_Comp&action=upByAjax';
		var param={
			jifen:jifen.value,
			compCode:compCode.value,
			shishiPeo:shishiPeo.value
		};
		
		$.getJSON(url,param,function(json){
			if(json.success===false) {
				alert(json.msg);
				return false;
			}
			debugger;
			//清空本地的积分和经验，并将取回的数据保存在本地数据库中
			var url1 = ' ?controller=Jifen_Comp&action=upByAjax';
			var param={
				jifen:jifen.value,
				compCode:compCode.value,
				upDate:upDate.value,
				shishiPeo:shishiPeo.value
			};
			$.getJSON(url1,param,function(json){
			if(json.success===false) {
				alert(json.msg);
				return false;
			}
			alert('上传成功！！');
			location.reload(true);
		 });
			
		});
  	});*/
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
{/literal}
</head>
<body>
<form name="form1" id="form1" action="{$sys}?controller=Jifen_Comp&action=UpJifen" method="post">
<table id="mainTable">

<tr>
	<td class="title">有效经验值：</td>
	<td><input name="remoteJingyan" type="text" disabled id="remoteJingyan" value="{$aRow.remoteJingyan}"/>
    	<input type="hidden" id="jy" name="jy" value="{$aRow.remoteJingyan}">
        <input name="jingyan" type="hidden"  disabled id="jingyan" value="{$aRow.jingyan}"/>
    </td>
	</tr>

<tr>
<td class="title">上传日期：</td>
<td><input name="upDate" type="text" id="upDate" value="{$aRow.upDate|default:$smarty.now|date_format:'%Y-%m-%d'}" onClick="calendar()"/><span class="bitian">*</span>
<input type="hidden" id="compCode" name="compCode" value="{$aRow.compCode}"/>
<input name="shishiPeo" type="hidden"  id="shishiPeo" value="{$aRow.shishiPeo}"/>
</td>
</tr>
<tr>
<td class="title">本次上传经验值：</td>
<td><input name="jifen" type="text" id="jifen" value="{$aRow.remoteJingyan}" onChange="getJy()"/><span class="bitian">*</span></td>
</tr>

</table>
<table id="buttonTable">
	<tr>
		<td><input type="submit" id="btnSave" name="btnSave" value='保存'>
        	<input type="hidden" id="netPath" name="netPath" value="{$sys}"/>
            <input type="hidden" id="url" name="url" value="{$url}"/>
            <input type="hidden" id="fromController" name="fromController" value="{$smarty.get.controller}"/>
            <input type="hidden" id="fromAction" name="fromAction" value="{$smarty.get.fromAction}"/>
        </td>
	</tr>
</table>
</form>
</body>
</html>
