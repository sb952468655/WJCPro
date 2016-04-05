{*使用tbllist.tpl模板，最新*}
<base target="_self" />
{assign var=_checked value=true}
{include file='TblList.tpl'}

<script language='javascript'>
//建立数据集缓存，用来双击某行时提取数据
var _ds = {$arr_field_value|@json_encode};
//定义ondbclick事件
var _arr = [];
{literal}
$(function(){
	//选择按钮单机事件
	$('#Sel_BTN').click(function(){
		var i=0;
		// debugger;
		for(var k in _ds) {
			if(typeof(_ds[k])=='function') continue;
			//如果对应的行以选中
			if(document.getElementsByName('Sel_CHECKBOX')[i].checked){
				_arr.push(_ds[k]);
			}

			i++;
		}
		if(!_arr.length>0){
			if(confirm('没有选择任何数据，请确认是否关闭选择窗口')){
				_arr=null;
			}else return;
		}
		// dump(_arr);
		//debugger;
		if(window.opener!=undefined) {
			window.opener.returnValue = _arr;
		} else {
			window.returnValue = _arr;
		}
		window.close();
	});

});

{/literal}
</script>