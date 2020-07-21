<div class="card-body table-responsive-lg table-responsive-sm table-responsive-md">
    <table class="table table-striped table-bordered" id="orders-table" width="100%">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Status</th>
            <th class="text-center">Items</th>
            <th class="text-center">Tax</th>
            <th class="text-center">Shipping</th>
            <th class="text-center">Amount</th>
            <th>Updated At</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th><input class="form-control filter" value=""></th>
            <th><input class="form-control filter" value=""></th>
            <th>
                <select class="custom-select custom-select-sm form-control form-control-sm filter">
                    <option value=""></option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->code }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </tfoot>
    </table>
</div>
@section('footer_scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/buttons.bootstrap4.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap4.css') }}"/>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap4.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: "{{ route('admin.shop.orders.data') }}",
                columns: [
                    {data: 'id', width: '60px', name: 'id'},
                    {data: 'user_id'},
                    {data: 'statusCode', width: '110px'},
                    {data: 'items', orderable: false, searchable: false, 'class': 'text-center'},
                    {data: 'tax', orderable: false, searchable: false, 'class': 'text-right'},
                    {data: 'shipping', orderable: false, searchable: false, 'class': 'text-right'},
                    {data: 'amount', orderable: false, searchable: false, 'class': 'text-right'},
                    {data: 'updated_at'},
                    {data: 'created_at'},
                    {data: 'actions', width: '42px', orderable: false, searchable: false}
                ],
                order: [[0, 'desc']],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        $(column.footer()).find('input').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search(val ? val : '', true, false).draw();
                        });
                        $(column.footer()).find('select').on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    });
                }
            }).on('draw.dt', function (e, settings, data) {
                $(this).find('.livicon').updateLivicon();
            });
            $('#orders-table').on('page.dt', function () {
                setTimeout(function () {
                    $('.livicon').updateLivicon();
                }, 500);
            });
            $('#orders-table').on('length.dt', function (e, settings, len) {
                setTimeout(function () {
                    $('.livicon').updateLivicon();
                }, 500);
            });
        });
    </script>
@stop