@if(request()->is('admin/apis*'))
 {{-- action header button --}}
<div class="btn-group float-right">
<div class="dropdown">
    <button type="button" class="btn border mx-2 dropdown-toggle" data-toggle="dropdown">
    Action
    </button>
    <div class="dropdown-menu">
       <a href="{{route('admin.apis.index')}}" class="dropdown-item"><i class="fa fa-list-ul"></i> {{ trans('api-generator::menus.apis.all') }}</a>
       <a href="{{route('admin.apis.create')}}" class="dropdown-item"><i class="fa fa-plus"></i> {{ trans('api-generator::menus.apis.create') }}</a>
  </div>
    </div>
</div>

@endif

