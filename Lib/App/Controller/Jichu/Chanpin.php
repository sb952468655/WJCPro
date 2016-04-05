<?php
FLEA::loadClass('Controller_Jichu_Product');
class Controller_Jichu_Chanpin extends Controller_Jichu_Product{
  var $_modelExample;
  var $fldMain;

  ///构造函数
  function __construct() {
    $this->_modelExample = & FLEA::getSingleton('Model_Jichu_Product');
    $this->_subModel = &FLEA::getSingleton('Model_Jichu_ProductSon');
    $this->_gongxu = &FLEA::getSingleton('Model_Jichu_gongxu');

    $this->fldMain = array(
      'kind'=>array('title'=>'分类',"type"=>"combobox",'value'=>'','options'=>array(),'auto'=>true),
      'proCode'=>array('title'=>'成布编码',"type"=>"text",'value'=>$this->_autoCode('B',date('ym'),'jichu_product','proCode'),'name'=>'proCode2'),
      // 'zhujiCode'=>array('title'=>'助记码','type'=>'text','value'=>''),
      'pinzhong'=>array('title'=>'成布品种','type'=>'text','value'=>''),
      'guige'=>array('title'=>'成布规格','type'=>'text','value'=>'','name'=>'guige2'),
      'menfu'=>array('title'=>'参考门幅','type'=>'text','value'=>'','name'=>'menfu','addonEnd'=>'M'),
      'kezhong'=>array('title'=>'参考克重','type'=>'text','value'=>'','name'=>'kezhong','addonEnd'=>'g/m<sup>2</sup>'),
      'viewPer'=>array('title'=>'成分比列','type'=>'text','value'=>''),
      'jixing'=>array('title'=>'机型','type'=>'text','value'=>''),
      'color'=>array('title'=>'颜色','type'=>'popupEdit','url'=>url($_GET['controller'],'SetColor'),'textFld'=>'color','hiddenFld'=>'color'),
      'memo'=>array('title'=>'备注说明','type'=>'textarea','value'=>''),
      'id'=>array('type'=>'hidden','value'=>'','name'=>'proId'),
      'type'=>array('type'=>'hidden','value'=>'1'),
      //'kind'=>array('value'=>''),
    );

    $this->headSon = array(
      '_edit'=>array('type'=>'btBtnRemove',"title"=>'+5行','name'=>'_edit[]'),
      'productId' => array(
              'title' => '选择纱支',
              "type" => "btPopup",
              'name' => 'productId[]',
              'url'=>url('jichu_product','popup'),
              'textFld'=>'kind',
              'hiddenFld'=>'id',
              'inTable'=>true,
          ),
      'proName'=>array('type'=>'bttext',"title"=>'纱支','name'=>'proName[]','readonly'=>true),
      //用于计算，原来称成分比例，后来客户提出为纱支比例，用于计算
      'chengfenPer'=>array('type'=>'bttext',"title"=>'纱支比列(%)','name'=>'chengfenPer[]'),
      'xianchang'=>array('type'=>'bttext',"title"=>'线长','name'=>'xianchang[]'),
      'memoView'=>array('type'=>'bttext',"title"=>'备注','name'=>'memoView[]'),
      //***************如何处理hidden?
      'id'=>array('type'=>'bthidden','name'=>'id[]'),
    );

    $this->qitaSon = array(
      '_edit' => array('type' => 'btCheckbox', "title" => '选择', 'name' => 'sel[]'),
      'gongxuName' => array('type' => 'bttext', "title" => '工序', 'name' => 'gongxuName[]','readonly'=>true),
      'qtmemo'=>array('type'=>'bttext',"title"=>'备注','name'=>'qtmemo[]'),
      'id'=>array('type'=>'bthidden','name'=>'qtid[]'),
    );

    $this->rules=array(
      'kind'=>'required',
      'proCode2'=>'required',
      'pinzhong'=>'required',
      'guige2'=>'required',
      // 'color2'=>'required',
    );
  }


  function actionRight() {
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      "kindBu"=>"",
      'key' => '',
      'shazhi' => '',
    ));
    if($arr['shazhi']!=''){
      $sql="select x.proId from jichu_product_chengfen x
      left join jichu_product y on x.productId=y.id
      where 1 and (y.proName like '%{$arr['shazhi']}%' or y.proCode like '%{$arr['shazhi']}%')";
      $temp = $this->_modelExample->findBySql($sql);
      $proId = join(',',array_col_values($temp,'proId'));
      if($proId!='')$where =  " and id in ({$proId})";
      else $where = ' and 0';
    }
    $str = "select * from jichu_product where 1 and type=1";
    if ($arr['key']!='') $str .= " and (proCode like '%{$arr['key']}%'
                        or proName like '%{$arr['key']}%'
                        or guige like '%{$arr['key']}%'
                        or pinzhong like '%{$arr['key']}%'
                        )";
    $arr['kindBu'] && $str.= " and kind='{$arr['kindBu']}'";
    $str.=$where;
    $str .=" order by proCode desc,proName asc,guige asc";
    $pager =& new TMIS_Pager($str);
    $rowset =$pager->findAllBySql($str);
    //$pageInfo = $pager->getNavBar('Index.php?'.$pager->getParamStr($arr));
    if(count($rowset)>0) foreach($rowset as & $v){
      $v['_edit'] = $this->getEditHtml($v['id']) . ' ' . $this->getRemoveHtml($v['id']);

      //添加复制按钮：用于快速新增新的产品信息
      $v['_edit'] .="&nbsp;<a href='".$this->_url('Edit',array(
              'copy'=>1,
              'id'=>$v['id']
            ))."'>复制</a>";

      //查看成分信息
      $sql="select y.proName,x.chengfenPer from jichu_product_chengfen x
        left join jichu_product y on x.productId=y.id
        where proId='{$v['id']}'";
      $temp = $this->_subModel->findBySql($sql);
      $v['proName']=join('/',array_col_values($temp,'proName'));
      foreach ($temp as $key => & $value) {
        $value['chengfenPer']=round($value['chengfenPer'],2);
      }
      $v['chengfenPer']=join('/',array_col_values($temp,'chengfenPer'));
    }
    $smarty = & $this->_getView();
    $smarty->assign('title', '选择产品');
    $pk = $this->_modelExample->primaryKey;
    $smarty->assign('pk', $pk);
    $arr_field_info = array(
      "_edit"=>'操作',
      "kind"=>'类别',
      // "zhujiCode"=>'助记码',
      "proCode" =>"成布编码",
      "pinzhong" =>"成布品种",
      "guige" =>"成布规格",
      "color" => "颜色",
      "proName" => array('text'=>"纱支",'width'=>150),
      "chengfenPer" => "纱支比例",
      "viewPer" => array('text'=>"成分比例",'width'=>150),
      "menfu" => "门幅(M)",
      "kezhong" => "克重(g/m<sup>2</sup>)",
      "jixing" => "机型",
      "memo" =>"说明"
    );
    $smarty->assign('arr_field_info',$arr_field_info);
    $smarty->assign('arr_field_value',$rowset);
    $smarty->assign('arr_condition',$arr);
    $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
    $smarty-> display('TblList.tpl');
  }

  function actionAdd() {
    // $this->authCheck('3-1');
    $this->_setOptionsForCombox($this->fldMain);
    // 从表区域信息描述
    $smarty = &$this->_getView();
    $areaMain = array('title' => '成布基本信息', 'fld' => $this->fldMain);
    $smarty->assign('areaMain', $areaMain);
    // 从表信息字段,默认5行
    for($i = 0;$i < 5;$i++) {
      $rowsSon[] = array();
    }
    $qitaSon = $this->qitaSon;
    //查找工序信息
    $gx = $this->_gongxu->findAll();
    // dump($gx);exit;
    $row4sSon=array();
    foreach($gx as $k => & $v){
      $row4sSon[]=array(
        'gongxuName'=>array('value'=>$v['itemName']),
        '_edit'=>array('value'=>$k),
      );
    }

    $smarty->assign('headSon', $this->headSon);
    $smarty->assign('rowsSon', $rowsSon);
    $smarty->assign('rules', $this->rules);
    $smarty->assign('qitaSon',$qitaSon);
    $smarty->assign('row4sSon',$row4sSon);
    $smarty->assign('sonTpl',"Jichu/proSonTpl.tpl");
    $smarty->assign("otherInfoTpl",'Jichu/otherInfoTpl.tpl');
    $smarty->display('Main2Son/T1.tpl');
  }

  function actionEdit() {
    // $this->authCheck('3-1');
    $this->_setOptionsForCombox($this->fldMain);
    $arr = $this->_modelExample->find(array('id' => $_GET['id']));
    $arr = $this->_modelExample->find(array('id' => $_GET['id']));

    //如果copy=1为true，表示为复制，所有的id需要制空
    if($_GET['copy']==1){
      $arr['id']='';
      //清空成分比列的id与主表，子表对应的外键id
      $this->array_values_empty($arr['Products'],array('id','proId'));
      //清空工序的id与主表，子表对应的外键id
      $this->array_values_empty($arr['Gongxus'],array('id','proId'));
      //重新填充编码信息
      $arr['proCode'] = $this->_autoCode('B',date('ym'),'jichu_product','proCode');
    }

    // dump($arr);exit;
    foreach ($this->fldMain as $k => &$v) {
      $v['value'] = $arr[$k]?$arr[$k]:$v['value'];
    }

    $this->fldMain['color']['text']=$arr['color'];

    // //加载库位信息的值
    $areaMain = array('title' => '成布基本信息', 'fld' => $this->fldMain);

    // 入库明细处理
    $rowsSon = array();
    foreach($arr['Products'] as &$v) {
      $sql = "select * from jichu_product where id='{$v['productId']}'";
      $_temp = $this->_modelExample->findBySql($sql); //dump($_temp);exit;
      $v['proCode'] = $_temp[0]['proCode'];
      $v['zhonglei'] = $_temp[0]['zhonglei'];
      $v['proName'] = $_temp[0]['proName'];
      $v['guige'] = $_temp[0]['guige'];
      $v['color'] = $_temp[0]['color'];

      $v['chengfenPer']=round($v['chengfenPer'],1);
      $v['viewPer']=round($v['viewPer'],1);
    }

    //排序
    // $arr['Products'] = array_column_sort($arr['Products'],'id');
    foreach($arr['Products'] as &$v) {
      $temp = array();
      foreach($this->headSon as $kk => &$vv) {
        $temp[$kk] = array('value' => $v[$kk]);
      }
      $rowsSon[] = $temp;
    }

    //显示纱支的类别信息
    foreach ($rowsSon as $key => & $v) {
      $sql="select * from jichu_product where id='{$v['productId']['value']}'";
      $_temp = $this->_modelExample->findBySql($sql);
      $v['productId']['text'] = $_temp[0]['kind'];
    }
    // dump($rowsSon);exit;
    //补齐5行
    $cnt = count($rowsSon);
    for($i=5;$i>$cnt;$i--) {
      $rowsSon[] = array();
    }
    // dump($areaMain);exit;
    $qitaSon = $this->qitaSon;
    //查找工序信息
    $gx = $this->_gongxu->findAll();
    $row4sSon=array();
    foreach($gx as $k => & $v){
      $temp=array(
        'gongxuName'=>array('value'=>$v['itemName']),
        '_edit'=>array('value'=>$k),
      );
      //如果已设置工序，显示已设置的信息
      // dump($v);exit;
      foreach ($arr['Gongxus'] as $key => & $vv) {
        if($vv['gongxuName']==$v['itemName']){
          $temp['_edit']['checked'] = true;
          $temp['qtmemo']['value'] = $vv['qtmemo'];
          $temp['id']['value'] = $vv['id'];
        }
      }
      // dump($temp);
      $row4sSon[]=$temp;
    }
    // dump($row4sSon);exit;

    $smarty = &$this->_getView();
    $smarty->assign('areaMain', $areaMain);
    $smarty->assign('headSon', $this->headSon);
    $smarty->assign('rowsSon', $rowsSon);
    $smarty->assign('fromAction', $_GET['fromAction']);
    $smarty->assign('rules', $this->rules);
    $smarty->assign('qitaSon',$qitaSon);
    $smarty->assign('row4sSon',$row4sSon);
    $smarty->assign('sonTpl',"Jichu/proSonTpl.tpl");
    $smarty->assign("otherInfoTpl",'Jichu/otherInfoTpl.tpl');
    $smarty->display('Main2Son/T1.tpl');
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
          $sql = "select {$k} from jichu_product where type=1 group by {$k}";
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

  function actionSave(){
    // dump($_POST);exit;
    //有效性验证,没有明细信息禁止保存
    //查找编码是否重复
    $sql="select count(*) as cnt from jichu_product where proCode='{$_POST['proCode2']}'";
    $_POST['proId']>0 && $sql.="  and id<>'{$_POST['proId']}'";
    $temp = $this->_modelExample->findBySql($sql);
    // dump($sql);exit;
    if($temp[0]['cnt']>0){
      js_alert('成布编码不能重复','window.history.go(-1)');
      exit;
    }

    $sql="select count(*) as cnt from jichu_product where pinzhong='{$_POST['pinzhong']}'";
    $_POST['proId']>0 && $sql.="  and id<>'{$_POST['proId']}'";
    $temp = $this->_modelExample->findBySql($sql);
    // dump($sql);exit;
    if($temp[0]['cnt']>0){
      js_alert('成布品种不能重复','window.history.go(-1)');
      exit;
    }

    //开始保存
    //成分比例信息
    $pros = array();
    foreach($_POST['productId'] as $key=>&$v) {
      if($v=='') continue;
      $temp = array();
      foreach($this->headSon as $k=>&$vv) {
        $temp[$k] = $_POST[$k][$key];
      }
      $pros[]=$temp;
    }

     //工序信息
    $gongxus = array();
    foreach($_POST['sel'] as & $v) {
      if($v=='') continue;
      $temp = array();
      foreach($this->qitaSon as $k=>&$vv) {
        $temp[$k] = $_POST[$k][$v];
      }
      $temp['id'] = $_POST['qtid'][$v];
      $gongxus[]=$temp;
    }

    //主信息
    $row = array();
    foreach($this->fldMain as $k=>&$vv) {
      $name = $vv['name']?$vv['name']:$k;
      $row[$k] = $_POST[$name];
    }

    $row['Products'] = $pros;
    $row['Gongxus'] = $gongxus;
    //删除之外的工序明细
    $ids= join(',',array_filter(array_col_values($gongxus,'id')));
    if($_POST['proId']>0) {
      $sql = "delete from jichu_product_gongxu
      where proId={$_POST['proId']} ";
      $ids!='' && $sql.=" and id not in({$ids})";
      // dump($sql);exit;
      $r = $this->_subModel->execute($sql);
      if(!$r) {
        js_alert('删除之外的工序明细失败!',null,null);
        exit;
      }
    }

    // dump($row);exit;
    if(!$this->_modelExample->save($row)) {
      js_alert('保存失败','window.history.go(-1)');
      exit;
    }

    //处理颜色，需要保存在jichu_color表中
   $colorModel = & FLEA::getSingleton('Model_Jichu_Color');
   $colorModel->saveStr($_POST['color']);

    //跳转
    js_alert(null,'window.parent.showMsg("保存成功!")',url($_POST['fromController'],$_POST['fromAction'],array()));
    exit;
  }

  function actionPopup(){
    FLEA::loadClass('TMIS_Pager');
    $arr = TMIS_Pager::getParamArray(array(
      'key' => '',
      "kindBu"=>"",
      'kind'=>'',
      'type'=>'',
    ));
     $str = "select * from jichu_product where 1 and type=1";
    if ($arr['key']!='') $str .= " and (proCode like '%{$arr['key']}%'
                        or pinzhong like '%$arr[key]%'
                        or guige like '%$arr[key]%')";
    $arr['kindBu'] && $str.= " and kind='{$arr['kindBu']}'";
    $arr['kind'] && $str.= " and kind='{$arr['kind']}'";
    $str .=" order by proCode asc,proName asc,guige asc";
    $pager =& new TMIS_Pager($str);
    $rowset =$pager->findAllBySql($str);
    foreach ($rowset as $key => & $v) {
      //查找库存信息
      $sql="select sum(cnt) as cnt,sum(cntJian) as cntJian from cangku_kucun where type='{$arr['type']}' and (rukuId>0 or (chukuId>0 and isCheck=1)) and productId='{$v['id']}'";
      $res=$this->_modelExample->findBySql($sql);
      $v['cntKucun']=$res[0]['cnt']==0?'':round($res[0]['cnt'],2);
      $v['cntJian']=$res[0]['cntJian'];

      $v['color']='';

      //查看成分信息
      // $sql="select y.zhonglei,x.chengfenPer from jichu_product_chengfen x
      //   left join jichu_product y on x.productId=y.id
      //   where proId='{$v['id']}'";
      // $temp = $this->_subModel->findBySql($sql);
      // $v['zhonglei']=join('/',array_col_values($temp,'zhonglei'));
      // foreach ($temp as $key => & $value) {
      //   $value['chengfenPer']=round($value['chengfenPer'],2);
      // }
      // $v['chengfenPer']=join('/',array_col_values($temp,'chengfenPer'));
    }
    $smarty = & $this->_getView();
    $smarty->assign('title', '选择产品');
    $pk = $this->_modelExample->primaryKey;
    $smarty->assign('pk', $pk);
    $arr_field_info = array(
      'kind'=>'类别',
      "proCode" =>"成布编码",
      "pinzhong" =>"品种",
      "guige" =>"规格",
      // "color" => "颜色",
      // "zhonglei" => "成分",
      // "chengfenPer" => "成分比例",
      "menfu" => "门幅(M)",
      "kezhong" => "克重(g/m<sup>2</sup>)",
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
   * 显示
   * @author li 2014-5-30
   */
   function actionViewPer(){
      if(empty($_GET['productId'])){
        echo '访问失败，没有相关产品信息';exit;
      }
      $cnt=$_GET['cnt']+0;
      //查询产品，获取其对应的成分与成分比例
      $perInfo = $this->_modelExample->find($_GET['productId']);
      //成分信息
      $chengfen = explode('/',$perInfo['zhonglei']);
      //成分比例
      $chengfenPer = explode('/',$perInfo['chengfenPer']);
      $sumPer = array_sum($chengfenPer);
      // dump($chengfen);exit;
      $rowset=array();
      //计算各个成分的相关数量
      foreach($chengfen as $key => & $v){
        $rowset[]=array(
          'chengfen'=>$v,
          'chengfenPer'=>$chengfenPer[$key],
          'cnt'=>$chengfenPer[$key]/$sumPer*$cnt
        );
      }
      $rowset[]=$this->getHeji($rowset,array('cnt','chengfenPer'),'chengfen');

      $arrFieldInfo=array(
        'chengfen'=>'成分',
        'chengfenPer'=>'成分比例',
        'cnt'=>'数量',
      );
      // dump($rowset);exit;
      $smarty= & $this->_getView();
      $smarty->assign('title', '成分比例查询');
      $smarty->assign('arr_field_info', $arrFieldInfo);
      $smarty->assign('add_display', 'none');
      $smarty->assign('arr_condition', $arr);
      $smarty->assign('arr_field_value', $rowset);
      $smarty->display('TblList.tpl');
   }

   function actionRemoveByAjax(){
      $m = & FLEA::getSingleton('Model_Jichu_ProductSon');
      $r = $m->removeByPkv($_POST['id']);
      if(!$r) {
        $arr = array('success'=>false,'msg'=>'删除失败');
        echo json_encode($arr);
        exit;
      }
      $arr = array('success'=>true);
      echo json_encode($arr);
      exit;
   }

   function actionRemove(){
      //查找订单信息
      $sql="select count(*) as cnt from trade_order2product where productId='{$_GET['id']}'";
      $rest = $this->_modelExample->findBySql($sql);
      if($rest[0]['cnt']>0){
        js_alert('订单中已使用该产品信息，禁止删除','',$this->_url('right'));
        exit;
      }

      parent::actionRemove();
   }


   /**
    * 库存显示信息
    * Time：2014/08/11 11:20:17
    * @author li
   */
   //写跳转的目的是想统一管理弹出连接地址(解决问题：如果把地址写在每个控件的里面，以后修改的时候需要对每个控件中的地址都修改。)
   function actionPopupZhizao(){
      unset($_GET['controller']);
      unset($_GET['action']);
      // dump($_GET);exit;
      redirect(url('Shengchan_Zhizao_Llck','PopupReport',$_GET));
   }

   function actionPopupRanbu(){
      unset($_GET['controller']);
      unset($_GET['action']);
      // dump($_GET);exit;
      redirect(url('Shengchan_Ranbu_Llck','PopupReport',$_GET));
   }

   function actionPopupHzl(){
      unset($_GET['controller']);
      unset($_GET['action']);
      // dump($_GET);exit;
      redirect(url('Shengchan_Hzl_Llck','PopupReport',$_GET));
   }

}
?>