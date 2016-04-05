<?php /* Smarty version 2.6.10, created on 2014-10-30 13:50:57
         compiled from Trade/OrderEdit.tpl */ ?>
<?php echo '
<script language="javascript">
$(function(){
	/**
	 * 复制按钮
	*/
	$(\'[id="btnCopy"]\',\'#table_main\').click(function(){
		var tr = $(this).parents(\'.trRow\');
		var nt = tr.clone(true);
	    
	    //有些数据需要制空
	    $(\'[name="cntYaohuo[]"]\',nt).val(\'\');
	    $(\'[name="money[]"]\',nt).val(\'\');
	    $(\'[name="memo[]"]\',nt).val(\'\');
	    $(\'[name="id[]"]\',nt).val(\'\');
	    //拼接
	    tr.after(nt);
	});
});
</script>
'; ?>