<?php /* Smarty version 2.6.10, created on 2014-10-30 14:20:17
         compiled from Shengchan/sonTpl.tpl */ ?>
<script language="javascript">
<?php echo '
	$(function(){
		$(\'[name="chengfenPer[]"],[name="sunhao[]"]\').live(\'change\',function(){
			var pos=$(\'[name="\'+this.name+\'"]\').index(this);
			var chengfenPer = parseFloat($(\'[name="chengfenPer[]"]\').eq(pos).val())||0;
			var sunhao = parseFloat($(\'[name="sunhao[]"]\').eq(pos).val())||0;
			var cntSc = parseFloat($(\'#cntShengchan\').val())||0;
			var cntKg = (cntSc*chengfenPer/100*(1+sunhao/100)).toFixed(2);
			$(\'[name="cntKg[]"]\').eq(pos).val(cntKg);
		});
	});
'; ?>

</script>