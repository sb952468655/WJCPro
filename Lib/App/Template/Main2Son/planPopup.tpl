<div class="col-xs-4">
    <div class="form-group">
        <label for="planCode"  class="col-sm-3 control-label lableMain">{$item.title|default:"名称"}:</label>
        <div class="col-sm-9">
          {webcontrol type='btplanpopup' value=$item.value itemName=$item.name|default:$key}
        </div>
    </div>
</div>