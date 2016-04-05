<?php /* Smarty version 2.6.10, created on 2014-11-11 16:55:24
         compiled from Popup/_init.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'json_encode', 'Popup/_init.tpl', 3, false),)), $this); ?>
<script language='javascript'>
//建立数据集缓存，用来双击某行时提取数据
var _ds = <?php echo json_encode($this->_tpl_vars['arr_field_value']); ?>
;
//定义ondbclick事件
<?php echo '
$(function(){
	$(\'.trRow\').dblclick(function(e){
		var pos = $(\'.trRow\').index(this);
		//ds可能为对象，不是纯粹的array,所以这里不能直接使用_ds[pos]
		var i=0;
		for(var k in _ds) {
			if(typeof(_ds[k])==\'function\') continue;
			if(i==pos) {
				var obj = _ds[k];
				break;
			}
			i++;
		}			
		if(window.parent.ymPrompt) window.parent.ymPrompt.doHandler(obj,true);//return false;
		else {
			if(window.parent.thickboxCallBack) {
				//return false;
				window.parent.tb_remove();
				window.parent.thickboxCallBack(obj,pos);
				window.close();
				return;
			}
			// debugger;
			if(window.opener!=undefined) {
				window.opener.returnValue = obj;
			} else {
				window.returnValue = obj;
			}
			window.close();			
		}
	});
});

'; ?>

</script>