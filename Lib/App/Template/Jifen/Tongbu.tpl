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
	$('#reset').click(function(){
		window.location.href='?controller=jifen_comp&action=ResetLogin';
	});
	/*$('#btnSave').click(function(){	
		var id=document.getElementsByName('id[]');
		var userCode=document.getElementsByName('userCode[]');
		var realName=document.getElementsByName('realName[]');
		var passwd=document.getElementsByName('passwd[]');
		var shenfenzheng=document.getElementsByName('shenfenzheng[]');
	 	var jifen=document.getElementsByName('jifen[]');
		var jingyan=document.getElementsByName('jingyan[]');
		var compCode=document.getElementById('compCode');
		var shishiPeo=document.getElementById('shishiPeo');
		var idArr=new Array();
		var userCodeArr=new Array();
		var shenfenzhengArr=new Array();
		var realNameArr=new Array();
		var passwdArr=new Array();
		var jifenArr=new Array();
		var jingyanArr=new Array();
		//debugger;
		var k=0;
		for(var i=0;i < shenfenzheng.length;i++){
			if((jingyan[i].value>0 ) || (jifen[i].value>0 ))
			{
				//debugger;
				idArr[k]=id[i].value;
				userCodeArr[k]=userCode[i].value;
				passwdArr[k]=passwd[i].value;
				shenfenzhengArr[k]=shenfenzheng[i].value;
				realNameArr[k]=realName[i].value;
				jifenArr[k]=parseInt(jifen[i].value)||0;
				jingyanArr[k]=parseInt(jingyan[i].value)||0;
				k++;
			}
			
		}	
		if(shenfenzhengArr.length==0) {
			alert("没有有效积分上传");	
			return false;
		}
		var url = $('#netPath').val()+'?controller=Jifen_User&action=upByAjax';
		var param={
			id:idArr,
			compCode:compCode.value,
			userCode:userCodeArr,
			passwd:passwdArr,
			realName:realNameArr,
			shenfenzheng:shenfenzhengArr,
			jifen:jifenArr,
			jingyan:jingyanArr,
			shishiPeo:shishiPeo.value
		};
		
		$.getJSON(url,param,function(json){
			if(json.success===false) {
				alert(json.msg);
				return false;
			}
			//清空本地的积分和经验，并将取回的数据保存在本地数据库中
			//debugger;
			var url1 = ' ?controller=Jifen_Comp&action=upUserJifenByAjax';
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
<form name="form1" id="form1" action="{$sys}?controller=Jifen_User&action=Tongbu" method="post">
<!--<table id="tableList" style="width:100%; text-align:center">
 <tr style="background-color:#D4E2F4; font-size:12px; height:25px;">
  <td>用户编号</td>
  <td>姓名</td>
  <td>身份证号</td>
  <td>本地总积分</td>
  <td>本地总经验值</td>
  
</tr>
{foreach from=$aRow item=item}
<tr>
  <td>{$item.userCode}</td>
  <td>
  		<input id="id[]" name="id[]" type="hidden" value="{$item.id}"/>
        <input id="realName[]" name="realName[]" type="hidden" value="{$item.realName}"/>
        <input id="userCode[]" name="userCode[]" type="hidden" value="{$item.userCode}"/>
  {$item.realName}</td>
  <td>{$item.shenfenzheng}</td>
  <td>{$item.remoteJifen}</td>
  <td>{$item.remoteJingyan}</td>
 
  
</tr>
{/foreach}
</table>
-->
<p style="margin-top:20px; color:#F00; margin-left:200px; margin-bottom:50px; line-height:30px;" align="left">
注意：<br>
提取操作将会从网站端取得最新的企业经验，并覆盖本地服务器上的企业经验，
<br>此操作为不可逆操作，同步前请确认网站上的经验是最新经验。
<br>
提取操作不会从网站下载排名信息，排名信息会在用户登录时自动更新(每天一次)，你可以通过"重置登录状态"按钮，使下一次登录强制触发上传下载动作，更新网站经验和本地排名等信息！
</p>
<br>
<table id="buttonTable">
	<tr>
		<td><input type="submit" id="btnSave" name="btnSave" value=' 开始提取 '>
         <input type="hidden" id="compCode" name="compCode" value="{$compCode}"/>
            <input type="hidden" id="netPath" name="netPath" value="{$sys}"/>
            <input type="hidden" id="shishiPeo" name="shishiPeo" value="{$smarty.session.REALNAME}"/>
            <input type="hidden" id="url" name="url" value="{$url}"/>
            <input type="hidden" id="fromController" name="fromController" value="{$smarty.get.controller}"/>
            <input type="hidden" id="fromAction" name="fromAction" value="{$smarty.get.fromAction}"/>
            <input type="hidden" id="LANG" name="LANG" value="{$smarty.session.LANG}"/>
            <input type="hidden" id="SN" name="SN" value="{$smarty.session.SN}"/>
            <input type="hidden" id="USERID" name="USERID" value="{$smarty.session.USERID}"/>
            <input type="hidden" id="REALNAME" name="REALNAME" value="{$smarty.session.REALNAME}"/>
            <input type="hidden" id="USERNAME" name="USERNAME" value="{$smarty.session.USERNAME}"/>
        <input type="button" id="reset" name="reset" value=' 重置登录状态 '></td>
	</tr>
</table>
</form>
</body>
</html>
