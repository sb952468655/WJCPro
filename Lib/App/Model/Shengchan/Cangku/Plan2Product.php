<?php
load_class('TMIS_TableDataGateway');
class Model_Shengchan_Cangku_Plan2Product extends TMIS_TableDataGateway {
	var $tableName = 'pisha_plan_son';
	var $primaryKey = 'id';

	var $belongsTo = array (
		array(
			'tableClass' => 'Model_Shengchan_Cangku_Plan',
			'foreignKey' => 'psPlanId',
			'mappingName' => 'Plan',
		),
		array(
			'tableClass' => 'Model_Jichu_Jiagonghu',
			'foreignKey' => 'supplierId',
			'mappingName' => 'Supplier',
		)
	);

	/**
	 * 目的：保存关系到投料计划中
	*/
	public function _afterCreateDb(& $row)
	{
		if($row['plan2tlId']!=''){
			$sql="update shengchan_plan2product_touliao set psPlan2proId='{$row['id']}' where id in ({$row['plan2tlId']})";
			$this->execute($sql);
		}
	}

}


?>