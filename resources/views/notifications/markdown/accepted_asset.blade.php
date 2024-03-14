@component('mail::message')
# {{ trans('mail.hello') }},

{{ $intro_text }}.

@component('mail::table')
|        |          |
| ------------- | ------------- |
| **{{ trans('mail.user') }}** | {{ $assigned_to }} |
@if (isset($accepted_date))
| **{{ ucfirst(trans('general.accepted')) }}** | {{ $accepted_date }} |
@endif
@if ((isset($item_tag)) && ($item_tag!=''))
| **{{ trans('mail.asset_tag') }}** | {{ $item_tag }} |
@endif
@if ((isset($item_model)) && ($item_model!=''))
| **{{ trans('mail.asset_name') }}** | {{ $item_model }} |
@endif
@if (isset($item->model))
| **{{ trans('general.asset_model') }}** | {{ $item->model->name }} |
@endif
@if (isset($item_serial))
| **{{ trans('mail.serial') }}** | {{ $item_serial }} |
@endif
@endcomponent

{{ trans('mail.best_regards') }}

{{ $snipeSettings->site_name }}

@endcomponent

{{-- adding an attachment for the pdf. docs say a method would be used, but i don't see any other place we do that? --}}