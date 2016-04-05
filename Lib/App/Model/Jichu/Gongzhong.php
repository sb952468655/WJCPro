<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Gongzhong extends TMIS_TableDataGateway {
	var $tableName = 'jichu_gongzhong';
	var $primaryKey = 'id';
	var $primaryName = 'itemName';

	function getSelect(){
		$row=$this->findAll(null,'orderLine');
		foreach($row as & $v){
			$arr[]=array('text'=>$v[$this->primaryName],'value'=>$v[$this->primaryName]);
		}
		return $arr;
	}
}
?>