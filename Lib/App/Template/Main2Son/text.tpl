<div class="col-xs-4">
    <div class="form-group">
        <label for="{$item.name|default:$key}" class="col-sm-3 control-label lableMain lableMain">{$item.title}:</label>
        <div class="col-sm-9">
        	{webcontrol type='bttext' itemName=$item.name|default:$key value=$item.value disabled=$item.disabled readonly=$item.readonly addonPre=$item.addonPre addonEnd=$item.addonEnd}
        </div>
    </div>
</div>