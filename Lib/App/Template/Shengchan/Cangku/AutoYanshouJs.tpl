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
		var tblName = '#table_else';
		_autoAddRow(1,tblName);

		//获取当前操作的行
		var tr = $(this).parents('.trRow');
		// debugger;
		//获取空行
		var _proInput = $('.trRow',tblName).find('[name="productId[]"][value=""]');
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
		$('[name="proCode"]',trNull).val($('[name="textBox"]',g).val());

		$('[name="productId[]"]',trNull).val($('[name="productId[]"]',tr).val());
		$('[name="ganghao[]"]',trNull).val($('[name="ganghao[]"]',tr).val());
		$('[name="pinzhong[]"]',trNull).val($('[name="pinzhong[]"]',tr).val());
		$('[name="guige[]"]',trNull).val($('[name="guige[]"]',tr).val());
		// $('[name="color[]"]',trNull).val($('[name="color[]"]',tr).val());
		$('[name="dengji[]"]',trNull).val($('[name="dengji[]"]',tr).val());
		$('[name="cnt[]"]',trNull).val($('[name="cnt[]"]',tr).val());
		$('[name="cntJian[]"]',trNull).val($('[name="cntJian[]"]',tr).val());

		setTimeout(function(){
	        $(obj).attr('disabled',false);
	      }, 600);
	});
	
	//不是返修部允许填写缸号
	$('#isFanxiu').change(function(){
		if($(this).val()==0){
			$('[name="pihao[]"]').attr('readonly',true);
			$('[name="pihao[]"]').attr('value','');
		}else{
			$('[name="pihao[]"]').attr('readonly',false);
		}
	});

	/**
	 * 自动投料
	*/
	/*$('[name="autoLingliao[]"]').click(function(){
		var obj = this;
		$(obj).attr('disabled',true);
		// debugger;
		//获取空行，没有空行需要添加一个空行
		var tblName = '#table_main';
		_autoAddRow(1,tblName);

		//获取当前操作的行
		var tr = $(this).parents('.trRow');
		// debugger;
		//获取空行
		var _proInput = $('.trRow',tblName).find('[name="productId[]"][value=""]');
		var trNull = $(_proInput).eq(0).parents('.trRow');

		//对空行进行赋值
		$('[name="plan2proId[]"]',trNull).val($('[name="plan2proId[]"]',tr).val());
		$('[name="planGxId[]"]',trNull).val($('[name="planGxId[]"]',tr).val());

		

		//查找坯布送染厂信息，投料数量只能按照公式计算理论的值
		
		var color=$('[name="color[]"]',tr).val();
		var dengji=$('[name="dengji[]"]',tr).val();
		var cnt=$('[name="cnt[]"]',tr).val();
		var cntJian=$('[name="cntJian[]"]',tr).val();
		var ganghao=$('[name="ganghao[]"]',tr).val();
		var productId=$('[name="productId[]"]',tr).val();
		var pinzhong=$('[name="pinzhong[]"]',tr).val();
		var guige=$('[name="guige[]"]',tr).val();
		var proCode=$('[name="proCode[]"]',tr).val();

		var url = "?controller=Shengchan_Zhizao_Scrk&action=GetInfoByGanghao";
		var param = {'ganghao':ganghao,'productId':productId};

		$.ajax({
		      type: "GET",
		      url: url,
		      data: param,
		      success: function(json){
		      	if(json.success == false){
		      		alert('没有查找到对应的本厂缸号记录，请确认本厂缸号是否正确！');
		      	}

		      	if(json.data.cntJian < cntJian){
		      		alert('坯布验收的件数只有'+json.data.cntJian+'件，此处投料件数有问题，请确认!');
		      	}
		        cnt=(json.data.cntEve*cntJian).toFixed(2);
		        color=json.data.color;
		        dengji=json.data.dengji;
		        productId=json.data.productId;
		        pinzhong=json.data.pinzhong;
		        guige=json.data.guige;
		        proCode=json.data.proCode;
		      },
		      dataType: 'json',
		      async: false//同步操作
	    });

		$('[name="color[]"]',trNull).val(color);
		$('[name="dengji[]"]',trNull).val(dengji);
		$('[name="cnt[]"]',trNull).val(cnt);
		$('[name="cntJian[]"]',trNull).val(cntJian);

		//计划code
		var gNull = $('[name="planGxId[]"]',trNull).parents('.input-group');
		var g = $('[name="planGxId[]"]',tr).parents('.input-group');
		$('[name="textBox"]',gNull).val($('[name="textBox"]',g).val());

		//产品编号
		var g = $('[name="productId[]"]',trNull).parents('.input-group');
		$('[name="textBox"]',g).val(proCode);

		$('[name="productId[]"]',trNull).val(productId);
		$('[name="ganghao[]"]',trNull).val($('[name="ganghao[]"]',tr).val());
		$('[name="pinzhong[]"]',trNull).val(pinzhong);
		$('[name="guige[]"]',trNull).val(guige);


		setTimeout(function(){
	        $(obj).attr('disabled',false);
    	}, 600);
	});*/
});
/**
 * 判断是否有空行
*/
function _autoAddRow(cnt,tblName){
	//查找空行的数量
	var trs = $('.trRow',tblName);
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
