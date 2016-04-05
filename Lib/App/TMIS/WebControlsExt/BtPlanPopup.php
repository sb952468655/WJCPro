<?php
/*
*2014-3-26 by jeff : select需要被bootstrap控件使用，所以这里改动为select1
*/
function _ctlBtPlanPopup($name,$params){
	// dump($params);
	$itemName 	= $params['itemName'];
	$readonly = $params['readonly']?"readonly":'';
	$disabled = $params['disabled']?"disabled":'';
  $value = $params['value']?$params['value']:'';

    if($value!='') {
    	$m = & FLEA::getSingleton('Model_Shengchan_Plan');
    	$sql = "select * from shengchan_plan where id='{$value}'";
    	$temp = $m->findBySql($sql);
    	// dump($temp);
    	$planCode = $temp[0]['planCode'];
      $orderId =  $temp[0]['orderId'];
    }
  
    $html = "
  <div style='width:150px;'>
      <div class='input-group span12'>      
        <input name='planCode' class='form-control'  type='text' id='planCode' value='{$planCode}' readonly placeholder='单击选择' />
        <span class=\"input-group-btn\" name='btnPlanCode' id='btnPlanCode'>
          <button class=\"btn btn-default\" type=\"button\">...</button>
        </span>
        <input name='{$itemName}' type='hidden' id='plan2proId' value='{$value}' />
      </div>
  </div>
  ";
    // dump($html);
	return $html;	
}
?>