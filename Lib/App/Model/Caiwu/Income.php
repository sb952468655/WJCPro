<?php
load_class('TMIS_TableDataGateway');
class Model_Caiwu_Income extends TMIS_TableDataGateway {
	var $tableName = 'caiwu_income';
	var $primaryKey = 'id';
	var $belongsTo = array(
//		array(
//			'tableClass' => 'Model_Caiwu_IncomeAccount',
//			'foreignKey' => 'accountId',
//			'mappingName' => 'Account'
//		),
//		array(
//			'tableClass' => 'Model_Jichu_Client',
//			'foreignKey' => 'clientId',
//			'mappingName' => 'Client'
//		),
		array(
			'tableClass' => 'Model_Caiwu_Bank',
			'foreignKey' => 'bankId',
			'mappingName' => 'Bank'
		)

	);
//	var $hasMany=array(
//		    array(
//			'tableClass' => 'Model_Caiwu_Ar_Guozhang',
//			'foreignKey' => 'incomeId',
//			'mappingName' => 'Guozhang'
//		    )
//	    );
	#得到入账方式的中文说明
	function getTypeDesc($typeId){
		if ($typeId==0) return '现金';
		if ($typeId==1) return '支票';
		if ($typeId==2) return '电汇';
		if ($typeId==3) return '其他';
		if ($typeId==4) return '承兑';
		if ($typeId==5) return '汇票';
	}
}
?>