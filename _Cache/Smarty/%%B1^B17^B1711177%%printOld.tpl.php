<?php /* Smarty version 2.6.10, created on 2014-11-04 13:24:39
         compiled from printOld.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'printOld.tpl', 55, false),array('modifier', 'default', 'printOld.tpl', 72, false),array('modifier', 'is_string', 'printOld.tpl', 75, false),array('modifier', 'explode', 'printOld.tpl', 85, false),array('function', 'math', 'printOld.tpl', 58, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php echo '
<style type="text/css">
<!--
.style1 {
	font-size: 14pt;
	font-weight: bold;
}
body {
	margin-left: 0px;
	margin-top: 0px;
}
td {FONT-FAMILY:"宋体,Arial";FONT-SIZE:14px;COLOR:#000;}
.title {FONT-SIZE: 12pt}

#tr {height:30px;}
-->
</style>
<script language="javascript">
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
</script>
'; ?>

<link href="Resource/Css/Print.css" rel="stylesheet" type="text/css" />
</head>
	
<body style="text-align:center" onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<?php if ($this->_tpl_vars['sonTpl']):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sonTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
<div style=" margin-bottom:5px;"><font style="font-weight:bold; font-size:24px; border-bottom:1px double #000;"><?php echo $this->_tpl_vars['title']; ?>
</font></div>
<?php if ($this->_tpl_vars['arr_main_value']): ?>
<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr id="tr">  
  	<?php $this->assign('i', 0); ?>
    <?php $this->assign('index', 0); ?>
    <?php $this->assign('countMain', count($this->_tpl_vars['arr_main_value'])); ?>
    <?php $_from = $this->_tpl_vars['arr_main_value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> 
    <td align="left"><?php echo $this->_tpl_vars['key']; ?>
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

<table id="dataList" width="98%" style="BORDER-COLLAPSE: collapse;" bordercolor="#000000" border="2" align="center" cellpadding="2" cellspacing="0">
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
    
 <?php $_from = $this->_tpl_vars['arr_field_value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_value']):
?>    
  <tr id="tr">	  	
	<?php $_from = $this->_tpl_vars['arr_field_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>  
    	<?php if ($this->_tpl_vars['key'] != '_edit'): ?>  		
			<?php $this->assign('foo', ((is_array($_tmp=".")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['key']) : explode($_tmp, $this->_tpl_vars['key']))); ?>
            <?php $this->assign('key1', $this->_tpl_vars['foo']['0']); ?>
            <?php $this->assign('key2', $this->_tpl_vars['foo']['1']); ?>
            <?php $this->assign('key3', $this->_tpl_vars['foo']['2']); ?>	                 
            <td>
                <?php if ($this->_tpl_vars['key2'] == ''):  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

                <?php elseif ($this->_tpl_vars['key3'] == ''):  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key1']][$this->_tpl_vars['key2']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

                <?php else:  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key1']][$this->_tpl_vars['key2']][$this->_tpl_vars['key3']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;'));  endif; ?>
            </td>	
         <?php endif; ?>
	<?php endforeach; endif; unset($_from); ?>    	
  </tr>
  <?php endforeach; endif; unset($_from); ?>
</table>
<div id="prn" align="center">
<input type="button" id="button1" name="button1" value="打印" onclick="prnbutt_onclick()" />
</div>
</body>
</html>