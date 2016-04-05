{*
次模板为单一界面的通用模板，主要在基础档案中应用或其他单一表的编辑时使用
*}<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
</head>
{webcontrol type='LoadJsCss' src="Resource/Script/Calendar/WdatePicker.js"}
{webcontrol type='LoadJsCss' src="Resource/Css/validate.css"}
{webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css"}
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
</style>
{/literal}
<body>
<div class='container'>
  <form name="form1" id="form1" class="form-horizontal" action="{url controller=$smarty.get.controller action=$form.action|default:'save'}" method="post" {if $form.up==true}enctype="multipart/form-data"{/if}>

  <!-- 主表字段登记区域 -->
  <div class="panel panel-info">
    <div class="panel-heading"><h3 class="panel-title" style="text-align:left;">{$title}</h3></div>
    <div class="panel-body">
      <div class="row">
        {foreach from=$fldMain item=item key=key}
        {include file="Main/"|cat:$item.type|cat:".tpl"}      
        {/foreach}
      </div>       
    </div>
  </div>

  {if $otherInfoTpl!=''}
  {include file=$otherInfoTpl}
  {/if}
  <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <input class="btn btn-primary" type="submit" id="Submit" name="Submit" value="保 存">
        {if $btn.SaveAdd!='hidden'}
        <input class="btn btn-default" type="submit" id="Submit" name="Submit" value="保存并新增">{/if}
        {if $btn.Reset!='hidden'}<input class="btn btn-default" type="reset" id="Reset" name="Reset" value=" 重 置 ">{/if}
    </div>
  </div>
  <div style="clear:both;"></div>
  <input type='hidden' name='fromAction' value='{$smarty.get.fromAction|default:"right"}' />
  </form>
</div>
<script language="javascript" src="Resource/bootstrap/bootstrap3.0.3/js/jquery.min.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<script src="Resource/bootstrap/bootstrap3.0.3/js/bootstrap.js"></script>
<script src="Resource/bootstrap/bootstrap3.0.3/js/jeffCombobox.js"></script>

<script language="javascript"> 
var _rules = {$rules|@json_encode};
{literal}
$(function(){ 
  //表单验证
  //表单验证应该被封装起来。
  var rules = $.extend({},_rules);
  $('#form1').validate({
    rules:rules,
    submitHandler : function(form){
      var r=true;
      if(typeof(beforeSubmit)=="function") {
        r = beforeSubmit();
      }
      if(!r) return;
      if($('[name="Submit"]').attr('submits')!='submiting'){
        $('[name="Submit"]').attr('submits','submiting');
        form.submit();
      }
    }
    // ,debug:true
    ,onfocusout:false
    ,onclick:false
    ,onkeyup:false
  });

  {/literal}
  {if $jsPatch}{include file=$jsPatch}{/if}
  {literal}
});
</script>
{/literal}
</body>
</html>