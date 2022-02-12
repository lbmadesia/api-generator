@extends ('backend.layouts.app')

@section ('title')
 Apis Management
@endsection


@section('content')
 <div class="p-3">
    <div class="col-md-12 bg-white py-3 px-2 shadow-lg bordertop-5 ">
        <div class="row text-dark">
            <div class="col-md-6"><b>Active Apis</b></div>
            <div class="col-md-6"> @include('generator::partials.Apis-header-buttons') </div>
        </div>

         <div class="table-parent py-4">
            <div class="table-responsive data-table-wrapper">
                <table id="Apis_table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('generator::labels.Apis.table.name') }}</th>
                            <th>{{ trans('generator::labels.Apis.table.url') }}</th>
                            <th>{{ trans('generator::labels.Apis.table.created_by') }}</th>
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
                    url: '{{ route("admin.Apis.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'name', name: 'Apis.name'},
                    {data: 'url', name: 'Apis.url'},
                    {data: 'created_by', name: 'users.name'}
                ],
                order: [[0, "asc"]],
                searchDelay: 500
         });


});
</script>
@endsection
