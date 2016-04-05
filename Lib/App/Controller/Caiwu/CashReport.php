<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Caiwu_CashReport extends Tmis_Controller {
	var $_modelExample;
	//var $funcId=116;
	var $title ='现金日记帐';
	function Controller_Caiwu_CashReport() {
		$this->_modelExample = & FLEA::getSingleton('Model_Caiwu_Income');
	}

	function actionRight(){
		$this->authCheck('8-3-5');

		FLEA::loadClass('TMIS_Pager');
		$arrParam = array(
			'dateFrom'=>date("Y-m-01"),
			'dateTo'=>date("Y-m-d"),
			'bankId'=>'',
            'feiyongId'=>0
		);
		$arr = TMIS_Pager::getParamArray($arrParam);

		//期初支出
		$sql = "select sum(money) as money from caiwu_xianjin where payDate<'{$arr['dateFrom']}' and kind=0";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
                if($arr['feiyongId']>0) $sql.=" and itemId = '{$arr['feiyongId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$initOut = $r[0]['money'];

		//期初收入
		$sql = "select sum(money) as money from caiwu_income where incomeDate<'{$arr['dateFrom']}' and kind=0";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
                if($arr['feiyongId']>0) $sql.=" and itemId = '{$arr['feiyongId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$initIn = $r[0]['money'];

		//总期初
		$totalInit = round($initIn - $initOut,2);
		$arrInit = array(
			'date' => "<font color=blue>期初余额</font>",
			'remain' => "<font color=blue>".$totalInit."</font>"
		);

		$arrRet = array();

		//支出
		$sql = "select x.*,y.itemName from caiwu_xianjin x
		left join caiwu_bank y on x.bankId=y.id
		where x.kind=0 and payDate>='{$arr['dateFrom']}' and payDate<='{$arr['dateTo']}'";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
        if($arr['feiyongId']>0) $sql.=" and x.itemId = '{$arr['feiyongId']}'";
                //echo $sql;exit;
		$expense = $this->_modelExample->findBySql($sql);
		if (count($expense)>0) foreach($expense as & $v) {
                       // dump($v);exit;
			$arrRet[] = array(
				"date" =>$v['payDate'],
				"bank"=>$v['itemName'],
				//"dakuanfang"=>'对方打款方',
				"shoukuanfang"=>$v['shoukuanfang'],
				//"moneyIncome"=>$v['money'],
				"moneyExpense"=>$v['money'],
				"memo" =>$v['memo'],
				'itemid' =>$v['itemId'],
				"dt"=>$v['payDate']
			);
		}
                //dump($arrRet);exit;
		//收入
		$sql = "select x.*,y.itemName from caiwu_income x
		left join caiwu_bank y on x.bankId=y.id
		where x.kind=0 and incomeDate>='{$arr['dateFrom']}' and incomeDate<='{$arr['dateTo']}'";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
        if($arr['feiyongId']>0) $sql.=" and x.itemId = '{$arr['feiyongId']}'";
        // echo $sql;exit;
		$expense = $this->_modelExample->findBySql($sql);
		if (count($expense)>0) foreach($expense as & $v) {
			$arrRet[] = array(
				"date" =>$v['incomeDate'],
				"bank"=>$v['itemName'],
				"dakuanfang"=>$v['dakuanfang'],
				//"shoukuanfang"=>$v['shoukuanfang'],
				"moneyIncome"=>$v['money'],
				//"moneyExpense"=>$v['shoukuanfang'],
				"memo" =>$v['memo'],
				//'remain' =>$v['shoukuanfang'],
				"dt"=>$v['incomeDate']
			);
		}
                //dump($arrRet);exit;
		//排序
		$arrRet = array_column_sort($arrRet,'date');
		array_unshift($arrRet, $arrInit);

		$heji = $this->getHeji($arrRet,array('moneyIncome','moneyExpense'),'date');
		$heji['remain'] = round($totalInit+$heji['moneyIncome']-$heji['moneyExpense'],2);
		$arrRet[] = $heji;

		$arr_field_info = array(
			"date" =>"日期",
			//"way" => "入帐方式",
			"bank"=>'账户',
			"dakuanfang"=>'对方打款人',
			"shoukuanfang"=>'对方收款人',
			"moneyIncome"=>'收入金额',
			"moneyExpense"=>'支出金额',
			"memo" =>"发生说明",
			'remain' =>'余额',
			'dt'=>'登记时间'
		);

		//设置模板
		$smarty = & $this->_getView();
		$smarty->assign('title', "日记帐");
		//$smarty->assign('compCode',$arr['compCode']);
		$smarty->assign('list_url', $this->_url('Export',$arr+array('fromAction'=>$_GET['action'])));
		$smarty->assign('list_text', '导出');
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$arrRet);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->display('TableList.tpl');
	}

	//现金日报表的导出
	function actionExport(){
		$tpl = 'Export2Excel.tpl';
		$title="现金日报表";
		$arr = $_GET;
		if($_GET['dateFrom']!='') $arr['dateFrom']=$_GET['dateFrom'];
		if($_GET['dateTo']!='') $arr['dateTo']=$_GET['dateTo'];
		if($_GET['bankId']!='') $arr['bankId']=$_GET['bankId'];
		if($_GET['feiyongId']!='') $arr['feiyongId']=$_GET['feiyongId'];
		//期初支出
		$sql = "select sum(money) as money from caiwu_xianjin where payDate<'{$arr['dateFrom']}' and kind=0";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
        if($arr['feiyongId']>0) $sql.=" and itemId = '{$arr['feiyongId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$initOut = $r[0]['money'];

		//期初收入
		$sql = "select sum(money) as money from caiwu_income where incomeDate<'{$arr['dateFrom']}' and kind=0";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
                if($arr['feiyongId']>0) $sql.=" and itemId = '{$arr['feiyongId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$initIn = $r[0]['money'];

		//总期初
		$totalInit = round($initIn - $initOut,2);
		$arrInit = array(
			'date' => "期初余额",
			'remain' =>$totalInit
		);

		$arrRet = array();

		//支出
		$sql = "select x.*,y.itemName from caiwu_xianjin x
		left join caiwu_bank y on x.bankId=y.id
		where x.kind=0 and payDate>='{$arr['dateFrom']}' and payDate<='{$arr['dateTo']}'";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
        if($arr['feiyongId']>0) $sql.=" and x.itemId = '{$arr['feiyongId']}'";
                //echo $sql;exit;
		$expense = $this->_modelExample->findBySql($sql);
		if (count($expense)>0) foreach($expense as & $v) {
                       // dump($v);exit;
			$arrRet[] = array(
				"date" =>$v['payDate'],
				"bank"=>$v['itemName'],
				//"dakuanfang"=>'对方打款方',
				"shoukuanfang"=>$v['shoukuanfang'],
				//"moneyIncome"=>$v['money'],
				"moneyExpense"=>$v['money'],
				"memo" =>$v['memo'],
				'itemid' =>$v['itemId'],
				"dt"=>$v['payDate']
			);
		}
		//dump($arrRet);exit;
		//收入
		$sql = "select x.*,y.itemName from caiwu_income x
		left join caiwu_bank y on x.bankId=y.id
		where x.kind=0 and incomeDate>='{$arr['dateFrom']}' and incomeDate<='{$arr['dateTo']}'";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
        if($arr['feiyongId']>0) $sql.=" and x.itemId = '{$arr['feiyongId']}'";
                //echo $sql;exit;
		$expense = $this->_modelExample->findBySql($sql);
		if (count($expense)>0) foreach($expense as & $v) {
			$arrRet[] = array(
				"date" =>$v['incomeDate'],
				"bank"=>$v['itemName'],
				"dakuanfang"=>$v['dakuanfang'],
				"moneyIncome"=>$v['money'],
				"memo" =>$v['memo'],
				"dt"=>$v['incomeDate']
			);
		}
		$arrRet = array_column_sort($arrRet,'date');
		array_unshift($arrRet, $arrInit);
		$heji = $this->getHeji($arrRet,array('moneyIncome','moneyExpense'),'date');
		$heji['remain'] = round($totalInit+$heji['moneyIncome']-$heji['moneyExpense'],2);
		$arrRet[] = $heji;
		//dump($arrRet);exit;
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment;filename=Domestic collection.xls");
		header("Content-Transfer-Encoding: binary");
		$smarty = & $this->_getView();
		$smarty->assign('title', $title);
		$smarty->assign('arr_field_info',array(
			"date" =>"日期",
			"bank"=>'账户',
			"dakuanfang"=>'对方打款人',
			"shoukuanfang"=>'对方收款人',
			"moneyIncome"=>'收入金额',
			"moneyExpense"=>'支出金额',
			"memo" =>"发生说明",
			'remain' =>'余额',
			'dt'=>'登记时间'

		));
		$smarty->assign('arr_field_value',$arrRet);
		$smarty->display($tpl);
	}
	

    function actionRight1(){
		//$this->authCheck(36);

		FLEA::loadClass('TMIS_Pager');
		$arrParam = array(
			'dateFrom'=>date("Y-m-01"),
			'dateTo'=>date("Y-m-d"),
			'bankId'=>'',
                        'feiyongId'=>''
		);
		$arr = TMIS_Pager::getParamArray($arrParam);

		//期初支出
		$sql = "select sum(money) as money from caiwu_xianjin where payDate<'{$arr['dateFrom']}' and kind=1";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
                if($arr['feiyongId']>0) $sql.=" and itemId = '{$arr['feiyongId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$initOut = $r[0]['money'];

		//期初收入
		$sql = "select sum(money) as money from caiwu_income where incomeDate<'{$arr['dateFrom']}' and kind=1";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
                if($arr['feiyongId']>0) $sql.=" and itemId = '{$arr['feiyongId']}'";
		$r = $this->_modelExample->findBySql($sql);
		$initIn = $r[0]['money'];

		//总期初
		$totalInit = round($initIn - $initOut,2);
		$arrInit = array(
			'date' => "<font color=blue>期初余额</font>",
			'remain' => "<font color=blue>".$totalInit."</font>"
		);


		$arrRet = array();

		//支出
		$sql = "select x.*,y.itemName from caiwu_xianjin x
		left join caiwu_bank y on x.bankId=y.id
		where x.kind=1 and payDate>='{$arr['dateFrom']}' and payDate<='{$arr['dateTo']}'";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
                if($arr['feiyongId']>0) $sql.=" and x.itemId = '{$arr['feiyongId']}'";
		$expense = $this->_modelExample->findBySql($sql);
		if (count($expense)>0) foreach($expense as & $v) {
                       // dump($v);exit;
			$arrRet[] = array(
				"date" =>$v['payDate'],
				"bank"=>$v['itemName'],
				//"dakuanfang"=>'对方打款方',
				"shoukuanfang"=>$v['shoukuanfang'],
				//"moneyIncome"=>$v['money'],
				"moneyExpense"=>$v['money'],
				"memo" =>$v['memo'],
				//'remain' =>$v['shoukuanfang'],
				"dt"=>$v['payDate']
			);
		}

		//收入
		$sql = "select x.*,y.itemName from caiwu_income x
		left join caiwu_bank y on x.bankId=y.id
		where x.kind=1 and incomeDate>='{$arr['dateFrom']}' and incomeDate<='{$arr['dateTo']}'";
		if($arr['bankId']>0) $sql.=" and bankId='{$arr['bankId']}'";
                if($arr['feiyongId']>0) $sql.=" and x.itemId = '{$arr['feiyongId']}'";
		$expense = $this->_modelExample->findBySql($sql);
		if (count($expense)>0) foreach($expense as & $v) {
			$arrRet[] = array(
				"date" =>$v['incomeDate'],
				"bank"=>$v['itemName'],
				"dakuanfang"=>$v['dakuanfang'],
				//"shoukuanfang"=>$v['shoukuanfang'],
				"moneyIncome"=>$v['money'],
				//"moneyExpense"=>$v['shoukuanfang'],
				"memo" =>$v['memo'],
				//'remain' =>$v['shoukuanfang'],
				"dt"=>$v['incomeDate']
			);
		}

		//排序
		$arrRet = array_column_sort($arrRet,'date');
		array_unshift($arrRet, $arrInit);

		$heji = $this->getHeji($arrRet,array('moneyIncome','moneyExpense'),'date');
		$heji['remain'] = round($totalInit+$heji['moneyIncome']-$heji['moneyExpense'],2);
		$arrRet[] = $heji;

		$arr_field_info = array(
			"date" =>"日期",
			//"way" => "入帐方式",
			"bank"=>'账户',
			"dakuanfang"=>'对方打款人',
			"shoukuanfang"=>'对方收款人',
			"moneyIncome"=>'收入金额',
			"moneyExpense"=>'支出金额',
			"memo" =>"发生说明",
			'remain' =>'余额',
			'dt'=>'登记时间'
		);

		//设置模板
		$smarty = & $this->_getView();
		$smarty->assign('title', "日记帐");
		//$smarty->assign('compCode',$arr['compCode']);
		$smarty->assign('arr_field_info',$arr_field_info);
		$smarty->assign('arr_field_value',$arrRet);
		$smarty->assign('add_display', 'none');
		$smarty->assign('arr_condition', $arr);
		$smarty->display('TableList.tpl');
	}

        //费用报表
    function actionReport(){
			$this->authCheck('8-3-8');
            FLEA::loadclass('TMIS_Pager');
            $arr=TMIS_Pager::getParamArray(array(
                    'years'=>date('Y'),
                    'key'=>''
            ));
            $str="SELECT x.*,y.feiyongName FROM caiwu_xianjin x
            LEFT JOIN jichu_feiyong y on x.itemId=y.id
             where itemId>0 and x.payDate like '{$arr['years']}%'";
            if($arr['key']!=''){
            	$str.=" and y.feiyongName like '%{$arr['key']}%'";
            }
            $str.="GROUP BY x.itemId";
            $rows=$this->_modelExample->findBySql($str);
            $rowset=array();
			if(count($rows)>0)
					foreach($rows as & $v) {
						$rowset[$v['itemId']]['itemName']=$v['feiyongName'];
			}
                //dump($rowset);exit;
                $arrItem=array();
                for($i=1;$i<13;$i++){
                    if($i<10){
                        $arrItem[$arr['years']."-0".$i]=$arr['years']."-0".$i;
                    }else $arrItem[$arr['years']."-".$i]=$arr['years']."-".$i;
                }
                //dump($arrItem);exit;
                $hj=array();
                if($rowset){
                    foreach($rowset as  $key=>& $v){
                        $heji=0;
                        foreach($arrItem as $key1=> & $v1){
                            $str="SELECT sum(money) as money FROM caiwu_xianjin where payDate LIKE '{$key1}%' and itemId='{$key}'";
                            $re=mysql_fetch_assoc(mysql_query($str));
                            $rowset[$key][$key1]=$re['money']+0;
                            $heji+=$re['money'];
                            $hj[$key1]+=$re['money'];
                            $rowset[$key][$key1]="<a href='".$this->_url('payDetail',array('dt'=>$key1,'itemId'=>$key,'TB_iframe'=>1))."' class='thickbox' title='明细'>".$rowset[$key][$key1]."</a>";
                        }
                       // if($heji)
                        $rowset[$key]['heji']=$heji;
                        $hj['heji']+=$heji;
                    }
                }
                //dump($rowset);exit;
            // dump($hj);exit;

                //$hj['_bgColor']='#FEF4C8';
                $hj['itemName']="<b>合计</b>";
                $rowset[]=$hj;
				$arr_field_info=array(
					'itemName'=>'项目名'
				);
                $arr_field_info=$arr_field_info+$arrItem;
                $arr_field_info['heji']="小计";
				//$note="<font color='red'>绿色表示已经到账完成。</font>";
				$smarty=& $this->_getView();
				$smarty->assign('arr_condition',$arr);
				//$smarty->assign('add_display','none');
				$smarty->assign('arr_field_info',$arr_field_info);
				$smarty->assign('arr_field_value',$rowset);
				$smarty->assign('add_display','none');
				//$smarty->assign('page_info',$page->getNavBar($this->_url($_GET['action'],$arr)).$note);
				$smarty->display('TblList.tpl');
        }

        //付款明细
        function actionPayDetail(){
            //dump($_GET);exit;
             FLEA::loadClass('TMIS_Pager');
        //dump($_GET);
        $str="SELECT * from caiwu_xianjin where payDate LIKE '{$_GET['dt']}%' and itemId='{$_GET['itemId']}'";
        $rowset=$this->_modelExample->findBySql($str);
        //echo $str;
        $heji=$this->getHeji($rowset,array('money'),'payCode');
        $rowset[]=$heji;
        $arr_field_info=array(
            'payCode'=>'凭证号',
            'payDate'=>'付款日期',
            'shoukuanfang'=>'收款方',
            'itemName'=>'费用名称',
            'money'=>'金额',
            'memoy'=>'备注'
        );
        $smarty=& $this->_getView();
        $smarty->assign('nav_display','none');
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
       // $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$_GET)));
        $smarty->display('Popup/Client.tpl');
        }
}
?>