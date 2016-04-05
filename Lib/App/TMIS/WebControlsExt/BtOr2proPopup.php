<?php
function _ctlBtOr2proPopup($name,$params){
	// dump($params);
	$itemName 	= $params['itemName'];
	$readonly = $params['readonly']?"readonly":'';
	$disabled = $params['disabled']?"disabled":'';
    $value = $params['value']?$params['value']:'';

    if($value!='') {
    	$m = & FLEA::getSingleton('Model_Trade_Order2Product');
    	$sql = "select * from trade_order2product where id='{$value}'";
    	$temp = $m->findBySql($sql);
    	//dump($temp);
    	$proCode = $temp[0]['orderCode'];
    }
    
    // $orderName = $params['orderName']?$params['orderName']:'';
	$html = "<input name='proCode' class='form-control' type='text' id='proCode' value='{$proCode}' disabled />";	
	$html.= "<button type='button' class='btn btns btn-primary' id='btnOrd2pro' name='btnOrd2pro' style='border-radius:0px 2px 2px 0px; border:0px;'>...</button>";
	$html.="<input name='{$itemName}' type='hidden' id='{$itemName}' value='{$value}'>";
    // dump($html);
	return $html;	
}
?>