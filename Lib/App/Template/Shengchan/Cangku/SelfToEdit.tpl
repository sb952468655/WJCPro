<script language="javascript">
{literal}
$(function(){
	$('[name="pihao[]"]','#table_main').attr('readonly',true);
	$('[name="pihao[]"]','#table_main').attr('placeholder','单击选择');

	$.validator.addMethod("pihaoCheck", function(value, element) {
		var _tt = true;
    	$('[name="productId[]"]').each(function(){
    		if($(this).val()>0){
    			var trs = $(this).parents('.trRow');
	    		var pihao = $('[name="pihao[]"]',trs).val();
	    		if(pihao==''){
	    			_tt = false;
	    		}
    		}
    	});
    	return _tt;
	}, "批号必填");

	//批号添加双击事件
	$('[name="pihao[]"]','#table_main').click(function(){
		debugger;
		var o = this;
		var trRow = $(this).parents('.trRow');

		var productId = $('[name="productId[]"]',trRow).val()||0;
		var color = $('[name="color[]"]',trRow).val()||'';
		var supplierId = $('[name="supplierId[]"]',trRow).val()||0;
		var kuweiId = $('#kuweiIdLl').val()||0;
		var type = $('#type').val()||'';

		if(productId>0){
			var url="?controller=Shengchan_chuku&action=getKucunByAjax";
			var param={ 
						productId:productId,
						color:color,
						supplierId:supplierId,
						kuweiId:kuweiId,
						type:type				
					}
			$.post(url,param,function(json){
				setPihaoDiv(o,json.data);
			},'json');
		}
	});

	$('body').click(function(){
	     hideWindowPiaho();
	});

	$('[name="cnt[]"]').change(function(){
		var max = parseFloat($(this).attr('max'))||0;
		var value = parseFloat($(this).val())||0;
		if(max==0)return;

		if(value > max){
			alert('最大库存为：'+max);
			$(this).val(max);
		}
	});

	/**
	 * 复制按钮
	*/
	$('[id="btnCopy"]','#table_else').click(function(){
		var tr = $(this).parents('.trRow');
		var nt = tr.clone(true);
	    
	    //有些数据需要制空
	    $('[name="ganghao[]"]',nt).val('');
	    $('[name="cnt[]"]',nt).val('');
	    $('[name="ganghao[]"]',nt).val('');
	    $('[name="chehao[]"]',nt).val('');
	    $('[name="shahao[]"]',nt).val('');
	    $('[name="cntJian[]"]',nt).val('');
	    $('[name="cntM[]"]',nt).val('');
	    $('[name="money[]"]',nt).val('');
	    $('[name="memoView[]"]',nt).val('');
	    $('[name="qtid[]"]',nt).val('');
	    //拼接
	    tr.after(nt);
	});
});

/**
 * 隐藏div
*/
function hideWindowPiaho(){
  $('.window_Pihao').hide();
  $('.window_Pihao').remove();
}

//显示层，用于选择批号
function setPihaoDiv(o,arr){
	var trs = $(o).parents('.trRow');
	//删除原来的窗口信息
	$('.window_Pihao').remove();
	//创建div
	var div ='<div class="window_Pihao popover container"><div class="arrow"></div><h3 class="popover-title">请选择</h3><div class="popover-content window_main"></div></div>';
	//添加到页面
	$('body').append(div);
	//隐藏
	$('.window_Pihao').hide();

	setContentToDiv(arr);

	//计算位置
	var em = $(o).offset();
	var top = em.top+$(o).outerHeight();
	// alert(top);
	var left = em.left;
	// alert(top+','+left);
	//自定义样式信息
	$('.window_Pihao').css({'position':'absolute','top':top,'left':left,'max-width':'750px'});
	$('.window_main').css({'max-height':'230px','overflow':'auto'});
	//显示窗口信息
	$('.window_Pihao').show();

	//定义单机事件
	$('.trPihao').click(function(){
		var json = eval("(" + $(this).attr('jsonData') + ")");
		// alert(json);
		$('[name="color[]"]',trs).val(json.color);
		$('[name="pihao[]"]',trs).val(json.pihao);
		$('#kuweiIdLl').val(json.kuweiId);
		var g = $('#kuweiIdLl').parents('.input-group');
		$('#textBox',g).val(json.kuweiName);
		$('[name="supplierId[]"]',trs).val(json.supplierId);
		$('[name="dengji[]"]',trs).val(json.dengji);

		var cntOld = parseFloat($('[name="cnt[]"]',trs).val())||0;
		if(json.cnt < cntOld ||cntOld==0){
			$('[name="cnt[]"]',trs).val(json.cnt);
		}
		
		$('[name="cnt[]"]',trs).attr('max',json.cnt);
		$('[name="cnt[]"]',trs).change();

		$('[name="cntJian[]"]',trs).val(json.cntJian);
	});
}

/**
 * 填充颜色信息
*/
function setContentToDiv(arr){
	//清空内容
	$('.window_main').html('');
	var str_pihao = '';
	var content=[];
	content.push('<tr style="background:#efefef">');
	content.push('<td>库位</td>');
	content.push('<td>供应商</td>');
	content.push('<td>颜色</td>');
	content.push('<td><b>批号</b></td>');
	content.push('<td>等级</td>');
	content.push('<td>件数</td>');
	content.push('<td>数量</td>');
	content.push('</tr>');

	if(arr){
		for(var i=0;arr[i];i++){
			content.push("<tr class='trPihao' jsonData=\'"+arr[i].jsonData+"\'>");
			content.push('<td>'+arr[i].kuweiName+'</td>');
			content.push('<td>'+arr[i].compName+'</td>');
			content.push('<td>'+arr[i].color+'</td>');
			content.push('<td><b>'+arr[i].pihao+'</b></td>');
			content.push('<td>'+arr[i].dengji+'</td>');
			content.push('<td>'+arr[i].cntJian+'</td>');
			content.push('<td>'+arr[i].cnt+'</td>');
			content.push('</tr>');
		}
	}
	str_pihao = content.join('');
	str_pihao = "<table class='table table-hover'>"+str_pihao+"</table>";
	$('.window_main').html(str_pihao);
}

{/literal}
</script>
