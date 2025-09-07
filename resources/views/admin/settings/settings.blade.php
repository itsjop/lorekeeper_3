@extends('admin.layout', ['componentName' => 'admin/settings/settings'])

@section('admin-title')
  Site Settings
@endsection

@section('admin-content')
  {!! breadcrumbs(['Admin Panel' => 'admin', 'Site Settings' => 'admin/settings']) !!}

  <h1> Site Settings </h1>

  <p> This is a list of settings that can be quickly modified to alter the site behaviour. Please make sure that the values
    correspond to the possible options as stated in the descriptions! Incorrect values can cause the site to stop working.
    Additional
    settings can be found in the code config files. </p>

  @if (!count($settings))
    <p> No settings found. </p>
  @else
    {!! $settings->render() !!}
    <div class="mb-4 logs-table setting-table">
      <div class="logs-table-header">
        <div class="row">
          <div class="col-5 col-md-5">
            <div class="logs-table-cell font-weight-bold"> Key </div>
          </div>
          <div class="col-4 col-md-4">
            <div class="logs-table-cell font-weight-bold"> Description </div>
          </div>
          <div class="col-md-3 ">
            <div class="logs-table-cell font-weight-bold"> Value </div>
          </div>
        </div>
        <hr>
      </div>
      <div class="logs-table-body">
        @foreach ($settings as $setting)
          <div class="logs-table-row">
            <div class="row flex-wrap">
              <div class="col-6 col-md-4">
                <div class="logs-table-cell"> {{ $setting->key }} </div>
              </div>
              <div class="col-6 col-md-5">
                <div class="logs-table-cell log-description"> {{ $setting->description }} </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="logs-table-cell">
                  {!! Form::open(['url' => 'admin/settings/' . $setting->key, 'class' => 'd-flex justify-content-end']) !!}
                  <div class="form-group mr-3 mb-3">
                    {!! Form::text('value', $setting->value, ['class' => 'form-control']) !!}
                  </div>
                  <div class="form-group mb-3">
                    {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

    </div>
    {!! $settings->render() !!}
  @endif
@endsection
<style>
  .log-description {
    white-space: pre-line;
  }
</style>
