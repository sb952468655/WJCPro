<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{literal}
<style type="text/css">
td{
	padding:3px 7px 2px 7px;
}
table{
	width:700px;
	text-align:left;
	padding-left:2px;
	}
#t001{
	border:#000 1px solid;
	empty-cells:show; 
	border-collapse:collapse;

	}	
#t001 tr td{
	border:#000 1px solid;
	height:40px;
	padding-left:3px;
	}
.table{
	border:#000 1px solid;
	text-align:center;
	}
.table tr td{
	width:50px;
	height:20px;
	text-align:left;
	
	}

</style>
{/literal}
</head>

<body>
<h1 align="center">生产计划单</h1>

<table align="center">
    <tr>
        <td width="73" align="right">订单编号:</td>
        <td align="left">{$rt.orderCode}</td>
        <td width="73" align="right">工序名称:</td>
        <td align="left">{$rt.gongxuName}</td>
    </tr>
    <tr>
        <td align="right">计划单号:</td>
        <td align="left">{$rt.planCode}</td>
        <td >加工户:</td>
        <td align="left">{$rt.compName}</td>
    </tr>
    <tr height="20">
    </tr>
</table >

<table id="t001" align="center">
    <tr>
        <td>品名</td>
        <td>门幅(M)</td>
        <td>克重(g/m<sup>2</sup>)</td>
        <td>缩率</td>
        <td>颜色（花色）</td>
        <td>数量</td>
        <td>单位</td>
        <td>交期</td>
        <td>备注</td>
    </tr>
    {foreach from=$ret item=item}  
    <tr>
        <td>{$item.pinzhong}</td>
        <td>{$item.menfu}</td>
        <td>{$item.kezhong}</td>
        <td></td>
        <td>{$item.color}</td>
        <td>{$item.cntShengchan}</td>
        <td>{$item.unit}</td>
        <td>{$item.dateJiaohuo}</td>
        <td>{$item.memo}</td>
    </tr>
    {/foreach}
</table>

<table align="center">
    <tr height="20"></tr>
    <tr>
    	<td>要求</td>
    </tr>
</table>

<table class="table" align="center">
    <tr>
    	<td width="208">
            <input type="checkbox"/> 
            <span class="spans">是否需要批条</span>
                 
        </td>
    </tr>
    <tr>
    	<td>
            <input type="checkbox"/>
            <span class="spans">是否需要跑米数</span>
            
        </td>       
    </tr>
    <tr>
    	<td>
            <input type="checkbox"/>
            <span class="spans">是否需要大货样</span>
            
        </td>
       
    </tr>
    <tr>
    	<td>
            <input type="checkbox"/>
            <span class="spans">是否需要测试样</span>
            
        </td>
    </tr>
</table>


<table align="center">
    <tr height="20"></tr>
    <tr>
    	<td>备注</td>
    </tr>
</table>
<table class="table" align="center">
    <tr>
    	<td style="height:100px;" valign="top">
        {$rt.planMemo}</td>
    </tr>
</table>

</body>
</html>
