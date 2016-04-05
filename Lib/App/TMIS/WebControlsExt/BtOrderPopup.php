<?php
/*
*2014-3-26 by jeff : select需要被bootstrap控件使用，所以这里改动为select1
*/
function _ctlBtOrderPopup($name,$params){
	// dump($params);
	$itemName 	= $params['itemName'];
	$readonly = $params['readonly']?"readonly":'';
	$disabled = $params['disabled']?"disabled":'';
    $value = $params['value']?$params['value']:'';

    if($value!='') {
    	$m = & FLEA::getSingleton('Model_Trade_Order');
    	$sql = "select * from trade_order where id='{$value}'";
    	$temp = $m->findBySql($sql);
    	// dump($temp);
    	$orderName = $temp[0]['orderCode'];
    }
    
	// $html = "<input name='orderName' class='form-control' type='text' id='orderName' value='{$orderName}' disabled />";	
	// $html.= "<button type='button' class='btn btns btn-primary' id='btnorderName' name='btnorderName' style='border-radius:0px 2px 2px 0px; border:0px;'>...</button>";
	// $html.="<input name='{$itemName}' type='hidden' id='{$itemName}' value='{$value}'>";

    $html = '
    <div class="input-group input-group-sm">
      <input name=\'orderName\' class=\'form-control\' type=\'text\' id=\'orderName\' value="'.$orderName.'" disabled />
      <span class="input-group-btn" id="btnorderName" name="btnorderName">
        <button class="btn btn-default" type="button">...</button>
      </span>
      <input name="'.$itemName.'" type="hidden" id="'.$itemName.'" value="'.$value.'">
    </div>';
    // dump($html);
	return $html;	
}
?>