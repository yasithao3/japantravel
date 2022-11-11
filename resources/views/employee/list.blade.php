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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Manager Name</th>
                                            <th>Action</th>
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
                        'data': 'employee_name',
                        'name': 'employee_name'
                    },
                    {
                        'data': 'email',
                        'name': 'email'
                    },
                    {
                        'data': 'manager_name',
                        'name': 'manager_name'
                    },
                    {
                        mRender: function(data, type, row, meta) {
                            return edit_link(row.DT_RowId);
                        }
                    }
                ]
            });
        });

        function edit_link(editId) {
            return "<a class='' target='_blank' href='{{ $editLink }}/" + editId +
                "' data-toggle='tooltip' data-placement='bottom' title='Edit'> Edit </a> ";
        }
    </script>
@endsection
