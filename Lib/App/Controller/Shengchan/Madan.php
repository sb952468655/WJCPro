<?php
FLEA::loadClass('Tmis_Controller');
class Controller_Shengchan_Madan extends Tmis_Controller {
	// /构造函数
	function __construct() {
		$this->_modelExample = & FLEA::getSingleton('Model_Shengchan_Cangku_Madan');
	}

	/**
	 * 码单导出
	 * Time：2014/06/30 13:48:23
	 * @author li
	*/
	function actionExport(){
		$tpl = 'Shengchan/Export.tpl';
		FLEA::loadClass('TMIS_Pager');
		$name=FLEA::getAppInf('compName');
		// dump($rowset);exit;
		//整理码单信息，每200个码单一页，40个一列，4列一行
		//导出时固定格式的参数
		$exportInfo=array();
		$eveCol=20;//一页40列，
		$eveRow=5;
		$evePage=$eveCol*$eveRow;
		$exportInfo=array(
			'page'=>$evePage,
			'col'=>$eveCol,
			'row'=>$eveRow,
		);

		// 取得需要导出的出库明细信息
		$str="select x.id,x.pihao,y.chukuDate,a.orderCode,b.menfu,b.kezhong,p.pinzhong,p.guige,x.color,x.cntJian,x.cnt,x.cntM,e.compName from cangku_chuku_son x
			left join cangku_chuku y on x.chukuId=y.id 
			left join trade_order2product b on x.ord2proId=b.id
			left join trade_order a on b.orderId=a.id
			left join jichu_client e on y.clientId=e.id
			left join jichu_product p on p.id=x.productId
			where 1";
		// if($_GET['orderId']!='') $str.=" and y.orderId='{$_GET['orderId']}'";//订单id
		if($_GET['chukuId']!='') $str.=" and y.id='{$_GET['chukuId']}'";
		$str.=" and exists(select id from cangku_madan c where c.chuku2proId=x.id)";
		// dump($str);exit;
		$rowset = $this->_modelExample->findBySql($str);
		// dump($rowset);exit;
		//查找出库明细具体的码单信息
		foreach ($rowset as $k => & $row) {
			$cntKg=0;
			$cntM=0;
			$arr=array();
			//查找码单信息
			$sql="select * from cangku_madan where chuku2proId='{$row['id']}'";
			$row['Son']=$this->_modelExample->findBySql($sql);
			
			//处理码单信息
			$temp_number=array();
			foreach($row['Son'] as & $v) {
				#取得最大值，确定所需的表格数及求得发运数
				$cntKg+=$v['cnt'];
				$cntM+=$v['cntM'];
				// $v['num']=$v['number'].'#';
				//取得值类型,判断是为String还是Number
				$v['type']='String';
				if(is_numeric($v['cnt_format'])) {
					$v['type'] = 'Number';
				}
				// $temp_number[]=$v['number'];
			}

			$row['cnt_Kg']=$cntKg;
			$row['cnt_M']=$cntM;
			$row['cnt_Jian']=count($row['Son']);

			/**
			* 处理码单之间的件数不间断
			*/
			/*$son_arr=array();
			foreach($row['Son'] as & $v){
				$son_arr[$v['number']]=$v;
			}
			// dump($son_arr);exit;
			$min=min($temp_number);$max=max($temp_number);
			$min=floor($min/($eveCol*$eveRow))*$eveCol*$eveRow+1;
			// echo $min;exit;
			for($i=$min;$i<=$max;$i++) {
				if(!isset($son_arr[$i]))$son_arr[$i]=array('number'=>$i);
			}
			// dump($son_arr);exit;
			$row['Son']=$son_arr;*/
		}

		//计算小计
		$xiaoji=array();
		foreach($rowset as $key => & $v){
			$son=array_column_sort($v['Son'],'number',SORT_ASC);
			// ksort($v['Son']);
			// $son=$v['Son'];
			// dump($son);exit;
			//计算需要的页数，并重新组织数据
			$page=ceil(count($son)/$evePage);
			$newSon=array();//每200条数据放在一个数组里
			for($i=0;$i<$page;$i++){
			    $newSon[]=array_slice($son,$evePage*$i,$evePage);
			}
			// dump($newSon);exit;
			//对每页处理,处理成每页中 每20条数据放在一个数组中
			foreach($newSon as $kp => & $vv){
				$temp=ceil(count($vv)/$eveCol);
				$newRow=array();
				for($i=0;$i<$temp;$i++){
				    $newRow[]=array_slice($vv,$eveCol*$i,$eveCol);
				}
				// dump($newRow);exit;
				//覆盖原来的每页中的数据
				$vv=$newRow;
				//计算小计，对该页中不同列计算小计
				foreach($newRow as $k=>& $val){
				    foreach($val as & $he){
						$xiaoji[$key][$kp][$k]['cnt']+=$he['cnt'];
						$xiaoji[$key][$kp][$k]['cntM']+=$he['cntM'];
				    }
				}
			}
			// dump($newSon);exit;
			//覆盖原来son值
			$v['Son']=$newSon;
		}

		//计算每个花型的需要的分页行位置
		$arrPos = array();
		$head=3;
		$nums=0;
		$noP=0;
		//dump($xiaoji);
		foreach($xiaoji as $k=>& $v) {
			for($i=1;$i<=count($v);$i++){
			    $no=count($v)>1?42:43;
				$no=$i==count($v)?43:42;
				//每页行数
				$page= $i==1?$head+$no:$no;
				//dump($i);dump($page);
				$nums+=$page;
				$arrPos[$k][] =$nums;
				$noP++;
			}
		}
		// dump($rowset);exit;
		$smarty=& $this->_getView();
		$smarty->assign('madan',$rowset);
		$smarty->assign('name',$name);
		$smarty->assign('noP',$noP);//分得页数
		$smarty->assign('arrPos',$arrPos);
		$smarty->assign('xiaoji',$xiaoji);
		$smarty->assign('zongji',$zongji);
		$smarty->assign('exInfo',$exportInfo);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=".iconv('utf-8',"gb2312", "码单".$rowset[0]['compName'].'-'.$rowset[0]['chukuDate']).".xls");
		header("Content-Transfer-Encoding: binary");
		$smarty=$smarty->display($tpl);
	}
}
?>