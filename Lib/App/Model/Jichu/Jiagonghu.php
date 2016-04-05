<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Jiagonghu extends TMIS_TableDataGateway {
	var $tableName = 'jichu_jiagonghu';
	var $primaryKey = 'id';
	var $primaryName = 'compName';
	var $sortByKey = ' letters';
	var $optgroup = true;

	var $belongsTo = array(
		array(
			'tableClass' => 'Model_Jichu_Gongxu',
			'foreignKey' => 'gongxuId',
			'mappingName' => 'Gongxu'
		)
	);

	//获取加工户
	function getJghOptions($arr){
		$textItem = $arr['valueField']!=''?$arr['valueField']:$this->primaryName;
		$valueItem = $arr['valueKey']!=''?$arr['valueKey']:$this->primaryKey;


		$gongxu=$this->findAll(array('isSupplier'=>0),$this->sortByKey);
		// dump($gongxu);exit;
		$item=array();
		foreach($gongxu as & $v){
			$item[]=array('text'=>$v[$textItem],'value'=>$v[$valueItem]);
		}
		return $item;
	}

	function getSupplierOptions($arr){
		$textItem = $arr['valueField']!=''?$arr['valueField']:$this->primaryName;
		$valueItem = $arr['valueKey']!=''?$arr['valueKey']:$this->primaryKey;


		$gongxu=$this->findAll(array('isSupplier'=>1),'letters');
		// dump($gongxu);exit;
		$item=array();
		foreach($gongxu as & $v){
			$item[]=array('text'=>$v[$textItem],'value'=>$v[$valueItem]);
		}
		return $item;
	}
}
?>