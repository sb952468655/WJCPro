{*
T1为T的升级版本,主要是将js剥离出来了。
注意:
proKind为产品弹出选择控件的必须参考的元素,特里特个性化需求,出了订单登记界面外其他使用产品弹出选择控件的模板必须制定proKind为hidden控件
*}<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
</head>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">

{literal}
<style type="text/css">

body{margin-left:5px; margin-top:5px; margin-right: 8px;}
.btns { position:absolute; right:16px; top:1px; height:28px;}
.relative { position:relative;}
.frbtn {position:absolute; top:1px; right:0px; height:28px;z-index:1000;}
.pd5{ padding-left:5px;}
#heji { padding-left:20px; height:20px; line-height:20px; margin-bottom:5px;}
label.error {
  color: #FF0000;
  font-style: normal;
	position:absolute;
	right:-50px;
	top:5px;
}
.lableMain {
  padding-left: 2px !important;
  padding-right: 2px !important;
}
.trRow input{
  min-width: 75px !important;
}
</style>
{/literal}
<body>

<form name="form1" id="form1" class="form-horizontal" action="{url controller=$smarty.get.controller action=$action_save|default:'save'}" method="post">
{include file=$otherInfoTpl|default:'Main2Son/OtherInfoTpl.tpl'}
<div class="form-group">
  <div class="col-sm-offset-4 col-sm-8">
      <input class="btn btn-primary" type="button" id="Submit" name="Submit" value="确定" onclick="ok()">
      {*其他一些功能按钮,*}
      {$other_button}
      <input class="btn btn-default" type="button" id="cannel" name="cannel" value="取消" onclick="window.close()">
  </div>
</div>
<div style="clear:both;"></div>
</form>
{*通用的js代码放在_jsCommon中,主要是一些组件的效果*}
{include file='Main2Son/_jsCommon.tpl'}
<script language="javascript">
var _cache = eval('('+window.dialogArguments.data+')');
{literal}
/*
* 返回信息到父界面
*/
function ok(){
  if(typeof(ok_dialog) == 'function'){
    var obj = ok_dialog();
    if(window.opener!=undefined) {
      window.opener.returnValue = obj;
    } else {
      window.returnValue = obj;
    }
    window.close();
  }
}
{/literal}
</script>
{*下面是个性化的js代码,和特殊的业务逻辑挂钩,比如某些模板中自动合计的效果等*}
{if $sonTpl}
  {if $sonTpl|@is_string==1}
    {include file=$sonTpl}
  {else}
    {foreach from=$sonTpl item=js_item}
      {include file=$js_item}
    {/foreach}
  {/if}
{/if}
</body>
</html>