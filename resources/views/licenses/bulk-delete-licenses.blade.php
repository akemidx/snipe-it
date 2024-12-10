@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/hardware/form.bulk_delete') }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <p>{{ trans('admin/hardware/form.bulk_delete_help') }}</p>
    <form class="form-horizontal" method="post" action="{{ route('license/bulkdelete') }}" autocomplete="off" role="form">
      {{csrf_field()}}
      <div class="box box-default">
        <div class="box-header with-border">
          <h2 class="box-title" style="color: red">{{ trans('admin/hardware/form.bulk_delete_warn', ['asset_count' => count($licenses)]) }}</h2>
        </div>

        <div class="box-body">
          <table class="table table-striped table-condensed">
            <thead>
              <tr>
                <th></th>
                <th>{{ trans('admin/license/table.id') }}</th>
                <th>{{ trans('admin/license/table.title') }}</th>
                <th>{{ trans('admin/license/table.seats')}}</th>
                <th>{{ trans('admin/license/table.purchase_date') }}</th>
                <th>{{ trans('admin/license/table.license_email') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($licenses as $license)
              <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $license->id }}" checked="checked"></td>
                <td>{{ $license->id }}</td>
                <td>{{ $license->present()->name() }}</td>
                <td>{{ $license->seats->count() }}</td>
                <td>{{ $license->purchase_date }}</td>
                <td>{{ $license->license_email }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- /.box-body -->

        <div class="box-footer text-right">
          <a class="btn btn-link" href="{{ URL::previous() }}">
            {{ trans('button.cancel') }}
          </a>
          <button type="submit" class="btn btn-success" id="submit-button">
            <x-icon type="checkmark" /> {{ trans('button.delete') }}
{{--            We will need to prevent a delete if licenses are still checked out--}}

          </button>
        </div><!-- /.box-footer -->
      </div><!-- /.box -->
    </form>
  </div> <!-- .col-md-12-->
</div><!--.row-->
@stop
