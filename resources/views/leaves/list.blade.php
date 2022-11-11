@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row m-0">
                                <div class="col-sm-9 mb-3">
                                    <h4 class="header-title mb-0">Employees</h4>
                                </div>
                                <div class="col-sm-3">
                                    <div class="float-right">
                                        <a href="{{ @$addNewLink }}">
                                            <div class="btn btn-info btn-sm mb-2"><span class="fa fa-plus"></span>
                                                &nbsp;&nbsp;Add New</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="basic-datatable" class="table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Leave Type</th>
                                            <th>Leaave Count</th>
                                            <th>Status</th>
                                            @can('review leave requests')
                                                <th>Employee Name</th>
                                                <th>Action</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script>
        $(document).ready(function() {
            table = $('#basic-datatable').DataTable({
                responsive: true,
                autoWidth: true,
                pagingType: "full_numbers",
                lengthChange: true,
                lengthMenu: [
                    [500, 1000, 2000, 5000, 8000],
                    [500, 1000, 2000, 5000, 8000]
                ],
                fixedHeader: {
                    header: true,
                    footer: true
                },
                type: 'POST',
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ], // Default sort is by primary key,
                ajax: {
                    url: "{{ @$fetchDataLink }}",
                    type: 'POST',
                    data: function(data) {
                        data._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        'data': 'DT_RowId',
                        'name': 'id',
                        "visible": false
                    }, // As primary key no need to visible in this table, it has been hidden.
                    {
                        'data': 'leave_type',
                        'name': 'leave_type'
                    },
                    {
                        'data': 'leave_count',
                        'name': 'leave_count'
                    },
                    {
                        'data': 'status',
                        'name': 'status'
                    }
                    @can('review leave requests')
                        , {
                            'data': 'employee_name',
                            'name': 'employee_name'
                        }, {
                            mRender: function(data, type, row, meta) {
                                if (row.status == 'PENDING') {
                                    return '<button class="btn btn-success confirm-input" data-postdata=\'{"_token": "{{ csrf_token() }}", "approval_status": "APPROVED", "action_id" : "' +
                                        row.DT_RowId +
                                        '" }\' data-url="{{ url('/review-leaves') }}">Approve</button>' +
                                        ' <button class="btn btn-danger confirm-input" data-postdata=\'{"_token": "{{ csrf_token() }}", "approval_status": "REJECTED", "action_id" : "' +
                                        row.DT_RowId +
                                        '"}\' data-url="{{ url('/review-leaves') }}">Reject</button>';
                                } else {
                                    return '-';
                                }
                                // return approve_link(row.DT_RowId, row.status) + reject_link(row
                                //     .DT_RowId, row.status);
                            }
                        }
                    @endcan
                ]
            });
        });

        function approve_link(editId, status) {


        }

        function reject_link(editId, status) {
            if (status == 'PENDING') {
                return ' <button class="btn btn-danger confirm-input" data-postdata=\'{"_token": "{{ csrf_token() }}", "approval_status": "APPROVED", "action_id" : "' +
                    editId + '"}\' data-url="{{ url('/review-leaves') }}">Reject</button>';
            } else {
                return '-';
            }
        }
        $(document).ready(function() {
            $('#basic-datatable').on('click', '.confirm-input', function(e) {
                e.preventDefault();
                var elem = $(this);
                var url = elem.data('url');
                var inputId = elem.data('inputid');
                var postData = elem.data('postdata');
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: $.param(postData),
                    success: function(response) {
                        notification_handler(response.notify);
                        elem.prop('disabled', true);
                    }
                });
            });
        });
    </script>
@endsection
