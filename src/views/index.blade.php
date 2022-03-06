@extends ('backend.layouts.app')

@section ('title', trans('api-generator::labels.apis.management'))


@section('content')
 <div class="p-3">
    <div class="col-md-12 bg-white py-3 px-2 shadow-lg bordertop-5 ">
        <div class="row text-dark">
            <div class="col-md-6"><b>Active Apis</b></div>
            <div class="col-md-6"> @include('api-generator::partials.apis-header-buttons') </div>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                {{ Session::get('success') }}
                @php
                Session::forget('success');
                @endphp
            </div>
        @endif

         <div class="table-parent py-4">
            <div class="table-responsive data-table-wrapper">
                <table id="Apis_table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('api-generator::labels.apis.table.name') }}</th>
                            <th>{{ trans('api-generator::labels.apis.table.url') }}</th>
                            <th>{{ trans('api-generator::labels.apis.table.controller_path') }}</th>
                            <th>{{ trans('api-generator::labels.apis.table.created_by') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div>
    </div>
@endsection

@section('bottom-scripts')

<script type="text/javascript">
   $(document).ready(function() {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
         $('#Apis_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.apis.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'name', name: 'apis.name'},
                    {data: 'url', name: 'apis.url'},
                    {data: 'controller_path', name: 'apis.controller_path'},
                    {data: 'created_by', name: 'users.name'}
                ],
                order: [[0, "asc"]],
                searchDelay: 500
         });


});
</script>
@endsection
