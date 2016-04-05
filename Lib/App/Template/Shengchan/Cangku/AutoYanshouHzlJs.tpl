<script language="javascript">
{literal}

/**
 * 给投自动验收钮加载单机事件
*/
$(function(){
	//自动验收
	$('[name="autoYanshou[]"]').click(function(){
		var obj = this;
		$(obj).attr('disabled',true);

		//获取空行，没有空行需要添加一个空行
		_autoAddRow(1);

		//获取当前操作的行
		var tr = $(this).parents('.trRow');
		// debugger;
		//获取空行
		var _proInput = $('.trRow','#table_else').find('[name="productId[]"][value=""]');
		var trNull = $(_proInput).eq(0).parents('.trRow');

		//对空行进行赋值
		$('[name="plan2proId[]"]',trNull).val($('[name="plan2proId[]"]',tr).val());
		$('[name="planGxId[]"]',trNull).val($('[name="planGxId[]"]',tr).val());

		//计划code
		var gNull = $('[name="planGxId[]"]',trNull).parents('.input-group');
		var g = $('[name="planGxId[]"]',tr).parents('.input-group');
		$('[name="textBox"]',gNull).val($('[name="textBox"]',g).val());

		//产品编号
		var g = $('[name="productId[]"]',tr).parents('.input-group');
		var gNull = $('[name="productId[]"]',trNull).parents('.input-group');
		$('[name="textBox"]',gNull).val($('[name="textBox"]',g).val());

		$('[name="productId[]"]',trNull).val($('[name="productId[]"]',tr).val());
		$('[name="ganghao[]"]',trNull).val($('[name="ganghao[]"]',tr).val());
		$('[name="pihao[]"]',trNull).val($('[name="pihao[]"]',tr).val());
		$('[name="pinzhong[]"]',trNull).val($('[name="pinzhong[]"]',tr).val());
		$('[name="guige[]"]',trNull).val($('[name="guige[]"]',tr).val());
		$('[name="color[]"]',trNull).val($('[name="color[]"]',tr).val());
		$('[name="dengji[]"]',trNull).val($('[name="dengji[]"]',tr).val());
		$('[name="cnt[]"]',trNull).val($('[name="cnt[]"]',tr).val());
		$('[name="cntJian[]"]',trNull).val($('[name="cntJian[]"]',tr).val());

		setTimeout(function(){
	        $(obj).attr('disabled',false);
	      }, 600);
	});

	$('[name="planGxId[]"]').bind('beforeOpen',function(event,url){
		var type = $('#type').val();
		if(type!='')url+="&ColType="+$('#kind').val();
		return url;
	});
});

/**
 * 判断是否有空行
*/
function _autoAddRow(cnt){
	//查找空行的数量
	var trs = $('.trRow','#table_else');
	var length = $(trs).find('[name="productId[]"][value=""]').length;

	//如果cnt(需要的空行数) > 实际的空行数
	if(cnt > length){
		//复制行数
		var len = trs.length;
		var trTpl = trs.eq(len-1).clone(true);
		var parent = trs.eq(0).parent();
		$('input,select',trTpl).val('');

		for(var i=length;i<cnt;i++){
			var newTr = trTpl.clone(true);
			parent.append(newTr);
		}
	}

}
{/literal}
</script>
