<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$title}</title>
{webcontrol type='LoadJsCss' src="Resource/Script/jquery.js"}
</head>
{literal}
<script>
$(function(){
  $('table').mouseover(function(){
    $(this).find('.tdTitle13').css({'font-weight':'bold'});
  });
   $('table').mouseout(function(){
    $(this).find('.tdTitle13').css({'font-weight':''});
  });
})
</script>
{/literal}
<body>
<form name="form1" id='form1' method="post" action="{url controller=Trade_Chengben action='saveShenhe'}">
<div id='divHtml'>
  {literal}
  <style type="text/css">
  table{table-layout: fixed;}
  .redM{color:#900}
  .noBorder{ border:0px; width:110px; font-size:15px}
  .button{height:22px; width:60px; border:1px; border-color:#666;}
  input{ border-bottom-width:1px;border-top-width:0px;border-left-width:0px;border-right-width:0px; width:80px; border-color:#000}
  td { padding: 5px;}
  .trRow td{height:25px;}
  #main{min-width:780px; margin-left: auto; margin-right: auto; width: 80%;}
  </style>
  {/literal}
  <div id="main">
 <center><h2>{$title}</h2></center>
    <table width="100%" style="BORDER-COLLAPSE: collapse" borderColor=#000000 border="2" align="center" cellpadding="2" cellspacing="2">
        <tr>
          <td>订单编号：{$order.orderCode}</td>
          <td>订单日期：{$order.orderDate}</td>
          <td>业务员：{$order.Trader.employName}</td>
        </tr>
        <tr>
          <td>客户名称：{$order.Client.compName}</td>
          <td>客户合同号：{$order.clientOrder}</td>
          <td>币种：{$order.bizhong}</td>
        </tr>
  
         <tr>
          <td><span class="tdTitle13">应收金额：{$order.yingshou}</span></td>     
          <td><span class="tdTitle13">成本金额：{$order.chengben}</span></td>
          <td><span class="tdTitle13">利润：{$order.lirun}</span></td>
        </tr>
      </table>
      {*订单明细*}
      <br />
      <table width="100%" style="BORDER-COLLAPSE: collapse" borderColor=#000000 border="2" align="center" cellpadding="2" cellspacing="2">
          <tr style="font-weight:bold;">
            <td colspan="7">订单明细</td>
          </tr>
          <tr>
            <td align="center">产品编号</td>
            <td align="center">品名</td>
            <td align="center">规格</td>
            <td align="center">颜色</td>
            <td align="center">数量</td>
            <td align="center">单价</td>
            <td align="center"><span class="tdTitle13">金额</span></td>
          </tr>
          {foreach from=$order.Products item=pro}
          <tr class='trRow'>
            <td align="center">{$pro.proCode}</td>
            <td align="center">{$pro.pinzhong}</td>
            <td align="center">{$pro.guige}</td>
            <td align="center">{$pro.color}</td>
            <td align="center">{$pro.cntYaohuo|cat:$pro.unit}</td>
            <td align="center">{$pro.danjia}</td>
            <td align="center"><span class="tdTitle13">{$pro.money}</span></td>
          </tr>
          {/foreach}
      </table>
      {*出库明细*}
      <br />
      <table width="100%" style="BORDER-COLLAPSE: collapse" borderColor='#000000' border="2" align="center" cellpadding="2" cellspacing="2">
          <tr style="font-weight:bold;">
            <td colspan="9">出库明细</td>
          </tr>
          <tr>
           <td align="center">产品编号</td>
            <td align="center">品名</td>
            <td align="center">规格</td>
            <td align="center">出库单号</td>
            <td align="center">出库日期</td>
            <td align="center">颜色</td>
            <td align="center">数量</td>
            <td align="center">单价</td>
            <td align="center"><span class="tdTitle13">金额</span></td>
          </tr>
          {foreach from=$chuku item=pro}
          <tr class='trRow'>
            <td align="center">{$pro.proCode}</td>
            <td align="center">{$pro.pinzhong}</td>
            <td align="center">{$pro.guige}</td>
            <td align="center">{$pro.chukuCode}</td>
            <td align="center">{$pro.chukuDate}</td>
            <td align="center">{$pro.color}</td>
            <td align="center">{$pro.cnt}</td>
            <td align="center">{$pro.danjia}</td>
            <td align="center"><span class="tdTitle13">{$pro.money}</span></td>
          </tr>
          {/foreach}
      </table>
      {*采购成本明细*}
      <br />
      <table width="100%" style="BORDER-COLLAPSE: collapse" borderColor='#000000' border="2" align="center" cellpadding="2" cellspacing="2">
          <tr style="font-weight:bold;">
            <td colspan="11">用纱明细</td>
          </tr>
          <tr>
            <td align="center">产品编号</td>
            <td align="center">品名</td>
            <td align="center">规格</td>
            <td align="center">供应商</td>
            <td align="center">类别</td>
            <td align="center">日期</td>
            <td align="center">批号</td>
            <td align="center">数量</td>
            <td align="center">单价</td>
            <td align="center"><span class="tdTitle13">金额</span></td>
            <td align="center">状态</td>
          </tr>
          {foreach from=$caigou item=pro}
          <tr class='trRow'>
            <td align="center">{$pro.proCode}</td>
            <td align="center">{$pro.pinzhong}</td>
            <td align="center">{$pro.guige}</td>
            <td align="center">{$pro.compName}</td>
            <td align="center">{$pro.kind}</td>
            <td align="center">{$pro.chukuDate}</td>
            <td align="center">{$pro.pihao}</td>
            <td align="center">{$pro.cnt|cat:$pro.unit}</td>
            <td align="center">{$pro.danjia}</td>
            <td align="center"><span class="tdTitle13">{$pro.money}</span></td>
            <td align="center">{$pro.isOver}</td>
          </tr>
          {/foreach}
      </table>
      {*加工成本明细*}
      <br />
      <table width="100%" style="BORDER-COLLAPSE: collapse" borderColor='#000000' border="2" align="center" cellpadding="2" cellspacing="2">
          <tr style="font-weight:bold;">
            <td colspan="11">加工明细</td>
          </tr>
          <tr>
            <td align="center">产品编号</td>
            <td align="center">品名</td>
            <td align="center">规格</td>
            <td align="center">加工户</td>
            <td align="center">工序名称</td>
            <td align="center">开始日期</td>
            <td align="center">结束日期</td>
            <td align="center">最终数量</td>
            <td align="center">加工单价</td>
            <td align="center"><span class="tdTitle13">金额</span></td>
            <td align="center">状态</td>
          </tr>
          {foreach from=$jiagong item=pro}
          <tr class='trRow'>
             <td align="center">{$pro.proCode}</td>
            <td align="center">{$pro.pinzhong}</td>
            <td align="center">{$pro.guige}</td>
            <td align="center">{$pro.compName}</td>
            <td align="center">{$pro.gongxuName}</td>
            <td align="center">{$pro.genzongDate}</td>
            <td align="center">{$pro.overDate}</td>
            <td align="center">{$pro.cnt|cat:$pro.unit}</td>
            <td align="center">{$pro.danjia}</td>
            <td align="center"><span class="tdTitle13">{$pro.money}</span></td>
            <td align="center">{$pro.isOver}</td>
          </tr>
          {/foreach}
      </table>
    </div>
  </div>
</form>
</body>
</html>
