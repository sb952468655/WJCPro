<div class="col-xs-4">
    <div class="form-group">
        <label for="{$item.name|default:$key}" class="col-sm-3 control-label lableMain">{$item.title}:</label>
        <div class="col-sm-9">
          {webcontrol type='btcalendar' itemName=$item.name|default:$key value=$item.value disabled=$item.disabled readonly=$item.readonly}
        </div>
    </div>
</div>