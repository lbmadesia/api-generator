@extends ('backend.layouts.app')

@section ('title', trans('generator::labels.Apis.management') . ' | ' . trans('generator::labels.Apis.edit'))

@section('page-header')
    <h1>
        {{ trans('generator::labels.Apis.management') }}
        <small>{{ trans('generator::labels.Apis.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($api, ['route' => ['admin.Apis.update', $api], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-module', 'files' => true]) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('generator::labels.Apis.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('generator::partials.Apis-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("backend.Apis.form")
                    <div class="edit-form-btn">
                        <div class="row ">
                            <div class="col-12 text-center">

                                {{ link_to_route('admin.Apis.index', trans('generator::buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                {{ Form::submit(trans('generator::buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                            </div>
                        </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
@endsection
