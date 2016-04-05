<?php /* Smarty version 2.6.10, created on 2014-11-03 16:21:25
         compiled from Popup/MultSel.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Popup/MultSel.tpl', 12, false),array('modifier', 'json_encode', 'Popup/MultSel.tpl', 94, false),array('modifier', 'escape', 'Popup/MultSel.tpl', 94, false),array('modifier', 'default', 'Popup/MultSel.tpl', 94, false),array('modifier', 'explode', 'Popup/MultSel.tpl', 96, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%7D^7D8^7D8B9465%%MultSel.tpl.inc'] = '24c9cc0de24b171ecb63cbe797866ec2'; ?><html>
<head>

<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:24c9cc0de24b171ecb63cbe797866ec2#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:24c9cc0de24b171ecb63cbe797866ec2#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:24c9cc0de24b171ecb63cbe797866ec2#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:24c9cc0de24b171ecb63cbe797866ec2#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:24c9cc0de24b171ecb63cbe797866ec2#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:24c9cc0de24b171ecb63cbe797866ec2#2}';}?>

<link href="Resource/Css/Main.css" rel="stylesheet" type="text/css">
<link href="Resource/Css/Page.css" rel="stylesheet" type="text/css" >
<?php echo '
<base target="_self" />
<script language="javascript">
var _cache = new Array();
$(function(){
	var he = $(\'#searchGuide\').height() || 0;
	var he1 = $(\'#divPage\').height() || 0;
	//alert(he);
	//alert($(window).height());
	$(\'#TableContainer\').height($(window).height()-he-he1-17);

});
function changeCache(obj,json) {
	if(obj.checked) {
		_cache[obj.value] = json;
	} else delete _cache[obj.value];
	//alert(_cache.length);
}
function ret(pos) {
	//window.parent.callBack(\'adf\');return false;
	var arr = new Array();
	for (key in _cache) {
		arr.push(_cache[key])
	}
	if(window.parent.ymPrompt) window.parent.ymPrompt.doHandler(arr,true);//return false;
	else {
		if(window.parent.thickboxCallBack) {
			//return false;
			window.parent.tb_remove();
			window.parent.thickboxCallBack(arr,pos);
		}
		window.returnValue = arr;
		window.close();
	}
	//window.returnValue=arr;
	//window.close();

	//如果是iframe,改变opener中的变量,并执行callback(arr);
}
</script>

<style type="text/css">
.scrollTable{
	border-top:1px solid #999;
	border-left:1px solid #999;
	border-collapse:collapse;
	text-align:center
}
.scrollTable td {border-bottom:1px solid #999; border-right:1px solid #999; }
.scrollTable .th {background-color:#CCCCCC}
</style>
'; ?>

</head>
<body style="margin-left:2px; margin-right:8px; height:100%">
<?php if ($_GET['no_edit'] != 1): ?>
<table width="100%" cellpadding="0" cellspacing="0">
<tr><td colspan="2"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_SearchItem.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></tr>
<tr><td style="height:5px;" colspan="2"></td></tr>
</table>
<?php endif; ?>
<div id="div_content" class="c">
<table width='100%' class="scrollTable" id="tb">
          <thead class="fixedHeader headerFormat">
      <tr id="fieldInfo" class="th">
        <td align="center"><input type="button" name="button" id="button" value="选择" onClick="ret(<?php echo $_GET['pos']; ?>
)"></td>
	    <?php $_from = $this->_tpl_vars['arr_field_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        	<td align="center"  class="point" nowrap><?php echo $this->_tpl_vars['item']; ?>
</td>
        <?php endforeach; endif; unset($_from); ?>
		<?php if ($this->_tpl_vars['arr_edit_info'] != ""): ?>		<?php endif; ?>
      </tr>
	  </thead>
            <tbody class="scrollContent bodyFormat" style="height:auto;">
      <?php $_from = $this->_tpl_vars['arr_field_value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_value']):
?>
	  <?php if ($this->_tpl_vars['field_value']['display'] != 'false'): ?>	  	  <tr class="fieldValue">
      	<td align="center"><?php if ($this->_tpl_vars['field_value']['isHave'] != 'no'): ?><INPUT TYPE="checkbox" NAME="sel[]" onclick='changeCache(this,<?php echo ((is_array($_tmp=json_encode($this->_tpl_vars['field_value']))) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
)' value='<?php echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['unique_field']])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['field_value']['id']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['field_value']['id'])); ?>
' style="margin:0px; border:0px;"><?php endif; ?></td>
		<?php $_from = $this->_tpl_vars['arr_field_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        	<?php $this->assign('foo', ((is_array($_tmp=".")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['key']) : explode($_tmp, $this->_tpl_vars['key']))); ?>
		    <?php $this->assign('key1', $this->_tpl_vars['foo'][0]); ?>
		    <?php $this->assign('key2', $this->_tpl_vars['foo'][1]); ?>
			<?php $this->assign('key3', $this->_tpl_vars['foo'][2]); ?>
    	<td align="center" nowrap <?php if ($this->_tpl_vars['field_value']['_bgColor'] != ''): ?>bgcolor="<?php echo $this->_tpl_vars['field_value']['_bgColor']; ?>
"<?php endif; ?>>
            <?php if ($this->_tpl_vars['key2'] == ''):  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

            <?php elseif ($this->_tpl_vars['key3'] == ''):  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key1']][$this->_tpl_vars['key2']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

            <?php else:  echo ((is_array($_tmp=@$this->_tpl_vars['field_value'][$this->_tpl_vars['key1']][$this->_tpl_vars['key2']][$this->_tpl_vars['key3']])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>

            <?php endif; ?></td>
    	<?php endforeach; endif; unset($_from); ?>
  	  </tr>
	  <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
</div>
<div id='divPage' style="float:left"><?php echo $this->_tpl_vars['page_info']; ?>
</div>
</body>
</html>