{literal}
<script language="javascript">
$(function(){
	//初始化界面，显示已经设置的颜色信息
	initView();
});

/**
 * 初始化界面
 * Time：2014/07/02 09:09:09
 * @author li
*/
function initView(){
	var _color = _cache.hideVal;
	var color = _color.split(",");
	//新增行并赋值
	buildRow(color);
}

/**
 * 查找需要的行数，然后添加对应的行数
*/
function buildRow(obj){
	var len=obj.length;
	if(len<5)len=5;
	//获取所有行
	var rows = $('.trRow','#table_else');
	//复制最后一行
	var _tr = rows.eq(rows.length-1).clone(true);
	var parent = rows.eq(0).parent();
	//删除所有行数
	$('.trRow','#table_else').remove();

	//添加行
	for(var i=0;i<len;i++){
		var newTr = _tr.clone(true);
		$('[name="color[]"]',newTr).val(obj[i]);
		// autoComplete();
	    parent.append(newTr);
	}
}

/**
* 组织数据返回给父窗口
*/
function ok_dialog () {
	var color=[];
	$('[name="color[]"]').each(function(i){
		var _color = $(this).val();
		if(_color!='')color.push(_color);
	});
	var obj={'color':color.join(","),'viewcolor':color.join(" ")};
	return obj;
}
</script>
{/literal}