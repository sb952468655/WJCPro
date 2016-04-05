<?php /* Smarty version 2.6.10, created on 2014-10-30 13:50:57
         compiled from Trade/ColorAuutoCompleteJs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'webcontrol', 'Trade/ColorAuutoCompleteJs.tpl', 1, false),)), $this); ?>
<?php $this->_cache_serials['Lib/App/../../_Cache/Smarty\%%28^287^287C7CA2%%ColorAuutoCompleteJs.tpl.inc'] = '2b9945f2aa4a98adeb2c696357144e3d';  if ($this->caching && !$this->_cache_including) { echo '{nocache:2b9945f2aa4a98adeb2c696357144e3d#0}';}echo $this->_plugins['function']['webcontrol'][0][0]->_pi_func_webcontrol(array('type' => 'LoadJsCss','src' => "Resource/bootstrap/bootstrap3.0.3/js/bootstrap.window.js"), $this);if ($this->caching && !$this->_cache_including) { echo '{/nocache:2b9945f2aa4a98adeb2c696357144e3d#0}';}?>

<script language="javascript">
<?php echo '
$(function(){
  /**
   * 颜色只读，为了统一管理颜色，方便调整，在这里统一调整为只读
  */
  $(\'input[name="color[]"]\').css({\'min-width\':\'110px\'});
  $(\'input[name="color[]"]\').attr(\'readonly\',true);
  $(\'input[name="color[]"]\').attr(\'placeholder\',\'单击选择\');

  /**
   * 需要显示弹出窗口，用于选择颜色信息
  */

  $(\'input[name="color[]"]\').click(function(){
      var obj = this;
      var tr=$(this).parents(\'.trRow\');
      var productId=$(\'[name="productId[]"]\',tr).val();
      if(!productId>0)return;

      var url="?controller=jichu_color&action=GetColorByProId";
      $.getJSON(url,{\'productId\':productId},function(json){
          //show color info
          if(json.success)showWindow(obj,json.data);
      });
  });

});

'; ?>

</script>