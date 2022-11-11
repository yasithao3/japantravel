@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">{{ @$actionHeading }}</h4>
                        </div>
                        <div class="card-body">
                            <form class="form-label-left input_mask text-form" action="javascript:;" id=""
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Leave Type</label>
                                            <hr class="mt-1 mb-2">
                                            <select name="leave_type" id="leave_type" class="form-control">
                                                <option value="">Please select</option>
                                                @if (!empty($leaveTypes))
                                                    @foreach ($leaveTypes as $type)
                                                        <option
                                                            {{ @$model->leave_type == $type->id ? 'selected="selected"' : '' }}
                                                            value="{{ $type->id }}">{{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Leave Count <span class="text-danger">*</span></label>
                                            <hr class="mt-1 mb-2">
                                            <input type="text" class="form-control" type="number" name="leave_count"
                                                value="{{ @$model->leave_count }}" placeholder="Leave Count "
                                                id="leave_count">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> <span class="text-danger"></span></label>
                                            <hr class="mt-1 mb-2">
                                            <input type="hidden" name="action_id" value="{{ @$model->id }}">
                                            @if ($formMode == 'edit')
                                                <button class="text-form-submit btn btn-success pull-right float-right"
                                                    data-url="{{ $updateUrl }}">Update</button>
                                            @elseif($formMode == 'create')
                                                <button class="text-form-submit btn btn-success pull-right float-right"
                                                    data-url="{{ $saveUrl }}">Save</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div><!-- end col-->
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script>
        $(document).ready(function() {
            $('.text-form .text-form-submit').on('click', function(e) {
                e.preventDefault();
                var elem = $(this);
                var url = elem.data('url');
                var postData = elem.closest('form').serializeArray();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url,
                    data: $.param(postData),
                    success: function(response) {
                        notification_handler(response.notify)
                    }
                });
            });
        });
    </script>
@endsection
