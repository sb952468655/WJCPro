<?php /* Smarty version 2.6.10, created on 2014-11-11 20:00:28
         compiled from Main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Main.tpl', 4, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%8B^8BA^8BAC94BE%%Main.tpl.inc'] = 'aaba5c087a124828083f5ebfb41013e0'; ?><html>
<meta http-equiv="X-UA-Compatible" content="chrome=34">
<head>
  <title><?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'GetAppInf','varName' => 'systemName'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#0}';}?>
</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#1}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/resources/css/ext-all.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#1}';}?>

    <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#2}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Css/main1.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#2}';}?>

    <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#3}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/adapter/ext/ext-base.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#3}';}?>

    <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#4}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/ext-all.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#4}';}?>

	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#5}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ext/TabCloseMenu.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#5}';}?>

    <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#6}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#6}';}?>

	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#7}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/thickbox/thickbox.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#7}';}?>

    <?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#8}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/thickbox/thickbox.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#8}';}?>

	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#9}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/ymPrompt.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#9}';}?>

	<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#10}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/ymPrompt/skin/qq/ymPrompt.css"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#10}';}?>

    <?php echo '
    <style type="text/css">
    html, body {
        font:normal 12px Arial;
        margin:0;
        padding:0;
        border:0 none;
        overflow:hidden;
        height:100%;
    }
    p {
        /*margin:5px;*/
    }
	#loading-mask {
		background-color:white;
		height:100%;
		left:0;
		position:absolute;
		top:0;
		width:100%;
		z-index:20000;
		background-color:#FFFFFF
	}

	#divMsg {
		/*width:100px; */
		position:absolute;
		height: 22px;
		float:left;
		font-size: 12px;
		line-height: 22px;
		left:45%;
		/*overflow: hidden;	*/
		white-space: nowrap;
		background: none repeat scroll 0 0 #16960E;
		color : #fff;
		font-weight:bold;
		text-align:center;
		border:1px solid #0C9;
		margin-top:15px;
		display:none;
		padding-left:10px; padding-right:10px;
	}
	#footer {width:100%;padding:1px;}
	#footer table {width:100%;}
	#footer td {font-size:9pt;white-space: nowrap;}
	#footer img {vertical-align:text-bottom;}
	#footer #divUser {float: left; text-align: right;}
	#footer #divJingyan {float: right;}

    </style>
    
    <script type="text/javascript">
    Ext.onReady(function(){
		var imagePath = \'Resource/Script/ext/resources/images\';
		Ext.BLANK_IMAGE_URL = imagePath+\'/default/s.gif\';
		var detailEl;
		var tabs;
		var welcomeUrl=\'Index.php?controller=main&action=Welcome\';



		var treePanel = new Ext.tree.TreePanel({
			id: \'tree-panel\',
			//title: \'菜单目录\',
			region:\'center\',
			split: true,
			border:false,
			//height: 400,
			//minSize: 300,
			autoScroll: true,

			// tree-specific configs:
			rootVisible: false,
			lines: false,
			singleExpand: true,
			useArrows: true,

			loader: new Ext.tree.TreeLoader({
				dataUrl:"?controller=main&action=getmenu"
			}),
			root: new Ext.tree.AsyncTreeNode()
		});

		// Assign the changeLayout function to be called on tree node click.
		treePanel.on(\'click\', function(n){
			//debugger;//alert(\'右边窗口增加一个tab窗口\');
			var sn = this.selModel.selNode || {}; // selNode is null on initial selection
			var desc = "<p style=\'margin:8px\'>"+(n.attributes.desc||\'没有使用说明\')+\'</p>\';
			var href = n.attributes.src;
			var id = \'docs-\' + n.attributes.id;
			var text = n.attributes.text;

			//处理tab
			if(!n.leaf) {
				//展开
				n.expand();
				return ;
			}
			var tab = tabs.getComponent(id);
			if(tab){
				document.getElementById(\'_frm\'+id).src = href;
				tab.show();
			}else{
				var t = tabs.add({
					id:id,
					title: text,
					iconCls: \'tabs\',
					html: \'<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="\'+href+\'" id="_frm\'+id+\'"> </iframe>\',
					closable:true,
					listeners: {
						activate : function(o) {
							var node = treePanel.getNodeById(o.id.slice(5));
							if(!node) return true;
							node.ensureVisible(function(){node.select();});
						}
					}
				}).show();
			}
		});

		var northItem = {
			xtype: \'box\',
			region: \'north\',
			height:45,
			contentEl: \'header\'
		}
		var southItem = {
			xtype: \'box\',
			region: \'south\',
			layout: \'fit\',
			height:20,
			contentEl: \'footer\'
		}

		var westItem =  {
			region: \'west\',
			//iconCls: \'tabs\',
			id: \'west-panel\', // see Ext.getCmp() below
			layout: \'border\',
			title: \'系统菜单\',
			split: true,
			width: 200,
			minSize: 100,

			maxSize: 400,
			collapsible: true,
			margins: \'2 0 0 2\',
			items: [treePanel]
			//items: [treePanel, detailsPanel]  //detailsPanel是左下角的揭示框
		};
		var centerItem = new Ext.TabPanel({
			id:\'_tabs\',
			region: \'center\', // a center region is ALWAYS required for border layout
			deferredRender: false,
			enableTabScroll:true,
			activeTab: 0,     // first tab initially active
			margins: \'2 0 0 0\',
			items: [{
				//contentEl: \'center2\',
				title: \'首页\',
				autoScroll: true,
				html: \'<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="\'+welcomeUrl+\'"> </iframe>\'
			}],
			plugins: new Ext.ux.TabCloseMenu()
		});
		tabs = centerItem;


        var viewport = new Ext.Viewport({
            layout: \'border\',
            items: [northItem,southItem,westItem,centerItem]
        });
		setTimeout(function(){
			Ext.get(\'loading\').remove();
			Ext.get(\'loading-mask\').fadeOut({remove:true});
		}, 500);
		//开始弹窗
		pop();
	 	setTimeout(\'getTongzhi()\',60000);
		//setTimeout(\'getMail()\',60000);
    });

	function pop(){
		var url=\'?controller=tool&action=GetPopByAjax\';
		var param=null;
		$.post(url,param,function(json){
			if(!json) {
				alert(\'异常\');
				return false;
			}
			if(!json.success) {//没有弹窗信息
				return true;
			}
			//开始显示弹窗
			ymPrompt.alert({message:json.data.content,title:json.data.title,winPos:\'rb\'}) ;
			//alert(json.data.content);
		},\'json\');
	}
	
	//text表示提示框中要出现的文字，
	//ok表示是显示ok图标还是出错图标
	function showMsg(text,time) {
		if(!time>0)time=2600;
		$(\'#divMsg\').text(text).fadeIn(\'slow\');
		setTimeout(function(){$(\'#divMsg\').fadeOut(\'normal\');}, time);
	}
	function addTab(frmId,text,href) {
		var id = \'docs-\' + frmId;
		var tabs = Ext.getCmp(\'_tabs\');
		var tab = tabs.getComponent(id);
		var treePanel = Ext.getCmp(\'tree-panel\');
		if(tab){
			document.getElementById(\'_frm\'+id).src = href;
			tab.show();
		}else{
			var t = tabs.add({
					id:id,
					title: text,
					iconCls: \'tabs\',
					html: \'<iframe scrolling="auto" frameborder="0" width="100%" height="100%" src="\'+href+\'" id="_frm\'+id+\'"> </iframe>\',
					closable:true,
					listeners: {
						activate : function(o) {
							var node = treePanel.getNodeById(o.id.slice(5));
							if(!node) return true;
							node.ensureVisible(function(){node.select();});
						}
					}
				}).show();
		}
	}
    </script>
    <script language="javascript">
	//var cntJiaji=0;
	$(function(){
		$(\'body\').keydown(function(e){
			var currKey=e.keyCode||e.which||e.charCode;
			//alert(currKey);
			//如果ctrl+alt+shift+A弹出db_change输入框,此功能只开发给开发人员形成db_change文档时用
			if(e.altKey&&e.ctrlKey&&e.shiftKey&&currKey==65) {
				var url = \'?controller=Dbchange&action=Add\';
				window.open(url);
			}
			//如果ctrl+alt+shift+z弹出执行窗口,此功能只给实施人员用
			if(e.altKey&&e.ctrlKey&&e.shiftKey&&currKey==90) {
				var url = \'?controller=Dbchange&action=AutoUpdate\';
				window.open(url);
			}
		});

	});
	function getTongzhi(){
	 var url=\'?controller=main&action=GetTongzhiByAjax\';
	 var param={};
	 //ymPrompt.alert({message:\'右下角弹出\',title:\'右下角弹出\',winPos:\'rb\'})
	 $.getJSON(url,param,function(json){
	  if(!json) return false;
	  if(json.cnt>0) {//如果原来的加急数>0且当前加急数>原来加急数,弹出窗
	  		if(!json.kindName)json.kindName=\'通知\';
	   		ymPrompt.confirmInfo({message:\'系统发现新的\'+json.kindName+\'！请进入通知管理查看详细\',title:json.kindName,winPos:\'rb\',handler:function(a){
				if(a==\'ok\') {
					var url=\'?controller=OaMessage&action=right&no_edit=1\';
					window.open(url);
				}
				//弹出窗口后则不显示弹出窗口了
				var url="?controller=main&action=TzViewDetailsByAjax";
				$.getJSON(url,{},function(json){});
				setTimeout(\'getTongzhi()\',60000);
			}}) ;
	  } else {
	  		setTimeout(\'getTongzhi()\',60000);
	  }

	 });
	}

	function getMail(){
	 var url=\'?controller=main&action=GetMailByAjax\';
	 var param={};
	 //debugger;
	 //ymPrompt.alert({message:\'右下角弹出\',title:\'右下角弹出\',winPos:\'rb\'})
	 $.getJSON(url,param,function(json){
	  if(!json) return false;
	  if(json.cnt>0) {//如果原来的加急数>0且当前加急数>原来加急数,弹出窗
	   		ymPrompt.confirmInfo({message:\'系统发现有新的邮件！请进入邮件管理查看详细\',title:\'内部邮件\',winPos:\'rb\',handler:function(a){
				if(a==\'ok\') {
					var url=\'?controller=Mail&action=MailNoRead&no_edit=1\';
					window.open(url);
				}
				setTimeout(\'getMail()\',60000);
			}}) ;
	  } else {
	  		setTimeout(\'getMail()\',60000);
	  }

	 });
	}

function closeWin(){
	if(!confirm("该操作将退出并关闭系统，请确认！")){
		return;
	}
	window.open(\'\',\'_self\',\'\');    
    window.close();
}

</script>
    '; ?>

<body>
  <div id="loading-mask" style=""></div>
  <div id="loading">
    <div class="loading-indicator"><img src="Resource/Script/ext/loading.gif" width="32" height="32" style="margin-right:8px;" align="absmiddle"/>正在载入...</div>
  </div>
  <div id='header' style="width:100%;height:100%; color:white;background-image:url(Resource/Image/bg_top.gif);text-align:center;">
	<div style="float:left; margin:8px; padding-top:5px; font:16px Arial, Helvetica, sans-serif; font-weight:bold;">
		<img src="Resource/Image/logo2.gif" style="vertical-align:middle; height:27px; font-family:"微软雅黑", "新宋体";" />&nbsp;欢迎进入<?php if ($this->caching && !$this->_cache_including) { echo '{nocache:aaba5c087a124828083f5ebfb41013e0#11}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'GetAppInf','varName' => 'compName'), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:aaba5c087a124828083f5ebfb41013e0#11}';}?>
信息管理系统！
	</div>
	<div id="divMsg">saving...</div>
	<div style="float:right; padding-top:20px;">
	  <p style="font-family:Arial, Helvetica, sans-serif; padding-right:5px;">
<img src="Resource/Image/huiyi_icon.gif">&nbsp;<?php echo $_SESSION['REALNAME']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;
	  	<a href="?controller=Login&action=logout" style="color:white;text-decoration: underline;">注销</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:void(0)" onClick="closeWin()" style="color:white;text-decoration: underline;">退出</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['tool']; ?>
 </p>
	</div>
  </div>
  <div id='footer'>
  	<table>
  		<tr>
  			<td>
  				技术支持：<a href="http://www.eqinfo.com.cn" target='_blank' style="color:#000">易奇科技</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;全国服务热线：400-669-0297
  			</td>
  			<td>
  			</td>
  			<td align='right' id='divJingyan'>
  				<!--正在获得最新经验...-->
  			</td>
  		</tr>
  	</table>
	  <!-- <div style='width:300px;float:left;color:#000;padding-left:5px;padding-right:10px;'></div>
	  <div style='width:100px;float:left;color:#000;padding-left:5px;padding-right:10px;'></div>
	  <div style='width:45%;float:right;text-align:right;' ></div> -->
  </div>
</body>
</html>