@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/licenses/general.software_licenses') }}
@parent
@stop


@section('header_right')
@can('create', \App\Models\License::class)
    <a href="{{ route('licenses.create') }}" accesskey="n" class="btn btn-primary pull-right">
      {{ trans('general.create') }}
    </a>
    @endcan
@can('view', \App\Models\License::class)
    <a class="btn btn-default pull-right" href="{{ route('licenses.export') }}" style="margin-right: 5px;">{{ trans('general.export') }}</a>
@endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">

          <table
              data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}"
              data-cookie-id-table="licensesTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-fullscreen="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="licensesTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.licenses.index') }}"
              data-export-options='{
            "fileName": "export-licenses-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
            }'>
          </table>

      </div><!-- /.box-body -->

      <div class="box-footer clearfix">
      </div>
    </div><!-- /.box -->
  </div>
    @can('checkin', \App\Models\License::class)
        @include ('modals.confirm-action',
              [
                  'modal_name' => 'checkinFromAllModal',
                  'route' => route('licenses.bulkcheckin', $license->id),
                  'title' => trans('general.modal_confirm_generic'),
                  'body' => trans_choice('admin/licenses/general.bulk.checkin_all.modal', 2, ['checkedout_seats_count' => $checkedout_seats_count])
              ])
    @endcan
    @can('delete', $license)

        @if ($license->availCount()->count() == $license->seats)
            <button class="btn btn-block btn-danger btn-sm btn-social delete-license" data-toggle="modal" data-title="{{ trans('general.delete') }}" data-content="{{ trans('general.delete_confirm', ['item' => $license->name]) }}" data-target="#dataConfirmModal">
                <x-icon type="delete" />
                {{ trans('general.delete') }}
            </button>
        @else
            <span data-tooltip="true" title=" {{ trans('admin/licenses/general.delete_disabled') }}">
            <a href="#" class="btn btn-block btn-danger btn-sm btn-social delete-license disabled">
              <x-icon type="delete" />
              {{ trans('general.delete') }}
            </a>
          </span>
        @endif
    @endcan
</div><!-- /.row -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop
