<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>码单——单卷单匹编辑</title>
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.validate.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/common.js"}
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
{webcontrol type='LoadJsCss' src="Resource/Script/ext/resources/css/ext-all.css"}
{webcontrol type='LoadJsCss' src="Resource/Script/ext/adapter/ext/ext-base.js"}
{webcontrol type='LoadJsCss' src="Resource/Script/ext/ext-all.js"}
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.json.js"}
<script language="javascript">
var data=window.dialogArguments.data;
if(data=='')data='[]';
var _cache=eval('('+data+')');
var page=1;
{literal}
$(function(){	
	/*
	*设置页面布局
	*/
		var southItem = {
			xtype: 'box',
			region: 'south',
			height:30,
			contentEl: 'footer'
		};

		var centerItem = {
			  region:'center',
			  layout:'border',
			  items:[{
				//title:'明细(选中上边某行显示)',
				id : 'pihao',
				region:'west',
				title:'卷号[<a href="javascript:;" title="Alt+N 快捷添加" style="color:green;font-size:13px;" name="addMenuLink" id="addMenuLink" accesskey="N">+5页</a>]',
				layout:'fit',
				contentEl: 'caidan',
				margins: '-2 -2 -2 -2',
				autoScroll:true,
				width:115
				//split: true
			  },
			  {
				  id : 'gridView',
				  title:'<div><div style="float:left">码单明细</div><div id="divHeji" style="float:right;color:green;font-size:13px;padding-right:70px;"></div></div>',
				  collapsible: false,
				  region:'center',
				  margins: '-2 -2 -2 -2',
				  layout:'fit',
				  contentEl: 'tab',
				  autoScroll: true
				}]
		  };

        var viewport = new Ext.Viewport({
            layout: 'border',
            items: [southItem,centerItem]
        });
		//页面布局end
	//禁止回车键提交
	$('#form1').keydown(function(e){
		if(e.keyCode==13){
			if(e.target.type!='textarea')event.returnValue=false;
		}
	});
	/*
	*获取最大的卷号，用于判断共需多少页，每页100个卷号，每100个卷号用一个层作为导航
	*左侧菜单栏加载导航信息，判断需要加载的个数
	*/
	var maxPi=0;
	if(_cache){
		for(var k in _cache){
			if(isNaN(parseInt(k)))continue;
			if(!_cache[k])continue;
			if(_cache[k].number>maxPi)maxPi=parseInt(_cache[k].number);
		}
	}
	if(maxPi>0)page=Math.ceil(maxPi/100);
	//加载层******************
	for(var i=0;i<page;i++){
		var div='<div class="div_caidan">'+(i*100+1)+'—'+(i*100+100)+'</div>';
		$('#caidan').append(div);
	}
	/*
	*end************************************
	*/
	/////////////////////////////////////////////////////////////
	//加载码单列表
	getMadanList();
	//卷号选择菜单的事件
	$('.div_caidan').live('mouseover',function(){
		//如果该div 被选中，则不作处理
		// if(this.style.background=='#f0f061')return;
		// this.style.background='#dedede';
		this.style.fontWeight='bold';
	});
	$('.div_caidan').live('mouseout',function(){
		//如果该div 被选中，则不作处理
		// if(this.style.background=='#f0f061')return;
		// this.style.background='#ffffff';
		this.style.fontWeight='';
	});
	$('.div_caidan').live('click',function(){
		clear();
		this.style.background='#f0f061';
		//改变卷号的值并加载对应的码单明细
		var strnum=$(this).html();
		var num=parseInt(strnum.substring(0,strnum.indexOf('—')));
		selectNum(num);
		getDataBynumber(num);
		$(this).attr('active',true);
	});
	$('.div_caidan:first').click();
	//+100
	$('#addMenuLink').click(function(){
		for(var i=0;i<5;i++){
			addMenu();
		}
	});
	
	//设置卷号,修改缓存
	$('[name="cntFormat[]"],[name="cnt_M[]"]').live('change',function(){
			var pos=$('[name="'+$(this).attr('name')+'"]').index(this);
			var number=$('[name="number[]"]').eq(pos).val();
			changeCache(pos,number-1);
			
			getHeji();
	});
	//设置卷号,修改缓存
	$('[name="lot[]"]').live('change',function(){
			var pos=$('[name="lot[]"]').index(this);
			var number=$('[name="number[]"]').eq(pos).val();
			changeCache(pos,number-1);
	});
	
	//加载前100卷号的数据
	getDataBynumber(1);
	
	//初始化合计信息
	getHeji();
});
//清空菜单颜色
function clear(){
	$('.div_caidan').each(function(){
		this.style.background='#ffffff';
	});
	$('.div_caidan').attr('active','');
}
//添加菜单
function addMenu(){
	var strnum=$('.div_caidan:last').html();
	var num=parseInt(strnum.substr(strnum.indexOf('—')+1))+1;
	//添加新的层
	var div='<div class="div_caidan">'+num+'—'+(num+99)+'</div>';
	$('#caidan').append(div);
}

//加载码单明细
function getMadanList(){
	//载入新数据
	var t = [];
	var tJuan =0;
	var tCnt =0;
	var page =1;
	//加载码单
	for(var ii=0;ii<page;ii++) {
		t.push("<div id='divPage'>");
		for(var j=0;j<5;j++) {
			t.push("<div id='divBlock'>");
			//每20卷卷合计和数量合计
			var _s=0;
			var _j=0;
			for(var k=0;k<20;k++) {
				var i = ii*100+j*20+k;

				t.push("<div id='divDuan'>");
				//卷号
				t.push("<div class='j'>");
				t.push("<input name='number[]' readonly value='"+(i+1)+"' class='juan form-control'/>");
				t.push("</div>");

				//数量
				t.push("<div class='s'>");
				//debugger;
				t.push("<input name='cntFormat[]' value='' class='cnt form-control' onkeydown='moveNext(event,this)'/>");
				t.push("</div>");

				//数量
				t.push("<div class='s'>");
				//debugger;
				t.push("<input name='cnt_M[]' value='' class='cntM form-control' onkeydown='moveNext(event,this)'/>");
				t.push("</div>");

				//质量
				t.push("<div class='l'>");
				t.push("<input name='lot[]' value='' onclick='this.select()' class='lot form-control' onkeydown='moveNext(event,this)'/>");
				//其他按钮
				//t.push("<span style='background-color:lightblue; width:10px; color:red; font-size:12px; cursor:pointer'>×</span>");
				t.push("</div>");
				t.push("</div>");//end divDuan

			}
			t.push("</div>");//end divBlock
		}
		t.push("</div>");
	}
	var headArr=[];
	for(var ib=0;ib<5;ib++){
		headArr.push("<div class='headDuan'><div class='j form-control'>卷号</div><div class='s form-control'>数量Kg</div><div class='s form-control'>数量M</div><div class='l form-control'>lot#</div></div>");
	}
	var divHtml="<div class='classHead'>"+headArr.join('')+"</div>";
	divHtml+=t.join('');
	//加载到div
	$('#tab').html(divHtml);


	//鼠标放在数据上面，title显示数据
	$('.cnt,.cntM').mouseover(function(){
		var strCnt = $(this).val();
		if(strCnt.indexOf('+')<=0){
			$(this).attr('title','');return;
		}
		$(this).attr('title',strCnt+'='+getHeSplitStr(strCnt));
	});

	//聚焦
	$('.cnt:first').focus();

	//禁止只读控件tab键聚焦
	$('input[readonly]').attr('tabindex',-1);
}
//设置键盘方向键
function moveNext(e,o) {
	var name=o.name;
	var i=$('[name="'+name+'"]').index(o);
	var pos=-1;
	//alert(pos);
	if(e.keyCode==37) {//左
		pos = i-20;
	} else if(!e.altKey&&e.keyCode==38) {//上
		pos = i-1;
	} else if(e.keyCode==39) {//右
		pos = i+20;
	} else if(!e.altKey&&(e.keyCode==40 || e.keyCode==13)) {//下
		pos = i+1;
	}else if(e.altKey&&e.keyCode==13) {//下
		pos = i+1;
		name='cntFormat[]';
	} else if(e.altKey&&(e.keyCode==40 || e.keyCode==13)){
		//获取当前被选中的菜单
		var page=$('.div_caidan').index($('.div_caidan[active=true]'));
		if($('.div_caidan')[page+1]){
			$(o).change();
			$('.cnt:first').focus();
			$('.div_caidan').eq(page+1).click();
		}
		return false;
	}else if(e.altKey&&e.keyCode==38){
		//获取当前被选中的菜单
		var page=$('.div_caidan').index($('.div_caidan[active=true]'));
		if($('.div_caidan')[page-1]){
			$(o).change();
			$('.cnt:first').focus();
			$('.div_caidan').eq(page-1).click();
		}
		return false;
	}
	if(pos>-1) {
		if(pos>99) return false;
		// alert(o.name);
		document.getElementsByName(name)[pos].focus();
		return false;
	}
	return true;
}

//得到总和
function getTotal(){
	var cntHeji=0;
	var cntDuan=0;
	for(var t in _cache){
		if(isNaN(parseInt(t)))continue;
		if(!_cache[t])continue;
		if(_cache[t].cnt==0 || _cache[t].cnt=='')continue;
		var _t=_cache[t].cnt;
		cntHeji += parseFloat(_t||0);
		
		if(_t!='')cntDuan++;
	}
	return {cnt:cntHeji,cntDuan:cntDuan};
}
//修改缓存
function changeCache(i,p){
	if(!_cache)_cache=[];
	if(!_cache[p])_cache[p]={"id":'',"ruku2proId":'',"cnt":'',"cntFormat":'','cnt_M':'','cntM':'',"number":'',"lot":''};
	var _t=_cache[p];
	_t.cntFormat=$('[name="cntFormat[]"]').eq(i).val();
	_t.number=$('[name="number[]"]').eq(i).val();
	_t.cnt_M=$('[name="cnt_M[]"]').eq(i).val();
	_t.lot=$('[name="lot[]"]').eq(i).val();
	//合计
	_t.cnt=getHeSplitStr(_t.cntFormat);
	_t.cntM=getHeSplitStr(_t.cnt_M);
	// debugger;
}

/*
* 输入字符串形式：15+25+45，自动计算合计
*/
function getHeSplitStr(str){
	var temp = str.split('+');
	var cntHeji=0;
	for(var j=0;temp[j];j++) {
		cntHeji += parseFloat(temp[j]||0);
	}
	return cntHeji;
}
//选择批号时改变卷号的值
function selectNum(num){
	$('[name="number[]"]').each(function(){
			this.value=num;
			num++;
	});	
}

//加载数据，以开始的number开始加载
function getDataBynumber(num){
	var pos=num-1;
	//清空当前值
	$('[name="cntFormat[]"]').attr('value','');
	$('[name="cnt_M[]"]').attr('value','');
	$('[name="lot[]"]').attr('value','');
	$('[name="lot[]"]').attr('readonly',false);
	$('[name="cntFormat[]"]').attr('readonly',false);
	$('[name="cntFormat[]"]').attr('title','');
	$('[name="cnt_M[]"]').attr('readonly',false);
	$('[name="cnt_M[]"]').attr('title','');
	//重新赋值
	if(!_cache)return false;	
	for(var t in _cache){
		if(!_cache[t])continue;
		if(t>=pos && t<=(pos+99)){
			var _pos=t%100;
			//使用jquery检索导致速度变慢
			document.getElementsByName('cntFormat[]')[_pos].value=_cache[t].cntFormat;
			document.getElementsByName('cnt_M[]')[_pos].value=_cache[t].cnt_M;
			if(_cache[t].readonly){
				document.getElementsByName('cntFormat[]')[_pos].readOnly=true;
				document.getElementsByName('cntFormat[]')[_pos].title="该码单已出库，不能修改";
				document.getElementsByName('cnt_M[]')[_pos].readOnly=true;
				document.getElementsByName('cnt_M[]')[_pos].title="该码单已出库，不能修改";
				document.getElementsByName('lot[]')[_pos].readOnly=true;
			}
			_cache[t].lot=_cache[t].lot==undefined?'':_cache[t].lot;
			document.getElementsByName('lot[]')[_pos].value=_cache[t].lot;
		}
	}
	
}

//求合计
function getHeji(){
	var heji=0;
	var hejiM=0;
	var ma=0;
	for(var t in _cache){
		if(!_cache[t])continue;
		if(isNaN(parseInt(t)))continue;
		heji+=parseFloat(_cache[t].cnt)||0;
		hejiM+=parseFloat(_cache[t].cntM)||0;
		if(_cache[t].cntFormat!='')ma++;
	}
	//合计显示在页面上
	var hejiStr="合计Kg："+"<font color='red'>"+heji.toFixed(2)+"</font>&nbsp;&nbsp;合计M："+"<font color='red'>"+hejiM.toFixed(2)+"</font>&nbsp;&nbsp;卷数<font color='red'>："+ma+"</font>";
	$('#divHeji').html(hejiStr);
}
//返回给父窗口
//通过ajax 保存
/*function saveByAjax(o){
	// debugger;
	var param = {jsonStr:$.toJSON(_cache),'ruku2proId':$('#ruku2proId').val()};
	$(o).attr('disabled',true);
	//debugger;
	var url="?controller=Shengchan_CangkuBu_Cprk&action=SaveMadanByAjax";
	//禁止重复提交
	$.post(url,param,function(json){
		if(json.success!=true){
			alert(json.msg);
		}else{
			window.parent.showMsg("操作完成，请确认");
			window.location.href=window.location.href;
		}
		$(o).attr('disabled',false);
	},'json');
}
*/
function ok(){
	var o=getTotal();
	var obj = {data:$.toJSON(_cache),'ok':1,"cnt":o.cnt,"cntJian":o.cntDuan};
	if(window.opener!=undefined) {
		window.opener.returnValue = obj;
	} else {
		window.returnValue = obj;
	}
	window.close();	
}
</script>
<style type="text/css">
body{ text-align:left;}
input{ height: 24px !important; min-width: 40px; padding-left: 3px !important; padding-right: 2px !important;}
td,div {font-size:12px; white-space:nowrap; white-space:nowrap;}
#main {margin: 10px 0px 0px 10px; width:1075px;}
.div_caidan{width:100%; border:0px; float:left; font-size:14px; color:#00F; padding:3px 0 0 10px; height:22px; border-bottom:1px solid #bbbbbb; cursor:pointer;}
.j {width:42px; float:left;border:0px solid #000; margin-top: 2px;}
.s {width:54px; float:left;border:0px solid #000; margin-top: 2px;}
.l {width:58px; float:left;border:0px solid #000; margin-top: 2px;}
.classData {clear:both; margin-top:0px;margin-left:3px;}
#toolbar { text-align:center; width:100%; margin-top:5px; margin-bottom:10px;}
.classHead {width:1075px;clear:both;text-align:left; font-weight:bold;}
.headDuan{width:215px; float:left;}
#divPage {width:1075px; clear:both; overflow: auto;}
#divBlock {width:215px; float:left;}
#divDuan {width:100%; clear:both;}
</style>
{/literal}
</head>
<body>
<form name="form1" id="form1" action="" method="post"  autocomplete="off">
<div id="caidan">
</div>
<div id='tab'>
</div>
<div id="footer">
<table id="buttonTable" align="center">
<tr>
		<td>
		<input type="hidden" value="{$ruku2proId}" id='ruku2proId' name="ruku2proId">
		<input class="btn btn-primary" style="height:28px !important;width:60px !important;" type="button" name="Submit" value='确定' onClick="ok()">
      </td>
	</tr>
</table>
</div>
</form>
</body>
</html>
