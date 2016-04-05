<!--其他费用信息-->
<div class="panel panel-info">
  <div class="panel-heading"><h3 class="panel-title" style="text-align:left;">工序设置</h3></div>
  <div class="panel-body">
  <table class="table table-condensed table-striped" id='table_else'>
    <thead>
      <tr>
        {foreach from=$qitaSon item=item key=key}
        {if $item.type!='bthidden'}
          {if $item.type=='btBtnRemove'}
            <th>{webcontrol type='btBtnAdd'}</th>
          {else}
          <th style='white-space:nowrap;'>{$item.title}</th>
          {/if}
        {/if}
        {/foreach}
      </tr>   
    </thead>
    <tbody>
      {foreach from=$row4sSon item=item1 key=key1}
      <tr class='trRow'>
        {foreach from=$qitaSon item=item key=key}
          {if $item.type!='bthidden'}
          <td>{webcontrol type=$item.type value=$item1[$key].value kind=$item.kind itemName=$item.name readonly=$item.readonly disabled=$item.disabled width=$item.width options=$item.options checked=$item1[$key].checked}</td>
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