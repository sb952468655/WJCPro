<?php /* Smarty version 2.6.10, created on 2014-11-05 20:12:34
         compiled from Print.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Print.tpl', 6, false),array('function', 'math', 'Print.tpl', 93, false),array('modifier', 'count', 'Print.tpl', 16, false),array('modifier', 'json_encode', 'Print.tpl', 57, false),array('modifier', 'default', 'Print.tpl', 92, false),array('modifier', 'is_string', 'Print.tpl', 145, false),array('modifier', 'explode', 'Print.tpl', 155, false),array('modifier', 'date_format', 'Print.tpl', 184, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%22^228^2282AE22%%Print.tpl.inc'] = 'cbc1b88ea1bac01d23c2179a187a0403'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cbc1b88ea1bac01d23c2179a187a0403#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Print/LodopFuncs.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cbc1b88ea1bac01d23c2179a187a0403#0}';}?>

<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="install_lodop.exe"></embed>
<param name="CompanyName" value="常州易奇信息科技有限公司">
<param name="License" value="664717080837475919278901905623">
</object> 
<?php echo '
<script language="javascript" type="text/javascript"> 
//(Top,Left,Width,Height,strHtml)
//in(英寸)、cm(厘米) 、mm(毫米) 、pt(磅)、px(1/96英寸) 、%(百分比)，如"10mm"表示10毫米。
	var cnt=';  echo count($this->_tpl_vars['arr_main_value']);  echo ';
	var height=Math.ceil(cnt/3)*5;
	if(height==0)height=22;
	else height+=22;
	var LODOP; //声明为全局变量
	function PrintTable(){
		//加载打印控件
		LODOP=getLodop(document.getElementById(\'LODOP_OB\'),document.getElementById(\'LODOP_EM\'));  
		//LODOP.SET_PRINT_PAGESIZE(0,\'203mm\',\'290mm\',\'A4\')
		LODOP.PRINT_INIT("易奇科技报表打印");
		LODOP.ADD_PRINT_HTM(10,5,"99%",400,document.getElementById("compName").innerHTML);
		LODOP.SET_PRINT_STYLEA(0,"ItemType",1);
		//0--普通项 1--页眉页脚 2--页号项 3--页数项 4--多页项
		LODOP.ADD_PRINT_TABLE(height+\'mm\',5,"99%",(280-height)+\'mm\',document.getElementById("main").innerHTML);
		LODOP.ADD_PRINT_TABLE(5,0,"99%",100,document.getElementById("div3").innerHTML);
		LODOP.SET_PRINT_STYLEA(0,"LinkedItem",2);   
		
		
		LODOP.ADD_PRINT_TEXT(3,653,135,20,"第#页/共&页");
		LODOP.SET_PRINT_STYLEA(0,"ItemType",2);
 
		LODOP.PREVIEW();	
	};	
	
	
function prnbutt_onclick() { 
	window.print(); 
	return true; 
} 

function window_onbeforeprint() { 
	prn.style.visibility ="hidden"; 
	return true; 
} 

function window_onafterprint() { 
	prn.style.visibility = "visible"; 
	return true; 
}

function loadPrint(){
		var auto=';  echo json_encode($_GET['auto']);  echo ';
		if(auto==1)document.getElementById(\'button\').click();
}
</script>
'; ?>

</head>
	
<body onload="loadPrint()" style="text-align:center" onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<div id="compName">
<div style="text-align:center;">
<font style="font-weight:bold;font-size:24px;"><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:cbc1b88ea1bac01d23c2179a187a0403#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'GetAppInf','varName' => 'compName'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:cbc1b88ea1bac01d23c2179a187a0403#1}';}?>
</font>
<br>
<font style="font-weight:bold;font-size:19px;border-bottom:2pt double #000000;"><?php echo $this->_tpl_vars['title']; ?>
</font>
</div>
<?php if ($this->_tpl_vars['arr_main_value']): ?>
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:6px; font-size:14px;">
   <tr id="tr">  
  	<?php $this->assign('i', 0); ?>
    <?php $this->assign('index', 0); ?>
    <?php $this->assign('countMain', count($this->_tpl_vars['arr_main_value'])); ?>
    <?php $_from = $this->_tpl_vars['arr_main_value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    
    <?php if ($this->_tpl_vars['countMain'] <= 4 && $this->_tpl_vars['countMain'] > 1): ?>
	    <?php $this->assign('align', 'left'); ?>
	    <?php $this->assign('j', $this->_tpl_vars['j']+1); ?>
	    <?php if ($this->_tpl_vars['j']%3 == 0 || $this->_tpl_vars['j'] == $this->_tpl_vars['countMain'] && $this->_tpl_vars['j'] < 4): ?>
	    <?php $this->assign('align', 'right'); ?>
	    <?php elseif ($this->_tpl_vars['j']%3 == 2): ?>
	    <?php $this->assign('align', 'center'); ?>
	    <?php endif; ?>
    <?php endif; ?>
    <td align="<?php echo ((is_array($_tmp=@$this->_tpl_vars['align'])) ? $this->_run_mod_handler('default', true, $_tmp, 'left') : smarty_modifier_default($_tmp, 'left')); ?>
"><?php echo $this->_tpl_vars['key']; ?>
：<?php echo $this->_tpl_vars['item']; ?>
</td>
    <?php echo smarty_function_math(array('equation' => "(x+1)%3",'x' => $this->_tpl_vars['i'],'assign' => 'i'), $this);?>

    <?php echo smarty_function_math(array('equation' => "x+1",'x' => $this->_tpl_vars['index'],'assign' => 'index'), $this);?>

    <?php if ($this->_tpl_vars['i'] == 0 && $this->_tpl_vars['index'] > 0 && $this->_tpl_vars['index'] < $this->_tpl_vars['countMain']): ?>
    </tr>
    <tr id="tr"> 
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
  </tr>  
</table>
<?php endif; ?>
</div>
<div id="main">
<?php echo '
<style type="text/css">
#dataList{
	border-top:2px solid #000;
	border-bottom:2px solid #000;
	border-left:0px;
	border-right:0px;
	border-collapse:collapse;
	font-size:14px;
}
.ptd{font-weight:bold;}
#hr td{
	border-bottom:1px solid #000;
	white-space:nowrap;
	padding-left:3px;
	padding-right:2px;
	height:25px;
}
#trmain td{
	border-bottom:1px dotted #000;
	padding-left:3px;
	padding-right:2px;
	height:22px;
}
#gz{
	display: none;
}
a,font,span{
	color:#000;
	text-decoration:none;
}
</style>
'; ?>

<table id="dataList" width="98%" align="center" cellpadding="2" cellspacing="0">
<thead>
  	<tr id="hr" style="height:<?php echo ((is_array($_tmp=@$this->_tpl_vars['hr_height'])) ? $this->_run_mod_handler('default', true, $_tmp, '30px') : smarty_modifier_default($_tmp, '30px')); ?>
;"> 	   
		<?php $_from = $this->_tpl_vars['arr_field_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['key'] != '_edit'): ?>  	
	 <td class="ptd"><?php if (is_string($this->_tpl_vars['item']) == 1):  echo $this->_tpl_vars['item'];  else:  echo $this->_tpl_vars['item']['text'];  endif; ?></td>
        <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>        
  </tr>
  </thead>
 <?php $_from = $this->_tpl_vars['arr_field_value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_value']):
?>    
  <tr id="trmain">	  	
	<?php $_from = $this->_tpl_vars['arr_field_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>  
    	<?php if ($this->_tpl_vars['key'] != '_edit'): ?>  		
			<?php $this->assign('foo', ((is_array($_tmp=".")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['key']) : explode($_tmp, $this->_tpl_vars['key']))); ?>
            <?php $this->assign('key1', $this->_tpl_vars['foo']['0']); ?>
            <?php $this->assign('key2', $this->_tpl_vars['foo']['1']); ?>
            <?php $this->assign('key3', $this->_tpl_vars['foo']['2']); ?>	                 
            <td <?php if ($this->_tpl_vars['field_value']['mark'] == 'heji'): ?>class="ptd"<?php endif; ?>>
                <?php if ($this->_tpl_vars['key2'] == ''):  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

                <?php elseif ($this->_tpl_vars['key3'] == ''):  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key1']][$this->_tpl_vars['key2']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

                <?php else:  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key1']][$this->_tpl_vars['key2']][$this->_tpl_vars['key3']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;'));  endif; ?>
            </td>	
         <?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>    	
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
</div>
<div id="div3">
<div style="margin:10px 50px 0 50px; white-space:nowrap;font-size:14px;">
<table border="0px" width="90%">
<tr>
<td align="left" width="33%">制单人：<font style="border-bottom:1px solid #000000;padding-left:15px; padding-right:15px;"><?php echo $_SESSION['REALNAME']; ?>
</font></td>
<td width="33%" align="center">
	<?php if ($this->_tpl_vars['gongzhang'] == '1'): ?>
		<img border="0" transcolor="#FFFFFF"  src="resource/image/gz.gif" style="position: absolute;z-index: -15;margin-top:-20px;margin-left:10px;" id='gz'/>
	<?php endif; ?>
	审核：
	<font style="border-bottom:1px solid #000000;padding-left:15px; padding-right:15px;">
	<?php echo ((is_array($_tmp=@$this->_tpl_vars['aRow']['checkPeople'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;&nbsp;&nbsp;&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;&nbsp;&nbsp;&nbsp;')); ?>

	</font>
</td>
<td width="33%" align="right" style="padding-right:30px;">日期：<font style="border-bottom:1px solid #000000;padding-left:10px; padding-right:10px;"><?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
</font></td>
</tr>
</table>
</div>
</div>
<br />
<div id="prn" align="center">
<input type="button" name="button" id="button" value="打印" onclick="PrintTable()"/>
<?php echo $this->_tpl_vars['other_button']; ?>

</div>
</body>
</html>