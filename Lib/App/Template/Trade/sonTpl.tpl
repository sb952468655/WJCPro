{webcontrol type='LoadJsCss' src="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css"}
{literal}
<style type="text/css">
.bs-callout {
	border: 1px solid #eee;
	/*border-left-width: 5px #D4E1F2 solid;*/
	border-radius: 3px;
	margin-left: 2px;
}
.head th{
	font-weight: bold !important;
	/*border-left:1px solid #ddd;*/
}
.head th span{
	cursor: pointer;
}
.head th span:hover{
	cursor: pointer;
	color: blue;
}
.tblGroupView{
	display: none;
}
.tblGroupOrder{
	display: none;
}
</style>
{/literal}
<script language="javascript">
{literal}
/**
* param 为{attr:attributes,node:node}
* attr : 该行的所有信息，包括没有显示的信息
* node : 该节点的所有信息
* dump(node);查看其它节点信息
*/
function afterClick (param) {
	//删除原来的信息
	$('.trRowSon').remove();

	
	//加载新信息
	var plan2proId = param.attr.plan2proId;
	var orderId = param.attr.orderId;
	if(!plan2proId>0){
		$('.tblGroupView').hide();
		$('.tblGroupOrder').show();

		//显示订单信息
		viewOrder(orderId);
	}else{
		$('.tblGroupOrder').hide();
		$('.tblGroupView').show();

		//显示计划跟踪信息
		viewPlan(plan2proId);
	}

	
}
/**
* 显示订单跟踪信息
*/
function viewOrder(orderId){
	var url = "?controller=trade_order&action=GetChukuInfoByOrderId";
	var param = {'orderId':orderId};
	$.getJSON(url,param,function(json){
		// debugger;
		var pros = json.pros;

		//加載工序信息到表格显示
		if(pros.length>0){
			var newTr = [];
			for(var i=0;pros[i];i++){
				var t = pros[i];

				var trStr = "<tr class='trRowSon'>";
				trStr +="<td>"+t.proCode+"</td>";
				trStr +="<td>"+t.pinzhong+"</td>";
				trStr +="<td>"+t.guige+"</td>";
				trStr +="<td>"+t.color+"</td>";
				trStr +="<td>"+t.cntYaohuo+"</td>";
				trStr +="<td>"+t.chukuCnt+"</td>";
				trStr +="<td>"+t.unit+"</td>";
				trStr +="<td>"+t.rate+"</td>";
				trStr += "</tr>";

				newTr.push(trStr);
			}

			var trsStr=newTr.join('');
			$('#orderChuku').append(trsStr);
		}
	});
}

/**
* 显示计划信息
*/
function viewPlan(plan2proId){
	var url = "?controller=Shengchan_plan&action=getInfoByPlan2proId";
	var param = {'plan2proId':plan2proId};
	$.getJSON(url,param,function(json){
		// debugger;
		var gxpros = json.gxInfo;
		var tlpros = json.tlInfo;

		//加載工序信息到表格显示
		if(gxpros.length>0){
			var gxTr = [];
			for(var i=0;gxpros[i];i++){
				var t = gxpros[i];

				var trStr = "<tr class='trRowSon'>";
				trStr +="<td>"+t.gongxuName+"</td>";
				trStr +="<td>"+t.compName+"</td>";
				trStr +="<td>"+t.cntTl+"</td>";
				trStr +="<td>"+t.cntYs+"</td>";
				trStr +="<td>"+t.sunhao+"</td>";
				trStr += "</tr>";

				gxTr.push(trStr);
			}

			var trsStr=gxTr.join('');
			$('#gongxuTbl').append(trsStr);
		}

		//加载投料信息
		if(tlpros.length>0){
			var tlTr = [];
			for(var i=0;tlpros[i];i++){
				var t = tlpros[i];

				var trStr = "<tr class='trRowSon'>";
				trStr +="<td>"+t.proCode+"</td>";
				trStr +="<td>"+t.proName+"</td>";
				trStr +="<td>"+t.guige+"</td>";
				trStr +="<td>"+t.color+"</td>";
				trStr +="<td>"+t.cntKg+"</td>";
				trStr +="<td>"+t.cnt+"</td>";
				trStr += "</tr>";

				tlTr.push(trStr);
			}

			var trsStr=tlTr.join('');
			$('#touliaoTbl').append(trsStr);
		}
	});
}
{/literal}
</script>