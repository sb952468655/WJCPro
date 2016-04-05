<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>码单——打包编辑</title>
<script language="javascript" src="Resource/Script/jquery.js"></script>
<script language="javascript" src="Resource/Script/jquery.validate.js"></script>
<script language="javascript" src="Resource/Script/common.js"></script>
<link href="Resource/Css/validate.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="Resource/Script/ext/resources/css/ext-all.css" />
<script type="text/javascript" src="Resource/Script/ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="Resource/Script/ext/ext-all.js"></script>
<link rel="stylesheet" href="Resource/bootstrap/bootstrap3.0.3/css/bootstrap.css">
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.json.js"}
<script language="javascript">
var _cache={$madanRows};
var page=1;
// _cache=eval('('+window.dialogArguments.data+')');
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
				title:'包号[<a href="javascript:;" title="Alt+N 快捷添加" style="color:green;font-size:13px;" name="addMenuLink" id="addMenuLink" accesskey="N">+20包</a>]',
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
	*获取最大的包号，用于判断共需多少页，每页100个包号，每100个包号用一个层作为导航
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
	if(maxPi>0)page=Math.ceil(maxPi/20);
	//加载层******************
	for(var i=0;i<page;i++){
		var div='<div class="div_caidan">'+(i*20+1)+'—'+(i*20+20)+'</div>';
		$('#caidan').append(div);
	}
	/*
	*end************************************
	*/
	/////////////////////////////////////////////////////////////
	//加载码单列表
	getMadanList();
	//包号选择菜单的事件
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
		//改变包号的值并加载对应的码单明细
		var strnum=$(this).html();
		var num=parseInt(strnum.substring(0,strnum.indexOf('—')));
		selectNum(num);
		getDataBynumber(num);
		$(this).attr('active',true);
	});
	$('.div_caidan:first').click();
	//+100
	$('#addMenuLink').click(function(){
		var strnum=$('.div_caidan:last').html();
		var num=parseInt(strnum.substr(strnum.indexOf('—')+1))+1;
		//添加新的层
		var div='<div class="div_caidan">'+num+'—'+(num+19)+'</div>';
		$('#caidan').append(div);
	});
	
	//设置包号,修改缓存
	$('[name="cntFormat[]"]').live('change',function(){
			var pos=$('[name="cntFormat[]"]').index(this);
			var number=$('[name="number[]"]').eq(pos).val();
			
			//合计
			var temp = $(this).val().split('+');
			var cntHeji=0;
			var cntDuan=0;
			for(var j=0;temp[j];j++) {
				cntHeji += parseFloat(temp[j]||0);
				cntDuan++;
			}
			
			//计算段数与合计
			$('[name="duan[]"]').eq(pos).val(cntDuan);
			$('[name="cnt[]"]').eq(pos).val(cntHeji);
			
			changeCache(pos,number-1);
			
			getHeji();
	});
	
	//加载前100包号的数据
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
		for(var j=0;j<1;j++) {
			t.push("<div id='divBlock'>");
			//每20包包合计和数量合计
			var _s=0;
			var _j=0;
			for(var k=0;k<20;k++) {
				var i = ii*20+j*20+k;

				t.push("<div id='divDuan'>");
				//包号
				t.push("<div class='j'>");
				t.push("<input name='number[]' readonly value='"+(i+1)+"' class='juan form-control'/>");
				t.push("</div>");

				//数量
				t.push("<div class='s'>");
				//debugger;
				t.push("<input name='cntFormat[]' value='' class='cnt form-control' onkeydown='moveNext(event,this)'/>");
				t.push("</div>");

				//质量
				t.push("<div class='l'>");
				t.push("<input name='duan[]' value='' disabled class='duan form-control'/>");
				//其他按钮
				//t.push("<span style='background-color:lightblue; width:10px; color:red; font-size:12px; cursor:pointer'>×</span>");
				t.push("</div>");
				//匹长合计
				t.push("<div class='h'>");
				t.push("<input name='cnt[]' value='' class='cntH form-control' disabled/>");
				t.push("</div>");
				
				t.push("</div>");//end divDuan

			}
			t.push("</div>");//end divBlock
		}
		t.push("</div>");
	}
	var divHtml="<div class='classHead'><div class='j form-control'>包号</div><div class='s form-control'>匹长(支持 '+' 号)</div><div class='l form-control'>段数</div><div class='h form-control'>合计</div></div>";
	divHtml+=t.join('');
	//加载到div
	$('#tab').html(divHtml);

	//聚焦
	$('.cnt:first').focus();
}
//设置键盘方向键
function moveNext(e,o) {
	var i=$('[name="'+o.name+'"]').index(o);
	var pos=-1;
	//alert(pos);
	if(!e.altKey&&e.keyCode==38) {//上
		pos = i-1;
	}else if(!e.altKey&&(e.keyCode==40 || e.keyCode==13)) {//下
		pos = i+1;
	}else if(e.altKey&&(e.keyCode==40 || e.keyCode==13)){
		//获取当前被选中的菜单
		var pos=$('.div_caidan').index($('.div_caidan[active=true]'));
		if($('.div_caidan')[pos+1]){
			$('.div_caidan').eq(pos+1).click();
			$('.cnt:first').focus();
		}
		return;
	}else if(e.altKey&&e.keyCode==38){
		//获取当前被选中的菜单
		var pos=$('.div_caidan').index($('.div_caidan[active=true]'));
		if($('.div_caidan')[pos-1]){
			$('.div_caidan').eq(pos-1).click();
			$('.cnt:first').focus();
		}
		return;
	}

	if(pos>-1) {
		if(pos>19) return false;
		document.getElementsByName(o.name)[pos].focus();
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
	if(!_cache[p])_cache[p]={"id":'',"madanId":'',"cnt":'',"cntFormat":'',"number":'','duan':''};
	var _t=_cache[p];
	_t.cntFormat=$('[name="cntFormat[]"]').eq(i).val();
	_t.number=$('[name="number[]"]').eq(i).val();
	_t.cnt=$('[name="cnt[]"]').eq(i).val();
	_t.duan=$('[name="duan[]"]').eq(i).val();
}
//选择批号时改变包号的值
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
	$('[name="cnt[]"]').attr('value','');
	$('[name="duan[]"]').attr('value','');
	$('[name="cntFormat[]"]').attr('readonly',false);
	$('[name="cntFormat[]"]').attr('title','');
	//重新赋值
	if(!_cache)return false;
	for(var t in _cache){
		if(!_cache[t])continue;
		if(t>=pos && t<=(pos+19)){
			var _pos=t%20;
			document.getElementsByName('cntFormat[]')[_pos].value=_cache[t].cntFormat;
			if(_cache[t].readonly){
				document.getElementsByName('cntFormat[]')[_pos].readOnly=true;
				document.getElementsByName('cntFormat[]')[_pos].title="该码单已出库，不能修改";
			}
			//计算段数
			var duan=_cache[t].duan;
			if(!duan>0){
				var temp = _cache[t].cntFormat.split('+');
				duan=temp.length;
			}
			document.getElementsByName('duan[]')[_pos].value=duan;
			document.getElementsByName('cnt[]')[_pos].value=_cache[t].cnt;
		}
	}
}

//求合计
function getHeji(){
	var heji=0;
	var ma=0;
	for(var t in _cache){
		if(!_cache[t])continue;
		if(isNaN(parseInt(t)))continue;
		heji+=parseFloat(_cache[t].cnt)||0;
		if(_cache[t].cntFormat!='')ma++;
	}
	//合计显示在页面上
	var hejiStr="合计："+"<font color='red'>"+heji.toFixed(2)+"</font>&nbsp;&nbsp;包数<font color='red'>："+ma+"</font>";
	$('#divHeji').html(hejiStr);
}
//返回给父窗口
//通过ajax 保存
function saveByAjax(o){
	var param = {jsonStr:$.toJSON(_cache),'ruku2proId':$('#ruku2proId').val()};
	$(o).attr('disabled',true);
	//debugger;
	var url="?controller=Shengchan_CangkuBu_Cprk&action=SaveMadanByAjax";
	//禁止重复提交
	$.post(url,param,function(json){
		if(json.success!=true){
			alert(json.msg);
			$(o).attr('disabled',false);
			return false;
		}
	},'json');
}

</script>
<style type="text/css">
body{ text-align:left;}
input{ height: 24px !important; min-width: 50px;}
td,div {font-size:12px; white-space:nowrap; white-space:nowrap;}
#main {margin: 10px 0px 0px 10px; width:900px;}
.div_caidan{width:100%; border:0px; float:left; font-size:14px; color:#00F; padding:3px 0 0 10px; height:22px; border-bottom:1px solid #CCC; cursor:pointer;}
.j {width:56px; float:left;border:0px solid #000;margin-top: 2px;}

.s {width:403px; float:left;border:0px solid #000;margin-top: 2px;}

.l {width:63px; float:left;border:0px solid #000;margin-top: 2px;}

.h {width:83px; float:left;border:0px solid #000;margin-top: 2px;}

.classData {clear:both; margin-top:0px;margin-left:3px;}

#toolbar { text-align:center; width:100%; margin-top:5px; margin-bottom:10px;}
.classHead {width:616px;clear:both;text-align:left; font-weight:bold;}
#divPage {width:100%; clear:both; height:400px;}
#divBlock {width:616px; float:left;}
#divDuan {width:616px; clear:both;}

#divTol20 { width:590px; height:20px;background-color:#FF0; clear:both;}
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
		<input type="button" id="Submit" name="Submit" value='确定' onClick="ok()">
	  <input type="button" id="Back" name="Back" value='取消' onClick="window.close();">
      </td>
	</tr>
</table>
</div>
</form>
</body>
</html>
