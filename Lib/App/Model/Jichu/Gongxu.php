<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Gongxu extends TMIS_TableDataGateway {
	var $tableName = 'jichu_gongxu';
	var $primaryKey = 'id';
	var $primaryName = 'itemName';

	function getOptions($arr){
		$textItem = $arr['valueField']!=''?$arr['valueField']:$this->primaryName;
		$valueItem = $arr['valueKey']!=''?$arr['valueKey']:$this->primaryKey;


		$gongxu=$this->findAll(array('isStop'=>0),'orderLine');
		// dump($gongxu);exit;
		$item=array();
		foreach($gongxu as & $v){
			$item[]=array('text'=>$v[$textItem],'value'=>$v[$valueItem]);
		}
		return $item;
	}
	
}
?>