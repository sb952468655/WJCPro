{webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.0.3/js/bootstrap.autocomplete.js"}
<script language="javascript">
{literal}
$(function(){
	/*
	 *颜色需要自动完成控件，因为很多界面都需要，所以写在了这个地方
	 */
  if($('[name="color[]"]').length>0){
		$('[name="color[]"]').each(function(){
			var tr = $(this).parents('.trRow');
			autoComplete(tr);
		});
  }  
});


/**
 * 初始化自动完成控件
 * Time：2014/07/02 14:33:42
 * @author li
*/
function autoComplete(tr){
  //去除浏览器自动提示的功能
  $('[name="color[]"]').attr('autocomplete','off');
  var url="?controller=jichu_color&action=GetColorByAjax";
  //加载自动控件信息
  $('[name="color[]"]',tr).autocomplete({
        source:function(query,process){
         var matchCount = this.options.items;
         //获取对应的产品id
         var productId = $('[name="productId[]"]',tr).val();
         //ajax获取数据
          $.post(url,{"title":query,'productId':productId},function(respData){
              var myobj=eval(respData);
              return process(myobj);
          });
        },
        formatItem:function(item){
            return item["color"];
        },
        setValue:function(item){
            return {'data-value':item["color"],'real-value':item["color"]};
        }
    });
}

/*
* 拼接div，显示保存按钮
*/
function addDiv(){
  $('.editBtn_ok').remove();
  var div ="<div class='editBtn_ok'><a class='btn btn-primary' href='javascript:;'>颜色保存到档案</a></div>";
  $('body').append(div);
  $('.editBtn_ok').hide();
}

function showDiv(input){
  var em = $(input).offset();
  var top = em.top+$(input).outerHeight();
  var left = em.left;
  // alert(top+','+left);
  $('.editBtn_ok').css({'position':'absolute','top':top,'left':left});
  $('.editBtn_ok').show();

  //绑定事件
  $('.editBtn_ok').click(function(){
    var trRow = $(input).parents('.trRow');
    var productId = $('[name="productId[]"]',trRow).val();
    if(!productId>0)return;
    var url="?controller=jichu_product&action=saveColorByAjax";
    var param={'color':$(input).val(),'productId':productId};
    $.getJSON(url,param,function(){});
  });
}

$('body').click(function(){
   $('.editBtn_ok').hide();
});


/**
* 鼠标在颜色控件上右键触发
*/
function _RightMouse(input){
  //客户要求可以再登记界面直接把颜色添加到基础档案
  //判断是否已经绑定事件
  if($(input).data('events')['dblclick'])return;

  $(input).dblclick(function(){
    var color=$(input).val();
    if(color=='')return;
    //显示操作按钮
    addDiv();
    showDiv(input);
  });

}


/**
 * 新增行后触发的事件
 * Time：2014/07/02 17:27:21
 * @author li
*/
function beforeAdd(tr,tblId){
  //获取该次操作的表格id
  //替换掉原来的颜色信息
  var cell = '[name="color[]"]';
  $(cell,tr).replaceWith(function(){
    var html = $(cell,_tr[tblId]).parent().html();
    return html;
  });
  //对颜色进行自动控件初始化
  autoComplete(tr);
}

//选中产品后重新加载自动控件
function afterSel(tr,ret){
  //鼠标右键事件
  _RightMouse($('[name="color[]"]',tr));
}
{/literal}
</script>