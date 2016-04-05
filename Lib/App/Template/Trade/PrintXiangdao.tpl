<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
<title>{$title}</title>
{literal}
<script language="javascript">
$(function(){
	$('a').click(function(){
		//当点击url 之后,向导界面自动关闭
		//if(!window.opener) window.parent.tb_remove();
	});
});
</script>
<style type="text/css">
a { color:#00C; text-decoration:none}
table tr td { height:30px; text-align:left;}
</style>
{/literal}
</head>

<body>
<form id="form1" name="form1" method="post" action="{url controller=$smarty.get.controller action='PrintXiangdao'}" target="_blank">
  <table border="0" cellpadding="1" cellspacing="1" align="center">
  {foreach from=$url item=item key=key}
    <tr>
      <td><li>{$item}</li></td>
    </tr>
   {/foreach}
    <tr>
      <td><label>
        <input type="button" name="button" id="button" value="  取 消  " onclick='if(!window.opener) window.parent.tb_remove()'/>
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>
