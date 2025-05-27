<div>
{{--
    we need the warranty expiration date
    when a model is picked, we grab that expiration date by:
        expiration months on model, calculate from purchase date = wan exp date
        purchase date on asset -> asset id, purchase date
        expiration on model -> model id, warranty months
        purchase date + expiration months = wan exp date

        we do have warranty_expires() as a function on the Asset Presenter


    @if ($asset->purchase_date)
            {{ Helper::getFormattedDateObject($asset->present()->warranty_expires(), 'date', false) }}
            -
            {{ Carbon::parse($asset->present()->warranty_expires())->diffForHumans(['parts' => 2]) }}
        @else
            {{ trans('general.na_no_purchase_date') }}
        @endif


        id 8 = 36 months
        id 1 = 24 months --}}
<div class="form-group {{ $errors->has('warranty') ? ' has-error' : '' }}">
    <label for="warranty_expires_at" class="col-md-3 control-label">{{ trans('admin/hardware/form.warranty_expires') }}</label>
            <div class="input-group col-md-4">
                <div class="input-group date" id="warranty_expires_at" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
{{--                     value="{{ old('$warranty_expires_at', $item->warranty_expires_at) }}">
                        so using this...it says $item doesn't exist, but we use this exact syntax on other partials that are doing the same here.--}}
                    <input class="form-control" type="text" placeholder="{{ trans('general.select_date') }}" name="warranty_expires_at" id="warranty_expires_at" style="background-color:inherit"  maxlength="20"
                         value="{{ old('warranty_expires_at', '') }}"/>
                    <span class="input-group-addon"><x-icon type="calendar" /></span>
                </div>
            </div>
                <div class="col-md-8 col-md-offset-3">
                <p class="help-block">{{ trans('admin/hardware/general.warranty_expiration_notice') }}</p>
                    {!! $errors->first('warranty_expires_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>
            </div>



    {{--        if the user selects warranty months instead, we should clear on the next edit page load, or at _Least_ have the updated expiratin date--}}

    <p>warranty_months: {{ $warranty_months }}</p>
    <p>purchase_date: {{ $purchase_date }}</p>
    <p>warranty_date: {{ $warranty_expires_at }}</p>

</div>


@script
    <script>
        $(document).ready(function(){

        $('#model_select_id')
            .on('select2:select', function (event) {
                $wire.$call('setWarrantyMonthsFromModel', event.params.data.id)
                console.log(event.params.data.id)
            });

            $('#purchase_date_wrapper').datepicker({
                clearBtn: true,
                todayHighlight: true,
                endDate: '0d',
                format: 'yyyy-mm-dd',
            }).on('changeDate', function (event) {
                console.log(event)
                console.log(event.date)
                console.log(event.format(0))
                $wire.$call('setPurchaseDate',event.format(0))

                $(this).datepicker('hide');
            });

            $('#warranty_expiration_wrapper').datepicker({
                clearBtn: true,
                todayHighlight: true,
                endDate: '0d',
                format: 'yyyy-mm-dd',
            }).on('changeDate', function (event) {
                console.log(event)
                console.log(event.date)
                console.log(event.format(0))
                $wire.$set('warranty_expires_at', event.format(0))

                {{--We're updating the warranty_expires_at, but changing the purchase date will change the warranty expire again--}}

                $(this).datepicker('hide');
            });

            // $('#purchase_date_wrapper').datepicker('setDate', new Date(2024, 8, 02));
            // ❓ update?
            // $('#purchase_date_wrapper').datepicker('update', new Date(2024, 8, 02));

        });
    </script>
@endscript
