<?php /* Smarty version 2.6.10, created on 2014-11-25 13:41:57
         compiled from TblList.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'TblList.tpl', 21, false),array('function', 'url', 'TblList.tpl', 243, false),array('modifier', 'json_encode', 'TblList.tpl', 35, false),array('modifier', 'default', 'TblList.tpl', 45, false),array('modifier', 'is_string', 'TblList.tpl', 243, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%55^557^55731247%%TblList.tpl.inc'] = 'fab7285aa80ac5f612f02c7eee3b4238'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/adapter/ext/ext-base.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/ext-all.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.query.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/Calendar/WdatePicker.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/thickbox/thickbox.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/thickbox/thickbox.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#7}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#8}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/SearchItemTpl.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#8}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#9}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/resources/css/ext-all.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#9}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#10}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/TblList.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#10}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#11}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/tblList.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#11}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#12}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/TmisGrid.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#12}';}?>

<script language="javascript">
var _head = <?php echo json_encode($this->_tpl_vars['arr_field_info']); ?>
;

//如果自动添加复选框，则需要自动添加一列表头信息
<?php if ($this->_tpl_vars['_checked']): ?>
	<?php echo '
		_head = $.extend({\'_checked\':{\'width\':40}}, null, _head);
	'; ?>

<?php endif; ?>

var _hasSearch = <?php if ($this->_tpl_vars['arr_condition']): ?>true<?php else: ?>false<?php endif; ?>;
var _printUrl = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['print_href'])) ? $this->_run_mod_handler('default', true, $_tmp, null) : smarty_modifier_default($_tmp, null)); ?>
';//打印的url
var _showExport = '<?php echo ((is_array($_tmp=@$this->_tpl_vars['fn_export'])) ? $this->_run_mod_handler('default', true, $_tmp, null) : smarty_modifier_default($_tmp, null)); ?>
';//是否显示导出
var _debug = false;//打开调试，不进行viewport，不显示蒙版
<?php echo '
try{//解决ie6下背景图片延迟的问题
	document.execCommand("BackgroundImageCache", false, true);
}
catch (e){
}
Ext.onReady(function() {
	var divGrid = document.getElementById(\'divGrid\');

	$(\'#divList\', divGrid)[0].onscroll = function() {
		duiqiHead(this.parentNode);
	}

	//开始布局
	var items = [];
	if(_hasSearch && document.getElementById(\'searchGuide\')) items.push({
		xtype: \'box\',
		region: \'north\',
		height: 28,
		//frame:true,
		contentEl: \'searchGuide\'
	});

	var bbar = [{
		xtype: \'tbtext\',
		contentEl: \'p_bar\'
	}, \'->\',
	{
		text: \' 刷 新 \',
		iconCls: \'x-tbar-loading\',
		cls: \'x-btn-mc\',
		handler: function() {
			window.location.href = window.location.href
		}
	}];
	if(_printUrl || typeof(fnPrint) == \'function\') {
		bbar.push(\'-\');
		bbar.push({
			text: \'打 印\',
			iconCls: \'btnPrint\',
			handler: function() {
				if(typeof(fnPrint) == \'function\') {
					fnPrint();
					return;
				}
				window.location.href = _printUrl;
			}
		});
	}
	if(_showExport) {
		bbar.push(\'-\');
		bbar.push({
			text: \'导 出\',
			iconCls: \'btnExport\',
			handler: function() {
				window.location.href = _showExport;
				//alert(\'导出\');
			}
		});
	}
	if(divGrid) items.push({
		id: \'gridView\',
		collapsible: false,
		region: \'center\',
		layout: \'fit\',
		contentEl: \'divGrid\',
		margins: \'0 0 -1 -1\',
		autoScroll: false,
		bbar: bbar
	});
	if(!_debug) var viewport = new Ext.Viewport({
		layout: \'border\',
		items: items,
		onLayout: function() {
			layoutGrid(divGrid)
		},
		onRender: function() {
			setCellsWidth(divGrid, _head);

			//鼠标移上变边框
			$(\'#divRow\', divGrid).hover(fnOver, fnOut).click(function() {
				$(\'.rowSelected\').removeClass(\'rowSelected\');
				$(this).addClass(\'rowSelected\');

			});
			//表头以上改变cursor
			$(\'.headTd\', divGrid).mousemove(changeCursor);

			//使列宽可调整
			var splitZone = new SplitDragZone(divGrid);
			//载入插件
			if(typeof(afterRender) != \'undefined\') afterRender();
			Ext.QuickTips.init(); //使得所有标记了ext:qtip=\'点击显示订单跟踪明细\'的元素显示出tip,比如
			Ext.apply(Ext.QuickTips.getQuickTip(), {
				dismissDelay: 0
			});
			//<input value=\'\' ext:qtip=\'点击显示订单跟踪明细\' />
			renderForm(document.getElementById(\'FormSearch\'));
		}
	});
	
	//自动加载鼠标提示信息
	qtipToCellContents();
	//处理搜索
	autoSearchDiv();
	$(window).bind(\'resize\',function(event){
		autoSearchDiv();
	});
	Ext.get(\'loading\').remove();
	Ext.get(\'loading-mask\').remove();
	
});


//选择月份后改变dateFrom和dateTo
function changeDate(obj){
	//alert(obj.value);
	var df = document.getElementById(\'dateFrom\');
	var dt = document.getElementById(\'dateTo\');
	var d=new Date();
	var year=d.getFullYear();
	var m=parseInt(obj.value)+1;
	if(m<10) m="0"+m;
	df.value=year+\'-\'+m+\'-\'+\'01\';
	//如果为1、3、5、7、8、10、12一个月为31天
	if(obj.value==\'0\'||obj.value==\'2\'||obj.value==\'4\'||obj.value==\'6\'||obj.value==\'7\'||obj.value==\'9\'||obj.value==\'11\')
	{

		dt.value=year+\'-\'+m+\'-\'+\'31\';
	}
	//如果是2月份判断是否闰年
	if(obj.value==\'1\') {
		if((year%4==0 && year%100!=0) || year%400==0){
			dt.value=year+\'-\'+m+\'-\'+\'29\';
		}else{
			dt.value=year+\'-\'+m+\'-\'+\'28\';;
		}
	}
	if(obj.value==\'13\') {
		df.value=\'';  echo date("2010-01-01");  echo '\';
		dt.value=\'';  echo date("Y-m-d",mktime(0,0,0,1,0,date("Y")+1));  echo '\';
	}
	if(obj.value==\'3\'||obj.value==\'5\'||obj.value==\'8\'||obj.value==\'10\')
	{
		dt.value=year+\'-\'+m+\'-\'+\'30\';
	}

}

function form_submit(){
	document.getElementById("FormSearch").submit();
}
</script>
'; ?>

<?php if ($this->_tpl_vars['sonTpl']):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sonTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
<?php if ($this->_tpl_vars['jsTpl']):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['jsTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
</head>
<body style='position:static'>
<div id="loading-mask"></div>
<div id="loading">
  <div class="loading-indicator"><img src="Resource/Script/ext/resources/images/default/grid/loading.gif" width="16" height="16" style="margin-right:8px;" align="absmiddle"/>正在载入...</div>
</div>
<?php if ($_GET['no_edit'] != 1):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_Search.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
<div id="divGrid" class="divGrid">
  <div id="divHead"> 
    <!--增加一个headOffset层，宽度为list的宽度+滚动条的宽度，为了在拖动时始终能看到表头背景-->
    <div id='divHeadOffset'> 
      <!--必须定义border="0" cellpadding="0" cellspacing="0",否则offsetWidth会超出-->
      <table border="0" cellpadding="0" cellspacing="0" id='tblHead'>
        <tr>
        <!-- 添加是否全选的操作 -->
        <?php if ($this->_tpl_vars['_checked']): ?>
	        <td class='headTd'>
	        	<div class='headTdDiv'>
	        		<a href='javascript:;' id='Sel_BTN'>选择</a>
	        	</div>
	        </td>
        <?php endif; ?>
        <!-- end -->
        <?php $_from = $this->_tpl_vars['arr_field_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <?php if ($this->_tpl_vars['key'] != '_edit' || $_GET['no_edit'] != 1): ?>
          <td class='headTd'><div class='headTdDiv'><?php if (is_string($this->_tpl_vars['item']) == 1):  if ($this->_tpl_vars['key'] != '_edit' || $_GET['no_edit'] != 1):  echo $this->_tpl_vars['item'];  endif;  else:  if ($this->_tpl_vars['item']['sort']):  echo $this->_tpl_vars['item']['text']; ?>
<a href='<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#13}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => $_GET['action'],'sortBy' => $this->_tpl_vars['key'],'sort' => 'asc'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#13}';}?>
'><img src='Resource/Image/toolbar/up.gif' border="0" title='升序'/></a><a href='<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:fab7285aa80ac5f612f02c7eee3b4238#14}';}echo $this->_plugins['function']['url'][0][0]->_pi_func_url(array('controller' => $_GET['controller'],'action' => $_GET['action'],'sortBy' => $this->_tpl_vars['key'],'sort' => 'desc'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:fab7285aa80ac5f612f02c7eee3b4238#14}';}?>
'><img src='Resource/Image/toolbar/down.gif' border="0" title='降序'/></a><?php else:  echo $this->_tpl_vars['item']['text'];  endif;  endif; ?></div></td>
          <?php endif; ?>
          <?php endforeach; endif; unset($_from); ?> </tr>
      </table>
    </div>
  </div>
  <div class="x-clear"></div>
  <div id="divList"> 
    <!--必须定义border="0" cellpadding="0" cellspacing="0",否则offsetWidth会超出--> 
    
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=@$this->_tpl_vars['TblListView'])) ? $this->_run_mod_handler('default', true, $_tmp, 'TblListView.tpl') : smarty_modifier_default($_tmp, 'TblListView.tpl')), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> </div>
</div>
<div id='p_bar'><?php echo $this->_tpl_vars['page_info']; ?>

   </div>
</body>
</html>