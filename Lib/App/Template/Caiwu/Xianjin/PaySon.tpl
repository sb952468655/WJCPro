
<script language="javascript">
var aRow = {$aRow|@json_encode};
{literal}
$(function(){

$('#incomeCode').val(aRow.incomeCode);
$('#dakuanfang').val(aRow.dakuanfang);
$('#incomeDate').val(aRow.incomeDate);
$('#zhifuWay').val(aRow.zhifuWay);
$('#bankId').val(aRow.bankId);
$('#memo').val(aRow.memo);
$('#id').val(aRow.id);
});
</script>
{/literal}