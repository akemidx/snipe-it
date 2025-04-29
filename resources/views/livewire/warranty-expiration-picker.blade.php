<div>
    {{--
    we need the warranty expiration date
    when a model is picked, we grab that expiration date by:
        expiration months on model, calculate from purchase date = wan exp date


    @if ($asset->purchase_date)
            {{ Helper::getFormattedDateObject($asset->present()->warranty_expires(), 'date', false) }}
            -
            {{ Carbon::parse($asset->present()->warranty_expires())->diffForHumans(['parts' => 2]) }}
        @else
            {{ trans('general.na_no_purchase_date') }}
        @endif


        id 8 = 36 months
        id 1 = 24 months --}}
    <p>warranty_months: {{ $warranty_months }}</p>
</div>

@script
    <script>
        $('#model_select_id')
            .on('select2:select', function (event) {
                //$wire.$set('warranty_months', event.params.data.id)
                $wire.$call('setWarrantyMonthsFromModel', event.params.data.id)
                console.log(event.params.data.id)
            });
    </script>
@endscript
