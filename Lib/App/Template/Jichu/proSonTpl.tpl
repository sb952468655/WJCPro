{webcontrol type='LoadJsCss' src="Resource/Script/jquery.json.js"}
<script language="javascript">
{literal}
$(function(){
	/*
  * 弹出窗口，需要编辑信息返回父窗口的模式
  */
  $('[name="btnPopEdit"]').click(function(e){
    // debugger;
    var p = $(this).parents('.clsPopEdit');
    //弹出窗地址
    var url = $(this).attr('url');
    var textFld= $(this).attr('textFld');
    var hiddenFld= $(this).attr('hiddenFld');
    var id = $('.hideId',p).attr('id');
    var dialogWidth = parseInt($(this).attr('dialogWidth'))||650;
    var hideVal=$('.hideId',p).val();
    var textVal=$('#textBox',p).val();
    var param={'hideVal':hideVal,'text':textVal};
    var ret = window.showModalDialog(url,{data:$.toJSON(param)},'dialogWidth:'+dialogWidth);
    if(!ret) ret=window.returnValue;
    if(!ret) return;


    //选中行后填充textBox和对应的隐藏id
    $('#textBox',p).val(ret[textFld]);
    $('.hideId',p).val(ret[hiddenFld]);
    
  });

  //成分比例
  $('[name="chengfenPer[]"]').change(function(){
    var tr = $(this).parents('.trRow');
    if($('[name="viewPer[]"]',tr).val()==''){
        $('[name="viewPer[]"]',tr).val($(this).val());
    }
  });

  //纱支选择
  $('[name="productId[]"]').bind('onSel',function(event,ret){
    var trs = $(this).parents('.trRow');
    $('[name="proName[]"]',trs).val(ret.proName);
  });
});
{/literal}
</script>