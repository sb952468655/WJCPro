{webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.0.3/js/bootstrap.window.js"}
<script language="javascript">
{*颜色不能随便填写，需要只读*}
{literal}
$(function(){
  /**
   * 颜色只读，为了统一管理颜色，方便调整，在这里统一调整为只读
  */
  $('input[name="color[]"]').css({'min-width':'110px'});
  $('input[name="color[]"]').attr('readonly',true);
  $('input[name="color[]"]').attr('placeholder','单击选择');

  /**
   * 需要显示弹出窗口，用于选择颜色信息
  */

  $('input[name="color[]"]').click(function(){
      var obj = this;
      var tr=$(this).parents('.trRow');
      var productId=$('[name="productId[]"]',tr).val();
      if(!productId>0)return;

      var url="?controller=jichu_color&action=GetColorByProId";
      $.getJSON(url,{'productId':productId},function(json){
          //show color info
          if(json.success)showWindow(obj,json.data);
      });
  });

});

{/literal}
</script>