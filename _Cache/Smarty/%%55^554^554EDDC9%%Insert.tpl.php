<?php /* Smarty version 2.6.10, created on 2014-11-03 09:57:16
         compiled from Caiwu/Ys/Insert.tpl */ ?>
<?php echo '
<script language="javascript">
/**
* 插入行，通过ajax获取数据插入行
*/
function _Insert(tblId){
	//限制按钮使用
	$(\'#btnSel\',tblId).attr(\'disabled\',true);
	  
	//url地址
	var url=$(\'#btnSel\',tblId).attr(\'url\');
	// alert(url);
	var param={};
	//打开窗口之前处理url地址
	if($(\'#btnSel\',tblId).data("events") && $(\'#btnSel\',tblId).data("events")[\'beforeInsert\']){
	  param=$(\'#btnSel\',tblId).triggerHandler(\'beforeInsert\',[param]);
	}
	
	//通过ajax获取
	$.getJSON(url,param,function(json){
	    if(json.success===false){
	      alert(json.msg);
	    }else{
	      //执行回调函数,就是触发自定义事件:onSel
	      if(!$(\'#btnSel\').data("events") || !$(\'#btnSel\').data("events")[\'afterClick\']) {
	        alert(\'您可能需要对按钮使用bind进行事件绑定:\\n\\$(\\\'#btnSel\\\').bind(\\\'afterClick\\\',function(event,ret){...})\');
	        return;
	      }
	      $(\'#btnSel\',tblId).trigger(\'afterClick\',[json.data]);
	    }
	  });
	  
	setTimeout(function(){
	    $(\'#btnSel\',tblId).attr(\'disabled\',false);
	}, 600);
}
</script>
'; ?>