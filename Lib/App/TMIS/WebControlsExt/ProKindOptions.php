<?php
function _ctlProKindOptions($name,$params) {
	$m = & FLEA::getSingleton("Model_Jichu_Client");
	$sql = "select distinct kind from jichu_product where 1 ";
	$rowset = $m->findBySql($sql);
	$ret = "<option value='' style='color:#ccc'>物料类别</option>";
	foreach($rowset as & $v) {
		$ret .= "<option value='{$v['kind']}'";
		if($params['selected']==$v['kind']) $ret .= " selected";
		$ret .= ">{$v['kind']}</option>
		";
	}
	return $ret;
}
?>
