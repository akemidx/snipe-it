<!-- Warranty Expires-->
<div class="form-group {{ $errors->has('warranty') ? ' has-error' : '' }}">
    <label for="warranty_months" class="col-md-3 control-label">{{ trans('admin/hardware/form.warranty_expires') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <input class="form-control" type="text" name="warranty_expires" id="warranty_expires"
                   value="{{ $item->present()->warranty_expires() < date("Y-m-d")}}"/>
            <span class="input-group-addon" style="width: 30%"> {{-- //this currently moves weird when width of window changes, needs lock on button size?--}}
                {{ trans('admin/hardware/form.warranty_expires') }}
            </span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('warranty_months', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>