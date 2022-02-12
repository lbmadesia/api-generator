@if(request()->is('admin/apis*'))
 {{-- action header button --}}
<div class="btn-group float-right">
<div class="dropdown">
    <button type="button" class="btn border mx-2 dropdown-toggle" data-toggle="dropdown">
    Action
    </button>
    <div class="dropdown-menu">
       <a href="{{route('admin.apis.index')}}" class="dropdown-item"><i class="fa fa-list-ul"></i> {{trans('menus.backend.apis.all')}}</a>
       <a href="{{route('admin.apis.create')}}" class="dropdown-item"><i class="fa fa-plus"></i> {{trans('menus.backend.apis.create')}}</a>
  </div>
    </div>
</div>
{{-- export header button --}}
<div class="btn-group float-right">
    <div class="dropdown">
    <button type="button" class="btn border mx-2 dropdown-toggle" data-toggle="dropdown">
        Export
    </button>
    <div class="dropdown-menu">
        <a id="copyButton" href="#" class="dropdown-item"><i class="fa fa-clone"></i> Copy</a>
        <a id="csvButton" href="#" class="dropdown-item"><i class="fa fa-file-text-o"></i> CSV</a>
        <a id="excelButton" href="#" class="dropdown-item"><i class="fa fa-file-excel-o"></i> Excel</a>
        <a id="pdfButton" href="#" class="dropdown-item"><i class="fa fa-file-pdf-o"></i> PDF</a>
        <a id="printButton" href="#" class="dropdown-item"><i class="fa fa-print"></i> Print</a>

    </div>
    </div>
</div>

@endif

