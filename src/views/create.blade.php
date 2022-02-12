
@extends ('backend.layouts.app')

@section ('title')
User Management
@endsection

@section('page-header')
<div class="w-100 d-flex justify-content-between align-items-center pt-3 px-3" style="border-bottom:2px solid #ccc;">
    <p><b class="lbindectionName text-dark">  {{ trans('generator::labels.apis.management') }}</b> / {{ trans('generator::labels.apis.create') }}</p>
    <p></p>
 </div>
@endsection

@section('content')
<div class=" p-3">
    <div class="col-md-12 bg-white py-3 px-2 shadow-lg bordertop-5 ">
    {{ Form::open(['route' => 'admin.apis.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-module', 'files' => true]) }}

        <div class="box box-success">

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("generator::form")
                    <div class="edit-form-btn">
                        <div class="row ">
                            <div class="col-12 text-center">
                                {{ link_to_route('admin.apis.index', trans('generator::buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                                {{ Form::submit(trans('generator::buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                            </div>
                        </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
       </div>
    </div>
@endsection
