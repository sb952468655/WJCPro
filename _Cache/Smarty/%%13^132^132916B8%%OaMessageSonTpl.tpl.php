<?php /* Smarty version 2.6.10, created on 2015-10-09 11:23:46
         compiled from OaMessageSonTpl.tpl */ ?>
<script charset="utf-8" src="Resource/Script/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="Resource/Script/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="Resource/Script/kindeditor/plugins/code/prettify.js"></script>
<?php echo '
<script language="javascript">
$(function(){
  $(\'#content\').css({\'height\':\'400px\'});
});

KindEditor.ready(function(K) {
			var editor1 = K.create(\'textarea[name="content"]\', {
				cssPath : \'Resource/Script/kindeditor/plugins/code/prettify.css\',
				uploadJson : \'Resource/Script/kindeditor/php/upload_json.php\',
				fileManagerJson : \'Resource/Script/kindeditor/php/file_manager_json.php\',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
				}
			});
			prettyPrint();
		});
</script>
'; ?>