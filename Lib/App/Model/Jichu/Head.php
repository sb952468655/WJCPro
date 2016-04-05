<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Head extends TMIS_TableDataGateway {
	var $tableName = 'jichu_head';
	var $primaryKey = 'id';
	var $primaryName = 'head';
	// var $sortByKey = ' convert(trim(compName) USING gbk)';

}
?>