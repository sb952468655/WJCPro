<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<link href="Resource/Css/EditCommon.css" type="text/css" rel="stylesheet">
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
{literal}
<script language="javascript">
$(function(){
	$('#form1').validate({
		rules:{		
			'feiyongName':'required'
		}
	});
});
</script>
{/literal}
</head>
<body>
<form name="form1" id="form1" action="{url controller=$smarty.get.controller action='save'}" method="post">
<input name="id" type="hidden" id="id" value="{$aRow.id}">
<table id="mainTable">
<td class="title">费用名称：</td>
<td><input name="feiyongName" type="text" id="feiyongName" value="{$aRow.feiyongName}"/><span class="bitian">*</span></td>
</tr>

</table>

<table id="buttonTable">
	<tr>
		<td>
		<!--<input type="submit" id="Submit" name="Submit" value='保存并新增下一个'>-->
		<input type="submit" id="Submit" name="Submit" value='保存'>
		<input type="button" id="Back" name="Back" value='返回' onClick="window.location.href='{url controller=$smarty.get.controller}&action=right'">
		</td>
	</tr>
</table>
</form>
</body>
</html>