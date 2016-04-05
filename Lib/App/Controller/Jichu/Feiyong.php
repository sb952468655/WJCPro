<?php
FLEA::loadClass('TMIS_Controller');
class Controller_Jichu_Feiyong extends Tmis_Controller {
	var $_modelExample;
	var $title = "费用类别定义模块";
	//var $funcId = 161;
	var $_tplEdit='Jichu/FeiyongEdit.tpl';
	function Controller_Jichu_Feiyong() {
	//if(!//$this->authCheck()) die("禁止访问!");
		$this->_modelExample = & FLEA::getSingleton('Model_Jichu_Feiyong');
	}
	 function actionRight() {
    //dump($_GET['kind']);exit;
        $title = '费用类别定义列表';
        ///////////////////////////////模板文件
        $tpl = 'TableList.tpl';
        ///////////////////////////////表头
        $arr_field_info = array(
			'_edit'=>'操作',
            "feiyongName" =>"费用名称"
        );

        ///////////////////////////////模块定义
        $this->authCheck('8-3-7');
        FLEA::loadClass('TMIS_Pager');
        $arr = TMIS_Pager::getParamArray(array(
            'key'=>''
        ));
        $condition=array();
        if($arr['key']!='') {
            $condition[] = array('feiyongName',"%{$arr['key']}%",'like');
          
        }
	//	dump($arr_field_info);exit;
        $pager =& new TMIS_Pager($this->_modelExample,$condition);
        $rowset =$pager->findAll();
        if(count($rowset)>0) foreach($rowset as & $v) {
            ///////////////////////////////
            //$this->makeEditable($v,'memoCode');
                $v['_edit'] = $this->getEditHtml($v['id']) . '&nbsp;&nbsp;' . $this->getRemoveHtml($v['id']);
            }
        $smarty = & $this->_getView();
        $smarty->assign('title', $title);
        $smarty->assign('arr_field_info',$arr_field_info);
        $smarty->assign('arr_field_value',$rowset);
        $smarty->assign('arr_condition', $arr);

		/*///////////////grid,thickbox,///////////////*/
        $smarty->assign('arr_js_css',$this->makeArrayJsCss(array('calendar')));
        $smarty->assign('page_info',$pager->getNavBar($this->_url($_GET['action'],$arr)));
        $smarty->display($tpl);
    }

	function actionSave() {
		if(empty($_POST['id'])) {
			$sql = "SELECT count(*) as cnt FROM `jichu_feiyong` where feiyongName='".$_POST['feiyongName']."'";
			$rr = $this->_modelExample->findBySql($sql);
			//dump($rr);exit;
			if($rr[0]['cnt']>0) {
				js_alert('费用名称重复!',null,$this->_url('add'));
			}
		} else {
		//修改时判断是否重复
			$str1="SELECT count(*) as cnt FROM `jichu_feiyong` where id!=".$_POST['id']." and (feiyongName='".$_POST['feiyongName']."')";
			$ret=$this->_modelExample->findBySql($str1);
			if($ret[0]['cnt']>0) {
				js_alert('费用名称重复!',null,$this->_url('Edit',array('id'=>$_POST['id'])));
			}
		}
		$id = $this->_modelExample->save($_POST);
		if($_POST['id']=='')
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url('add'));
		else
			js_alert(null,"window.parent.showMsg('保存成功!')",$this->_url('right'));
	}

	function actionRemove() {
		if($_GET['id']!="") {

			$sql="SELECT count(*) as cnt FROM `caiwu_xianjin` where itemId =".$_GET['id'];
			//dump($sql);exit;
			$re=$this->_modelExample->findBySql($sql);
			//dump($re);exit;
			if($re[0]['cnt']>0) {
				js_alert('此费用已有记录，禁止删除！',null,$this->_url('right'));
			}
		}
		parent::actionRemove();
	}


}
?>