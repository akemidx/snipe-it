<!-- Warranty Expires-->
<div class="form-group {{ $errors->has('warranty') ? ' has-error' : '' }}">
    <label for="warranty_expires_at" class="col-md-3 control-label">{{ trans('admin/hardware/form.warranty_expires') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                <input class="form-control" type="text" name="warranty_expires_at" id="warranty_expires_at"
                       value="{{ $item->warranty_expires_at }}"/>
                <span class="input-group-addon"><x-icon type="calendar" /></span>
            </div>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('warranty_expires_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>