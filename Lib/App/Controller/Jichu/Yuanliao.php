<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Yuanliao extends Tmis_Controller{
  var $_modelExample;
  var $fldMain;

  ///构造函数
  function Controller_Jichu_Yuanliao() {
    $this->_modelExample = & FLEA::getSingleton('Model_Jichu_Yuanliao');
    //得到所有的历史成分
    $sql = "select zhonglei from jichu_yuanliao group by zhonglei";
    $rowset = $this->_modelExample->findBySql($sql);
    foreach($rowset as & $v) {
      $opt[] = array('text'=>$v['zhonglei'],'value'=>$v['zhonglei']);
    }
     //得到所有的历史颜色
    $sql = "select color from jichu_yuanliao group by color";
    $rowset = $this->_modelExample->findBySql($sql);
    foreach($rowset as & $v) {
      $color[] = array('text'=>$v['color'],'value'=>$v['color']);
    }
    $this->fldMain = array(            
      'kind'=>array('title'=>'分类',"type"=>"select",'value'=>'','options'=>array(
        array('text'=>'坯纱','value'=>'坯纱'),
        array('text'=>'色纱','value'=>'色纱'),
      )),
      'proCode'=>array('title'=>'物料编码',"type"=>"text",'value'=>''),
      'zhujiCode'=>array('title'=>'助记码','type'=>'text','value'=>''),
      // 'zhonglei'=>array('title'=>'纱支成分','type'=>'combobox','value'=>'','options'=>$opt),
      'proName'=>array('title'=>'纱支支数','type'=>'text','value'=>''),
      'guige'=>array('title'=>'纱支规格','type'=>'text','value'=>''),
      'color'=>array('title'=>'纱支颜色','type'=>'combobox','value'=>'','options'=>$color),
      'memo'=>array('title'=>'备注说明','type'=>'textarea','value'=>''),           
      'id'=>array('type'=>'hidden','value'=>''),
      //'kind'=>array('value'=>''),
    );
  }

  function actionRight() {
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      "kindYuanliao"=>"",
      'key' => '',
    ));
     $str = "select * from jichu_yuanliao where 1";
    if ($arr['key']!='') $str .= " and (proCode like '%{$arr['key']}%'
                        or proName like '%{$arr['key']}%'
                        or guige like '%{$arr['key']}%')";
    $arr['kindYuanliao'] && $str.= " and kind='{$arr['kindYuanliao']}'";
    $str .=" order by proCode asc,proName asc,guige asc";
    $pager =& new TMIS_Pager($str);
    $rowset =$pager->findAllBySql($str);
    //$pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
    if(count($rowset)>0) foreach($rowset as & $v){
      $v['_edit'] = $this->getEditHtml($v['id']) . ' ' . $this->getRemoveHtml($v['id']);
    }
    $smarty = & $this->_getView();
    $smarty->assign('title', '选择产品');
    $pk = $this->_modelExample->primaryKey;
    $smarty->assign('pk', $pk);
    $arr_field_info = array(
      "_edit"=>'操作',
      "kind"=>'类别',
      "proCode" =>"产品编码",
      "zhonglei" =>"成分",
      "proName" =>"纱支",
      "guige" =>"规格",
      "color" => "颜色"
      //"unit" =>"单位",
      // 'cntKucun'=>'库存数'
    );
    $smarty->assign('arr_field_info',$arr_field_info);
    $smarty->assign('arr_field_value',$rowset);
    // $smarty->assign('add_display','none');
    $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('thickbox')));
    $smarty->assign('arr_condition',$arr);
    $smarty->assign('page_info',$pager->getNavBar($this->_url('Popup',$arr)));
    $smarty-> display('Popup/CommonNew.tpl');
  }

  //**************************弹出原料信息 begin***************************
  function actionPopup(){
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      'key' => '',
      "kind"=>""
    ));
     $str = "select * from jichu_yuanliao where 1";
    if ($arr[key]!='') $str .= " and (proCode like '%$arr[key]%'
                        or proName like '%$arr[key]%'
                        or guige like '%$arr[key]%')";
  
    $str .=" order by proCode asc,proName asc,guige asc";
    $pager =& new TMIS_Pager($str);
    $rowset =$pager->findAllBySql($str);
    //$pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
    if(count($rowset)>0) foreach($rowset as & $v){
      // $str="select * from cangku_init where productId='{$v['id']}'";
      // $re=mysql_fetch_assoc(mysqL_query($str));
      // $v['cntKucun']=$re['initCnt']+$re['kucunCnt'];
      //$v['text'] = $v['proCode']."&nbsp;".$v['proName']."&nbsp;".$v['pinpai']."&nbsp;".$v['guige'];
      //$v['text'] = str_replace('"','“',$v['text']);
      //$v['_edit'] = "<a href='#' onclick=\"retOptionValue($v[id],'".$v['text']."')\">选择</a>";
    }
    $smarty = & $this->_getView();
    $smarty->assign('title', '选择产品');
    $pk = $this->_modelExample->primaryKey;
    $smarty->assign('pk', $pk);
    $arr_field_info = array(
      "proCode" =>"种类",
      "proName" =>"产品名称",
      //"color" => "颜色",
      "guige" =>"规格",
      //"unit" =>"单位",
      // 'cntKucun'=>'库存数'
    );
    if($arr["kind"]==1){
      $arr_field_info["proCode"] = "种类";
      $arr_field_info["proName"]= "品名";
    }
    if($arr["kind"]==2){
       $arr_field_info["proCode"] = "种类";
      $arr_field_info["proName"]= "品名";
    }
    if($arr["kind"]==3){
        $arr_field_info["proCode"] = "种类";
      $arr_field_info["proName"]= "品名";
    }
    $smarty->assign('arr_field_info',$arr_field_info);
    $smarty->assign('arr_field_value',$rowset);
    $smarty->assign('add_display','none');
    $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('thickbox')));
    $smarty->assign('arr_condition',$arr);
    $smarty->assign('page_info',$pager->getNavBar($this->_url('Popup',$arr)));
    $smarty-> display('Popup/CommonNew.tpl');
   }
   //**************************弹出产品信息 end***************************

  function actionAdd() {
    $smarty = & $this->_getView();
    $smarty->assign('fldMain',$this->fldMain);
    $smarty->assign('title','原料信息编辑');
    $smarty->display('Main/A.tpl');
  }

  function actionEdit() {
    $row = $this->_modelExample->find(array('id'=>$_GET['id']));
    $this->fldMain = $this->getValueFromRow($this->fldMain,$row);
    // dump($row);dump($this->fldMain);exit;
    $smarty = & $this->_getView();
    $smarty->assign('fldMain',$this->fldMain);
    $smarty->assign('title','原料信息编辑');
    $smarty->assign('aRow',$row);
    $smarty->display('Main/A.tpl');
  }

  function actionSave() {
    // dump($_POST);exit;
    //确保产品编码,品名,规格,颜色都存在
    if(!$_POST['kind']) {
      js_alert('请选择类别!',null,$this->_url($_POST['fromAction']));
      exit;
    }
    if(!$_POST['proCode']) {
      js_alert('产品编码缺失!',null,$this->_url($_POST['fromAction']));
      exit;
    } else {
      //产品编码不重复
      $sql = "select count(*) cnt from jichu_yuanliao where proCode='{$_POST['proCode']}' and id<>'{$_POST['id']}'";
      $_rows = $this->_modelExample->findBySql($sql);
      if($_rows[0]['cnt']>0) {
        js_alert('产品编码重复!',null,$this->_url($_POST['fromAction']));
        exit;
      }
    }
    if(!$_POST['proName']) {
      js_alert('品名缺失!',null,$this->_url($_POST['fromAction']));
      exit;
    }
    if(!$_POST['guige']) {
      js_alert('规格缺失!',null,$this->_url($_POST['fromAction']));
      exit;
    }
    if(!$_POST['color']) {
      js_alert('颜色缺失!',null,$this->_url($_POST['fromAction']));
      exit;
    }
    $this->_modelExample->save($_POST);
    js_alert(null,'window.parent.showMsg("保存成功")',$this->_url($_POST['fromAction']));
    exit;
  }
}
?>