<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Jitai extends TMIS_TableDataGateway {
	var $tableName = 'jichu_jitai';
	var $primaryKey = 'id';
	var $primaryName = 'jitaiCode';

	var $sortByKey = "orderLine,jitaiCode";
}
?>