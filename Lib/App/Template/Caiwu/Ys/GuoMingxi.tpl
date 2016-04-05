<!--其他费用信息-->
<div class="panel panel-info">
  <div class="panel-heading"><h3 class="panel-title" style="text-align:left;">{$otherInfo|default:'其他信息编辑'}</h3></div>
  <div class="panel-body" style="overflow:auto;max-height:320px;">
    <div class="table-responsive" style="margin-top:-15px;">
      <table class="table table-condensed table-striped" id='table_else'>
        <thead>
          <tr>
            {assign var=i value=0}
	        {foreach from=$qitaSon item=item key=key}
	        {assign var=i value=$i+1}
	        {if $item.type!='bthidden'}
	          {*如果是第一列,判断$firstColumn.head,再判断是否btnRemove*}
	          {if $i==1}
	            {*如果有特殊表头信息，需要加载特殊表头信息*}
	            {if $firstColumn2.head}
	              {if $firstColumn2.head.type}
	                <th>{webcontrol type=$firstColumn2.head.type title=$firstColumn2.head.title url=$firstColumn2.head.url}</th>
	              {else}
	                <th style='white-space:nowrap;'>{$firstColumn2.head.title}</th>
	              {/if}
	            {elseif $item.type=='btBtnRemove'}{*不存在表头信息，处理默认的信息*}
	              <th>{webcontrol type='btBtnAdd'}</th>
	            {else}
	              <th style='white-space:nowrap;'>{$item.title}</th>
	            {/if}
	          {else}
	              <th style='white-space:nowrap;' {if $item.colmd>0}class="col-md-{$item.colmd}"{/if}>{$item.title}</th>
	          {/if}  
	        {/if}
	        {/foreach}
          </tr>   
        </thead>
        <tbody id='t_body'>
          {foreach from=$rowsSon2 item=item1 key=key1}
          <tr class='trRow' style="height:40px;">
            {foreach from=$qitaSon item=item key=key}
              {if $item.type!='bthidden'}
              <td>{webcontrol 
                      type=$item.type
                      value=$item1[$key].value
                      kind=$item.kind
                      itemName=$item.name
                      readonly=$item.readonly
                      disabled=$item.disabled
                      model=$item.model
                      options=$item.options
                      checked=$item1[$key].checked
                      url=$item.url 
                      textFld=$item.textFld
                      hiddenFld=$item.hiddenFld
                      text=$item1[$key].text
                      inTable=$item.inTable 
                      condition=$item.condition
                      dialogWidth=$item.dialogWidth 
                      width=$item.width
                      style=$item.style
              }</td>
              {else}
                {webcontrol type=$item.type value=$item1[$key].value itemName=$item.name readonly=$item.readonly disabled=$item.disabled}
              {/if}
            {/foreach}
          </tr>  
          {/foreach}    
        </tbody>
      </table>
    </div>
  </div>
  </div>
</div>