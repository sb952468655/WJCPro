<?php /* Smarty version 2.6.10, created on 2015-11-25 11:21:49
         compiled from Shengchan/Cangku/PlanEdit.tpl */ ?>
<script language="javascript">
<?php echo '
$(function(){
	var url=\'?Controller=Shengchan_PlanTl&action=GetTouliaoByAjax\';

	$(\'#touliaoId\').bind(\'onSel\',function(event,ret){
		// debugger;
		var id=[];
		var touliaoId=[];
		var touliaoCode=[];
		for(var k in ret){
			if(typeof(ret[k])==\'function\') continue;
			id.push(ret[k].id);
			touliaoId.push(ret[k].touliaoId);
			touliaoCode.push(ret[k].touliaoCode);
		}
		touliaoId = unique(touliaoId);
		touliaoCode = unique(touliaoCode);

		// dump(touliaoId);

		$(\'#touliaoId\').val(touliaoId.join(\',\'));
		$(\'[name="textBox"]\',$(\'#touliaoId\').parents(\'.input-group\')).val(touliaoCode.join(\',\'));

		if(touliaoId.length==0)return;

		var param={\'touliaoId\':id.join(\',\')};

		$.getJSON(url,param,function(json){
			if(!json.success) {
				alert(json.msg);
				return;
			}
			var pros = json.Touliao;
			// alert(json.Touliao);
			// debugger;
			if(pros.length==0) {
				alert(\'δ���������ƻ���Ͷ����Ϣ!\');
				return;
			}
			//�ж��������е�id[]�����Ϊ��ɾ����������(��Ҫ��Ϊ�˿����޸�ʱ�����ܰ��ѱ��������ϸֱ��ɾ��)
			var trs = $(\'.trRow\');
			var len = trs.length;
			var trTpl = trs.eq(len-1).clone(true);
			var parent = trs.eq(0).parent();
			$(\'input,select\',trTpl).val(\'\');
			for(var i=0;trs[i];i++) {
				var id = $(\'[name="id[]"]\',trs[i]);
				if(id.val()!=\'\') continue;
				trs.eq(i).remove();
			}
			//��ѡ�ж�������ϸ�γ����в���
			for(var i=0;pros[i];i++) {
				var newTr = trTpl.clone(true);

				$(\'#proCode\',newTr).val(pros[i].Product.proCode);
				$(\'[name="productId[]"]\',newTr).val(pros[i].Product.id);
				$(\'[name="proName[]"]\',newTr).val(pros[i].Product.proName);
				$(\'[name="guige[]"]\',newTr).val(pros[i].Product.guige);
				$(\'[name="color[]"]\',newTr).val(pros[i].color);
				$(\'[name="cntKg[]"]\',newTr).val(pros[i].cntKg);
				$(\'[name="plan2tlId[]"]\',newTr).val(pros[i].id);
				$(\'[name="supplierId[]"]\',newTr).val(pros[i].supplierId);
				$(\'[name="memoView[]"]\',newTr).val(pros[i].memoView);

				//�����Զ��ؼ�����ɫ�����
				parent.append(newTr);
			}
			
		});
	});
	/*$(\'#touliaoId\').bind(\'onSel\',function(event,ret){
		// debugger;
		var touliaoId = $(\'#touliaoId\').val();
		var param={\'touliaoId\':touliaoId};
		$.getJSON(url,param,function(json){
			if(!json.success) {
				alert(json.msg);
				return;
			}
			var pros = json.Touliao;
			// alert(json.Touliao);
			// debugger;
			if(pros.length==0) {
				alert(\'δ���������ƻ���Ͷ����Ϣ!\');
				return;
			}
			//�ж��������е�id[]�����Ϊ��ɾ����������(��Ҫ��Ϊ�˿����޸�ʱ�����ܰ��ѱ��������ϸֱ��ɾ��)
			var trs = $(\'.trRow\');
			var len = trs.length;
			var trTpl = trs.eq(len-1).clone(true);
			var parent = trs.eq(0).parent();
			$(\'input,select\',trTpl).val(\'\');
			for(var i=0;trs[i];i++) {
				var id = $(\'[name="id[]"]\',trs[i]);
				if(id.val()!=\'\') continue;
				trs.eq(i).remove();
			}
			//��ѡ�ж�������ϸ�γ����в���
			for(var i=0;pros[i];i++) {
				var newTr = trTpl.clone(true);

				$(\'#proCode\',newTr).val(pros[i].Product.proCode);
				$(\'[name="productId[]"]\',newTr).val(pros[i].Product.id);
				$(\'[name="zhonglei[]"]\',newTr).val(pros[i].Product.zhonglei);
				$(\'[name="proName[]"]\',newTr).val(pros[i].Product.proName);
				$(\'[name="guige[]"]\',newTr).val(pros[i].Product.guige);
				$(\'[name="color[]"]\',newTr).val(pros[i].color);
				$(\'[name="cntKg[]"]\',newTr).val(pros[i].cntKg);
				$(\'[name="plan2tlId[]"]\',newTr).val(pros[i].id);
				$(\'[name="supplierId[]"]\',newTr).val(pros[i].supplierId);

				//�����Զ��ؼ�����ɫ�����
				parent.append(newTr);
			}
			
		});
	});*/
});
'; ?>

</script>