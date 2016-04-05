<?php
/*
*2014-3-26 by jeff : select需要被bootstrap控件使用，所以这里改动为select1
*/
function _ctlBtSelect($name,$params){	
	$itemName 	= $params['itemName'];
	$opts 	= $params['options'];
	$selected = $params['value'];
    $condition = $params['condition'];
    $sortByKey = $params['sort'];
    $disabled = $params['disabled']?"disabled":'';
    $emptyText = $params['emptyText']?$params['emptyText']:'请选择';
    //$selected = 1;
    $model = $params['model'];
    $inTable =  $params['inTable']?"style='width:auto'":'';//显示在hidden控件中的字段
    
    if($model!='') {
        if(count($opts)==0) { //根据model取得所有的基础档案数据
            $m = & FLEA::getSingleton($model);
            $sortByKey = $m->sortByKey!=''?$m->sortByKey:$sortByKey;
            $rowset = $m->findAll($condition,$sortByKey,NULL);
            foreach($rowset as & $v) {
                $opts[] = array('text'=>$v[$m->primaryName],'value'=>$v[$m->primaryKey]);
            }
        }       
    }
    $html = "<select name='{$itemName}' id='{$itemName}' {$disabled} class='form-control' {$inTable}>";
    $html .= "<option value=''>{$emptyText}</option>";

    //需要汇总显示的，处理
    if($m->optgroup==true){
        FLEA::loadClass('TMIS_Common');
        $letterTrue=true;
        $letter='';
    }

    foreach($opts as $k => & $v) {
        //处理汇总信息
        if($letterTrue && $v['value']!=''){
            $temp_lett=strtoupper(TMIS_Common::getPinyin($v['text']));
            if($letter!=substr($temp_lett,0,1)){
                $letter=substr($temp_lett,0,1);
                if($k>1)$html .="</optgroup>";
                $html .="<optgroup label='{$letter}'>";
            }
        }
        //处理下拉选项信息
    	$html.= "<option value='{$v['value']}'";
    	if($selected==$v['value']) $html.=" selected ";
    	$html.=">{$v['text']}</option>";
    }
    $html .= "</select>";
	return $html;	
}
?>