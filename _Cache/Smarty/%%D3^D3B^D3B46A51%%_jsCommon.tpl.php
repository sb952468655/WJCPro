<?php /* Smarty version 2.6.10, created on 2014-11-15 14:08:00
         compiled from Main2Son/_jsCommon.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Main2Son/_jsCommon.tpl', 2, false),array('modifier', 'default', 'Main2Son/_jsCommon.tpl', 12, false),array('modifier', 'json_encode', 'Main2Son/_jsCommon.tpl', 14, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%D3^D3B^D3B46A51%%_jsCommon.tpl.inc'] = '9a905c2e03cb4aa08a77d942b0ee9374';  if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/js/jquery.min.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.validate.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/js/bootstrap.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/js/tooltip.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/js/jeffCombobox.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:9a905c2e03cb4aa08a77d942b0ee9374#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/js/TableHeader.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:9a905c2e03cb4aa08a77d942b0ee9374#7}';}?>


<script language="javascript">
var _removeUrl='?controller=<?php echo $_GET['controller']; ?>
&action=<?php echo ((is_array($_tmp=@$this->_tpl_vars['RemoveByAjax'])) ? $this->_run_mod_handler('default', true, $_tmp, 'RemoveByAjax') : smarty_modifier_default($_tmp, 'RemoveByAjax')); ?>
';
var _removeUrl2='?controller=<?php echo $_GET['controller']; ?>
&action=RemoveQitaByAjax';
var _rules = <?php echo json_encode($this->_tpl_vars['rules']); ?>
;
var controller = '<?php echo $_GET['controller']; ?>
';
var _tr = new Array();
<?php echo '
$(function(){
  ret2cab();
  $(\'#table_main\').tableHeader();
  $(\'#table_else\').tableHeader();
  //对所有的规格设置长度，临时写在这里，需要后期优化
  $(\'[name="guige[]"]\').css({\'min-width\':\'110px\'});
  //复制空行
  var tblIds = [\'#table_main\',\'#table_else\'];
  //存在多个表格，复制行，并复制基础的事件，如明细表中一些选择事件，删除，
  for(var i=0;tblIds[i];i++){
    var _rows=$(\'.trRow\',tblIds[i]);
    _tr[tblIds[i]] = _rows.eq(_rows.length-1).clone(true);
    $(\'input,select\',_tr[tblIds[i]]).val(\'\');
  }

  //日历下拉按钮点击后触发calendar;
  $(\'[id="btnCalendar"]\').click(function(){
    var p = $(this).parents(\'.input-group\');
    // debugger;
    //WdatePicker({el:\'d12\'})
    var id=$(\'input\',p).attr(\'id\');
    // debugger;
    WdatePicker({el:id});
  });
  
  //删除行,临时写在这里，后期需要用sea.js封装
  $(\'[id="btnRemove"]\',\'#table_main\').click(function(){
    fnRemove(\'#table_main\',this,_removeUrl,\'id[]\');
  });

  //复制行,临时写在这里，后期需要用sea.js封装
  $(\'#btnAdd\',\'#table_main\').click(function(){
    fnAdd(\'#table_main\');
  });

  $(\'[id="btnRemove"]\',\'#table_else\').click(function(){
    fnRemove(\'#table_else\',this,_removeUrl2,\'qtid[]\');
  });

  //复制行,临时写在这里，后期需要用sea.js封装
  $(\'#btnAdd\',\'#table_else\').click(function(){
    fnAdd(\'#table_else\');
  });

  //通用的弹出选择控件的事件定义,
  //里面暴露一个onSelect
  //另有
  $(\'[name="btnPop"]\').click(function(e){
    // debugger;
    var p = $(this).parents(\'.clsPop\');
    //弹出窗地址
    // var url = $(p).find(\'#url\').val();
    var url = $(this).attr(\'url\');    

    var textFld= $(this).attr(\'textFld\');
    var hiddenFld= $(this).attr(\'hiddenFld\');
    var id = $(\'.hideId\',p).attr(\'id\');

    //打开窗口之前处理url地址
    if($("[name=\'"+id+"\']").data("events") && $("[name=\'"+id+"\']").data("events")[\'beforeOpen\']){
      url=$(\'.hideId\',p).triggerHandler(\'beforeOpen\',[url]);
      if(url==false)return;
    }

    var dialogWidth = parseInt($(this).attr(\'dialogWidth\'))||650;
    window.returnValue=null;
    var ret = window.showModalDialog(url,window,\'dialogWidth:\'+dialogWidth);
    if(!ret) ret=window.returnValue;
    if(!ret) return;


    //选中行后填充textBox和对应的隐藏id
    $(\'#textBox\',p).val(ret[textFld]);
    $(\'.hideId\',p).val(ret[hiddenFld]);

    //执行回调函数,就是触发自定义事件:onSel
    if(!$("[name=\'"+id+"\']").data("events") || !$("[name=\'"+id+"\']").data("events")[\'onSel\']) {
      alert(\'未发现对popup控件 \'+id+ \' 的回调函数进行定义,您可能需要在sonTpl中用bind进行事件绑定:\\n$("[name=\\\'\'+id+\'[]\\\']").bind(\\\'onSel\\\',function(event,ret){...})\');
      return;
    }
   
    $(\'.hideId\',p).trigger(\'onSel\',[ret]);
  });

  //明细信息中用到的数量字段名字会有变动
  if($(\'[name="cntYaohuo[]"]\').length>0){
    getMoney(\'cntYaohuo[]\');
  }else if($(\'[name="cnt[]"]\').length>0){
    getMoney(\'cnt[]\');
  }else if($(\'[name="cntKg[]"]\').length>0){
    getMoney(\'cntKg[]\');
  }


  /**
  * 添加5行方法，适应于多个table
  */
  function fnAdd(tblId) {
    var rows = $(\'.trRow\',tblId);
    var len = rows.length;
    
    for(var i=0;i<5;i++) {
      var nt = rows.eq(len-1).clone(true);
      $(\'input,select\',nt).val(\'\');
      //偷懒行为，直接统一修改
      $(\'[name="dengji[]"]\',nt).val(\'一等品\');

       //加载新增后运行的代码
      if(typeof(beforeAdd) == \'function\'){
        beforeAdd(nt,tblId);
      }
      //拼接
      rows.eq(len-1).after(nt);
    }

    return;
  }
  /**
  * 删除行方法，适应于多个table
  */
  function fnRemove(tblId,obj,url,idname) {
    //利用ajax删除,后期需要利用sea.js进行封装
    var url=url;
    // alert(url);
    var trs = $(\'.trRow\',tblId);
    // alert(trs.length);
    if(trs.length<=1) {
      alert(\'至少保存一个明细\');
      return;
    }

    var tr = $(obj).parents(\'.trRow\');
    var id = $(\'[name="\'+idname+\'"]\',tr).val();
    // alert(id);
    if(!id) {
      tr.remove();
      return;
    }

    if(!confirm(\'此删除不可恢复，你确认吗?\')) return;
    var param={\'id\':id};
    $.post(url,param,function(json){
      if(!json.success) {
        alert("出错\\r"+json.msg);
        return;
      }
      tr.remove();
    },\'json\');
    return;
  }


  //计算明细信息中的金额信息
  function getMoney(name){
    $(\'[name="\'+name+\'"],[name="danjia[]"]\').change(function(){
        var tr = $(this).parents(".trRow");
        var danjia = parseFloat($(\'[name="danjia[]"]\',tr).val()||0);
        var cnt = parseFloat($(\'[name="\'+name+\'"]\',tr).val()||0);
        $(\'[name="money[]"]\',tr).val((danjia*cnt).toFixed(2));
        return;
    });
  }

  //输入金额，自动计算单价

  //表单验证
  //表单验证应该被封装起来。
  var rules = $.extend({},_rules);
  /**
  *添加几个常用的验证规则
  */
  //重复验证，默认验证该model对应表数据，指定的某字段是否重复，如果有其他需求需要个性化代码

  $.validator.addMethod("repeat", function(value, element) {
    var url="?controller="+controller+\'&action=repeat\';
    var param = {field:element.name,fieldValue:value,id:$(\'#id\').val()};

    var repeat=true;
    //通过ajax获取值是否已经存在
    $.ajax({
      type: "GET",
      url: url,
      data: param,
      success: function(json){
        repeat = json.success;
      },
      dataType: \'json\',
      async: false//同步操作
    });
    return repeat;
  }, "已存在");

  $(\'#form1\').validate({
    rules:rules,
    submitHandler : function(form){
      var r=true;
      if(typeof(beforeSubmit)=="function") {
        r = beforeSubmit();
      }
      if(!r) return;
      if($(\'[name="Submit"]\').attr(\'submits\')!=\'submiting\'){
        $(\'[name="Submit"]\').attr(\'submits\',\'submiting\');
        form.submit();
      }
    }
    ,errorPlacement: function(error, element) {
      var type = element.attr(\'type\');
      var obj = element;
      if(type==\'hidden\') {//如果是hidden控件，需要取得非hidden控件，否则位置会报错
        var par = element.parents(\'.input-group\');
        obj = $(\'input[type="text"]\',par);
      }
      var errorText = error.text();
      obj.attr(\'data-toggle\',\'tooltip\').attr(\'data-placement\',\'bottom\').attr(\'title\',errorText);
      obj.tooltip(\'show\');      
    }

    // ,debug:true
    ,onfocusout:false
    ,onclick:false
    ,onkeyup:false
  });

  ///////////////////////////弹出选择控件
  //临时写在这里，后期需要用sea.js封装
  $(\'#btnclientName\').click(function(){
    var url="?controller=Jichu_Client&action=Popup";
    window.returnValue=null;
    var ret = window.showModalDialog(url,window,\'dialogWidth:800px\');
     // debugger;
    if(!ret) ret=window.returnValue;
    if(!ret) return;
    var g = $(this).parents(\'.input-group\');
    $(\'#clientId\',g).val(ret.id);
    $(\'#clientName\',g).val(ret.compName);

    //触发onSelClient函数
    if(onSelClient) onSelClient(this);
    return;
  });

  //产品选择,临时写在这里，后期需要用sea.js封装
  $(\'[name="btnChanpin"]\').click(function(){
    var tr = $(this).parents(\'.trRow\');
    var url="?controller=jichu_chanpin&action=popup";
    url += "&type="+($(\'#_proKind\',tr).val()||0);
    window.returnValue=null;
    var ret = window.showModalDialog(url,window);
    if(!ret) ret=window.returnValue;
    if(!ret) return;
    var tr = $(this).parents(".trRow");
    $(\'[name="proCode"]\',tr).val(ret.proCode);
    $(\'[name="productId[]"]\',tr).val(ret.id);
    $(\'[name="pinzhong[]"]\',tr).val(ret.pinzhong);
    $(\'[name="guige[]"]\',tr).val(ret.guige);
    $(\'[name="menfu[]"]\',tr).val(ret.menfu);
    $(\'[name="kezhong[]"]\',tr).val(ret.kezhong);


    //选择产品后加载的方法
    if(typeof(afterSel) == \'function\'){
      afterSel(tr,ret);
    }
    
    return;
  });

  //纱弹出窗口
  $(\'[name="btnProduct"]\').click(function(){
    var tr = $(this).parents(\'.trRow\');
    var url="?controller=jichu_product&action=popup";
    url += "&type="+($(\'#_proKind\',tr).val()||0);
    window.returnValue=null;
    var ret = window.showModalDialog(url,window);
    if(!ret) ret=window.returnValue;
    if(!ret) return;
    var tr = $(this).parents(".trRow");

    $(\'[name="proCode"]\',tr).val(ret.proCode);
    $(\'[name="productId[]"]\',tr).val(ret.id);
    $(\'[name="proName[]"]\',tr).val(ret.proName);
    // $(\'[name="zhonglei[]"]\',tr).val(ret.zhonglei);
    // $(\'[name="color[]"]\',tr).val(ret.color);
    $(\'[name="guige[]"]\',tr).val(ret.guige);

     $(\'[name="color[]"]\',tr).focus();

    //选择产品后加载的方法
    if(typeof(afterSel) == \'function\'){
      afterSel(tr,ret);
    }
    
    return;
  });


  //订单选择
  $(\'#btnorderName\').click(function(){
    var url="?controller=Trade_Order&action=popup";
    if($(\'#orderKind\').val()!=\'\')url+="&kind="+$(\'#orderKind\').val();
    window.returnValue=null;
    var ret = window.showModalDialog(encodeURI(url),window);
    if(!ret) ret=window.returnValue;
    if(!ret) return;
    //控件显示订单号
    var g = $(this).parents(\'.form-group\');
    $(\'#orderName\',g).val(ret.orderCode);
    $(\'#orderId\',g).val(ret.orderId);
    // dump(ret);

    if(onSelOrder) onSelOrder(this,ret);
    return;
  });
});
'; ?>

</script>