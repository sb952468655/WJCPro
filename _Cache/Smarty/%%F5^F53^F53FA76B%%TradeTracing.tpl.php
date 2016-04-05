<?php /* Smarty version 2.6.10, created on 2016-03-07 11:15:07
         compiled from Trade/TradeTracing.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Trade/TradeTracing.tpl', 6, false),array('modifier', 'json_encode', 'Trade/TradeTracing.tpl', 24, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%F5^F53^F53FA76B%%TradeTracing.tpl.inc'] = 'e320bb915e1cb2c269bd3fa312db4a5c'; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->_tpl_vars['title']; ?>
</title>
<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/adapter/ext/ext-base.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#0}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/ext-all.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#1}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#2}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/common.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#3}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/SearchItemTpl.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#4}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/resources/css/ext-all.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#5}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/tblList.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#6}';}?>

<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:e320bb915e1cb2c269bd3fa312db4a5c#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/TblList.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:e320bb915e1cb2c269bd3fa312db4a5c#7}';}?>


<script type="text/javascript" src="Resource/Script/ext/ux/treegrid/TreeGridSorter.js"></script>
<script type="text/javascript" src="Resource/Script/ext/ux/treegrid/TreeGridColumnResizer.js"></script>
<script type="text/javascript" src="Resource/Script/ext/ux/treegrid/TreeGridNodeUI.js"></script>
<script type="text/javascript" src="Resource/Script/ext/ux/treegrid/TreeGridLoader.js"></script>
<script type="text/javascript" src="Resource/Script/ext/ux/treegrid/TreeGridColumns.js"></script>
<script type="text/javascript" src="Resource/Script/ext/ux/treegrid/TreeGrid.js"></script>
<link rel="stylesheet" type="text/css" href="Resource/Script/ext/ux/treegrid/treegrid.css" rel="stylesheet" />

<script language="javascript">
var _head = <?php echo json_encode($this->_tpl_vars['arr_field_info']); ?>
;
var _hasSearch = <?php if ($this->_tpl_vars['arr_condition']): ?>true<?php else: ?>false<?php endif; ?>;
var _dataUrl = '<?php echo $this->_tpl_vars['dataUrl']; ?>
';
<?php echo '
try { //解决ie6下背景图片延迟的问题
	document.execCommand("BackgroundImageCache", false, true);
} catch(e) {}

/**
* 布局界面
*/
Ext.onReady(function() {
	var mainDiv = document.getElementById(\'treeGrid\');
	var sonDiv = document.getElementById(\'panelInfo\');

	//加载treeGrid数据
	var treeGrids = new Ext.ux.tree.TreeGrid({
        width: 500,
        height: 400,
        enableSort:false,
        enableHdMenu:false,
        // useArrows:false,

        renderTo: Ext.get(\'treeGrid\'),
        enableDD: true,
		
        columns:_head,

        dataUrl: _dataUrl,
        listeners:{
        	click:function(node, e){
        		/**
				* param 为{attr:attributes,node:node}
				* attr : 该行的所有信息，包括没有显示的信息
				* node : 该节点的所有信息
				* 如果获取该节点的父节点：node.parentNode
				* dump(node);查看其它节点信息
				*/
        		// dump(node);
        		if(typeof afterClick) afterClick({\'attr\':node.attributes,\'node\':node});
        	}
        }
    });

	//开始布局
	var items = [];
	if(_hasSearch && document.getElementById(\'searchGuide\')) items.push({
		xtype: \'box\',
		region: \'north\',
		height: 28,
		contentEl: \'searchGuide\'
	});

	var bbar = [{
		xtype: \'tbitem\',
		contentEl: \'p_bar\'
	} //不能使用tbtext,会导致上下偏移失常。
	,
	\'->\',
	{
		text: \' 刷 新 \',
		iconCls: \'x-tbar-loading\',
		cls: \'x-btn-mc\',
		handler: function() {
			window.location.href = window.location.href
		}
	}];
	if(mainDiv)items.push({
		id: \'viewMain\',
		region: \'center\',
		layout: \'border\',
		margins: \'0 0 -1 -1\',
		bbar: bbar,
		items: [{
			// title: \'明细(选中上边某行显示)\',
			id: \'pannel\',
			region: \'south\',
			layout: \'fit\',
			contentEl: \'panelInfo\',
			autoScroll:true,
			margins: \'-1 -1 -1 -1\',
			split: true, // enable resizing
			//width: _sonWidth
			height:200
		}, {
			id: \'gridView\',
			region: \'center\',
			layout: \'fit\',
			margins: \'-2 -2 0 -2\',
			// contentEl: \'treeGrid\',
			items: [treeGrids],
			onLayout: function() {
			}
		}]
	});

	//渲染界面
	var viewport = new Ext.Viewport({
		layout: \'border\',
		items: items,
		onRender: function() {
			Ext.QuickTips.init(); //使得所有标记了ext:qtip=\'点击显示订单跟踪明细\'的元素显示出tip,比如
			Ext.apply(Ext.QuickTips.getQuickTip(), {
				dismissDelay: 0
			});
			//<input value=\'\' ext:qtip=\'点击显示订单跟踪明细\' />
			renderForm(document.getElementById(\'FormSearch\'));
			//处理搜索
			autoSearchDiv();
		
		}
	});

	//弹出窗口定义事件
	$(".openDialog").live(\'click\',function(){
		var win = Ext.getCmp("win");
		if(!win){
			var url=$(this).attr(\'href\');
			var width=$(this).attr(\'width\')||700;
			var height=$(this).attr(\'height\')||470;
			win = new Ext.Window({
				id:\'win\',
				layout:\'fit\',
				width:width,
				height:height,
				closeAction:\'close\',
				plain: true,
				title:$(this).attr(\'title\')+\'\',
				padding:\'5 2 2 2\',
				modal:true,
				html:\'<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="\'+url+\'"> </iframe>\'
			});
		}
		win.show();
		return false;
	});

	Ext.get(\'loading\').remove();
	Ext.get(\'loading-mask\').remove();
	
});

function form_submit() {
	document.getElementById("FormSearch").submit();
}
</script>
'; ?>

<?php if ($this->_tpl_vars['sonTpl']):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sonTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
</head>
<body style='position:static'>
<div id="loading-mask"></div>
<div id="loading">
  <div class="loading-indicator"><img src="Resource/Script/ext/resources/images/default/grid/loading.gif" width="16" height="16" style="margin-right:8px;" align="absmiddle"/>正在载入...</div>
</div>
 <!-- 搜索信息栏 -->
<?php if ($_GET['no_edit'] != 1):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "_Search.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
<!-- 主要信息显示区域，treeGrid控件 -->
<div id="treeGrid">
</div>
<!-- 子信息显示区域，显示其他信息 -->
<div id="panelInfo">
	<?php if ($this->_tpl_vars['sonViewTpl']):  $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => $this->_tpl_vars['sonViewTpl'], 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
  endif; ?>
</div>
<!-- 最下面的状态提示信息和分页信息 -->
<div id='p_bar'><?php echo $this->_tpl_vars['page_info']; ?>
</div>
</body>
</html>