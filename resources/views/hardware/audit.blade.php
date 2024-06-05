@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.audit') }}
    @parent
@stop

{{-- Page content --}}
@section('content')

    <style>

        .input-group {
            padding-left: 0px !important;
        }
    </style>

    <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">

                {{ Form::open([
                  'method' => 'POST',
                  'route' => ['asset.audit.store', $asset->id],
                  'files' => true,
                  'class' => 'form-horizontal' ]) }}

                    <div class="box-header with-border">
                        <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h2>
                    </div>
                    <div class="box-body">
                    {{csrf_field()}}

                        <!-- Asset model -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                {{ Form::label('name', trans('admin/hardware/form.model'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-8">
                                    <p class="form-control-static">
                                        @if (($asset->model) && ($asset->model->name))
                                            {{ $asset->model->name }}
                                        @else
                                            <span class="text-danger text-bold">
                                              <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                                              {{ trans('admin/hardware/general.model_invalid')}}
                                            </span>
                                            {{ trans('admin/hardware/general.model_invalid_fix')}}
                                            <a href="{{ route('hardware.edit', $asset->id) }}">
                                                <strong>{{ trans('admin/hardware/general.edit') }}</strong>
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>


                    <!-- Asset Name -->
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ Form::label('name', trans('admin/hardware/form.name'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <p class="form-control-static">{{ $asset->name }}</p>
                            </div>
                        </div>

                        <!-- Locations -->
                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

                    <!-- Update location -->
                        <div class="form-group">

                            <div class="col-md-8 col-md-offset-3">
                                <label class="form-control">
                                    <input type="checkbox" value="1" name="update_location" {{ Request::old('update_location') == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/hardware/form.asset_location') }}
                                </label>
                                <p class="help-block">{!! trans('help.audit_help') !!}</p>
                            </div>

                        </div>

                        <!-- Custom fields -->
                        @can('assets.edit')
                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9 col-sm-9 col-md-offset-3">
                                    <a id="optional_info" class="dropdown-toggle">
                                        <i class="fa fa-2x fa-caret-right" id="optional_info_icon"></i>
                                        <strong>{{ trans('admin/custom_fields/general.custom_fields') }}</strong>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <ul class="treeview-menu" style="display: none; padding-top: 10px;" id="optional_details">
                                        <li>
                                            @include("models/custom_fields_form",["model" => $asset->model])
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endcan

                        <!-- Show last audit date -->
                        <div class="form-group">
                            <label class="control-label col-md-3">
                                {{ trans('general.last_audit') }}
                            </label>
                            <div class="col-md-8">

                                <p class="form-control-static">
                                    @if ($asset->last_audit_date)
                                        {{ Helper::getFormattedDateObject($asset->last_audit_date, 'datetime', false) }}
                                    @else
                                        {{ trans('admin/settings/general.none') }}
                                    @endif
                                </p>
                            </div>
                        </div>


                        <!-- Next Audit -->
                        <div class="form-group{{ $errors->has('next_audit_date') ? ' has-error' : '' }}">
                            {{ Form::label('name', trans('general.next_audit_date'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-clear-btn="true">
                                    <input type="text" class="form-control" placeholder="{{ trans('general.next_audit_date') }}" name="next_audit_date" id="next_audit_date" value="{{ old('next_audit_date', $next_audit_date) }}">
                                    <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                {!! $errors->first('next_audit_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                 <p class="help-block">{!! trans('general.next_audit_date_help') !!}</p>
                            </div>
                        </div>


                        <!-- Note -->
                        <div class="form-group{{ $errors->has('note') ? ' has-error' : '' }}">
                            {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $asset->note) }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Audit Image -->
                        @include ('partials.forms.edit.image-upload', ['help_text' => trans('general.audit_images_help')])


                    </div> <!--/.box-body-->
                    <div class="box-footer">
                        <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success pull-right{{ (!$asset->model ? ' disabled' : '') }}"{!! (!$asset->model ? ' data-tooltip="true" title="'.trans('admin/hardware/general.model_invalid_fix').'" disabled' : '') !!}>
                            <i class="fas fa-check icon-white" aria-hidden="true"></i>
                            {{ trans('general.audit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div> <!--/.col-md-7-->
    </div>
@stop

@section('moar_scripts')

    <script>
        $(document).ready(function() {
            $("#optional_info").on("click", function () {
                $('#optional_details').fadeToggle(100);
                $('#optional_info_icon').toggleClass('fa-caret-right fa-caret-down');
                var optional_info_open = $('#optional_info_icon').hasClass('fa-caret-down');
                document.cookie = "optional_info_open=" + optional_info_open + '; path=/';
            });
            var all_cookies = document.cookie.split(';')
            for (var i in all_cookies) {
                var trimmed_cookie = all_cookies[i].trim(' ')
                if (trimmed_cookie.startsWith('optional_info_open=')) {
                    elems = all_cookies[i].split('=', 2)
                    if (elems[1] == 'true') {
                        $('#optional_info').trigger('click')
                    }
                }
            }
        });
    </script>
@stop
