<?php /* Smarty version 2.6.10, created on 2014-11-13 11:55:48
         compiled from caiwu/Xianjin/PaySon.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'json_encode', 'caiwu/Xianjin/PaySon.tpl', 3, false),)), $this); ?>

<script language="javascript">
var aRow = <?php echo json_encode($this->_tpl_vars['aRow']); ?>
;
<?php echo '
$(function(){

$(\'#incomeCode\').val(aRow.incomeCode);
$(\'#dakuanfang\').val(aRow.dakuanfang);
$(\'#incomeDate\').val(aRow.incomeDate);
$(\'#zhifuWay\').val(aRow.zhifuWay);
$(\'#bankId\').val(aRow.bankId);
$(\'#memo\').val(aRow.memo);
$(\'#id\').val(aRow.id);
});
</script>
'; ?>