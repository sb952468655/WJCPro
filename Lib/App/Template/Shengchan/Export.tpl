<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Created>1996-12-17T01:32:42Z</Created>
  <LastSaved>2011-04-19T08:27:23Z</LastSaved>
  <Version>11.9999</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <RemovePersonalInformation/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>4530</WindowHeight>
  <WindowWidth>8505</WindowWidth>
  <WindowTopX>480</WindowTopX>
  <WindowTopY>120</WindowTopY>
  <AcceptLabelsInFormulas/>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="12"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s30">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>{*
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>*}
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="18" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s31">
   <Alignment ss:Horizontal="Left" ss:Vertical="Bottom"/>
   <Borders>
   {*
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
    *}
   </Borders>
  </Style>
  <Style ss:ID="s32">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   
  </Style>
  <Style ss:ID="s33">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="11" ss:Bold="1"/>
  </Style>
  
  <Style ss:ID="s37">
   <Borders>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="12" ss:Bold="1"/>
   <Interior/>
  </Style>
   <Style ss:ID="s38">
   <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="10" ss:Bold="1"/>
   <Interior/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet1">
  <Table ss:DefaultColumnWidth="44" ss:DefaultRowHeight="13.7">
  <Column ss:AutoFitWidth="0" ss:Width="30"/>
   <Column ss:Index="4" ss:AutoFitWidth="0" ss:Width="38"/>
   <Column ss:AutoFitWidth="0" ss:Width="30"/>
   <Column ss:Index="8" ss:AutoFitWidth="0" ss:Width="38"/>
   <Column ss:AutoFitWidth="0" ss:Width="30"/>
   <Column ss:Index="12" ss:AutoFitWidth="0" ss:Width="38"/>
   <Column ss:AutoFitWidth="0" ss:Width="30"/>
   <Column ss:Index="16" ss:AutoFitWidth="0" ss:Width="38"/>
   <Column ss:AutoFitWidth="0" ss:Width="30"/>
   <Column ss:Index="20" ss:AutoFitWidth="0" ss:Width="38"/>
  {foreach from=$madan item=row key=key}{*花型循环*}
   <Row ss:Height="24">
    <Cell ss:MergeAcross="19" ss:StyleID="s30"><Data ss:Type="String">{$name}码单</Data></Cell>
   </Row>
   <Row>
    <Cell ss:MergeAcross="6" ss:StyleID="s31"><ss:Data ss:Type="String" xmlns="http://www.w3.org/TR/REC-html40">客户:<B>{$row.compName}</B></ss:Data></Cell>
     <Cell ss:MergeAcross="6" ss:StyleID="s31"><ss:Data ss:Type="String" xmlns="http://www.w3.org/TR/REC-html40">订单号:<B>{$row.orderCode}</B></ss:Data></Cell>
     <Cell ss:MergeAcross="5" ss:StyleID="s31"><ss:Data ss:Type="String" xmlns="http://www.w3.org/TR/REC-html40">日期:<B>{$row.chukuDate}</B></ss:Data></Cell>
   </Row>
   <Row>
   <Cell ss:MergeAcross="6" ss:StyleID="s31"><ss:Data ss:Type="String" xmlns="http://www.w3.org/TR/REC-html40">规格:<B>{$row.guige}</B></ss:Data></Cell>
    <Cell ss:MergeAcross="6" ss:StyleID="s31"><ss:Data ss:Type="String" xmlns="http://www.w3.org/TR/REC-html40">品种:<B>{$row.pinzhong}</B></ss:Data></Cell> 
    <Cell ss:MergeAcross="5" ss:StyleID="s31"><ss:Data ss:Type="String" xmlns="http://www.w3.org/TR/REC-html40">颜色:<B>{$row.color} </B></ss:Data></Cell>  
   </Row>
    {foreach from=$row.Son item=son key=hxId}{*循环码单*}
    <Row>
           {section loop=$exInfo.row name=r}{*5列一行*}
            <Cell ss:StyleID="s33"><Data ss:Type="String">件号</Data></Cell>
            <Cell ss:StyleID="s33"><Data ss:Type="String">数量Kg</Data></Cell>
            <Cell ss:StyleID="s33"><Data ss:Type="String">数量M</Data></Cell>
            <Cell ss:StyleID="s33"><Data ss:Type="String">lot</Data></Cell>
            {/section}
    </Row>
    {section loop=$exInfo.col name=c}{*40行*}
    {assign var=colNum value=$smarty.section.c.rownum-1}
    <Row ss:Height="12">
        {section loop=$exInfo.row name=r}{*每一行5列*}
        {assign var=rowNum value=$smarty.section.r.rownum-1}
        	<Cell ss:StyleID="s32"><Data ss:Type="String">{$son[$rowNum][$colNum].number}</Data></Cell>
            <Cell ss:StyleID="s32"><Data ss:Type="{$son[$rowNum][$colNum].type|default:'String'}">{$son[$rowNum][$colNum].cntFormat|@trim}</Data></Cell>
            <Cell ss:StyleID="s32"><Data ss:Type="{$son[$rowNum][$colNum].type|default:'String'}">{$son[$rowNum][$colNum].cnt_M|@trim}</Data></Cell>
            <Cell ss:StyleID="s32"><Data ss:Type="String">{$son[$rowNum][$colNum].lot|@trim}</Data></Cell>
            
         {/section}            
   </Row>
   {/section}{*end 40行,下面输出小计行*}
   <Row ss:Height="12">
       {section loop=$exInfo.row name=r}{*5列*}
       {assign var=rowNum2 value=$smarty.section.r.rownum-1}
        <Cell ss:StyleID="s32"><Data ss:Type="String">小计</Data></Cell>
        <Cell ss:StyleID="s32"><Data ss:Type="Number">{$xiaoji[$key][$hxId][$rowNum2].cnt}</Data></Cell>
        <Cell ss:StyleID="s32"><Data ss:Type="Number">{$xiaoji[$key][$hxId][$rowNum2].cntM}</Data></Cell>
        <Cell ss:StyleID="s32"/>
        {/section}
   </Row>
   {/foreach}{*end 分页*}
   <Row ss:AutoFitHeight="0" ss:Height="20">
    <Cell ss:StyleID="s38" ss:MergeAcross="19"><Data ss:Type="String">合计：{$row.cnt_Jian}卷, {$row.cnt_Kg}Kg，{$row.cnt_M}M</Data></Cell>
   </Row>
   {/foreach}{*end 花型*}
   <Row ss:AutoFitHeight="0" ss:Height="10"/>
   {*
   <Row ss:AutoFitHeight="0" ss:Height="20">
        <Cell ss:StyleID="s38" ss:MergeAcross="19"><Data ss:Type="String">总计：{$zongji.cntJian}卷, {$zongji.cnt_Kg}Kg, {$zongji.cnt_M}M</Data></Cell>
       </Row>
       *}
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Layout x:CenterHorizontal="1"/>
    <Header x:Margin="0.51181102362204722"/>
    <Footer x:Margin="0.51181102362204722"/>
    <PageMargins x:Bottom="0.78740157480314965" x:Left="0.11811023622047245"
     x:Right="0.11811023622047245" x:Top="0.78740157480314965"/>
   </PageSetup>
   <Selected/>   
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>15</ActiveRow>
     <ActiveCol>7</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
  
  <PageBreaks xmlns="urn:schemas-microsoft-com:office:excel">
   <RowBreaks>    
    {foreach from=$arrPos item=row key=key}{*花型循环*}
     {foreach from=$row item=num1}{*分页*}
     {assign var=nn value=$nn+1}{*分得页数*}
     {if $nn!=$noP}
     	<RowBreak>        		
	     		<Row>{$num1}</Row>            
    	</RowBreak>  
	{/if}
     {/foreach}
     {/foreach}
   </RowBreaks>
  </PageBreaks>
  
 </Worksheet>
 <Worksheet ss:Name="Sheet2">
  <Table ss:ExpandedColumnCount="0" ss:ExpandedRowCount="0" x:FullColumns="1"
   x:FullRows="1" ss:DefaultColumnWidth="54" ss:DefaultRowHeight="14.25"/>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
 <Worksheet ss:Name="Sheet3">
  <Table ss:ExpandedColumnCount="0" ss:ExpandedRowCount="0" x:FullColumns="1"
   x:FullRows="1" ss:DefaultColumnWidth="54" ss:DefaultRowHeight="14.25"/>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
