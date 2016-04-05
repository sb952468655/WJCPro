<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
<link href="Resource/Css/Print.css" type="text/css" rel="stylesheet" />
{literal}
<script language="javascript">
function prnbutt_onclick() { 
	window.print(); 
	return true; 
} 

function window_onbeforeprint() { 
	prn.style.visibility ="hidden"; 
	return true; 
} 

function window_onafterprint() { 
	prn.style.visibility = "visible"; 
	return true; 
}
</script>
<style type="text/css">
table {border-color:#FFF;border-style:solid;border-collapse:collapse}
.tablec{border-width:1px;border-color:#000000;border-style:solid;border-collapse:collapse}
.tablec tr td{border-width:1px;border-color:#000000;border-style:solid;border-collapse:collapse; text-align:center; padding:3px 0 2px 0;}

td {font-size:13px;color:#000000; line-height:130%;font-family:"arial,verdana,sans-serif,宋体"}
.td1 {border:1px solid;font-size:12px;color:#000000;font-family:"arial,verdana,sans-serif,宋体";border-top:1px solid}

.tda {font-size:12px;color:#000000;font-family:"arial,verdana,sans-serif,宋体";}
.tda1 {border:1px solid;font-size:12px;color:#000000;font-family:"arial,verdana,sans-serif,宋体";border-top:1px solid}

.tdb {font-size:13px;color:#000000;font-family:"arial,verdana,sans-serif,宋体"}
.tdb1 {border:1px solid;font-size:14px;color:#000000;font-family:"arial,verdana,sans-serif,宋体";border-top:1px solid}

.tdc {font-size:15px;color:#000000;font-family:"arial,verdana,sans-serif,宋体"}
.tdc1 {border:1px solid;font-size:15px;color:#000000;font-family:"arial,verdana,sans-serif,宋体";border-top:1px solid}

.tdd {font-size:18pt;color:#000000;font-family:"arial,verdana,sans-serif,宋体"}
.tdd1 {border:1px solid;font-size:16pt;color:#000000;font-family:"arial,verdana,sans-serif,宋体";border-top:1px solid}

.tde {font-size:25px;color:#000000;font-family:"arial,verdana,sans-serif,宋体"}
.tde1 {border:1px solid;font-size:25px;color:#000000;font-family:"arial,verdana,sans-serif,宋体";border-top:1px solid}

.tdf {font-size:30px;color:#000000;font-family:"arial,verdana,sans-serif,宋体"}
.tdf1 {border:1px solid;font-size:30px;color:#000000;font-family:"arial,verdana,sans-serif,宋体";border-top:1px solid}
.canedit{ border:0px;min-width:210px;overflow-x:visible; cursor:pointer; font-size:12px;font-family:"arial,verdana,sans-serif,宋体";}
.canedit2{ border:0px; border-bottom:1px solid #000; width:650px;cursor:pointer;font-size:12px;font-family:"arial,verdana,sans-serif,宋体";}
.tdtxt{ line-height:20px;vertical-align: top;}
.tdHead{ line-height:20px;vertical-align: top; white-space: nowrap; height: 28px;}
</style>
{/literal}
</head>
<body onafterprint="return window_onafterprint()" onbeforeprint="return window_onbeforeprint()">
<table width="710px"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td align="center" class="tdd">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="tdd">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" class="tdd"><b>购销合同</b></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	  <table width="100%"  border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="60%">甲方（供方）：{$aRow.Head.head}</td>
          <td>合同编号：{$aRow.orderCode|default:'&nbsp;'}</td>
        </tr>
        <tr>
          <td>乙方（需方）：{$aRow.Client.compName|default:'&nbsp;'}</td>
          <td>签订地点：<input type="text" class="canedit" value="常州"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>签订日期：<input type="text" class="canedit" value="{$aRow.orderDate}"></td>
        </tr>
      </table>
      </td>
  </tr>
  <tr><td>第一 购销内容：</td></tr>
  <tr><td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="1" class="tablec">
      <tr align="center">
      {if $aRow.kind=='成布'}
        <td class="tda" align="left"><strong>品种</strong></td>
      {else}
        <td class="tda" align="left"><strong>成分</strong></td>
        <td class="tda" align="left"><strong>纱支</strong></td>
      {/if}
        <td class="tda"><strong>规格</strong></td>
        <td class="tda"><strong>颜色</strong></td>
        <td class="tda"><strong>门幅(m)</strong></td>
        <td class="tda"><strong>克重(g/㎡)</strong></td>
        <td class="tda"><strong>单位</strong></td>
        <td class="tda"><strong>数量</strong></td>
		<td class="tda"><strong>单价（<span class="tdb">元</span>）</strong></td>
		<td align="right" class="tda"><strong>金额（<span class="tdb">元</span>）</strong></td>
        <td class="tda"><strong>交货日期</strong></td>
      </tr>
      {foreach from=$aRow.Products item=item}
      <tr align="center">
      {if $aRow.kind=='成布'}
        <td valign="top" class="tda" align="left">{$item.pinzhong|default:'&nbsp;'}</td>
      {else}
        <td valign="top" class="tda" align="left">{$item.zhonglei|default:'&nbsp;'}</td>
        <td valign="top" class="tda">{$item.proName|default:'&nbsp;'}</td>
      {/if}
        
        <td class="tda">{$item.guige|default:'&nbsp;'}</td>
        <td class="tda">{$item.color|default:'&nbsp;'}</td>
        <td class="tda">{$item.menfu|default:'&nbsp;'}</td>
        <td class="tda">{$item.kezhong|default:'&nbsp;'}</td>
        <td class="tda">{$item.unit|default:'&nbsp;'}</td>
        <td class="tda">{$item.cntYaohuo|default:'&nbsp;'}</td>
        <td class="tda">{$item.danjia|default:'&nbsp;'}</td>
        <td class="tda">{$item.money|default:'&nbsp;'}</td>
        <td align="right" class="tda">{$item.dateJiaohuo|default:'&nbsp;'}</td>
      </tr>
	 {/foreach}
      <tr align="center">
        <td colspan="2" class="tdb"><span class="tda"><b>合计金额（大写）</b></span></td>
        <td colspan="9" style=" text-align:left; padding-left:5px;"><b>{$aRow.moneyUpper}</b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
    <table width="100%"  border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td class='tdHead'>第二 质量标准：</td><td class='tdtxt'>{$aRow.orderItem1}</td>
      </tr>
      <tr>
      <td class='tdHead'>第三 包装标准：</td><td  class='tdtxt'>{$aRow.orderItem2}</td>
      </tr>
      <tr>
        <td class='tdHead'>第四 交货数量：</td><td class='tdtxt'>{$aRow.orderItem3}</td>
      </tr>
      <tr>
        <td class='tdHead'>第五 交货方式：</td><td class='tdtxt'>{$aRow.orderItem4}</td>
      </tr>
       <tr>
        <td class='tdHead'>第六 交货时间：</td><td class='tdtxt'>{$aRow.orderItem5}</td>
      </tr>
      <tr>
        <td class='tdHead'>第七 结算方式：</td><td class='tdtxt'>{$aRow.orderItem6}</td>
      </tr>
        <tr>
        <td class='tdHead'>第八 争议解决：</td><td class='tdtxt'>{$aRow.orderItem7}</td>
      </tr> 
       <tr>
        <td class='tdHead'>第九  </td><td>本合同一式两份，由供、需方各执一份，双方签名盖章有效。</td>
      </tr> 
       <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
     
    </table></td>
  </tr>
  <tr>
    <td>
      <table width="100%"  border="0" cellspacing="0" cellpadding="1">
       <tr>
        <td width="50%">甲方信息：{$aRow.Head.head}</td>
        <td>乙方信息：{$aRow.Client.compName}</td>
      </tr>
      <tr>
        <td>地址：{$aRow.Head.address}</td>
        <td>地址：{$aRow.Client.address}</td>
      </tr>
      <tr>
        <td>法定代表人：<input type="text" class="canedit" value="{$aRow.Head.fadingPeo}"></td>
        <td>法定代表人：<input type="text" class="canedit" value="{$aRow.Client.people}"></td>
      </tr>
      <tr>
        <td>开户银行：{$aRow.Head.bankName}</td>
        <td>开户银行：{$aRow.Client.bankName}</td>
      </tr>
      <tr>
        <td>账号：{$aRow.Head.accountId}</td>
        <td>账号：{$aRow.Client.accountId}</td>
      </tr>
       <tr>
        <td>电话：<input type="text" class="canedit" value="{$aRow.Head.tel}"></td>
        <td>电话：<input type="text" class="canedit" value="{$aRow.Client.tel}"></td>
      </tr>
      <tr>
        <td>传真：<input type="text" class="canedit" value="{$aRow.Head.fax}"></td>
        <td>传真：<input type="text" class="canedit" value="{$aRow.Client.fax}"></td>
      </tr>
      <!--
      <tr>
        <td>邮政编码：<input type="text" class="canedit" value="{$aRow.Head.zipcode}"></td>
        <td>邮政编码：<input type="text" class="canedit" value=""></td>
      </tr>
      -->
      </table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%"  border="0" cellpadding="1" cellspacing="0">
      <tr>
        <td width="60%">甲方签字盖章</td>
        <td>乙方签字盖章</td>
      </tr>
      <tr>
        <td>委托代理人：<input type="text" style="width:100px; border:0px;" value="{$aRow.Trader.employName}" /></td>
        <td>委托代理人：<input type="text" style="width:100px; border:0px;" value=""></td>
      </tr>
        <tr>
        <td>时间：&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" style="width:100px; border:0px;" value="" /></td>
        <td>时间：&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" style="width:100px; border:0px;" value="" /></td>
      </tr>
    </table></td>
  </tr>
</table>
<div id="prn" align="center">
<input type="button" id="button1" name="button1" value="打印" onclick="window_onbeforeprint();prnbutt_onclick();window_onafterprint();" />
</div>
</body>
</html>
