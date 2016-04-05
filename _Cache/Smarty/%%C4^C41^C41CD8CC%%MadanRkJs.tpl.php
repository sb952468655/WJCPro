<?php /* Smarty version 2.6.10, created on 2014-11-04 09:50:39
         compiled from Shengchan/Cangku/MadanRkJs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Shengchan/Cangku/MadanRkJs.tpl', 1, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%C4^C41^C41CD8CC%%MadanRkJs.tpl.inc'] = '20cc63e9fdf7272de653c294698e3172';  if ($this->caching && !$this->_cache_including) { echo '{nocache:20cc63e9fdf7272de653c294698e3172#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/Script/jquery.json.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:20cc63e9fdf7272de653c294698e3172#0}';}?>

<script language="javascript">
<?php echo '
$(function(){
	/**
	* 码单按钮单机事件
	* 打开码单出库界面
	*/
	$(\'[name="btnMadan"]\').live(\'click\',function(){
		//url地址
		var url="?controller=Shengchan_Ruku&action=ViewMadan";
		var trRow = $(this).parents(".trRow");
		//弹出窗口，设置宽度高度
		var width = screen.width;
		var height = screen.height;
		width = width>1200?1200:width;
		height = height>640?640:height;
		//获取码单选择信息
		var madan = $(\'[name="Madan[]"]\',trRow).val();
		window.returnValue=null;
		var ret = window.showModalDialog(url,{data:madan},\'dialogWidth:\'+width+\'px;dialogHeight:\'+height+\'px;\');

	    if(!ret){
	    	ret=window.returnValue;
	    }
	    if(!ret) return;
		if(ret.ok!=1)return false;
		// dump(ret);
		$(\'[name="cntJian[]"]\',trRow).val(ret.cntJian);
		$(\'[name="cnt[]"]\',trRow).val(ret.cnt);
		$(\'[name="Madan[]"]\',trRow).val(ret.data);
		$(\'[name="cnt[]"]\',trRow).change();
	});
});
'; ?>

</script>