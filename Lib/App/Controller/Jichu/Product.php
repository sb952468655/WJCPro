<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Product extends Tmis_Controller{
  var $_modelExample;
  var $fldMain;

  ///构造函数
  function Controller_Jichu_Product() {
    $this->_modelExample = & FLEA::getSingleton('Model_Jichu_Product');
    
    $this->fldMain = array(            
      'kind'=>array('title'=>'分类',"type"=>"combobox",'value'=>'','options'=>array(),'auto'=>true),//auto 表示设置为true，下面的方法自动加载options
      'proCode'=>array('title'=>'物料编码',"type"=>"text",'value'=>$this->_autoCode('S',date('ym'),'jichu_product','proCode')),
      // 'zhujiCode'=>array('title'=>'助记码','type'=>'text','value'=>''),
      // 'zhonglei'=>array('title'=>'纱支成分','type'=>'combobox','value'=>'','options'=>array(),'auto'=>true),
      'proName'=>array('title'=>'纱支','type'=>'text','value'=>''),
      'guige'=>array('title'=>'规格','type'=>'text','value'=>''),
      'color'=>array('title'=>'颜色','type'=>'popupEdit','url'=>url($_GET['controller'],'SetColor'),'textFld'=>'color','hiddenFld'=>'color'),
      'memo'=>array('title'=>'备注说明','type'=>'textarea','value'=>''),           
      'id'=>array('type'=>'hidden','value'=>''),
      'type'=>array('type'=>'hidden','value'=>'0'),
    );
    $this->rules=array(
      'proCode'=>'required repeat',
      'proName'=>'required',
      // 'zhonglei'=>'required',
      // 'color'=>'required',
    );
  }

  function actionRight() {
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      "kindSha"=>"",
      'key' => '',
    ));
     $str = "select * from jichu_product where 1 and type=0";
    if ($arr['key']!='') $str .= " and (proCode like '%{$arr['key']}%'
                        or proName like '%{$arr['key']}%'
                        or guige like '%{$arr['key']}%')";
    $arr['kindSha'] && $str.= " and kind='{$arr['kindSha']}'";
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
      // "zhonglei" =>"成分",
      "proName" =>"纱支",
      "guige" =>"规格",
      "color" => "颜色"
    );
    $smarty->assign('arr_field_info',$arr_field_info);
    $smarty->assign('arr_field_value',$rowset);
    $smarty->assign('arr_condition',$arr);
    $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('thickbox')));
    $smarty->assign('arr_condition',$arr);
    $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
    $smarty-> display('TblList.tpl');
  }

  //**************************弹出原料信息 begin***************************
  function actionPopup2(){
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      'key' => '',
      "kindSha"=>"",
      'kind'=>'',
    ));
    if($arr['kind']){
      unset($arr['kindSha']);//如果传递过来kind字段，则表示默认了类别，不允许客户通过类别选择种类
    }
    $str = "select * from jichu_product where 1 and type=0";
    
    if ($arr[key]!='') $str .= " and (proCode like '%$arr[key]%'
                        or proName like '%$arr[key]%'
                        or guige like '%$arr[key]%')";
    $arr['kindSha'] && $str.= " and kind='{$arr['kindSha']}'";
    $arr['kind'] && $str.= " and kind='{$arr['kind']}'";
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
      'kind'=>'类别',
      "proCode" =>"产品编码",
      // "zhonglei" =>"成分",
      "proName" =>"纱支",
      "guige" =>"规格",
      // "color" => "颜色"
    );
    
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
    $this->_setOptionsForCombox($this->fldMain);
    $smarty = & $this->_getView();
    $smarty->assign('fldMain',$this->fldMain);
    $smarty->assign('title','原料信息编辑');
    $smarty->assign('rules',$this->rules);
    $smarty->assign('sonTpl',"Jichu/proSonTpl.tpl");
    $smarty->display('Main/A1.tpl');
  }

  function actionEdit() {
    $this->_setOptionsForCombox($this->fldMain);
    $row = $this->_modelExample->find(array('id'=>$_GET['id']));
    $this->fldMain = $this->getValueFromRow($this->fldMain,$row);
    $this->fldMain['color']['text']=$row['color'];
    // dump($row);dump($this->fldMain);exit;
    $smarty = & $this->_getView();
    $smarty->assign('fldMain',$this->fldMain);
    $smarty->assign('title','原料信息编辑');
    $smarty->assign('aRow',$row);
    $smarty->assign('rules',$this->rules);
    $smarty->assign('sonTpl',"Jichu/proSonTpl.tpl");
    $smarty->display('Main/A1.tpl');
  }

  /**
   * 显示自动控件需要显示的值
   * Time：2014/06/16 17:11:07
   * @author li
   * @param fldMain array 引参，直接修改传递过来的数组信息
  */
  function _setOptionsForCombox(& $fldMain){
      foreach ($fldMain as $k => & $v) {
        if($v['auto'] && $v['type']=='combobox'){
          $sql = "select {$k} from jichu_product where type=0 group by {$k}";
          $rowset = $this->_modelExample->findBySql($sql);
          // dump($rowset);exit;
          $opt=array();
          foreach($rowset as & $vv) {
            $opt[] = array('text'=>$vv[$k],'value'=>$vv[$k]);
            $v['options']=$opt;
          }
        }
      }
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
      $sql = "select count(*) cnt from jichu_product where proCode='{$_POST['proCode']}' and id<>'{$_POST['id']}'";
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
    // if(!$_POST['guige']) {
    //   js_alert('规格缺失!',null,$this->_url($_POST['fromAction']));
    //   exit;
    // }
    // if(!$_POST['color']) {
    //   js_alert('颜色缺失!',null,$this->_url($_POST['fromAction']));
    //   exit;
    // }
    // dump($_POST);exit;
    $this->_modelExample->save($_POST);

    //处理颜色，需要保存在jichu_color表中
    $colorModel = & FLEA::getSingleton('Model_Jichu_Color');
    $colorModel->saveStr($_POST['color']);
    
    if($_POST['Submit']=='保 存')
      js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url($_POST['fromAction']==''?'add':$_POST['fromAction']));
    else
      js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url('add'));
  }

  //删除功能
  function actionRemove(){
     if($_GET['id']>0){
          $url=$this->_url($_GET['fromAction']==''?'right':$_GET['fromAction']);
          //判断订单中是否使用
          $str="select count(*) as cnt from jichu_product_chengfen where productId='{$_GET['id']}'";
          $temp=$this->_modelExample->findBySql($str);
          if($temp[0]['cnt']>0){
               js_alert('布档案中已使用该产品，禁止删除','',$url);
          }

          //查找计划
          $str="select count(*) as cnt from shengchan_plan2product_touliao where productId='{$_GET['id']}'";
          $temp=$this->_modelExample->findBySql($str);
          if($temp[0]['cnt']>0){
               js_alert('生产投料计划已使用该产品，禁止删除','',$url);
          }

          //查找入库
          $str="select count(*) as cnt from cangku_ruku_son where productId='{$_GET['id']}'";
          $temp=$this->_modelExample->findBySql($str);
          if($temp[0]['cnt']>0){
               js_alert('仓库已使用该产品，禁止删除','',$url);
          }
     }

     parent::actionRemove();
  }

  /**
   * 颜色设置
   * Time：2014/07/01 15:05:11
   * @author li
  */
  function actionSetColor(){
    // dump($_REQUEST);exit;
    $qitaSon = array(
      '_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
      'color' => array('type' => 'bttext', "title" => '颜色', 'name' => 'color[]'),
    );

    // $row4sSon=explode($_GET['color']);

    while (count($row4sSon)<5) {
      $row4sSon[]=array();
    }

    $smarty = & $this->_getView();
    $smarty->assign('title','原料信息编辑');
    $smarty->assign('qitaSon',$qitaSon);
    $smarty->assign('row4sSon',$row4sSon);
    $sonTpl=array("Other/sonTpl.tpl","Trade/ColorAuutoCompleteJs.1.1.tpl");
    $smarty->assign('sonTpl',$sonTpl);
    $smarty->display('Other/Other.tpl');
  }

  /**
   * 获取产品对应的颜色，生成字符串后返回
   * Time：2014/07/03 17:13:45
   * @author li
   * @param $_GET
   * @return json
  */
  function actionGetColorByAjax(){
    $id=(int)$_GET['productId'];
    if(!$id){
      $str = '参数有误';
      $success=false;
    }else{
      $res = $this->_modelExample->find($id);
      $color = explode(',',$res['color']);
      //数组整理
      foreach($color as & $v){
        $v="<li v='{$v}'><a>{$v}</a></li>";
      }

      //生成字符串
      $str = join('',$color);
      $success=true;
    }

    
    echo json_encode(array('comboboxHtml'=>$str,'success'=>$success));exit;
  }

  /**
   * 如：登记订单的时候，如果客户输入的颜色在基础档案中没有，需要添加到基础档案中
   * Time：2014/07/10 16:17:34
   * @author li
  */
  function actionSaveColorByAjax(){
    $res=$this->_modelExample->find($_GET['productId']);
    $color=explode(',',$res['color']);
    $_GET['color']=trim($_GET['color']);
    if(!empty($_GET['color']) && !in_array($_GET['color'], $color)){
      $arr=array(
        'id'=>$res['id'],
        'color'=>$res['color'].','.$_GET['color']
      );
      $this->_modelExample->update($arr);

      //处理颜色，需要保存在jichu_color表中
      $colorModel = & FLEA::getSingleton('Model_Jichu_Color');
      $colorModel->saveStr($_POST['color']);
    }
    echo array('msg'=>'over');
  }


  /**
   * 支持显示库存：选择产品的时候可以选择库存信息
   * Time：2014/08/11 10:49:19
   * @author li
  */
  function actionPopup(){
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      'key' => '',
      "kindSha"=>"",
      'kind'=>'',
    ));
    if($arr['kind']){
      unset($arr['kindSha']);//如果传递过来kind字段，则表示默认了类别，不允许客户通过类别选择种类
    }
    $str = "select * from jichu_product where 1 and type=0";
    
    if ($arr[key]!='') $str .= " and (proCode like '%$arr[key]%'
                        or proName like '%$arr[key]%'
                        or guige like '%$arr[key]%')";
    $arr['kindSha'] && $str.= " and kind='{$arr['kindSha']}'";
    $arr['kind'] && $str.= " and kind='{$arr['kind']}'";
    $str .=" order by proCode asc,proName asc,guige asc";
    $pager =& new TMIS_Pager($str);
    $rowset =$pager->findAll($str);

    foreach($rowset as & $v){
      //查找库存信息
      $sql="select sum(cnt) as cnt,sum(cntJian) as cntJian from cangku_kucun where type='纱' and (rukuId>0 or (chukuId>0 and isCheck=1)) and productId='{$v['id']}'";
      $res=$this->_modelExample->findBySql($sql);
      $v['cntKucun']=$res[0]['cnt']==0?'':round($res[0]['cnt'],2);
      $v['cntJian']=$res[0]['cntJian'];

      $v['color']='';
    }
    $smarty = & $this->_getView();
    $smarty->assign('title', '选择产品');
    $arr_field_info = array(
      'kind'=>'类别',
      "proCode" =>"产品编码",
      // "zhonglei" =>"成分",
      "proName" =>"纱支",
      "guige" =>"规格",
      "cntKucun" => "库存",
      "cntJian" => "件数"
    );
    
    $smarty->assign('arr_field_info',$arr_field_info);
    $smarty->assign('arr_field_value',$rowset);
    $smarty->assign('add_display','none');
    $smarty->assign('arr_condition',$arr);
    $smarty->assign('page_info',$pager->getNavBar($this->_url('Popup',$arr)));
    $smarty-> display('Popup/CommonNew.tpl');
   }

   /**
    * 库存显示信息
    * Time：2014/08/11 11:20:17
    * @author li
   */
   function actionPopupReport(){
      unset($_GET['controller']);
      unset($_GET['action']);
      redirect(url('Shengchan_Cangku_Llck','PopupReport',$_GET));
   }
}
?>