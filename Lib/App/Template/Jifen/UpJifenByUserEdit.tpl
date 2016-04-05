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
<form name="form1" id="form1" action="{$sys}?controller=Jifen_User&action=UpJifen" method="post">
<table id="tableList" style="width:100%; text-align:center">
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
{foreach from=$aRow item=item}
<tr>
  <td><input id="userCode[]" name="userCode[]" type="hidden" value="{$item.userCode}"/>{$item.userCode}</td>
  <td><input id="realName[]" name="realName[]" type="hidden" value="{$item.realName}"/>
  		<input id="passwd[]" name="passwd[]" type="hidden" value="{$item.passwd}"/>
        <input id="id[]" name="id[]" type="hidden" value="{$item.id}"/>
  {$item.realName}</td>
  <td><input id="shenfenzheng[]" name="shenfenzheng[]" type="hidden" value="{$item.shenfenzheng}"/>{$item.shenfenzheng}</td>
  <td>{$item.remoteJifen}</td>
  <td>{$item.remoteJingyan}</td>
  <td>{$item.jifen}</td>
  <td>{$item.jingyan}</td>
  <td><input type="text" id="jifen[]" name="jifen[]" value="{$item.jifen}"></td>
  <td><input type="text" id="jingyan[]" name="jingyan[]" value="{$item.jingyan}"></td>
</tr>
{/foreach}
</table>
<br>
<table id="buttonTable">
	<tr>
		<td><input type="submit" id="btnSave" name="btnSave" value='保存'>
        	<input type="hidden" id="compCode" name="compCode" value="{$row.compCode}"/>
            <input type="hidden" id="netPath" name="netPath" value="{$sys}"/>
            <input type="hidden" id="shishiPeo" name="shishiPeo" value="{$smarty.session.REALNAME}"/>
            <input type="hidden" id="url" name="url" value="{$url}"/>
            <input type="hidden" id="fromController" name="fromController" value="{$smarty.get.controller}"/>
            <input type="hidden" id="fromAction" name="fromAction" value="{$smarty.get.fromAction}"/>
        </td>
	</tr>
</table>
</form>
</body>
</html>
