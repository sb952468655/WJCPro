<?php
load_class('TMIS_TableDataGateway');
class Model_Jichu_Color extends TMIS_TableDataGateway {
	var $tableName = 'jichu_color';
	var $primaryKey = 'id';
	var $primaryName = 'color';
	var $letters = true;

	/**
	 * 获取现有的颜色，进行提示选择
	 * Time：2014/07/01 14:09:47
	 * @author li
	*/
	function getColor(){
		//获取颜色
		$rowset=$this->findAll(null,'letters');
		
		//组织颜色的数据集
		$data=array();
		foreach ($rowset as $key => & $v) {
			$data[]=array(
				'text'=>$v[$this->primaryName],
				'value'=>$v[$this->primaryName]
			);
		}

		//返回
		return $data;
	}

	/**
	 * 根据字符串保存颜色，可能存在多个颜色，用“,”隔开
	 * Time：2014/07/02 13:16:29
	 * @author li
	 * @param string
	 * @return boolean
	*/
	function saveStr($str){
		//判断是否为空，为空返回
		if(empty($str))return false;

		/*
		*
		* 字符串形成数组
		*/
		$color=explode(',',$str);//处理字符串成数组
		$color=$this->noEmpty($color);//去除空字符元素，需要去除空格

		//没有有效的颜色数据，返回
		if(!count($color)>0)return false;

		/*
		* 判断该颜色是否已存在表中，不存在的需要保存
		*
		*/
		$temp=array();//处理颜色，最终生成('绿色','蓝色')的字符串，数据查询的时候用
		foreach($color as & $v){
			$temp[]="'".$v."'";
		}
		$str_color=join(',',$temp);
		//查找数据库中已存在的颜色
		$sql="select color from ".$this->tableName." where color in({$str_color})";
		// echo $sql;exit;
		$color_have=$this->findBySql($sql);
		$color_have=array_col_values($color_have,'color');
		//查找数据库中不存在的部分
		$_color=array_diff($color,$color_have);
		#end

		//如果没有数据中不存在的数据，则返回
		if(!count($_color)>0)return false;

		/*
		*
		* 处理数据用于保存
		*/
		$rowset=array();
		if($this->letters)FLEA::loadClass('TMIS_Common');//首字母自动获取
		foreach ($_color as $key => & $v) {
			if($this->letters)$letters=strtolower(TMIS_Common::getPinyin($v));//首字母自动获取
			$rowset[]=array(
				'color'=>$v,
				'letters'=>$letters
			);
		}
		// dump($rowset);exit;
		$temp=$this->saveRowSet($rowset);
		return true;
	}

	/**
	 * 判断是否为空，不为空的返回，否则过滤；判断时候需要去除空格
	 * Time：2014/07/02 13:34:00
	 * @author li
	 * @param array
	 * @return array
	*/
	function noEmpty($arr){
		$row=array();
		foreach ($arr as & $v) {
			$v=trim($v);
			if(!empty($v))$row[]=$v;
		}
		return $row;
	}
}
?>